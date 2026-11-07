<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Technicians;
use App\Models\EscalaTecnica;

class TechniciansController extends Controller
{
    public function technicians(){
        return view('pages.technicians');
    }


    public function store(Request $request){
        $validate = $request -> validate([
            'name'=>'required|string|max:50',
            'surname'=>'required|string|max:50',
            'gender'=>'required|string|max:10',
            'nuit'=>'required|string|max:10',
            'admin_date'=>'required|date',
            'category'=>'required|string|max:240',
            'allocation'=>'required|string',
            'telephone'=>'required|string'
        ]);

        $nuit = $request -> nuit;
        $technic = Technicians::where('nuit', $nuit)->first();
       

        if($technic){
            return redirect()->back()->with('error', 'Este NUIT ja foi registado! ');
        }

        Technicians::create($validate);
        return redirect()->back()->with('success', 'Tecnico registado com sucesso! ');

    }

    public function tecnicos_lista(){
        $tecnicos = Technicians::all();
        return view('ptms.tecnicos_lista', compact('tecnicos'));
    }
#function to call escala view


public function escala_tecnica()
{
    $tecnicos = Technicians::orderBy('name')->get();

    return view('escala.escala', compact('tecnicos'));
}

public function store_escala(Request $request){
    $validate = $request->validate([
        'technician_id'=>'required',
        'data'=>'required|date',
        'turno'=>'required|string|max:15'
    ]);

    EscalaTecnica::create($validate);
     return redirect()
        ->back()
        ->with('success', 'Escala registada com sucesso!');
}



}
