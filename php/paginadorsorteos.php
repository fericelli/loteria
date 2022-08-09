<?php
	Class Paginadorsorteos{
		private $Comunicacion;
		function Paginadorsorteos(){
			include("conexion.php");
			$this->Comunicacion = new Conexion();
			if(isset($_GET["pagina"]) && isset($_GET["loteria"])){
				echo $this->Retorno($_GET["pagina"]);
			}
		}
		private function Retorno($pagina){
			$consultacantidadsorteos = $this->Comunicacion->Consultar("SELECT * FROM sorteo WHERE loteria='".$_GET["loteria"]."'");
			$cantidadsorteos = $this->Comunicacion->NFilas($consultacantidadsorteos);
			$cantidadregistromostrar = 6;
			$total_paginas = ceil($cantidadsorteos/$cantidadregistromostrar);
			$paginasiguiente = $pagina + 1;
			$paginaanterior = $pagina - 1;
			$inicio = ($pagina-1)*$cantidadregistromostrar;
			$r='<table class="tablasorteo segunda" style="width:300px">
				<tr>
					<th colspan="2">Lunes a Domingo</th>
				</tr>
				<tr>
					<th>Horario</th>	
				</tr>';
				
			$consultasorteos = $this->Comunicacion->Consultar("SELECT * FROM sorteo WHERE loteria='".$_GET["loteria"]."' ORDER BY hora ASC LIMIT ".$inicio.",".$cantidadregistromostrar."");
			while($sorteos = $this->Comunicacion->Recorrido($consultasorteos)){
				$date = new DateTime($sorteos[1]);
				$r=$r."<tr>
					<td>".date_format($date, 'g:i A')."</td>
				</tr>";
			}
			$r=$r."</table><br><div style='display:flex; width:300px; margin:auto;justify-content:space-around'>";
			if($pagina>1){
				$r=$r."<div id='".$paginaanterior."' class='ateriortablasorteo' style='cursor:pointer; padding:5px;color:#fff;background-color:#0B0B61'><</div>";
			}
			if($total_paginas>$pagina){
				$r=$r."<div id='".$paginasiguiente."' class='siguientetablasorteo' style='cursor:pointer; padding:5px;color:#fff;background-color:#0B0B61'>></div>";
			}
					
			return $r=$r."</div>";
		}
	}
	new Paginadorsorteos();
?>