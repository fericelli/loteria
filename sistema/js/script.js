$(document).on("ready",iniciarpagina);

function iniciarpagina(){
		
	var alto = window.innerHeight;
	$(".contenedor-principal").css("height",alto);
	
	$("#ingresar").on("click",function(){
		if($("#usuario").val()==""){
			$(".usuario").css("display","flex");
			$("#usuario").css("border","solid 1px red");
			setTimeout(function(){
				$(".usuario").css("display","none");
				$("#usuario").css("border","");
			},1000);
		}
		
		if($("#usuario").val()!=""){
			$.ajax({
				type:'POST',
				url: 'php/sesion.php',
				data:({usuario:$("#usuario").val(), contraseña:$("#contraseña").val()}),
				success: function(respuesta){
					if(respuesta=="no registrado"){
						$(".noregistrado").css("display","flex");
						$("#usuario").val("");
						setTimeout(function(){
							$(".noregistrado").css("display","none");
						},1000);
					}else if(respuesta=="contraseña incorrecta"){
						$(".contraseñaincorrecta").css("display","flex");
						$("#contraseña").val("");
						setTimeout(function(){
							$(".contraseñaincorrecta").css("display","none");
						},1000);						
					}else if(respuesta=="bloqueado"){
						$(".usuariobloqueado").css("display","flex");
						$("#usuario").val("");
						$("#contraseña").val("");
						setTimeout(function(){
							$(".usuariobloqueado").css("display","none");
						},1000);
					}else{
						$("body").html(respuesta);
					}
				},
				complete: function(respuesta){
					sesion();
				}
			})
		}
	})
}
function sesion(){
	var alto = window.innerHeight;
	var ancho = window.innerWidth;
	$(".contenedor-principal").css("height",alto);
	$(".menu-lateral").css("height",alto-40);
	$("#contenido").css("height",alto-40);
	$(".informacion").css("height",alto-40);
	$("#verlistadousuarios").css("height",alto-50);
	$("#contenedoragregarcontraseña").css("height",alto);
	index = $(".menu-lateral .opcion").length;
	$("#menu .opcion").on("click",function(){
		$(".informacion").css("display","none");
		if($(this).hasClass("activaropcionmenuprincipal")==false){
			$("#menu .opcion").removeClass("activaropcionmenuprincipal");
			$(this).addClass("activaropcionmenuprincipal");	
			a = $(this).index();
			$(".menu-lateral").css("display","none");
			$(".menu-lateral").eq(a).css("display","flex");
		}else{
			$(this).removeClass("activaropcionmenuprincipal");
			$(".menu-lateral").css("display","none");
		}
		$("input").val("");
	})
	$(".opcionlateral").on("click",function(){
		$(".menu-lateral").css("display","none");
		$(".informacion").css("display","none");
		$("#menu .opcion").removeClass("activaropcionmenuprincipal");
		$(".informacion").eq($(this).index()).css("display","flex");
	})
	$("#seleccionarloteria").change(function(){
		$("#seleccionarloteria option:selected").each(function() {
			loteria = $(this).attr("id");
		});
		if(loteria=="todos"){
			$("#verlistado").css("display","none");
			$("#seleccionarsorteos").html("<option id='todos'>Seleccione Un Sorteo</option>");
		}else{
			$.ajax({
				type:'GET',
				url: 'php/loterias.php?loteria='+loteria+'',
				success: function(respuesta){
					if(respuesta=="error"){
						$(".errorloteria").css("display","flex");
					}else{
						$("#seleccionarsorteos").html(respuesta.substr(0,respuesta.indexOf("-")));
						$("#verlistado").html(respuesta.substr(respuesta.indexOf("-")+1));
						$("#verlistado").css("display","flex");
						
					}
				},
				complete: function(respuesta){
					setTimeout(function(){
						$(".errorloteria").css("display","none");
					},2000);
					
				}
			})
		}
	})
	$("#cambiarclave").on("click",function(){
		$.ajax({
				type:'POST',
				url: 'php/cambiarclave.php?usuario='+$("#usuario").text()+'',
				data: {clave:$("#contrasenanueva").val()},
				success: function(respuesta){
					if(respuesta=="clave cambiada"){
						$(".mensajeclave").css("display","flex");
					}
				},
				complete: function(){
					setTimeout(function(){
						$("#contenedoragregarcontrasena").css("display","none");
					},3000);
				}
			})
	})
	verfechaspendientes();
	vericificarmac();
	apostar();
	agregarbanca();
	verlistadobanca();
	agregarrecolector();
	verlistadorecolectores();
	agregarloteria();
	veragregarjugadas();
	agregarjugada();
	verloterias();
	agregaesorteo();
	verformulariosorteo();
	veradministrarsorteo();
	vermodificarporcentageganancia();
	modificarporcentagedeganancias();
	seleccionarporecentage();
	salirmodificarporcentageganancia();
	veradministrarjugadas();
	cambiarfechainicio();
	buscarcontroldinero();
	cambiarfechainiciorecolector();
	buscarcontroldinerorecolector();
	buscarpremios();
	cambiarfechainiciobanca();
	buscardinerocontrolbanca();
	actualizarsistema();
	vertiketganadores();
	cancelartiket();
}

