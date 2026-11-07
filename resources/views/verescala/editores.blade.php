@extends('layouts.ptms')

@section('content')

<div class="container-fluid">

    {{-- =========================================================
         CABEÇALHO
         ========================================================= --}}
    <div class="d-flex justify-content-between align-items-center mb-3">

        <div>
            <h3 class="mb-0">
                <i class="fas fa-microphone"></i>
                Escala de Edicoes
            </h3>

            <small class="text-muted">
                {{ $startWeek->translatedFormat('d \d\e F') }}
                a
                {{ $endWeek->translatedFormat('d \d\e F \d\e Y') }}
            </small>
        </div>

        <div>

            {{-- Semana anterior --}}
            <a href="{{ route('editores', [
                'data' => $startWeek->copy()->subWeek()->format('Y-m-d')
            ]) }}"
            class="btn btn-secondary">

                <i class="fas fa-chevron-left"></i>
                Semana anterior

            </a>


            {{-- Semana actual --}}
            <a href="{{ route('editores') }}"
               class="btn btn-primary">

                <i class="fas fa-calendar-day"></i>
                Hoje

            </a>


            {{-- Próxima semana --}}
            <a href="{{ route('editores', [
                'data' => $startWeek->copy()->addWeek()->format('Y-m-d')
            ]) }}"
            class="btn btn-secondary">

                Próxima semana
                <i class="fas fa-chevron-right"></i>

            </a>

        </div>

    </div>


    {{-- =========================================================
         ESCALA
         ========================================================= --}}
    <div class="card">

        <div class="card-header">

            <h3 class="card-title">
                Escala semanal
            </h3>

        </div>


        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table table-bordered table-hover mb-0">

                    {{-- =================================================
                         CABEÇALHO DOS DIAS
                         ================================================= --}}
                    <thead>

                        <tr class="text-center">

                            @foreach($day as $dia)

                                <th style="min-width: 180px;">

                                    <div class="font-weight-bold text-uppercase">

                                        {{ $dia['data']->translatedFormat('l') }}

                                    </div>

                                    <div class="text-muted">

                                        {{ $dia['data']->format('d/m') }}

                                    </div>

                                </th>

                            @endforeach

                        </tr>

                    </thead>


                    {{-- =================================================
                         CONTEÚDO DA ESCALA
                         ================================================= --}}
                    <tbody>

                        <tr>

                            @foreach($day as $dia)

                                <td class="align-top">

                                    @php

                                        $escalaDoDia = $escalas->filter(function ($escala) use ($dia) {

                                            return \Carbon\Carbon::parse($escala->data)
                                                ->isSameDay($dia['data']);

                                        });

                                    @endphp


                                    @forelse($escalaDoDia as $escala)

                                        @php

                                            /*
                                             * Verificar se este jornalista
                                             * possui falta registada para
                                             * esta edição.
                                             */
                                            $falta = $faltas->first(function ($falta) use ($escala) {

                                                return $falta->funcionario_id == $escala->jornalista_id
                                                    && $falta->data->format('Y-m-d') ==
                                                       \Carbon\Carbon::parse($escala->data)->format('Y-m-d')
                                                    && $falta->turno == $escala->horario->horas;

                                            });

                                        @endphp


                                        <div class="card mb-2 shadow-sm bg-dark text-white">

                                            <div class="card-body p-2">

                                                {{-- =================================================
                                                     HORÁRIO
                                                     ================================================= --}}
                                                <div class="font-weight-bold">

                                                    <i class="far fa-clock"></i>

                                                    {{ $escala->horario->horas ?? '--:--' }}

                                                </div>


                                                {{-- =================================================
                                                     JORNALISTA
                                                     ================================================= --}}
                                                <div class="bg-warm p-1 rounded mt-1">

                                                    {{ $escala->jornalista->name ?? 'Sem jornalista' }}

                                                    {{ $escala->jornalista->surname ?? '' }}

                                                </div>


                                                {{-- =================================================
                                                     ESTADO DA FALTA
                                                     ================================================= --}}
                                                @if($falta)

                                                    <div class="mt-2">

                                                        <span class="badge badge-danger">

                                                            <i class="fas fa-user-times"></i>

                                                            FALTOU

                                                        </span>

                                                    </div>

                                                @else

                                                    {{-- =================================================
                                                         MARCAR FALTA
                                                         ================================================= --}}
                                                    <div class="mt-2">

                                                        <form action="{{ route('faltas.marcarEditor') }}"
                                                              method="POST">

                                                            @csrf

                                                            <input type="hidden"
                                                                   name="jornalista_id"
                                                                   value="{{ $escala->jornalista_id }}">

                                                            <input type="hidden"
                                                                   name="horarios_id"
                                                                   value="{{ $escala->horarios_id }}">

                                                            <input type="hidden"
                                                                   name="data"
                                                                   value="{{ \Carbon\Carbon::parse($escala->data)->format('Y-m-d') }}">

                                                            <button type="submit"
                                                                    class="btn btn-sm btn-danger"
                                                                    onclick="return confirm('Confirmar falta deste jornalista?')">

                                                                <i class="fas fa-user-times"></i>

                                                                Marcar falta

                                                            </button>

                                                        </form>

                                                    </div>

                                                @endif

                                            </div>

                                        </div>


                                    @empty

                                        <div class="text-center text-muted py-4">

                                            <i class="fas fa-calendar-times"></i>

                                            <br>

                                            Sem escala

                                        </div>

                                    @endforelse

                                </td>

                            @endforeach

                        </tr>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

@stop