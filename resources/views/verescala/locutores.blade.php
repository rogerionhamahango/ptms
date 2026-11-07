@extends('layouts.ptms')

@section('content')

<div class="container-fluid">

{{-- CABEÇALHO --}}
<div class="d-flex justify-content-between align-items-center mb-3">

    <div>
        <h3 class="mb-0">
            <i class="fas fa-microphone"></i>
            Escala de Emissões
        </h3>

        <small class="text-muted">
            {{ $startWeek->translatedFormat('d \d\e F') }}
            a
            {{ $endWeek->translatedFormat('d \d\e F \d\e Y') }}
        </small>
    </div>

    <div>

        {{-- SEMANA ANTERIOR --}}
        <a href="{{ route('locutores', [
            'data' => $startWeek->copy()->subWeek()->format('Y-m-d')
        ]) }}"
        class="btn btn-secondary">

            <i class="fas fa-chevron-left"></i>
            Semana anterior

        </a>

        {{-- HOJE --}}
        <a href="{{ route('locutores') }}"
           class="btn btn-primary">

            <i class="fas fa-calendar-day"></i>
            Hoje

        </a>

        {{-- PRÓXIMA SEMANA --}}
        <a href="{{ route('locutores', [
            'data' => $startWeek->copy()->addWeek()->format('Y-m-d')
        ]) }}"
        class="btn btn-secondary">

            Próxima semana
            <i class="fas fa-chevron-right"></i>

        </a>

    </div>

</div>


{{-- ESCALA --}}
<div class="card">

    <div class="card-header">
        <h3 class="card-title">
            Escala semanal de Emissões
        </h3>
    </div>

    <div class="card-body p-0">

        <div class="table-responsive">

            <table class="table table-bordered table-hover mb-0">

                {{-- DIAS DA SEMANA --}}
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


                {{-- ESCALAS --}}
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
                                         * Verificar se o locutor já possui
                                         * uma falta registada para esta
                                         * data e turno.
                                         */
                                        $falta = $faltas->first(function ($falta) use ($escala) {

                                            return $falta->funcionario_id == $escala->jornalist_id
                                                && $falta->data->format('Y-m-d') ==
                                                   \Carbon\Carbon::parse($escala->data)->format('Y-m-d')
                                                && $falta->turno == $escala->turno;

                                        });

                                    @endphp


                                    <div class="card mb-2 shadow-sm">

                                        <div class="card-body p-2 bg-green text-white">

                                            {{-- TURNO --}}
                                            <div class="font-weight-bold">

                                                {{ $escala->turno ?? '--:--' }}

                                            </div>


                                            {{-- LOCUTOR --}}
                                            <div>

                                                {{ trim(
                                                    ($escala->jornalist->name ?? '') .
                                                    ' ' .
                                                    ($escala->jornalist->surname ?? '')
                                                ) ?: 'Sem locutor' }}

                                            </div>


                                            {{-- ESTADO DA FALTA --}}
                                            @if($falta)

                                                <div class="mt-2">

                                                    <span class="badge badge-danger">

                                                        <i class="fas fa-user-times"></i>

                                                        FALTOU

                                                    </span>

                                                </div>

                                            @else

                                                {{-- MARCAR FALTA --}}
                                                <div class="mt-2">

                                                    <form action="{{ route('faltas.marcarLocutor') }}"
                                                          method="POST">

                                                        @csrf

                                                        <input type="hidden"
                                                               name="jornalist_id"
                                                               value="{{ $escala->jornalist_id }}">

                                                        <input type="hidden"
                                                               name="data"
                                                               value="{{ \Carbon\Carbon::parse($escala->data)->format('Y-m-d') }}">

                                                        <input type="hidden"
                                                               name="turno"
                                                               value="{{ $escala->turno }}">

                                                        <button type="submit"
                                                                class="btn btn-sm btn-danger"
                                                                onclick="return confirm('Confirmar falta deste locutor?')">

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

                                        Sem emissão

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