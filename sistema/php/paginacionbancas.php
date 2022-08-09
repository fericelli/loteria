<?php
	Class Paginacionbancas{
		private $Comunicacion;
		function Paginacionbancas(){
			include("../../php/conexion.php");
			$this->Comunicacion = new Conexion();
			if(isset($_GET["usuario"]) && isset($_GET["pagina"])){
				if($this->ComprobarTipoDeUsuario()=="administrador"){
					echo $this->ListadoBanca($_GET["pagina"]);
				}else{
					echo $this->ListadoBancaRecolector($_GET["pagina"]);
				}
			}
		}
		private function ComprobarTipoDeUsuario(){
			$consulta = $this->Comunicacion->Consultar("SELECT tipodeusuario FROM usuarios WHERE nick='".$_GET["usuario"]."'");
				if($row = $this->Comunicacion->Recorrido($consulta)){
					return $row["tipodeusuario"]; 
				}
			}
			private function ListadoBanca($pagina){
				$consultacantidadbancas = $this->Comunicacion->Consultar("SELECT * FROM bancas WHERE creador='administrador'");
				$cantidadbancas = $this->Comunicacion->NFilas($consultacantidadbancas);
				$cantidadregistromostrar = 12;
				$total_paginas = ceil($cantidadbancas/$cantidadregistromostrar);
				
				$paginasiguiente = $pagina + 1;
				$paginaanterior = $pagina - 1;
				$inicio = ($pagina-1)*$cantidadregistromostrar;
				if($cantidadbancas>0){
					$r='<div id="contenedor-banca">';
					$consulta = $this->Comunicacion->Consultar("SELECT usuario,bloqueo FROM bancas WHERE creador='administrador' ORDER BY nombre ASC LIMIT ".$inicio.",".$cantidadregistromostrar."");
					while($usuario = $this->Comunicacion->Recorrido($consulta)){
						$r = $r."<div class='botones botonescontrolbanca'><div id='".$usuario[0]."' class='boton botonbancas eliminarbanca'>Eliminar</div>";
						if($usuario[1]=="si"){
							$r=$r."<div id='".$usuario[0]."' class='boton botonbancas desbloqueobancas'>Desbloquear</div>";
						}else{
							$r=$r."<div id='".$usuario[0]."' class='boton botonbancas bloqueobancas'>Bloquear</div>";
						}
						$r=$r."<div id='".$usuario[0]."' class='boton botonbancas reiniciarclave'>Reiniciar Clave</div></div>";
					}
					$r = $r."<div class='contenedor'>";
					$consul = $this->Comunicacion->Consultar("SELECT nombre FROM bancas WHERE creador='administrador' ORDER BY nombre ASC LIMIT ".$inicio.",".$cantidadregistromostrar."");
					while($listausuario = $this->Comunicacion->Recorrido($consul)){
						$r=$r."<div class='contenedor-banca'>
							<div>".$listausuario[0]."</div>
						</div>";
					}
					$r=$r."</div>";
					if($total_paginas>$pagina){
						$r=$r."<div id='".$paginasiguiente."' class='botonsiguiete botonbancasiguiete'>></div>";
					}
					if($pagina>1){
						$r=$r."<div id='".$paginaanterior."' class='botonanterior botonbancaaterior'><</div>";
					}
					return $r=$r."</div>";
				}else{
					return $r='<div id="contenedor-banca">
					<h2>No Hay Bancas Agregadas</h2>
					</div>';
				}
				
			}
			private function ListadoBancaRecolector($pagina){
				$consultacantidadbancas = $this->Comunicacion->Consultar("SELECT * FROM bancas WHERE usuariocreador='".$_GET["usuario"]."'");
				$cantidadbancas = $this->Comunicacion->NFilas($consultacantidadbancas);
				$cantidadregistromostrar = 12;
				$total_paginas = ceil($cantidadbancas/$cantidadregistromostrar);
				
				$paginasiguiente = $pagina + 1;
				$paginaanterior = $pagina - 1;
				$inicio = ($pagina-1)*$cantidadregistromostrar;
				if($cantidadbancas>0){
					$r='<div id="contenedor-banca">';
					$consulta = $this->Comunicacion->Consultar("SELECT usuario,bloqueo FROM bancas WHERE usuariocreador='".$_GET["usuario"]."' ORDER BY nombre ASC LIMIT ".$inicio.",".$cantidadregistromostrar."");
					while($usuario = $this->Comunicacion->Recorrido($consulta)){
						$r = $r."<div class='botones botonescontrolbanca'><div id='".$usuario[0]."' class='boton botonbancas eliminarbanca'>Eliminar</div>";
						if($usuario[1]=="si"){
							$r=$r."<div id='".$usuario[0]."' class='boton botonbancas desbloqueobancas'>Desbloquear</div>";
						}else{
							$r=$r."<div id='".$usuario[0]."' class='boton botonbancas bloqueobancas'>Bloquear</div>";
						}
						$r=$r."<div id='".$usuario[0]."' class='boton botonbancas reiniciarclave'>Reiniciar Clave</div></div>";
					}
					$r = $r."<div class='contenedor'>";
					$consul = $this->Comunicacion->Consultar("SELECT nombre FROM bancas WHERE usuariocreador='".$_GET["usuario"]."' ORDER BY nombre ASC LIMIT ".$inicio.",".$cantidadregistromostrar."");
					while($listausuario = $this->Comunicacion->Recorrido($consul)){
						$r=$r."<div class='contenedor-banca'>
							<div>".$listausuario[0]."</div>
						</div>";
					}
					$r=$r."</div>";
					if($total_paginas>$pagina){
						$r=$r."<div id='".$paginasiguiente."' class='botonsiguiete botonbancasiguiete'>></div>";
					}
					if($pagina>1){
						$r=$r."<div id='".$paginaanterior."' class='botonanterior botonbancaaterior'><</div>";
					}
					return $r=$r."</div>";
				}else{
					return $r='<div id="contenedor-banca">
					<h2>No Hay Bancas Agregadas</h2>
					</div>';
				}
			}
	}
	new Paginacionbancas();
?>