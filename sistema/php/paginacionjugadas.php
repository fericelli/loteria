<?php
	Class Paginacionjugadas{
		private $Comunicacion;
		function Paginacionjugadas(){
			include("../../php/conexion.php");
			$this->Comunicacion = new Conexion();
			if(isset($_GET["pagina"]) && isset($_GET["loteria"])){
				echo $this->Retorno($_GET["pagina"]);
			}
		}
		private function Retorno($pagina){
			$r="";
			$consultacantidad = $this->Comunicacion->Consultar("SELECT codigoapuesta,nombre,imagen FROM jugadas WHERE loteria='".$_GET["loteria"]."' AND bloqueo<>'si'");
			$cantidadjugadas = $this->Comunicacion->NFilas($consultacantidad);
			$cantidadregistromostrar = 6;
			$total_paginas = ceil($cantidadjugadas/$cantidadregistromostrar);
			$paginasiguiente = $pagina + 1;
			$paginaanterior = $pagina - 1;
			$inicio = ($pagina-1)*$cantidadregistromostrar;
			if($cantidadjugadas>0){
				$consu = $this->Comunicacion->Consultar("SELECT codigoapuesta,nombre,imagen FROM jugadas WHERE loteria='".$_GET["loteria"]."' AND bloqueo<>'si' ORDER BY codigoapuesta ASC LIMIT ".$inicio.",".$cantidadregistromostrar."");
				while($row = $this->Comunicacion->Recorrido($consu)){
					$r=$r."<div style='width:300px' class='botones botonesjugadas'>
					<div id='".$row[0]."-".$_GET["loteria"]."-".$row[1]."-".$row[2]."' class='boton  eliminarjugada'>Eliminar</div>
					</div>";
				}
				$consulta = $this->Comunicacion->Consultar("SELECT codigoapuesta,nombre,imagen FROM jugadas WHERE loteria='".$_GET["loteria"]."' AND bloqueo<>'si' ORDER BY codigoapuesta ASC LIMIT ".$inicio.",".$cantidadregistromostrar."");
				while($row = $this->Comunicacion->Recorrido($consulta)){
					$r=$r."<div class='contenedor-jugada'>
					<div>".$row[0]."</div>
					<div>".$row[1]."</div>
					<img src='".$row[2]."'>
					</div>";
				}
				if($total_paginas>$pagina){
					$r=$r."<div id='".$paginasiguiente."' class='botonsiguiete botonjugadasiguiete'>></div>";
				}
				if($pagina>1){
					$r=$r."<div id='".$paginaanterior."' class='botonanterior botonjugadaaterior'><</div>";
				}
				return $r;
			}
			
			
		}
	}
	new Paginacionjugadas();
?>