<?php

namespace App\Http\Controllers;

use App\Models\Caballo;
use Illuminate\Http\Request;

class CaballoController extends Controller
{
  
    public function index()
    {
        $caballos = Caballo::all();
        //le mando todos los caballos a la vista
        return view('caballos.index', compact('caballos')); 
    }

    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        //
    }

   
    public function show(string $id)
    {
        //
    }

   
    public function edit(string $id)
    {
        //
    }

  
    public function update(Request $request, string $id)
    {
        //
    }

 
    public function destroy(string $id)
    {
        //
    }
}
