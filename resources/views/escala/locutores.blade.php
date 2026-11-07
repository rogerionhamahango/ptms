@extends('layouts.ptms')

@section('content')

<div class="card">

    <div class="card-header">
        <h3 class="card-title"><b>Registar Escala Locutores</b></h3>
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
    <div class="alert alert-dark alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle"></i>
        {{ session('error') }}

        <button type="button" class="close" data-dismiss="alert">
            <span>&times;</span>
        </button>
    </div>
    @endif

    <form action="{{ route('store_locutores') }}" method="POST">

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
                <label for="jornalist_id">Locutor</label>

                <select
                    name="jornalist_id"
                    id="jornalist_id"
                    class="form-control"
                    required
                >

                    <option value="">Seleccione o Locutor</option>

                    @foreach($locutores as $locutor)

                        <option
                            value="{{ $locutor->id }}"
                            {{ old('jornalist_id') == $locutor->id ? 'selected' : '' }}
                        >
                            {{ $locutor->name }} {{ $locutor->surname }}
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


            {{-- Turno --}}
            <div class="form-group">
                <label for="turno">Horário de entrada</label>

                <select
                    name="turno"
                    id="turno"
                    class="form-control"
                    required
                >

                    <option value="">Seleccione o horário</option>

                    <option value="4h30" {{ old('turno') == '4h30' ? 'selected' : '' }}>
                        4h30
                    </option>

                    <option value="09h55" {{ old('turno') == '11h30' ? 'selected' : '' }}>
                        09h55
                    </option>

                    <option value="18h55" {{ old('turno') == '18h30' ? 'selected' : '' }}>
                        18h55
                    </option>

                    <option value="0h00" {{ old('turno') == '0h30' ? 'selected' : '' }}>
                        0h00
                    </option>

                </select>
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