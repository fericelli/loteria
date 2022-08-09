<?php
	Class Agragarloteria{
		private $Comunicacion;
		function Agragarloteria(){
			include("../../php/conexion.php");
			$this->Comunicacion = new Conexion();
			if(isset($_POST["loteria"]) && isset($_POST["valorapuesta"]) && isset($_POST["diascaducacion"])){
				if($this->ComprobarLoteria()=="existe"){
					echo "existe";
				}else{
					if($this->Registrar()=="bien"){
						echo "registro";
					}
				}
			} 
		}
		private function ComprobarLoteria(){
			$consulta = $this->Comunicacion->Consultar("SELECT * FROM loterias WHERE loteria='".$_POST["loteria"]."'");
			if($this->Comunicacion->Recorrido($consulta)){
				return "existe";
			}
		}
		private function Registrar(){
			$carpeta = '../imagenes/'.$_POST["loteria"].'';
			mkdir($carpeta, 0777, true);
			$consulta = $this->Comunicacion->Consultar("INSERT loterias(loteria,valorapuesta,bloqueo,diascaducaciontiket) VALUES ('".$_POST["loteria"]."','".$_POST["valorapuesta"]."','no','".$_POST["diascaducacion"]."')");
			if($consulta == true){
				return "bien";
			}
		}
	}
	new Agragarloteria();
?>