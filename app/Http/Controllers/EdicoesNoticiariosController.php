<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Horario;
use App\Models\Jornalist;
use App\Models\Edicoes;

class EdicoesNoticiariosController extends Controller
{
    public function edicoes(){
        $horarios = Horario::all();
        $jornalistas=Jornalist::all();

        return view('escala.edicoes', compact('horarios', 'jornalistas'));
    }


    public function store_edicao(Request $request){
        $validate = $request->validate([
        'jornalista_id' => 'required|exists:jornalists,id',
        'horarios_id'   => 'required|exists:horarios,id',
        'data'          => 'required|date',
    ]);

    // =====================================================
    // 1. Verificar duplicação
    // Mesmo jornalista + mesma data + mesmo horário
    // =====================================================

    $jaExiste = Edicoes::where('jornalista_id', $validate['jornalista_id'])
        ->whereDate('data', $validate['data'])
        ->where('horarios_id', $validate['horarios_id'])
        ->exists();

    if ($jaExiste) {
        return redirect()->back()
            ->withInput()
            ->with(
                'error',
                'Este jornalista já está escalado para esta data e horário!'
            );
    }

    // =====================================================
    // 2. Determinar início e fim da semana
    // =====================================================

    $data = \Carbon\Carbon::parse($validate['data']);

    $startWeek = $data->copy()->startOfWeek();
    $endWeek   = $data->copy()->endOfWeek();

    // =====================================================
    // 3. Contar edições do jornalista na semana
    // =====================================================

    $num_edicoes = Edicoes::where(
            'jornalista_id',
            $validate['jornalista_id']
        )
        ->whereBetween('data', [
            $startWeek->toDateString(),
            $endWeek->toDateString()
        ])
        ->select('data')
        ->distinct()
        ->count('data');

    // =====================================================
    // 4. Limite de 5 edições por semana
    // =====================================================

    if ($num_edicoes >= 5) {
        return redirect()->back()
            ->withInput()
            ->with(
                'error',
                'Este jornalista já atingiu o limite de 5 edições por semana!'
            );
    }

    // =====================================================
    // 5. Registar edição
    // =====================================================

    Edicoes::create($validate);

    return redirect()->back()
        ->with('success', 'Edição registada com sucesso!');


}
}