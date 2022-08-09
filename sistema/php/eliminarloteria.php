<?php
	Class Eliminarloteria{
		private $Comunicacion;
		function Eliminarloteria(){
			include("../../php/conexion.php");
			$this->Comunicacion = new Conexion();
			if(isset($_GET['loteria'])){
				if($this->ComprobarJugadas()=='bloquear'){
					if($this->Bloquear()=='bloqueado'){
						echo $this->RetornoBloqueado();
					}
				}else{
					if($this->Eliminar()=="eliminada"){
						echo $this->RetornoEliminada();
					}
				}
			}
		}
		private function ComprobarJugadas(){
			$consulta = $this->Comunicacion->Consultar("SELECT * FROM apuesta WHERE loteria='".$_GET["loteria"]."'");
			$consultar = $this->Comunicacion->Consultar("SELECT * FROM controlapuesta WHERE loteria='".$_GET["loteria"]."'");
			$consultarr = $this->Comunicacion->Consultar("SELECT * FROM ganadores WHERE loteria='".$_GET["loteria"]."'");
			if($this->Comunicacion->Recorrido($consultar)){
				return "bloquear";
			}
			if($this->Comunicacion->Recorrido($consulta)){
				return "bloquear";
			}
			if($this->Comunicacion->Recorrido($consultarr)){
				return "bloquear";
			}
		}
		private function Bloquear(){
			$consulta = $this->Comunicacion->Consultar("UPDATE loterias SET bloqueo='si' WHERE loteria='".$_GET['loteria']."'");
			if($consulta==true && $consultar==true){
				return "bloqueado";
			}
		}
		private function Eliminar(){
			
			$carpeta = '$_SERVER[DOCUMENT_ROOT]/sistema/imagenes/'.$_GET["loteria"];
			
			$consulta = $this->Comunicacion->Consultar("DELETE FROM loterias WHERE loteria='".$_GET['loteria']."'");
			$eliminrsorteos = $this->Comunicacion->Consultar("DELETE FROM sorteo WHERE loteria='".$_GET['loteria']."'");
			$consultar = $this->Comunicacion->Consultar("DELETE FROM dineroapostado WHERE loteria='".$_GET['loteria']."'");
			$consultar = $this->Comunicacion->Consultar("DELETE FROM controlsorteo WHERE loteria='".$_GET['loteria']."'");
			rmdir($carpeta);
			return "eliminada";
			
		}
		private function RetornoBloqueado(){
			$consultacantidadloterias = $this->Comunicacion->Consultar("SELECT loteria,valorapuesta FROM loterias WHERE bloqueo<>'si' ORDER BY loteria ASC");
			$cantidadloterias = $this->Comunicacion->NFilas($consultacantidadloterias);
			$cantidadregistromostrar = 12;
			$pagina = 1;
			$paginasiguiente = $pagina + 1;
			if($cantidadloterias>0){
				$r="<div id='conetenedor-verloterias'>
				<div style='font-size:12px' class='boton loteriabloqueada mensajeloteria'>Loteria Bloqueada Para Ser Eliminada</div>";
				$consulta = $this->Comunicacion->Consultar("SELECT loteria,valorapuesta FROM loterias WHERE bloqueo<>'si' ORDER BY loteria ASC LIMIT 0,".$cantidadregistromostrar."");
				while($row = $this->Comunicacion->Recorrido($consulta)){
					$r=$r."<div style='width:300px' class='botones botonesloterias'>
					<div id='".$row[0]."' class='boton  eliminarloteria'>Eliminar</div>
					<div id='".$row[0]."' class='boton  modificarloteria'>Modificar Valor Apuesta</div></div>";
				}
				$r=$r."<div class='contenedor'>";
				$consul = $this->Comunicacion->Consultar("SELECT loteria,valorapuesta FROM loterias WHERE bloqueo<>'si' ORDER BY loteria ASC LIMIT 0,".$cantidadregistromostrar."");
				while($row = $this->Comunicacion->Recorrido($consul)){
					$r=$r."<div class='contenedor-loteria'>
							<div>".$row[0]."</div>
							<div>".$row[1]."</div>
						</div>";
				}
				$r=$r."</div>";
				if($cantidadloterias>$cantidadregistromostrar){
					$r=$r."<div id='".$paginasiguiente."' class='siguiente botonsiguiete botonloteriasiguiete'>></div>";
				}
				$r=$r."</div>
				<div style='display:none' class='modificar-loteria'>
						<div style='display:none' class='mensajevalorapuesta boton'>Datos Modificados</div>
						<div>
							<div class='mensaje-input conpletecampoapuesta'><div class='flecha-mensaje-input'></div><p>Complete El Campo</p></div>
							<div class='mensaje-input conpletecampoapuestavalornumerico'><div class='flecha-mensaje-input'></div><p>Ingrese Valor Numérico</p></div>
							<input id='valorapuestanuevo' type='text' placeholder='Valor Apuesta Nuevo'>
						</div><br>";
				$consull = $this->Comunicacion->Consultar("SELECT loteria FROM loterias WHERE bloqueo<>'si' LIMIT 0,".$cantidadregistromostrar."");
				while($row = $this->Comunicacion->Recorrido($consull)){
					$r=$r."<div style='display:none, text-align:center' id='".$row[0]."' class='boton modificarvalorapuesta'>Modificar</div><br>";
				}
				$r=$r."<div class='boton salirmodificarvalorapuesta'>Salir</div>
					</div>";
				return $r;
			}else{
				$r="<div id='conetenedor-verloterias'>
					<h2>No Hay Loterias Agregadas</h2>
				</div>";
				return $r;
			}
		}
		private function RetornoEliminada(){
			$consultacantidadloterias = $this->Comunicacion->Consultar("SELECT loteria,valorapuesta FROM loterias WHERE bloqueo<>'si' ORDER BY loteria ASC");
			$cantidadloterias = $this->Comunicacion->NFilas($consultacantidadloterias);
			$cantidadregistromostrar = 12;
			$pagina = 1;
			$paginasiguiente = $pagina + 1;
			if($cantidadloterias>0){
				$r="<div id='conetenedor-verloterias'>
				<div class='boton loteriaeliminada mensajeloteria'>Loteria Eliminada</div>";
				$consulta = $this->Comunicacion->Consultar("SELECT loteria,valorapuesta FROM loterias WHERE bloqueo<>'si' ORDER BY loteria ASC LIMIT 0,".$cantidadregistromostrar."");
				while($row = $this->Comunicacion->Recorrido($consulta)){
					$r=$r."<div style='width:300px' class='botones botonesloterias'>
					<div id='".$row[0]."' class='boton  eliminarloteria'>Eliminar</div>
					<div id='".$row[0]."' class='boton  modificarloteria'>Modificar Valor Apuesta</div></div>";
				}
				$r=$r."<div class='contenedor'>";
				$consul = $this->Comunicacion->Consultar("SELECT loteria,valorapuesta FROM loterias WHERE bloqueo<>'si' ORDER BY loteria ASC LIMIT 0,".$cantidadregistromostrar."");
				while($row = $this->Comunicacion->Recorrido($consul)){
					$r=$r."<div class='contenedor-loteria'>
							<div>".$row[0]."</div>
							<div>".$row[1]."</div>
						</div>";
				}
				$r=$r."</div>";
				if($cantidadloterias>$cantidadregistromostrar){
					$r=$r."<div id='".$paginasiguiente."' class='siguiente botonsiguiete botonloteriasiguiete'>></div>";
				}
				$r=$r."</div>
				<div style='display:none' class='modificar-loteria'>
						<div style='display:none' class='mensajevalorapuesta boton'>Datos Modificados</div>
						<div>
							<div class='mensaje-input conpletecampoapuesta'><div class='flecha-mensaje-input'></div><p>Complete El Campo</p></div>
							<div class='mensaje-input conpletecampoapuestavalornumerico'><div class='flecha-mensaje-input'></div><p>Ingrese Valor Numérico</p></div>
							<input id='valorapuestanuevo' type='text' placeholder='Valor Apuesta Nuevo'>
						</div><br>";
				$consull = $this->Comunicacion->Consultar("SELECT loteria FROM loterias WHERE bloqueo<>'si' LIMIT 0,".$cantidadregistromostrar."");
				while($row = $this->Comunicacion->Recorrido($consull)){
					$r=$r."<div style='display:none, text-align:center' id='".$row[0]."' class='boton modificarvalorapuesta'>Modificar</div><br>";
				}
				$r=$r."<div class='boton salirmodificarvalorapuesta'>Salir</div>
					</div>";
				return $r;
			}else{
				$r="<div id='conetenedor-verloterias'>
					<h2>No Hay Loterias Agregadas</h2>
				</div>";
				return $r;
			}
		}
	}
	new Eliminarloteria();
?>