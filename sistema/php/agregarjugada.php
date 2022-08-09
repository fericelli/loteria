<?php
	Class Agregarjugada{
		private $Comunicacion;
		function Agregarjugada(){
			include("../../php/conexion.php");
			$this->Comunicacion = new Conexion();
			if($this->comprobarfoto() == "Formatos Permitidos Solo jpg y png"){
				echo $this->comprobarfoto();
			}else if($this->comprobarfoto() == "Intente Subir la Foto Nuevamente"){
				echo $this->comprobarfoto();
			}else{
				if($this->comprobarjugada()=="existe"){
					echo "exite jugada";
				}else{
					if($this->comprobarcodigo()=="existe"){
						echo "exite codigo";
					}else{
						$foto = $this->comprobarfoto();
						echo $this->crarjugada($foto);
					}
				}
			}
		}
		private function comprobarfoto(){
			$correo = $_GET["jugada"];
			$formatos = array(".jpg",".png");
			$ErrorArchivo = $_FILES['foto-registro']['error'];
			$NombreArchivo = $_FILES['foto-registro']['name'];
			$NombreTmpArchivo = $_FILES['foto-registro']['tmp_name'];
			$ext = substr($NombreArchivo,strrpos($NombreArchivo, '.'));
			if(in_array($ext, $formatos)){
				if($ErrorArchivo>0){
					return "Intente Subir la Foto Nuevamente";
				}else{
					$directorio = "../imagenes/".$_GET["loteria"]."/".$correo.$ext;
					move_uploaded_file($NombreTmpArchivo,utf8_decode($directorio));
					return $directorio;
				}
			}else{
				return "Formatos Permitidos Solo jpg y png";
			}
		}
		private function comprobarjugada(){
			$consultar = $this->Comunicacion->Consultar("SELECT * FROM jugadas WHERE nombre='".$_GET["jugada"]."' AND loteria='".$_GET["loteria"]."'");
			if($this->Comunicacion->Recorrido($consultar)){
				return "existe";
			}
		}
		private function comprobarcodigo(){
			$consultar = $this->Comunicacion->Consultar("SELECT * FROM jugadas WHERE codigoapuesta='".$_GET["codigojugada"]."' AND loteria='".$_GET["loteria"]."'");
			if($this->Comunicacion->Recorrido($consultar)){
				return "existe";
			}
		}
		private function crarjugada($foto){
			$consulta = $this->Comunicacion->Consultar("INSERT INTO jugadas (codigoapuesta,nombre,loteria,imagen,tipojugada) VALUES ('".$_GET["codigojugada"]."','".$_GET["jugada"]."','".$_GET["loteria"]."','".substr($foto,3,strlen($foto)-2)."','".$_GET["tipodejugada"]."')");
			if($consulta==true){
				return "bien";
			}
		}
	}
	new Agregarjugada();
?>