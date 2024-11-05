<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Personas;
use App\Models\Roles;
use App\Models\Grupo_sanguineo;
use App\Models\Contratos;
use App\Models\Ficha; 
use App\Models\RedConocimiento;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Auth\Events\Registered;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = '/dashboard';

    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function validator(array $data)
    {
        try {
            // Verificar si el documento está autorizado
            $cedulaAutorizada = DB::table('cedulas_autorizadas')
                ->where('documento', $data['documento'])
                ->first();

            if (!$cedulaAutorizada) {
                throw new \Exception('El documento no está autorizado para registro.');
            }

            // Obtener los IDs de roles
            $rolAprendiz = Roles::where('name', 'aprendiz')->first()->id;
            $rolInstructor = Roles::where('name', 'instructor')->first()->id;

            // Verificar si el rol seleccionado coincide con el tipo de documento
            if (($cedulaAutorizada->tipo === 'aprendiz' && $data['rol_id'] != $rolAprendiz) ||
                ($cedulaAutorizada->tipo === 'instructor' && $data['rol_id'] != $rolInstructor)) {
                throw new \Exception('El rol seleccionado no corresponde con el tipo de documento.');
            }

            $rules = [
                'documento' => ['required', 'string', 'unique:personas'],
                'pnombre' => ['required', 'string', 'max:255'],
                'snombre' => ['nullable', 'string', 'max:255'],
                'papellido' => ['required', 'string', 'max:255'],
                'sapellido' => ['nullable', 'string', 'max:255'],
                'telefono' => ['required', 'string'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'direccion' => ['required', 'string'],
                'tipo_sangre_id' => ['required', 'exists:grupo_sanguineos,id'],
                'rol_id' => ['required', 'exists:roles,id'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
            ];

            // Validación condicional según el rol
            if ($data['rol_id'] == $rolAprendiz) {
                $rules['codigo_ficha'] = ['required', 'exists:fichas,codigo_ficha'];
            } else {
                $rules['tipo_contrato_id'] = ['required', 'exists:contratos,id'];
                if ($data['rol_id'] == $rolInstructor) {
                    $rules['redes_conocimiento'] = ['required', 'array'];
                    $rules['redes_conocimiento.*'] = ['exists:red_conocimientos,id'];
                }
            }

            return Validator::make($data, $rules);

        } catch (\Exception $e) {
            Log::error('Error en validación de registro: ' . $e->getMessage());
            return Validator::make([], [])->after(function ($validator) use ($e) {
                $validator->errors()->add('documento', $e->getMessage());
            });
        }
    }

    protected function create(array $data)
    {
        return DB::transaction(function () use ($data) {
            // Crear usuario
            $user = User::create([
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'role_id' => $data['rol_id']
            ]);

            // Preparar datos de persona
            $personaData = [
                'documento' => $data['documento'],
                'pnombre' => $data['pnombre'],
                'snombre' => $data['snombre'] ?? null,
                'papellido' => $data['papellido'],
                'sapellido' => $data['sapellido'] ?? null,
                'telefono' => $data['telefono'],
                'correo' => $data['email'],
                'direccion' => $data['direccion'],
                'tipo_sangre_id' => $data['tipo_sangre_id'],
                'user_id' => $user->id
            ];

            // Agregar campos específicos según el rol
            if ($data['rol_id'] == Roles::where('name', 'aprendiz')->first()->id) {
                $personaData['codigo_ficha'] = $data['codigo_ficha'];
            } else {
                $personaData['tipo_contrato_id'] = $data['tipo_contrato_id'];
            }

            // Crear persona
            $persona = Personas::create($personaData);

            // Si es instructor, asociar con redes de conocimiento
            if ($data['rol_id'] == Roles::where('name', 'instructor')->first()->id 
                && isset($data['redes_conocimiento'])) {
                $persona->redesConocimiento()->attach($data['redes_conocimiento']);
            }

            return $user;
        });
    }

    public function showRegistrationForm()
{
    $roles = Roles::whereIn('name', ['aprendiz', 'instructor'])->get();
    $gruposSanguineos = Grupo_sanguineo::get();
    $tiposContratos = Contratos::get(); // Cambiado de tiposContrato a tiposContratos
    $fichas = Ficha::get(['codigo_ficha']);
    $redesConocimiento = RedConocimiento::get();

    return view('auth.register', compact(
        'roles', 
        'gruposSanguineos',
        'tiposContratos',  // Nombre corregido
        'fichas',
        'redesConocimiento'
    ));
}

    public function register(Request $request)
    {
        try {
            $validator = $this->validator($request->all());

            if ($validator->fails()) {
                return back()
                    ->withErrors($validator)
                    ->withInput();
            }

            DB::beginTransaction();

            $user = $this->create($request->all());

            event(new Registered($user));

            $this->guard()->login($user);

            DB::commit();

            return redirect($this->redirectPath())
                ->with('success', '¡Usuario registrado exitosamente!');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error en registro: ' . $e->getMessage());

            return back()
                ->withInput()
                ->withErrors(['error' => 'Error al registrar el usuario: ' . $e->getMessage()]);
        }
    }

    public function verificarDocumento($documento)
    {
        try {
            $cedulaAutorizada = DB::table('cedulas_autorizadas')
                ->where('documento', $documento)
                ->first();

            if (!$cedulaAutorizada) {
                return response()->json([
                    'valido' => false,
                    'mensaje' => 'El documento no está autorizado para registro'
                ]);
            }

            $rolId = $cedulaAutorizada->tipo === 'aprendiz' 
                ? Roles::where('name', 'aprendiz')->first()->id
                : Roles::where('name', 'instructor')->first()->id;

            return response()->json([
                'valido' => true,
                'tipo' => $cedulaAutorizada->tipo,
                'rol_id' => $rolId
            ]);

        } catch (\Exception $e) {
            Log::error('Error verificando documento: ' . $e->getMessage());
            return response()->json([
                'valido' => false,
                'mensaje' => 'Error al verificar el documento'
            ], 500);
        }
    }
}