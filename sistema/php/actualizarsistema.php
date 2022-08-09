<?php
	Class Actualizarsistema{
		private $Comunicacion;
		function Actualizarsistema(){
			include("../../php/conexion.php");
			$this->Comunicacion = new Conexion();
			echo $this->actualizar();
		}
		private function actualizar(){
			$this->EliminarTiketGanador();
			$this->EliminarLoterias();
			$this->EliminarJugadas();
			$this->EliminarRegstro();
			//$this->EliminarJugadasGanadores();
			
		}
		private function EliminarRegstro(){
			$consulta = $this->Comunicacion->Consultar("SELECT DISTINCT(fecha) FROM controlsorteo ORDER BY fecha ASC");
			while($fechacontrolsorteo = $this->Comunicacion->Recorrido($consulta)){
				if($fechacontrolsorteo[0]!=date("Y-m-d")){
					$this->Comunicacion->Consultar("DELETE FROM controlsorteo WHERE fecha='".$fechacontrolsorteo[0]."'");
					$this->Comunicacion->Consultar("DELETE FROM dineroapostado WHERE fecha='".$fechacontrolsorteo[0]."'");
				}
			}
		}
		private function EliminarTiketGanador(){
			$consultatiket = $this->Comunicacion->Consultar("SELECT * FROM ganadores");
			while($tiketganadores = $this->Comunicacion->Recorrido($consultatiket)){
				$dias = 0;
				for($i=$tiketganadores[5];$i<=date("Y-m-d");$i = date("Y-m-d", strtotime($i ."+ 1 days"))){
					$dias ++;
				}
				$consultadias = $this->Comunicacion->Consultar("SELECT diascaducaciontiket FROM loterias WHERE loteria='".$tiketganadores[3]."'");
				if($diasdecaducacion = $this->Comunicacion->Recorrido($consultadias)){
					if($diasdecaducacion[0]<=$dias){
						$this->Comunicacion->Consultar("DELETE FROM ganadores WHERE loteria='".$tiketganadores[3]."' AND fecha='".$tiketganadores[5]."'");
					}
				}
			}
		}
		private function EliminarLoterias(){
			$consultar = $this->Comunicacion->Consultar("SELECT loteria FROM loterias WHERE bloqueo='si'");
			while($loterias = $this->Comunicacion->Recorrido($consultar)){
				$consultaganadores = $this->Comunicacion->Consultar("SELECT * FROM ganadores WHERE loteria='".$loterias[0]."'");
				$cantidadloteriagaadores = $this->Comunicacion->NFilas($consultaganadores);
				if($cantidadloteriagaadores<1){
					
					$this->Comunicacion->Consultar("DELETE FROM loterias WHERE loteria='".$loterias[0]."'");
					$this->Comunicacion->Consultar("DELETE FROM jugadasganadoras WHERE loteria='".$loterias[0]."'");
					$this->Comunicacion->Consultar("DELETE FROM jugadas WHERE loteria='".$loterias[0]."'");
					$this->Comunicacion->Consultar("DELETE FROM sorteo WHERE loteria='".$loterias[0]."'");
					$this->Comunicacion->Consultar("DELETE FROM controlsorteo WHERE loteria='".$loterias[0]."'");
					$this->Comunicacion->Consultar("DELETE FROM dineroapostado WHERE loteria='".$loterias[0]."'");
					$carpeta = '$_SERVER[DOCUMENT_ROOT]/sistema/imagenes/'.$loterias[0];
					rmdir($carpeta);
				}
			}
		}
		private function EliminarJugadas(){
			$consultar = $this->Comunicacion->Consultar("SELECT nombre,loteria FROM jugadas WHERE bloqueo='si'");
			while($jugadas = $this->Comunicacion->Recorrido($consultar)){
				$consultaganadores = $this->Comunicacion->Consultar("SELECT * FROM ganadores WHERE jugada='".$jugadas[0]."' loteria='".$jugadas[1]."'");
				$cantidadjugadaganadres = $this->Comunicacion->NFilas($consultaganadores);
				if($cantidadloteriagaadores<1){
					$this->Comunicacion->Consultar("DELETE FROM jugadasganadoras WHERE loteria='".$jugadas[1]."' AND jugada='".$jugadas[0]."'");
					$this->Comunicacion->Consultar("DELETE FROM jugadas WHERE nombre='".$loterias[0]."' AND loteria='".$loterias[1]."'");
					$this->Comunicacion->Consultar("DELETE FROM controlsorteo WHERE jugada='".$loterias[0]."' AND loteria='".$loterias[1]."'");
					$cosultadirectorio = $this->Comunicacion->Consultar("SELECT imagen FROM jugada WHERE nombre='".$loterias[0]."' AND loteria='".$loterias[1]."'");
					if($imagen = $this->Comunicacion->Recorrido($cosultadirectorio)){
						$carpeta = '$_SERVER[DOCUMENT_ROOT]/sistema/'.$imagen[0];
						unlink($carpeta);
					}	
						
				}
			}
		}
		private function EliminarJugadasGanadores(){
			$consultar = $this->Comunicacion->Consultar("SELECT sorteo,loteria FROM jugadasganadoras");
			while($jugadaganadoras = $this->Comunicacion->Recorrido($consultar)){
				$sorteo = explode(" ",$jugadaganadoras[0]);
				$consultacantidad = $this->Comunicacion->Consultar("SELECT * FROM ganadores WHERE loteria='".$jugadaganadoras[1]."' AND fecha='".$sorteo[0]."' AND sorteo='".$sorteo[1]."'");
				$cantidad = $this->Comunicacion->NFilas($consultacantidad);
				if($cantidad<1){
					//return "DELETE FROM jugadaganadoras WHERE sorteo='".$jugadaganadoras[0]."' AND loteria='".$jugadaganadoras[1]."'";
					$this->Comunicacion->Consultar("DELETE FROM jugadasganadoras WHERE sorteo='".$jugadaganadoras[0]."' AND loteria='".$jugadaganadoras[1]."'");
				}
			}
		}
		private function EliminacionDeInformacionDeSorteoscancelados(){
			$consultar = $this->Comunicacion->Consultar("SELECT sorteo,loteria FROM jugadasganadoras");
			while($jugadaganadoras = $this->Comunicacion->Recorrido($consultar)){
				$sorteo = explode(" ",$jugadaganadoras[0]);
				$consultacantidad = $this->Comunicacion->Consultar("SELECT * FROM ganadores WHERE loteria='".$jugadaganadoras[1]."' AND fecha='".$sorteo[0]."' AND sorteo='".$sorteo[1]."'");
				$cantidad = $this->Comunicacion->NFilas($consultacantidad);
				if($cantidad<1){
					//return "DELETE FROM jugadaganadoras WHERE sorteo='".$jugadaganadoras[0]."' AND loteria='".$jugadaganadoras[1]."'";
					$this->Comunicacion->Consultar("DELETE FROM controlsorteo WHERE sorteo='".$jugadaganadoras[0]."' AND fecha='".$sorteo[0]."'");
					$this->Comunicacion->Consultar("DELETE FROM dineroapostado WHERE sorteo='".$jugadaganadoras[0]."' AND fecha='".$sorteo[0]."'");
					$this->Comunicacion->Consultar("DELETE FROM controldinerobanca WHERE sorteo='".$jugadaganadoras[0]."' AND fecha='".$sorteo[0]."'");
				}
			}
		}
	}
	new Actualizarsistema();
?>