<?php
	Class Paginacioncontroldinerorecolector{
		private $Comunicacion;
		function Paginacioncontroldinerorecolector(){
			include("../../php/conexion.php");
			$this->Comunicacion = new Conexion();
			if(isset($_POST["fechainicial"]) && isset($_POST["fechafinal"]) && isset($_GET["usuario"]) && isset($_GET["pagina"])){
				
				echo $this->retorno($_POST["fechainicial"],$_POST["fechafinal"],$_GET["pagina"]);
			}
		}
		private function retorno($fecha1,$fecha2,$pagina){
			$r="<div><table border='1' id='contenedorpagos'>
			<tr><th>Bancas</th><th>Ganancia</th><th>Premios A Responder</th><th>Dinero A Entregar</th><th>Total A Cobrar O Pagar</th></tr>";
			$consultacantidadbancas = $this->Comunicacion->Consultar("SELECT DISTINCT banca FROM controldinero WHERE usuariocreador='".$this->NombreDeRecolector($_GET["usuario"])."' AND pagorecolector<>'si'");
			$cantidadbancas = $this->Comunicacion->NFilas($consultacantidadbancas);
			$cantidadregistromostrar = 10;
			$total_paginas = ceil($cantidadbancas/$cantidadregistromostrar);
			$paginasiguiente = $pagina + 1;
			$paginaanterior = $pagina - 1;
			$inicio = ($pagina-1)*$cantidadregistromostrar;
			
			$consultabancas = $this->Comunicacion->Consultar("SELECT DISTINCT banca FROM controldinero WHERE usuariocreador='".$this->NombreDeRecolector($_GET["usuario"])."' AND pagorecolector<>'si' ORDER BY banca LIMIT ".$inicio.",".$cantidadregistromostrar."");
			while($bancas = $this->Comunicacion->Recorrido($consultabancas)){
				$ganancia = 0;
				$premiosresponsables = 0;
				$totalacobrar = 0;
				$dineroaentregar = 0;
				for($i=$fecha1;$i<=$fecha2;$i = date("Y-m-d", strtotime($i ."+ 1 days"))){
					$consultaganancia = $this->Comunicacion->Consultar("SELECT SUM(ganancia),SUM(premiosresponsables),SUM(gananciarecolector) FROM controldinero WHERE banca='".$bancas[0]."' AND fecha='".$i."' AND pagorecolector<>'si'");
					if($gananciadiaria = $this->Comunicacion->Recorrido($consultaganancia)){
						$dineroaentregar = $gananciadiaria[0] + $dineroaentregar;
						$ganancia = $gananciadiaria[2] + $ganancia;
						$premiosresponsables = $gananciadiaria[1]+$premiosresponsables;
					}
				}
				$dineroaentregar = $dineroaentregar - $premiosresponsables;
				if($dineroaentregar<0){
					$dineroaentregar=0;
				}
				$totalacobrar = $ganancia + $dineroaentregar - $premiosresponsables;
				$r=$r."<tr class='contenedorpagorecolector'>
					<td><center>".$bancas[0]."</center></td>
					<td><center>".$ganancia."</center></td>
					<td><center>".$premiosresponsables."</center></td>
					<td><center>".$dineroaentregar."</center></td>
					<td><center>".$totalacobrar."</center></td>
				</tr>";
			}
			$r=$r."</table>";
			if($total_paginas>$pagina){
					$r=$r."<div style='left:950px; top:70px' id='".$paginasiguiente."' class='botonsiguiete botondinerosiguienterecolector'>></div>";
			}
			if($pagina>1){
				$r=$r."<div style='right:950px; top:70px' id='".$paginaanterior."' class='botonanterior botondineroanteriorrecolector'><</div>";
			}
			$r=$r."</div><br>";
			$consultabotones = $this->Comunicacion->Consultar("SELECT DISTINCT banca FROM controldinero WHERE usuariocreador='".$this->NombreDeRecolector($_GET["usuario"])."' AND pagorecolector<>'si' ORDER BY banca LIMIT ".$inicio.",".$cantidadregistromostrar."");
			while($botonesbancas = $this->Comunicacion->Recorrido($consultabotones)){
				$r=$r."<div style='width:500px;	margin:auto;' id='".$botonesbancas[0]."/".$fecha1."/".$fecha2."' class='botoncobrorecolector boton'>Realizar Cobro</div>";
			}
			return $r;
			
		}
		private function NombreDeRecolector($usuario){
			$consultar = $this->Comunicacion->Consultar("SELECT nombre FROM recolectores WHERE usuario='".$usuario."'");
			if($nombre = $this->Comunicacion->Recorrido($consultar)){
				return $nombre[0];
			}
		}
	}
	new Paginacioncontroldinerorecolector();
?>