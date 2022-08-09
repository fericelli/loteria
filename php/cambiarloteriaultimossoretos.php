<?php
	Class Cambiarloteriaultimossoretos{
		private $Comunicacion;
		function Cambiarloteriaultimossoretos(){
			include("conexion.php");
			$this->Comunicacion = new Conexion();
			
			if(isset($_GET["loteria"])){
				
				echo $this->retorno();
			}
		}
		private function retorno(){
			$r="";
			$cosnultajugadasganaoras = $this->Comunicacion->Consultar("SELECT * FROM jugadasganadoras WHERE loteria='".$_GET["loteria"]."'");
				$cantidadloterias = $this->Comunicacion->NFilas($cosnultajugadasganaoras);
				if($cantidadloterias>0){
					$consultaultimasjugadas = $this->Comunicacion->Consultar("SELECT sorteo,jugada FROM jugadasganadoras WHERE loteria='".$_GET["loteria"]."' ORDER BY sorteo DESC LIMIT 0,3");
					$contador = 0;
					while($jugadasganadoras = $this->Comunicacion->Recorrido($consultaultimasjugadas)){
						$date = date_create($jugadasganadoras[0]);
						$contador ++;
						$r=$r.'<article class="info__columna">
						<h2 class="info__titulo">Sorteo '.date_format($date, 'g:i A').'</h2>
						<p class="info__txt">La Jugada Ganadora Es: '.$jugadasganadoras[1].'</p>';
						$consultaimagen = $this->Comunicacion->Consultar("SELECT imagen FROM jugadas WHERE nombre='".$jugadasganadoras[1]."' AND loteria='".$_GET["loteria"]."'");
						if($imagen = $this->Comunicacion->Recorrido($consultaimagen)){
							$r=$r.'<center><img src="sistema/'.$imagen[0].'" alt="" class="info__img"></center>';
						}
						$r=$r.'</article>';
					}
					while($contador<3){
						$r=$r.'<article class="info__columna">
							<h2 class="info__titulo">No Hay Sorteo</h2>
							<p class="info__txt">Espere Por El Sorteo!!</p>
							<center><img src="img/nosorteado.png" alt="" class="info__img"></center>
						</article>';
						$contador ++;
					}
				}else{
					$contador = 0;
					while($contador<3){
					$r=$r.'<article class="info__columna">
							<h2 class="info__titulo">No Hay Sorteo</h2>
							<p class="info__txt">Espere Por El Sorteo!!</p>
							<center><img src="img/nosorteado.png" alt="" class="info__img"></center>
						</article>';
						$contador ++;
					}
				}
					
				if($contador==0){
					$r=$r.'<article class="info__columna">
					<h2 class="info__titulo">No Hay Loterias</h2>
					<p class="info__txt">Espere Por El Administrador A Que La Agreguen!!</p>
					<center><img src="img/nosorteado.png" alt="" class="info__img"></center>
					</article>';
				}
			return $r;
		}
	}
	new Cambiarloteriaultimossoretos();
?>