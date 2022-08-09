<?php

	Class Eliminarapuesta{
		private $Comunicacion;
		function Eliminarapuesta(){
			include("../../php/conexion.php");
			$this->Comunicacion = new Conexion();
			mysql_set_charset('utf8');
			if(isset($_GET["variable"])){
				if($this->Eliminar()=="bien"){
					echo $this->MostrarApuestas();
				}
			}
		}
		private function Eliminar(){
			$porciones = explode("-", $_GET["variable"]);
			$consultar = $this->Comunicacion->Consultar("DELETE FROM controlapuesta WHERE banca='".$porciones[0]."' AND loteria='".$porciones[1]."' AND sorteo='".$porciones[2]."' AND hora='".$porciones[3]."' AND jugada='".$porciones[4]."'");
			if($consultar==true){
				return "bien";
			}
		}
		public function MostrarApuestas(){
			$porciones = explode("-", $_GET["variable"]);
			$totalpagar = 0;
			$sql = "SELECT banca,hora,loteria,sorteo,jugada FROM controlapuesta WHERE banca='".$porciones[0]."' AND loteria='".$porciones[1]."' AND sorteo='".$porciones[2]."'";
			$consultar = $this->Comunicacion->Consultar($sql);
			$consulta = $this->Comunicacion->Consultar("SELECT jugada,apuesta,ganancia,loteria FROM controlapuesta WHERE banca='".$porciones[0]."' AND loteria='".$porciones[1]."' AND sorteo='".$porciones[2]."'");
			
			if($this->Comunicacion->Recorrido($consultar)){
				$retornohtml = "<div class='contenedor'>
				<div id='encabezado-controlapuesta'>
				<div>Loteria</div><div>Jugada</div><div>Apuesta</div><div>Ganancia</div>
				</div>";
				while($row2 = $this->Comunicacion->Recorrido($consultar)){
					$retornohtml = $retornohtml."<a id='".$row2[0]."-".$row2[2]."-".$row2[3]."-".$row2[1]."-".$row2[4]."' class='botoneliminarapuesta boton'>Eliminar</a>";
				}
				 
				while($row = $this->Comunicacion->Recorrido($consulta)){
					$retornohtml = $retornohtml."<div class='contenedor-controlapuesta'>
						<div>".$row[3]."</div>
						<div>".$row[0]."</div>
						<div>".$row[1]."</div>
						<div>".$row[2]."</div>
					</div>";
					$totalpagar = $totalpagar + $row[1];
				}
				return $retornohtml = $retornohtml."<div>Total Apuesta ".$totalpagar."</div><div class='boton botonfinalizaapuesta'>Finalizar Apuesta</div><br><div class='boton botoncancelarapuestaapuesta'>Cancelar Apuesta</div></div>";	
			}
			
		}
	}
	new Eliminarapuesta();
?>