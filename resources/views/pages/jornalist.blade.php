@extends('layouts.ptms')

@section('content')
     <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- jquery validation -->
            <div class="card card-dark">
              <div class="card-header">
                <h3 class="card-title">Cadastro de Locutor ou Jornalista </h3>
              </div>
             @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-warning">
        {{ session('error') }}
    </div>
@endif
              <!-- /.card-header -->
              <!-- form start -->
              <form id="quickForm" action="{{route('jornalist.store')}}" method="POST">
                @csrf
                <div class="card-body">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Nome</label>
                    <input type="text" name="name" class="form-control" id="exampleInputEmail1" placeholder="Primeiros nomes">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Apelido</label>
                    <input type="text" name="surname" class="form-control" id="exampleInputPassword1" placeholder="Apelido">
                  </div>

                  <div class="form-group">
                    <label for="exampleInputPassword1">Genero</label>
                    <div class="form-group">
                    <div class="form-group">
                    <select class="form-control select2" name="gender" style="width: 100%;">
                    <option selected="selected">Genero</option>
                    <option value="Femenino">Femenino</option>
                    <option value="Masculino">Masculino</option>
                    <option value="Outro">Outro</option>
                  </select>
                </div>
                  </div>

                  <div class="form-group">
                    <label for="exampleInputPassword1">NUIT</label>
                    <input type="text" name="nuit" class="form-control" id="exampleInputPassword1" placeholder="NUIT">
                  </div>

                  <div class="form-group">
                    <label for="exampleInputPassword1">Data de admissao</label>
                    <input type="date" name="admin_date" class="form-control" id="exampleInputPassword1">
                  </div>
                  


                  <div class="form-group">
                    <label for="exampleInputPassword1">Carreira</label>
                    <div class="form-group">
                    <select class="form-control select2" name="career" style="width: 100%;">
                    <option selected="selected">Carreira</option>
                    <option value="Locutor">Locutor</option>
                    <option value="Jornalista">Jornalista</option>
                    <option value="Locutor e Jornalista">Locutor e Jornalista</option>
                  </select>
                </div>
                  </div>

                  <div class="form-group">
                    <label for="exampleInputPassword1">Linguas</label>
                    <input type="text" name="languages" class="form-control" id="exampleInputPassword1" placeholder="Linguas">
                  </div>

                  <div class="form-group">
                    <label for="exampleInputPassword1">Afectacao</label>
                    <div class="form-group">
                    <select class="form-control select2" name="allocation" style="width: 100%;">
                    <option selected="selected">Afectacao</option>
                    <option value="Antena Nacional">Antena Nacional</option>
                    <option value="EPM">EPM</option>
                    <option value="MCR">MCR</option>
                    <option value="EPG">EPG</option>
                    <option value="EPI">EPI</option>
                    <option value="EPS">EPS</option>
                    <option value="EPZ">EPZ</option>
                    <option value="EPCD">EPCD</option>
                    <option value="EPN">EPN</option>
                    <option value="EPT">EPT</option>
                    <option value="Radio Cidade">Radio Cidade</option>
                  </select>
                </div>
                  

                  <div class="form-group">
                    <label for="exampleInputPassword1">Telefone</label>
                    <input type="text" name="telephone" class="form-control" id="exampleInputPassword1" placeholder="Numero de telefone celular">
                  </div>

                  
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" class="btn btn-danger">Registar</button>

                   <a href="{{route('dashboard')}}" class="btn btn-secondary">
                    Voltar
                  </a>
                </div>

               
              </form>
            </div>
            <!-- /.card -->
            </div>
          <!--/.col (left) -->
          <!-- right column -->
          <div class="col-md-6">

          </div>
          <!--/.col (right) -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>

@stop