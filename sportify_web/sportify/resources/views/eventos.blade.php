@extends('layouts.app')

@section('content')
<div >
    <a href="{{ url()->previous() }}" style="font-size: 45px">
        <i class="fas fa-arrow-alt-circle-left"></i>
    </a>
</div>

<div class="container-fluid mis_eventos"  style="margin-top: 2vh;">

    <div class="row justify-content-center">
        <div class="col-12">
            <h1 style="padding-top:20px; ">Eventos</h1>

            <div class="row  ">
                @foreach ($eventos as $evento)
                <div class="col-lg-3 col-sm-12">
                    <div class="card bg-light">
                        <img class="card-img-top" src="{{ asset($evento->foto) }}" alt="Imagen evento">
                        <div class="card-body">
                            <h5 class="card-title text-center">{{ $evento->titulo_e }}</h5>
                            
                            <a href="{{ url('eventos-info/'.$evento->id_evento) }}" class="btn btn-primary">Ver evento</a>
                        </div>
                    
                    </div>
                </div>
                @endforeach
          </div>
            
        </div>
    </div>
    
</div>
  
@endsection