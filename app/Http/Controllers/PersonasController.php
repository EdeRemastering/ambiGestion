<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use App\Models\Personas;
use App\Models\Roles;
use App\Models\Grupo_sanguineo;
use App\Models\Contratos;
use App\Models\RedConocimiento;
use App\Models\Ficha;
use App\Models\User;

class PersonasController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $query = Personas::with(['user.role', 'grupoSanguineo', 'tipoContrato']);
    
        if (Auth::user()->role->name !== 'admin') {
            $query->where('user_id', Auth::id());
        }
    
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('documento', 'like', "%{$searchTerm}%")
                  ->orWhere('pnombre', 'like', "%{$searchTerm}%")
                  ->orWhere('papellido', 'like', "%{$searchTerm}%")
                  ->orWhere('correo', 'like', "%{$searchTerm}%");
            });
        }
    
        $personas = $query->get();
    
        return view('personas.index', compact('personas'));
    }

    public function create()
    {
        $roles = Roles::all();
        $gruposSanguineos = Grupo_sanguineo::all();
        $tiposContratos = Contratos::all();
        $fichas = Ficha::all();
        return view('personas.create', compact('roles', 'gruposSanguineos', 'tiposContratos', 'fichas'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'documento' => 'required|unique:personas',
            'pnombre' => 'required',
            'snombre' => 'nullable',
            'papellido' => 'required',
            'sapellido' => 'nullable',
            'telefono' => 'required',
            'correo' => 'required|email|unique:users,email',
            'direccion' => 'required',
            'tipo_sangre_id' => 'required|exists:grupo_sanguineos,id',
            'rol_id' => 'required|exists:roles,id',
            'password' => 'required|min:8|confirmed',
        ]);

        if ($validatedData['rol_id'] == Roles::where('name', 'aprendiz')->first()->id) {
            $validatedData['codigo_ficha'] = $request->validate(['codigo_ficha' => 'required|exists:fichas,codigo_ficha'])['codigo_ficha'];
        } else {
            $validatedData['tipo_contrato_id'] = $request->validate(['tipo_contrato_id' => 'required|exists:contratos,id'])['tipo_contrato_id'];
        }

        DB::transaction(function () use ($validatedData) {
            $user = User::create([
                'name' => $validatedData['pnombre'] . ' ' . $validatedData['papellido'],
                'email' => $validatedData['correo'],
                'password' => Hash::make($validatedData['password']),
                'role_id' => $validatedData['rol_id'],
            ]);

            Personas::create([
                'documento' => $validatedData['documento'],
                'pnombre' => $validatedData['pnombre'],
                'snombre' => $validatedData['snombre'],
                'papellido' => $validatedData['papellido'],
                'sapellido' => $validatedData['sapellido'],
                'telefono' => $validatedData['telefono'],
                'correo' => $validatedData['correo'],
                'direccion' => $validatedData['direccion'],
                'tipo_sangre_id' => $validatedData['tipo_sangre_id'],
                'tipo_contrato_id' => $validatedData['tipo_contrato_id'] ?? null,
                'codigo_ficha' => $validatedData['codigo_ficha'] ?? null,
                'user_id' => $user->id,
            ]);
        });

        return redirect()->route('personas.index')->with('success', 'Perfil creado con éxito');
    }

    public function show(Personas $persona)
    {
        return view('personas.show', compact('persona'));
    }

    public function edit(Personas $persona)
{
    $user = Auth::user();
    if ($user->role->name !== 'admin' && $user->id !== $persona->user_id) {
        abort(403, 'No tienes permiso para editar este perfil.');
    }

    $roles = Roles::select('id', 'name', 'descripcion')->get();
    $gruposSanguineos = Grupo_sanguineo::select('id', 'descripcion')->get();
    $tiposContratos = Contratos::select('id', 'descripcion')->get();
    
    // Modificación en la consulta de fichas
    $fichas = Ficha::selectRaw('JSON_OBJECT("codigo_ficha", codigo_ficha) as ficha_data')
        ->get()
        ->map(function ($ficha) {
            return json_decode($ficha->ficha_data);
        });

    $redesConocimiento = RedConocimiento::select('id', 'nombre')->get();

    $canChangeRole = $user->role->name === 'admin';
    $isAprendiz = $persona->user->role->name === 'aprendiz';

    return view('personas.edit', compact(
        'persona', 
        'roles', 
        'gruposSanguineos',
        'tiposContratos', 
        'canChangeRole', 
        'isAprendiz', 
        'fichas', 
        'redesConocimiento'
    ));
}

    public function update(Request $request, Personas $persona)
    {
        $user = Auth::user();
        if ($user->role->name !== 'admin' && $user->id !== $persona->user_id) {
            abort(403, 'No tienes permiso para actualizar este perfil.');
        }
    
        $rules = [
            'documento' => 'required|unique:personas,documento,'.$persona->id,
            'pnombre' => 'required',
            'snombre' => 'nullable',
            'papellido' => 'required',
            'sapellido' => 'nullable',
            'telefono' => 'required',
            'correo' => 'required|email|unique:users,email,'.$persona->user_id,
            'direccion' => 'required',
            'tipo_sangre_id' => 'required|exists:grupo_sanguineos,id',
        ];
    
        // Reglas específicas según el rol
        if ($persona->user->role->name === 'aprendiz') {
            $rules['codigo_ficha'] = 'required|exists:fichas,codigo_ficha';
        } else {
            $rules['tipo_contrato_id'] = 'required|exists:contratos,id';
        }
    
        // Si es instructor, validar redes de conocimiento
        if ($persona->user->role->name === 'instructor') {
            $rules['redes_conocimiento'] = 'required|array';
            $rules['redes_conocimiento.*'] = 'exists:red_conocimientos,id';
        }
    
        // Reglas para administradores
        if ($user->role->name === 'admin') {
            $rules['rol_id'] = 'sometimes|required|exists:roles,id';
        }
    
        // Reglas para cambio de contraseña
        if ($request->has('change_password') && $request->change_password == 'on') {
            $rules['current_password'] = 'required';
            $rules['password'] = 'required|min:8|confirmed';
        }
    
        $validatedData = $request->validate($rules);
    
        try {
            DB::transaction(function () use ($validatedData, $persona, $user, $request) {
                // Actualizar datos básicos de la persona
                $persona->update($validatedData);
    
                // Actualizar rol si es admin
                if ($user->role->name === 'admin' && isset($validatedData['rol_id'])) {
                    $persona->user->update(['role_id' => $validatedData['rol_id']]);
                }
    
                // Actualizar contraseña si se solicita
                if ($request->has('change_password') && $request->change_password == 'on') {
                    if (!Hash::check($request->current_password, $persona->user->password)) {
                        throw new \Exception('La contraseña actual es incorrecta.');
                    }
                    $persona->user->update(['password' => Hash::make($request->password)]);
                }
    
                // Actualizar nombre de usuario
                $persona->user->update(['name' => $validatedData['pnombre'] . ' ' . $validatedData['papellido']]);
    
                // Actualizar redes de conocimiento si es instructor
                if ($persona->user->role->name === 'instructor' && isset($validatedData['redes_conocimiento'])) {
                    $persona->redesConocimiento()->sync($validatedData['redes_conocimiento']);
                }
            });
    
            return redirect()->route('personas.index')
                ->with('success', 'Perfil actualizado exitosamente');
        } catch (\Exception $e) {
            Log::error('Error al actualizar persona: ' . $e->getMessage());
            return back()
                ->withErrors(['error' => $e->getMessage()])
                ->withInput();
        }
    }

    public function destroy(Personas $persona)
    {
        $user = Auth::user();
        if ($user->role->name !== 'admin') {
            abort(403, 'No tienes permiso para eliminar perfiles.');
        }

        try {
            DB::transaction(function () use ($persona) {
                $persona->user->delete();
                $persona->delete();
            });
            return redirect()->route('personas.index')->with('success', 'Persona eliminada exitosamente.');
        } catch (\Exception $e) {
            Log::error('Error al eliminar persona: ' . $e->getMessage());
            return back()->with('error', 'Ocurrió un error al eliminar el perfil. Por favor, intenta de nuevo.');
        }
    }

    
    public function settings()
    {
        $user = Auth::user();
    
        // Obtener la persona asociada al usuario autenticado usando Eloquent
        $persona = Personas::with('user')->where('user_id', $user->id)->first();
    
        // Verifica si la persona existe
        if (!$persona) {
            return back()->withErrors(['error' => 'No se encontró la persona asociada.'])->withInput();
        }
    
        // Obtener roles, grupos sanguíneos y contratos si se necesitan en la vista
        $roles = Roles::select('id', 'name', 'descripcion')->get();
        $gruposSanguineos = Grupo_sanguineo::select('id', 'descripcion')->get();
        $tiposContratos = Contratos::select('id', 'descripcion')->get();
    
        $canChangeRole = $user->role->name === 'admin';
        $isAprendiz = $persona->user->role->name === 'aprendiz';
    
        return view('personas.settings', compact('persona', 'roles', 'gruposSanguineos', 'tiposContratos', 'canChangeRole', 'isAprendiz'));
    }
    



    public function updateSettings(Request $request)
    {
        $user = Auth::user();
        $persona = Personas::where('user_id', $user->id)->first();
    
        if (!$persona) {
            return back()->withErrors(['error' => 'No se encontró la persona asociada.'])->withInput();
        }
    
        $rules = [
            'documento' => 'required',
            'pnombre' => 'required',
            'snombre' => 'nullable',
            'papellido' => 'required',
            'sapellido' => 'nullable',
            'telefono' => 'required',
            'correo' => 'required|email',
            'direccion' => 'required',
            'tipo_sangre_id' => 'required|exists:grupo_sanguineos,id',
            'password' => 'nullable|min:6',
        ];
    
        if ($persona->user->role->name !== 'aprendiz') {
            $rules['tipo_contrato_id'] = 'required|exists:contratos,id';
        }
    
        $validatedData = $request->validate($rules);
    
        try {
            DB::beginTransaction();
    
            // Actualizar usando joins
            DB::table('personas')
                ->join('users', 'personas.user_id', '=', 'users.id')
                ->where('users.id', $user->id)
                ->update([
                    'personas.documento' => $validatedData['documento'],
                    'personas.pnombre' => $validatedData['pnombre'],
                    'personas.snombre' => $validatedData['snombre'],
                    'personas.papellido' => $validatedData['papellido'],
                    'personas.sapellido' => $validatedData['sapellido'],
                    'personas.telefono' => $validatedData['telefono'],
                    'personas.correo' => $validatedData['correo'],
                    'personas.direccion' => $validatedData['direccion'],
                    'personas.tipo_sangre_id' => $validatedData['tipo_sangre_id'],
                    'personas.tipo_contrato_id' => $validatedData['tipo_contrato_id'] ?? null,
                    'users.email' => $validatedData['correo'],
                    'users.password' => $request->filled('password') ? Hash::make($request->password) : $user->password,
                ]);
    
            DB::commit();
            return redirect()->route('dashboard')->with('success', 'Perfil actualizado exitosamente');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al actualizar configuración: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Ocurrió un error al actualizar. Inténtalo nuevamente.'])->withInput();
        }
    }

}