@extends('layouts.ptms')






@section('content')

<form action="{{route('techicians.store')}}" method="post">
    @csrf
                <div class="card-body">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Nome</label>
                    <input type="text" name="name" class="form-control" id="exampleInputEmail1" placeholder="Primeiros nomes">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Apelido</label>
                    <input type="text" class="form-control" name="surname" id="exampleInputPassword1" placeholder="Apelido">
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

                  <div class="form-group">
                    <label for="exampleInputPassword1">NUIT</label>
                    <input type="text" name="nuit" class="form-control" id="exampleInputPassword1" placeholder="NUIT">
                  </div>

                  <div class="form-group">
                    <label for="exampleInputPassword1">Data de ingresso</label>
                    <input type="date" name="admin_date" class="form-control" id="exampleInputPassword1">
                  </div>

                  <div class="form-group">
                    <label for="exampleInputPassword1">Categoria</label>
                    <input type="text" name="category" class="form-control" id="exampleInputPassword1" placeholder="Sua categoria">
                  </div>

                  <div class="form-group">
                    <label for="exampleInputPassword1">Afectacao</label>
                    <div class="form-group">
                    <select class="form-control select2" name="allocation" style="width: 100%;">
                    <option selected="selected">Afectacao</option>
                    <option value="Sede">Sede</option>
                    <option value="EPM">Maputo</option>
                    <option value="EPG">Gaza</option>
                    <option value="EPI">Inhambane</option>
                    <option value="EPS">Sofala</option>
                    <option value="EPZ">Zambezia</option>
                    <option value="EPCD">Cabo Delgado</option>
                    <option value="EPN">Nampula</option>
                    <option value="Tete">EPT</option>
                    <option value="EPMA">Manica</option>
                  </select>
                </div>

                  <div class="form-group">
                    <label for="exampleInputPassword1">Telefone</label>
                    <input type="text" name="telephone" class="form-control" id="exampleInputPassword1" placeholder="Numero de telefone celular.">
                  </div>
                  
                    
                  
                  
                

                <div class="card-footer">
                  <button type="submit" class="btn btn-danger">Registar</button>

                    <a href="{{route('dashboard')}}" class="btn btn-secondary">
                    Voltar
                  </a>
                </div>
 </form>

@stop
