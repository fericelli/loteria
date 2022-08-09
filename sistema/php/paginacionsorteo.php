<?php
	Class Paginacionsorteo{
		private $Comunicacion;
		function Paginacionsorteo(){
			include("../../php/conexion.php");
			$this->Comunicacion = new Conexion();
			if(isset($_GET["loteria"]) && isset($_GET["pagina"])){
				echo $this->Retorno($_GET["pagina"]);
			}
		}
		private function Retorno($pagina){
			$r="";
			$consultasorteos = $this->Comunicacion->Consultar("SELECT hora FROM sorteo WHERE loteria='".$_GET["loteria"]."'");
			$cantidadsorteos = $this->Comunicacion->NFilas($consultasorteos);
			$cantidadregistromostrar = 10;
			$total_paginas = ceil($cantidadsorteos/$cantidadregistromostrar);
			$paginasiguiente = $pagina + 1;
			$paginaanterior = $pagina - 1;
			$inicio = ($pagina-1)*$cantidadregistromostrar;
			if($cantidadsorteos>0){
				$consultasorteo = $this->Comunicacion->Consultar("SELECT hora FROM sorteo WHERE loteria='".$_GET["loteria"]."' ORDER BY hora ASC LIMIT ".$inicio.",".$cantidadregistromostrar."");
				while($sorteo = $this->Comunicacion->Recorrido($consultasorteo)){
					$r = $r."<div class='botones botonescontrolsorteo'><div id='".$sorteo[0]."' class='boton  eliminarsorteo'>Eliminar</div></div>";
				}
				$consul = $this->Comunicacion->Consultar("SELECT hora FROM sorteo WHERE loteria='".$_GET["loteria"]."' ORDER BY hora ASC LIMIT ".$inicio.",".$cantidadregistromostrar."");
				while($listasorteo = $this->Comunicacion->Recorrido($consul)){
					$r=$r."<div class='contenedor-sorteo'>
						<div>".$listasorteo[0]."</div>
					</div>";
				}
				$r=$r."</div>";	
				if($total_paginas>$pagina){
					$r=$r."<div id='".$paginasiguiente."' class='botonsiguiete botonsorteosiguiete'>></div>";
				}
				if($pagina>1){
					$r=$r."<div id='".$paginaanterior."' class='botonanterior botonsorteoaterior'><</div>";
				}
				return $r;
			}
		}
	}
	new Paginacionsorteo();
?>