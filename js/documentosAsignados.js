
function grillaDatos(_cuadro, _tabla, _path)
{
    var _columnas = [
				{ "data": "n"     , visible: true    ,"width": "5%"  },
                                { "data": "alias"     , visible: true    ,"width": "35%"  },
                                { "data": "perfil"     , visible: true     , "width": "26%"   },
				{ "data": "numero"    , "orderable": true ,  "width": "26%"     },
                                { "data": "edit"    , "orderable": true ,  "width": "8%"     }
			];
    var _rutaSend = "code/BL/bl.documentoAsignado.php";
    var _action   = 'listarAsignados';
    if (_cuadro==2)
    {   // etiquetas
        _columnas = [
				{ "data": "n"     , visible: true    ,"width": "4%"  },
                                { "data": "nombre"     , visible: true    ,"width": "30%"  },
                                { "data": "variable"     , visible: true     , "width": "31%"   },
				{ "data": "funcion"    , "orderable": true ,  "width": "26%"     },
                                { "data": "edit"    , "orderable": true ,  "width": "8%"     }
			];
        _rutaSend = "code/BL/bl.perfilMovil.php";
        _action   = "listaretiqueta";
        
    }
    else if (_cuadro==3)
    {   // etiquetas
        _columnas = [
				{ "data": "n"     , visible: true    ,"width": "4%"  },
                                { "data": "nombre"     , visible: true    ,"width": "30%"  },
                                { "data": "documento"     , visible: true     , "width": "58%"   },				
                                { "data": "edit"    , "orderable": true ,  "width": "8%"     }
			];
        _rutaSend = "code/BL/bl.perfilMovil.php";
        _action   = "listarperfil";
        
    }
    else if (_cuadro==4)
    {   // etiquetas
        _columnas = [
				{ "data": "n"     , visible: true    ,"width": "4%"  },
                                { "data": "nombre"     , visible: true    ,"width": "58%"  },
                                { "data": "alias"     , visible: true     , "width": "30%"   },				
                                { "data": "edit"    , "orderable": true ,  "width": "8%"     }
			];        
        _action   = "listardocumentos";
        
    }
    else if (_cuadro==5)
    {   // etiquetas
        _columnas = [
				{ "data": "n"     , visible: true    ,"width": "4%"  },
                                { "data": "nombre"     , visible: true    ,"width": "40%"  },
                                { "data": "otros"     , visible: true     , "width": "48%"   },				
                                { "data": "edit"    , "orderable": true ,  "width": "8%"     }
			];        
        _action   = "listaropciones";
        
    }
    $('#'+_tabla).dataTable({
                "bPaginate": true,
                /*'<"top"i>rt<"bottom"flp><"clear">'*/
                /*"sDom": '<"top"iflp<"clear">>rt<"bottom"iflp<"clear">>',*/
                /*"sDom": '<"top"i>rt<"bottom"flp><"clear">',*/
                /*"sDom": '<"top"flp>rt<"bottom"i><"clear">',*/
                "dom": '<lf<t>ip>',
                "bLengthChange": true,
                "bFilter": true,
                "bSort": true,
                //"scrollY": "340px",
                "sScrollY": "380px",
                "bScrollCollapse": true,                
                "jQueryUI":       true,
                "scrollCollapse": true,
                "bInfo": false,
                "processing": true,                
		"serverSide": true,
                //"paging":         true,
                "language": {
				"url": _path+"js/plugins/datatTable/media/es_ES.txt"
					},
                "ajax" : {
				"url": _path+_rutaSend,
				"data": function ( d ) {
                                        if (_cuadro==1)
                                        {
                                            return $.extend( {}, d, 
                                               {                                              
                                                        "action": _action,                                              
                                                        "cuadro": _cuadro                                                        
                                                   });
                                        }
                                        else
                                        {
                                            return $.extend( {}, d, 
                                               {                                              
                                                        "action": _action,                                              
                                                        "cuadro": _cuadro
                                                   });
                                        }
                                        
					},
                                        "dataSrc": function ( json ) {    
                                            //$(".divTitulo").html(json.titulo);
                                            return json.data;
                                        }   
				},
			"columns": _columnas
            });
}

function cargarDocumento(_path)
{
	$.post(_path+"code/BL/bl.documentoAsignado.php",{ action : "listarDocumento"}, 
		function(data)
		{
			$("#sDocumentoD").html(data);
		});
}

function cargarUsuario(_path)
{
	$.post(_path+"code/BL/bl.documentoAsignado.php",{ action : "listarUsuario"}, 
		function(data)
		{
			$("#sUsuario").html(data);
                        //$("#sUsuario").chosen();
		});
}



function cargarPerfil(_path)
{
	$.post(_path+"code/BL/bl.perfilMovil.php",{ action : "cargarPerfil", documento: $("#sDocumentoD").val()}, 
		function(data)
		{
			$("#sPerfilD").html(data);
		});
}

function fcGrabarDA(_path)
{
	var _documento=$("#sDocumentoD").val();
	var _perfil   =$("#sPerfilD").val();
	var _serie    =$("#txtSerie").val();
	var _numero   =$("#txtNumero").val();
	var _usuario  =$("#sUsuario").val();
	var _msg  = "";
	if (_documento=="0")
	{
		_msg = "Debe seleccionar un documento";
	}
	else if (_perfil=="")
	{
		_msg = "Debe seleccionar un perfil";
	}
	else if (_usuario=="0")
	{
		_msg = "Debe seleccionar un Usuario";
	}
	else if (_serie=="")
	{
		_msg = "Debe ingresar una serie";
	}
	else if (_numero=="")
	{
		_msg = "Debe ingresar el numero";
	}
	if (_msg!="")
	{
		bootbox.alert(_msg);
	}
	else
	{
		bootbox.confirm("Esta seguro de grabar la asignacion?", 
			function(result)
			{
				$.post(_path+"code/BL/bl.documentoAsignado.php",{ action : "asignarDocumentoPerfil" , 
										documento : _documento , perfil : _perfil , serie : _serie , 
										numero : _numero , usuarioa : _usuario},
					function(data)
					{

					}
					);
		 	});
	}
}