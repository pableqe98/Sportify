$(document).on('change', '.form-control', function() {
    var target = $(this).data('target');
    var show = $("option:selected", this).data('show');
    $(target).children().addClass('hide');
    $(show).removeClass('hide');
});

$(document).ready(function(){
    $('.form-control').trigger('change');
});


//Filtro buscar usuarios para invitar a equipo
$(document).ready(function(){
    $("#filtroNombre").on("keyup", function() {
      var value = $(this).val().toLowerCase();
      $("#lista_usuarios *").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
      });
    });
  });