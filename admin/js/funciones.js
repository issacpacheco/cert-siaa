$(document).ready(function(){
    // $("#btnlogin").click(function(){
    //     fnlogin();
    // });
    
    // $("input").keyup(function () {
    //     if ($(this).hasClass('alerta')) {
    //         $(this).removeClass('alerta');
    //     }
    // });  
    
    // $("#acceso").animate({
    //     top: "50%"
    // }, 800, function(){
    //     setTimeout(function () {
    //         mostrarFormulario();
    //     }, 500);
    // });
    
    $("body, #board, #popup").on("keypress", ".esnumero", function(){
        elem = $(this);
        // capturamos la tecla pulsada
        var teclaPulsada = window.event ? window.event.keyCode : e.which;

        // capturamos el contenido del input
        var valor = $(elem).val();
        if (teclaPulsada > 31 && (teclaPulsada < 48 || teclaPulsada > 57)) {
            return false;
        }else{
            return true;
        }

        // devolvemos true o false dependiendo de si es numerico o no
        return /\d/.test(String.fromCharCode(teclaPulsada));        
    });
    $("body, #board, #popup").on("keypress", ".esprecio", function(){
        elem = $(this);
        // capturamos la tecla pulsada
        var teclaPulsada = window.event ? window.event.keyCode : e.which;

        // capturamos el contenido del input
        var valor = $(elem).val();

        // 45 = tecla simbolo menos (-)
        // Si el usuario pulsa la tecla menos, y no se ha pulsado anteriormente
        // Modificamos el contenido del mismo aÃ±adiendo el simbolo menos al
        // inicio
        if (teclaPulsada == 45 && valor.indexOf("-") == -1) {
            $(elem).val("-" + valor)
        }

        // 13 = tecla enter
        // 46 = tecla punto (.)
        // Si el usuario pulsa la tecla enter o el punto y no hay ningun otro
        // punto
        if (teclaPulsada == 13 || (teclaPulsada == 46 && valor.indexOf(".") == -1)) {
            return true;
        }

        // devolvemos true o false dependiendo de si es numerico o no
        return /\d/.test(String.fromCharCode(teclaPulsada));        
    });
    
  
});

// $(document).bind('keypress', function(event){
//     if (event.keyCode == '13')
//     {
//         fnlogin();		
//     }
// });

// function mostrarFormulario(){
//     $("#frmacceso").fadeIn("fast");
//     console.log("listo!");
// }

// function fnlogin(){
//     //frmlogin
//     if(validacionID("frmlogin", "validar")){
//         fnvalidar();
//     }else{
//         alertaRoja("Completa los campos marcados");
//     }
// }

function fnvalidar(){

    $.ajax({
        type: "POST",
        url: "admin/scripts/login",
        data: $("#LoginForm").serialize(),
        success: function (response) {
            console.log(response);
            if(response==0){
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'El usuario o contraseña son incorrectos',
                    footer: '<a href="">¿El problema persiste?</a>'
                })
            }
            if(response==1){
                window.location.href = "admin/";
            }                  
        },
        failure: function (response) {
            fnvalidar();
        },
        error: function (response) {
            
        }
    });
   
}

function is_chrome() {
    var is_chrome = navigator.userAgent.toLowerCase().indexOf('chrome') > -1;
    if (is_chrome == 'false' || is_chrome == 0) {
        //location.href = "error.php";
        alert("Se necesita google chrome");
    }
}	

function validacionID(id, clase) {
    var total = $("#" + id + " ." + clase + ":visible").length;
    var conteo = 0;
    var flag = 1;
    var preflag = 1;

    $("#" + id + " ." + clase + ":visible").each(function () {
        conteo++;
        var idb = $(this).attr("id");
        var valor = $(this).val();
        var tipo = document.getElementById(idb).type;
        if (valor == "" || (tipo == "select-one" && valor == 0)) {
            flag = 0;
            $(this).addClass('alerta');
        }
    });

    if (flag == 0) {
        return false;
    } else {
        return true;
    }
}

hacer = 0;
function alertaRoja(mensaje) {
    if (hacer == 0) {
        $(".cajaAlertaRoja p").html(mensaje);
        $(".cajaAlertaRoja").show();
        $(".cajaAlertaRoja").animate({
            right: "0px"
        }, 200, function () {
            hacer = 1;
            setTimeout(function () {
                escondeAlertas();
            }, 3000);
        });
    }
}

function escondeAlertas() {
    $(".alertas:visible").animate({
        right: "-350px"
    }, 200, function () {
        hacer = 0;
        $(".cajaAlertaRoja").hide();
        $(".cajaAlertaRoja p").empty();
    });
}

