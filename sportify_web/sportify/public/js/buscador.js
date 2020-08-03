function myFunction() {
    var input, filter, cards, cardContainer, h5, title, i;
    input = document.getElementById("cadena_busqueda");
    filter = input.value.toUpperCase();
    var filtro = document.getElementById("filtro");
    var contenido = filtro.options[filtro.selectedIndex].text;

    if (contenido == 'Mis temáticas') {
        cardContainer = document.getElementById("eventos_preferidos");
    } else {
        cardContainer = document.getElementById("eventos_todos");
    }

    cards = cardContainer.getElementsByClassName("tarjeta");
    for (i = 0; i < cards.length; i++) {
        title = cards[i].querySelector(".card .card-body h5.card-title");
        if (title.innerText.toUpperCase().indexOf(filter) > -1) {
            cards[i].style.display = "flex";
        } else {
            cards[i].style.display = "none";
        }
    }
}