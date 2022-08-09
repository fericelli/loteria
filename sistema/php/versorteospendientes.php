<?php
	Class Versorteospendientes{
		private $Comunicacion;
		function Versorteospendientes(){
			include("../../php/conexion.php");
			$this->Comunicacion = new Conexion();
			if(isset($_GET["fecha"])){
				echo $this->Retorno();
			}
		}
		private function Retorno(){
			$r="<select id='fechasorteos'>
			<option id='todos'>Seleccione Una Fecha</option>";
			if($_GET["fecha"]!="todos"){
				$r=$r."<option id='".$_GET["fecha"]."' selected>".$_GET["fecha"]."</option>";
			}
			$consultafecha = $this->Comunicacion->Consultar("SELECT DISTINCT fecha FROM apuesta WHERE fecha<>'".$_GET["fecha"]."' ORDER BY sorteo ASC");
			while($fecha = $this->Comunicacion->Recorrido($consultafecha)){
				$r=$r."<option id='".$fecha[0]."'>".$fecha[0]."</option>";
			}
			$r=$r."</select>";
			$consultacantidadpasorteos = $this->Comunicacion->Consultar("SELECT DISTINCT sorteo FROM apuesta WHERE fecha='".$_GET["fecha"]."'");
			$cantidadsoretos = $this->Comunicacion->NFilas($consultacantidadpasorteos);
			$cantidadregistromostrar = 12;
			$pagina = 1;
			$paginasiguiente = $pagina + 1;
			
			$consltabotones = $this->Comunicacion->Consultar("SELECT DISTINCT sorteo FROM apuesta WHERE fecha='".$_GET["fecha"]."' ORDER BY sorteo ASC LIMIT 0,".$cantidadregistromostrar."");
			
			while($sorteo = $this->Comunicacion->Recorrido($consltabotones)){
				$consultaloteria = $this->Comunicacion->Consultar("SELECT DISTINCT loteria FROM apuesta WHERE fecha='".$_GET["fecha"]."' AND sorteo='".$sorteo[0]."' ORDER BY sorteo ASC LIMIT 0,".$cantidadregistromostrar."");
				while($loteria = $this->Comunicacion->Recorrido($consultaloteria)){
					$r=$r."<div style='width:300px' class='botones botonesrealizarsorteo'>
					<div id='".$loteria[0]."-".$sorteo[0]."' class='boton finalizarsorteo'>Finalizar Sorteo</div></div>";
				}
			}
			$r=$r."<div class='contenedor'>";
			$consultasorteo = $this->Comunicacion->Consultar("SELECT DISTINCT sorteo FROM apuesta WHERE fecha='".$_GET["fecha"]."' ORDER BY sorteo ASC LIMIT 0,".$cantidadregistromostrar."");
			while($sorteo = $this->Comunicacion->Recorrido($consultasorteo)){
				$consultaloteria = $this->Comunicacion->Consultar("SELECT DISTINCT loteria FROM apuesta WHERE fecha='".$_GET["fecha"]."' AND sorteo='".$sorteo[0]."' ORDER BY sorteo ASC LIMIT 0,".$cantidadregistromostrar."");
				while($loteria = $this->Comunicacion->Recorrido($consultaloteria)){
					$r=$r."<div class='contenedor-sorteopensientes'>
						<div>".$loteria[0]."</div>
						<div>".$sorteo[0]."</div>
					</div>";
				}
			}
			
			if($cantidadsoretos>$cantidadregistromostrar AND $_GET["fecha"]!="todos"){
				$r=$r."<div id='".$paginasiguiente."' class='siguiente botonsiguiete botonsorteofinalsiguiete'>></div>";
			}
			$r=$r."</div>";
			return $r;
		}
	}
	new Versorteospendientes();
?>