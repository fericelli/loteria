<?php
	Class Modificarporcentageganancia{
		private $Comunicacion;
		function Modificarporcentageganancia(){
			include("../../php/conexion.php");
			$this->Comunicacion = new Conexion();
			if(isset($_POST["porcentage"]) && isset($_GET["tipodeusuario"])){
				$this->modificar();
				echo $this->TablaPorcentageDeGanancia();
			}
		}
		private function modificar(){
			$consulta = $this->Comunicacion->Consultar("UPDATE porcentajes SET porcentaje='".$_POST["porcentage"]."' WHERE nombre='".$_GET["tipodeusuario"]."'");
			if($consulta==true){
				return "bien";
			}
		}
		private function TablaPorcentageDeGanancia(){
			$r="<div id='administrar-porcentages'>";
			$consulta = $this->Comunicacion->Consultar("SELECT * FROM porcentajes");
			while($porcentajes = $this->Comunicacion->Recorrido($consulta)){
				$r = $r."<div class='botones botonescontrolporcentage'><div id='".$porcentajes[0]."' class='boton  modifiporcentageganancia'>Modificar Porcentage</div></div>";
			}
			$r = $r."<div class='contenedor'>";
			$consul = $this->Comunicacion->Consultar("SELECT * FROM porcentajes");
			while($listaporcentajes = $this->Comunicacion->Recorrido($consul)){
				$r=$r."<div class='contenedor-porcentages'>
					<div>".$listaporcentajes[0]."</div>
					<div>".$listaporcentajes[1]."</div>
				</div>";
			}
			$r = $r."</div>
			</div>
			<div style='display:none' class='modificar-porcntageganancia'>
					<div style='display:none' class='mensajevalorporcentage boton'>Datos Modificados</div>
					<div>
						<p style='display:none' class='conpletecampoporcentage'>Complete El Campo</p>
						<p style='display:none' class='conpletecampoapuestaporcentagenumerico'>Ingrese Valor Numérico</p>
						<input id='valorporcentagenuevo' type='text' placeholder='Valor Apuesta Nuevo'>
					</div><br>";
			$consull = $this->Comunicacion->Consultar("SELECT * FROM porcentajes");
			while($row = $this->Comunicacion->Recorrido($consull)){
				$r=$r."<div style='display:none' id='".$row[0]."' class='boton modificarvalorporcentagegaancia'>Modificar</div><br>";
			}
			$r=$r."<div class='boton salirmodificarporcentageganancia'>Salir</div>
				</div>";
			return $r;
		}
	}
	new Modificarporcentageganancia();
?>