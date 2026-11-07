@extends('adminlte::page')

@section('title', 'Jornalistas')

@section('content_header')
    <h1>Lista de Jornalistas</h1>
@stop

@section('content')

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Jornalistas cadastrados</h3>
    </div>

    <div class="card-body">

        <table class="table table-bordered table-striped">

            <thead>
                <tr>
                    
                    <th>Nome</th>
                    <th>Genero</th>
                    <th>NUIT</th>
                    <th>Data de admissão</th>
                    <th>Afectação</th>
                    <th>Telefone</th>
                </tr>
            </thead>

            <tbody>
                 @forelse($jornalista as $jornalist)

                    <tr>
                        
                        <td>{{ $jornalist->name }} {{$jornalist->surname}}</td>
                        <td>{{ $jornalist->gender }}</td>
                        <td>{{ $jornalist->nuit }}</td>
                        <td>{{ $jornalist->admin_date }}</td>
                        <td>{{ $jornalist->allocation }}</td>
                        <td>{{ $jornalist->telephone }}</td>
                    </tr>

                @empty

                    <tr>
                        <td colspan="9" class="text-center">
                            Nenhum jornalista cadastrado.
                        </td>
                    </tr>

                @endforelse             
            </tbody>

        </table>

    </div>
</div>

@stop