<?php
	Class Loterias{
		private $Comunicacion;
		function Loterias(){
			include("../../php/conexion.php");
			$this->Comunicacion = new Conexion();
			if(isset($_GET["loteria"])){
				if($this->ComprobarApuesta()=="no"){
					echo "error";
				}else{
					echo $this->Sorteo()."-".$this->Listadojugada();
				}
			}	
		}
		private function Listadojugada(){
			$retornohtml = "";
			$consulta = $this->Comunicacion->Consultar("SELECT * FROM jugadas WHERE loteria='".$_GET["loteria"]."' AND bloqueo<>'si' ORDER BY codigoapuesta ASC");
			while($row = $this->Comunicacion->Recorrido($consulta)){
				
				$retornohtml = $retornohtml."<div style='border: 1px solid #000; height:100px; margin:5px' class='contenedor-jugadasaapaostas'>
					<div style='display:flex; width:100px;flex-derection:row'>
						<input id='".$row[0]."' type='checkbox'>
						<div>".$row[0]."</div>
						<div>".$row[1]."</div>
					</div>
					<center><img style='width:50px; height:50px' src='".$row[3]."'></center>
				</div>";	
			}
			return $retornohtml;
		}
		private function ComprobarApuesta(){
			$consulta = $this->Comunicacion->Consultar("SELECT valorapuesta FROM loterias WHERE loteria='".$_GET["loteria"]."'");
			if($valor = $this->Comunicacion->Recorrido($consulta)){
				$consultafilas = $this->Comunicacion->Consultar("SELECT * FROM jugadas WHERE loteria='".$_GET["loteria"]."' AND bloqueo<>'si' AND tipojugada<>'especial'");
				$numerodejugada = $this->Comunicacion->NFilas($consultafilas);
				if($numerodejugada<=$valor[0]){
					return "no";
				}
			}
			$consultar = $this->Comunicacion->Consultar("SELECT bloqueo FROM loterias WHERE loteria='".$_GET["loteria"]."'");
			if($bloqueo = $this->Comunicacion->Recorrido($consultar)){
				if($bloqueo[0]=="si"){
					return "no";
				}
			}
		}
		private function Sorteo(){
			$r="<option id='todos' selected>".$this->Comunicacion->Traductor("seleccione un sorteo")."</option>";
			$consulta = $this->Comunicacion->Consultar("SELECT hora FROM sorteo WHERE loteria='".$_GET["loteria"]."'");
			while($hora = $this->Comunicacion->Recorrido($consulta)){
				$r=$r."<option id='".$hora[0]."'>".$hora[0]."</option>";
			}
			return $r;
		}
	}
	new Loterias();
?>