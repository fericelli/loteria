<?php

	Class Apuesta{
		private $Comunicacion;
		function Apuesta(){
			include("../../php/conexion.php");
			$this->Comunicacion = new Conexion();
			
			if(isset($_GET["usuario"]) && isset($_GET["loteria"]) && isset($_POST["codigo"]) && isset($_POST["apuesta"]) && isset($_GET["sorteo"]) && isset($_GET["codigos"]) && isset($_GET["cantidadjugadas"])){
				if(strlen($_GET["codigos"])>0){
					$this->AgregarApuestas();
					echo $this->MostrarApuestas();
				}else{
					if($this->ComprobarCodigo()=="apostar"){
						$this->AgregarApuesta();
						echo $this->MostrarApuestas();
					}else if($this->ComprobarCodigo()=="codigoerrado"){
						echo $this->ComprobarCodigo();
					}
				}
			}
		}
		private function ComprobarCodigo(){
			$consulta = $this->Comunicacion->Consultar("SELECT nombre FROM jugadas WHERE loteria='".$_GET["loteria"]."' AND codigoapuesta='".$_POST["codigo"]."'");
			
			if($jugada = $this->Comunicacion->Recorrido($consulta)){
				return "apostar";
			}else{
				return "codigoerrado";
			}
		}
		
		private function ComprobarBanca(){
			$consulta = $this->Comunicacion->Consultar("SELECT nombre FROM bancas WHERE usuario='".$_GET["usuario"]."'");
			if($row = $this->Comunicacion->Recorrido($consulta)){
				return $row[0];
			}else{
				return "";
			}
		}
		private function ValorGanancia($codigo){
			if($this->TipoDeJugada($codigo)=="especial"){
				$consulta = $this->Comunicacion->Consultar("SELECT * FROM jugadas WHERE loteria='".$_GET["loteria"]."' AND tipojugada<>'especial' AND bloqueo<>'si'");
				$cantidadjugada = $this->Comunicacion->NFilas($consulta);
				return $cantidadjugada * $_POST["apuesta"];
			}else{
				$consulta = $this->Comunicacion->Consultar("SELECT valorapuesta FROM loterias WHERE loteria='".$_GET["loteria"]."'");
				if($row = $this->Comunicacion->Recorrido($consulta)){
					return $row[0] * $_POST["apuesta"];
				}
			}
		}
		private function TipoDeJugada($codigo){
			$consultar = $this->Comunicacion->Consultar("SELECT tipojugada FROM jugadas WHERE codigoapuesta='".$codigo."'");
			if($tipojugada = $this->Comunicacion->Recorrido($consultar)){
				return $tipojugada[0];
			}
		}
		private function AgregarApuesta(){
			$consulta = $this->Comunicacion->Consultar("INSERT INTO controlapuesta (banca,loteria,sorteo,apuesta,ganancia,hora,jugada) 
			VALUES ('".$this->ComprobarBanca()."','".$_GET["loteria"]."','".$_GET["sorteo"]."','".$_POST["apuesta"]."','".$this->ValorGanancia($_POST["codigo"])."','".date("H:m:s")."','".$this->ComprobarJugada($_POST["codigo"])."')");
			if($consulta==true){
				return "bien";
			}
		}
		private function AgregarApuestas(){
			$codigos = explode("-",$_GET["codigos"]);
			$r="";
			$contador = 1;
			while($contador <= $_GET["cantidadjugadas"]){
				$this->Comunicacion->Consultar("INSERT INTO controlapuesta (banca,loteria,sorteo,apuesta,ganancia,hora,jugada)
				VALUES ('".$this->ComprobarBanca()."','".$_GET["loteria"]."','".$_GET["sorteo"]."','".$_POST["apuesta"]."','".$this->ValorGanancia($codigos[$contador])."','".date("H:m:s")."','".$this->ComprobarJugada($codigos[$contador])."')");
				$contador++;
			}
		}
		private function ComprobarJugada($codigo){
			$consultar = $this->Comunicacion->Consultar("SELECT nombre FROM jugadas WHERE codigoapuesta='".$codigo."' AND loteria='".$_GET["loteria"]."'");
			if($jugada = $this->Comunicacion->Recorrido($consultar)){
				return $jugada[0];
			}
		}
		private function MostrarApuestas(){
			$totalpagar = 0;
			$retornohtml ="";
			$consultar = $this->Comunicacion->Consultar("SELECT banca,hora,loteria,sorteo,jugada FROM controlapuesta WHERE banca='".$this->ComprobarBanca()."'");
			$consulta = $this->Comunicacion->Consultar("SELECT jugada,apuesta,ganancia,loteria FROM controlapuesta WHERE banca='".$this->ComprobarBanca()."'");
			while($row2 = $this->Comunicacion->Recorrido($consultar)){
				$retornohtml = $retornohtml."<a id='".$row2[0]."-".$row2[2]."-".$row2[3]."-".$row2[1]."-".$row2[4]."' class='botoneliminarapuesta boton'>Eliminar</a>";
			}
			$retornohtml = $retornohtml."<div class='contenedor'>
			<div id='encabezado-controlapuesta'>
			<div>Loteria</div><div>Jugada</div><div>Apuesta</div><div>Ganancia</div>
			</div>";
			
			while($row = $this->Comunicacion->Recorrido($consulta)){
				$retornohtml = $retornohtml."<div class='contenedor-controlapuesta'>
					<div>".$row[3]."</div>
					<div>".$row[0]."</div>
					<div>".$row[1]."</div>
					<div>".$row[2]."</div>
				</div>";
				$totalpagar = $totalpagar + $row[1];
			}
			return $retornohtml = $retornohtml."<div>Total Apuesta ".$totalpagar."</div><img style='display:none; margin:auto; width:60px; heigth:60px' class='cargafinalizarapueta' src='imagenes/cargando.gif'><div class='boton botonfinalizaapuesta'>Finalizar Apuesta</div><br><div class='boton botoncancelarapuestaapuesta'>Cancelar Apuesta</div></div>";
		}
	}
	new Apuesta();
?>