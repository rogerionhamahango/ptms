<?php

namespace App\Http\Controllers;

use App\Models\Falta;
use App\Models\EscalaTecnica;
use App\Models\EscalaLocutores;
use App\Models\Edicoes;
use App\Models\Technicians;
use App\Models\Jornalist;
use App\Models\Horario;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FaltaController extends Controller
{
    // =========================================================
    // MARCAR FALTA DE TÉCNICO
    // =========================================================
    public function marcarTecnico(Request $request)
    {
        $request->validate([
            'technician_id' => 'required|integer|exists:technicians,id',
            'data' => 'required|date',
            'turno' => 'required|string|max:15',
            'motivo' => 'nullable|string|max:1000',
        ], [
            'technician_id.required' => 'O técnico é obrigatório.',
            'technician_id.exists' => 'O técnico selecionado não existe.',

            'data.required' => 'A data é obrigatória.',
            'data.date' => 'A data selecionada é inválida.',

            'turno.required' => 'O turno é obrigatório.',
            'turno.max' => 'O turno não pode ultrapassar 15 caracteres.',

            'motivo.max' => 'O motivo não pode ultrapassar 1000 caracteres.',
        ]);

        // =====================================================
        // VERIFICAR SE O TÉCNICO ESTÁ ESCALADO
        // =====================================================

        $escala = EscalaTecnica::where(
                'technician_id',
                $request->technician_id
            )
            ->whereDate('data', $request->data)
            ->where('turno', $request->turno)
            ->first();

        if (!$escala) {
            return back()
                ->withInput()
                ->with(
                    'error',
                    'Este técnico não está escalado para a data e turno selecionados.'
                );
        }

        // =====================================================
        // VERIFICAR SE A FALTA JÁ EXISTE
        // =====================================================

        $faltaExiste = Falta::where(
                'funcionario_id',
                $request->technician_id
            )
            ->where(
                'funcionario_type',
                Technicians::class
            )
            ->whereDate('data', $request->data)
            ->where('turno', $request->turno)
            ->exists();

        if ($faltaExiste) {
            return back()
                ->withInput()
                ->with(
                    'error',
                    'A falta deste técnico já foi registada para este dia e turno.'
                );
        }

        // =====================================================
        // REGISTAR FALTA
        // =====================================================

        Falta::create([
            'funcionario_id' => $request->technician_id,
            'funcionario_type' => Technicians::class,
            'data' => $request->data,
            'turno' => $request->turno,
            'motivo' => $request->motivo,
            'marcado_por' => Auth::id(),
        ]);

        return back()->with(
            'success',
            'Falta do técnico registada com sucesso.'
        );
    }


    // =========================================================
    // MARCAR FALTA DE LOCUTOR
    // =========================================================
    public function marcarLocutor(Request $request)
    {
        $request->validate([
            'jornalist_id' => 'required|integer|exists:jornalists,id',
            'data' => 'required|date',
            'turno' => 'required|string|max:15',
            'motivo' => 'nullable|string|max:1000',
        ], [
            'jornalist_id.required' => 'O locutor é obrigatório.',
            'jornalist_id.exists' => 'O locutor selecionado não existe.',

            'data.required' => 'A data é obrigatória.',
            'data.date' => 'A data selecionada é inválida.',

            'turno.required' => 'O turno é obrigatório.',
            'turno.max' => 'O turno não pode ultrapassar 15 caracteres.',

            'motivo.max' => 'O motivo não pode ultrapassar 1000 caracteres.',
        ]);

        // =====================================================
        // VERIFICAR SE O LOCUTOR ESTÁ ESCALADO
        // =====================================================

        $escala = EscalaLocutores::where(
                'jornalist_id',
                $request->jornalist_id
            )
            ->whereDate('data', $request->data)
            ->where('turno', $request->turno)
            ->first();

        if (!$escala) {
            return back()
                ->withInput()
                ->with(
                    'error',
                    'Este locutor não está escalado para a data e turno selecionados.'
                );
        }

        // =====================================================
        // VERIFICAR SE A FALTA JÁ EXISTE
        // =====================================================

        $faltaExiste = Falta::where(
                'funcionario_id',
                $request->jornalist_id
            )
            ->where(
                'funcionario_type',
                Jornalist::class
            )
            ->whereDate('data', $request->data)
            ->where('turno', $request->turno)
            ->exists();

        if ($faltaExiste) {
            return back()
                ->withInput()
                ->with(
                    'error',
                    'A falta deste locutor já foi registada para este dia e turno.'
                );
        }

        // =====================================================
        // REGISTAR FALTA
        // =====================================================

        Falta::create([
            'funcionario_id' => $request->jornalist_id,
            'funcionario_type' => Jornalist::class,
            'data' => $request->data,
            'turno' => $request->turno,
            'motivo' => $request->motivo,
            'marcado_por' => Auth::id(),
        ]);

        return back()->with(
            'success',
            'Falta do locutor registada com sucesso.'
        );
    }


    // =========================================================
    // MARCAR FALTA DE EDITOR / JORNALISTA
    // =========================================================
    public function marcarEditor(Request $request)
    {
        $request->validate([
            'jornalista_id' => 'required|integer|exists:jornalists,id',
            'horarios_id' => 'required|integer|exists:horarios,id',
            'data' => 'required|date',
            'motivo' => 'nullable|string|max:1000',
        ], [
            'jornalista_id.required' => 'O jornalista é obrigatório.',
            'jornalista_id.exists' => 'O jornalista selecionado não existe.',

            'horarios_id.required' => 'O horário é obrigatório.',
            'horarios_id.exists' => 'O horário selecionado não existe.',

            'data.required' => 'A data é obrigatória.',
            'data.date' => 'A data selecionada é inválida.',

            'motivo.max' => 'O motivo não pode ultrapassar 1000 caracteres.',
        ]);

        // =====================================================
        // BUSCAR O HORÁRIO
        // =====================================================

        $horario = Horario::find($request->horarios_id);

        if (!$horario) {
            return back()
                ->withInput()
                ->with(
                    'error',
                    'O horário selecionado não existe.'
                );
        }

        // =====================================================
        // HORÁRIO GUARDADO COMO "TURNO"
        // =====================================================

        $turno = $horario->horas;

        // =====================================================
        // VERIFICAR SE O JORNALISTA ESTÁ ESCALADO
        // =====================================================

        $escala = Edicoes::where(
                'jornalista_id',
                $request->jornalista_id
            )
            ->where(
                'horarios_id',
                $request->horarios_id
            )
            ->whereDate('data', $request->data)
            ->first();

        if (!$escala) {
            return back()
                ->withInput()
                ->with(
                    'error',
                    'Este jornalista não está escalado para esta edição, data e horário.'
                );
        }

        // =====================================================
        // VERIFICAR SE A FALTA JÁ EXISTE
        // =====================================================

        $faltaExiste = Falta::where(
                'funcionario_id',
                $request->jornalista_id
            )
            ->where(
                'funcionario_type',
                Jornalist::class
            )
            ->whereDate('data', $request->data)
            ->where('turno', $turno)
            ->exists();

        if ($faltaExiste) {
            return back()
                ->withInput()
                ->with(
                    'error',
                    'A falta deste jornalista já foi registada para esta edição.'
                );
        }

        // =====================================================
        // REGISTAR FALTA
        // =====================================================

        Falta::create([
            'funcionario_id' => $request->jornalista_id,
            'funcionario_type' => Jornalist::class,
            'data' => $request->data,
            'turno' => $turno,
            'motivo' => $request->motivo,
            'marcado_por' => Auth::id(),
        ]);

        return back()->with(
            'success',
            'Falta do jornalista registada com sucesso.'
        );
    }
}