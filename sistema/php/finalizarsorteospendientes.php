<?php
	Class Finalizarsorteospendientes{
		private $Comunicacion;
		function Finalizarsorteospendientes(){
			include("../../php/conexion.php");
			$this->Comunicacion = new Conexion();
			if(isset($_GET["fecha"]) && isset($_GET["sorteo"])){
				ECHO $this->GenerarSorteo();
				echo $this->Retorno();
			}
		}
		
		private function GenerarSorteo(){
			$porciones = explode("-",$_GET["sorteo"]);
			$jugada ="";
			$ganancia = 0;
			$gananciatotalbanca = 0;
			$gananciatotalrecolector = 0;
			$dineroarepatir = 0;
			
			$consultadinerototal = $this->Comunicacion->Consultar("SELECT dinero FROM dineroapostado WHERE fecha='".$_GET["fecha"]."' AND sorteo='".$porciones[1]."' AND loteria='".$porciones[0]."'");
			if($dinerototal = $this->Comunicacion->Recorrido($consultadinerototal)){
				
				$consultabancas = $this->Comunicacion->Consultar("SELECT DISTINCT banca FROM apuesta WHERE fecha='".$_GET["fecha"]."' AND sorteo='".$porciones[1]."' AND loteria='".$porciones[0]."'");
				while($bancas = $this->Comunicacion->Recorrido($consultabancas)){
					//return "SELECT * FROM controldinerobanca WHERE banca='".$bancas[0]."' AND fecha='".$_GET["fecha"]."' AND sorteo='".$porciones[1]."' AND loteria='".$porciones[0]."'";
					$consultadinerobanca = $this->Comunicacion->Consultar("SELECT * FROM controldinerobanca WHERE banca='".$bancas[0]."' AND fecha='".$_GET["fecha"]."' AND sorteo='".$porciones[1]."' AND loteria='".$porciones[0]."'");
					if($dinerobanca = $this->Comunicacion->Recorrido($consultadinerobanca)){
						$consultarinformacionbanca = $this->Comunicacion->Consultar("SELECT * FROM bancas WHERE nombre='".$bancas[0]."'");
						if($banca = $this->Comunicacion->Recorrido($consultarinformacionbanca)){
							$gananciatotalbanca = $dinerobanca[6] * $banca[5];
							$gananciatotalbanca = $gananciatotalbanca/100;
							if($banca[2]="recolector"){
								//return "SELECT * FROM recolectores WHERE usuario='".$banca[3]."'";
								$consultaporcentajerecolector = $this->Comunicacion->Consultar("SELECT * FROM recolectores WHERE usuario='".$banca[3]."'");
								if($recolector = $this->Comunicacion->Recorrido($consultaporcentajerecolector)){
									$porcentajerecolector = 0;
									$porcentajerecolector = $recolector[5]-$banca[5];
									$gananciatotalrecolector = $dinerobanca[6] * $porcentajerecolector;
									$gananciatotalrecolector = $gananciatotalrecolector /100;
								}
							}
						}
						//return "INSERT INTO controlsorteofinalizado(banca,gananciabanca,gananciarecolector,gananciajugadores,efectivobanca) VALUES ('".$_GET["fecha"]."','".$porciones[1]."','".$porciones[0]."','".$bancas[0]."','".$gananciatotalbanca."','".$gananciatotalrecolector."',0,'".$dinerobanca[6]."')";
						$this->Comunicacion->Consultar("INSERT INTO controlsorteofinalizado(banca,gananciabanca,gananciarecolector,gananciajugadores,efectivobanca) VALUES ('".$bancas[0]."','".$gananciatotalbanca."','".$gananciatotalrecolector."',0,'".$dinerobanca[6]."')");
					}
				}
				$consultaporcentageganancia = $this->Comunicacion->Consultar("SELECT porcentaje FROM porcentajes WHERE nombre='sorteos'");
				if($porcentajeganancia = $this->Comunicacion->Recorrido($consultaporcentageganancia)){
					$ganancia = $dinerototal[0] * $porcentajeganancia[0];
					$ganancia = $ganancia/100;
					$cantidadarepartir = $dinerototal[0]-$ganancia-$gananciatotalbanca-$gananciatotalrecolector;
					//return "SELECT jugada,dinero FROM controlsorteo WHERE dinero=(SELECT MAX(dinero) FROM controlsorteo WHERE dinero<='".$cantidadarepartir."' AND fecha='".$_GET["fecha"]."' AND sorteo='".$porciones[1]."' AND loteria='".$porciones[0]."')";
					$consultaminimo = $this->Comunicacion->Consultar("SELECT jugada,dinero FROM controlsorteo WHERE dinero=(SELECT MAX(dinero) FROM controlsorteo WHERE dinero<'".$cantidadarepartir."' AND fecha='".$_GET["fecha"]."' AND sorteo='".$porciones[1]."' AND loteria='".$porciones[0]."')");
					if($dinerorepartir = $this->Comunicacion->Recorrido($consultaminimo)){
						$jugada = $dinerorepartir[0];
						$dineroarepatir = $dinerorepartir[1];
						if($dineroarepatir==0){
							$consuulta = $this->Comunicacion->Consultar("SELECT jugada FROM controlsorteo WHERE dinero=0 ORDER BY RAND()");
							if($jugadaaleatoria = $this->Comunicacion->Recorrido($consuulta)){
								$jugada = $jugadaaleatoria[0];
							}
						}
					}else{
						
						$this->Comunicacion->Consultar("TRUNCATE TABLE controlsorteofinalizado");
						$consultaotrajugada = $this->Comunicacion->Consultar("SELECT jugada,dinero FROM controlsorteo WHERE dinero=(SELECT MIN(dinero) FROM controlsorteo WHERE fecha='2018-01-25' AND sorteo='09:00' AND loteria='Animalitos') ORDER BY RAND()");
						if($jugadaminima = $this->Comunicacion->Recorrido($consultaotrajugada)){
							$jugada = $jugadaminima[0];
						}
						//return $jugada;
						$consultabancas = $this->Comunicacion->Consultar("SELECT DISTINCT banca FROM apuesta WHERE fecha='".$_GET["fecha"]."' AND sorteo='".$porciones[1]."' AND loteria='".$porciones[0]."'");
						while($bancas = $this->Comunicacion->Recorrido($consultabancas)){
							//return "SELECT * FROM controldinerobanca WHERE banca='".$bancas[0]."' AND fecha='".$_GET["fecha"]."' AND sorteo='".$porciones[1]."' AND loteria='".$porciones[0]."'";
							$consultadinerobanca = $this->Comunicacion->Consultar("SELECT * FROM controldinerobanca WHERE banca='".$bancas[0]."' AND fecha='".$_GET["fecha"]."' AND sorteo='".$porciones[1]."' AND loteria='".$porciones[0]."'");
							if($dinerobanca = $this->Comunicacion->Recorrido($consultadinerobanca)){
								$consultarinformacionbanca = $this->Comunicacion->Consultar("SELECT * FROM bancas WHERE nombre='".$bancas[0]."'");
								if($banca = $this->Comunicacion->Recorrido($consultarinformacionbanca)){
									$porcentajegananciabanca = $this->porcentangejugada($porciones[0])*60;
									$porcentajegananciabanca = $porcentajegananciabanca/100;
									$gananciatotalbanca = $dinerobanca[6] * $porcentajegananciabanca;
									$gananciatotalbanca = $gananciatotalbanca/100;
									if($banca[2]="recolector"){
										//return "SELECT * FROM recolectores WHERE usuario='".$banca[3]."'";
										$consultaporcentajerecolector = $this->Comunicacion->Consultar("SELECT * FROM recolectores WHERE usuario='".$banca[3]."'");
										if($recolector = $this->Comunicacion->Recorrido($consultaporcentajerecolector)){
											$porcentajerecolector = $this->porcentangejugada($porciones[0])*30;
											$porcentajerecolector = $porcentajerecolector/100;
											$gananciatotalrecolector = $dinerobanca[6] * $porcentajerecolector;
											$gananciatotalrecolector = $gananciatotalrecolector /100;
										}
									}
								}
								//return "INSERT INTO controlsorteofinalizado(banca,gananciabanca,gananciarecolector,gananciajugadores,efectivobanca) VALUES ('".$_GET["fecha"]."','".$porciones[1]."','".$porciones[0]."','".$bancas[0]."','".$gananciatotalbanca."','".$gananciatotalrecolector."',0,'".$dinerobanca[6]."')";
								$this->Comunicacion->Consultar("INSERT INTO controlsorteofinalizado(banca,gananciabanca,gananciarecolector,gananciajugadores,efectivobanca) VALUES ('".$bancas[0]."','".$gananciatotalbanca."','".$gananciatotalrecolector."',0,'".$dinerobanca[6]."')");
							}
						}
					}
					
					
				}
			}	
			$consultajugadasganandas = $this->Comunicacion->Consultar("SELECT codigo,ganancia,hora,banca FROM apuesta WHERE jugada='".$jugada."' AND fecha='".$_GET["fecha"]."' AND sorteo='".$porciones[1]."' AND loteria='".$porciones[0]."'"); 
			while($apuestasganadoras = $this->Comunicacion->Recorrido($consultajugadasganandas)){
				$this->Comunicacion->Consultar("INSERT INTO ganadores(codigo,banca,jugada,loteria,ganancia,fecha,sorteo,hora) VALUES ('".$apuestasganadoras[0]."','".$apuestasganadoras[3]."','".$jugada."','".$porciones[0]."','".$apuestasganadoras[1]."','".$_GET["fecha"]."','".$porciones[1]."','".$apuestasganadoras[2]."')");
				$this->Comunicacion->Consultar("UPDATE controlsorteofinalizado SET gananciajugadores=gananciajugadores+".$apuestasganadoras[1]." WHERE banca='".$apuestasganadoras[3]."'");
			}
			$gananciaenbanca = 0;
			$premiosresponsables = 0;
			//RETURN "SELECT * FROM controlsorteofinalizado";
			$consultasorteofinalizado = $this->Comunicacion->Consultar("SELECT * FROM controlsorteofinalizado"); 
			while($controlsorteofinalizado = $this->Comunicacion->Recorrido($consultasorteofinalizado)){
				$gananciaenbanca = $controlsorteofinalizado[4] - $controlsorteofinalizado[3] - $controlsorteofinalizado[2] - $controlsorteofinalizado[1];
				if($gananciaenbanca<0){
					$gananciaenbanca = 0;
					$premiosresponsables = $gananciaenbanca*-1;
				}
				$this->Comunicacion->Consultar("INSERT INTO controldinero(banca,usuariocreador,fecha,sorteo,gananciabanca,gananciarecolector,ganancia,pagorecolector,premiosresponsables,loteria) VALUES ('".$controlsorteofinalizado[0]."','".$this->UsuarioCreador($controlsorteofinalizado[0])."','".$_GET["fecha"]."','".$porciones[1]."','".$controlsorteofinalizado[1]."','".$controlsorteofinalizado[2]."','".$gananciaenbanca."','','".$premiosresponsables."','".$porciones[0]."')");
							
			}
			$this->Comunicacion->Consultar("INSERT INTO jugadasganadoras(sorteo,loteria,jugada) VALUES ('".$_GET["fecha"]." ".$porciones[1]."','".$porciones[0]."','".$jugada."')");
			$this->Comunicacion->Consultar("DELETE FROM apuesta WHERE fecha='".$_GET["fecha"]."' AND sorteo='".$porciones[1]."' AND loteria='".$porciones[0]."'");
			$this->Comunicacion->Consultar("DELETE FROM controldinerobanca WHERE fecha='".$_GET["fecha"]."' AND sorteo='".$porciones[1]."' AND loteria='".$porciones[0]."'");
			$this->Comunicacion->Consultar("DELETE FROM controlsorteo WHERE fecha='".$_GET["fecha"]."' AND sorteo='".$porciones[1]."' AND loteria='".$porciones[0]."' AND loteria='".$porciones[0]."'");
			$this->Comunicacion->Consultar("TRUNCATE TABLE controlsorteofinalizado");
			$this->Comunicacion->Consultar("DELETE FROM dineroapostado WHERE fecha='".$_GET["fecha"]."' AND sorteo='".$porciones[1]."' AND loteria='".$porciones[0]."'");	
			
		}
		private function PorcentageGananciaBanca(){
			$consulta = $this->Comunicacion->Consultar("SELECT porcentaje FROM porcentajes WHERE nombre='banca'");
			if($porcentaje = $this->Comunicacion->Recorrido($consulta)){
				return $porcentaje[0];
			}
		}
		private function PorcentageGananciaRecolector(){
			$consulta = $this->Comunicacion->Consultar("SELECT porcentaje FROM porcentajes WHERE nombre='recolector'");
			if($porcentaje = $this->Comunicacion->Recorrido($consulta)){
				return $porcentaje[0];
			}
		}
		private function PorcentageGananciaBancaRecolector(){
			$consulta = $this->Comunicacion->Consultar("SELECT porcentaje FROM porcentajes WHERE nombre='bancorecolector'");
			if($porcentaje = $this->Comunicacion->Recorrido($consulta)){
				return $porcentaje[0];
			}
		}
		private function ConfirmarRecolector($banca){
			$consulta = $this->Comunicacion->Consultar("SELECT usuariocreador FROM bancas WHERE nombre='".$banca."'");
			if($usuariorecolector = $this->Comunicacion->Recorrido($consulta)){
				$consul = $this->Comunicacion->Consultar("SELECT tipodeusuario FROM usuarios WHERE nick='".$usuariorecolector[0]."'");
				if($tipodeusuario = $this->Comunicacion->Recorrido($consul)){
					if($tipodeusuario[0]=="recolector"){
						return "si";
					}
				}
			}
		}
		private function UsuarioCreador($banca){
			$consulta = $this->Comunicacion->Consultar("SELECT creador,usuariocreador FROM bancas WHERE nombre='".$banca."'");
			if($creador = $this->Comunicacion->Recorrido($consulta)){
				if($creador[0]=="administrador"){
					return $creador[0];
				}else{	
					return $this->NombreDeRecolector($creador[1]);
				}
			}
		}
		private function NombreDeRecolector($usuario){
			$consultar = $this->Comunicacion->Consultar("SELECT nombre FROM recolectores WHERE usuario='".$usuario."'");
			if($nombre = $this->Comunicacion->Recorrido($consultar)){
				return $nombre[0];
			}
		}
		private function porcentangejugada($loteria){
			$consultavalorapuesta = $this->Comunicacion->Consultar("SELECT valorapuesta FROM loterias WHERE loteria='".$loteria."'");
			if($valorapuesta = $this->Comunicacion->Recorrido($consultavalorapuesta)){
				$consultajugadas = $this->Comunicacion->Consultar("SELECT * FROM jugadas WHERE loteria='".$loteria."'");
				$cantidadjugadas = $this->Comunicacion->NFilas($consultajugadas);
				$jugadasdinero = $cantidadjugadas-$valorapuesta[0];
				$porcentajeganancia = $jugadasdinero * 100;
				$porcentajeganancia = $porcentajeganancia/$cantidadjugadas;
				return $porcentajeganancia;
			}
		}
		private function Retorno(){
			$r="<select id='fechasorteos'>
			<option id='todos'>Seleccione Una Fecha</option>";
			$consulta = $this->Comunicacion->Consultar("SELECT DISTINCT fecha FROM apuesta");
			while($row = $this->Comunicacion->Recorrido($consulta)){
				$r=$r."<option id='".$row[0]."'>".$row[0]."</option>";
			}
			return $r=$r."</select>";
		}
		
	}
	new Finalizarsorteospendientes();
?>