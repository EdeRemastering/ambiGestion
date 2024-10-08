<?php

namespace App\Http\Controllers;

use App\Models\Personas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Roles;
use App\Models\Grupo_sanguineo;
use App\Models\Contratos;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Persona;

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
    protected function create(array $data)
{
    $user = User::create([
        'name' => $data['name'],
        'email' => $data['email'],
        'password' => Hash::make($data['password']),
    ]);

    $persona = Personas::create([
        'documento' => $data['documento'],
        'pnombre' => $data['pnombre'],
        'snombre' => $data['snombre'],
        'papellido' => $data['papellido'],
        'sapellido' => $data['sapellido'],
        'telefono' => $data['telefono'],
        'correo' => $data['email'],
        'direccion' => $data['direccion'],
        'tipo_sangre_id' => $data['tipo_sangre_id'],
        'tipo_contrato_id' => $data['tipo_contrato_id'],
        'user_id' => $user->id,
    ]);

    return $user;
}

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'documento' => 'required',
            'pnombre' => 'required',
            'snombre' => 'nullable',
            'papellido' => 'required',
            'sapellido' => 'nullable',
            'telefono' => 'required',
            'correo' => 'required|email',
            'direccion' => 'required',
            'tipo_sangre_id' => 'required|exists:grupo_sanguineos,id',
            'tipo_contrato_id' => 'required|exists:contratos,id',
        ]);

        $validatedData['user_id'] = Auth::id();

        try {
            Personas::create($validatedData);
            return redirect()->route('personas.index')->with('success', 'Perfil completado con éxito');
        } catch (\Exception $e) {
            Log::error('Error al crear persona: ' . $e->getMessage());
            return back()->with('error', 'Ocurrió un error al crear el perfil. Por favor, intenta de nuevo.');
        }
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
    
    $canChangeRole = $user->role->name === 'admin';
    $isAprendiz = $persona->user->role->name === 'aprendiz';
    
    return view('personas.edit', compact('persona', 'roles', 'gruposSanguineos', 'tiposContratos', 'canChangeRole', 'isAprendiz'));
}
public function update(Request $request, Personas $persona)
{
    $user = Auth::user();
    if ($user->role->name !== 'admin' && $user->id !== $persona->user_id) {
        abort(403, 'No tienes permiso para actualizar este perfil.');
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
    ];

    if ($persona->user->role->name !== 'aprendiz') {
        $rules['tipo_contrato_id'] = 'required|exists:contratos,id';
    }

    if ($user->role->name === 'admin') {
        $rules['rol_id'] = 'sometimes|required|exists:roles,id';
    }

    $validatedData = $request->validate($rules);

    try {
        DB::beginTransaction();

        $persona->update($validatedData);

        if ($user->role->name === 'admin' && isset($validatedData['rol_id'])) {
            $persona->user->update(['role_id' => $validatedData['rol_id']]);
        }

        DB::commit();
        return redirect()->route('personas.index')->with('success', 'Perfil actualizado exitosamente');
    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('Error al actualizar persona: ' . $e->getMessage());
        return back()->withErrors(['error' => $e->getMessage()])->withInput();
    }
}
    public function destroy(Personas $persona)
    {
        $user = Auth::user();
        if ($user->role->name !== 'admin') {
            abort(403, 'No tienes permiso para eliminar perfiles.');
        }

        try {
            $persona->delete();
            return redirect()->route('personas.index')->with('success', 'Persona eliminada exitosamente.');
        } catch (\Exception $e) {
            Log::error('Error al eliminar persona: ' . $e->getMessage());
            return back()->with('error', 'Ocurrió un error al eliminar el perfil. Por favor, intenta de nuevo.');
        }
    }
}