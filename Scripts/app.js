var cola = [];
var cancionActual = -1;

$(document).ready(function () {
    $(window).on('hashchange', function () {
        switch (location.hash.slice(1)) {
            case "Inicio":

                $(".menu li:nth-child(2)").removeClass("seleccionado");
                $(".menu li:nth-child(1)").addClass("seleccionado");

                $("#divCola").hide("fast", function () {
                    $("#divResultados").show("fast");
                })
                break;
            case "Cola":
                $(".menu li:nth-child(1)").removeClass("seleccionado");
                $(".menu li:nth-child(2)").addClass("seleccionado");

                $("#divResultados").hide("fast", function () {
                    $("#divCola").show("fast");

                })

                break;
        }
        //alert(location.hash.slice(1));    
    });

    $("form").on("submit", function (e) {
        e.preventDefault();
        var textoDeBusqueda = $("#txtBusqueda").val();

        $.ajax({
            url: "Servidor/prueba.php",
            data: { buscarPor: textoDeBusqueda }
        }).done(function (datos) {
            $("#divCola").html(datos);
        }).fail(function (error) {
            alert(JSON.stringify(error));
        });

    });

    /*
    $("input[type=text]").on("keydown", function(evento){
    console.log(evento.key);
    if(!evento.key >= "0" && evento.key <= "9"){
    evento.preventDefault();
    }
    })
    */

    $(".lista li").click(function () {
        var archivo = $(this).find("input[type=hidden]").val();
        var cancionEnCola = $("#divCola .lista li input[value='"+ archivo +"']");
        if(cancionEnCola.length==0){
            $("#divCola .lista").append("<li>" + $(this).html() + "</li>");
            $("#reproductor").attr("src", "Musica/" + archivo);
        
        document.getElementById('reproductor').play();
        }
    
    });

    $("#botonPausa").click(function () {
        var reproductor = document.getElementById("reproductor");
        if (reproductor.paused) {
            reproductor.play();
            $(this).removeClass("pause");
            $(this).addClass("play");
        } else {
            reproductor.pause();
            $(this).removeClass("play");
            $(this).addClass("pause");
        }

    });


     $('#chkMenu + label').click(function(){
		$('.cuerpo > aside').toggle();
		
	});
})