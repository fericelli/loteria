<?php
	Class Paginacionloteria{
		private $Comunicacion;
		function Paginacionloteria(){
			include("../../php/conexion.php");
			$this->Comunicacion = new Conexion();
			if(isset($_GET["pagina"])){
				echo $this->Retorno($_GET["pagina"]);
			}
		}
		private function Retorno($pagina){
			$consultacantidadbancas = $this->Comunicacion->Consultar("SELECT * FROM loterias");
			$cantidadloterias = $this->Comunicacion->NFilas($consultacantidadbancas);
			$cantidadregistromostrar = 12;
			$total_paginas = ceil($cantidadloterias/$cantidadregistromostrar);
			$paginasiguiente = $pagina + 1;
			$paginaanterior = $pagina - 1;
			$inicio = ($pagina-1)*$cantidadregistromostrar;
			if($cantidadloterias>0){
				$r="<div id='conetenedor-verloterias'>";
				$consulta = $this->Comunicacion->Consultar("SELECT loteria,valorapuesta FROM loterias WHERE bloqueo<>'si' ORDER BY loteria ASC LIMIT ".$inicio.",".$cantidadregistromostrar."");
				while($row = $this->Comunicacion->Recorrido($consulta)){
					$r=$r."<div style='width:300px' class='botones botonesloterias'>
					<div id='".$row[0]."' class='boton  eliminarloteria'>Eliminar</div>
					<div id='".$row[0]."' class='boton  modificarloteria'>Modificar Valor Apuesta</div></div>";
				}
				$r=$r."<div class='contenedor'>";
				$consul = $this->Comunicacion->Consultar("SELECT loteria,valorapuesta FROM loterias WHERE bloqueo<>'si' ORDER BY loteria ASC LIMIT ".$inicio.",".$cantidadregistromostrar."");
				while($row = $this->Comunicacion->Recorrido($consul)){
					$r=$r."<div class='contenedor-loteria'>
						<div>".$row[0]."</div>
						<div>".$row[1]."</div>
					</div>";
				}
				$r=$r."</div>";
				if($total_paginas>$pagina){
					$r=$r."<div id='".$paginasiguiente."' class='botonsiguiete botonloteriasiguiete'>></div>";
				}
				if($pagina>1){
					$r=$r."<div id='".$paginaanterior."' class='botonanterior botonloteriaaterior'><</div>";
				}
				$r=$r."</div>
				<div style='display:none' class='modificar-loteria'>
						<div style='display:none' class='mensajevalorapuesta boton'>Datos Modificados</div>
						<div>
							<div class='mensaje-input conpletecampoapuesta'><div class='flecha-mensaje-input'></div><p>Complete El Campo</p></div>
							<div class='mensaje-input conpletecampoapuestavalornumerico'><div class='flecha-mensaje-input'></div><p>Ingrese Valor Numérico</p></div>
							<input id='valorapuestanuevo' type='text' placeholder='Valor Apuesta Nuevo'>
						</div><br>";
				$consull = $this->Comunicacion->Consultar("SELECT loteria FROM loterias WHERE bloqueo<>'si' LIMIT ".$inicio.",".$cantidadregistromostrar."");
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
	new Paginacionloteria();
?>