function fnlogin(){
    //frmlogin
    if(validacionID("frmlogin", "validar")){
        fnvalidar();
    }else{
        alertaRoja("Completa los campos marcados");
    }
}

function validacionID(id, clase) {
    var total = $("#" + id + " ." + clase + ":visible").length;
    var conteo = 0;
    var flag = 1;
    var preflag = 1;

    $("#" + id + " ." + clase + ":visible").each(function () {
        conteo++;
        var idb = $(this).attr("id");
        var valor = $(this).val();
        var tipo = document.getElementById(idb).type;
        if (valor == "" || (tipo == "select-one" && valor == 0)) {
            flag = 0;
            $(this).addClass('alerta');
        }
    });

    if (flag == 0) {
        return false;
    } else {
        return true;
    }
}

function eliminarImagen(idfoto, foto, page){
    if (confirm("¿Seguro que desea eliminar esta foto?")) {  
        $.ajax({
            type: "POST",
            url: "ajax-delete/"+page,
            data: {id: idfoto, foto: foto},
            success: function () {
                $("#oscuro").hide();
                $("#foto_"+idfoto).fadeOut("fast");
                alertaVerde("Foto eliminada correctamente");
            }
        });
    }    
}

function ConvertirStarImagen(idfoto, idrelacion, page){
    if (confirm("¿Seguro que desea realizar esta operación?")) {   
        $.ajax({
            type: "POST",
            url: "ajax-save/"+page,
            data: {id: idfoto, idrelacion: idrelacion},
            success: function () {
                $(".starimg.letramarilla").removeClass("letramarilla").addClass("letrablanca");
                $("#star_"+idfoto).removeClass("letrablanca").addClass("letramarilla");
                alertaVerde("Foto configurada correctamente");
            }
        });
    }     
}

function filtrarportexto(texto){
    var cant = texto.length;
    if(cant >= 4){
        $("#listadoopciones .opcionsitios").show();
        $("#listadoopciones .opcionsitios:not([rel*='" + texto + "'])").hide();           
    }else{
        $("#listadoopciones .opcionsitios").show();
    }

}

function agregarMaterial(idcategoria, idmaterial){
    $.ajax({
        type: "POST",
        url: "ajax-save/material-categoria-add",
        data: {idcategoria: idcategoria, idmaterial: idmaterial},
        success: function () {
            alertaVerde("Elemento agregado con éxito");
        }
    });    
}

function eliminarMaterial(idcategoria, idmaterial){
    $.ajax({
        type: "POST",
        url: "ajax-delete/material-categoria-eliminar",
        data: {idcategoria: idcategoria, idmaterial: idmaterial},
        success: function () {
            alertaVerde("Elemento eliminado con éxito");
        }
    });     
}

function agregarMaterialBod(idcategoria, idmaterial){
    $.ajax({
        type: "POST",
        url: "ajax-save/material-bodega-add",
        data: {idcategoria: idcategoria, idmaterial: idmaterial},
        success: function () {
            alertaVerde("Elemento agregado con éxito");
        }
    });    
}

function eliminarMaterialBod(idcategoria, idmaterial){
    $.ajax({
        type: "POST",
        url: "ajax-delete/material-bodega-eliminar",
        data: {idcategoria: idcategoria, idmaterial: idmaterial},
        success: function () {
            alertaVerde("Elemento eliminado con éxito");
        }
    });     
}

function borrarArchivoPDF(folio,page,tipo,cont) {
    if (confirm("¿Confirma que desea eliminar esta archivo? \n Los datos eliminados no podran ser recuperados.")) {
        Pace.restart();
        $("#oscuro").show();
        Pace.track(function () {
            Pace.start();
            $.ajax({
                type: "POST",
                url: "ajax-delete/"+page,
                data: "folio="+folio,
                success: function (response) {
                    Pace.stop();
                    $("#oscuro").hide();
                    $("#contenedordelogos").empty();
                    $("#contenedoreliminar").empty();
                    $("#portaimagenesupload").show();
                    $("#subeimagenes").show();
                    if(tipo == 0){
                        $("#foto_"+cont).fadeOut("fast");
                        alertaVerde("Elemento eliminado con éxito");
                    }else{
                        $("#factura_0").fadeOut("fast");
                        $("#contenedoreliminarAnexo").fadeOut("fast");
                        $("#subeimagenesAnexo").removeClass("oculto");
                        alertaVerde("Elemento eliminado con éxito");
                    }
                    
                },
                failure: function (response) {
                    //----some code here-----//
                },
                error: function (response) {
                    //----some code here-----//
                }
            });
        });
    }
}