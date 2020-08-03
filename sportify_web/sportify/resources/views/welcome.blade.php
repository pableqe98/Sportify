@extends('layouts.app')

@section('title', '')

@section('css')
<link rel="stylesheet" type="text/css" href="{{ asset('css/inicio.css') }}">
@endsection


@section('content')

<!-- Carrusel -->

<div id="carouselExampleCaptions" class="carousel slide" data-ride="carousel">
    <ol class="carousel-indicators">
        <li data-target="#carouselExampleCaptions" data-slide-to="0" class="active"></li>
        <li data-target="#carouselExampleCaptions" data-slide-to="1"></li>
        <li data-target="#carouselExampleCaptions" data-slide-to="2"></li>
    </ol>
    <div class="carousel-inner" >
        <div class="carousel-item active">
            
            <img src={{ asset('imgs/carousel/andar.png') }} class="d-block w-100 carrusel" alt="running"/>
            <div class="carousel-caption">
                <p>Tres no tienen que ser multitud</p>
                <p class="subtexto">Seguro que hay muchas personas que comparten tu pasión. ¡Uníos!</h3>
            </div>
        </div>
        <div class="carousel-item">
            <img src={{ asset('imgs/carousel/futbol.png') }} class="d-block w-100 carrusel" alt="futbol"/>
            <div class="carousel-caption">
                <p>¿No estáis suficientes para un partido?</p>
                <p class="subtexto">Crea un evento en Sportify, compártelo, y consigue gente. ¡No te quedes sin plan!</p>
            </div>
        </div>
        <div class="carousel-item">
            <img src={{ asset('imgs/carousel/basket.png') }} class="d-block w-100 carrusel" alt="tenis"/>
            <div class="carousel-caption">
                <p>¿Podréis ser los campeones?</p>
                <p class="subtexto">
                    Participa u organiza torneos y ligas. Forma un equipo con tus amigos y a ganar.
                </p>
            </div>
        </div>
    </div>
    <a class="carousel-control-prev" href="#carouselExampleCaptions" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#carouselExampleCaptions" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
</div>

<!-- Divisor -->
<div class="container-fluid mb-6" style="margin-top: 5%; margin-bottom: 5%;">
   
    <hr class="solid">
</div>

<!-- Cartas -->
<div class="container-fluid" >
    <div class="card-deck  ">
        <div class="card bg-light">
            <img class="card-img-top" src={{ asset('imgs/cards/woman-playing-soccer-ball-on-grass-258395.jpg') }}  alt="Card image cap">
            <div class="card-body">
                <h5 class="card-title text-center">Organiza eventos</h5>
                <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
            </div>
        
        </div>
        <div class="card bg-light">
            <img class="card-img-top" src={{ asset('imgs/cards/girls-on-white-red-jersey-playing-hand-game-163465.jpg') }}  alt="Card image cap">
            <div class="card-body">
                <h5 class="card-title text-center">Haz nuevos amigos</h5>
                <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
            </div>
        
        </div>
        <div class="card bg-light">
            <img class="card-img-top" src={{ asset('imgs/cards/action-athletes-black-and-white-court-839707.jpg') }}  alt="Card image cap">
            <div class="card-body">
                <h5 class="card-title text-center">Crea equipos</h5>
                <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
            </div>
        
        </div>
  </div>
</div>

<!-- Divisor -->
<div class="container-fluid mb-6" style="margin-top: 5%; margin-bottom: 5%;">
    <hr class="solid">
</div>

<!-- Cartas -->
<div class="container-fluid" >
    <div class="row">
        <div class="col-md-2"></div>
        <div class="card bg-light text-center col-md-8" >
            
            <div class="card-body">
                <h1 class="card-title text-center">Mira nuestros eventos</h1>
                <a href="{{ url('/eventos-info') }}" class="btn btn-primary" style="font-size: 2em;">Ver Eventos</a>
            </div>
        
        </div>
        <div class="col-md-2"></div>
    </div>
</div>

<!-- Divisor -->
<div class="container-fluid mb-6" style="margin-top: 5%; margin-bottom: 5%;">
    <hr class="solid">
</div>

<!-- Unirse -->

<h1 class="text-center">¡Únete a Nosotros!</h1>

<div class="container-fluid text-center mt-4 mb-5" style="width:50%;">

    <a role="button" class="btn btn-primary btn-lg btn-block botonRegistrar" href="{{ url('/pre-register') }}">Regístrate</a>

    <div class="mt-4">
        <p>¿Ya tienes una cuenta? <a href="{{ url('/pre-login') }}">Inicia sesión</a> </p>
    </div>
    

</div>


@endsection
