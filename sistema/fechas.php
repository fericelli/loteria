<?php
	Class Fechas{
		function Fechas(){
			echo $this->retorno();
		}
		private function retorno(){
			$fecha1 = "2010-02-25";
			$fecha2 = "2010-02-25";
			$retorno = "";
			for($i=$fecha1;$i<=$fecha2;$i = date("Y-m-d", strtotime($i ."+ 1 days"))){
				$retorno = $retorno. $i . "<br />";
			 //aca puedes comparar $i a una fecha en la bd y guardar el resultado en un arreglo

			}
			return $retorno;
		}
	}
	new Fechas();
?>