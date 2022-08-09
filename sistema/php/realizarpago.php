<?php
	Class Realizarpago{
		private $Comunicacion;
		function Realizarpago(){
			include("../../php/conexion.php");
			$this->Comunicacion = new Conexion();
			if(isset($_POST["codigo"])){
				$this->BorrarLoteriaYJugadasNoexistentes();
				echo $this->ConfirmarPago();
			}
		}
		private function ConfirmarPago(){
			$consultasorteo = $this->Comunicacion->Consultar("SELECT loteria,fecha,sorteo FROM ganadores WHERE codigo='".$_POST["codigo"]."'");
			$cantidadsorteo = $this->Comunicacion->NFilas($consultasorteo);
			while($sorteos = $this->Comunicacion->Recorrido($consultasorteo)){
				$consultacantidadsorteos = $this->Comunicacion->Consultar("SELECT * FROM ganadores WHERE loteria='".$sorteos[0]."' AND fecha='".$sorteos[1]."' AND sorteo='".$sorteos[2]."'");
				 $cantidadloteriaenganadores = $this->Comunicacion->NFilas($consultacantidadsorteos);
				if($cantidadsorteo==$cantidadloteriaenganadores){
					//return "DELETE FROM jugadasganadoras WHERE sorteo='".$sorteos[1]." ".$sorteos[2]."' AND loteria='".$sorteos[0]."'";
					//$this->Comunicacion->Consultar("DELETE FROM jugadasganadoras WHERE sorteo='".$sorteos[1]." ".$sorteos[2]."' AND loteria='".$sorteos[0]."'");
				}
			}
			$this->Comunicacion->Consultar("DELETE FROM ganadores WHERE codigo='".$_POST["codigo"]."'");
			
		}
		private function BorrarLoteriaYJugadasNoexistentes(){
			$consultasorteotiket = $this->Comunicacion->Consultar("SELECT fecha,sorteo FROM ganadores WHERE codigo='".$_POST["codigo"]."'");
			$cantidadsorteo = $this->Comunicacion->NFilas($consultasorteotiket);
			if($sorteos = $this->Comunicacion->Recorrido($consultasorteotiket)){
				//return "SELECT * FROM ganadores WHERE fecha='".$sorteos[0]."' AND sorteo='".$sorteos[0]."'";
				$consultacantidadsorteos = $this->Comunicacion->Consultar("SELECT * FROM ganadores WHERE fecha='".$sorteos[0]."' AND sorteo='".$sorteos[1]."'");
				$cantidadloteriaenganadores = $this->Comunicacion->NFilas($consultacantidadsorteos);
				if($cantidadsorteo==$cantidadloteriaenganadores){
					$consultajugadagnadora = $this->Comunicacion->Consultar("SELECT * FROM jugadasganadoras WHERE sorteo='".$sorteos[0]." ".$sorteos[1]."'");
					if($jugadasganadoras = $this->Comunicacion->Recorrido($consultajugadagnadora)){
						$consultacantidadloteriajugadas = $this->Comunicacion->Consultar("SELECT * FROM jugadasganadoras WHERE loteria='".$jugadasganadoras[1]."'");
						$cantidadloteriajugadas = $this->Comunicacion->NFilas($consultacantidadloteriajugadas);
						if($cantidadloteriajugadas==1){
							$camprobarblqoeuoloteria = $this->Comunicacion->Consultar("SELECT bloqueo FROM loterias WHERE loteria='".$jugadasganadoras[1]."'");
							if($bloqueoloteria = $this->Comunicacion->Recorrido($camprobarblqoeuoloteria)){
								if($bloqueoloteria[0]=="si"){
									unlink("../imagenes/".$jugadasganadoras[1]);
									
								}
							}
						}
						$consultacantidadjugadas = $this->Comunicacion->Consultar("SELECT * FROM jugadasganadoras WHERE loteria='".$jugadasganadoras[1]."' AND jugada='".$jugadasganadoras[2]."'");
						$cantidadjugadas = $this->Comunicacion->NFilas($consultacantidadjugadas);
						if($cantidadjugadas==1){
							//return "SELECT imagen,bloqueo FROM jugadas WHERE loteria='".$jugadasganadoras[1]."' AND jugada='".$jugadasganadoras[2]."'";
							$comprobarbloqueojugadas = $this->Comunicacion->Consultar("SELECT imagen,bloqueo FROM jugadas WHERE loteria='".$jugadasganadoras[1]."' AND nombre='".$jugadasganadoras[2]."'");
							if($bloqueojugadas = $this->Comunicacion->Recorrido($comprobarbloqueojugadas)){
								if($bloqueojugadas[1]=="si"){
									unlink("../".$bloqueojugadas[0]);
								}
							}
						}
					}
				}
			}
		}
	}
	new Realizarpago();
?>