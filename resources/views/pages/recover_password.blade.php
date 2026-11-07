@extends('adminlte::auth.auth-page')

@section('auth_header')
    <h1 class="text-center">
        <b>PTMS</b>
    </h1>

    <p class="text-center text-muted">
        Production and Technical Management System
    </p>
@stop

@section('auth_body')

    <form action="#">
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Confirm Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <button type="submit" class="btn btn-danger btn-block">Change password</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

@stop