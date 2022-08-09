<?php
	Class EliminarBanca{
		private $Comunicacion;
		function EliminarBanca(){
			include("../../php/conexion.php");
			$this->Comunicacion = new Conexion();
			if(isset($_GET["usuariobanca"]) && isset($_GET["usuario"]) && isset($_POST["taquilla"])){
				if($this->eliminar()=="bien"){
					if($this->ComprobarTipoDeUsuario()=="administrador"){
						echo $this->ListadoBanca();
					}else{
						echo $this->ListadoBancaRecolector();
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
		
		private function eliminar(){
		
			$consulta = $this->Comunicacion->Consultar("DELETE FROM bancas WHERE usuario='".$_GET["usuariobanca"]."'");
			$consultar = $this->Comunicacion->Consultar("DELETE FROM usuarios WHERE nick='".$_GET["usuariobanca"]."'");
			if($consulta == true && $consultar == true){
				return "bien";
			}
		}
		private function ListadoBanca(){
			//return "SELECT * FROM bancas WHERE LIKE '%".$_POST["taquilla"]."%' AND creador='administrador'";
			$consultacantidadbancas = $this->Comunicacion->Consultar("SELECT * FROM bancas WHERE nombre LIKE '%".$_POST["taquilla"]."%' AND creador='administrador'");
			$cantidadbancas = $this->Comunicacion->NFilas($consultacantidadbancas);
			$cantidadregistromostrar = 10;
			$pagina = 1;
			$paginasiguiente = $pagina + 1;
			if($cantidadbancas>0){
				$r='';
				$consulta = $this->Comunicacion->Consultar("SELECT usuario,bloqueo FROM bancas WHERE nombre LIKE '%".$_POST["taquilla"]."%' AND creador='administrador' ORDER BY nombre ASC LIMIT 0,".$cantidadregistromostrar."");
				while($usuario = $this->Comunicacion->Recorrido($consulta)){
					$r = $r."<div class='botones botonescontrolbanca'><div id='".$usuario[0]."' class='boton botonbancas eliminarbanca'>Eliminar</div>";
					if($usuario[1]=="si"){
						$r=$r."<div id='".$usuario[0]."' class='boton botonbancas desbloqueobancas'>Desbloquear</div>";
					}else{
						$r=$r."<div id='".$usuario[0]."' class='boton botonbancas bloqueobancas'>Bloquear</div>";
					}
					$r=$r."<div id='".$usuario[0]."' class='boton botonbancas reiniciarclave'>Reiniciar Clave</div></div>";
				}
				$r = $r."<div class='contenedor'>";
				$consul = $this->Comunicacion->Consultar("SELECT nombre,telefono FROM bancas WHERE nombre LIKE '%".$_POST["taquilla"]."%' AND creador='administrador' ORDER BY nombre ASC LIMIT 0,".$cantidadregistromostrar."");
				while($listausuario = $this->Comunicacion->Recorrido($consul)){
					$r=$r."<div class='contenedor-banca'>
						<div>".$listausuario[0]."</div>
						<div>".$listausuario[1]."</div>
					</div>";
				}
				$r=$r."</div>";
				if($_POST["taquilla"]!=""){
					sleep(3);
					return $r;	
				}else{
					return '';
				}
			}else{
				sleep(3);
				return $r='<div>
				<h2>No Hay Bancas Agregadas</h2></div>
				';
			}
			
		}
		private function ListadoBancaRecolector(){
			$consultacantidadbancas = $this->Comunicacion->Consultar("SELECT * FROM bancas WHERE nombre LIKE '%".$_POST["taquilla"]."%' AND usuariocreador='".$_GET["usuario"]."'");
			$cantidadbancas = $this->Comunicacion->NFilas($consultacantidadbancas);
			$cantidadregistromostrar = 12;
			$pagina = 1;
			$paginasiguiente = $pagina + 1;
			if($cantidadbancas>0){
				$r='';
				$consulta = $this->Comunicacion->Consultar("SELECT usuario,bloqueo FROM bancas WHERE nombre LIKE '%".$_POST["taquilla"]."%' AND usuariocreador='".$_GET["usuario"]."' ORDER BY nombre ASC LIMIT 0,".$cantidadregistromostrar."");
				while($usuario = $this->Comunicacion->Recorrido($consulta)){
					$r = $r."<div class='botones botonescontrolbanca'><div id='".$usuario[0]."' class='boton botonbancas eliminarbanca'>Eliminar</div>";
					if($usuario[1]=="si"){
						$r=$r."<div id='".$usuario[0]."' class='boton botonbancas desbloqueobancas'>Desbloquear</div>";
					}else{
						$r=$r."<div id='".$usuario[0]."' class='boton botonbancas bloqueobancas'>Bloquear</div>";
					}
					$r=$r."<div id='".$usuario[0]."' class='boton botonbancas reiniciarclave'>Reiniciar Clave</div></div>";
				}
				$r = $r."<div class='contenedor'>";
				$consul = $this->Comunicacion->Consultar("SELECT nombre,telefono FROM bancas WHERE nombre LIKE '%".$_POST["taquilla"]."%' AND usuariocreador='".$_GET["usuario"]."' ORDER BY nombre ASC LIMIT 0,".$cantidadregistromostrar."");
				while($listausuario = $this->Comunicacion->Recorrido($consul)){
					$r=$r."<div class='contenedor-banca'>
						<div>".$listausuario[0]."</div>
						<div>".$listausuario[1]."</div>
					</div>";
				}
				$r=$r."</div>";
				if($_POST["taquilla"]!=""){
					sleep(3);
					return $r;	
				}else{
					return '';
				}
			}else{
				sleep(3);
				return $r='<div>
				<h2>No Hay Bancas Agregadas</h2>
				</div>';
			}
		}
	}
	new EliminarBanca();
?>