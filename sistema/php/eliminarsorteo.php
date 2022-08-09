<?php
	Class Eliminarsorteo{
		private $Comunicacion;
		function Eliminarsorteo(){
			include("../../php/conexion.php");
			$this->Comunicacion = new Conexion();
			if(isset($_GET["sorteo"]) && isset($_GET["loteria"])){
				$this->Eliminar();
				echo $this->Sorteos();
			}
		}
		private function Eliminar(){
			$consulta = $this->Comunicacion->Consultar("DELETE FROM sorteo WHERE loteria='".$_GET["loteria"]."' AND hora='".$_GET["sorteo"]."'");
			$consultar = $this->Comunicacion->Consultar("DELETE FROM dineroapostado WHERE loteria='".$_GET['loteria']."' AND sorteo='".$_GET["sorteo"]."'");
			$consultar = $this->Comunicacion->Consultar("DELETE FROM controlsorteo WHERE loteria='".$_GET['loteria']."' AND sorteo='".$_GET["sorteo"]."'");
		}
		private function Sorteos(){
			$r="";
			$consulta = $this->Comunicacion->Consultar("SELECT hora FROM sorteo WHERE loteria='".$_GET["loteria"]."' ORDER BY hora ASC");
			$cantidaddesorteos = $this->Comunicacion->NFilas($consulta);
			$cantidadregistromostrar = 12;
			$pagina = 1;
			$paginasiguiente = $pagina + 1;
			if($cantidaddesorteos>0){
				$r = $r."<div class='contenedor'>";
				$consultasorteo = $this->Comunicacion->Consultar("SELECT hora FROM sorteo WHERE loteria='".$_GET["loteria"]."' ORDER BY hora ASC LIMIT 0,".$cantidadregistromostrar."");
				while($sorteo = $this->Comunicacion->Recorrido($consultasorteo)){
					$r = $r."<div class='botones botonescontrolsorteo'><div id='".$sorteo[0]."' class='boton  eliminarsorteo'>Eliminar</div></div>";
				}
				$consul = $this->Comunicacion->Consultar("SELECT hora FROM sorteo WHERE loteria='".$_GET["loteria"]."' ORDER BY hora ASC LIMIT 0,".$cantidadregistromostrar."");
				while($listasorteo = $this->Comunicacion->Recorrido($consul)){
					$r=$r."<div class='contenedor-sorteo'>
						<div>".$listasorteo[0]."</div>
					</div>";
				}
				if($cantidaddesorteos>$cantidadregistromostrar){
					$r=$r."<div id='".$paginasiguiente."' class='siguiente botonsiguiete botonsorteosiguiete'>></div>";
				}	
				$r=$r."</div>";
				return $r;	
			}else{
				return "<h2>No Ha Agregado Sorteos</h2>";
			}
		}
	}
	new Eliminarsorteo();
?>