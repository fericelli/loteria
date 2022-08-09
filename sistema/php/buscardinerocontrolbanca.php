<?php
	Class Buscardinerocontrolbanca{
		private $Comunicacion;
		function Buscardinerocontrolbanca(){
			include("../../php/conexion.php");
			$this->Comunicacion = new Conexion();
			if(isset($_GET["usuario"]) && isset($_POST["fechainicial"]) && isset($_POST["fechafinal"])){
				
				echo $this->retorno($_POST["fechainicial"],$_POST["fechafinal"]);
			}
		}
		private function retorno($fecha1,$fecha2){
			$contorl = 0;
			$r="";
			$consultabanca = $this->Comunicacion->Consultar("SELECT * FROM controldinero WHERE banca='".$this->ComprobarBanca()."'");
			$cantidadregistros = $this->Comunicacion->NFilas($consultabanca);
			if($cantidadregistros>0){
				$ganancia=0;
				$dineroentregar = 0;
				$dinerofaltante = 0;
				$r="<div style='display:flex; flex-direction:column'><table border='1' id='contenedorpagos'>
				<tr><th>Ganancia</th><th>Dinero A Entregas</th><th>Dinero Faltante</th></tr>";
				for($i=$fecha1;$i<=$fecha2;$i = date("Y-m-d", strtotime($i ."+ 1 days"))){
					$consultaganancia = $this->Comunicacion->Consultar("SELECT SUM(gananciabanca),SUM(gananciarecolector),SUM(ganancia),SUM(premiosresponsables) FROM controldinero WHERE banca='".$this->ComprobarBanca()."' AND fecha='".$i."'");
					if($gananciadiaria = $this->Comunicacion->Recorrido($consultaganancia)){
						$ganancia = $gananciadiaria[0] + $ganancia;
						$dineroentregar = $dineroentregar+($gananciadiaria[1]+$gananciadiaria[2]-$gananciadiaria[3]);
					}
				}
				//return $dineroentregar;
				if($dineroentregar<0){
					$dinerofaltante = $dineroentregar*-1;
					$dineroentregar = 0;
				}
				$r=$r."<tr><td><center>".$ganancia."</center></td><td><center>".$dineroentregar."</center></td><td><center>".$dinerofaltante."</center></td></tr>";
			}
			return $r."</table></div>";
		}
		private function ComprobarBanca(){
			$consulta = $this->Comunicacion->Consultar("SELECT nombre FROM bancas WHERE usuario='".$_GET["usuario"]."'");
			if($banca = $this->Comunicacion->Recorrido($consulta)){
				return $banca[0];
			}
		}
	}
	new Buscardinerocontrolbanca();
?>