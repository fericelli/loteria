<?php
	Class Verifcarfecha{
		private $Comunicacion;
		function Verifcarfecha(){
			include("../../php/conexion.php");
			$this->Comunicacion = new Conexion();
			if(isset($_GET["tipodeusuario"]) && isset($_POST["fecha"])){
				echo $this->retorno();
			}
		}
		private function retorno(){
			if($_GET["tipodeusuario"] == "banca"){
				$consultafecha = $this->Comunicacion->Consultar("SELECT fecha FROM controldinero WHERE usuariocreador='administrador' ORDER BY fecha ASC");
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
			}else{
				$consultafecha = $this->Comunicacion->Consultar("SELECT fecha FROM controldinero WHERE usuariocreador<>'administrador' ORDER BY fecha ASC");
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
		}
		
	}
	new Verifcarfecha();
?>