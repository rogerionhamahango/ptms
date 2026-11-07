@extends('adminlte::page')

@section('title', 'Tecnicos')

@section('content_header')
    <h1>Lista dos Tecnicos</h1>
@stop

@section('content')

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Tecnicos cadastrados</h3>
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
                @foreach($tecnicos as $technic)

                    <tr>
                        
                        <td>{{ $technic->name }} {{$technic->surname}}</td>
                        <td>{{ $technic->gender }}</td>
                        <td>{{ $technic->nuit }}</td>
                        <td>{{$technic->admin_date }}</td>
                        <td>{{ $technic->allocation }}</td>
                        <td>{{ $technic->telephone }}</td>
                    </tr>

                @endforeach     
                       
            </tbody>

        </table>

    </div>
</div>

@stop