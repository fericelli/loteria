<?php
	Class Paginaganadores{
		private $Comunicacion;
		function Paginaganadores(){
			include("conexion.php");
			$this->Comunicacion = new Conexion();
			if(isset($_GET["pagina"]) && isset($_GET["loteria"])){
				echo $this->Retorno($_GET["pagina"]);
			}
		}
		private function Retorno($pagina){
			$consultarcantidadsorteos = $this->Comunicacion->Consultar("SELECT * FROM jugadasganadoras WHERE loteria='".$_GET["loteria"]."'");
			$cantidadjugadasganadoras = $this->Comunicacion->NFilas($consultarcantidadsorteos);
			$cantidadregistromostrar = 4;
			$total_paginas = ceil($cantidadjugadasganadoras/$cantidadregistromostrar);
			$paginasiguiente = $pagina + 1;
			$paginaanterior = $pagina - 1;
			$inicio = ($pagina-1)*$cantidadregistromostrar;
			$r='<table class="tablasorteo segunda" style="width:300px">
				<tr>
					<th>Fecha</th>
					<th>Sorteos</th>
					<th>Jugada Ganadora</th>
				</tr>';
				$cosultajugadasganadoas = $this->Comunicacion->Consultar("SELECT * FROM jugadasganadoras WHERE loteria='".$_GET["loteria"]."' ORDER BY sorteo DESC LIMIT ".$inicio.",".$cantidadregistromostrar."");
				while($jugadasganadoras = $this->Comunicacion->Recorrido($cosultajugadasganadoas)){
					$sorteo = explode(" ",$jugadasganadoras[0]);
					//return $sorteo[0];
					$fecha = strtotime($sorteo[0]);
					$date = date('d-m-Y',$fecha);
					$hora = date_create($jugadasganadoras[0]);
					$r=$r."<tr>
						<td>".$date."</td>
						<td>".date_format($hora, 'g:i A')."</td>
						<td><div>".$jugadasganadoras[2];
						$consultarimagen = $this->Comunicacion->Consultar("SELECT imagen FROM jugadas WHERE nombre='".$jugadasganadoras[2]."'");
						if($imagen = $this->Comunicacion->Recorrido($consultarimagen)){
							$r=$r."</div><img src='sistema/".$imagen[0]."'></td>";
						}
					$r=$r."</tr>";
				}
				$r=$r."</table><br><div style='display:flex; justify-content:space-around'>";
				
				if($pagina>1){
					$r=$r."<div id='".$paginaanterior."' class='anteriostablaganadoras' style='cursor:pointer; padding:5px;color:#fff;background-color:#0B0B61'><</div>";
				}
				if($total_paginas>$pagina){
					$r=$r."<div id='".$paginasiguiente."' class='siguientetablaganadoras' style='cursor:pointer; padding:5px;color:#fff;background-color:#0B0B61'>></div>";
				}
			return $r."</div>";
		}
	}
	new Paginaganadores();
?>