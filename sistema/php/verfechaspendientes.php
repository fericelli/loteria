<?php
	Class Verfechaspendientes{
		private $Comunicacion;
		function Verfechaspendientes(){
			include("../../php/conexion.php");
			$this->Comunicacion = new Conexion();
			echo $this->Retorno();
		}
		private function Retorno(){
			$r="<select id='fechasorteos'>
			<option id='todos'>Seleccione Una Fecha</option>";
			$consulta = $this->Comunicacion->Consultar("SELECT DISTINCT fecha FROM apuesta");
			while($row = $this->Comunicacion->Recorrido($consulta)){
				$r=$r."<option id='".$row[0]."'>".$row[0]."</option>";
			}
			return $r=$r."</select>";
		}
	}
	new Verfechaspendientes();
?>