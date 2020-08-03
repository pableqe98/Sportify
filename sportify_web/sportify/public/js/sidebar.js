$(document).ready(function () {
        $("#sidebar").mCustomScrollbar({
            theme: "minimal"
        });

        $('#dismiss, .overlay').on('click', function () {
            // hide sidebar
            $('#sidebar').removeClass('active');
           // $('#sidebar').style.display = 'none';
            // hide overlay
            $('.overlay').removeClass('active');
        });

        $('#sidebarCollapse').on('click', function () {
          //  $('#sidebar').style.display = 'block';
            // open sidebar
            $('#sidebar').addClass('active');
            // fade in the overlay
            $('.overlay').addClass('active');
            $('.collapse.in').toggleClass('in');
            $('a[aria-expanded=true]').attr('aria-expanded', 'false');
        });
});
