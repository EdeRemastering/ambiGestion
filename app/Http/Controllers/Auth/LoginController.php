<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    /**
     * Handle a successful login response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();

// Obtener el ID del usuario autenticado
$userId = Auth::id();

// Consultar los datos del usuario y concatenar el nombre completo
$userData = DB::table('users')
    ->join('personas', 'users.id', '=', 'personas.user_id')
    ->select(
        'users.*',
        DB::raw("CONCAT(personas.pnombre, ' ', personas.snombre, ' ', personas.papellido, ' ', personas.sapellido) AS nombre_completo")
    )
    ->where('users.id', $userId)
    ->first();

// Añadir el mensaje de éxito a la sesión con el nombre completo
session()->flash('success', 'Inicio de sesión exitoso. Bienvenido de nuevo, ' . $userData->nombre_completo . '!');


        $this->clearLoginAttempts($request);

        return $this->authenticated($request, $this->guard()->user())
                ?: redirect()->intended($this->redirectPath());
    }

    /**
     * Handle a failed login attempt.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        // Añadir un mensaje de error a la sesión
        return redirect()->back()
            ->withInput($request->only('email', 'remember'))
            ->with('error', 'Credenciales incorrectas. Inténtalo de nuevo.');
    }
}
