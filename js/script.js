$(document).on("ready",iniciarpagina);
function iniciarpagina(){
	var btnMenu = document.getElementById("btn-menu");
	var nav = document.getElementById ("nav");
	
	btnMenu.addEventListener("click", function(){
		nav.classList.toggle("mostrar");
	})
	$(".interfazprincipal").css("min-height",$(window).height());
	$(".menu .menu__link").on("click",function(){
		$(".menu__link").length;
		$(".menu__link").removeClass("select");
		$(this).addClass("select");
		$(".interfazprincipal").removeClass("activo");
		$(".interfazprincipal").css("display","none");
		$(".interfazprincipal").eq($(".menu__link").index(this)).css("display","flex");
		$(".interfazprincipal").eq($(".menu__link").index(this)).addClass("activo");
	})
	paginadorjugadas();
	paginadorsorteos();
	paginaganadores();
	cambiarloteriaultimossoretos();
	cambiarloteriajugadas();
	cambiarsorteosjugadas();
	cambiarloteriajugadasganadoras();
}
function paginadorjugadas(){
	$(".siguientetablajugadas").on("click",function(){
		$("#loteriasjugadas option:selected").each(function() {
			loteria = $(this).attr("id");
		});
		$.ajax({
			type:'GET',
			url:'php/paginadorjugadas.php?loteria='+loteria+'&pagina='+$(this).attr("id")+'',
			success:function(respuesta){
				$("#tablajugadas").html(respuesta);
			},
			complete:function(){
				paginadorjugadas();
			}
		})
	})
	$(".ateriortablajugadas").on("click",function(){
		$("#loteriasjugadas option:selected").each(function() {
			loteria = $(this).attr("id");
		});
		$.ajax({
			type:'GET',
			url:'php/paginadorjugadas.php?loteria='+loteria+'&pagina='+$(this).attr("id")+'',
			success:function(respuesta){
				$("#tablajugadas").html(respuesta);
			},
			complete:function(){
				paginadorjugadas();
			}
		})
	})
}
function paginadorsorteos(){
	$(".siguientetablasorteo").on("click",function(){
		$("#loteriassorteo option:selected").each(function() {
			loteria = $(this).attr("id");
		});
		$.ajax({
			type:'GET',
			url:'php/paginadorsorteos.php?loteria='+loteria+'&pagina='+$(this).attr("id")+'',
			success:function(respuesta){
				$("#contenedortablasorteo").html(respuesta);
			},
			complete:function(){
				paginadorsorteos();
			}
		})
	})
	$(".ateriortablasorteo").on("click",function(){
		$("#loteriassorteo option:selected").each(function() {
			loteria = $(this).attr("id");
		});
		$.ajax({
			type:'GET',
			url:'php/paginadorsorteos.php?loteria='+loteria+'&pagina='+$(this).attr("id")+'',
			success:function(respuesta){
				$("#contenedortablasorteo").html(respuesta);
			},
			complete:function(){
				paginadorsorteos();
			}
		})
	})
}
function paginaganadores(){
	$(".siguientetablaganadoras").on("click",function(){
		$("#loteriasganadoras option:selected").each(function() {
			loteria = $(this).attr("id");
		});
		$.ajax({
			type:'GET',
			url:'php/paginaganadores.php?loteria='+loteria+'&pagina='+$(this).attr("id")+'',
			success:function(respuesta){
				$("#contenedortablaganadoras").html(respuesta);
			},
			complete:function(){
				paginaganadores();
			}
		})
	})
	$(".anteriostablaganadoras").on("click",function(){
		$("#loteriasganadoras option:selected").each(function() {
			loteria = $(this).attr("id");
		});
		$.ajax({
			type:'GET',
			url:'php/paginaganadores.php?loteria='+loteria+'&pagina='+$(this).attr("id")+'',
			success:function(respuesta){
				$("#contenedortablaganadoras").html(respuesta);
			},
			complete:function(){
				paginaganadores();
			}
		})
	})
}
function cambiarloteriaultimossoretos(){
	$("#loteriasultimosorteos").change(function(){
		$("#loteriasultimosorteos option:selected").each(function(){
			loteria = $(this).attr("id");
		})
		$.ajax({
			type:'GET',
			url:'php/cambiarloteriaultimossoretos.php?loteria='+loteria+'',
			success:function(respuesta){
				$("#contenedorultimossorteos").html(respuesta);
			}
		})
	})
}
function cambiarloteriajugadas(){
	$("#loteriasjugadas").change(function(){
		$("#loteriasjugadas option:selected").each(function(){
			loteria = $(this).attr("id");
		})
		$.ajax({
			type:'GET',
			url:'php/cambiarloteriajugadas.php?loteria='+loteria+'',
			success:function(respuesta){
				$(".listado").html(respuesta);
			},
			complete:function(){
				paginadorjugadas();
			}
		})
	})
}
function cambiarsorteosjugadas(){
	$("#loteriassorteo").change(function(){
		$("#loteriassorteo option:selected").each(function(){
			loteria = $(this).attr("id");
		})
		$.ajax({
			type:'GET',
			url:'php/cambiarsorteosjugadas.php?loteria='+loteria+'',
			success:function(respuesta){
				$("#contenedortablasorteo").html(respuesta);
			},
			complete: function(){
				paginadorsorteos();
			}
		})
	})
}
function cambiarloteriajugadasganadoras(){
	$("#loteriasganadoras").change(function(){
		$("#loteriasganadoras option:selected").each(function(){
			loteria = $(this).attr("id");
		})
		$.ajax({
			type:"GET",
			url:'php/cambiarloteriajugadasganadoras.php?loteria='+loteria+'',
			success:function(respuesta){
				$("#contenedortablaganadoras").html(respuesta);
			},
			complete:function(){
				paginaganadores();
			}
		})
	})
}
