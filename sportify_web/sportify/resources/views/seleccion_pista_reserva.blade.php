@extends('layouts.app')

@section('content')

<div class="container-fluid mis_eventos"  style="margin-top: 2vh;">
    @include('inc.sidebar')
    <div class="row justify-content-center">
        <div class="col-12">
            <h1 style="padding-top:20px; ">Pistas de {{ $entidad->name }}</h1>         

            <div class="row  ">
                <div class="col-md-3"></div>
                <div class="list-group col-md-6">
                    @foreach ($pistas as $pista)
                    
                        
                        <a href="{{ url('individual/lista-entidades/'.$id_evento.'/'.$entidad->id_entidad.'/'.$pista->id_pista) }}"  class="list-group-item list-group-item-action  align-items-start ">

                            <p class="mb-1" style="font-size: 2rem; text-align: center;">Pista {{ $pista->id_pista }}</p>
                                    
                        </a>
                        
                    
                    @endforeach
                </div>
                <div class="col-md-3"></div>
            </div>
            
        </div>
    </div>
    
</div>
  
@endsection