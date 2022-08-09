<?php
	Class Verbalance{
		private $Comunicacion;
		function Verbalance(){
			include("../../php/conexion.php");
			$this->Comunicacion = new Conexion();
			if(isset($_GET["usuario"])){
				echo $this->retorno();
			}
		}
		private function retorno(){
			$dinerobanca = 0;
			$gananciabanca = 0;
			$dineroaentregar = 0;
			$premiosporpagar = 0;
			$dineroarecibir = 0;
			$r="";
			//return "SELECT SUM(gananciabanca),SUM(gananciarecolector),SUM(ganancia),SUM(premiosresposables) FROM controldinero WHERE banca='".$this->Banca()."'";
			$consultacontroldinero = $this->Comunicacion->Consultar("SELECT SUM(gananciabanca),SUM(gananciarecolector),SUM(ganancia),SUM(premiosresponsables) FROM controldinero WHERE banca='".$this->Banca()."'");
			
			if($controldinero = $this->Comunicacion->Recorrido($consultacontroldinero)){
				
				$gananciabanca = $controldinero[0];
				$dineroaentregar = $controldinero[1] + $controldinero[2] - $controldinero[3];
				
			}
			
			//return "SELECT dinero,premiosporpagar FROM dinerobanca WHERE banca='".$this->Banca()."'";
			$consultacontroldinerobanca = $this->Comunicacion->Consultar("SELECT dinero,premiosporpagar FROM dinerobanca WHERE banca='".$this->Banca()."'");
			if($controldinerobanca = $this->Comunicacion->Recorrido($consultacontroldinerobanca)){
				$dinerobanca = $controldinerobanca[0];
				 $premiosporpagar = $controldinerobanca[1];
			}
			$dineroarecibir = $dineroaentregar * -1;
			$r = $r.'<div class="formulario"><div>Dinero Disponible = '.$dinerobanca.'</div>
			<div>Ganancia Banca = '.$gananciabanca.'</div>';
			if($dineroaentregar>=0){
				$r=$r.'<div>Dinero A Entregar = '.$dineroaentregar.'</div>';
			}else{
				$r=$r.'<div>Dinero A Recibir = '.$dineroarecibir.'</div>';
			}
			
			$r=$r.'<div>Premios Por Pagar = '.$premiosporpagar.'</div></div>';
			return $r;
		}
		private function Banca(){
			$consulta = $this->Comunicacion->Consultar("SELECT nombre FROM bancas WHERE usuario='".$_GET["usuario"]."'");
			if($row = $this->Comunicacion->Recorrido($consulta)){
				return $row[0];
			}else{
				return "";
			}
		}
	}
	new Verbalance();
?>