<?php
	Class Buscarcontroldinero{
		private $Comunicacion;
		function Buscarcontroldinero(){
			include("../../php/conexion.php");
			$this->Comunicacion = new Conexion();
			if(isset($_POST["fechainicial"]) && isset($_POST["fechafinal"]) && isset($_GET["tipodeusuario"])){
				
				echo $this->retorno($_POST["fechainicial"],$_POST["fechafinal"],$_GET["tipodeusuario"]);
			}
		}
		private function retorno($fecha1,$fecha2,$tipodeusuario){
			$contorl = 0;
			$r="";
			if($tipodeusuario == "banca"){
				$consultacantidadbanca = $this->Comunicacion->Consultar("SELECT DISTINCT banca FROM controldinero WHERE usuariocreador='administrador'");
				$cantidadbancas = $this->Comunicacion->NFilas($consultacantidadbanca);
				$cantidadregistromostrar = 5;
				$pagina = 1;
				$paginasiguiente = $pagina + 1;
				$r="<div style='display:flex; flex-direction:column'><table border='1' id='contenedorpagos'>
				<tr><th>Bancas</th><th>Ganancia</th><th>Premios A Responder</th><th>Total A Cobrar O Pagar</th></tr>";
				$consultabancas = $this->Comunicacion->Consultar("SELECT DISTINCT banca FROM controldinero WHERE usuariocreador='administrador' ORDER BY banca LIMIT 0,".$cantidadregistromostrar."");
				while($bancas = $this->Comunicacion->Recorrido($consultabancas)){
					$contorl ++;
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
				if($cantidadbancas>$cantidadregistromostrar){
					$r=$r."<div style='left:950px; top:70px' id='".$paginasiguiente."' class='botonsiguiete botondinerosiguiente'>></div>";
				}
				$r=$r."</div><br>";
				$consultabotones = $this->Comunicacion->Consultar("SELECT DISTINCT banca FROM controldinero WHERE usuariocreador='administrador' ORDER BY banca LIMIT 0,".$cantidadregistromostrar."");
				while($botonesbancas = $this->Comunicacion->Recorrido($consultabotones)){
					$r=$r."<div style='width:500px;	margin:auto;' id='".$botonesbancas[0]."/".$fecha1."/".$fecha2."/".$tipodeusuario."' class='botoncobro boton'>Realizar Cobro</div>";
				}
			}else{
				$r="<div><table border='1' id='contenedorpagos'>
				<tr><th>Recolector</th><th>Ganancia</th><th>Premios A Responder</th><th>Total A Cobrar o Pagar</th></tr>";
				$consultarecolectores = $this->Comunicacion->Consultar("SELECT DISTINCT usuariocreador FROM controldinero WHERE usuariocreador<>'administrador'");
				$cantidadrecolectores = $this->Comunicacion->NFilas($consultarecolectores);
				$cantidadregistromostrar = 5;
				$pagina = 1;
				$paginasiguiente = $pagina + 1;
				$consultabancas = $this->Comunicacion->Consultar("SELECT DISTINCT usuariocreador FROM controldinero WHERE usuariocreador<>'administrador' ORDER BY usuariocreador ASC LIMIT 0,".$cantidadregistromostrar."");
				while($recolector = $this->Comunicacion->Recorrido($consultabancas)){
					$contorl ++;
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
				if($cantidadrecolectores>$cantidadregistromostrar){
					$r=$r."<div style='left:950px; top:70px' id='".$paginasiguiente."' class='botonsiguiete botondinerosiguiente'>></div>";
				}
				$r=$r."</div><br>";
				$consultabotones = $this->Comunicacion->Consultar("SELECT DISTINCT usuariocreador FROM controldinero WHERE usuariocreador<>'administrador' ORDER BY usuariocreador ASC LIMIT 0,".$cantidadregistromostrar."");
				while($botonesbancas = $this->Comunicacion->Recorrido($consultabotones)){
					$r=$r."<div style='width:500px;	margin:auto;' id='".$botonesbancas[0]."/".$fecha1."/".$fecha2."/".$tipodeusuario."' class='botoncobro boton'>Realizar Cobro</div>";
				}
			}
			if($contorl>0){
				return $r;
			}else{
				return "";
			}
		}
		
	}
	new Buscarcontroldinero();
?>