<?php

	Class Sesion{
		private $Comunicacion;
		function Sesion(){
			include("../../php/conexion.php");
			$this->Comunicacion = new Conexion();
			if(isset($_POST["usuario"]) && isset($_POST["contraseña"])){
				if($this->ComprabarUsuario()=="registrado"){
					if($this->ComprobarContraseña()=="iniciar"){
						echo $this->Interfaz();
					}else{
						echo "contraseña incorrecta";
					}
				}else{
					echo $this->ComprabarUsuario();	
				}
			}
		}
		private function Interfaz(){
			if($this->ComprobarTipoDeUsuario()=="administrador"){
				return $this->InterfazAdministrador();
			}
			if($this->ComprobarTipoDeUsuario()=="banca"){
				return $this->InterfazBanca();
			}
			if($this->ComprobarTipoDeUsuario()=="recolector"){
				return $this->InterfazRecolectores();
			}
		}
		
		private function Loterias(){
			$retornohtml = "<div>
			<div class='mensaje-input errorloteria'>
			<div class='flecha-mensaje-input'></div><p>Error En La Lotería</p>
			</div>
			<div class='mensaje-input seleccionloteria'>
			<div class='flecha-mensaje-input'></div><p>".$this->Comunicacion->Traductor("seleccione una loteria")."</p>
			</div>
			<select id='seleccionarloteria'>";
			$retornohtml = $retornohtml."<option id='todos' selected>".$this->Comunicacion->Traductor("seleccione una loteria")."</option>";
			$consulta = $this->Comunicacion->Consultar("SELECT * FROM loterias ORDER BY loteria ASC");
			while($row = $this->Comunicacion->Recorrido($consulta)){
				$consu = $this->Comunicacion->Consultar("SELECT * FROM jugadas WHERE loteria='".$row[0]."' AND bloqueo<>'si' AND tipojugada<>'especial'");
				$cantidadjugadas = $this->Comunicacion->NFilas($consu);
				if($row[1]<$cantidadjugadas){
					$retornohtml = $retornohtml."<option id='".$row[0]."'>".$row[0]."</option>";
				}	
			}
			$retornohtml = $retornohtml."</select></div>";
			return $retornohtml;
		}
		private function Sorteos(){
			$retornohtml = "<div>
			<div class='mensaje-input seleccionsorteo'>
			<div class='flecha-mensaje-input'></div><p>".$this->Comunicacion->Traductor("seleccione un sorteo")."</p>
			</div><div class='mensaje-input sorteofinalizado'>
			<div class='flecha-mensaje-input'></div><p>Sorteo Finalizado</p>
			</div>
			<select style='width:258px' id='seleccionarsorteos'>";
			$retornohtml = $retornohtml."<option id='todos' selected>".$this->Comunicacion->Traductor("seleccione un sorteo")."</option>
			</select></div>";
			return $retornohtml;
		}
		private function ComprabarUsuario(){
			$consulta = $this->Comunicacion->Consultar("SELECT * FROM usuarios WHERE nick='".$_POST["usuario"]."'");
			if($this->Comunicacion->Recorrido($consulta)){
				return "registrado";
			}else{
				return "no registrado";
			}
		}
		private function ComprobarContraseña(){
			$consulta = $this->Comunicacion->Consultar("SELECT * FROM usuarios WHERE nick='".$_POST["usuario"]."' AND clave='".$_POST["contraseña"]."'");
			if($this->Comunicacion->Recorrido($consulta)){
				return "iniciar";
			}else{
				return "no iniciar";
			}
		}
		private function ComprobarTipoDeUsuario(){
			$consulta = $this->Comunicacion->Consultar("SELECT tipodeusuario FROM usuarios WHERE nick='".$_POST["usuario"]."' AND clave='".$_POST["contraseña"]."'");
			if($row = $this->Comunicacion->Recorrido($consulta)){
				return $row["tipodeusuario"]; 
			}
		}
		private function ComprobarBloqueo(){
			$consulta = $this->Comunicacion->Consultar("SELECT bloqueo FROM usuarios WHERE nick='".$_POST["usuario"]."'");
			if($row = $this->Comunicacion->Recorrido($consulta)){
				if($row[0]=="si"){
					return "bloqueado";
				}
			}
		}
		private function ComprobarMac(){
			
		}
		private function VerificarIngresoDeContraseña(){
			$r="";
			$consulta = $this->Comunicacion->Consultar("SELECT clave FROM usuarios WHERE nick='".$_POST["usuario"]."'");
			if($row=$this->Comunicacion->Recorrido($consulta)){
				if($row[0]==""){
					$r=$r.'<div id="contenedoragregarcontrasena">
						<div style="margin-top:10%" class="formulario">
							<div style="display:none" class="boton mensajeclave">Contraseña Cambiada</div>
							<div>
								<div class="mensaje-input contraseñacambiar"><div class="flecha-mensaje-input"></div><p>Complete El Campo</p></div>
								<input id="contrasenanueva" type="text" placeholder="Ingrese Una Contraseña">
							</div>
							<div id="cambiarclave" class="boton">Aceptar</div>
						</div>
					</div>
					';
				}
			}
			if($this->ComprobarTipoDeUsuario()=="administrador"){
				$r=$r.'<div id="contenedoractualizarsistema" style="position:fixed; z-index:100;width:100%; height:100%; background-color:rgba(0,0,0,0.6)">
					<div style="margin-top:10%" class="formulario">
							<div id="actualizarsitema" class="boton">Actualizar Sistema</div>
						</div>
				</div>';
			}
			if($this->ComprobarTipoDeUsuario()=="banca"){
				$r=$r.'<div id="contenedorfichero" style="display:none;position:fixed; z-index:100;width:100%; height:100%; background-color:rgba(0,0,0,0.6)">
						<form class="formulario" id="cargamac">
							<div>
								<div class="mensaje-input seleccionarchivo"><div class="flecha-mensaje-input"></div><p>Seleccione Una Imagen</p></div>
								<div class="mensaje-input archivonoprmitido"><div class="flecha-mensaje-input"></div><p>Archivo No Permitido</p></div>
								<input name="archivo-mac" id="archivo-mac" type="file">
							</div>
							<div id="verificarmac" class="boton">Comprobar Mac</div>
						</form>
					</div>';
			}
			return $r;
		}
		private function InterfazAdministrador(){
			$r = '<div class="contenedor-principal">'.$this->VerificarIngresoDeContraseña();
			$r = $r.' 		<div id="encabezado">
							<div class="contenedor">
								<div id="menu">
									<div class="opcion">Taquillas</div>
									<div class="opcion">Recolectores</div>
									<div class="opcion">Loterias</div>
									<div class="opcion">Sorteos</div>
									<div class="opcion">Ganancias</div>
								</div>
								<div id="usuario">'.$_POST["usuario"].'</div>
							</div>
						</div>
						<div id="contenido">
							<div class="contenedor">
								<div class="menu-lateral">
									<div class="opcion opcionlateral">Agregar Taquillas</div>
									<div class="opcion opcionlateral administrarbanca">Administar Taquillas</div>
								</div>
								<div class="menu-lateral">
									<div style="display:none" class="opcion opcionlateral">Agregar Banca</div>
									<div style="display:none" class="opcion  opcionlateral administrarbanca">Administar Banca</div>
									<div class="opcion opcionlateral ">Agregar Recolector</div>
									<div class="opcion  opcionlateral administrarrecolector">Administar Recolectores</div>
								</div>
								<div class="menu-lateral">
									<div style="display:none" class="opcion opcionlateral">Agregar Banca</div>
									<div style="display:none" class="opcion  opcionlateral administrarbanca">Administar Banca</div>
									<div style="display:none" class="opcion opcionlateral">Agregar Recolector</div>
									<div style="display:none" class="opcion opcionlateral administrarrecolector">Administar Recolectores</div>
									<div class="opcion opcionlateral">Agregar Loteria</div>
									<div class="opcion opcionlateral agragarjugadas">Agregar Jugada</div>
									<div class="opcion opcionlateral administrarloteria">Administrar Loterias</div>
									<div class="opcion opcionlateral administrarjugada">Administrar Jugada</div>
								</div>
								<div class="menu-lateral">
									<div style="display:none" class="opcion opcionlateral">Agregar Banca</div>
									<div style="display:none" class="opcion  opcionlateral administrarbanca">Administar Banca</div>
									<div style="display:none" class="opcion opcionlateral">Agregar Recolector</div>
									<div style="display:none" class="opcion opcionlateral administrarrecolector">Administar Recolectores</div>
									<div style="display:none" class="opcion opcionlateral">Agregar Loteria</div>
									<div style="display:none" class="opcion opcionlateral agragarjugadas">Agregar Jugada</div>
									<div style="display:none" class="opcion opcionlateral administrarloteria">Administrar Loterias</div>
									<div style="display:none" class="opcion opcionlateral administrarjugada">Administrar Jugada</div>
									<div  class="opcion opcionlateral agregarsorteo">Agregar Sorteos</div>
									<div  class="opcion opcionlateral adiministrarsorteo">Administrar Sorteos</div>
									<div  class="opcion opcionlateral sorteoslanzar">Finalizar Sorteos</div>
								</div>
								<div class="menu-lateral">
									<div style="display:none" class="opcion opcionlateral">Agregar Banca</div>
									<div style="display:none" class="opcion  opcionlateral administrarbanca">Administar Banca</div>
									<div style="display:none" class="opcion opcionlateral">Agregar Recolector</div>
									<div style="display:none" class="opcion opcionlateral administrarrecolector">Administar Recolectores</div>
									<div style="display:none" class="opcion opcionlateral">Agregar Loteria</div>
									<div style="display:none" class="opcion opcionlateral agragarjugadas">Agregar Jugada</div>
									<div style="display:none" class="opcion opcionlateral administrarloteria">Administrar Loterias</div>
									<div style="display:none" class="opcion opcionlateral administrarjugada">Administrar Jugada</div>
									<div style="display:none" class="opcion opcionlateral agregarsorteo">Agregar Sorteos</div>
									<div style="display:none" class="opcion opcionlateral adiministrarsorteo">Adiministrar Sorteos</div>
									<div style="display:none" class="opcion opcionlateral adiministrarsorteo">Adiministrar Sorteos</div>
									<div style="display:flex" class="opcion opcionlateral">Adiministrar porcenta</div>
									<div class="opcion opcionlateral">Adiministrar Ganancias</div>
								</div>
								<div class="informacion">
									<div class="formulario">
										<div style="display:none" class="mensajeagregarbanca boton">Registro Exitoso</div>
										<div>
											<div class="mensaje-input banca"><div class="flecha-mensaje-input"></div><p>Complete El Campo</p></div>
											<div class="mensaje-input bancaregistrada"><div class="flecha-mensaje-input"></div><p>Taquilla Registrada</p></div>
											<input id="banca" type="text" placeholder="Nombre De La Taquilla">		
										</div>
										<div>
											<div class="mensaje-input usuario"><div class="flecha-mensaje-input"></div><p>Complete El Campo</p></div>
											<div class="mensaje-input usuarioregistrado"><div class="flecha-mensaje-input"></div><p>Usuario Registrado</p></div>
											<input id="usuariobanca" type="text" placeholder="Nombre De Usuario">		
										</div>
										<div>
											<div class="mensaje-input porcentajebanca"><div class="flecha-mensaje-input"></div><p>Complete El Campo</p></div>
											<div class="mensaje-input porcentajebancanumero"><div class="flecha-mensaje-input"></div><p>Ingrese Un Valor Numérico</p></div>
											<input id="porcentajebanca" type="text" placeholder="Porcentaje De Ganancia">		
										</div>
										<div>
											<div class="mensaje-input telefonobanca"><div class="flecha-mensaje-input"></div><p>Complete El Campo</p></div>
											<input id="telefonobanca" type="text" placeholder="Número de teléfono">		
										</div>
										<div>
											<div class="mensaje-input macexiste"><div class="flecha-mensaje-input"></div><p>La Pc Ya Tiene una Taquilla Asignada</p></div>
											<input id="mac" type="text" placeholder="Mac De La Taquilla">		
										</div>
										<div style="tex-aling:center" id="agregarbanca" class="boton">Agregar</div>
									</div>
								</div>
								<div id="contenedor-bancas" class="informacion">
									<div id="contenedor-banca">
										<input id="buscarbanca" type="text" placeholder="Ingrese un nombre">
										<center><img id="cargabanca" style="display:none; width:30px; height:30px" src="imagenes/cargando.gif"></center>
										<div class="contenedor">
										</div>
									</div>
								</div>
								<div class="informacion">
									<div class="formulario">
										<div style="display:none" class="mensajeagregarrecolector boton">Registro Exitoso</div>
										<div>
											<div class="mensaje-input recolector"><div class="flecha-mensaje-input"></div><p>Complete El Campo</p></div>
											<div class="mensaje-input recolectorregistrado"><div class="flecha-mensaje-input"></div><p>Recolector Registrado</p></div>
											<input id="recolector" type="text" placeholder="Nombre Del Recolector">		
										</div>
										<div>
											<div class="mensaje-input usuario"><div class="flecha-mensaje-input"></div><p>Complete El Campo</p></div>
											<div class="mensaje-input usuarioregistrado"><div class="flecha-mensaje-input"></div><p>Usuario Registrado</p></div>
											<input id="usuariorecolector" type="text" placeholder="Nombre De Usuario">		
										</div>
										<div>
											<div class="mensaje-input porcentajerecolector"><div class="flecha-mensaje-input"></div><p>Complete El Campo</p></div>
											<div class="mensaje-input porcentajerecolectornumero"><div class="flecha-mensaje-input"></div><p>Ingrese Un Valor Numérico</p></div>
											<input id="porcentajerecolector" type="text" placeholder="Porcentaje De Ganancia">		
										</div>
										<div>
											<div class="mensaje-input telefonorecolector"><div class="flecha-mensaje-input"></div><p>Complete El Campo</p></div>
											<input id="telefonorecolector" type="text" placeholder="Número de teléfono">		
										</div>
										<div style="tex-aling:center" id="agregarrecolector" class="boton">Agregar</div>
									</div>
								</div>
								<div id="contenedor-recolectores" class="informacion">
									<div id="contenedor-recolector">
										<input id="buscarrecolector" type="text" placeholder="Ingrese un nombre">
										<center><img id="cargarecolector" style="display:none; width:30px; height:30px" src="imagenes/cargando.gif"></center>
										<div class="contenedor">
										</div>
									</div>
								</div>
								<div class="informacion">
									<div class="formulario">
										<div style="display:none" class="mensajeagregarloteria boton">Registro Exitoso</div>
										<div>
											<div class="mensaje-input loteria"><div class="flecha-mensaje-input"></div><p>Complete El Campo</p></div>
											<div class="mensaje-input loteriaregistrada"><div class="flecha-mensaje-input"></div><p>Loteria Registrado</p></div>
											<input id="loteria" type="text" placeholder="Nombre De La Loteria">		
										</div>
										<div>
											<div class="mensaje-input valorapuesta"><div class="flecha-mensaje-input"></div><p>Complete El Campo</p></div>
											<div class="mensaje-input valornumerico"><div class="flecha-mensaje-input"></div><p>Ingrese Un Valor Numérico</p></div>
											<input id="valorapuesta" type="text" placeholder="Valor Apuesta">		
										</div>
										<div>
											<div class="mensaje-input caducaciontiket"><div class="flecha-mensaje-input"></div><p>Complete El Campo</p></div>
											<div class="mensaje-input valornumericotiket"><div class="flecha-mensaje-input"></div><p>Ingrese Un Valor Numérico</p></div>
											<input id="diascaduca" type="text" placeholder="Días De Caducacion Tiket">		
										</div>
										<div style="tex-aling:center" id="agregarloteria" class="boton">Agregar</div>
										<center><img src="imagenes/cargando.gif"></center>
									</div>
								</div>
								<div class="informacion">
									<form  class="formulario" id="cargajugada">
									</form>
								</div>
								<div class="informacion respuestaloterias">
									
								</div>
								<div class="informacion respuestajugadas">
									
								</div>
								<div class="informacion">
									<form style="height:150px"  class="formulario formulariosorteo">
										
									</form>
								</div>
								<div id="administrar-sorteo" class="informacion">
									
								</div>
								<div class="informacion">
									<div id="lanzarsorteos">
										
									</div>
								</div>
								<div class="informacion infoporcentaje">
									'.$this->TablaPorcentageDeGanancia().'
								</div>
								<div class="informacion">
									<div id="contenedorfechas">
										<input id="fechaprimera" type="date">
										<input id="fechasegunda" type="date">
										<select id="tipodeusuario">
											<option id="banca">Taquillas</option>
											<option id="recolector">Reclectores</option>
										</select>
										<div id="buscarcontroldinero" class="boton">Buscar</div>
									</div>
									<div id="contenedorganancias"></div>
								</div>
							</div>
						</div>
					</div>	
			';
			return $r;
		}
		private function TablaPorcentageDeGanancia(){
			$r="<div id='administrar-porcentages'>";
			$consulta = $this->Comunicacion->Consultar("SELECT * FROM porcentajes");
			while($porcentajes = $this->Comunicacion->Recorrido($consulta)){
				$r = $r."<div class='botones botonescontrolporcentage'><div id='".$porcentajes[0]."' class='boton  modifiporcentageganancia'>Modificar Porcentage</div></div>";
			}
			$r = $r."<div class='contenedor'>";
			$consul = $this->Comunicacion->Consultar("SELECT * FROM porcentajes");
			while($listaporcentajes = $this->Comunicacion->Recorrido($consul)){
				$r=$r."<div class='contenedor-porcentages'>
					<div>".$listaporcentajes[0]."</div>
					<div>".$listaporcentajes[1]."</div>
				</div>";
			}
			$r = $r."</div>
			</div>
			<div style='display:none' class='modificar-porcntageganancia'>
					<div style='display:none' class='mensajevalorporcentage boton'>Datos Modificados</div>
					<div>
						<p style='display:none' class='conpletecampoporcentage'>Complete El Campo</p>
						<p style='display:none' class='conpletecampoapuestaporcentagenumerico'>Ingrese Valor Numérico</p>
						<input id='valorporcentagenuevo' type='text' placeholder='Valor Apuesta Nuevo'>
					</div><br>";
			$consull = $this->Comunicacion->Consultar("SELECT * FROM porcentajes");
			while($row = $this->Comunicacion->Recorrido($consull)){
				$r=$r."<div style='display:none' id='".$row[0]."' class='boton modificarvalorporcentagegaancia'>Modificar</div><br>";
			}
			$r=$r."<div class='boton salirmodificarporcentageganancia'>Salir</div>
				</div>";
			return $r;
		}
		private function InterfazBanca(){
			$r = '<div class="contenedor-principal"><div id="contenedorimrimir"></div>'.$this->VerificarIngresoDeContraseña();
			
			$r = $r.' 	<div id="encabezado">
							<div class="contenedor">
								<div id="menu">
									<div class="opcion">Apuestas</div>
									<div class="opcion">Balance</div>
								</div>
								<div id="usuario">'.$_POST["usuario"].'</div>
							</div>
						</div>
						<div id="contenido">
							<div class="contenedor">
								<div class="menu-lateral">';
									if($this->ComprobarBloqueo()!="bloqueado"){
										$r = $r.'<div class="opcion opcionlateral">Realizar Apuesta</div>';
									}else{
										$r = $r.'<div style="display:none" class="opcion opcionlateral">Realizar Apuesta</div>';
									}
									
									$r=$r.'<div class="opcion opcionlateral">Cancelar Tiket</div>
									<div class="opcion opcionlateral">Pagar Tiket</div>
									<div class="opcion opcionlateral bverpremios">Tiket Premiados</div>
								</div>
								<div class="menu-lateral">
									<div style="display:none" class="opcion opcionlateral">Realzar Apuesta</div>
									<div style="display:none" class="opcion opcionlateral">Pagar Tiket</div>
									<div style="display:none" class="opcion opcionlateral">Pagar Tiket</div>
									<div style="display:none" class="opcion opcionlateral">Tiket Premiados</div>
									<div class="opcion opcionlateral opcionverbalance">Ver Balance</div>
								</div>
								<div class="informacion apuesta">'.$this->Loterias()."  ".$this->Sorteos().'
									<div style="display:flex;flex-direction:row;justify-content:space-around">
										<div class="formulario">
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
												<img class="cargaapuesta" style="display:none" src="imagenes/cargando.gif">
												<div id="apostar" class="boton">Apostar</div>
											</div>
										</div>
										<div id="verlistado"></div>
										<div id="controlapuesta"></div>
									</div>
								</div>
								<div class="informacion">
									<div class="formulario">
										<div style="display:none" class="boton tiketcancelado">Tiket Cancelado</div>
										<div>
											<div class="mensaje-input codigonoasignado"><div class="flecha-mensaje-input"></div><p>Código No Registrado</p></div>					
											<input id="codigotiketcancel" type="text" placeholder="Código Tiket">
										</div>
										<div class="botones">
											<img class="cargacancelartket" style="display:none" src="imagenes/cargando.gif">
											<div id="cancelartiket" class="boton">Cancelar</div>
										</div>
									</div>
									<div id="resultadosganadores" style="display:none; flex-direction:column; margin:auto; width:300px; border:solid 1px #000">
									</div>
								</div>
								<div class="informacion">
									<div class="formulario formulariobuscatiket">
										<div style="display:none" class="boton pagoexitoso">Pago Finalizado</div>
										<div>
											<div class="mensaje-input codigonoganador"><div class="flecha-mensaje-input"></div><p>Código No Ganador</p></div>					
											<input id="codigotiket" type="text" placeholder="Código Tiket">
										</div>
										<div class="botones">
											<img class="cargabuscarpremios" style="display:none" src="imagenes/cargando.gif">
											<div id="buscarpremios" class="boton">Buscar</div>
										</div>
									</div>
									<div id="resultadosganadores" style="display:none; flex-direction:column; margin:auto; width:300px; border:solid 1px #000">
									</div>
								</div>
								<div class="informacion verpremios">
								</div>
								<div class="informacion">
									<div id="contenedorfechas">
										<input id="fechaprimerabanca" type="date">
										<input id="fechasegundabanca" type="date">
										<div id="buscarcontroldinerobanca" class="boton">Buscar</div>
									</div>
									<div id="contenedorganancias"></div>
								</div>
							</div>
						</div>
					</div>	
			';
			return $r;
		}
		private function InterfazRecolectores(){
			$r = '<div class="contenedor-principal">'.$this->VerificarIngresoDeContraseña();
			$r = $r.' 	<div id="encabezado">
							<div class="contenedor">
								<div id="menu">
									<div class="opcion">Taquillas</div>
									<div class="opcion">Ganancias</div>
								</div>
								<div id="usuario">'.$_POST["usuario"].'</div>
							</div>
						</div>
						<div id="contenido">
							<div class="contenedor">
								<div class="menu-lateral">';
								if($this->ComprobarBloqueo()!="bloqueado"){
									$r = $r.'<div class="opcion opcionlateral">Agregar Taquillas</div>';
								}else{
									$r = $r.'<div style="display:none" class="opcion opcionlateral">Agregar Taquillas</div>';
								}
									
									$r=$r.'<div class="opcion opcionlateral administrarbanca">Administar Taquillas</div>
								</div>
								<div class="menu-lateral">
									<div style="display:none" class="opcion opcionlateral">Agregar Banca</div>
									<div style="display:none" class="opcion  opcionlateral administrarbanca">Administar Banca</div>
									<div class="opcion opcionlateral">Adiministrar Ganancias</div>
								</div>
								<div class="informacion">
									<div class="formulario">
										<div style="display:none" class="mensajeagregarbanca boton">Registro Exitoso</div>
										<div>
											<div class="mensaje-input banca"><div class="flecha-mensaje-input"></div><p>Complete El Campo</p></div>
											<div class="mensaje-input bancaregistrada"><div class="flecha-mensaje-input"></div><p>Taquilla Registrada</p></div>
											<input id="banca" type="text" placeholder="Nombre De La Taquilla">		
										</div>
										<div>
											<div class="mensaje-input usuario"><div class="flecha-mensaje-input"></div><p>Complete El Campo</p></div>
											<div class="mensaje-input usuarioregistrado"><div class="flecha-mensaje-input"></div><p>Usuario Registrado</p></div>
											<input id="usuariobanca" type="text" placeholder="Nombre De Usuario">		
										</div>
										<div>
											<div class="mensaje-input porcentajebanca"><div class="flecha-mensaje-input"></div><p>Complete El Campo</p></div>
											<div class="mensaje-input porcentajebancanumero"><div class="flecha-mensaje-input"></div><p>Ingrese Un Valor Numérico</p></div>
											<input id="porcentajebanca" type="text" placeholder="Porcentaje De Ganancia">		
										</div>
										<div>
											<div class="mensaje-input telefonobanca"><div class="flecha-mensaje-input"></div><p>Complete El Campo</p></div>
											<input id="telefonobanca" type="text" placeholder="Número de teléfono">		
										</div>
										<div>
											<div class="mensaje-input macexiste"><div class="flecha-mensaje-input"></div><p>La Pc Ya Tiene una Taquilla Asignada</p></div>
											<input id="mac" type="text" placeholder="Mac De La Taquilla">		
										</div>
										<div style="tex-aling:center" id="agregarbanca" class="boton">Agregar</div>
									</div>
								</div>
								<div id="contenedor-bancas" class="informacion">
									<div id="contenedor-banca">
										<input id="buscarbanca" type="text" placeholder="Ingrese un nombre">
										<center><img id="cargabanca" style="display:none; width:30px; height:30px" src="imagenes/cargando.gif"></center>
										<div class="contenedor">
										</div>
									</div>
								</div>
								<div class="informacion">
									<div id="contenedorfechas">
										<input id="fechaprimerarecolector" type="date">
										<input id="fechasegundarecolector" type="date">
										
										<div id="buscarcontroldinerorecolector" class="boton">Buscar</div>
									</div>
									<div id="contenedorganancias"></div>
								</div>
							</div>
						</div>
					</div>	
			';
			return $r;
		}
	}
	new Sesion();

?>