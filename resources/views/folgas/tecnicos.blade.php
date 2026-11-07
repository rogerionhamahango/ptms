@extends('layouts.ptms')

@section('title', 'Folgas dos Técnicos')

@section('content_header')
    <h1>
        <i class="fas fa-calendar-alt text-danger"></i>
        Gestão de Folgas dos Técnicos
    </h1>
@stop

@section('content')

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="fas fa-check-circle"></i>
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert"
                    aria-label="Fechar">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Não foi possível concluir a operação.</strong>
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $erro)
                    <li>{{ $erro }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- 1. Seleccionar técnico e data para consultar a escala --}}
    <div class="card card-danger">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-search"></i>
                Consultar compromissos
            </h3>
        </div>

        <form method="GET" action="{{ route('folgas.tecnicos') }}">
            <div class="card-body">
                <div class="form-group">
                    <label for="funcionario_id">Técnico</label>
                    <select name="funcionario_id" id="funcionario_id"
                            class="form-control" required>
                        <option value="">Seleccione um técnico</option>
                        @foreach ($tecnicos as $tecnico)
                            <option value="{{ $tecnico->id }}"
                                @selected(request('funcionario_id') == $tecnico->id)>
                                {{ $tecnico->name }} {{ $tecnico->surname }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="data">Data da folga</label>
                    <input type="date" name="data" id="data"
                           class="form-control"
                           value="{{ request('data', now()->format('Y-m-d')) }}"
                           required>
                </div>
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-search"></i>
                    Consultar compromissos
                </button>
            </div>
        </form>
    </div>

    {{-- 2. Mostrar os compromissos e recolher os substitutos --}}
    @if ($tecnicoSelecionado && $dataSelecionada)
        <div class="card card-danger mt-3">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-calendar-check"></i>
                    Registar folga
                </h3>
            </div>

            <form method="POST" action="{{ route('folgas.storeTecnico') }}">
                @csrf

                <input type="hidden" name="funcionario_id"
                       value="{{ $tecnicoSelecionado->id }}">
                <input type="hidden" name="data"
                       value="{{ $dataSelecionada }}">

                <div class="card-body">
                    <p>
                        <strong>Técnico:</strong>
                        {{ $tecnicoSelecionado->name }}
                        {{ $tecnicoSelecionado->surname }}
                    </p>

                    <p>
                        <strong>Data:</strong>
                        {{ \Illuminate\Support\Carbon::parse($dataSelecionada)->format('d/m/Y') }}
                    </p>

                    @if ($compromissos->isEmpty())
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i>
                            Não existem compromissos para este técnico nesta
                            data. Pode registar a folga sem substitutos.
                        </div>
                    @else
                        <div class="alert alert-warning">
                            Indique um substituto para cada compromisso.
                        </div>

                        @foreach ($compromissos as $compromisso)
                            <div class="border rounded p-3 mb-3">
                                <p>
                                    <strong>Turno:</strong>
                                    {{ $compromisso->turno }}
                                </p>

                                <label for="substituto_{{ $compromisso->id }}">
                                    Técnico substituto
                                </label>

                                <select
                                    name="substituicoes[{{ $compromisso->id }}]"
                                    id="substituto_{{ $compromisso->id }}"
                                    class="form-control"
                                    required>
                                    <option value="">Seleccione um substituto</option>

                                    @forelse ($substitutosPorEscala[$compromisso->id] ?? [] as $substituto)
                                        <option value="{{ $substituto->id }}"
                                            @selected(
                                                old('substituicoes.'.$compromisso->id)
                                                == $substituto->id
                                            )>
                                            {{ $substituto->name }}
                                            {{ $substituto->surname }}
                                        </option>
                                    @empty
                                        <option value="" disabled>
                                            Não existem substitutos disponíveis
                                        </option>
                                    @endforelse
                                </select>

                                @if (count($substitutosPorEscala[$compromisso->id] ?? []) === 0)
                                    <small class="text-danger">
                                        Não há técnicos disponíveis para este turno.
                                        Verifique a escala antes de continuar.
                                    </small>
                                @endif
                            </div>
                        @endforeach
                    @endif

                    <div class="form-group">
                        <label for="motivo">Motivo ou observação</label>
                        <textarea name="motivo" id="motivo"
                                  class="form-control" rows="3"
                                  maxlength="1000"
                                  placeholder="Motivo da folga (opcional)">{{ old('motivo') }}</textarea>
                    </div>
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-danger"
                        @disabled(
                            $compromissos->isNotEmpty()
                            && $compromissos->contains(
                                fn ($compromisso) =>
                                    count($substitutosPorEscala[$compromisso->id] ?? []) === 0
                            )
                        )
                        onclick="return confirm('Confirma o registo da folga e das substituições?')">
                        <i class="fas fa-save"></i>
                        Autorizar e registar folga
                    </button>
                </div>
            </form>
        </div>
    @endif

@stop
