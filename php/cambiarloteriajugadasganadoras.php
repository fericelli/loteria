<?php
	Class Cambiarloteriajugadasganadoras{
		private $Comunicacion;
		function Cambiarloteriajugadasganadoras(){
			include("conexion.php");
			$this->Comunicacion = new Conexion();
			if(isset($_GET["loteria"])){
				echo $this->Retorno();
			}
		}
		private function Retorno(){
			$r="";
			$consultarcantidadsorteos = $this->Comunicacion->Consultar("SELECT * FROM jugadasganadoras WHERE loteria='".$_GET["loteria"]."'");
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
				$cosultajugadasganadoas = $this->Comunicacion->Consultar("SELECT * FROM jugadasganadoras WHERE loteria='".$_GET["loteria"]."' ORDER BY sorteo DESC LIMIT 0,".$cantidadregistromostrar."");
				while($jugadasganadoras = $this->Comunicacion->Recorrido($cosultajugadasganadoas)){
					$sorteo = explode(" ",$jugadasganadoras[0]);
					$fecha = strtotime($sorteo[0]);
					$date = date('d-m-Y',$fecha);
					$hora = date_create($jugadasganadoras[0]);
					$r=$r."<tr>
						<td>".$date."</td>
						<td>".date_format($hora, 'g:i A')."</td>
						<td><div>".$jugadasganadoras[2];
					$consultarimagen = $this->Comunicacion->Consultar("SELECT imagen FROM jugadas WHERE nombre='".$jugadasganadoras[2]."' AND loteria='".$_GET["loteria"]."'");
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
				$r=$r.'<center><article class="info__columna">
					<h2 class="info__titulo">No Hay Sorteos</h2>
					<p class="info__txt">Espere Por El Administrador A Que La Agreguen!!</p>
					<center><img src="img/nosorteado.png" alt="" class="info__img"></center>
				</article></center>';
			}
			return $r;
		}
	}
	new Cambiarloteriajugadasganadoras();
?>