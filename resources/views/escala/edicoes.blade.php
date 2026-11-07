@extends('layouts.ptms')

@section('content')

<div class="card">

    <div class="card-header">
        <h3 class="card-title"><b>Registar Edicoes</b></h3>

        
    </div>
    {{-- Mensagem de sucesso --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle"></i>
                {{ session('success') }}

                <button type="button" class="close" data-dismiss="alert">
                    <span>&times;</span>
                </button>
            </div>
        @endif


{{-- Mensagem de erro --}}
@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle"></i>
        {{ session('error') }}

        <button type="button" class="close" data-dismiss="alert">
            <span>&times;</span>
        </button>
    </div>
@endif

    <form action="{{ route('store_edicao') }}" method="POST">

        @csrf

        <div class="card-body">

            {{-- Mensagem de sucesso --}}
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Erros de validação --}}
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif


            {{-- Locutor --}}
            <div class="form-group">
                <label for="jornalista_id">Jornalista</label>

                <select
                    name="jornalista_id"
                    id="jornalista_id"
                    class="form-control"
                    required
                >

                    <option value="">Seleccione o Jornalista</option>

                    @foreach($jornalistas as $jornalista)

                        <option
                            value="{{ $jornalista->id }}"
                            {{ old('jornalista_id') == $jornalista->id ? 'selected' : '' }}
                        >
                            {{ $jornalista->name }} {{ $jornalista->surname }}
                        </option>

                    @endforeach

                </select>
            </div>

            <div class="form-group">
                <label for="horarios_id">Horarios</label>

                <select
                    name="horarios_id"
                    id="horarios_id"
                    class="form-control"
                    required
                >

                    <option value="">Selecione a hora da edicao</option>

                    @foreach($horarios as $horario)

                        <option
                            value="{{ $horario->id }}"
                            {{ old('jornalista_id') == $horario->id ? 'selected' : '' }}
                        >
                            {{ $horario-> horas }}
                        </option>

                    @endforeach

                </select>
            </div>


            {{-- Data --}}
            <div class="form-group">
                <label for="data">Data</label>

                <input
                    type="date"
                    name="data"
                    id="data"
                    class="form-control"
                    value="{{ old('data') }}"
                    required
                >
            </div>


            

        </div>

        <div class="card-footer">

            <button type="submit" class="btn btn-danger">
                Registar escala
            </button>

             <a href="{{route('dashboard')}}" class="btn btn-secondary">
                Voltar
            </a>

        </div>

    </form>

</div>

@stop