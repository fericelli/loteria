<?php

	Class Index{
		private $Comunicacion;
		function Index(){
			include ("php/conexion.php");
			$this->Comunicacion = new Conexion();
			//echo $this->GenerarSorteo();
			echo $this->Interfaz();
		}
		private function Interfaz(){
			$r='<!DOCTYPE html>
				<html lang="es">
					<head>
						<meta charset="utf-8"/>
						<title>Apuestas</title>
						<meta name="viewport" content= "width=device-width, user-scalable=no, inicial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0"/>
						<link rel="stylesheet" href="css/estilos.css"/>
						<link href="https://file.myfontastic.com/eKZWew6WZLJgJaSmjB2s8Y/icons.css" rel="stylesheet">
						<link rel="icon" type="image/png" href="img/logo.png" />
						<script src="js/jquery-1.11.3.min.js"></script>
					</head>
					<body>
						<header class="header">
							<div class="contenedor">
								<h4 class="logo"><img src="img/logo.png"> <p>LotoMiranda</p> </h4>
								<span class="icon-menu" id="btn-menu"></span>
								<nav class="nav" id="nav">
									<ul class="menu">
										<li class="menu__item"><a class="menu__link select">Inicio</a></li>
										<li class="menu__item"><a class="menu__link">Loterías</a></li>
										<li class="menu__item"><a class="menu__link">Sorteos</a></li>
										<li class="menu__item"><a class="menu__link">Resultados</a></li>
										<li style="display:none" class="menu__item"><a class="menu__link">Contacto</a></li>
									</ul>
								</nav>
							</div>
						</header>
						<div class="interfazprincipal activo">
							<div class="banner">
								<img src="img/sorteo.jpg" alt="" class="banner__img">
								<div class="contenedor">
									<h2 class="banner__titulo">La mejor lotería a tu alcance</h2>
									<p class="banner__txt">Apuesta con nosotros y gana</p>
								</div>
							</div>
							<div class="main">
								<div class="contenedor">
									<section class="info">
										'.$this->UltimosSorteos().'
									</section>
									<section style="display:none" class="cuadros">
										<div class="cuadros__columna">
											<img src="img/animalitos.png" alt="" class="cuadros__img">
											<div class="cuadros__descripcion">
												<h3 class="cuadros__titulo"></h3>
												<p class="cuadros__txt"> Lista de animalitos</p>	  
											</div>
										</div>
										<div class="cuadros__columna">
											<img src="img/reloj.jpg" alt="" class="cuadros__img">
											<div class="cuadros__descripcion">
												<h3 class="cuadros__titulo"></h3>
												<p class="cuadros__txt"> Nuestros Horarios</p>	  
											</div>
										</div>
										<div class="cuadros__columna">
											<img src="img/contacto.jpg" alt="" class="cuadros__img">
											<div class="cuadros__descripcion">
												<h3 class="cuadros__titulo"></h3>
												<p class="cuadros__txt"> Contáctanos</p>	  
											</div>
										</div>
									</section>
								</div>
							</div>
						</div>
						<div class="interfazprincipal">
							'.$this->Loterias().'
						</div>
						<div class="interfazprincipal">
							'.$this->Sorteos().'
						</div>
						<div class="interfazprincipal">
							'.$this->Resultados().'
						</div>
						<div class="interfazprincipal interfazprincipalcontacto">
							<form>
								<h2>CONTACTO</h2>
								<input type="text" name="Nombre" placeholder="Nombre">
								<input type="text" name="Apellido" placeholder="Apellido">
								<input type="text" name="Correo" placeholder="Correo">
								<input type="text" name="Teléfono" placeholder="Teléfono">
								<textarea name="mensaje" placeholder="Escriba aquí su mensaje"></textarea>
								<input type="button" value="ENVIAR" id="button">
							</form>
						</div>
						<footer class="footer">
							<div class="social">
								<a  class="icon-facebook"></a>
								<a  class="icon-twitter"></a>
								<a  class="icon-instagram"></a>
								<a  class="icon-mail"></a>
							</div>
							<p class="copy">&copy; LotoMiranda 2017- Todos los derechos reservados</p>
						</footer>
						<script src="js/script.js"></script>
					</body>
				</html>';
				return $r;
		}
		private function UltimosSorteos(){
			$r="";
			$consultarloterias = $this->Comunicacion->Consultar("SELECT loteria FROM loterias ORDER BY loteria ASC");
			$r=$r."<select style='display:block; margin:auto; width:290px; height:40px; border-radius:5px;' id='loteriasultimosorteos'>";
			
			if($this->Comunicacion->Recorrido($consultarloterias)){
				$contadorselec = 0;
				$consultarloterias = $this->Comunicacion->Consultar("SELECT * FROM loterias ORDER BY loteria ASC");
				while($loterias = $this->Comunicacion->Recorrido($consultarloterias)){
					$cosnultajugadasganaoras = $this->Comunicacion->Consultar("SELECT * FROM jugadasganadoras WHERE loteria='".$loterias[0]."'");
					$cantidadloterias = $this->Comunicacion->NFilas($cosnultajugadasganaoras);
					if($cantidadloterias>0){
						$contadorselec ++;
						$r=$r."<option id='".$loterias[0]."'>".$loterias[0]."</option>";
					}else{
						if($loterias[2]!="si"){
							$consultacantidadjugada = $this->Comunicacion->Consultar("SELECT * FROM jugadas WHERE loteria='".$loterias[0]."' AND bloqueo<>'si'");
							$cantidadjugadas = $this->Comunicacion->NFilas($consultacantidadjugada);
							if($loterias[1]<$cantidadjugadas){
								$contadorselec ++;
								$r=$r."<option id='".$loterias[0]."'>".$loterias[0]."</option>";
							}
						}
					}
				}
				if($contadorselec==0){
					$r=$r."<option id='nohay'>No hay loterías</option>";
				}
			}else{
				$r=$r."<option id='nohay'>No hay loterías</option>";
			}
			$r=$r.'</select>
			<div id="contenedorultimossorteos">';
			$consultarloterias = $this->Comunicacion->Consultar("SELECT * FROM loterias ORDER BY loteria ASC");
			
			if($loterias = $this->Comunicacion->Recorrido($consultarloterias)){
				$cosnultajugadasganaoras = $this->Comunicacion->Consultar("SELECT * FROM jugadasganadoras WHERE loteria='".$loterias[0]."'");
				$cantidadloterias = $this->Comunicacion->NFilas($cosnultajugadasganaoras);
				if($cantidadloterias>0){
					$consultaultimasjugadas = $this->Comunicacion->Consultar("SELECT sorteo,jugada FROM jugadasganadoras WHERE loteria='".$loterias[0]."' ORDER BY sorteo DESC LIMIT 0,3");
					$contador = 0;
					while($jugadasganadoras = $this->Comunicacion->Recorrido($consultaultimasjugadas)){
						$date = date_create($jugadasganadoras[0]);
						$contador ++;
						$r=$r.'<article class="info__columna">
						<h2 class="info__titulo">Sorteo '.date_format($date, 'g:i A').'</h2>
						<p class="info__txt">La Jugada Ganadora Es: '.$jugadasganadoras[1].'</p>';
						$consultaimagen = $this->Comunicacion->Consultar("SELECT imagen FROM jugadas WHERE nombre='".$jugadasganadoras[1]."' AND loteria='".$loterias[0]."'");
						if($imagen = $this->Comunicacion->Recorrido($consultaimagen)){
							$r=$r.'<center><img src="sistema/'.$imagen[0].'" alt="" class="info__img"></center>';
						}
						$r=$r.'</article>';
					}
					while($contador<3){
						$r=$r.'<article class="info__columna">
							<h2 class="info__titulo">No hay sorteo</h2>
							<p class="info__txt">Espere por el sorteo!!</p>
							<center><img src="img/nosorteado.png" alt="" class="info__img"></center>
						</article>';
						$contador ++;
					}
				}else{
					$contador = 0;
					if($loterias[2]!="si"){
						$consultacantidadjugada = $this->Comunicacion->Consultar("SELECT * FROM jugadas WHERE loteria='".$loterias[0]."' AND bloqueo<>'si'");
						$cantidadjugadas = $this->Comunicacion->NFilas($consultacantidadjugada);
						if($loterias[1]<$cantidadjugadas){
							while($contador<3){
								$r=$r.'<article class="info__columna">
									<h2 class="info__titulo">No hay sorteo</h2>
									<p class="info__txt">Espere por el sorteo!!</p>
									<center><img src="img/nosorteado.png" alt="" class="info__img"></center>
								</article>';
								$contador ++;
							}
						}
					}
					if($contador==0){
						$r=$r.'<article class="info__columna">
						<h2 class="info__titulo">No Hay Loterías</h2>
						<p class="info__txt">Espere a que sea cargado por el administrador!!</p>
						<center><img src="img/nosorteado.png" alt="" class="info__img"></center>
						</article>';
					}
				}
			}else{
				$r=$r.'<article class="info__columna">
					<h2 class="info__titulo">No hay loterías</h2>
					<p class="info__txt">Espere a que sea cargada por el administrador!!</p>
					<center><img src="img/nosorteado.png" alt="" class="info__img"></center>
				</article>';
			}
			return $r=$r."</div>";	
		}
		private function Loterias(){
			$r="";
			$consultarloterias = $this->Comunicacion->Consultar("SELECT * FROM loterias WHERE bloqueo<>'si' ORDER BY loteria ASC");
			$r=$r."<center><select style='margin-top:10px;width:290px; height:40px; border-radius:5px;' id='loteriasjugadas'>";
			if($this->Comunicacion->Recorrido($consultarloterias)){
				$consultarloterias = $this->Comunicacion->Consultar("SELECT loteria,valorapuesta FROM loterias WHERE bloqueo<>'si' ORDER BY loteria ASC");
				while($loterias = $this->Comunicacion->Recorrido($consultarloterias)){
					$consultacantidadjugada = $this->Comunicacion->Consultar("SELECT * FROM jugadas WHERE loteria='".$loterias[0]."' AND bloqueo<>'si' AND tipojugada<>'especial'");
					$cantidadjugadas = $this->Comunicacion->NFilas($consultacantidadjugada);
					if($loterias[1]<$cantidadjugadas){
						$r=$r."<option id='".$loterias[0]."'>".$loterias[0]."</option>";
					}else{
						$r=$r."<option id='nohay'>No hay loterías</option>";
					}
				}
			}else{
				$r=$r."<option id='nohay'>No hay loterías</option>";
			}
			$r=$r.'</select></center><br>';
			$consultarloterias = $this->Comunicacion->Consultar("SELECT loteria,valorapuesta,diascaducaciontiket FROM loterias WHERE bloqueo<>'si' ORDER BY loteria ASC");
			if($loterias = $this->Comunicacion->Recorrido($consultarloterias)){
				
				$consultacantidadjugadas = $this->Comunicacion->Consultar("SELECT * FROM jugadas WHERE loteria='".$loterias[0]."' AND bloqueo<>'si'");
				$cantidadjugadasverificar = $this->Comunicacion->NFilas($consultacantidadjugadas);
				$cantidadregistromostrar = 6;
				$pagina = 1;
				$paginasiguiente = $pagina + 1;
				if($loterias[1]<$cantidadjugadasverificar){
					$r=$r.'<div class="listado">
					<div class="article">
						<div class="title">Modalidad del juego</div>
							<p>
								Este es un juego de azar basado en una selección simple, que le permite multiplicar '.$loterias[1].' 
								veces su apuesta si sale ganadora su selección. 
								En el sorteo, usted como jugador, puede seleccionar en un mismo ticket una o más combinaciones de las ';
								$consultacantidadjugada = $this->Comunicacion->Consultar("SELECT * FROM jugadas WHERE loteria='".$loterias[0]."' AND bloqueo<>'si'");
								$cantidadjugadas = $this->Comunicacion->NFilas($consultacantidadjugada);
								$r=$r.$cantidadjugadas.' existentes. Además existe (n) ';
								$consultarjugadasespeciales = $this->Comunicacion->Consultar("SELECT * FROM jugadas WHERE loteria='".$loterias[0]."' AND bloqueo<>'si' AND tipojugada='especial'");
								$cantidadjugadasespeciales = $this->Comunicacion->NFilas($consultarjugadasespeciales);
								$r=$r.$cantidadjugadasespeciales." jugada (s) que multiplica ";
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
						</div>
					</div><br>';
				}else{
					$r=$r.'
						<center><article class="info__columna">
							<h2 class="info__titulo">No hay loterías</h2>
							<p class="info__txt">Espere a que sea cargada por el administrador!!</p>
							<center><img src="img/nosorteado.png" alt="" class="info__img"></center>
						</article></center>';
				}
			}else{
				$r=$r.'
					<center><article class="info__columna">
						<h2 class="info__titulo">No Hay Loterias</h2>
						<p class="info__txt">Espere a que sea cargada por el administrador!!</p>
						<center><img src="img/nosorteado.png" alt="" class="info__img"></center>
					</article></center>';
			}
			return $r;
			
		}
		private function Sorteos(){
			$r="";
			$consultarloterias = $this->Comunicacion->Consultar("SELECT * FROM loterias WHERE bloqueo<>'si' ORDER BY loteria ASC");
			$r=$r."<center><select style='margin-top:10px;width:290px; height:40px; border-radius:5px;' id='loteriassorteo'>";
			if($this->Comunicacion->Recorrido($consultarloterias)){
				$consultarloterias = $this->Comunicacion->Consultar("SELECT loteria,valorapuesta FROM loterias WHERE bloqueo<>'si' ORDER BY loteria ASC");
				while($loterias = $this->Comunicacion->Recorrido($consultarloterias)){
					$consultacantidadjugada = $this->Comunicacion->Consultar("SELECT * FROM jugadas WHERE loteria='".$loterias[0]."' AND bloqueo<>'si' AND tipojugada<>'especial'");
					$cantidadjugadas = $this->Comunicacion->NFilas($consultacantidadjugada);
					if($loterias[1]<$cantidadjugadas){
						$r=$r."<option id='".$loterias[0]."'>".$loterias[0]."</option>";
					}else{
						$r=$r."<option id='nohay'>No Hay Loterías</option>";
					}
				}
			}else{
				$r=$r."<option id='nohay'>No Hay Loterías</option>";
			}
			$r=$r.'</select></center><br>';
			$consultarloterias = $this->Comunicacion->Consultar("SELECT * FROM loterias WHERE bloqueo<>'si' ORDER BY loteria ASC");
			if($loterias = $this->Comunicacion->Recorrido($consultarloterias)){
				$consultacantidadjugada = $this->Comunicacion->Consultar("SELECT * FROM jugadas WHERE loteria='".$loterias[0]."' AND bloqueo<>'si' AND tipojugada<>'especial'");
				$cantidadjugadas = $this->Comunicacion->NFilas($consultacantidadjugada);
				if($loterias[1]<$cantidadjugadas){
					$r=$r.'<div id="contenedortablasorteo">';
					$consultacantidadsorteos = $this->Comunicacion->Consultar("SELECT * FROM sorteo WHERE loteria='".$loterias[0]."'");
					$cantidadsorteos = $this->Comunicacion->NFilas($consultacantidadsorteos);
					if($cantidadsorteos>0){
						$r=$r.'<table class="tablasorteo segunda" style="width:300px">
						<tr>
							<th colspan="2">Lunes a Domingo</th>
						</tr>
						<tr>
							<th>Horario</th>	
						</tr>';
					}else{
						$r=$r.'
						<center>
							<article class="info__columna">
								<h2 class="info__titulo">No Hay Sorteos</h2>
								<p class="info__txt">Espere Por El Administrador A Que Lo Agregue!!</p>
								<center><img src="img/nosorteado.png" alt="" class="info__img"></center>
							</article>
						</center>';
					}
					$consultacantidadsorteos = $this->Comunicacion->Consultar("SELECT * FROM sorteo WHERE loteria='".$loterias[0]."'");
					$cantidadsorteos = $this->Comunicacion->NFilas($consultacantidadsorteos);
					$cantidadregistromostrar = 6;
					$pagina = 1;
					$paginasiguiente = $pagina + 1;
					$consultasorteos = $this->Comunicacion->Consultar("SELECT * FROM sorteo WHERE loteria='".$loterias[0]."' ORDER BY hora ASC LIMIT 0,".$cantidadregistromostrar."");
					while($sorteos = $this->Comunicacion->Recorrido($consultasorteos)){
						$date = new DateTime($sorteos[1]);
						$r=$r."<tr>
							<td>".date_format($date, 'g:i A')."</td>
						</tr>";
					}
					$r=$r.'</table><br>';
					if($cantidadsorteos>$cantidadregistromostrar){
						$r=$r."<div style='display:flex; justify-content:space-around'>
							<div id='".$paginasiguiente."' class='siguientetablasorteo' style='cursor:pointer; padding:5px;color:#fff;background-color:#0B0B61'>></div>
						</div>";
					}
					$r=$r.'</div>';
				}else{
					$r=$r.'<center><article class="info__columna">
						<h2 class="info__titulo">No Hay Loterias</h2>
						<p class="info__txt">Espere a que sea cargada por el administrador!!</p>
						<center><img src="img/nosorteado.png" alt="" class="info__img"></center>
					</article></center>';
				}
			}else{
				$r=$r.'<center><article class="info__columna">
					<h2 class="info__titulo">No Hay Loterias</h2>
					<p class="info__txt">Espere a que sea cargada por el administrador!!</p>
					<center><img src="img/nosorteado.png" alt="" class="info__img"></center>
				</article></center>';
			}
			
			return $r;
		}
		private function Resultados(){
			$r="";
			$consultarloterias = $this->Comunicacion->Consultar("SELECT * FROM loterias ORDER BY loteria ASC");
			$r=$r."<center><select style='margin-top:10px;width:290px; height:40px; border-radius:5px;' id='loteriasganadoras'>";
			if($this->Comunicacion->Recorrido($consultarloterias)){
				$consultarloterias = $this->Comunicacion->Consultar("SELECT loteria,valorapuesta FROM loterias ORDER BY loteria ASC");
				while($loterias = $this->Comunicacion->Recorrido($consultarloterias)){
					$consultacantidadjugada = $this->Comunicacion->Consultar("SELECT * FROM jugadas WHERE loteria='".$loterias[0]."' AND bloqueo<>'si' AND tipojugada<>'especial'");
					$cantidadjugadas = $this->Comunicacion->NFilas($consultacantidadjugada);
					if($loterias[1]<$cantidadjugadas){
						$r=$r."<option id='".$loterias[0]."'>".$loterias[0]."</option>";
					}else{
						$r=$r."<option id='nohay'>No Hay Loterías</option>";
					}
				}
			}else{
				$r=$r."<option id='nohay'>No Hay Loterías</option>";
			}
			$r=$r.'</select></center><br>';
			$consultarloterias = $this->Comunicacion->Consultar("SELECT * FROM loterias WHERE bloqueo<>'si' ORDER BY loteria ASC");
			if($this->Comunicacion->Recorrido($consultarloterias)){
				$consultarloterias = $this->Comunicacion->Consultar("SELECT loteria,valorapuesta FROM loterias WHERE bloqueo<>'si' ORDER BY loteria ASC");
				if($loterias = $this->Comunicacion->Recorrido($consultarloterias)){
					$consultacantidadjugada = $this->Comunicacion->Consultar("SELECT * FROM jugadas WHERE loteria='".$loterias[0]."' AND bloqueo<>'si' AND tipojugada<>'especial'");
					$cantidadjugadas = $this->Comunicacion->NFilas($consultacantidadjugada);
					if($loterias[1]<$cantidadjugadas){
						$consultarcantidadsorteos = $this->Comunicacion->Consultar("SELECT * FROM jugadasganadoras WHERE loteria='".$loterias[0]."'");
						$cantidadjugadasganadoras = $this->Comunicacion->NFilas($consultarcantidadsorteos);
						$cantidadregistromostrar = 4;
						$pagina = 1;
						$paginasiguiente = $pagina + 1;
						if($cantidadjugadasganadoras>0){
							$r=$r.'<div id="contenedortablaganadoras">		
								<table class="tablasorteo segunda" style="width:300px">
									<tr>
										<th>Fecha</th>
										<th>Sorteos</th>
										<th>Jugada Ganadora</th>
									</tr>';
									$cosultajugadasganadoas = $this->Comunicacion->Consultar("SELECT * FROM jugadasganadoras WHERE loteria='".$loterias[0]."' ORDER BY sorteo DESC LIMIT 0,".$cantidadregistromostrar."");
									while($jugadasganadoras = $this->Comunicacion->Recorrido($cosultajugadasganadoas)){
										$sorteo = explode(" ",$jugadasganadoras[0]);
										$fecha = strtotime($sorteo[0]);
										$date = date('d-m-Y',$fecha);
										$hora = date_create($jugadasganadoras[0]);
										$r=$r."<tr>
											<td>".$date."</td>
											<td>".date_format($hora, 'g:i A')."</td>
											<td><div>".$jugadasganadoras[2];
											$consultarimagen = $this->Comunicacion->Consultar("SELECT imagen FROM jugadas WHERE nombre='".$jugadasganadoras[2]."' AND loteria='".$loterias[0]."'");
											if($imagen = $this->Comunicacion->Recorrido($consultarimagen)){
													$r=$r."</div><img src='sistema/".$imagen[0]."'></td>";
											}
										$r=$r."</tr>";
									}
									
								$r=$r.'</table><br>';
								if($cantidadjugadasganadoras>$cantidadregistromostrar){
									$r=$r."<div style='display:flex; justify-content:space-around'>
										<div id='".$paginasiguiente."' class='siguientetablaganadoras' style='cursor:pointer; padding:5px;color:#fff;background-color:#0B0B61'>></div>
									</div>";
								}
							$r=$r.'</div>';
						}else{
							$r=$r.'
								<center><article class="info__columna">
									<h2 class="info__titulo">No Hay Sorteos</h2>
									<p class="info__txt">Espere a que sea cargada por el administrador!!</p>
									<center><img src="img/nosorteado.png" alt="" class="info__img"></center>
								</article></center>';
						}
						
					}else{
						$r=$r.'<center><article class="info__columna">
								<h2 class="info__titulo">No Hay Loterías</h2>
								<p class="info__txt">Espere a que sea cargada por el administrador!!</p>
								<center><img src="img/nosorteado.png" alt="" class="info__img"></center>
								</article></center>';
					}
				}
			}else{
				$r=$r.'<center>
						<article class="info__columna">
						<h2 class="info__titulo">No Hay Loterías</h2>
						<p class="info__txt">Espere a que sea cargada por el administrador!!</p>
						<center><img src="img/nosorteado.png" alt="" class="info__img"></center>
						</article>
					</center>';
			}
			return $r;
		}
		private function GenerarSorteo(){
			//$porciones = explode("-",$_GET["sorteo"]);
			$jugada ="";
			$fecha = "";
			$hora = "";
			$dinerototal = 0;
			$dinerobanca = 0;
			$ganancia = 0;
			$gananciatotalbanca = 0;
			$gananciatotalrecolector = 0;
			$dineroarepatir = 0;
			$sorteo = "";
			//return date("Y-m-d");
			//return date("H:i");
			if(strtotime( date("H:i"))>strtotime("10:52")){
				$hora = "mayor";	
			}else{
				$hora = "menor";
			}
			if(strtotime( date("Y-m-d"))>strtotime("2018-10-17")){
				$fecha = "mayor";
			}else{
				$fecha = "menor";
			}
			//return $fecha ." ".$hora;
			$consultarloteria = $this->Comunicacion->Consultar("SELECT DISTINCT loteria FROM sorteo");
			while($loterias = $this->Comunicacion->Recorrido($consultarloteria)){
				$consultarsorteo = $this->Comunicacion->Consultar("SELECT hora FROM sorteo WHERE loteria='".$loterias[0]."'");
				while($sorteos = $this->Comunicacion->Recorrido($consultarsorteo)){
					if(strtotime( date("H:i"))>strtotime($sorteos[0])){
						$sorteo = date("Y-m-d")." ".$sorteos[0];
						$consultasorteofializado = $this->Comunicacion->Consultar("SELECT * FROM jugadasganadoras WHERE sorteo='".$sorteo."'");
						if(!$this->Comunicacion->Recorrido($consultasorteofializado)){
							$consultadinerototal = $this->Comunicacion->Consultar("SELECT dinero FROM dineroapostado WHERE fecha='".date("Y-m-d")."' AND sorteo='".$sorteos[0]."'");
							if($dinero = $this->Comunicacion->Recorrido($consultadinerototal)){
								$dinerototal = $dinero[0];
							}else{
								$dinerototal = 0;
							}
							if($dinerototal!=0){
								$consultabancas = $this->Comunicacion->Consultar("SELECT nombre FROM bancas");
								while($bancas = $this->Comunicacion->Recorrido($consultabancas)){
									$consultadinerobanca = $this->Comunicacion->Consultar("SELECT * FROM controldinerobanca WHERE banca='".$bancas[0]."' AND fecha='".date("Y-m-d")."' AND sorteo='".$sorteos[0]."' AND loteria='".$loterias[0]."'");
									if($dinerobanca = $this->Comunicacion->Recorrido($consultadinerobanca)){
										$gananciatotalbanca = $dinerobanca[6] * $banca[5];
										$gananciatotalbanca = $gananciatotalbanca/100;
										if($banca[2]="recolector"){
											$consultaporcentajerecolector = $this->Comunicacion->Consultar("SELECT * FROM recolectores WHERE usuario='".$banca[3]."'");
											if($recolector = $this->Comunicacion->Recorrido($consultaporcentajerecolector)){
												$porcentajerecolector = 0;
												$porcentajerecolector = $recolector[5]-$banca[5];
												$gananciatotalrecolector = $dinerobanca[6] * $porcentajerecolector;
												$gananciatotalrecolector = $gananciatotalrecolector /100;
											}
										} 
									}
									$this->Comunicacion->Consultar("INSERT INTO controlsorteofinalizado(banca,gananciabanca,gananciarecolector,gananciajugadores,efectivobanca) VALUES ('".$bancas[0]."','".$gananciatotalbanca."','".$gananciatotalrecolector."',0,'".$dinerobanca[6]."')");
									$gananciatotalbanca = 0;
									$gananciatotalrecolector = 0;
								}
								$consultaporcentageganancia = $this->Comunicacion->Consultar("SELECT porcentaje FROM porcentajes WHERE nombre='sorteos'");
								if($porcentajeganancia = $this->Comunicacion->Recorrido($consultaporcentageganancia)){
									$ganancia = $dinerototal[0] * $porcentajeganancia[0];
									$ganancia = $ganancia/100;
									$cantidadarepartir = $dinerototal[0]-$ganancia-$gananciatotalbanca-$gananciatotalrecolector;
									//return "SELECT jugada,dinero FROM controlsorteo WHERE dinero=(SELECT MAX(dinero) FROM controlsorteo WHERE dinero<='".$cantidadarepartir."' AND fecha='".$_GET["fecha"]."' AND sorteo='".$porciones[1]."' AND loteria='".$porciones[0]."')";
									$consultaminimo = $this->Comunicacion->Consultar("SELECT jugada,dinero FROM controlsorteo WHERE dinero=(SELECT MAX(dinero) FROM controlsorteo WHERE dinero<='".$cantidadarepartir."' AND fecha='".date("Y-m-d")."' AND sorteo='".$dinerototal[1]."' AND loteria='".$dinerototal[2]."')");
									if($dinerorepartir = $this->Comunicacion->Recorrido($consultaminimo)){
										$jugada = $dinerorepartir[0];
										$dineroarepatir = $dinerorepartir[1];
										if($dineroarepatir==0){
											$consuulta = $this->Comunicacion->Consultar("SELECT jugada FROM controlsorteo WHERE dinero=0 ORDER BY RAND()");
											if($jugadaaleatoria = $this->Comunicacion->Recorrido($consuulta)){
												$jugada = $jugadaaleatoria[0];
											}
										}
									}
									
									$consultajugadasganandas = $this->Comunicacion->Consultar("SELECT codigo,ganancia,hora,banca FROM apuesta WHERE jugada='".$jugada."' AND fecha='".date("Y-m-d")."' AND sorteo='".$dinerototal[1]."' AND loteria='".$dinerototal[2]."'"); 
									while($apuestasganadoras = $this->Comunicacion->Recorrido($consultajugadasganandas)){
										$this->Comunicacion->Consultar("INSERT INTO ganadores(codigo,banca,jugada,loteria,ganancia,fecha,sorteo,hora) VALUES ('".$apuestasganadoras[0]."','".$apuestasganadoras[3]."','".$jugada."','".$dinerototal[2]."','".$apuestasganadoras[1]."','".date("Y-m-d")."','".$dinerototal[1]."','".$apuestasganadoras[2]."')");
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
										$this->Comunicacion->Consultar("INSERT INTO controldinero(banca,usuariocreador,fecha,sorteo,gananciabanca,gananciarecolector,ganancia,pagorecolector,premiosresponsables,loteria) VALUES ('".$controlsorteofinalizado[0]."','".$this->UsuarioCreador($controlsorteofinalizado[0])."','".date("Y-m-d")."','".$dinerototal[1]."','".$controlsorteofinalizado[1]."','".$controlsorteofinalizado[2]."','".$gananciaenbanca."','','".$premiosresponsables."','".$dinerototal[2]."')");
										
									}
								}
								$this->Comunicacion->Consultar("INSERT INTO jugadasganadoras(sorteo,loteria,jugada) VALUES ('".date("Y-m-d")." ".$dinerototal[1]."','".$dinerototal[2]."','".$jugada."')");
								$this->Comunicacion->Consultar("DELETE FROM apuesta WHERE fecha='".date("Y-m-d")."' AND sorteo='".$dinerototal[1]."' AND loteria='".$dinerototal[2]."'");
								$this->Comunicacion->Consultar("DELETE FROM controldinerobanca WHERE fecha='".date("Y-m-d")."' AND sorteo='".$dinerototal[1]."' AND loteria='".$dinerototal[2]."'");
								$this->Comunicacion->Consultar("DELETE FROM controlsorteo WHERE fecha='".date("Y-m-d")."' AND sorteo='".$dinerototal[1]."' AND loteria='".$dinerototal[2]."'");
								$this->Comunicacion->Consultar("TRUNCATE TABLE controlsorteofinalizado");
								$this->Comunicacion->Consultar("DELETE FROM dineroapostado WHERE fecha='".date("Y-m-d")."' AND sorteo='".$dinerototal[1]."' AND loteria='".$dinerototal[2]."'");
			
							}
						}
					}
				}
				
			}
			
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
		
	}
	$Index = new Index();
?>