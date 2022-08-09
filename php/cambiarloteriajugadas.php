<?php
	Class Cambiarloteriajugadas{
		private $Comunicacion;
		function Cambiarloteriajugadas(){
			include("conexion.php");
			$this->Comunicacion = new Conexion();
			if(isset($_GET["loteria"])){
				echo $this->retorno();
			}
		}
		private function retorno(){
			$consultarloterias = $this->Comunicacion->Consultar("SELECT loteria,valorapuesta,diascaducaciontiket FROM loterias WHERE bloqueo<>'si' AND loteria ='".$_GET["loteria"]."'");
			if($loterias = $this->Comunicacion->Recorrido($consultarloterias)){
				$r="";
				$consultacantidadjugadas = $this->Comunicacion->Consultar("SELECT * FROM jugadas WHERE loteria='".$loterias[0]."' AND bloqueo<>'si'");
				$cantidadjugadasverificar = $this->Comunicacion->NFilas($consultacantidadjugadas);
				$cantidadregistromostrar = 6;
				$pagina = 1;
				$paginasiguiente = $pagina + 1;
					$r=$r.'
					<div class="article">
						<div class="title">Modalidad del juego</div>
							<p>
								Este es un juego de azar basado en una selección simple, que le permite multiplicar '.$loterias[1].' 
								veces su apuesta si sale ganadora su selección. 
								En el sorteo, usted como jugador, puede seleccionar en un mismo ticket una o más combinaciones de las ';
								$consultacantidadjugada = $this->Comunicacion->Consultar("SELECT * FROM jugadas WHERE loteria='".$loterias[0]."' AND bloqueo<>'si'");
								$cantidadjugadas = $this->Comunicacion->NFilas($consultacantidadjugada);
								$r=$r.$cantidadjugadas.' existentes. Ademas Existe (n) ';
								$consultarjugadasespeciales = $this->Comunicacion->Consultar("SELECT * FROM jugadas WHERE loteria='".$loterias[0]."' AND bloqueo<>'si' AND tipojugada='especial'");
								$cantidadjugadasespeciales = $this->Comunicacion->NFilas($consultarjugadasespeciales);
								$r=$r.$cantidadjugadasespeciales." jugada que multiplica ";
								$cantidadmltiplicas = $cantidadjugadas-$cantidadjugadasespeciales;
								$r=$r.$cantidadmltiplicas." veces la cantidad apostada. Por ejemplo: si usted apuesta 10 Bs obtendrá un beneficio de ";
								$benefcio = $loterias[1]*10;
								$r=$r.$benefcio.'. Nuestros sorteos se realizan de forma electrónica mediante un algoritmo al azar y podrá ver los resultados en el inicio de esta página o
								en el área de resultados. <div class="title">Reglas del juego</div>
								<ol>
									<li>Juego de envite y azar, donde sólo pueden participar mayores de dieciocho (18).</li>
									<li>Consta de la extracción aleatoria de una (1) jugada que resulta ganador en cada uno de los sorteos establecidos.</li>
									<li>La(s) apuesta(s) de los jugadores se harán a través de las taquillas autorizadas, ubicadas en los centros de apuestas identificados.</li>
									<li>Las taquillas de venta emite un ticket a modo de comprobante de la jugada que muestra el serial del ticket, código para verificar la apuesta, nombre de la taquilla, nombre de la jugada o jugadas seleccionadas, monto apostado a la jugada o a las jugada, monto total apostado, sorteo al que está asociada la jugada.</li>
									<li>La jugada mínima y máxima será informada en la taquilla donde se realice la apuesta.</li>
									<li>EL jugador se compromete a entregar el ticket para reclamar el premio en caso de que el ticket este premiado únicamente en el centro de apuesta donde realizó la jugada.</li>
									<li>El jugador se compromete a entregar el ticket original y en perfecto estado (tickets con evidentes daños que incapaciten parte de su lectura no se aceptarán para comprobación y/o pago de premio si los tuviese).</li>
									<li>Las jugadas se realizarán hasta 10 minutos antes de cada sorteo. Jugadas realizadas por encima de ese horario se considerará como jugadas no válidas retornando de forma automática el monto de la jugada.</li>
									<li>El jugador puede reclamar el premio en el centro de apuesta donde realizó la jugada el mismo día del sorteo si el ticket estuviese premiado.</li>
									<li>Los centros de apuestas vendedoras de la LOTERIA son intermediarios independientes que asumen la responsabilidad por la perfecta ejecución de todas las operaciones a su cargo, sin que tal responsabilidad pueda ser imputada al operador de la LOTERIA.</li>
									<li>Los días y horas de sorteos se establecen en esta página web y de existir algún cambio se informara por los medios autorizados.</li>
									<li>Los tickets vencerán a los (';
									$r=$r.$loterias[2].') días consecutivos al sorteo. Luego del vencimiento del ticket el jugador perderá el derecho de reclamar el premio de la jugada en caso de existir.</li>
									<li>El pago de los premios es responsabilidad exclusiva del administrador de la LOTERIA.</li>
								</ol>
							</p>
						</div>
						<div id="tablajugadas" class="tabla2">
							<table class="tablasorteo" style="width:90%;margin:auto">';
								$r=$r."<tr>
									<th>Código</th>
									<th>Nombre</th>
									<th>Imagen</th>
								</tr>";
								$consultajugadas = $this->Comunicacion->Consultar("SELECT * FROM jugadas WHERE loteria='".$loterias[0]."' AND bloqueo<>'si' ORDER BY codigoapuesta ASC LIMIT 0,".$cantidadregistromostrar."");
								while($jugadas = $this->Comunicacion->Recorrido($consultajugadas)){
									$r=$r."<tr>
										<th>".$jugadas[0]."</th>
										<th>".$jugadas[1]."</th>
										<th><img src='sistema/".$jugadas[3]."'/></th>
									</tr>";
								}
								$r=$r.'</table><br>';
								if($cantidadjugadasverificar>$cantidadregistromostrar){
									$r=$r."<div style='display:flex; justify-content:space-around'>
										<div id='".$paginasiguiente."' class='siguientetablajugadas' style='cursor:pointer; padding:5px;color:#fff;background-color:#0B0B61'>></div>
									</div>";
							}
								
						$r=$r.'</div>
					</div><br>';
				return $r;
			}
		}
	}
	new Cambiarloteriajugadas();
?>