<?php
	Class Verificarmac{
		private $Comunicacion;
		function Verificarmac(){
			include("../../php/conexion.php");
			$this->Comunicacion = new Conexion();
			if($this->comprobararchivo() == "Formatos Permitidos Solo txt"){
				echo $this->comprobararchivo();
			}else if($this->comprobararchivo() == "Intente Subir la Foto Nuevamente"){
				echo $this->comprobararchivo();
			}else{
				if($this->fechadefichero()=="cerrar sesion"){
					echo "cerrar sesion";
				}else{
					echo $this->fechadefichero();
				}
			}
		}
		private function comprobararchivo(){
			$correo = $_GET["usuario"];
			$formatos = array(".txt");
			$ErrorArchivo = $_FILES['archivo-mac']['error'];
			$NombreArchivo = $_FILES['archivo-mac']['name'];
			$NombreTmpArchivo = $_FILES['archivo-mac']['tmp_name'];
			$ext = substr($NombreArchivo,strrpos($NombreArchivo, '.'));
			if(in_array($ext, $formatos)){
				if($ErrorArchivo>0){
					return "Intente Subir la Foto Nuevamente";
				}else{
					$directorio = "../mac/".$_GET["usuario"].$ext;
					move_uploaded_file($NombreTmpArchivo,utf8_decode($directorio));
					return $directorio;
				}
			}else{
				return "Formatos Permitidos Solo txt";
			}
		}
		private function fechadefichero(){
			$directorio = "../mac/".$_GET["usuario"].".txt";
			$página_inicio = file_get_contents($directorio);
			return $página_inicio;
			$fp = fopen($directorio, "r");
			$linea = fgets($fp);
			fclose($fp); 
			//return $linea;
			//return date("H:i:s d-m-Y")." ".$linea; 
			$infobanca = explode(" ",$linea);
			$consular = $this->Comunicacion->Consultar("SELECT * FROM bancas WHERE usuario='".$_GET["usuario"]."' AND mac='".$infobanca[0]."'");
			if($banca = $this->Comunicacion->Recorrido($consular)){
				
				if($this->minutos_transcurridos($infobanca[1],date("H:i:s d-m-Y"))>4){
					return $this->minutos_transcurridos($infobanca[1],date("H:i:s d-m-Y"));
				}
			}else{
				return "cerrar sesion";
			}
			
		}
		function minutos_transcurridos($fecha_i,$fecha_f){
			$minutos = (strtotime($fecha_i)-strtotime($fecha_f))/60;
			$minutos = abs($minutos); $minutos = floor($minutos);
			return $minutos;
		}
	}
	new Verificarmac();
?>