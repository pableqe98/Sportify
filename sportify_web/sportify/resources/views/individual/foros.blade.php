@extends('layouts.app')

@section('content')

<div class="container-fluid mis_eventos"  style="margin-top: 2vh;">
    @include('inc.sidebar')
    <div class="row justify-content-center">
        <div class="col-12">
            <h1 style="padding-top:20px; ">Foros Temáticos</h1>         

            <div class="row  ">
                <div class="col-md-3"></div>
                <div class="list-group col-md-6">
                    @foreach ($foros as $foro)
                        <a href="{{ url('individual/foro/'.$foro->id_foro) }}"  class="list-group-item list-group-item-action  align-items-start ">

                            <p class="mb-1" style="font-size: 2rem; text-align: center;">{{ $foro->nombre_foro }}</p>
                                
                        </a>
                    @endforeach
                </div>
                <div class="col-md-3"></div>
            </div>
            
        </div>
    </div>
    
</div>
  
@endsection