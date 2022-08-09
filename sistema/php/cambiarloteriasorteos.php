<?php
	Class Cambiarloteriasorteos{
		private $Comunicacion;
		function Cambiarloteriasorteos(){
			include("../../php/conexion.php");
			$this->Comunicacion = new Conexion();
			if(isset($_GET["loteria"])){
				echo $this->Retorno();
			}
		}
		private function Retorno(){
			$r="";
			$consultasorteos = $this->Comunicacion->Consultar("SELECT hora FROM sorteo WHERE loteria='".$_GET["loteria"]."'");
			$cantidaddesorteos = $this->Comunicacion->NFilas($consultasorteos);
			$cantidadregistromostrar = 12;
			$pagina = 1;
			$paginasiguiente = $pagina + 1;
			if($cantidaddesorteos>0){
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
				$r=$r."</div>";
				if($cantidaddesorteos>$cantidadregistromostrar){
					$r=$r."<div id='".$paginasiguiente."' class='siguiente botonsiguiete botonsorteosiguiete'>></div>";
				}	
				return $r;
			}else{
				return "<h2>No Ha Agregado Sorteos</h2>";
			}
		
		}
	}
	new Cambiarloteriasorteos();
?>