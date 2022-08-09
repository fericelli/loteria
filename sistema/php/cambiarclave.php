<?php
	Class Cambiarclave{
		private $Comunicacion;
		function Cambiarclave(){
			include("../../php/conexion.php");
			$this->Comunicacion = new Conexion();
			if(isset($_POST["clave"]) && isset($_GET["usuario"])){
				if($this->Cambiar()=="bien"){
					echo "clave cambiada";
				}
			}
		}
		private function Cambiar(){
			$consulta = $this->Comunicacion->Consultar("UPDATE usuarios SET clave='".$_POST["clave"]."' WHERE nick='".$_GET["usuario"]."'");
			if($consulta==true){
				return "bien";
			}
		}
	}
	new Cambiarclave();
?>