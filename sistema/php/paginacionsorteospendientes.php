<?php
	Class Paginacionsorteospendientes{
		private $Comunicacion;
		function Paginacionsorteospendientes(){
			include("../../php/conexion.php");
			$this->Comunicacion = new Conexion();
			if(isset($_GET["fecha"]) && isset($_GET["pagina"])){
				echo $this->Retorno($_GET["pagina"]);
				
			}
		}
		private function Retorno($pagina){
			$consultacantidad = $this->Comunicacion->Consultar("SELECT DISTINCT sorteo FROM apuesta WHERE fecha='".$_GET["fecha"]."'");
			$cantidadsoretos = $this->Comunicacion->NFilas($consultacantidad);
			$cantidadregistromostrar = 12;
			$total_paginas = ceil($cantidadsoretos/$cantidadregistromostrar);
			$paginasiguiente = $pagina + 1;
			$paginaanterior = $pagina - 1;
			$inicio = ($pagina-1)*$cantidadregistromostrar;
			
			$r="";
			$consltabotones = $this->Comunicacion->Consultar("SELECT DISTINCT sorteo FROM apuesta WHERE fecha='".$_GET["fecha"]."' ORDER BY sorteo ASC LIMIT ".$inicio.",".$cantidadregistromostrar."");
			
			while($sorteo = $this->Comunicacion->Recorrido($consltabotones)){
				$consultaloteria = $this->Comunicacion->Consultar("SELECT DISTINCT loteria FROM apuesta WHERE fecha='".$_GET["fecha"]."' AND sorteo='".$sorteo[0]."'");
				while($loteria = $this->Comunicacion->Recorrido($consultaloteria)){
					$r=$r."<div style='width:300px' class='botones botonesrealizarsorteo'>
					<div id='".$loteria[0]."-".$sorteo[0]."' class='boton finalizarsorteo'>Finalizar Sorteo</div></div>";
				}
			}
			$r=$r."<div class='contenedor'>";
			$consultasorteo = $this->Comunicacion->Consultar("SELECT DISTINCT sorteo FROM apuesta WHERE fecha='".$_GET["fecha"]."' ORDER BY sorteo ASC LIMIT ".$inicio.",".$cantidadregistromostrar."");
			while($sorteo = $this->Comunicacion->Recorrido($consultasorteo)){
				
				$consultaloteria = $this->Comunicacion->Consultar("SELECT DISTINCT loteria FROM apuesta WHERE fecha='".$_GET["fecha"]."' AND sorteo='".$sorteo[0]."' ORDER BY sorteo ASC");
				while($loteria = $this->Comunicacion->Recorrido($consultaloteria)){
					$r=$r."<div class='contenedor-sorteopensientes'>
						<div>".$loteria[0]."</div>
						<div>".$sorteo[0]."</div>
					</div>";
				}
			}
			$r=$r."</div>";
			if($total_paginas>$pagina){
				$r=$r."<div id='".$paginasiguiente."' class='botonsiguiete botonsorteofinalsiguiete'>></div>";
			}
			if($pagina>1){
				$r=$r."<div id='".$paginaanterior."' class='botonanterior botonsorteofinalaanterios'><</div>";
			}
			return $r;
		}
	}
	new Paginacionsorteospendientes();
?>