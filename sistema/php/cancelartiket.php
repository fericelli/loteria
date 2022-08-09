<?php
	Class Cancelartiket{
		private $Comunicacion;
		function Cancelartiket(){
			include("../../php/conexion.php");
			$this->Comunicacion = new Conexion();
			if(isset($_GET["usuario"]) && isset($_POST["codigo"])){
				echo $this->retorno();
			}
		}
		private function retorno(){
			$codigo = $_GET["usuario"]."-".$_POST["codigo"];
			$consultar = $this->Comunicacion->Consultar("SELECT * FROM apuesta WHERE codigo='".$codigo."'");
			if($this->Comunicacion->Recorrido($consultar)){
				$eliminar = $this->Comunicacion->Consultar("DELETE FROM apuesta WHERE codigo='".$codigo."'");
				if($eliminar==true){
					return "bien";
				}
			}else{
				return "codigo errado";
			}
		}
	}
	new Cancelartiket();
?>