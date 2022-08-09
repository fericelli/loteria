<?php
	Class Veradministrarjugadas{
		private $Comunicacion;
		function Veradministrarjugadas(){
			include("../../php/conexion.php");
			$this->Comunicacion = new Conexion();
			echo $this->Retorno();
		}
		private function Retorno(){
			$r="<div id='conetenedor-verjugadas'>
				<select id='seleccloteria'>
				<option id='todos'>Seleccione Una Lotería</option>";
				$consulta = $this->Comunicacion->Consultar("SELECT loteria FROM loterias WHERE bloqueo<>'si' ORDER BY loteria ASC");
				while($row = $this->Comunicacion->Recorrido($consulta)){
					$r=$r."<option id='".$row[0]."'>".$row[0]."</option>";
				}
				return $r=$r."</select><div class='contenedor'></div></div>";
		}
		
	}
	new Veradministrarjugadas();
?>