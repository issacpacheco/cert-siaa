function nobackbutton() {
    window.location.hash = "no-back-button";
    window.location.hash = "Again-No-back-button";
    window.onhashchange = function () {
        window.location.hash = "no-back-button";
    }
}

function popuptamano(w, h) {
    var ml = (w / 2) - w;
    $("#popup").css({
        width: w + "px",
        height: h + "px",
        marginLeft: ml + "px"
    });
}

function popupheight(h) {
    $("#popup").css({
        height: h + "px"
    });
}

function mostrarpopup(contenido) {
    $("#popup").html(contenido);
    $("#portapopups").finish();
    $("#portapopups").fadeIn("fast", function () {
        $("#popup").animate({
            top: "0px"
        }, 500, function () {

        });
    });
}

function cerrarpopup() {
    //var h = $("#popup").height() + 50;
    var h = 1000;
    $("#popup").animate({
        top: "-" + h + "px"
    }, 500, function () {
        $("#portapopups").fadeOut("fast");
        $('html,body').css('overflow', 'auto');
        $( "#popup").unbind( "keypress" );
    });
}

function alertaVerde(mensaje) {
    if (hacer == 0) {
        $(".cajaAlertaVerde p").html(mensaje);
        $(".cajaAlertaVerde").show();
        $(".cajaAlertaVerde").stop(true, true).animate({
            right: "0px"
        }, 200, function () {
            hacer = 1;
            setTimeout(function () {
                escondeAlertas();
            }, 3000);
        });
    }
}

function saveInfo(page, postpagina, elem) {
    var frm = $(elem).data("form");
    if (validacionID("frmRegistro", "validar")) {
        if(frm != ''){
            const button = document.querySelector('button');
            button.disabled = true;
            $.ajax({
                type: "POST",
                url: "ajax-save/" + page,
                data: $("#frmRegistro").serialize()+"&"+$("#"+frm).serialize(),
                success: function (response) {
                    alertaVerde("Realizado con éxito!");
                    if(postpagina != ''){
                        simpleload('contenedor', postpagina);
                    }
                    button.disabled = false;
                },
                failure: function (response) {
                    //----some code here-----//
                },
                error: function (response) {
                    //----some code here-----//
                }
            });
        }else{
            const button = document.querySelector('button');
            button.disabled = true;
            $.ajax({
                type: "POST",
                url: "ajax-save/" + page,
                data: $("#frmRegistro").serialize(),
                success: function (response) {
                    alertaVerde("Realizado con éxito!");
                    if(postpagina != ''){
                        simpleload('contenedor', postpagina);
                    }
                    button.disabled = false;
                },
                failure: function (response) {
                    //----some code here-----//
                },
                error: function (response) {
                    //----some code here-----//
                }
            });
        }
    } else {
        alertaRoja("Completa los campos marcados");
    }
}