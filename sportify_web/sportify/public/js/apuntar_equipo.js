  //Funcion para seleccionar el usuario elegido para invitar a un equipo
  $(document).ready(function() {

      // Get click event, assign button to var, and get values from that var
      $('#lista_equipos button').on('click', function() {
          var thisBtn = $(this);

          thisBtn.addClass('active').siblings().removeClass('active');
          var btnText = thisBtn.text();
          var btnValue = thisBtn.val();
          console.log(btnValue);

          $('#equipo_seleccionado').text(btnValue);
          $('#equipo_seleccionado').val(btnValue);
      });

  });


  $(document).ready(function() {

      // Get click event, assign button to var, and get values from that var
      $('#lista_usuarios button').on('click', function() {
          var thisBtn = $(this);

          thisBtn.addClass('active').siblings().removeClass('active');
          var btnText = thisBtn.text();
          var btnValue = thisBtn.val();
          console.log(btnValue);

          //$('#usuario_seleccionado').text(btnValue);
          $('#usuario_seleccionado').val(btnValue);
      });

  });