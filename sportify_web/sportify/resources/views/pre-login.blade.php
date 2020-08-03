@extends('layouts.app')

@section('title', '')

@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('css/login.css') }}">
@endsection

@section('content')

<div >
    <a href="{{ url('/') }}" style="font-size: 45px" class="boton_atras">
        <i class="fas fa-arrow-alt-circle-left boton_atras"></i>
    </a>
</div>


<div class="container-fluid">
    <div class="row ">
      <div class="d-none d-md-flex col-md-1"></div>
      <div class="col-md-10">
        <div class="login d-flex align-items-center py-5">
          <div class="container">
            <div class="row">
              <div class="col-md-9 col-lg-8 mx-auto">
                <h3 class="mb-4 text-center">Tipo de usuario</h3>
                <div class="row">
                  <div class="col-md-4">
                    <a role="button" class="btn btn-primary btn-lg" href="{{ route('individual.login') }}">Individual</a>
                  </div>
                  <div class="col-md-4 text-center">
                    <a role="button" class="btn btn-primary btn-lg " href="{{ route('admin.login') }}">Administrador</a>
                  </div>
                  <div class="col-md-4 text-right">
                    <a role="button" class="btn btn-primary btn-lg " href="{{ route('entidad.login') }}">Empresa</a>
                  </div> 
                      
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="d-none d-md-flex col-md-1"></div>
    </div>
  </div>




@endsection