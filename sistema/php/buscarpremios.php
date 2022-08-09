<?php
	Class Buscarpremios{
		private $Comunicacion;
		function Buscarpremios(){
			include("../../php/conexion.php");
			$this->Comunicacion = new Conexion();
			if(isset($_POST["codigo"]) && isset($_GET["usuario"])){
				$codigo = $this->Banca()."-".$_POST["codigo"];
				echo $this->retorno($codigo);
			}
		}
		private function retorno($codigo){
			$consulta = $this->Comunicacion->Consultar("SELECT fecha,sorteo,hora FROM ganadores WHERE codigo='".$codigo."' AND banca='".$this->Banca()."'");
			$r="";
			if($cofirmar = $this->Comunicacion->Recorrido($consulta)){
				$pagar=0;
				$date = date_create($cofirmar[0]);
				$fecha = date_format($date, 'd-m-Y');
				$r="<div style='display:flex;justify-content:space-around'><div>fecha:".$fecha."</div><div>hora:".$cofirmar[2]."</div><div>sorteo:".$cofirmar[1]."</div></div>";
				$consultaretorno = $this->Comunicacion->Consultar("SELECT loteria,jugada,ganancia FROM ganadores WHERE codigo='".$codigo."' AND banca='".$this->Banca()."'");
				while($retorno = $this->Comunicacion->Recorrido($consultaretorno)){
					$pagar=$retorno[2]+$pagar;
					$r=$r."<div style='display:flex;justify-content:space-around'><div>".$retorno[0]."</div><div>".$retorno[1]."</div><div>".$retorno[2]."</div></div>";
				}
				$r=$r."<div style='display:flex;justify-content:space-around'><div>Total A Pagar</div><div>".$pagar."</div></div>";
				$r=$r."<br><div id='".$codigo."' class='boton pagarpremio'>Realizar Pago</div><br>img class='cargabuspagar' style='display:none' src='imagenes/cargando.gif'>";
				$r=$r."<br><div class='boton cancelarpago'>Cancelar Pago</div>";
				return $r;
			}else{
				return "no premiado";
			}
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
	new Buscarpremios();
?>