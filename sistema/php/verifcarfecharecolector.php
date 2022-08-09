<?php
	Class Verifcarfecharecolector{
		private $Comunicacion;
		function Verifcarfecharecolector(){
			include("../../php/conexion.php");
			$this->Comunicacion = new Conexion();
			if(isset($_POST["fecha"]) && isset($_GET["usuario"])){
				
				echo $this->retorno();
			}
		}
		private function retorno(){
			//return "SELECT fecha FROM controldinero WHERE banca LIKE '%".$_POST["nombre"]."%' AND usuariocreador='".$this->NombreDeRecolector($_GET["usuario"])."' AND pagorecolector<>'si' ORDER BY fecha ASC";
			$consultafecha = $this->Comunicacion->Consultar("SELECT fecha FROM controldinero WHERE usuariocreador='".$this->NombreDeRecolector($_GET["usuario"])."' AND pagorecolector<>'si' ORDER BY fecha ASC");
			if($fecha = $this->Comunicacion->Recorrido($consultafecha)){
				if($fecha[0]==$_POST["fecha"]){
					return "bien";
				}else{
					$date = date_create($fecha[0]);
					return "La fecha seleccionada tiene que ser ".date_format($date, 'd-m-Y')."";
				}
			}else{
				return "no hay dinero por cobrar";
			}
		}
		private function NombreDeRecolector($usuario){
			$consultar = $this->Comunicacion->Consultar("SELECT nombre FROM recolectores WHERE usuario='".$usuario."'");
			if($nombre = $this->Comunicacion->Recorrido($consultar)){
				return $nombre[0];
			}
		}
	}
	new Verifcarfecharecolector();
?>