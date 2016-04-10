//Hide e Show filtro da página de mapa de eventos
$('document').ready(function(){

    $('#filtrar-mapa-eventos').click(function(){

        if($('#filtro-mapa-eventos').hasClass('fechado')){
            $('#filtro-mapa-eventos').slideDown();
            $('#filtro-mapa-eventos').removeClass('fechado');

            $('#filtrar-mapa-eventos > span').removeClass('glyphicon-chevron-down');
            $('#filtrar-mapa-eventos > span').addClass('glyphicon-chevron-up');

        }else{
            $('#filtro-mapa-eventos').slideUp();
            $('#filtro-mapa-eventos').addClass('fechado');

            $('#filtrar-mapa-eventos > span').addClass('glyphicon-chevron-down');
            $('#filtrar-mapa-eventos > span').removeClass('glyphicon-chevron-up');
        }
    })})

//Hide e Show quadro informativo da página de mapa de eventos

$('document').ready(function(){

    $('#quadro-mapa-eventos').click(function(){

        if($('#quadro-informativo-mapa-eventos').hasClass('fechado')){
            $('#quadro-informativo-mapa-eventos').removeClass('fechado');
            $('#h3-quadro-informativo').removeClass('fechado');

            $('#quadro-mapa-eventos > span').removeClass('glyphicon-chevron-left');
            $('#quadro-mapa-eventos > span').addClass('glyphicon-chevron-right pull-right');

            $('#mapa-eventos').removeClass('col-md-11 col-lg-11');
            $('#mapa-eventos').addClass('col-md-9 col-lg-9');
            $('#quadro-direito-mapa').removeClass('col-md-1 col-lg-1');
            $('#quadro-direito-mapa').addClass('col-md-3 col-lg-3');

        }else{
            $('#quadro-informativo-mapa-eventos').addClass('fechado');
            $('#h3-quadro-informativo').addClass('fechado');

            $('#quadro-mapa-eventos > span').addClass('glyphicon-chevron-left');
            $('#quadro-mapa-eventos > span').removeClass('glyphicon-chevron-right pull-right');

            $('#mapa-eventos').addClass('col-md-11 col-lg-11');
            $('#mapa-eventos').removeClass('col-md-9 col-lg-9');
            $('#quadro-direito-mapa').addClass('col-md-1 col-lg-1');
            $('#quadro-direito-mapa').removeClass('col-md-3 col-lg-3');
        }
    })})


//Hide & show detalhes do quadro informativo da coluna a direita da pagina de Mapa de eventos
$('document').ready(function(){
    $()
    $('.nav-pills-pai').click(function(){
        var i = $('.nav-pills-pai').index(this);
        var filho = $('.nav-pills-filho').eq(i);

        if(filho.hasClass('fechado')){
            filho.slideDown();
            filho.removeClass('fechado')
        }else{
            filho.slideUp();
            filho.addClass('fechado');
        }
    })
})