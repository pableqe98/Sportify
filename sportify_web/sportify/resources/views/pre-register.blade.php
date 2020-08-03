@extends('layouts.app')

@section('title', '')

@section('css')
<link rel="stylesheet" type="text/css"  href="{{ asset('css/login.css') }}">
@endsection

@section('content')

<div class="boton_atras">
    <a href="{{ url('/') }}" style="font-size: 45px">
        <i class="fas fa-arrow-alt-circle-left"></i>
    </a>
</div>


<div class="container-fluid">
    <div class="row ">
      <div class="d-none d-md-flex col-md-3"></div>
      <div class="col-md-6">
        <div class="login d-flex align-items-center py-5">
          <div class="container">
            <div class="row">
              <div class="col-md-9 col-lg-8 mx-auto">
                <h3 class="mb-4 text-center">Tipo de usuario</h3>
                <div class="row">
                  <div class="col-md-6">
                  <a role="button" class="btn btn-primary btn-lg" href="{{ route('individual.register') }}">Usuario Individual</a>
                  </div>
                  <div class="col-md-6 text-right">
                    <a role="button" class="btn btn-primary btn-lg " href="{{ route('entidad.register') }}">Empresa</a>
                  </div> 
                      
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="d-none d-md-flex col-md-3"></div>
    </div>
  </div>




@endsection