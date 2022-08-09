<?php

	Class Borrarcontrolapuesta{
		private $Comunicacion;
		function Borrarcontrolapuesta(){
			include("../../php/conexion.php");
			$this->Comunicacion = new Conexion();
			if(isset($_GET["usuario"])){
				$this->Borrarapuesta();
				echo $this->retorno();
			}
		}
		private function retorno(){
			return "Apuesta Cancelada";
		}
		private function Borrarapuesta(){
			$consulta = $this->Comunicacion->Consultar("DELETE FROM controlapuesta WHERE banca='".$this->Banca()."'");
		}
		private function Banca(){
			$consulta = $this->Comunicacion->Consultar("SELECT nombre FROM bancas WHERE usuario='".$_GET["usuario"]."'");
			if($row = $this->Comunicacion->Recorrido($consulta)){
				return $row[0];
			}else{
				return "";
			}
		}
	}
	new Borrarcontrolapuesta();
?>