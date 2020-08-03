@extends('layouts.app')

@section('content')

<div class="container-fluid mis_eventos"  style="margin-top: 2vh;">
    @include('inc.sidebar')
    <div class="row justify-content-center">
        
        <div id='calendar'></div>

            
        
                

    </div>
    
</div>
  
@endsection

@section('script')

<script>
    $(document).ready(function() {
        // page is now ready, initialize the calendar...
        $('#calendar').fullCalendar({
            // put your options and callbacks here
            monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
            monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'],
            dayNames: ['Domingo','Lunes','Martes','Miércoles','Jueves','Viernes','Sábado'],
            dayNamesShort: ['Dom','Lun','Mar','Mié','Jue','Vie','Sáb'],
            firstDay: 1,
            buttonText: {
                today: 'Hoy'
            },
            header: {
                left: 'prev,next ',
                center: 'title',
                right: 'today'
            },
            events : [
                @foreach($eventos as $evento)
                {
                    title : '{{ $evento->titulo_e }}',
                    start : '{{ $evento->fecha_ini }}',
                    end : '{{ $evento->fecha_fin }}T23:59:59',
                    allDay: false,
                    color : '#'+(Math.random()*0xFFFFFF<<0).toString(16),
                    url : '{{ url('entidad/evento/'.$evento->id_evento) }}'
                },
                @endforeach
            ]
        })
    });
</script>
@endsection
