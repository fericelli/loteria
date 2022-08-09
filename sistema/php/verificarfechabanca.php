<?php
	Class Verificarfechabanca{
		private $Comunicacion;
		function Verificarfechabanca(){
			include("../../php/conexion.php");
			$this->Comunicacion = new Conexion();
			if(isset($_GET["usuario"]) && isset($_POST["fecha"])){
				echo $this->retorno();
			}
		}
		private function retorno(){
			$consultafecha = $this->Comunicacion->Consultar("SELECT fecha FROM controldinero WHERE banca='".$this->ComprobarBanca()."'");
			if($fecha = $this->Comunicacion->Recorrido($consultafecha)){
				if($fecha[0]==$_POST["fecha"]){
					return "bien";
				}else{
					$date = date_create($fecha[0]);
					return "La fecha seleccionada tiene que ser ".date_format($date, 'd-m-Y')."";
				}
			}else{
				return "no hay dinero pendiente";
			}
		}
		private function ComprobarBanca(){
			$consulta = $this->Comunicacion->Consultar("SELECT nombre FROM bancas WHERE usuario='".$_GET["usuario"]."'");
			if($banca = $this->Comunicacion->Recorrido($consulta)){
				return $banca[0];
			}
		}
	}
	new Verificarfechabanca();
?>