<?php
	Class Agregarbanca{
		private $Comunicacion;
		function Agregarbanca(){
			include("../../php/conexion.php");
			$this->Comunicacion = new Conexion();
			if(isset($_GET["usuario"]) && isset($_POST["banca"]) && isset($_POST["usuarionevo"]) && isset($_POST["porcentajeganancia"]) && isset($_POST["mac"]) && isset($_POST["telefono"])){
				if($this->ComprobarBanca()=="existe banca"){
					echo "existe banca";
				}else{
					if($this->ComprobarUsuario()=="existe usuario"){
						echo "existe usuario";
					}else{
						if($this->ComprobarMac()=="mac exitente"){
							echo "mac exitente";
						}else{
							if($this->CrearBanca()=="registro exitoso"){
								echo "registro exitoso";
							}else{
								echo $this->CrearBanca();
							}
						}
					}
				}
			}
		}
		private function ComprobarBanca(){
			$consulta = $this->Comunicacion->Consultar("SELECT * FROM bancas WHERE nombre='".$_POST["banca"]."'");
			if($this->Comunicacion->Recorrido($consulta)){
				return "existe banca";
			}
		}
		private function ComprobarUsuario(){
			$consulta = $this->Comunicacion->Consultar("SELECT * FROM usuarios WHERE nick='".$_POST["usuarionevo"]."'");
			if($this->Comunicacion->Recorrido($consulta)){
				return "existe usuario";
			}
		}
		private function ComprobarTipoDeUsuario(){
			$consulta = $this->Comunicacion->Consultar("SELECT tipodeusuario FROM usuarios WHERE nick='".$_GET["usuario"]."'");
			if($row = $this->Comunicacion->Recorrido($consulta)){
				return $row["tipodeusuario"]; 
			}
		}
		private function ComprobarPorcentajeGanancia(){
			if($this->ComprobarTipoDeUsuario()!="administrador"){
				$consultar = $this->Comunicacion->Consultar("SELECT * FROM recolectores WHERE usuario='".$_GET["usuario"]."'");
				if($recolector = $this->Comunicacion->Recorrido($consultar)){
					if($recolector[5]-$_POST["porcentajeganancia"]<1){
						return $recolector[5];
					}else{
						return "bien";
					}
				}
			}
		}
		private function ComprobarMac(){
			if($_POST["mac"]!=""){
				$consulta = $this->Comunicacion->Consultar("SELECT * FROM bancas WHERE mac='".$_POST["mac"]."'");
				if($this->Comunicacion->Recorrido($consulta)){
					return "mac exitente";
				}
			}
		}
		private function CrearBanca(){
			//return "INSERT INTO dinerobanca(banca,usuario,dinero,dineroganados) VALUES ('".$_POST["banca"]."','".$_POST["usuarionevo"]."',0,0)";
			if($this->ComprobarTipoDeUsuario()!="administrador"){
				if($this->ComprobarPorcentajeGanancia()=="bien"){
					$insertarbanca = $this->Comunicacion->Consultar("INSERT INTO bancas(nombre,usuario,creador,usuariocreador,bloqueo,porcentageganancia,mac,ultimasesion,telefono) VALUES ('".$_POST["banca"]."','".$_POST["usuarionevo"]."','".$this->ComprobarTipoDeUsuario()."','".$_GET["usuario"]."','no','".$_POST["porcentajeganancia"]."','".$_POST["mac"]."','','".$_POST["telefono"]."')");
					$insertarusuario = $this->Comunicacion->Consultar("INSERT INTO usuarios(nick,clave,tipodeusuario,bloqueo) VALUES ('".$_POST["usuarionevo"]."','','banca','no')");
					//$insertardinerobanca = $this->Comunicacion->Consultar("INSERT INTO dinerobanca(banca,usuario,dinero,premiosporpagar) VALUES ('".$_POST["banca"]."','".$_POST["usuarionevo"]."',0,0)");
					if($insertarbanca==true and $insertarusuario==true){
						return "registro exitoso";
					}
				}else{
					return $this->ComprobarPorcentajeGanancia();
				}
			}else{
				$insertarbanca = $this->Comunicacion->Consultar("INSERT INTO bancas(nombre,usuario,creador,usuariocreador,bloqueo,porcentageganancia,mac,ultimasesion,telefono) VALUES ('".$_POST["banca"]."','".$_POST["usuarionevo"]."','".$this->ComprobarTipoDeUsuario()."','".$_GET["usuario"]."','no','".$_POST["porcentajeganancia"]."','".$_POST["mac"]."','','".$_POST["telefono"]."')");
					$insertarusuario = $this->Comunicacion->Consultar("INSERT INTO usuarios(nick,clave,tipodeusuario,bloqueo) VALUES ('".$_POST["usuarionevo"]."','','banca','no')");
					//$insertardinerobanca = $this->Comunicacion->Consultar("INSERT INTO dinerobanca(banca,usuario,dinero,premiosporpagar) VALUES ('".$_POST["banca"]."','".$_POST["usuarionevo"]."',0,0)");
					if($insertarbanca==true and $insertarusuario==true){
						return "registro exitoso";
					}
			}
		}
	}
	new Agregarbanca();
?>