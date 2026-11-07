
@extends('layouts.ptms')

@section('title', 'Visualização de Folgas')

@section('content_header')
    <h1>
        <i class="fas fa-calendar-alt"></i>
        Visualização de Folgas
    </h1>
@stop

@section('content')

    @php
        $nomeSector = [
            'tecnico' => 'Técnico',
            'locutor', 'locutor' => 'Produção',
        ];

        $nomeFuncionario = function ($funcionario) {
            if (!$funcionario) {
                return 'Funcionário não encontrado';
            }

            return trim(
                ($funcionario->name ?? '') . ' ' .
                ($funcionario->surname ?? '')
            ) ?: 'Nome não disponível';
        };
    @endphp

    <div class="card card-danger">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-filter"></i>
                Filtrar folgas
            </h3>
        </div>

        <form method="GET" action="{{ route('folgas.index') }}">
            <div class="card-body">
                <div class="row">

                    @if ($sectorDoChefe === 'todos')
                        <div class="col-md-4">
                            <label for="sector">Sector</label>
                            <select name="sector" id="sector"
                                    class="form-control">
                                <option value="">Todos os sectores</option>
                                <option value="tecnico"
                                    @selected($sector === 'tecnico')>
                                    Técnico
                                </option>
                              
                                <option value="editor"
                                    @selected($sector === 'editor')>
                                    Produção
                                </option>
                            </select>
                        </div>
                    @else
                        <input type="hidden" name="sector"
                               value="{{ $sectorDoChefe }}">
                        <div class="col-md-4">
                            <label>Sector</label>
                            <input class="form-control"
                                   value="{{ $nomeSector[$sectorDoChefe] }}"
                                   disabled>
                        </div>
                    @endif

                    <div class="col-md-3">
                        <label for="data_inicio">Data inicial</label>
                        <input type="date" name="data_inicio"
                               id="data_inicio" class="form-control"
                               value="{{ $dados['data_inicio'] ?? '' }}">
                    </div>

                    <div class="col-md-3">
                        <label for="data_fim">Data final</label>
                        <input type="date" name="data_fim"
                               id="data_fim" class="form-control"
                               value="{{ $dados['data_fim'] ?? '' }}">
                    </div>

                    <div class="col-md-2 d-flex align-items-end mt-3">
                        <button type="submit"
                                class="btn btn-danger mr-2">
                            <i class="fas fa-search"></i> Filtrar
                        </button>

                        <a href="{{ route('folgas.index') }}"
                           class="btn btn-secondary"
                           title="Limpar filtros">
                            <i class="fas fa-sync-alt"></i>
                        </a>
                    </div>

                </div>
            </div>
        </form>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $erro)
                    <li>{{ $erro }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                Folgas registadas
            </h3>

            <div class="card-tools">
                <span class="badge badge-danger">
                    {{ $folgas->total() }} registo(s)
                </span>
            </div>
        </div>

        <div class="card-body table-responsive p-0">
            <table class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th>Data</th>
                        <th>Funcionário</th>
                        <th>Sector</th>
                        <th>Motivo</th>
                        <th>Substitutos</th>
                        <th>Autorizado por</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($folgas as $folga)
                        @php
                            $sectorLinha = match ($folga->sector) {
                                'tecnico' => 'Técnico',
                                'locutor', 'editor' => 'Produção',
                               
                                default => 'Sector não identificado',
                            };
                        @endphp
                        <tr>
                            <td>
                                {{ $folga->data->format('d/m/Y') }}
                            </td>

                            <td>
                                <strong>
                                    {{ $nomeFuncionario($folga->funcionario) }}
                                </strong>
                            </td>

                            <td>{{ $sectorLinha }}</td>

                            <td>
                                {{ $folga->motivo ?: 'Sem motivo indicado' }}
                            </td>

                            <td>
                                @forelse ($folga->substituicoes as $substituicao)
                                    <div class="mb-1">
                                        <i class="fas fa-user-check text-success"></i>
                                        {{ $nomeFuncionario($substituicao->substituto) }}
                                    </div>
                                @empty
                                    <span class="text-muted">
                                        Sem substituição registada
                                    </span>
                                @endforelse
                            </td>

                            <td>
                                {{ $folga->autorizadoPor?->full_name
                                    ?? 'Não identificado' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center p-4">
                                <i class="fas fa-calendar-times fa-2x text-muted"></i>
                                <p class="mt-2 mb-0">
                                    Não existem folgas para os filtros seleccionados.
                                </p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($folgas->hasPages())
            <div class="card-footer">
                {{ $folgas->links() }}
            </div>
        @endif
    </div>

@stop
