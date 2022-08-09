<?php
	Class Agregarsorteo{
		private $Comunicacion;
		function Agregarsorteo(){
			include("../../php/conexion.php");
			$this->Comunicacion = new Conexion();
			if(isset($_POST["hora"]) && isset($_GET["loteria"])){
				if($this->ComprobarSorteoYHoraAgregada()=="exite"){
					echo "existe";
				}else{
					if($this->CrearSorteo()=="creado"){
						echo "creado";
					}
				}
			}
		}
		private function ComprobarSorteoYHoraAgregada(){
			$consulta = $this->Comunicacion->Consultar("SELECT * FROM sorteo WHERE loteria='".$_GET["loteria"]."' AND hora='".$_POST["hora"]."'");
			if($this->Comunicacion->Recorrido($consulta)){
				return "exite";
			}
		}
		private function CrearSorteo(){
			$consulta = $this->Comunicacion->Consultar("INSERT INTO sorteo(loteria,hora) VALUES ('".$_GET["loteria"]."','".$_POST["hora"]."')");
			if($consulta==true){
				return "creado";
			}
		}
	}
	new Agregarsorteo();
?>