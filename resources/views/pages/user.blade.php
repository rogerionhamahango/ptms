@extends('layouts.ptms')




@section('content')
      <h1 class="text-center">
        <b>PTMS</b>
    </h1>

    <p class="text-center text-muted">
        Production and Technical Management System
    </p>
   <form action="{{route('store')}}" method="post">
    @csrf
        <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="Full name" name="full_name">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="email" class="form-control" placeholder="Email" name="email">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <select name="user_role" id="role" class="form-control">
            <option value="">Select Role</option>
            <option value="superadmin">superAdmin</option>
            <option value="admin">Admin</option>
            <option value="chefeRedacao">Chefe Redacao</option>
            <option value="chefeEmissoes">Chefe Emissoes</option>
            <option value="chefeTecnico">Chefe Tecnico</option>
          </select>
          <div class="input-group-append">
            
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Password" name="password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" name="password_confirmation" placeholder="Retype password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        
        <div class="row">
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-danger btn-block">Register</button>
          </div>
          <!-- /.col -->
        </div>
      </form>
@stop    
