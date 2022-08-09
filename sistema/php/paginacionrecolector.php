<?php
	Class Paginacionrecolector{
		private $Comunicacion;
		function Paginacionrecolector(){
			include("../../php/conexion.php");
			$this->Comunicacion = new Conexion();
			if(isset($_GET["pagina"])){
				echo $this->ListadoRecolector($_GET["pagina"]);
			}
		}
		private function ListadoRecolector($pagina){
			$consultacantidadbancas = $this->Comunicacion->Consultar("SELECT * FROM recolectores");
			$cantidadrecoectores = $this->Comunicacion->NFilas($consultacantidadbancas);
			$cantidadregistromostrar = 12;
			$total_paginas = ceil($cantidadrecoectores/$cantidadregistromostrar);
			$paginasiguiente = $pagina + 1;
			$paginaanterior = $pagina - 1;
			$inicio = ($pagina-1)*$cantidadregistromostrar;
			if($cantidadrecoectores>0){
				$r='<div id="contenedor-recolector">';
				$consulta = $this->Comunicacion->Consultar("SELECT usuario,bloqueo FROM recolectores ORDER BY nombre ASC LIMIT ".$inicio.",".$cantidadregistromostrar."");
				while($usuario = $this->Comunicacion->Recorrido($consulta)){
					$r = $r."<div class='botones botonescontrolrecolector'><div id='".$usuario[0]."' class='boton  eliminarrecolector'>Eliminar</div>";
					if($usuario[1]=="si"){
						$r=$r."<div id='".$usuario[0]."' class='boton  desbloqueorecolector'>Desbloquear</div>";
					}else{
						$r=$r."<div id='".$usuario[0]."' class='boton  bloqueorecolector'>Bloquear</div>";
					}
					$r=$r."<div id='".$usuario[0]."' class='boton  reiniciarclaverecolector'>Reiniciar Clave</div></div>";
				}
				$r = $r."<div class='contenedor'>";
				$consul = $this->Comunicacion->Consultar("SELECT nombre FROM recolectores ORDER BY nombre ASC LIMIT ".$inicio.",".$cantidadregistromostrar."");
				while($listausuario = $this->Comunicacion->Recorrido($consul)){
					$r=$r."<div class='contenedor-recolector'>
						<div>".$listausuario[0]."</div>
					</div>";
				}
				$r=$r."</div>";
				if($total_paginas>$pagina){
					$r=$r."<div id='".$paginasiguiente."' class='botonsiguiete botonrecolectorsiguiete'>></div>";
				}
				if($pagina>1){
					$r=$r."<div id='".$paginaanterior."' class='botonanterior botonrecolectoraterior'><</div>";
				}
				return $r=$r."</div>";
			}else{
				return $r='<div id="contenedor-recolector">
				<h2>No Hay Recolectores Agregadas</h2>
				</div>';
			}
		}
	}
	new Paginacionrecolector();
?>