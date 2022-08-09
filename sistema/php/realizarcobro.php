<?php
	Class Realizarcobro{
		private $Comunicacion;
		function Realizarcobro(){
			include("../../php/conexion.php");
			$this->Comunicacion = new Conexion();
			if(isset($_GET["variables"])){
				$porciones = explode("/",$_GET["variables"]);
				$this->GananciaTotal($porciones[0],$porciones[1],$porciones[2],$porciones[3]);
				$this->FinalizarCobro($porciones[0],$porciones[1],$porciones[2],$porciones[3]);
				echo $this->retorno($porciones[1],$porciones[2],$porciones[3]);
			}
		}
		private function GananciaTotal($usuario,$fecha1,$fecha2,$tipodeusuario){
			if($tipodeusuario == "banca"){
				$ganancia = 0;
				$premiosresponsables = 0;
				$totalacobrar = 0;
				$totaldineroprogramador = 0;
				$totaldinerootros = 0;
				for($i=$fecha1;$i<=$fecha2;$i = date("Y-m-d", strtotime($i ."+ 1 days"))){
					$consultaganancia = $this->Comunicacion->Consultar("SELECT SUM(ganancia),SUM(premiosresponsables) FROM controldinero WHERE banca='".$usuario."' AND fecha='".$i."'");
					if($gananciadiaria = $this->Comunicacion->Recorrido($consultaganancia)){
						$ganancia = $gananciadiaria[0] + $ganancia;
						$premiosresponsables = $gananciadiaria[1]+$premiosresponsables;
					}
				}
				
				$totalacobrar = $ganancia - $premiosresponsables;
				$consultaporcentaje = $this->Comunicacion->Consultar("SELECT porcentage FROM ganancia WHERE socios='programador'");
				if($porcentage = $this->Comunicacion->Recorrido($consultaporcentaje)){
					if($totalacobrar<0){
						$totalacobrar = $totalacobrar * -1;
						$totaldineroprogramador = $totalacobrar * $porcentage[0];
						$totaldineroprogramador = $totaldineroprogramador/100;
						$totaldinerootros = $totalacobrar - $totaldineroprogramador;
						$totaldineroprogramador = $totaldineroprogramador * -1;
						$totaldinerootros = $totaldinerootros * -1;
					}else{
						$totaldineroprogramador = $totalacobrar * $porcentage[0];
						$totaldineroprogramador = $totaldineroprogramador/100;
						$totaldinerootros = $totalacobrar - $totaldineroprogramador;
					}
					
					$this->Comunicacion->Consultar("UPDATE ganancia SET ganancia=ganancia+".$totaldinerootros." WHERE socios='otros'");
					$this->Comunicacion->Consultar("UPDATE ganancia SET ganancia=ganancia+".$totaldineroprogramador." WHERE socios='programador'");
				}
			}else{
				
				$ganancia = 0;
				$premiosresponsables = 0;
				$totalacobrar = 0;
				for($i=$fecha1;$i<=$fecha2;$i = date("Y-m-d", strtotime($i ."+ 1 days"))){
					$consultaganancia = $this->Comunicacion->Consultar("SELECT SUM(ganancia),SUM(premiosresponsables) FROM controldinero WHERE usuariocreador='".$usuario."' AND fecha='".$i."'");
					if($gananciadiaria = $this->Comunicacion->Recorrido($consultaganancia)){
						$ganancia = $gananciadiaria[0] + $ganancia;
						$premiosresponsables = $gananciadiaria[1]+$premiosresponsables;
					}
				}
				$totalacobrar = $ganancia-$premiosresponsables;
				$consultaporcentaje = $this->Comunicacion->Consultar("SELECT porcentage FROM ganancia WHERE socios='programador'");
				if($porcentage = $this->Comunicacion->Recorrido($consultaporcentaje)){
					if($totalacobrar<0){
						$totalacobrar = $totalacobrar * -1;
						$totaldineroprogramador = $totalacobrar * $porcentage[0];
						$totaldineroprogramador = $totaldineroprogramador/100;
						$totaldinerootros = $totalacobrar - $totaldineroprogramador;
						$totaldineroprogramador = $totaldineroprogramador * -1;
						$totaldinerootros = $totaldinerootros * -1;
					}else{
						$totaldineroprogramador = $totalacobrar * $porcentage[0];
						$totaldineroprogramador = $totaldineroprogramador/100;
						$totaldinerootros = $totalacobrar - $totaldineroprogramador;
					}
					
					$this->Comunicacion->Consultar("UPDATE ganancia SET ganancia=ganancia+".$totaldinerootros." WHERE socios='otros'");
					$this->Comunicacion->Consultar("UPDATE ganancia SET ganancia=ganancia+".$totaldineroprogramador." WHERE socios='programador'");
				}
			}
		}
		private function FinalizarCobro($usuario,$fecha1,$fecha2,$tipodeusuario){
			//return  $fecha1." ".$fecha2." ".$usuario." ".$tipodeusuario;
			if($tipodeusuario == "banca"){
				for($i=$fecha1;$i<=$fecha2;$i = date("Y-m-d", strtotime($i ."+ 1 days"))){
					$this->Comunicacion->Consultar("DELETE FROM controldinero WHERE banca='".$usuario."' AND fecha='".$i."'");
				}
			}else{
				for($i=$fecha1;$i<=$fecha2;$i = date("Y-m-d", strtotime($i ."+ 1 days"))){
					$this->Comunicacion->Consultar("DELETE FROM controldinero WHERE usuariocreador='".$usuario."' AND fecha='".$i."'");
				}
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
				//return "SELECT DISTINCT banca FROM controldinero WHERE usuariocreador='administrador' ORDER BY banca LIMIT 0,".$cantidadregistromostrar."";
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
				$consultabancas = $this->Comunicacion->Consultar("SELECT DISTINCT usuariocreador FROM controldinero WHERE usuariocreador = '".$this->UsuarioCreador()."' AND usuariocreador<>'administrador' ORDER BY usuariocreador ASC LIMIT 0,".$cantidadregistromostrar."");
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
				$consultabotones = $this->Comunicacion->Consultar("SELECT DISTINCT usuariocreador FROM controldinero WHERE usuariocreador = '".$this->UsuarioCreador()."' AND usuariocreador<>'administrador' ORDER BY usuariocreador LIMIT 0,".$cantidadregistromostrar."");
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
	new Realizarcobro();
?>