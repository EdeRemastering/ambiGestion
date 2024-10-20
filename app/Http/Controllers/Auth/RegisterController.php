<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Personas;
use App\Models\Roles;
use App\Models\Grupo_sanguineo;
use App\Models\Contratos;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = '/home';  // Ajusta esta ruta según tus necesidades

    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function validator(array $data)
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'documento' => ['required', 'string', 'unique:personas'],
            'pnombre' => ['required', 'string', 'max:255'],
            'snombre' => ['nullable', 'string', 'max:255'],
            'papellido' => ['required', 'string', 'max:255'],
            'sapellido' => ['nullable', 'string', 'max:255'],
            'telefono' => ['required', 'string'],
            'direccion' => ['required', 'string'],
            'tipo_sangre_id' => ['required', 'exists:grupo_sanguineos,id'],
            'rol_id' => ['required', 'exists:roles,id'],
        ];

        // Si el rol no es aprendiz, requiere tipo_contrato_id
        if ($data['rol_id'] != Roles::where('name', 'aprendiz')->first()->id) {
            $rules['tipo_contrato_id'] = ['required', 'exists:contratos,id'];
        }

        return Validator::make($data, $rules);
    }


    protected function create(array $data)
    {
        return DB::transaction(function () use ($data) {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'role_id' => $data['rol_id'],
            ]);

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
                'user_id' => $user->id,
            ];

            // Si el rol no es aprendiz, añade tipo_contrato_id
            if ($data['rol_id'] != Roles::where('name', 'aprendiz')->first()->id) {
                $personaData['tipo_contrato_id'] = $data['tipo_contrato_id'];
            } else {
                // Si es aprendiz, asigna un valor por defecto o null
                $personaData['tipo_contrato_id'] = null; // o un valor por defecto si es necesario
            }

            Personas::create($personaData);

            return $user;
        });
    }


    public function showRegistrationForm()
    {
        $roles = Roles::whereIn('name', ['aprendiz', 'instructor'])->select('id', 'name', 'descripcion')->get();
        $gruposSanguineos = Grupo_sanguineo::select('id', 'descripcion')->get();
        $tiposContratos = Contratos::select('id', 'descripcion')->get();
        return view('auth.register', compact('roles', 'gruposSanguineos', 'tiposContratos'));
    }
}