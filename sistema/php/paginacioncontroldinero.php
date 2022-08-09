<?php
	Class Paginacioncontroldinero{
		private $Comunicacion;
		function Paginacioncontroldinero(){
			include("../../php/conexion.php");
			$this->Comunicacion = new Conexion();
			
			if(isset($_POST["fechainicial"]) && isset($_POST["fechafinal"]) && isset($_GET["tipodeusuario"]) && isset($_GET["pagina"])){
				echo $this->retorno($_POST["fechainicial"],$_POST["fechafinal"],$_GET["tipodeusuario"],$_GET["pagina"]);
				
			}
		}
		private function retorno($fecha1,$fecha2,$tipodeusuario,$pagina){
			
			$r="";
			if($tipodeusuario == "banca"){
				$consultacantidadbanca = $this->Comunicacion->Consultar("SELECT DISTINCT banca FROM controldinero WHERE usuariocreador='administrador'");
				$cantidadbancas = $this->Comunicacion->NFilas($consultacantidadbanca);
				$cantidadregistromostrar = 5;
				$total_paginas = ceil($cantidadbancas/$cantidadregistromostrar);
				$paginasiguiente = $pagina + 1;
				$paginaanterior = $pagina - 1;
				$inicio = ($pagina-1)*$cantidadregistromostrar;
				$r="<div style='display:flex; flex-direction:column'><table border='1' id='contenedorpagos'>
				<tr><th>Bancas</th><th>Ganancia</th><th>Premios A Responder</th><th>Total A Cobrar O Pagar</th></tr>";
				$consultabancas = $this->Comunicacion->Consultar("SELECT DISTINCT banca FROM controldinero WHERE usuariocreador='administrador' ORDER BY banca ASC LIMIT ".$inicio.",".$cantidadregistromostrar."");
				while($bancas = $this->Comunicacion->Recorrido($consultabancas)){
					
					$ganancia = 0;
					$premiosresponsables = 0;
					$totalacobrar = 0;
					for($i=$fecha1;$i<=$fecha2;$i = date("Y-m-d", strtotime($i ."+ 1 days"))){
						$consultaganancia = $this->Comunicacion->Consultar("SELECT SUM(ganancia),SUM(premiosresponsables) FROM controldinero WHERE banca='".$bancas[0]."' AND fecha='".$i."'");
						if($gananciadiaria = $this->Comunicacion->Recorrido($consultaganancia)){
							$ganancia = $gananciadiaria[0] + $ganancia;
							$premiosresponsables = $gananciadiaria[1]+$premiosresponsables;
						}
					}
					$totalacobrar = $ganancia - $premiosresponsables;
					$r=$r."<tr class='contenedorpago'>
						<td><center>".$bancas[0]."</center></td>
						<td><center>".$ganancia."</center></td>
						<td><center>".$premiosresponsables."</center></td>
						<td><center>".$totalacobrar."</center></td>
					</tr>";
				}
				
				
				$r=$r."</table>";
				if($total_paginas>$pagina){
					$r=$r."<div style='left:950px; top:70px' id='".$paginasiguiente."' class='botonsiguiete botondinerosiguiente'>></div>";
				}
				if($pagina>1){
					$r=$r."<div style='right:950px; top:70px' id='".$paginaanterior."' class='botonanterior botondineroanterios'><</div>";
				}
				$r=$r."</div><br>";
				$consultabotones = $this->Comunicacion->Consultar("SELECT DISTINCT banca FROM controldinero WHERE usuariocreador='administrador' ORDER BY banca ASC LIMIT ".$inicio.",".$cantidadregistromostrar."");
				while($botonesbancas = $this->Comunicacion->Recorrido($consultabotones)){
					$r=$r."<div style='width:500px;	margin:auto;' id='".$botonesbancas[0]."/".$fecha1."/".$fecha2."/".$tipodeusuario."' class='botoncobro boton'>Realizar Cobro</div>";
				}
			}else{
				$r="<div><table border='1' id='contenedorpagos'>
				<tr><th>Recolector</th><th>Ganancia</th><th>Premios A Responder</th><th>Total A Cobrar o Pagar</th></tr>";
				$consultarecolectores = $this->Comunicacion->Consultar("SELECT DISTINCT usuariocreador FROM controldinero WHERE usuariocreador<>'administrador'");
				$cantidadrecolectores = $this->Comunicacion->NFilas($consultarecolectores);
				$cantidadregistromostrar = 5;
				$total_paginas = ceil($cantidadrecolectores/$cantidadregistromostrar);
				$paginasiguiente = $pagina + 1;
				$paginaanterior = $pagina - 1;
				$inicio = ($pagina-1)*$cantidadregistromostrar;
				$consultabancas = $this->Comunicacion->Consultar("SELECT DISTINCT usuariocreador FROM controldinero WHERE usuariocreador<>'administrador' ORDER BY usuariocreador ASC LIMIT ".$inicio.",".$cantidadregistromostrar."");
				while($recolector = $this->Comunicacion->Recorrido($consultabancas)){
					
					$ganancia = 0;
					$premiosresponsables = 0;
					$totalacobrar = 0;
					for($i=$fecha1;$i<=$fecha2;$i = date("Y-m-d", strtotime($i ."+ 1 days"))){
						$consultaganancia = $this->Comunicacion->Consultar("SELECT SUM(ganancia),SUM(premiosresponsables) FROM controldinero WHERE usuariocreador='".$recolector[0]."' AND fecha='".$i."'");
						if($gananciadiaria = $this->Comunicacion->Recorrido($consultaganancia)){
							$ganancia = $gananciadiaria[0] + $ganancia;
							$premiosresponsables = $gananciadiaria[1]+$premiosresponsables;
						}
					}
					
					$totalacobrar = $ganancia-$premiosresponsables;
					$r=$r."<tr class='contenedorpago'>
						<td><center>".$recolector[0]."</center></td>
						<td><center>".$ganancia."</center></td>
						<td><center>".$premiosresponsables."</center></td>
						<td><center>".$totalacobrar."</center></td>
					</tr>";
				}
				$r=$r."</table>";
				
				if($total_paginas>$pagina){
					$r=$r."<div style='left:950px; top:70px' id='".$paginasiguiente."' class='botonsiguiete botondinerosiguiente'>></div>";
				}
				if($pagina>1){
					$r=$r."<div style='right:950px; top:70px' id='".$paginaanterior."' class='botonanterior botondineroanterios'><</div>";
				}
				$r=$r."</div><br>";
				$consultabotones = $this->Comunicacion->Consultar("SELECT DISTINCT usuariocreador FROM controldinero WHERE usuariocreador<>'administrador' ORDER BY usuariocreador ASC LIMIT ".$inicio.",".$cantidadregistromostrar."");
				while($botonesbancas = $this->Comunicacion->Recorrido($consultabotones)){
					$r=$r."<div style='width:500px;	margin:auto;' id='".$botonesbancas[0]."/".$fecha1."/".$fecha2."/".$tipodeusuario."' class='botoncobro boton'>Realizar Cobro</div>";
				}
			}
			return $r;
		}
	}
	new Paginacioncontroldinero();
?>