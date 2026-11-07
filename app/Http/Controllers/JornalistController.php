<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jornalist;
use App\Models\EscalaLocutores;

class JornalistController extends Controller
{
    public function jornalist(){
        return view('pages.jornalist');
        
    }

    public function store(Request $request){
        $validate = $request->validate([
            'name'=>'required|string|max:255',
            'surname'=>'required|string|max:30',
            'gender'=>'required|string|max:12',
            'nuit'=>'required|string|max:10',
            'admin_date'=>'required|date',
            'career'=>'required|string|max:50',
            'languages'=>'required|string|max:45',
            'allocation'=>'required|string|max:35',
            'telephone'=>'required|string|max:14'

        ]);

        $nuit = $request -> nuit;
        $jornalist = jornalist::where('nuit', $nuit)->first();

        if($jornalist){
            return redirect()->back()->with('error', 'Este NUIT ja foi registado! ');
        }

        Jornalist::create($validate);

     

        return redirect()->back()->with('success', 'Registado com sucesso!');
        
    }
    #for visualization of data
    
    public function jornalista()
    {
        $jornalista = Jornalist::all();
        return view('ptms.jornalista', compact('jornalista'));
    }

    #for visualization of view for create timetable of broadcasting
    public function escala_loc(){
        $locutores = Jornalist::all();

        return view('escala.locutores', compact('locutores'));
    }

    #for insertion of broadcasting timetable

    public function store_locutores(Request $request){
        $validate = $request->validate([
            'jornalist_id'=>'required',
            'data'=>'required|date',
            'turno'=>'required|string|max:15'
        ]);
            $locutor = EscalaLocutores::where('jornalist_id', $validate['jornalist_id'])
        ->whereDate('data', $validate['data'])
        ->first();

        if ($locutor) {
        return redirect()->back()
            ->withInput()
            ->with('error', 'Este locutor já foi registado para esta data!');
        }
        $data = \Carbon\Carbon::parse($validate['data']);
        $startWeek = $data->copy()->startOfWeek();
        $endWeek = $data->copy()->endOfWeek();

        // Contar emissões da semana
        $num_emissao = EscalaLocutores::where(
            'jornalist_id',
            $validate['jornalist_id']
        )
        ->whereBetween('data', [
            $startWeek->toDateString(),
            $endWeek->toDateString()
        ])
        ->count();

        if ($num_emissao >= 4) {
        return redirect()->back()
            ->withInput()
            ->with(
                'error',
                'Este locutor já atingiu o limite de 4 emissões por semana!'
            );
    }

    // Registar emissão
    EscalaLocutores::create($validate);

    return redirect()->back()
        ->with('success', 'Emissão registada com sucesso!');
    }


    }

