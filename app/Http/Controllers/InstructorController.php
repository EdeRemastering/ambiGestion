<?php

namespace App\Http\Controllers;

use App\Models\Personas;
use Illuminate\Http\Request;

class InstructorController extends Controller
{
    public function index()
    {
        $instructores = Personas::instructores()->get();
        return view('instructores.index', compact('instructores'));
    }

    public function show(Personas $persona)
    {
        if (!$persona->esInstructor()) {
            abort(404);
        }
        return view('instructores.show', compact('persona'));
    }

    // Otros métodos según sea necesario
}