<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Models\EscalaLocutores;
use App\Models\Edicoes;
use App\Models\Horario;
use App\Models\Jornalist;
use App\Models\Technicians;
use App\Models\EscalaTecnica;
use App\Models\Falta;

class EscalaController extends Controller
{
    // =========================================================
    // ESCALA DE EMISSÕES
    // =========================================================
    // =========================================================
// ESCALA DE EMISSÕES
// =========================================================
    public function locutores(Request $request)
    {
    $data = $request->data
        ? Carbon::parse($request->data)
        : Carbon::today();

    $startWeek = $data->copy()->startOfWeek(Carbon::MONDAY);
    $endWeek = $startWeek->copy()->addDays(6);

    $day = [];

    for ($i = 0; $i < 7; $i++) {
        $day[] = [
            'data' => $startWeek->copy()->addDays($i)
        ];
    }

    // =====================================================
    // BUSCAR ESCALAS DOS LOCUTORES
    // =====================================================

    $escalas = EscalaLocutores::with('jornalist')
        ->whereBetween('data', [
            $startWeek->format('Y-m-d'),
            $endWeek->format('Y-m-d')
        ])
        ->orderBy('data')
        ->get();

    // =====================================================
    // BUSCAR FALTAS DOS LOCUTORES DA SEMANA
    // =====================================================

    $faltas = Falta::where(
            'funcionario_type',
            Jornalist::class
        )
        ->whereBetween('data', [
            $startWeek->format('Y-m-d'),
            $endWeek->format('Y-m-d')
        ])
        ->get();

    return view('verescala.locutores', compact(
        'startWeek',
        'endWeek',
        'day',
        'escalas',
        'faltas'
    ));
}


    // =========================================================
    // ESCALA DE EDIÇÕES
    // =========================================================
    // =========================================================
    // ESCALA DE EDIÇÕES
    // =========================================================
    public function editores(Request $request)
    {
    $data = $request->data
        ? Carbon::parse($request->data)
        : Carbon::today();

    // Segunda-feira
    $startWeek = $data->copy()->startOfWeek(Carbon::MONDAY);

    // Domingo
    $endWeek = $startWeek->copy()->addDays(6);

    // Criar os 7 dias
    $day = [];

    for ($i = 0; $i < 7; $i++) {

        $day[] = [
            'data' => $startWeek->copy()->addDays($i)
        ];
    }

    // =====================================================
    // BUSCAR EDIÇÕES DA SEMANA
    // =====================================================

    $escalas = Edicoes::with([
            'jornalista',
            'horario'
        ])
        ->whereBetween('data', [
            $startWeek->format('Y-m-d'),
            $endWeek->format('Y-m-d')
        ])
        ->orderBy('data')
        ->get();

    // =====================================================
    // BUSCAR FALTAS DOS JORNALISTAS DA SEMANA
    // =====================================================

    $faltas = Falta::where(
            'funcionario_type',
            Jornalist::class
        )
        ->whereBetween('data', [
            $startWeek->format('Y-m-d'),
            $endWeek->format('Y-m-d')
        ])
        ->get();

    return view('verescala.editores', compact(
        'startWeek',
        'endWeek',
        'day',
        'escalas',
        'faltas'
    ));
    }


    // =========================================================
    // ESCALA TÉCNICA
    // =========================================================
    public function tecnicos(Request $request)
    {
        $data = $request->data
            ? Carbon::parse($request->data)
            : Carbon::today();

        // Segunda-feira
        $startWeek = $data->copy()->startOfWeek(Carbon::MONDAY);

        // Domingo
        $endWeek = $startWeek->copy()->addDays(6);

        // Criar os 7 dias
        $day = [];

        for ($i = 0; $i < 7; $i++) {

            $day[] = [
                'data' => $startWeek->copy()->addDays($i)
            ];
        }

        // Buscar escala técnica da semana
        $escalas = EscalaTecnica::with('technician')
            ->whereBetween('data', [
                $startWeek->format('Y-m-d'),
                $endWeek->format('Y-m-d')
            ])
            ->orderBy('data')
            ->get();

         // Buscar faltas dos técnicos da semana
        $faltas = Falta::where('funcionario_type', Technicians::class)
            ->whereBetween('data', [
            $startWeek->format('Y-m-d'),
            $endWeek->format('Y-m-d')
        ])
        ->get();   

        return view('verescala.tecnicos', compact(
            'startWeek',
            'endWeek',
            'day',
            'escalas',
            'faltas'
        ));
    }
}