<?php
	Class Paginacionganadores{
		private $Comunicacion;
		function Paginacionganadores(){
			include("../../php/conexion.php");
			$this->Comunicacion = new Conexion();
			if(isset($_GET["usuario"]) && isset($_GET["pagina"])){
				echo $this->Retorno($_GET["pagina"]);
			}
		}
		private function Retorno($pagina){
			$r='<div style="width:300px; border: solid 1px #000; margin:auto" id="tiketganadores">
			<div style="display:flex;flex-direction:row; justify-content:space-around"><div>Tiket</div><div>Ganancia</div></div>';
			$consultar = $this->Comunicacion->Consultar("SELECT DISTINCT codigo FROM ganadores WHERE banca='".$this->Banca()."'");
			$cantidadganadores = $this->Comunicacion->NFilas($consultar);
			$cantidadregistromostrar = 10;
			$total_paginas = ceil($cantidadganadores/$cantidadregistromostrar);
			$paginasiguiente = $pagina + 1;
			$paginaanterior = $pagina - 1;
			$inicio = ($pagina-1)*$cantidadregistromostrar;
			$consultarr = $this->Comunicacion->Consultar("SELECT DISTINCT codigo FROM ganadores WHERE banca='".$this->Banca()."' LIMIT ".$inicio.",".$cantidadregistromostrar."");
			if($cantidadganadores>0){
				while($codigo = $this->Comunicacion->Recorrido($consultarr)){
					$consultasuma = $this->Comunicacion->Consultar("SELECT SUM(ganancia) FROM ganadores WHERE codigo='".$codigo[0]."'");
					if($suma = $this->Comunicacion->Recorrido($consultasuma)){
						$r=$r."<div style='display:flex;flex-direction:row; justify-content:space-around'><div>".substr($codigo[0],strlen($this->Banca())+1)."</div>
						<div>".$suma[0]."</div></div>";
					}
				}
				
				if($total_paginas>$pagina){
					$r=$r."<div style='transform: translateX(-300px)' id='".$paginasiguiente."' class='botonsiguiete botonganadoressiguiete'>></div>";
				}
				if($pagina>1){
					$r=$r."<div style='transform: translateX(300px)' id='".$paginaanterior."' class='botonanterior botonganadoresanterior'><</div>";
				}
				return $r=$r."</div>";
			}else{
				$r=$r."<h2>No Hay Premios</h2>";
			}
			return $r;
		}
		private function Banca(){
			$consulta = $this->Comunicacion->Consultar("SELECT nombre FROM bancas WHERE usuario='".$_GET["usuario"]."'");
			if($row = $this->Comunicacion->Recorrido($consulta)){
				return $row[0];
			}else{
				return "";
			}
		}
	}
	new Paginacionganadores();
?>