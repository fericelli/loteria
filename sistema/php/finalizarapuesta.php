<?php

	Class FinalizarApuesta{
		private $Comunicacion;
		function FinalizarApuesta(){
			include("../../php/conexion.php");
			$this->Comunicacion = new Conexion();
			if(isset($_GET["usuario"])){
				$fecha = date("Y-m-d");
				$hora = date("H:m:s");
				if($this->ComprobarBloqueoBanca()=="cerrar sesion" and $this->ComprobarBloqueoRecolector()=="cerrar sesion"){
					echo "cerrar sesion";
				}else if($this->ComprobarBloqueoLoteria()=="error" OR $this->ComprobarBloqueoApuestas()=="error" or $this->ComprobarSorteo($fecha)=="error"){
					echo "error-".$this->InterfazApuesta();
				}else{
					$this->CrearControlSorteo($fecha);
					$this->CrearControlBancaYRecolector($fecha);
					$this->Realizarapuesta($fecha,$hora);
					echo $this->ConfirmarApuestas($fecha,$hora);
				}
				$this->Borrarapuesta();
			}
		}
		private function Realizarapuesta($fecha,$hora){
			$retorno = "";
			$script2 = substr(str_shuffle("0123456789"), 0,10);
			$script2 = $this->Banca().'-'.$script2;
			$cosultacodigo = $this->Comunicacion->Consultar("SELECT * FROM apuesta WHERE codigo='".$script2."'");
			if($this->Comunicacion->Recorrido($cosultacodigo)){
				return "error";
			}else{
				$consultacodigoganadores = $this->Comunicacion->Consultar("SELECT * FROM ganadores WHERE codigo='".$script2."'");
				if($this->Comunicacion->Recorrido($consultacodigoganadores)){
					return "error";
				}else{
					$consultaloteria = $this->Comunicacion->Consultar("SELECT DISTINCT loteria FROM controlapuesta WHERE banca='".$this->Banca()."'");
					while($loteria = $this->Comunicacion->Recorrido($consultaloteria)){
						$consulta = $this->Comunicacion->Consultar("SELECT DISTINCT sorteo FROM controlapuesta WHERE banca='".$this->Banca()."' AND loteria='".$loteria[0]."'");
						while($sorteo = $this->Comunicacion->Recorrido($consulta)){
							$consultajugada = $this->Comunicacion->Consultar("SELECT DISTINCT jugada FROM controlapuesta WHERE banca='".$this->Banca()."' AND loteria='".$loteria[0]."'");
							while($jugada = $this->Comunicacion->Recorrido($consultajugada)){
								$consualsuma = $this->Comunicacion->Consultar("SELECT SUM(apuesta),SUM(ganancia) FROM controlapuesta WHERE jugada='".$jugada[0]."' AND banca='".$this->Banca()."' AND loteria='".$loteria[0]."'");
								if($controlapuesta = $this->Comunicacion->Recorrido($consualsuma)){
									$this->Comunicacion->Consultar("INSERT INTO apuesta(codigo,jugada,loteria,banca,ganancia,fecha,hora,sorteo) VALUES ('".$script2."','".$jugada[0]."','".$loteria[0]."','".$this->Banca()."','".$controlapuesta[1]."','".$fecha."','".$hora."','".$sorteo[0]."')");
									$this->Comunicacion->Consultar("UPDATE controlsorteo SET dinero=dinero+".$controlapuesta[1]." WHERE fecha='".$fecha."' AND sorteo='".$sorteo[0]."' AND loteria='".$loteria[0]."' AND jugada='".$jugada[0]."'");
									$this->Comunicacion->Consultar("UPDATE dineroapostado SET dinero=dinero+".$controlapuesta[0]." WHERE fecha='".$fecha."' AND sorteo='".$sorteo[0]."' AND loteria='".$loteria[0]."'");
									$this->Comunicacion->Consultar("UPDATE controldinerobanca SET dinero=dinero+".$controlapuesta[0]." WHERE fecha='".$fecha."' AND sorteo='".$sorteo[0]."' AND banca='".$this->Banca()."'");
									//$this->Comunicacion->Consultar("UPDATE dinerobanca SET dinero=dinero+".$controlapuesta[0]." WHERE banca='".$this->Banca()."'");
								}
							}
						}
					}
				}
			}
		}
		private function ConfirmarApuestas($fecha,$hora){
			
			$c="";
			
			$consultacodigo = $this->Comunicacion->Consultar("SELECT codigo FROM apuesta WHERE banca='".$this->Banca()."' AND hora='".$hora."'");
			if($codigoapuesta = $this->Comunicacion->Recorrido($consultacodigo)){
				$c = substr($codigoapuesta[0],strpos($codigoapuesta[0],"-")+1);
			}
			
			$retornohtml = "<center>Apuesta Exitosa</center>";
			$retornohtml = $retornohtml."<div><center>".$fecha."</center></div>
			<div><center>".$hora."</center></div>
			<div><center>".$this->Banca()."</center></div>
			<div><center>Codigo Apuesta:".$c."</center></div>";
			$consultaloteria = $this->Comunicacion->Consultar("SELECT DISTINCT loteria FROM controlapuesta WHERE banca='".$this->Banca()."'");
			while($loteria = $this->Comunicacion->Recorrido($consultaloteria)){
				$retornohtml = $retornohtml."<div><center>loteria ".$loteria[0]."<center></div>";
				$consulta = $this->Comunicacion->Consultar("SELECT DISTINCT sorteo FROM controlapuesta WHERE banca='".$this->Banca()."' AND loteria='".$loteria[0]."'");
				
				while($sorteo = $this->Comunicacion->Recorrido($consulta)){
					$retornohtml = $retornohtml."<div><center>Sorteo ".$sorteo[0]."</center></div>";
					$consultaapuesta = $this->Comunicacion->Consultar("SELECT * FROM apuesta WHERE fecha='".$fecha."' AND hora='".$hora."' AND sorteo='".$sorteo[0]."' AND banca='".$this->Banca()."' AND loteria='".$loteria[0]."'");
					while($apuesta = $this->Comunicacion->Recorrido($consultaapuesta)){
						$retornohtml = $retornohtml."<div><center>Jugada ".$apuesta[1]."</center></div>
						<div><center>Ganancia ".$apuesta[4]."</center></div>";
					}
					
				}
			}
			
			$retornohtml = $retornohtml."<div class='boton botonimprimir'>Aceptar</div>";
			return $retornohtml;
		}
		private function Borrarapuesta(){
			$consulta = $this->Comunicacion->Consultar("DELETE FROM controlapuesta WHERE banca='".$this->Banca()."'");
		}
		private function Banca(){
			$consulta = $this->Comunicacion->Consultar("SELECT nombre FROM bancas WHERE usuario='".$_GET["usuario"]."'");
			if($row = $this->Comunicacion->Recorrido($consulta)){
				return $row[0];
			}else{
				return "";
			}
		}
		private function UsuarioCreador(){
			$consulta = $this->Comunicacion->Consultar("SELECT creador,usuariocreador FROM bancas WHERE nombre='".$this->Banca()."'");
			if($creador = $this->Comunicacion->Recorrido($consulta)){
				if($creador[0]=="administrador"){
					return $creador[0];
				}else{
					return $creador[1];
				}
			}
		}
		private function CrearControlSorteo($fecha){
			$consultaloteria = $this->Comunicacion->Consultar("SELECT loteria FROM loterias");
			while($loteria = $this->Comunicacion->Recorrido($consultaloteria)){
				$consultasorteos = $this->Comunicacion->Consultar("SELECT hora FROM sorteo WHERE loteria='".$loteria[0]."'");
				while($sorteo = $this->Comunicacion->Recorrido($consultasorteos)){
					$consultajugada = $this->Comunicacion->Consultar("SELECT nombre FROM jugadas WHERE loteria='".$loteria[0]."'");
					while($jugada = $this->Comunicacion->Recorrido($consultajugada)){
						$consultacontrolsrteo = $this->Comunicacion->Consultar("SELECT * FROM controlsorteo WHERE fecha='".$fecha."' AND sorteo='".$sorteo[0]."' AND loteria='".$loteria[0]."' AND jugada='".$jugada[0]."'");
						if($this->Comunicacion->Recorrido($consultacontrolsrteo)){
							
						}else{
							if($this->Cotrolsorteofinalizado($fecha,$sorteo[0],$loteria[0])!="si"){
								$this->Comunicacion->Consultar("INSERT INTO controlsorteo(fecha,sorteo,loteria,jugada,dinero) VALUES ('".$fecha."','".$sorteo[0]."','".$loteria[0]."','".$jugada[0]."',0)");
							}
						}
					}
					$consuladineropostado = $this->Comunicacion->Consultar("SELECT * FROM dineroapostado WHERE loteria='".$loteria[0]."' AND sorteo='".$sorteo[0]."' AND fecha='".$fecha."'");
					if($this->Comunicacion->Recorrido($consuladineropostado)){
						
					}else{
						if($this->Cotrolsorteofinalizado($fecha,$sorteo[0],$loteria[0])!="si"){
							$this->Comunicacion->Consultar("INSERT INTO dineroapostado(loteria,sorteo,fecha,dinero) VALUES ('".$loteria[0]."','".$sorteo[0]."','".$fecha."',0)");
						}
					}
				}
			}
			
		}
		private function Cotrolsorteofinalizado($fecha,$sorteo,$loteria){
			$consultar = $this->Comunicacion->Consultar("SELECT * FROM controldinero WHERE fecha='".$fecha."' AND sorteo='".$sorteo."' AND loteria='".$loteria."'");
			if($this->Comunicacion->Recorrido($consultar)){
				return "si";
			}
		}
		private function CrearControlBancaYRecolector($fecha){
			$consultaloteria = $this->Comunicacion->Consultar("SELECT loteria FROM loterias");
			while($loteria = $this->Comunicacion->Recorrido($consultaloteria)){
				$consultasorteos = $this->Comunicacion->Consultar("SELECT hora FROM sorteo WHERE loteria='".$loteria[0]."'");
				while($sorteo = $this->Comunicacion->Recorrido($consultasorteos)){
					$consultadinerobanca = $this->Comunicacion->Consultar("SELECT * FROM controldinerobanca WHERE fecha='".$fecha."' AND sorteo='".$sorteo[0]."' AND banca='".$this->Banca()."' AND loteria='".$loteria[0]."'");
					if($this->Comunicacion->Recorrido($consultadinerobanca)){
						
					}else{
						if($this->Cotrolsorteofinalizado($fecha,$sorteo[0],$loteria[0])!="si"){
							if($this->UsuarioCreador()=="administrador"){
								$this->Comunicacion->Consultar("INSERT INTO controldinerobanca(banca,usuariocreador,tipodeusuariocreador,loteria,fecha,sorteo,dinero) VALUES ('".$this->Banca()."','".$this->UsuarioCreador()."','".$this->UsuarioCreador()."','".$loteria[0]."','".$fecha."','".$sorteo[0]."',0)");
							}else{
								$this->Comunicacion->Consultar("INSERT INTO controldinerobanca(banca,usuariocreador,tipodeusuariocreador,loteria,fecha,sorteo,dinero) VALUES ('".$this->Banca()."','".$this->UsuarioCreador()."','recolector','".$loteria[0]."','".$fecha."','".$sorteo[0]."',0)");
							}
						}
					}
				}
			}
		}
		private function ComprobarBloqueoBanca(){
			$consular = $this->Comunicacion->Consultar("SELECT bloqueo FROM bancas WHERE nombre='".$this->Banca()."'");
			if($bloqueo = $this->Comunicacion->Recorrido($consular)){
				if($bloqueo[0]=="si"){
					return "cerrar sesion";
				}
			}else{
				return "cerrar sesion";
			}
			
		}
		private function ComprobarBloqueoRecolector(){
			$consulta = $this->Comunicacion->Consultar("SELECT usuariocreador FROM bancas WHERE nombre='".$this->Banca()."'");
			if($usuariocreador = $this->Comunicacion->Recorrido($consulta)){
				$cosultausuariocreador = $this->Comunicacion->Consultar("SELECT tipodeusuario,bloqueo FROM usuarios WHERE nick='".$usuariocreador[0]."'");
				if($tipodeusuariocre = $this->Comunicacion->Recorrido($cosultausuariocreador)){
					if($tipodeusuariocre[0]=="recolector" AND $tipodeusuariocre[1]=="si"){
						$this->Comunicacion->Consultar("UPDATE bancas SET bloqueo='si' WHERE nombre='".$this->Banca()."'");
						return "cerrar sesion";
					}
				}else{
					$this->Comunicacion->Consultar("UPDATE bancas SET bloqueo='si' WHERE nombre='".$this->Banca()."'");
					return "cerrar sesion";
				}
			}
		}
		private function ComprobarBloqueoLoteria(){
			
			$consultaloteria = $this->Comunicacion->Consultar("SELECT DISTINCT loteria FROM controlapuesta WHERE banca='".$this->Banca()."'");
			while($loteria = $this->Comunicacion->Recorrido($consultaloteria)){
				$consulta = $this->Comunicacion->Consultar("SELECT bloqueo,valorapuesta FROM loterias WHERE loteria='".$loteria[0]."'");
				if($bloqueo = $this->Comunicacion->Recorrido($consulta)){
					if($bloqueo[0]=="si"){
						return "error";
					}
					$consu = $this->Comunicacion->Consultar("SELECT * FROM jugadas WHERE loteria='".$loteria[0]."' AND bloqueo<>'si' AND tipojugada<>'especial'");
					$cantidadjugadas = $this->Comunicacion->NFilas($consu);
					
					if($bloqueo[1]>=$cantidadjugadas){
						return "error";
					}
				}else{
					return "error";
				}
			}
			
		}
		private function ComprobarBloqueoApuestas(){
			$consultaloteria = $this->Comunicacion->Consultar("SELECT DISTINCT loteria FROM controlapuesta WHERE banca='".$this->Banca()."'");
			while($loteria = $this->Comunicacion->Recorrido($consultaloteria)){
				$consultajugada = $this->Comunicacion->Consultar("SELECT DISTINCT jugada FROM controlapuesta WHERE banca='".$this->Banca()."' AND loteria='".$loteria[0]."'");
				while($jugada = $this->Comunicacion->Recorrido($consultajugada)){
					$consulta = $this->Comunicacion->Consultar("SELECT bloqueo FROM jugadas WHERE loteria='".$loteria[0]."' AND nombre='".$jugada[0]."'");
					if($bloqueo = $this->Comunicacion->Recorrido($consulta)){
						if($bloqueo[0]=="si"){
							return "error";
						} 
					}else{
						return "error";
					}
				}
			}
		}
		private function ComprobarSorteo($fecha){
			$consultaloteria = $this->Comunicacion->Consultar("SELECT DISTINCT loteria FROM controlapuesta WHERE banca='".$this->Banca()."'");
			while($loteria = $this->Comunicacion->Recorrido($consultaloteria)){
				$consultasorteo = $this->Comunicacion->Consultar("SELECT DISTINCT sorteo FROM controlapuesta WHERE banca='".$this->Banca()."' AND loteria='".$loteria[0]."'");
				while($sorteo = $this->Comunicacion->Recorrido($consultasorteo)){
					$consulta = $this->Comunicacion->Consultar("SELECT * FROM sorteo WHERE loteria='".$loteria[0]."' AND hora='".$sorteo[0]."'");
					if($this->Comunicacion->Recorrido($consulta)){
						
					}else{
						return "error";
					}
					if($this->Cotrolsorteofinalizado($fecha,$sorteo[0],$loteria[0])=="si"){
						return "error";
					}
				}	
			}
				
		}
		private function InterfazApuesta(){
			
			$r="<div>
			<div class='mensaje-input errorloteria'>
			<div class='flecha-mensaje-input loterianoexistente'></div><p>Error En La Lotería</p>
			</div>
			<div class='mensaje-input seleccionloteria'>
			<div class='flecha-mensaje-input'></div><p>".$this->Comunicacion->Traductor("seleccione una loteria")."</p>
			</div>
			<select id='seleccionarloteria'>";
			$r = $r."<option id='todos' selected>".$this->Comunicacion->Traductor("seleccione una loteria")."</option>";
			$consulta = $this->Comunicacion->Consultar("SELECT * FROM loterias ORDER BY loteria ASC");
			while($row = $this->Comunicacion->Recorrido($consulta)){
				$consu = $this->Comunicacion->Consultar("SELECT * FROM jugadas WHERE loteria='".$row[0]."' AND bloqueo<>'si'");
				$cantidadjugadas = $this->Comunicacion->NFilas($consu);
				if($row[1]<$cantidadjugadas){
					$r = $r."<option id='".$row[0]."'>".$row[0]."</option>";
				}	
			}
			$r = $r."</select></div>
			<div>
			<div class='mensaje-input seleccionsorteo'>
			<div class='flecha-mensaje-input'></div><p>".$this->Comunicacion->Traductor("seleccione un sorteo")."</p>
			</div><div class='mensaje-input sorteofinalizado'>
			<div class='flecha-mensaje-input'></div><p>Sorteo Finalizado</p>
			</div>
			<select style='width:258px' id='seleccionarsorteos'>";
			$r = $r."<option id='todos' selected>".$this->Comunicacion->Traductor("seleccione un sorteo")."</option>";
			
			$r = $r.'</select></div><div style="display:flex;flex-direction:row;justify-content:space-around"><div class="formulario">
					<div>
						<div class="mensaje-input codigoapuesta"><div class="flecha-mensaje-input"></div><p>Ingrese El Código De Apuestas</p></div>
						<div class="mensaje-input numerocodigo"><div class="flecha-mensaje-input"></div><p>Ingrese Un Valor Numérico</p></div>
						<div class="mensaje-input codigoinvalido"><div class="flecha-mensaje-input"></div><p>Código No Asignado</p></div>					
						<input id="codigo" type="text" placeholder="Código Apuestas">
					</div>
					<div>
						<div class="mensaje-input cantidadapostada"><div class="flecha-mensaje-input"></div><p>Ingrese La Cantidad Apostada</p></div>
						<div class="mensaje-input valorapostado"><div class="flecha-mensaje-input"></div><p>Complete El Campo</p></div>					
						<div class="mensaje-input valorapostadonumerico"><div class="flecha-mensaje-input"></div><p>Ingrese Un Valor Numérico</p></div>
						<input id="apuesta" type="text" placeholder="Cantidad Apostada">
					</div>
					<div class="botones">
						<div id="apostar" class="boton">Apostar</div>
					</div>
				</div>
				<div id="verlistado"></div>
				<div id="controlapuesta"></div></div>';
			return $r;
		}
	}
	new FinalizarApuesta();
?>