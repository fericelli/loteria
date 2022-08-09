<?php
	Class Selecionarloteriajugada{
		private $Comunicacion;
		function Selecionarloteriajugada(){
			include("../../php/conexion.php");
			$this->Comunicacion = new Conexion();
			if(isset($_GET["loteria"])){
				echo $this->Retorno();
			}
		}
		private function Retorno(){
			$r="";
			$consultacantidad = $this->Comunicacion->Consultar("SELECT * FROM jugadas WHERE loteria='".$_GET["loteria"]."' AND bloqueo<>'si'");
			$cantidadjugadas = $this->Comunicacion->NFilas($consultacantidad);
			$cantidadregistromostrar = 6;
			$pagina = 1;
			$paginasiguiente = $pagina + 1;
			if($cantidadjugadas>0){
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
				if($cantidadjugadas>$cantidadregistromostrar){
					$r=$r."<div id='".$paginasiguiente."' class='siguiente botonsiguiete botonjugadasiguiete'>></div>";
				}
				return $r;
			}else{
				if($_GET["loteria"]!='todos'){
					return "<h2>No Hay Loterias Agregadas</h2>";
				}
			}
		}
	}
	new Selecionarloteriajugada();
?>