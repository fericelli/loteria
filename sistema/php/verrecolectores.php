<?php

	Class Verrecolectores{
		private $Comunicacion;
		function Verrecolectores(){
			include("../../php/conexion.php");
			$this->Comunicacion = new Conexion();
			echo $this->ListadoRecolector();
		}
		private function ListadoRecolector(){
			$consultarecolector = $this->Comunicacion->Consultar("SELECT * FROM recolectores WHERE nombre LIKE '%".$_POST["recolector"]."%'");
			$cantidadrecoectores = $this->Comunicacion->NFilas($consultarecolector);
			$cantidadregistromostrar = 10;
			$pagina = 1;
			$paginasiguiente = $pagina + 1;
			if($cantidadrecoectores>0){
				$r='';
				$consulta = $this->Comunicacion->Consultar("SELECT usuario,bloqueo FROM recolectores WHERE nombre LIKE '%".$_POST["recolector"]."%' ORDER BY nombre ASC LIMIT 0,".$cantidadregistromostrar."");
				while($usuario = $this->Comunicacion->Recorrido($consulta)){
					$r = $r."<div class='botones botonescontrolrecolector'><div id='".$usuario[0]."' class='boton  eliminarrecolector'>Eliminar</div>";
					if($usuario[1]=="si"){
						$r=$r."<div id='".$usuario[0]."' class='boton  desbloqueorecolector'>Desbloquear</div>";
					}else{
						$r=$r."<div id='".$usuario[0]."' class='boton  bloqueorecolector'>Bloquear</div>";
					}
					$r=$r."<div id='".$usuario[0]."' class='boton  reiniciarclaverecolector'>Reiniciar Clave</div></div>";
				}
				
				$consul = $this->Comunicacion->Consultar("SELECT nombre,telefono FROM recolectores WHERE nombre LIKE '%".$_POST["recolector"]."%' ORDER BY nombre ASC LIMIT 0,".$cantidadregistromostrar."");
				while($listausuario = $this->Comunicacion->Recorrido($consul)){
					$r=$r."<div class='contenedor-recolector'>
						<div>".$listausuario[0]."</div>
						<div>".$listausuario[1]."</div>
					</div>";
				}
				if($_POST["recolector"]!=""){
					sleep(2);
					return $r;
				}else{
					return "";
				}
			}else{
				sleep(2);
				return '
				<h2>No Hay Recolectores Agregadas</h2>
				';
			}
		}
	}
	new Verrecolectores();
?>