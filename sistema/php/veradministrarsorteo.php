<?php
	Class Veradministrarsorteo{
		private $Comunicacion;
		function Veradministrarsorteo(){
			include("../../php/conexion.php");
			$this->Comunicacion = new Conexion();
			echo $this->Retorno();
		}
		private function Retorno(){
			$r="";
			$r=$r."<div id='administrar-sorteos'><select id='loteriassorteos'>";
			$consultaloterias = $this->Comunicacion->Consultar("SELECT loteria FROM loterias WHERE bloqueo<>'si' ORDER BY loteria ASC");
			$cantidadloterias = $this->Comunicacion->NFilas($consultaloterias);
			if($cantidadloterias<1){
				$r=$r."<option id='todos'>Seleccione Una Loteria</option>";	
			}
			while($loterias = $this->Comunicacion->Recorrido($consultaloterias)){
				$r=$r."<option id='".$loterias[0]."'>".$loterias[0]."</option>";
			}
			
			$r=$r.'</select>';
			$consultaloterias = $this->Comunicacion->Consultar("SELECT loteria FROM loterias WHERE bloqueo<>'si' ORDER BY loteria ASC");
			if($loterias = $this->Comunicacion->Recorrido($consultaloterias)){
				$consulta = $this->Comunicacion->Consultar("SELECT hora FROM sorteo WHERE loteria='".$loterias[0]."' ORDER BY hora ASC");
				$cantidaddesorteos = $this->Comunicacion->NFilas($consulta);
				$cantidadregistromostrar = 12;
				$pagina = 1;
				$paginasiguiente = $pagina + 1;
				if($cantidaddesorteos>0){
					$r = $r."<div class='contenedor'>";
					$consultasorteo = $this->Comunicacion->Consultar("SELECT hora FROM sorteo WHERE loteria='".$loterias[0]."' ORDER BY hora ASC LIMIT 0,".$cantidadregistromostrar."");
					while($sorteo = $this->Comunicacion->Recorrido($consultasorteo)){
						$r = $r."<div class='botones botonescontrolsorteo'><div id='".$sorteo[0]."' class='boton  eliminarsorteo'>Eliminar</div></div>";
					}
					$consul = $this->Comunicacion->Consultar("SELECT hora FROM sorteo WHERE loteria='".$loterias[0]."' ORDER BY hora ASC LIMIT 0,".$cantidadregistromostrar."");
					while($listasorteo = $this->Comunicacion->Recorrido($consul)){
						$r=$r."<div class='contenedor-sorteo'>
							<div>".$listasorteo[0]."</div>
						</div>";
					}
					if($cantidaddesorteos>$cantidadregistromostrar){
						$r=$r."<div id='".$paginasiguiente."' class='siguiente botonsiguiete botonsorteosiguiete'>></div>";
					}	
					$r=$r."</div>";
					
				}else{
					$r=$r."<h2>No Ha Agregado Sorteos</h2>";
				}
			}else{
				$r=$r."<h2>No Ha Agregado Sorteos</h2>";
			}
			return $r=$r.'</div>';
		}
	}
	new Veradministrarsorteo();
?>