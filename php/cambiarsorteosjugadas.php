<?php
	Class Cambiarsorteosjugadas{
		private $Comunicacion;
		function Cambiarsorteosjugadas(){
			include("conexion.php");
			$this->Comunicacion = new Conexion();
			if(isset($_GET["loteria"])){
				echo $this->Retorno();
			}
		}
		private function Retorno(){
			$r="";
			$consultacantidadsorteos = $this->Comunicacion->Consultar("SELECT * FROM sorteo WHERE loteria='".$_GET["loteria"]."'");
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
				$r=$r.'<center>
					<article class="info__columna">
						<h2 class="info__titulo">No Hay Sorteos</h2>
						<p class="info__txt">Espere Por El Administrador A Que Lo Agregue!!</p>
						<center><img src="img/nosorteado.png" alt="" class="info__img"></center>
					</article>
				</center>';
			}
			$consultacantidadsorteos = $this->Comunicacion->Consultar("SELECT * FROM sorteo WHERE loteria='".$_GET["loteria"]."'");
			$cantidadsorteos = $this->Comunicacion->NFilas($consultacantidadsorteos);
			$cantidadregistromostrar = 6;
			$pagina = 1;
			$paginasiguiente = $pagina + 1;
			$consultasorteos = $this->Comunicacion->Consultar("SELECT * FROM sorteo WHERE loteria='".$_GET["loteria"]."' ORDER BY hora ASC LIMIT 0,".$cantidadregistromostrar."");
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
			return $r;
		}
	}
	new Cambiarsorteosjugadas();
?>