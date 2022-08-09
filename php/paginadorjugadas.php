<?php
	Class Paginadorjugadas{
		private $Comunicacion;
		function Paginadorjugadas(){
			include("conexion.php");
			$this->Comunicacion = new Conexion();
			if(isset($_GET["pagina"]) && isset($_GET["loteria"])){
				echo $this->Retorno($_GET["pagina"]);
			}
		}
		private function Retorno($pagina){
			
			$consultajugadas = $this->Comunicacion->Consultar("SELECT * FROM jugadas WHERE loteria='".$_GET["loteria"]."' AND bloqueo<>'si'");
			$cantidadjugadas = $this->Comunicacion->NFilas($consultajugadas);
			$cantidadregistromostrar = 6;
			$total_paginas = ceil($cantidadjugadas/$cantidadregistromostrar);
			$paginasiguiente = $pagina + 1;
			$paginaanterior = $pagina - 1;
			$inicio = ($pagina-1)*$cantidadregistromostrar;
			//return "SELECT * FROM jugadas WHERE loteria='".$_GET["loteria"]."' AND bloqueo<>'si' ORDER BY codigoapuesta ASC LIMIT ".$inicio.",".$cantidadregistromostrar."";
			$consulta = $this->Comunicacion->Consultar("SELECT * FROM jugadas WHERE loteria='".$_GET["loteria"]."' AND bloqueo<>'si' ORDER BY codigoapuesta ASC LIMIT ".$inicio.",".$cantidadregistromostrar."");
			$r="";
			$r=$r.'<table class="tablasorteo" style="width:90%;margin:auto">
				<tr>
					<th>Código</th>
					<th>Nombre</th>
					<th>Imagen</th>
				</tr>';
			while($jugadas = $this->Comunicacion->Recorrido($consulta)){
				$r=$r."<tr>
					<th>".$jugadas[0]."</th>
					<th>".$jugadas[1]."</th>
					<th><img src='sistema/".$jugadas[3]."'/></th>
				</tr>";
			}
			$r=$r."</table><br><div style='display:flex; justify-content:space-around'>";
				
				if($pagina>1){
					$r=$r."<div id='".$paginaanterior."' class='ateriortablajugadas' style='cursor:pointer; padding:5px;color:#fff;background-color:#0B0B61'><</div>";
				}
				if($total_paginas>$pagina){
					$r=$r."<div id='".$paginasiguiente."' class='siguientetablajugadas' style='cursor:pointer; padding:5px;color:#fff;background-color:#0B0B61'>></div>";
				}
					
			return $r=$r."</div>";
		}
	}
	new Paginadorjugadas();
?>