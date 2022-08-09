<?php
	Class Agregarrecolector{
		private $Comunicacion;
		function Agregarrecolector(){
			include("../../php/conexion.php");
			$this->Comunicacion = new Conexion();
			if(isset($_GET["usuario"]) && isset($_POST["recolector"]) && isset($_POST["usuarionevo"]) && isset($_POST["porcentageganancia"]) && isset($_POST["telefono"])){
				if($this->ComprobarRecolector() == "existe recolector"){
					echo "existe recolector";
				}else{
					if($this->ComprobarUsuario() == "existe usuario"){
						echo "existe usuario";
					}else{
						if($this->CrearRecolector()=="registro exitoso"){
							echo "registro exitoso";
						}
					}
				}
			}
		}
		private function ComprobarTipoDeUsuario(){
			$consulta = $this->Comunicacion->Consultar("SELECT tipodeusuario FROM usuarios WHERE nick='".$_GET["usuario"]."'");
			if($row = $this->Comunicacion->Recorrido($consulta)){
				return $row["tipodeusuario"]; 
			}
		}
		private function ComprobarRecolector(){
			$consulta = $this->Comunicacion->Consultar("SELECT * FROM recolectores WHERE nombre='".$_POST["recolector"]."'");
			if($row = $this->Comunicacion->Recorrido($consulta)){
				return 'existe recolector';
			}
		}
		private function ComprobarUsuario(){
			$consulta = $this->Comunicacion->Consultar("SELECT * FROM usuarios WHERE nick='".$_POST["usuarionevo"]."'");
			if($this->Comunicacion->Recorrido($consulta)){
				return "existe usuario";
			}
		}
		private function CrearRecolector(){
			$insertarbanca = $this->Comunicacion->Consultar("INSERT INTO recolectores(nombre,usuario,creador,usuariocreador,bloqueo,porcentageganancia,telefono) VALUES ('".$_POST["recolector"]."','".$_POST["usuarionevo"]."','".$this->ComprobarTipoDeUsuario()."','".$_GET["usuario"]."','no','".$_POST["porcentageganancia"]."','".$_POST["telefono"]."')");
			$insertarusuario = $this->Comunicacion->Consultar("INSERT INTO usuarios(nick,clave,tipodeusuario,bloqueo) VALUES ('".$_POST["usuarionevo"]."','','recolector','no')");
			if($insertarbanca==true and $insertarusuario==true){
				return "registro exitoso";
			}
		}
	}
	new Agregarrecolector();
?>