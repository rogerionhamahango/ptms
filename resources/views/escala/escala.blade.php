@extends('layouts.ptms')

@section('content')

<div class="card">

    <div class="card-header">
        <h3 class="card-title">Registar Escala Técnica</h3>

        
    </div>

    <form action="{{ route('store_escala') }}" method="POST">

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


            {{-- Técnico --}}
            <div class="form-group">
                <label for="technician_id">Técnico</label>

                <select
                    name="technician_id"
                    id="technician_id"
                    class="form-control"
                    required
                >

                    <option value="">Seleccione o técnico</option>

                    @foreach($tecnicos as $tecnico)

                        <option
                            value="{{ $tecnico->id }}"
                            {{ old('technician_id') == $tecnico->id ? 'selected' : '' }}
                        >
                            {{ $tecnico->name }} {{ $tecnico->surname }}
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

                    <option value="11h30" {{ old('turno') == '11h30' ? 'selected' : '' }}>
                        11h30
                    </option>

                    <option value="18h30" {{ old('turno') == '18h30' ? 'selected' : '' }}>
                        18h30
                    </option>

                    <option value="0h30" {{ old('turno') == '0h30' ? 'selected' : '' }}>
                        0h30
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