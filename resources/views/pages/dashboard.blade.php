@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <div class="row">
        <div class="col-sm-6">
            <h1>Dashboard</h1>
        </div>

        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                    <a href="{{ route('dashboard') }}">Início</a>
                </li>

                <li class="breadcrumb-item active">
                    Dashboard
                </li>
            </ol>
        </div>
    </div>
@stop


@section('content')

    


    {{-- ========================================================= --}}
    {{-- MENSAGEM DE BOAS-VINDAS --}}
    {{-- ========================================================= --}}

    <div class="row">
        <div class="col-12">
             @php
                 $user = auth()->user();
                 $role = $user->user_role;
        
             @endphp
            @if($role === 'chefeRedacao')
                <a href="{{route('jornalist')}}" class="btn btn-danger">Registar Jornalista</a>
                <a href="{{route('edicoes')}}" class="btn btn-danger">Edicoes</a>
                <a href="{{route('folgas.editores')}}" class="btn btn-danger">Folgas</a>
                <a href="" class="btn btn-danger">Agenda</a>
                <a href="" class="btn btn-danger">Actualizar Escala</a>
            @endif 

            @if($role=== 'chefeEmissoes')
                 <a href="{{route('jornalist')}}" class="btn btn-danger">Registar Locutor</a>
                 <a href="{{route('escala_loc')}}" class="btn btn-danger">Registar Emissao</a>
                <a href="" class="btn btn-danger">Programas</a>
                <a href=""class="btn btn-danger">Actualizar Escala</a>
                <a href="{{route('folgas.locutores')}}" class="btn btn-danger">Folgas</a>

            @endif

            @if($role=== 'chefeTecnico')
                 <a href="{{route('technicians')}}" class="btn btn-danger">Registar Tecnico</a>
                 <a href="{{route('escala_tecnica')}}" class="btn btn-danger">Produzir Escala</a>
                 <a href="{{route('folgas.tecnicos')}}" class="btn btn-danger">Folgas</a>
                <a href="" class="btn btn-danger">Tarefas</a>

            @endif

     

            <div class="card">

                <div class="card-body">
{{-- ========================================================= --}}
    {{-- DADOS DO UTILIZADOR --}}
    {{-- ========================================================= --}}

   
                   
       
                    <h4 class="mb-1">
                        Bem-vindo,
                        {{ $user->full_name }}
                    </h4>

                    <p class="text-muted mb-0">
                        Este é o painel principal do PTMS.
                       
                    </p>

                </div>

            </div>

        </div>
    </div>


    {{-- ========================================================= --}}
    {{-- INDICADORES PRINCIPAIS --}}
    {{-- ========================================================= --}}

    <div class="row">


        {{-- ===================================================== --}}
        {{-- REDACÇÃO --}}
        {{-- Admin + Chefe de Redacção --}}
        {{-- ===================================================== --}}

        @if(in_array($role, ['admin', 'chefeRedacao']))

            <div class="col-lg-4 col-md-6 col-sm-12">

                <div class="small-box bg-danger">

                    <div class="inner">
                        <h3>0</h3>
                        <p>Redacção</p>
                    </div>

                    <div class="icon">
                        <i class="fas fa-newspaper"></i>
                    </div>

                    <a href="#" class="small-box-footer">
                        Ver detalhes
                        <i class="fas fa-arrow-circle-right"></i>
                    </a>

                </div>

            </div>

        @endif


        {{-- ===================================================== --}}
        {{-- EMISSÕES --}}
        {{-- Admin + Chefe de Emissões --}}
        {{-- ===================================================== --}}

        @if(in_array($role, ['admin', 'chefeEmissoes']))

            <div class="col-lg-4 col-md-6 col-sm-12">

                <div class="small-box bg-info">

                    <div class="inner">
                        <h3>0</h3>
                        <p>Emissões</p>
                    </div>

                    <div class="icon">
                        <i class="fas fa-broadcast-tower"></i>
                    </div>

                    <a href="#" class="small-box-footer">
                        Ver detalhes
                        <i class="fas fa-arrow-circle-right"></i>
                    </a>

                </div>

            </div>

        @endif


        {{-- ===================================================== --}}
        {{-- ÁREA TÉCNICA --}}
        {{-- Admin + Chefe Técnico --}}
        {{-- ===================================================== --}}

        @if(in_array($role, ['admin', 'chefeTecnico']))

            <div class="col-lg-4 col-md-6 col-sm-12">

                <div class="small-box bg-warning">

                    <div class="inner">
                        <h3>0</h3>
                        <p>Área Técnica</p>
                    </div>

                    <div class="icon">
                        <i class="fas fa-tools"></i>
                    </div>

                    <a href="#" class="small-box-footer">
                        Ver detalhes
                        <i class="fas fa-arrow-circle-right"></i>
                    </a>

                </div>

            </div>

        @endif

    </div>


    {{-- ========================================================= --}}
    {{-- ÁREA PRINCIPAL --}}
    {{-- ========================================================= --}}

    <div class="row">


        {{-- ===================================================== --}}
        {{-- ACTIVIDADE DO PTMS --}}
        {{-- ===================================================== --}}

        <div class="col-lg-8">

            <div class="card">

                <div class="card-header">

                    <h3 class="card-title">

                        <i class="fas fa-chart-line mr-2"></i>

                        Actividade do PTMS

                    </h3>

                </div>


                <div class="card-body">

                    @if($role === 'admin')

                        <h5>
                            <i class="fas fa-user-shield mr-2"></i>
                            Painel Administrativo
                        </h5>

                        <p class="text-muted">
                            Aqui serão apresentadas as principais actividades
                            administrativas do PTMS.
                        </p>


                    @elseif($role === 'chefeRedacao')

                        <h5>
                            <i class="fas fa-newspaper mr-2"></i>
                            Área de Redacção
                        </h5>

                        <p class="text-muted">
                            Aqui serão apresentadas as actividades,
                            escalas e informações da Redacção.
                        </p>


                    @elseif($role === 'chefeEmissoes')

                        <h5>
                            <i class="fas fa-broadcast-tower mr-2"></i>
                            Área de Emissões
                        </h5>

                        <p class="text-muted">
                            Aqui serão apresentadas as actividades
                            relacionadas com as emissões.
                        </p>


                    @elseif($role === 'chefeTecnico')

                        <h5>
                            <i class="fas fa-tools mr-2"></i>
                            Área Técnica
                        </h5>

                        <p class="text-muted">
                            Aqui serão apresentadas as informações
                            técnicas e operacionais do PTMS.
                        </p>


                    @else

                        <p class="text-muted">
                            Não existem informações disponíveis
                            para este perfil.
                        </p>

                    @endif

                </div>

            </div>

        </div>


        {{-- ===================================================== --}}
        {{-- INFORMAÇÕES DO UTILIZADOR --}}
        {{-- ===================================================== --}}

        <div class="col-lg-4">

            <div class="card">

                <div class="card-header">

                    <h3 class="card-title">

                        <i class="fas fa-user mr-2"></i>

                        Utilizador

                    </h3>

                </div>


                <div class="card-body">


                    {{-- Nome --}}

                    <strong>

                        <i class="fas fa-user mr-2"></i>

                        Nome

                    </strong>

                    <p class="text-muted">

                        {{ $user->full_name }}

                    </p>


                    <hr>


                    {{-- Email --}}

                    <strong>

                        <i class="fas fa-envelope mr-2"></i>

                        Email

                    </strong>

                    <p class="text-muted">

                        {{ $user->email }}

                    </p>


                    <hr>


                    {{-- Perfil --}}

                    <strong>

                        <i class="fas fa-user-tag mr-2"></i>

                        Perfil

                    </strong>

                    <p class="text-muted">

                        {{ $user->user_role }}

                    </p>

                </div>

            </div>

        </div>

    </div>

@stop


{{-- ============================================================= --}}
{{-- FOOTER --}}
{{-- ============================================================= --}}

@section('footer')

    <footer class="main-footer bg-danger">

        <strong>

            Copyright &copy; {{ date('Y') }}

            <a href="{{ url('/') }}">
                PTMS
            </a>.

        </strong>

        Production and Technical Management System

        <a href="#" target="_blank">
            PTMS
        </a>.


        <div class="float-right d-none d-sm-inline-block">

            <b>Version</b> 0.1

        </div>

    </footer>

@endsection