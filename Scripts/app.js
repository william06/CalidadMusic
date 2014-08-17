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
                });
                break;
            case "Cola":
                $(".menu li:nth-child(1)").removeClass("seleccionado");
                $(".menu li:nth-child(2)").addClass("seleccionado");

                $("#divResultados").hide("fast", function () {
                    $("#divCola").show("fast");

                });

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
        var cancionEnCola = $("#divCola .lista li input[value='" + archivo + "']");
        if (cancionEnCola.length == 0) {
            $("#divCola .lista").append("<li>" + $(this).html() + "</li>");
            $("#reproductor").attr("src", "Musica/" + archivo);
			$("#divReproductor").html($(this).html());
            document.getElementById('reproductor').play();
            cola.push(archivo);
            cancionActual=archivo;
        }

    });

    $("#botonPausa").click(function () {
        var reproductor = document.getElementById("reproductor");
        if (reproductor.paused) {
            reproductor.play();
            $(this).removeClass("icon-play");
            $(this).addClass("icon-pause");
        } else {
            reproductor.pause();
            $(this).removeClass("icon-pause");
            $(this).addClass("icon-play");
        }

    });


    $('#chkMenu + label').click(function () {
        $('.cuerpo > aside').toggle();

    });


     $("#botonAtras").click(function () {
    	for(var i=0; i < cola.length; i++){ 
        	if(cola[i]==cancionActual){
        		$("#reproductor").attr("src", "Musica/" + cola[i-1]);
        		document.getElementById('reproductor').play();
        		cancionActual=cola[i-1];
        		
        		var cancionEnCola = $("#divCola .lista li input[value='" + cancionActual + "']");
        		$("#divReproductor").html(cancionEnCola.parent().html());
        	}
        }
    });
    
    
    $("#botonSiguiente").click(function () {
    	for(var i=0; i < cola.length-1; i++){ 
        	if(cola[i]==cancionActual){
        		$("#reproductor").attr("src", "Musica/" + cola[i+1]);
        		document.getElementById('reproductor').play();
        		cancionActual=cola[i+1];
        		
        		var cancionEnCola = $("#divCola .lista li input[value='" + cancionActual + "']");
        		$("#divReproductor").html(cancionEnCola.parent().html());
        		break;
        	}
        		 
        }
    });
    


    //agregar al final de la cola
    $(".lista li .icon-indent-increase").click(function () {
        var archivo = $(this).parent().find("input[type=hidden]").val();
        var cancionEnCola = $("#divCola .lista li input[value='" + archivo + "']");
        if (cancionEnCola.length == 0) {
            $("#divCola .lista").append("<li>" + $(this).parent().html() + "</li>");
            
            cola.push(archivo);
            
        }

    });
    
});


function borrar(){
	$(".lista li .icon-remove").click(function(){
    	var archivo = $(this).parent().find("input[type=hidden]").val();
    	$(this).parent().remove();
   
    	var pos =cola.indexOf(archivo);
    	pos > -1 && cola.splice(pos,1);
    });
}


function siguienteCancion(){
	for(var i=0; i < cola.length-1; i++){ 
        	if(cola[i]==cancionActual){
        		$("#reproductor").attr("src", "Musica/" + cola[i+1]);
        		document.getElementById('reproductor').play();
        		cancionActual=cola[i+1];
        		
        		var cancionEnCola = $("#divCola .lista li input[value='" + cancionActual + "']");
        		$("#divReproductor").html(cancionEnCola.parent().html());
        		break;
        	}
        		 
        }
}