//funcciones de admisistrador
function agregarbanca(){
	$("#agregarbanca").on("click",function(){
		if($("#banca").val()==""){
			$(".banca").css("display","flex");
			setTimeout(function(){
				$(".banca").css("display","none");
			},1000);
		}
		if($("#usuariobanca").val()==""){
			$(".usuario").css("display","flex");
			setTimeout(function(){
				$(".usuario").css("display","none");
			},1000);
		}
		if($("#porcentajebanca").val()==""){
			$(".porcentajebanca").css("display","flex");
			setTimeout(function(){
				$(".porcentajebanca").css("display","none");
			},1000);
		}
		if($("#porcentajebanca").val()!="" && $.isNumeric($("#porcentajebanca").val())==false){
			$(".porcentajebancanumero").css("display","flex");
			$("#porcentajebanca").val("");
			setTimeout(function(){
				$(".porcentajebancanumero").css("display","none");
			},1000);
		}
		if($("#telefonobanca").val()==""){
			$(".telefonobanca").css("display","flex");
			setTimeout(function(){
				$(".telefonobanca").css("display","none");
			},1000);
		}
		if($("#banca").val()!="" && $("#usuariobanca").val()!="" && $("#porcentajebanca").val()!="" && $.isNumeric($("#porcentajebanca").val())!=false && $("#telefonobanca").val()!=""){
			$.ajax({
				type:'POST',
				url: 'php/agregarbanca.php?usuario='+$("#usuario").text()+'',
				data:({banca:$("#banca").val(),usuarionevo:$("#usuariobanca").val(),porcentajeganancia:$("#porcentajebanca").val(),mac:$("#mac").val(),telefono:$("#telefonobanca").val()}),
				success: function(respuesta){
					console.log(respuesta);
					if(respuesta == "existe banca"){
						$(".bancaregistrada").css("display","flex");
						$("#banca").val("");
					}else if(respuesta=="existe usuario"){
						$(".usuarioregistrado").css("display","flex");
						$("#usuariobanca").val("");
					}else if(respuesta == "registro exitoso"){
						$(".mensajeagregarbanca").css("display","flex");
						$("#usuariobanca").val("");
						$("#banca").val("");
						$("#porcentajebanca").val("");
						$("#mac").val("");
						$("#telefonobanca").val("");
					}else if(respuesta == "mac exitente"){
						$(".macexiste").css("display","flex");
						$("#mac").val("");
					}else{
						alert("No puede ser mayor ni igual a "+respuesta);
						$("#porcentajebanca").val("");
					}
				},
				complete: function(respuesta){
					setTimeout(function(){
						$(".mensajeagregarbanca").css("display","none");
						$(".bancaregistrada").css("display","none");
						$(".usuarioregistrado").css("display","none");
						$(".macexiste").css("display","none");
					},3000);
				}
			})
		}
		
	})
}
function verlistadobanca(){
	$("#buscarbanca").keyup(function(){
		$.ajax({
			type:'POST',
			url: 'php/verbanca.php?usuario='+$("#usuario").text()+'',
			data:({taquilla:$("#buscarbanca").val()}),
			beforeSend:function(){
				$("#contenedor-banca .contenedor div").remove();
				$("#cargabanca").css("display","flex");
			},
			complete: function(respuesta){
				seleccionarbanca();
				eliminarbanca();
				bloquearbanca();
				desbloquearbanca();
				reiniciarclavebanca();
				$("#cargabanca").css("display","none");
			},
			success: function(respuesta){
				$("#contenedor-banca .contenedor").html(respuesta);
			}
		})
	})
}
function seleccionarbanca(){
	$(".contenedor-banca").on("click",function(){
		if($(this).hasClass("activarbotonbanca")==true){
			$(this).removeClass("activarbotonbanca");
			$(".botonescontrolbanca").css("display","none");
		}else{
			$(".contenedor-banca").removeClass("activarbotonbanca");
			$(this).addClass("activarbotonbanca");
			$(".botonescontrolbanca").css("display","none");
			$(".botonescontrolbanca").eq($(".contenedor-banca").index(this)).css("display","flex");	
		}
	})
} 
function eliminarbanca(){
	$(".eliminarbanca").on("click",function(){
		$.ajax({
			type:'POST',
			url: 'php/eliminarbanca.php?usuariobanca='+$(this).attr("id")+'&usuario='+$("#usuario").text()+'',
			data:({taquilla:$("#buscarbanca").val()}),
			success: function(respuesta){
				$("#contenedor-banca .contenedor").html(respuesta);
			},
			complete: function(respuesta){
				seleccionarbanca();
				eliminarbanca();
				bloquearbanca();
				desbloquearbanca();
				reiniciarclavebanca();
			}
		})
	})
}
function bloquearbanca(){
	$(".bloqueobancas").on("click",function(){
		
		$.ajax({
			type:'POST',
			url: 'php/bloquearbanca.php?usuariobanca='+$(this).attr("id")+'&usuario='+$("#usuario").text()+'',
			data:({taquilla:$("#buscarbanca").val()}),
			success: function(respuesta){
				$("#contenedor-banca .contenedor").html(respuesta);
			},
			complete: function(respuesta){
				seleccionarbanca();
				eliminarbanca();
				bloquearbanca();
				desbloquearbanca();
				reiniciarclavebanca();
			}
		})
	})
}
function desbloquearbanca(){
	$(".desbloqueobancas").on("click",function(){
		$.ajax({
			type:'POST',
			url: 'php/desbloquearbanca.php?usuariobanca='+$(this).attr("id")+'&usuario='+$("#usuario").text()+'',
			data:({taquilla:$("#buscarbanca").val()}),
			success: function(respuesta){
				$("#contenedor-banca .contenedor").html(respuesta);
			},
			complete: function(respuesta){
				seleccionarbanca();
				eliminarbanca();
				bloquearbanca();
				desbloquearbanca();
				reiniciarclavebanca();
			}
		})
	})
}
function reiniciarclavebanca(){
	$(".reiniciarclave").on("click",function(){
		$.ajax({
			type:'POST',
			url: 'php/reiniciarclave.php?usuariobanca='+$(this).attr("id")+'&usuario='+$("#usuario").text()+'',
			data:({taquilla:$("#buscarbanca").val()}),
			success: function(respuesta){
				$("#contenedor-banca .contenedor").html(respuesta);
			},
			complete: function(respuesta){
				seleccionarbanca();
				eliminarbanca();
				bloquearbanca();
				desbloquearbanca();
				reiniciarclavebanca();
			}
		})
	})
}
function agregarrecolector(){
	$("#agregarrecolector").on("click",function(){
		if($("#recolector").val()==""){
			$(".recolector").css("display","flex");
			setTimeout(function(){
				$(".recolector").css("display","none");
			},2000);
		}
		if($("#usuariorecolector").val()==""){
			$(".usuario").css("display","flex");
			setTimeout(function(){
				$(".usuario").css("display","none");
			},2000);
		}
		if($("#porcentajerecolector").val()==""){
			$(".porcentajerecolector").css("display","flex");
			setTimeout(function(){
				$(".porcentajerecolector").css("display","none");
			},2000);
		}
		if($("#porcentajerecolector").val()!="" && $.isNumeric($("#porcentajerecolector").val())==false){
			$(".porcentajerecolectornumero").css("display","flex");
			setTimeout(function(){
				$(".porcentajerecolectornumero").css("display","none");
			},2000);
		}
		if($("#telefonorecolector").val()==""){
			$(".telefonorecolector").css("display","flex");
			setTimeout(function(){
				$(".telefonorecolector").css("display","none");
			},2000);
		}
		if($("#recolector").val()!="" && $("#usuariorecolector").val()!="" && $("#porcentajerecolector").val()!="" && $.isNumeric($("#porcentajerecolector").val())!=false && $("#telefonorecolector").val()!=""){
			$.ajax({
				type:'POST',
				url: 'php/agregarrecolector.php?usuario='+$("#usuario").text()+'',
				data:({recolector:$("#recolector").val(),usuarionevo:$("#usuariorecolector").val(),porcentageganancia:$("#porcentajerecolector").val(),telefono:$("#telefonorecolector").val()}),
				
				success: function(respuesta){
					if(respuesta == "existe recolector"){
						$(".recolectorregistrado").css("display","flex");
						$("#recolector").val("");
					}
					if(respuesta=="existe usuario"){
						$(".usuarioregistrado").css("display","flex");
						$("#usuariorecolector").val("");
					}
					if(respuesta == "registro exitoso"){
						$(".mensajeagregarrecolector").css("display","flex");
						$("#usuariorecolector").val("");
						$("#recolector").val("");
						$("#porcentajerecolector").val("");
						$("#telefonorecolector").val("");
					}
				},
				complete: function(respuesta){
					setTimeout(function(){
						$(".mensajeagregarrecolector").css("display","none");
						$(".recolectorregistrado").css("display","none");
						$(".usuarioregistrado").css("display","none");
					},3000)
				}
			})
		}
	})
}
function verlistadorecolectores(){
	$("#buscarrecolector").keyup(function(){
		$.ajax({
			type:'POST',
			url: 'php/verrecolectores.php',
			data:({recolector:$("#buscarrecolector").val()}),
			beforeSend:function(){
				$("#contenedor-recolector .contenedor div").remove();
				$("#cargarecolector").css("display","flex");
			},
			success: function(respuesta){
				$("#contenedor-recolector .contenedor").html(respuesta);
			},
			complete: function(respuesta){
				seleccinarrecolector();
				eliminarrecolector();
				bloquearrecolector();
				desbloquearrecolector();
				reiniciarclaverecolector();
				$("#cargarecolector").css("display","none");
			}
		})
	})
}
function seleccinarrecolector(){
	$(".contenedor-recolector").on("click",function(){
		if($(this).hasClass("activarbotonrecolector")==true){
			$(this).removeClass("activarbotonrecolector");
			$(".botonescontrolrecolector").css("display","none");
		}else{
			$(".contenedor-recolector").removeClass("activarbotonrecolector");
			$(this).addClass("activarbotonrecolector");
			$(".botonescontrolrecolector").css("display","none");
			$(".botonescontrolrecolector").eq($(".contenedor-recolector").index(this)).css("display","flex");	
		}
	})
}
function eliminarrecolector(){
	$(".eliminarrecolector").on("click",function(){
		$.ajax({
			type:'POST',
			url:'php/eliminarrecolector.php?usuario='+$(this).attr("id")+'',
			data:({recolector:$("#buscarrecolector").val()}),
			success: function(respuesta){
				$("#contenedor-recolector .contenedor").html(respuesta);
			},
			complete:function(){
				seleccinarrecolector();
				eliminarrecolector();
				bloquearrecolector();
				desbloquearrecolector();
				reiniciarclaverecolector();
			}
		})
	})
}
function bloquearrecolector(){
	$(".bloqueorecolector").on("click",function(){
		$.ajax({
			type:'POST',
			url:'php/bloquearecolector.php?usuariobloquear='+$(this).attr("id")+'',
			data:({recolector:$("#buscarrecolector").val()}),
			success: function(respuesta){
				$("#contenedor-recolector .contenedor").html(respuesta);
			},
			complete:function(){
				seleccinarrecolector();
				eliminarrecolector();
				bloquearrecolector();
				desbloquearrecolector();
				reiniciarclaverecolector();
			}
		})
	})
}
function desbloquearrecolector(){
	$(".desbloqueorecolector").on("click",function(){
		$.ajax({
			type:'POST',
			url:'php/desbloquearrecolector.php?usuariodesbloquear='+$(this).attr("id")+'',
			data:({recolector:$("#buscarrecolector").val()}),
			success: function(respuesta){
				$("#contenedor-recolector .contenedor").html(respuesta);
			},
			complete:function(){
				seleccinarrecolector();
				eliminarrecolector();
				bloquearrecolector();
				desbloquearrecolector();
				reiniciarclaverecolector();
			}
		})
	})
}
function reiniciarclaverecolector(){
	$(".reiniciarclaverecolector").on("click",function(){
		$.ajax({
			type:'POST',
			url:'php/reiniciarclaverecolector.php?usuario='+$(this).attr("id")+'',
			data:({recolector:$("#buscarrecolector").val()}),
			success: function(respuesta){
				$("#contenedor-recolector .contenedor").html(respuesta);
			},
			complete:function(){
				seleccinarrecolector();
				eliminarrecolector();
				bloquearrecolector();
				desbloquearrecolector();
				reiniciarclaverecolector();
			}
		})
	})
}
function agregarloteria(){
	$("#agregarloteria").on("click",function(){
		if($("#loteria").val()==""){
			$(".loteria").css("display","flex");
			setTimeout(function(){
				$(".loteria").css("display","none");
			},2000);
		}
		if($("#valorapuesta").val()==""){
			$(".valorapuesta").css("display","flex");
			setTimeout(function(){
				$(".valorapuesta").css("display","none");
			},2000);
		}
		if($.isNumeric($("#valorapuesta").val())==false && $("#valorapuesta").val()!=""){
			$(".valornumerico").css("display","flex");
			setTimeout(function(){
				$(".valornumerico").css("display","none");
			},2000);
		}
		if($("#diascaduca").val()==""){
			$(".caducaciontiket").css("display","flex");
			setTimeout(function(){
				$(".caducaciontiket").css("display","none");
			},2000);
		}
		if($.isNumeric($("#diascaduca").val())==false && $("#diascaduca").val()!=""){
			$(".valornumericotiket").css("display","flex");
			setTimeout(function(){
				$(".valornumericotiket").css("display","none");
			},2000);
		}
		if($("#loteria").val()!="" && $("#valorapuesta").val()!="" && $.isNumeric($("#valorapuesta").val())!=false && $.isNumeric($("#diascaduca").val())!=false && $("#diascaduca").val()!=""){
			$.ajax({
				type:'POST',
				url:'php/agragarloteria.php',
				data:{loteria:$("#loteria").val(),valorapuesta:$("#valorapuesta").val(),diascaducacion:$("#diascaduca").val()},
				success:function(respuesta){
					console.log(respuesta);
					if(respuesta=="existe"){
						$(".loteriaregistrada").css("display","flex");
						$("#loteria").val("");
						setTimeout(function(){
							$(".loteriaregistrada").css("display","none");
						},2000);
					}
					if(respuesta=="registro"){
						$(".mensajeagregarloteria").css("display","flex");
						$("#loteria").val("");
						$("#valorapuesta").val("");
						$("#diascaduca").val("");
						setTimeout(function(){
							$(".mensajeagregarloteria").css("display","none");
						},2000);
					}
				}
			})
		}
		
	})
}
function verloterias(){
	$(".administrarloteria").on("click",function(){
		$.ajax({
			url:'php/verloterias.php',
			success:function(respuesta){
				$(".respuestaloterias").html(respuesta);
			},
			complete:function(){
				seleccionarloterias();
				seleccionarmodificacionvalorapuesta();
				salirmodificarvalorapuesta();
				modificarvalorapuesta();
				eliminarloteria();
				paginacionloteria();
			}
		})
	})
}
function seleccionarloterias(){
	$(".contenedor-loteria").on("click",function(){
		$(".modificar-loteria").css("display","none");
		if($(this).hasClass("activarloteria")==true){
			$(this).removeClass("activarloteria");
			$(".botonesloterias").css("display","none");
		}else{
			$(".contenedor-loteria").removeClass("activarloteria");
			$(this).addClass("activarloteria");
			$(".botonesloterias").css("display","none");
			$(".botonesloterias").eq($(".contenedor-loteria").index(this)).css("display","flex");	
		}
	})
}
function seleccionarmodificacionvalorapuesta(){
	$(".modificarloteria").on("click",function(){
		console.log($(".modificarloteria").index(this));
		$(".contenedor-loteria").removeClass("activarloteria");
		$(".botonesloterias").css("display","none");
		$(".modificar-loteria").css("display","flex");
		
		$(".modificarvalorapuesta").css("display","none");
		$(".modificarvalorapuesta").eq($(".modificarloteria").index(this)).css("display","flex");
	})
}
function salirmodificarvalorapuesta(){
	$(".salirmodificarvalorapuesta").on("click",function(){
		$(".modificar-loteria").css("display","none");
		$(".modificarvalorapuesta").css("display","none");
	})
}
function modificarvalorapuesta(){
	$(".modificarvalorapuesta").on("click",function(){
		if($("#valorapuestanuevo").val()==""){
			$(".conpletecampoapuesta").css("display","flex");
			setTimeout(function(){
				$(".conpletecampoapuesta").css("display","none");
			},2000);
		}
		if($.isNumeric($("#valorapuestanuevo").val())==false && $("#valorapuestanuevo").val()==""){
			$(".conpletecampoapuestavalornumerico").css("display","flex");
			setTimeout(function(){
				$(".conpletecampoapuestavalornumerico").css("display","none");
			},2000);
		}
		if($("#valorapuestanuevo").val()!="" && $("#valorapuestanuevo").val()){
			$.ajax({
				type:'POST',
				url:'php/modificarvalorapuesta.php?loteria='+$(this).attr("id")+'',
				data:{valor:$("#valorapuestanuevo").val()},
				success:function(respuesta){
					$(".mensajevalorapuesta").css("display","flex");
					setTimeout(function(){
						$(".respuestaloterias").html(respuesta);	
					},2000);
				},
				complete:function(){
					setTimeout(function(){
						seleccionarloterias();
						seleccionarmodificacionvalorapuesta();
						salirmodificarvalorapuesta();
						modificarvalorapuesta();
						eliminarloteria();	
						paginacionloteria();					
					},2100);
					
				}
			})
		}
	})
}
function eliminarloteria(){
	$(".eliminarloteria").on("click",function(){
		$.ajax({
			type:'GET',
			url:'php/eliminarloteria.php?loteria='+$(this).attr("id")+'',
			success:function(respuesta){
				if(respuesta!=""){
					$(".respuestaloterias").html(respuesta);
				}
				
			},
			complete:function(respuesta){
				if(respuesta!=""){
					setTimeout(function(){
						$(".mensajeloteria").css("display","none");
						seleccionarloterias();
						seleccionarmodificacionvalorapuesta();
						salirmodificarvalorapuesta();
						modificarvalorapuesta();
						eliminarloteria();
						paginacionloteria();
					},1000);
				}					
			}
		})
	})
}
function paginacionloteria(){
	$(".botonloteriasiguiete").on("click",function(){
		$.ajax({
			type:'GET',
			url:'php/paginacionloteria.php?pagina='+$(this).attr("id")+'',
			success: function(respuesta){
				$(".respuestaloterias").html(respuesta);
			},
			complete: function(){
				seleccionarloterias();
				seleccionarmodificacionvalorapuesta();
				salirmodificarvalorapuesta();
				modificarvalorapuesta();
				eliminarloteria();
				paginacionloteria();
			}
		})
		
	})
	$(".botonloteriaaterior").on("click",function(){
		$.ajax({
			type:'GET',
			url:'php/paginacionloteria.php?pagina='+$(this).attr("id")+'',
			success: function(respuesta){
				$(".respuestaloterias").html(respuesta);
			},
			complete: function(){
				seleccionarloterias();
				seleccionarmodificacionvalorapuesta();
				salirmodificarvalorapuesta();
				modificarvalorapuesta();
				eliminarloteria();
				paginacionloteria();
			}
		})
	})
}
function veragregarjugadas(){
	$(".agragarjugadas").on("click",function(){
		$.ajax({
			url:'php/veragregarjugadas.php',
			success:function(respuesta){
				$("#cargajugada").html(respuesta);
			},
			complete: function(){
				agregarjugada();
			}
		})
	})
}
function agregarjugada(){
	$("#agregarjugada").on("click",function(){
		$("#loteriass option:selected").each(function() {
			loteria = $(this).attr("id");
		});
		$("#tipojugada option:selected").each(function(){
			tipodejugada = $(this).attr("id");
		});
		var formulario = $("#cargajugada"); 
		var archivos = new FormData();
		for(var i = 0; i < (formulario.find("input[type=file]").length); i++){
			archivos.append((formulario.find('input[type="file"]:eq('+i+')').attr("name")),((formulario.find('input[type="file"]:eq('+i+')')[0]).files[0]));
		}
		if(loteria=="todos"){
			$(".seleccionloteria").css("display","flex");
			setTimeout(function(){
				$(".seleccionloteria").css("display","none");
			},2000);
		}
		if(tipodejugada=="todos"){
			$(".selecciontipojugada").css("display","flex");
			setTimeout(function(){
				$(".selecciontipojugada").css("display","none");
			},2000);
		}
		if($("#nombrejugada").val()==""){
			$(".ingresejugada").css("display","flex");
			setTimeout(function(){
				$(".ingresejugada").css("display","none");
			},2000);
		}
		if($("#foto-registro").val()==""){
			$(".seleccionimagen").css("display","flex");
			setTimeout(function(){
				$(".seleccionimagen").css("display","none");
			},2000);
		}
		if($("#codigojugada").val()==""){
			$(".ingresecodigo").css("display","flex");
			setTimeout(function(){
				$(".ingresecodigo").css("display","none");
			},2000);
		}
		if($("#codigojugada").val()!="" && $.isNumeric($("#codigojugada").val())==false){
			$(".codigojugadanumero").css("display","flex");
			setTimeout(function(){
				$(".codigojugadanumero").css("display","none");
			},2000);
		}
		if(loteria!="todos" && tipodejugada!="todos" && $("#nombrejugada").val()!="" && $("#foto-registro").val()!="" && $("#codigojugada").val()!="" && $.isNumeric($("#codigojugada").val())!=false){
			$.ajax({
			type:'POST',
			url:'php/agregarjugada.php?loteria='+loteria+'&jugada='+$("#nombrejugada").val()+'&codigojugada='+$("#codigojugada").val()+'&tipodejugada='+tipodejugada+'',
			contentType:false,
			data: archivos,
			processData:false,
			data: archivos,
			success: function(respuesta){
				if(respuesta=='bien'){
					$(".mensajeagregarloteria").css("display","flex");
				}else if(respuesta=='exite jugada'){
					$(".jugadaexiste").css("display","flex");
				}else if(respuesta=='exite codigo'){
					$(".codigoexiste").css("display","flex");
				}else{
					$(".mensjeerror").css("display","flex");
				}
			},
			complete: function(){
				$("#nombrejugada").val("");
				$("#foto-registro").val("");
				$("#codigojugada").val("");
				$("#foto-registro").replaceWith($("#foto-registro").clone(true));
				scroll4();
				setTimeout(function(){
					$(".mensjeerror").css("display","none");
					$(".mensajeagregarloteria").css("display","none");
					$(".jugadaexiste").css("display","none");
					$(".codigoexiste").css("display","none");
				},2000);
			}
		})
		}
		
	})
}
function veradministrarjugadas(){
	$(".administrarjugada").on("click",function(){
		$.ajax({
			url:'php/veradministrarjugadas.php',
			success:function(respuesta){
				$(".respuestajugadas").html(respuesta);
			},
			complete:function(){
				selecionarloteriajugada();
			}
		})
	})
	
}
function selecionarloteriajugada(){
	$("#seleccloteria").change(function(){
		$("#seleccloteria option:selected").each(function() {
			loteria = $(this).attr("id");
		});
		$.ajax({
			type:'GET',
			url:'php/selecionarloteriajugada.php?loteria='+loteria+'',
			success:function(respuesta){
				
				$("#conetenedor-verjugadas .contenedor").html(respuesta);
			},
			complete:function(){
				
				seleccionarjugada();
				eliminarjugada();
				paginacionjugadas();
			}
		})
	})
}
function seleccionarjugada(){
	$(".contenedor-jugada").on("click",function(){
		if($(this).hasClass("activarjugada")==true){
			$(this).removeClass("activarjugada");
			$(".botonesjugadas").css("display","none");
		}else{
			$(".contenedor-jugada").removeClass("activarjugada");
			$(this).addClass("activarjugada");
			$(".botonesjugadas").css("display","none");
			$(".botonesjugadas").eq($(".contenedor-jugada").index(this)).css("display","flex");	
		}
	})
}
function eliminarjugada(){
	$(".eliminarjugada").on("click",function(){
		$("#seleccloteria option:selected").each(function() {
			loteria = $(this).attr("id");
		});
		$.ajax({
			type:'GET',
			url:'php/eliminarjugada.php?variables='+$(this).attr("id")+'&loteria='+loteria+'',
			success:function(respuesta){
				console.log(respuesta);
				$("#conetenedor-verjugadas .contenedor").html(respuesta);
			},
			complete:function(){
				seleccionarjugada();
				eliminarjugada();
				paginacionjugadas();
				setTimeout(function(){
					$(".mensajejugada").css("display","none");
				},3000)
			}
		})
	})
}
function paginacionjugadas(){
	
	$(".botonjugadasiguiete").on("click",function(){
		$("#seleccloteria option:selected").each(function() {
			loteria = $(this).attr("id");
		});
		$.ajax({
			type:'GET',
			url:'php/paginacionjugadas.php?pagina='+$(this).attr("id")+'&loteria='+loteria+'',
			success: function(respuesta){
				$("#conetenedor-verjugadas .contenedor").html(respuesta);
			},
			complete: function(){
				seleccionarjugada();
				eliminarjugada();
				paginacionjugadas();
			}
		})
	})
	$(".botonjugadaaterior").on("click",function(){
		$.ajax({
			type:'GET',
			url:'php/paginacionjugadas.php?pagina='+$(this).attr("id")+'&loteria='+loteria+'',
			success: function(respuesta){
				$("#conetenedor-verjugadas .contenedor").html(respuesta);
			},
			complete: function(){
				seleccionarjugada();
				eliminarjugada();
				paginacionjugadas();
			}
		})
	})
}
function verformulariosorteo(){
	$(".agregarsorteo").on("click",function(){
		$.ajax({
			url:'php/versorteo.php',
			success:function(respuesta){
				$(".formulariosorteo").html(respuesta);
			},
			complete:function(){
				agregaesorteo();
			}
		})
	})
}
function agregaesorteo(){
	$("#agregarsorteo").on("click",function(){
		
		if($("#hora").val()==""){
			$(".horasorteo").css("display","flex");
			setTimeout(function(){
				$(".horasorteo").css("display","none");
			},2000);
		}
		$("#loteriassorteo option:selected").each(function() {
			loteria = $(this).attr("id");
		});
		
		if(loteria=='todos'){
			$(".sleclote").css("display","flex");
			setTimeout(function(){
				$(".sleclote").css("display","none");
			},2000);
		}
		if($("#hora").val()!="" && loteria!='todos'){
			$.ajax({
				type:'POST',
				url:'php/agregarsorteo.php?loteria='+loteria+'',
				data:{hora:$("#hora").val()},
				success:function(respuesta){
					if(respuesta=="existe"){
						$(".existesorteo").css("display","flex");
					}
					if(respuesta=="creado"){
						$(".sorteocreado").css("display","flex");
					}
				},
				complete:function(){
					setTimeout(function(){
						$(".existesorteo").css("display","none");
					},2000);
					setTimeout(function(){
						$(".sorteocreado").css("display","none");
					},2000);
				}
			})
		}
	})
}
function veradministrarsorteo(){
	$(".adiministrarsorteo").on("click",function(){
		
		$.ajax({
			url:'php/veradministrarsorteo.php',
			success:function(respuesta){
				$('#administrar-sorteo').html(respuesta);
			},
			complete:function(){
				seleccionarsorteos();
				eliminarsorteo();
				cambiarloteriasorteos();
				paginacionsorteos();
			}
		})
	})
}
function cambiarloteriasorteos(){
	$("#loteriassorteos").change(function(){
		$("#loteriassorteos option:selected").each(function(){
			loteria = $(this).attr("id");
		})
		
		$.ajax({
			type:'GET',
			url:'php/cambiarloteriasorteos.php?loteria='+loteria+'',
			success: function(respuesta){
				$("#administrar-sorteos .contenedor").html(respuesta);
			},
			complete: function(){
				seleccionarsorteos();
				eliminarsorteo();
				paginacionsorteos();
			}
		})
	})
}
function seleccionarsorteos(){
	$(".contenedor-sorteo").on("click",function(){
		if($(this).hasClass("activarbotonsorteo")==true){
			$(this).removeClass("activarbotonsorteo");
			$(".botonescontrolsorteo").css("display","none");
		}else{
			$(".contenedor-sorteo").removeClass("activarbotonsorteo");
			$(this).addClass("activarbotonsorteo");
			$(".botonescontrolsorteo").css("display","none");
			$(".botonescontrolsorteo").eq($(".contenedor-sorteo").index(this)).css("display","flex");	
		}
	})
}
function eliminarsorteo(){
	$(".eliminarsorteo").on("click",function(){
		$("#loteriassorteos option:selected").each(function(){
			loteria = $(this).attr("id");
		})
		$.ajax({
			url:'php/eliminarsorteo.php?sorteo='+$(this).attr("id")+'&loteria='+loteria+'',
			success: function(respuesta){
				$("#administrar-sorteos .contenedor").html(respuesta);
			},
			complete:function(){
				seleccionarsorteos();
				eliminarsorteo();
				paginacionsorteos();
			}
		})
	})
}
function paginacionsorteos(){
	$(".botonsorteosiguiete").on("click",function(){
		$("#loteriassorteos option:selected").each(function(){
			loteria = $(this).attr("id");
		})
		$.ajax({
			url:'php/paginacionsorteo.php?pagina='+$(this).attr("id")+'&loteria='+loteria+'',
			success: function(respuesta){
				$("#administrar-sorteos .contenedor").html(respuesta);
			},
			complete:function(){
				seleccionarsorteos();
				eliminarsorteo();
				paginacionsorteos();
			}
		})
	})
	$(".botonsorteoaterior").on("click",function(){
		$("#loteriassorteos option:selected").each(function(){
			loteria = $(this).attr("id");
		})
		$.ajax({
			url:'php/paginacionsorteo.php?pagina='+$(this).attr("id")+'&loteria='+loteria+'',
			success: function(respuesta){
				$("#administrar-sorteos .contenedor").html(respuesta);
			},
			complete:function(){
				seleccionarsorteos();
				eliminarsorteo();
				paginacionsorteos();
			}
		})
	})
}
function verfechaspendientes(){
	$(".sorteoslanzar").on("click",function(){
		$.ajax({
			url: 'php/verfechaspendientes.php',
			success: function(respuesta){
				$("#lanzarsorteos").html(respuesta);
			},
			complete: function(respuesta){
				verfechaspendientes();
				versorteospendientes();
			}
		})
	})
}
function versorteospendientes(){
	$("#fechasorteos").change(function(){
		$("#fechasorteos option:selected").each(function() {
			fecha = $(this).attr("id");
		});
		$.ajax({
			type:'GET',
			url: 'php/versorteospendientes.php?fecha='+fecha+'',
			success: function(respuesta){
				$("#lanzarsorteos").html(respuesta);
			},
			complete: function(respuesta){
				versorteospendientes();
				seleccionarsorteospendientes();
				finalizarsorteo();
				paginacionfinalizarsorteospendeiente();
			}
		})
	})
	
}
function seleccionarsorteospendientes(){
	$(".contenedor-sorteopensientes").on("click",function(){
		if($(this).hasClass("activarsorteopensientes")==true){
			$(this).removeClass("activarsorteopensientes");
			$(".botonesrealizarsorteo").css("display","none");
		}else{
			$(".contenedor-sorteopensientes").removeClass("activarsorteopensientes");
			$(this).addClass("activarsorteopensientes");
			$(".botonesrealizarsorteo").css("display","none");
			$(".botonesrealizarsorteo").eq($(".contenedor-sorteopensientes").index(this)).css("display","flex");	
		}
	})
}
function finalizarsorteo(){
	$(".finalizarsorteo").on("click",function(){
		$("#fechasorteos option:selected").each(function() {
			fecha = $(this).attr("id");
		});
		$.ajax({
			url: 'php/finalizarsorteospendientes.php?fecha='+fecha+'&sorteo='+$(this).attr("id")+'',
			success: function(respuesta){
				$("#lanzarsorteos").html(respuesta);
			},
			complete: function(respuesta){
				versorteospendientes();
				seleccionarsorteospendientes();
				paginacionfinalizarsorteospendeiente();
			}
		})
	})
}
function paginacionfinalizarsorteospendeiente(){
	$(".botonsorteofinalsiguiete").on("click",function(){
		$("#fechasorteos option:selected").each(function() {
			fecha = $(this).attr("id");
		});
		$.ajax({
			type:'GET',
			url:'php/paginacionsorteospendientes.php?fecha='+fecha+'&pagina='+$(this).attr("id")+'',
			success: function(respuesta){
				$("#lanzarsorteos .contenedor").html(respuesta);
			},
			complete:function(){
				versorteospendientes();
				seleccionarsorteospendientes();
				finalizarsorteo();
				paginacionfinalizarsorteospendeiente();
			}
		})
	})
	$(".botonsorteofinalaanterios").on("click",function(){
		$("#fechasorteos option:selected").each(function() {
			fecha = $(this).attr("id");
		});
		$.ajax({
			type:'GET',
			url:'php/paginacionsorteospendientes.php?fecha='+fecha+'&pagina='+$(this).attr("id")+'',
			success: function(respuesta){
				$("#lanzarsorteos .contenedor").html(respuesta);
			},
			complete:function(){
				versorteospendientes();
				seleccionarsorteospendientes();
				finalizarsorteo();
				paginacionfinalizarsorteospendeiente();
			}
		})
	})
}
function seleccionarporecentage(){
	$(".contenedor-porcentages").on("click",function(){
		$(".modificar-porcntageganancia").css("display","none");
		if($(this).hasClass("activarporecentage")==true){
			$(this).removeClass("activarporecentage");
			$(".botonescontrolporcentage").css("display","none");
		}else{
			$(".contenedor-porcentages").removeClass("activarporecentage");
			$(this).addClass("activarporecentage");
			$(".botonescontrolporcentage").css("display","none");
			$(".botonescontrolporcentage").eq($(".contenedor-porcentages").index(this)).css("display","flex");	
		}
	})
}
function vermodificarporcentageganancia(){
	$('.modifiporcentageganancia').on("click",function(){
		console.log($('.modifiporcentageganancia').index(this));
		$(".contenedor-porcentages").removeClass("activarporecentage");
		$(".botonescontrolporcentage").css("display","none");
		$(".modificar-porcntageganancia").css("display","flex");
		$(".modificarvalorporcentagegaancia").eq($('.modifiporcentageganancia').index(this)).css("display","flex");
	})
}
function modificarporcentagedeganancias(){
	$('.modificarvalorporcentagegaancia').on("click",function(){
		if($("#valorporcentagenuevo").val()==""){
			$(".conpletecampoporcentage").css("display","flex");
			setTimeout(function(){
				$(".conpletecampoporcentage").css("display","none");
			},2000);
		}
		if($("#valorporcentagenuevo").val()!="" && $.isNumeric($("#valorporcentagenuevo").val())==false){
			$(".conpletecampoapuestaporcentagenumerico").css("display","flex");
			setTimeout(function(){
				$(".conpletecampoapuestaporcentagenumerico").css("display","none");
			},2000);
		}
		if($("#valorporcentagenuevo").val()!="" && $.isNumeric($("#valorporcentagenuevo").val())!=false){
			$.ajax({
			type:'POST',
			url:'php/modificarporcentageganancia.php?tipodeusuario='+$(this).attr("id")+'',
			data:{porcentage:$("#valorporcentagenuevo").val()},
			success:function(respuesta){
				$(".mensajevalorporcentage").css("display","flex");
				setTimeout(function(){
					$(".infoporcentaje").html(respuesta);
				},2000);
			},
			complete:function(){
				setTimeout(function(){
					seleccionarporecentage();
					vermodificarporcentageganancia();
					modificarporcentagedeganancias();
					$(".modificarvalorporcentagegaancia").css("display","none");
				},2100);
			}
		})
		}
		
	})
}
function salirmodificarporcentageganancia(){
	$(".salirmodificarporcentageganancia").on("click",function(){
		$(".modificarvalorporcentagegaancia").css("display","none");
		$(".modificar-porcntageganancia").css("display","none");
	})
}
function cambiarfechainicio(){
	$("#fechaprimera").change(function(){
		$("#tipodeusuario option:selected").each(function(){
			tipodeusuario = $(this).attr("id");
		})
		$("#contenedorganancias").html("");
		$.ajax({
			type:'POST',
			url:'php/verifcarfecha.php?tipodeusuario='+tipodeusuario+'',
			data:({fecha:$("#fechaprimera").val()}),
			success: function(respuesta){
				if(respuesta!="bien"){
					alert(respuesta);
					$(this).val("");
				}
			},
		})
	});
	$("#fechasegunda").change(function(){
		$("#contenedorganancias").html("");
	})
}
function buscarcontroldinero(){
	$("#buscarcontroldinero").on("click",function(){
		$("#tipodeusuario option:selected").each(function(){
			tipodeusuario = $(this).attr("id");
		})
		var hoy = new Date();
		var dd = hoy.getDate();
		var mm = hoy.getMonth()+1; //hoy es 0!
		var yyyy = hoy.getFullYear();

		if(dd<10) {
			dd='0'+dd
		} 

		if(mm<10) {
			mm='0'+mm
		} 

		hoy = yyyy+'-'+mm+'-'+dd;
		if($("#fechaprimera").val()>$("#fechasegunda").val()){
			alert("No puede ser mayor");	
		}else if($("#fechasegunda").val()>hoy){
			alert("La Segunda Fecha No Puede ser Mayor A Hoy");
		}else if($("#fechaprimera").val()=="" || $("#fechasegunda").val()==""){
			alert("Seleccione Las Fechas");
		}else{
			$.ajax({
				type:'POST',
				url:'php/buscarcontroldinero.php?tipodeusuario='+tipodeusuario+'',
				data:({fechainicial:$("#fechaprimera").val(),fechafinal:$("#fechasegunda").val()}),
				success: function(respuesta){
					if(respuesta!=""){
						$("#contenedorganancias").html(respuesta);
					}else{
						$("#contenedorganancias").css("display","none");
					}
				},
				complete: function(respuesta){
					if(respuesta!=""){
						seleccionarcontnedorpago();
						realizarcobro();
						paginacioncontroldinero();
					}
				}
			})
		}
	})
}
function seleccionarcontnedorpago(){
	$(".contenedorpago").on("click",function(){
		$(".botoncobro").css("display","none");
		if($(this).hasClass("activarcontenedorpago")==true){
			$(this).removeClass("activarcontenedorpago");
			$(".botoncobro").css("display","none");
		}else{
			$(".contenedorpago").removeClass("activarcontenedorpago");
			$(this).addClass("activarcontenedorpago");
			$(".botoncobro").css("display","none");
			$(".botoncobro").eq($(".contenedorpago").index(this)).css("display","flex");	
		}
	})
}
function realizarcobro(){
	$(".botoncobro").on("click",function(){
		$.ajax({
			type:'GET',
			url:'php/realizarcobro.php?variables='+$(this).attr("id")+'',
			success: function(respuesta){
				if(respuesta!=""){
					$("#contenedorganancias").html(respuesta);
				}else{
					$("#contenedorganancias").css("display","none");
				}
			},
			complete: function(respuesta){
				if(respuesta!=""){
					seleccionarcontnedorpago();
					realizarcobro();
					paginacioncontroldinero();
				}
			}
		})
	})
}
function paginacioncontroldinero(){
	$(".botondinerosiguiente").on("click",function(){
		$.ajax({
			type:'POST',
			url:'php/paginacioncontroldinero.php?tipodeusuario='+tipodeusuario+'&pagina='+$(this).attr("id")+'',
			data:({fechainicial:$("#fechaprimera").val(),fechafinal:$("#fechasegunda").val()}),
			success: function(respuesta){
				$("#contenedorganancias").html(respuesta);
			},
			complete: function(respuesta){
				seleccionarcontnedorpago();
				realizarcobro();
				paginacioncontroldinero();
			}
		})
	})
	$(".botondineroanterios").on("click",function(){
		$.ajax({
			type:'POST',
			url:'php/paginacioncontroldinero.php?tipodeusuario='+tipodeusuario+'&pagina='+$(this).attr("id")+'',
			data:({fechainicial:$("#fechaprimera").val(),fechafinal:$("#fechasegunda").val()}),
			success: function(respuesta){
				$("#contenedorganancias").html(respuesta);
			},
			complete: function(respuesta){
				seleccionarcontnedorpago();
				realizarcobro();
				paginacioncontroldinero();
			}
		})
	})
}
function actualizarsistema(){
	$("#actualizarsitema").on("click",function(){
		$("#contenedoractualizarsistema").css("display","none");
		$.ajax({
			url:"php/actualizarsistema.php",
			success:function(respuesta){
				console.log(respuesta);
			}
		})
	})
}
//funciones receloector
function cambiarfechainiciorecolector(){
	$("#fechaprimerarecolector").change(function(){
		$("#contenedorganancias").html("");
		$.ajax({
			type:'POST',
			url:'php/verifcarfecharecolector.php?usuario='+$("#usuario").text()+'',
			data:({fecha:$("#fechaprimerarecolector").val()}),
			success: function(respuesta){
				if(respuesta!="bien"){
					alert(respuesta);
					$(this).val("");
				}
			},
		})
		
	});
	$("#fechasegundarecolector").change(function(){
		$("#contenedorganancias").html("");
	})
}
function buscarcontroldinerorecolector(){
	$("#buscarcontroldinerorecolector").on("click",function(){
		
		var hoy = new Date();
		var dd = hoy.getDate();
		var mm = hoy.getMonth()+1; //hoy es 0!
		var yyyy = hoy.getFullYear();

		if(dd<10) {
			dd='0'+dd
		} 

		if(mm<10) {
			mm='0'+mm
		} 

		hoy = yyyy+'-'+mm+'-'+dd;
		if($("#fechaprimerarecolector").val()>$("#fechasegundarecolector").val()){
			alert("No puede ser mayor");	
		}else if($("#fechasegundarecolector").val()>hoy){
			alert("La Segunda Fecha No Puede ser Mayor A Hoy");
		}else{
			$.ajax({
				type:'POST',
				url:'php/buscarcontroldinerorecolector.php?usuario='+$("#usuario").text()+'',
				data:({fechainicial:$("#fechaprimerarecolector").val(),fechafinal:$("#fechasegundarecolector").val()}),
				success: function(respuesta){
					if(respuesta!=""){
						$("#contenedorganancias").html(respuesta);
					}else{
						$("#contenedorganancias").css("display","none");
					}
				},
				complete: function(respuesta){
					if(respuesta!=""){
						seleccionarcontenedorpagorecolector();
						realizarcobrorecolector();
						paginacioncontroldinerorecolector();
					}
				}
			})
		}
	})
}
function seleccionarcontenedorpagorecolector(){
	$(".contenedorpagorecolector").on("click",function(){
		$(".botoncobrorecolector").css("display","none");
		if($(this).hasClass("activarcontenedorpago")==true){
			$(this).removeClass("activarcontenedorpago");
			$(".botoncobrorecolector").css("display","none");
		}else{
			$(".contenedorpagorecolector").removeClass("activarcontenedorpago");
			$(this).addClass("activarcontenedorpago");
			$(".botoncobrorecolector").css("display","none");
			$(".botoncobrorecolector").eq($(".contenedorpagorecolector").index(this)).css("display","flex");	
		}
	})
}
function realizarcobrorecolector(){
	$(".botoncobrorecolector").on("click",function(){
		$.ajax({
			type:'POST',
			url:'php/realizarcobrorecolector.php?variables='+$(this).attr("id")+'&usuario='+$("#usuario").text()+'',
				data:({nombre:$("#nombrebuscarbanca").val()}),
			success: function(respuesta){
				if(respuesta!=""){
					$("#contenedorganancias").html(respuesta);
				}else{
					$("#contenedorganancias").css("display","none");
				}
			},
			complete: function(respuesta){
				if(respuesta!=""){
					seleccionarcontenedorpagorecolector();
					realizarcobrorecolector();
					paginacioncontroldinerorecolector();
				}
			}
		})
	})
}
function paginacioncontroldinerorecolector(){
	$(".botondinerosiguienterecolector").on("click",function(){
		$.ajax({
			type:'POST',
			url:'php/paginacioncontroldinerorecolector.php?pagina='+$(this).attr("id")+'&usuario='+$("#usuario").text()+'',
			data:({fechainicial:$("#fechaprimerarecolector").val(),fechafinal:$("#fechasegundarecolector").val()}),
			success:function(respuesta){
				$("#contenedorganancias").html(respuesta);
			},
			complete:function(){
				seleccionarcontenedorpagorecolector();
				realizarcobrorecolector();
				paginacioncontroldinerorecolector();
			}
		})
	})
	$(".botondineroanteriorrecolector").on("click",function(){
		$.ajax({
			type:'POST',
			url:'php/paginacioncontroldinerorecolector.php?pagina='+$(this).attr("id")+'&usuario='+$("#usuario").text()+'',
			data:({fechainicial:$("#fechaprimerarecolector").val(),fechafinal:$("#fechasegundarecolector").val()}),
			success:function(respuesta){
				$("#contenedorganancias").html(respuesta);
			},
			complete:function(){
				seleccionarcontenedorpagorecolector();
				realizarcobrorecolector();
				paginacioncontroldinerorecolector();
			}
		})
	})
}
//funciones banca
function vericificarmac(){
	$("#verificarmac").on("click",function(){
		if($("#archivo-mac").val()==""){
			$(".seleccionarchivo").css("display","flex");
			setTimeout(function(){
				$(".seleccionarchivo").css("display","none");
			},2000);
		}else{
			var formulario = $("#cargamac"); 
			var archivos = new FormData();
			for(var i = 0; i < (formulario.find("input[type=file]").length); i++){
				archivos.append((formulario.find('input[type="file"]:eq('+i+')').attr("name")),((formulario.find('input[type="file"]:eq('+i+')')[0]).files[0]));
			}
			$.ajax({
				type:'POST',
				url:'php/verificarmac.php?usuario='+$("#usuario").text()+'',
				contentType:false,
				data: archivos,
				processData:false,
				data: archivos,
				success: function(respuesta){
					//console.log(respuesta);
					if(respuesta=="cerrar sesion"){
						alert("La Mac Del Equipo No Es La Adecuada");
						location.reload();
					}else if(respuesta==""){
						$("#contenedorfichero").css("display","none");
					}else{
						alert("No puedes durar mas de 4 minutos después de crear el archivo mac para cargarlo");
						location.reload();
					}
				},
				complete: function(){
					
				}
			})
		}
	})
}
function apostar(){
	
	$("#apostar").on("click",function(){
		codigos="";
		if($("input:checked").length==0){
			if($("#codigo").val()==""){
				$(".codigoapuesta").css("display","flex");
				setTimeout(function(){
					$(".codigoapuesta").css("display","none");
				},1000);
			}
			if($("#codigo").val()!="" && $.isNumeric($("#codigo").val())==false){
				$(".numerocodigo").css("display","flex");
				setTimeout(function(){
					$(".numerocodigo").css("display","none");
				},1000);
			}
		}else{
			contador = 0;
			while(contador<$("input:checked").length){
				codigos = codigos+"-"+$("input:checked").eq(contador).attr("id");
				contador++;
			}
		}
		if($("#apuesta").val()==""){
			$(".cantidadapostada").css("display","flex");
			setTimeout(function(){
				$(".cantidadapostada").css("display","none");
			},1000);
		}
		if($("#apuesta").val()!="" && $.isNumeric($("#apuesta").val())==false){
			$(".valorapostadonumerico").css("display","flex");
			setTimeout(function(){
				$(".valorapostadonumerico").css("display","none");
			},1000);
		}
		$("#seleccionarloteria option:selected").each(function() {
			loteria = $(this).attr("id");
		});
		if(loteria=="todos"){
			$(".seleccionloteria").css("display","flex");
			setTimeout(function(){
				$(".seleccionloteria").css("display","none");
			},1000);
		}
		$("#seleccionarsorteos option:selected").each(function() {
			sorteo = $(this).attr("id");
		});
		if(sorteo=="todos"){
			$(".seleccionsorteo").css("display","flex");
			setTimeout(function(){
				$(".seleccionsorteo").css("display","none");
			},1000);
		}
		
		if((($("#codigo").val()!="" && $.isNumeric($("#codigo").val())!=false) || codigos.length>0) && $("#apuesta").val()!="" && $.isNumeric($("#apuesta").val())!=false && loteria!="todos" && sorteo!="todos"){
			$.ajax({
				type:'POST',
				url: 'php/apuesta.php?usuario='+$("#usuario").text()+'&sorteo='+sorteo+'&loteria='+loteria+'&codigos='+codigos+'&cantidadjugadas='+contador+'',
				data:({codigo:$("#codigo").val(),apuesta:$("#apuesta").val()}),
				beforeSend: function(){
					$(".cargaapuesta").css("display","flex");
					$("#apostar").css("display","none");
				},
				success: function(respuesta){
					
					if(respuesta=="codigoerrado"){
						$(".codigoinvalido").css("display","flex");
						setTimeout(function(){
							$(".codigoinvalido").css("display","none");
						},1000);
					}else if(respuesta=="sorteo cerrado"){
						$(".sorteofinalizado").css("display","flex");
						setTimeout(function(){
							$(".sorteofinalizado").css("display","none");
							
						$("#controlapuesta").css("display","none");
						},1000);
					}else{
						$("#controlapuesta").html(respuesta);
						$("#controlapuesta").css("display","flex");
						
					}
				},
				complete: function(respuesta){
					seleccionarapuesta();
					eliminarapuesta();
					borrarcontrolapuesta();
					finalizarapuesta();
					$("#codigo").val("");
					$("#apuesta").val("");
					$("input:checked").prop('checked', false);
					$(".cargaapuesta").css("display","none");
					$("#apostar").css("display","flex");
				}
			})	
		}
	})
}
function seleccionarapuesta(){
	$(".contenedor-controlapuesta").on("click",function(){
		if($(this).hasClass("activarboonapuesta")==true){
			$(this).removeClass("activarboonapuesta");
			$(".botoneliminarapuesta").css("display","none");
		}else{
			$(".contenedor-controlapuesta").removeClass("activarboonapuesta");
			$(this).addClass("activarboonapuesta");
			$(".botoneliminarapuesta").css("display","none");
			$(".botoneliminarapuesta").eq($("#controlapuesta .contenedor-controlapuesta").index(this)).css("display","flex");	
		}
		
	})
}
function eliminarapuesta(){
	$(".botoneliminarapuesta").on("click",function(){
		$.ajax({
			type:'GET',
			url: 'php/eliminarapuesta.php?variable='+$(this).attr("id")+'',
			success: function(respuesta){
				$("#controlapuesta").html(respuesta);
			},
			complete: function(respuesta){
				seleccionarapuesta();
				eliminarapuesta();
				borrarcontrolapuesta();
				finalizarapuesta();
			}
		})
	
	})
}
function borrarcontrolapuesta(){
	$(".botoncancelarapuestaapuesta").on("click",function(){
		$.ajax({
			type:'GET',
			url: 'php/borrarcontrolapuesta.php?usuario='+$("#usuario").text()+'',
			beforeSend:function(){
				$(".cargafinalizarapueta").css("display","flex");
				$(".botoncancelarapuestaapuesta").css("display","none");
			},
			success: function(respuesta){
				$("#controlapuesta").html(respuesta);
			},
			complete: function(respuesta){
				$(".cargafinalizarapueta").css("display","none");
				$(".botoncancelarapuestaapuesta").css("display","flex");
				setTimeout(function(){
					$("#controlapuesta").css("display","none");
				},1000);
			}
		})
	
	})
}
function finalizarapuesta(){
	$(".botonfinalizaapuesta").on("click",function(){
		$.ajax({
			type:'GET',
			url: 'php/finalizarapuesta.php?usuario='+$("#usuario").text()+'',
			beforeSend:function(){
				$(".cargafinalizarapueta").css("display","flex");
				$(".botonfinalizaapuesta").css("display","none");
			},
			success: function(respuesta){
				console.log(respuesta);
				if(respuesta=="cerrar sesion"){
					location.reload();
				}else if(respuesta.indexOf("error")!=-1){
					$(".apuesta").html(respuesta.substr(6));
					apostar();
					$("#seleccionarloteria").change(function(){
						$("#seleccionarloteria option:selected").each(function() {
							loteria = $(this).attr("id");
						});
						if(loteria=="todos"){
							$("#verlistado").css("display","none");
						}else{
							$.ajax({
							type:'GET',
							url: 'php/loterias.php?loteria='+loteria+'',
							success: function(respuest){
								if(respuest=="error"){
									$(".errorloteria").css("display","flex");
								}else{
									$("#seleccionarsorteos").html(respuest.substr(0,respuest.indexOf("-")));
									$("#verlistado").html(respuest.substr(respuest.indexOf("-")+1));
									$("#verlistado").css("display","flex");
								}
							},
							complete: function(respuest){
								if(respuest=="error"){
									setTimeout(function(){
										$(".errorloteria").css("display","flex");
									},2000);
								}
							}
							})
						}
					})
					
					alert("Hubo Un Error, Intente De Nuevo");
				}else if(respuesta=="error"){
					alert("Hubo Un Error, Intente De Nuevo");
					$("#controlapuesta").css("display","none");
				}else{
					$("#controlapuesta").html(respuesta);
				}
			},
			complete: function(respuesta){
				$(".cargafinalizarapueta").css("display","none");
				$(".botonfinalizaapuesta").css("display","flex")
				imprimirtiket();
			}
		})
	
	})
}
function imprimirtiket(){
	$(".botonimprimir").on("click",function(){
		$(this).remove();
		$("#contenedorimrimir").css("display","flex");
		$("#contenedorimrimir").html($("#controlapuesta").html());
		 $("#contenedorimrimir").printArea();
		$("#controlapuesta").css("display","none");
		$("#contenedorimrimir").css("display","none");
	})
}
function cancelartiket(){
	$("#cancelartiket").on("click",function(){
		$.ajax({
			type:'POST',
			url:'php/cancelartiket.php?usuario='+$("#usuario").text()+'',
			data:{codigo:$("#codigotiketcancel").val()},
			beforeSend: function(){
				$("#cancelartiket").css("display","none");
				$(".cargacancelartket").css("display","flex");
			},
			success: function(respuesta){
				if(respuesta=="bien"){
					$(".tiketcancelado").css("display","flex");
				}else if(respuesta=="codigo errado"){
					$(".codigonoasignado").css("display","flex");
				}
			},
			complete: function(){
				$("#codigotiketcancel").val("");
				$("#cancelartiket").css("display","flex");
				$(".cargacancelartket").css("display","none");
				setTimeout(function(){
					$(".tiketcancelado").css("display","none");
					$(".codigonoasignado").css("display","none");
				},3000)
			}
		})
	})
}
function buscarpremios(){
	$("#buscarpremios").on("click",function(){
		$.ajax({
			type:'POST',
			url:'php/buscarpremios.php?usuario='+$("#usuario").text()+'',
			data:({codigo:$("#codigotiket").val()}),
			beforeSend: function(){
				$(".cargabuscarpremios").css("display","flex");
				$("#buscarpremios").css("display","none");
			},
			success:function(respuesta){
				if(respuesta=="no premiado"){
					$(".codigonoganador").css("display","flex");
				}else{
					$(".formulariobuscatiket").css("display","none");
					$("#resultadosganadores").css("display","flex");
					$("#resultadosganadores").html(respuesta);
					realizarpago();
					cancelarpago();
				}
			},
			complete:function(respuesta){
				$("#codigotiket").val("");
				$(".cargabuscarpremios").css("display","none");
				$("#buscarpremios").css("display","flex");
				setTimeout(function(){
					$(".codigonoganador").css("display","none");
				},3000);
			}
		})
	})
}
function realizarpago(){
	$(".pagarpremio").on("click",function(){
		$.ajax({
			type:'POST',
			url:"php/realizarpago.php",
			data:({codigo:$(this).attr("id")}),
			beforeSend: function(){
				$(".cargabuspagar").css("display","flex");
				$(".pagarpremio").css("display","none");
			},
			success: function(respuesta){
				
			},
			complete:function(){
				$(".pagoexitoso").css("display","flex");
				$(".cargabuspagar").css("display","none");
				$(".pagarpremio").css("display","flex");
				setTimeout(function(){
					$("#resultadosganadores").css("display","none");
					$(".pagoexitoso").css("display","none");
					$(".formulariobuscatiket").css("display","flex");
				},3000);
			}
		})
	})
}
function cancelarpago(){
	$(".cancelarpago").on("click",function(){
		$("#resultadosganadores").css("display","none");
		$(".formulariobuscatiket").css("display","flex");
	})
}
function cambiarfechainiciobanca(){
	$("#fechaprimerabanca").change(function(){
		$("#contenedorganancias").html("");
		$.ajax({
			type:'POST',
			url:'php/verificarfechabanca.php?usuario='+$("#usuario").text()+'',
			data:({fecha:$(this).val()}),
			success:function(respuesta){
				if(respuesta!="bien"){
					alert(respuesta);
					$(this).val("");
				}
			}
		})
	})
	$("#fechasegundabanca").change(function(){
		$("#contenedorganancias").html("");
	})
}
function buscardinerocontrolbanca(){
	$("#buscarcontroldinerobanca").on("click",function(){
		var hoy = new Date();
		var dd = hoy.getDate();
		var mm = hoy.getMonth()+1; //hoy es 0!
		var yyyy = hoy.getFullYear();

		if(dd<10) {
			dd='0'+dd
		} 

		if(mm<10) {
			mm='0'+mm
		} 

		hoy = yyyy+'-'+mm+'-'+dd;
		if($("#fechaprimerabanca").val()>$("#fechasegundabanca").val()){
			alert("No puede ser mayor");	
		}else if($("#fechasegundabanca").val()>hoy){
			alert("La Segunda Fecha No Puede ser Mayor A Hoy");
		}else{
			$.ajax({
				type:'POST',
				url:"php/buscardinerocontrolbanca.php?usuario="+$("#usuario").text()+"",
				data:({fechainicial:$("#fechaprimerabanca").val(),fechafinal:$("#fechasegundabanca").val()}),
				success:function(respuesta){
					$("#contenedorganancias").html(respuesta);
				}
			})
		}
	})
}
function vertiketganadores(){
	$(".bverpremios").on("click",function(){
		
		$.ajax({
			type:'GET',
			url:"php/verprecios.php?usuario="+$("#usuario").text()+"",
			success:function(respuesta){
				$(".verpremios").html(respuesta);
			},
			complete:function(){
				paginadortiket();
			}
		})
	})
}
function paginadortiket(){
	$(".botonganadoressiguiete").on("click",function(){
		$.ajax({
			type:'GET',
			url:"php/paginacionganadores.php?usuario="+$("#usuario").text()+"&pagina="+$(this).attr("id")+"",
			success:function(respuesta){
				$(".verpremios").html(respuesta);
			},
			complete: function(){
				paginadortiket();
			}
		})
	})
	$(".botonganadoresanterior").on("click",function(){
		$.ajax({
			type:'GET',
			url:"php/paginacionganadores.php?usuario="+$("#usuario").text()+"&pagina="+$(this).attr("id")+"",
			success:function(respuesta){
				$(".verpremios").html(respuesta);
			},
			complete: function(){
				paginadortiket();
			}
		})
	})
}



