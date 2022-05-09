function universalLoad(elem){
    var valores = $(elem).data("valores");
    var carpeta = $(elem).data("carpeta");
    var page = $(elem).data("page");
    var load = $(elem).data("load");
    var postload = $(elem).data("postload");
    var id = $(elem).data("id");
    var frm = $(elem).data("form");
    var regresar = $(elem).data("regresar");

    if(frm != ''){

        $.ajax({
            type: "POST",
            url: carpeta+"/" + page,
            data: $("#"+frm).serialize()+"&postload="+postload+"&id="+id+"&regresar="+regresar+"&"+valores,
            success: function (response) {
                $("#"+load).html(response);
            },
            failure: function (response) {
                //----some code here-----//
            },
            error: function (response) {
                //----some code here-----//
            }
        });
    }else{
        $.ajax({
            type: "POST",
            url: carpeta+"/" + page+"?"+valores,
            data: {id: id, postload: postload, regresar: regresar},
            success: function (response) {
                $("#"+load).html(response);
            },
            failure: function (response) {
                //----some code here-----//
            },
            error: function (response) {
                //----some code here-----//
            }
        });
    }
}
function getPageMenu(page) {
    $.ajax({
        type: "POST",
        url: "ajax-show/" + page,
        success: function (response) {
            $("#contenedor").html(response);
        },
        failure: function (response) {

        },
        error: function (response) {

        }
    });
}
function openPopup(elem, width, height) {
    var form = $(elem).data("form");
    var page = $(elem).data("page");
    var returnpage = $(elem).data("returnpage");
    var divload = $(elem).data("div");
    var vars = $(elem).data("vars");

    $('html,body').css('overflow', 'hidden');
    $("#portapopups").show();

    if(form === ''){
        $.ajax({
            type: "POST",
            async: true,
            url: "ajax-popups/" + page,
            data: vars+"&returnpage="+returnpage+"&div="+divload,
            success: function (response) {
                popuptamano(width, height);
                mostrarpopup(response);
                $("#frmPopup .focus").focus();
            },
            failure: function (response) {
                //----some code here-----//
            },
            error: function (response) {
                //----some code here-----//
            }
        });
    }else{
        if(vars===''){
            $.ajax({
                type: "POST",
                async: true,
                url: "ajax-popups/" + page,
                data: $("#" + form).serialize()+"&returnpage="+returnpage+"&div="+divload,
                success: function (response) {
                    popuptamano(width, height);
                    mostrarpopup(response);
                    $("#frmPopup .focus").focus();
                },
                failure: function (response) {
                    //----some code here-----//
                },
                error: function (response) {
                    //----some code here-----//
                }
            });
        }else{

            $.ajax({
                type: "POST",
                async: true,
                url: "ajax-popups/" + page,
                data: $("#" + form).serialize()+"&"+vars+"&returnpage="+returnpage+"&div="+divload,
                success: function (response) {
                    popuptamano(width, height);
                    mostrarpopup(response);
                    $("#frmPopup .focus").focus();
                },
                failure: function (response) {
                    //----some code here-----//
                },
                error: function (response) {
                    //----some code here-----//
                }
            });
        }
    }
}

function openPopupEdit(elem, width, height) {
    var form = $(elem).data("form");
    var page = $(elem).data("page");
    var returnpage = $(elem).data("returnpage");
    var divload = $(elem).data("div");
    var vars = $(elem).data("vars");
    var id = $(elem).data("id");

    $('html,body').css('overflow', 'hidden');
    Pace.restart();
    $("#portapopups").show();

    if(form === ''){
        Pace.track(function () {
            Pace.start();
            $.ajax({
                type: "POST",
                async: true,
                url: "ajax-popups/" + page,
                data: vars+"&returnpage="+returnpage+"&div="+divload+"&id="+id,
                success: function (response) {
                    Pace.stop();
                    popuptamano(width, height);
                    mostrarpopup(response);
                    $("#frmPopup .focus").focus();
                },
                failure: function (response) {
                    //----some code here-----//
                },
                error: function (response) {
                    //----some code here-----//
                }
            });
        });
    }else{
        if(vars===''){
            Pace.track(function () {
                Pace.start();
                $.ajax({
                    type: "POST",
                    async: true,
                    url: "ajax-popups/" + page,
                    data: $("#" + form).serialize()+"&returnpage="+returnpage+"&div="+divload+"&id="+id,
                    success: function (response) {
                        Pace.stop();
                        popuptamano(width, height);
                        mostrarpopup(response);
                        $("#frmPopup .focus").focus();
                    },
                    failure: function (response) {
                        //----some code here-----//
                    },
                    error: function (response) {
                        //----some code here-----//
                    }
                });
            });
        }else{
            Pace.track(function () {
                Pace.start();
                $.ajax({
                    type: "POST",
                    async: true,
                    url: "ajax-popups/" + page,
                    data: $("#" + form).serialize()+"&"+vars+"&returnpage="+returnpage+"&div="+divload+"&id="+id,
                    success: function (response) {
                        Pace.stop();
                        popuptamano(width, height);
                        mostrarpopup(response);
                        $("#frmPopup .focus").focus();
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
}
function savePopup(elem) {
    var postpagina = $(elem).data("load");
    var page = $(elem).data("page");
    var div = $(elem).data("div");

    if (validacionID("frmPopup", "validar")) {
        $.ajax({
            type: "POST",
            url: "ajax-save/" + page,
            data: $("#frmPopup").serialize(),
            success: function (response) {
                alertaVerde('Guardado con exito!');
                simpleload(div, postpagina);
                cerrarpopup();
                $('html,body').css('overflow', 'auto');
            },
            failure: function (response) {
                //----some code here-----//
            },
            error: function (response) {
                //----some code here-----//
            }
        });
    } else {
        alertaRoja("Completa los campos marcados");
    }
}

function importarExcel(elem) {
    var formData = new FormData(document.getElementById("frmPopup"));
    // var frm = $(formdata).data("form");
    var postpagina = $(elem).data("load");
    var page = $(elem).data("page");
    var div = $(elem).data("div");
    $.ajax({
        url: 'ajax-save/'+page,
        type: 'post',
        data: formData,
        dataType: "html",
        contentType: false,
        processData: false,
        success: function (response) {
            console.log(response);
            alertaVerde(response);
            simpleload(div, postpagina);
            cerrarpopup();
            $('html,body').css('overflow', 'auto');
        }
    });
}

function simpleload(div, pagina) {

    var page = pagina.split("/");
    tamano = page.length;

    if (tamano == 1) {
        var url = "ajax-show/" + pagina;
    } else {
        var url = page["0"] + "/" + page["1"];
    }

    $.ajax({
        type: "POST",
        url: url,
        success: function (response) {
            $("#" + div).html(response);
        },
        failure: function (response) {
            //----some code here-----//
        },
        error: function (response) {
            //----some code here-----//
        }
    });
    
}

function editPopup(elem) {
    var postpagina = $(elem).data("load");
    var page = $(elem).data("page");
    var div = $(elem).data("div");
    var id = $(elem).data("id");

    if (validacionID("frmPopup", "validar")) {
        $.ajax({
            type: "POST",
            url: "ajax-save/" + page,
            data: $("#frmPopup").serialize()+"&id="+id,
            success: function (response) {
                simpleload(div, postpagina);
                cerrarpopup();
                $('html,body').css('overflow', 'auto');
            },
            failure: function (response) {
                //----some code here-----//
            },
            error: function (response) {
                //----some code here-----//
            }
        });
    } else {
        alertaRoja("Completa los campos marcados");
    }
}