<?php
	Class Eliminarjugada{
		private $Comunicacion;
		function Eliminarjugada(){
			include("../../php/conexion.php");
			$this->Comunicacion = new Conexion();
			if(isset($_GET["variables"]) && isset($_GET["loteria"])){
				echo $this->Eliminar();
				if($this->ComprobarJugadas()=='bloquear'){
					if($this->Bloquear()=='bloqueado'){
						echo $this->RetornoBloqueado();
					}
				}else{
					if($this->Eliminar()=="eliminada"){
						echo $this->RetornoEliminada();
					}
				}
			}
		}
		private function ComprobarJugadas(){
			$porciones = explode("-",$_GET["variables"]);
			$consulta = $this->Comunicacion->Consultar("SELECT * FROM controlapuesta WHERE loteria='".$_GET["loteria"]."' AND jugada='".$porciones[1]."'");
			$consultar = $this->Comunicacion->Consultar("SELECT * FROM apuesta WHERE loteria='".$porciones[1]."' AND jugada='".$porciones[1]."'");
			$consultarr = $this->Comunicacion->Consultar("SELECT * FROM ganadores WHERE loteria='".$porciones[1]."' AND jugada='".$porciones[1]."'");
			if($this->Comunicacion->Recorrido($consultar)){
				return "bloquear";
			}
			if($this->Comunicacion->Recorrido($consulta)){
				return "bloquear";
			}
			if($this->Comunicacion->Recorrido($consultarr)){
				return "bloquear";
			}
		}
		private function Bloquear(){
			$porciones = explode("-",$_GET["variables"]);
			$consulta = $this->Comunicacion->Consultar("UPDATE jugadas SET bloqueo='si' WHERE loteria='".$porciones[1]."' AND jugada='".$porciones[2]."' AND codigoapuesta='".$porciones[0]."'");
			if($consulta==true){
				return "bloqueado";
			}
		}
		private function Eliminar(){
			$porciones = explode("-",$_GET["variables"]);
			$carpeta = '$_SERVER[DOCUMENT_ROOT]/sistema/'.$porciones[3];		
			
				unlink("".$carpeta."");
			//$consulta = $this->Comunicacion->Consultar("DELETE FROM jugadas WHERE loteria='".$porciones[1]."' AND nombre='".$porciones[2]."' AND codigoapuesta='".$porciones[0]."'");
			$consulta = $this->Comunicacion->Consultar("DELETE FROM controlsorteo WHERE loteria='".$porciones[1]."' AND jugada='".$porciones[2]."'");
			$consulta = $this->Comunicacion->Consultar("DELETE FROM dineroapostado WHERE loteria='".$porciones[1]."' AND jugada='".$porciones[2]."'");
			if($consulta==true){
				return "eliminada";
			}
		}
		private function RetornoBloqueado(){
			$r="";
			$consultacantidad = $this->Comunicacion->Consultar("SELECT codigoapuesta,nombre,imagen FROM jugadas WHERE loteria='".$_GET["loteria"]."' AND bloqueo<>'si'");
			$cantidadjugadas = $this->Comunicacion->NFilas($consultacantidad);
			$cantidadregistromostrar = 6;
			$pagina = 1;
			$paginasiguiente = $pagina + 1;
			if($cantidadjugadas>0){
				$r="<div style='font-size:12px' class='boton jugadabloqueada mensajejugada'>Jugada Bloqueada Para Ser Eliminada</div>";
				$consu = $this->Comunicacion->Consultar("SELECT codigoapuesta,nombre,imagen FROM jugadas WHERE loteria='".$_GET["loteria"]."' AND bloqueo<>'si' ORDER BY codigoapuesta ASC LIMIT 0,".$cantidadregistromostrar."");
				while($row = $this->Comunicacion->Recorrido($consu)){
					$r=$r."<div style='width:300px' class='botones botonesjugadas'>
					<div id='".$row[0]."-".$_GET["loteria"]."-".$row[1]."-".$row[2]."' class='boton  eliminarjugada'>Eliminar</div>
					</div>";
				}
				$consulta = $this->Comunicacion->Consultar("SELECT codigoapuesta,nombre,imagen FROM jugadas WHERE loteria='".$_GET["loteria"]."' AND bloqueo<>'si' ORDER BY codigoapuesta ASC LIMIT 0,".$cantidadregistromostrar."");
				while($row = $this->Comunicacion->Recorrido($consulta)){
					$r=$r."<div class='contenedor-jugada'>
					<div>".$row[0]."</div>
					<div>".$row[1]."</div>
					<img src='".$row[2]."'>
					</div>";
				}
				return $r;
			}else{
				return "<h2>No Hay Loterias Agregadas</h2>";
			}
			
		}
		private function RetornoEliminada(){
			$r="";
			$consultacantidad = $this->Comunicacion->Consultar("SELECT codigoapuesta,nombre,imagen FROM jugadas WHERE loteria='".$_GET["loteria"]."' AND bloqueo<>'si'");
			$cantidadjugadas = $this->Comunicacion->NFilas($consultacantidad);
			$cantidadregistromostrar = 6;
			$pagina = 1;
			$paginasiguiente = $pagina + 1;
			if($cantidadjugadas>0){
				$r="<div style='font-size:12px' class='boton jugadabloqueada mensajejugada'>Jugada Eliminada</div>";
				$consu = $this->Comunicacion->Consultar("SELECT codigoapuesta,nombre,imagen FROM jugadas WHERE loteria='".$_GET["loteria"]."' AND bloqueo<>'si' ORDER BY codigoapuesta ASC LIMIT 0,".$cantidadregistromostrar."");
				while($row = $this->Comunicacion->Recorrido($consu)){
					$r=$r."<div style='width:300px' class='botones botonesjugadas'>
					<div id='".$row[0]."-".$_GET["loteria"]."-".$row[1]."-".$row[2]."' class='boton  eliminarjugada'>Eliminar</div>
					</div>";
				}
				$consulta = $this->Comunicacion->Consultar("SELECT codigoapuesta,nombre,imagen FROM jugadas WHERE loteria='".$_GET["loteria"]."' AND bloqueo<>'si' ORDER BY codigoapuesta ASC LIMIT 0,".$cantidadregistromostrar."");
				while($row = $this->Comunicacion->Recorrido($consulta)){
					$r=$r."<div class='contenedor-jugada'>
					<div>".$row[0]."</div>
					<div>".$row[1]."</div>
					<img src='".$row[2]."'>
					</div>";
				}
				return $r;
			}else{
				return "<h2>No Hay Loterias Agregadas</h2>";
			}
		}
		
	}
	new Eliminarjugada();
?>