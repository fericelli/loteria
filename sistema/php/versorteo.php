<?php
	Class Versorteo{
		private $Comunicacion;
		function Versorteo(){
			include("../../php/conexion.php");
			$this->Comunicacion = new Conexion();
			echo $this->Retorno();
		}
		private function Retorno(){
			$r='<div style="display:none"class="boton existesorteo">Sorteo Existenten</div>
			<div style="display:none"class="boton sorteocreado">Sorteo Creado</div>
			'.$this->Loterias().'
			<div style="display:flex; flex-direction:row">
				<div class="mensaje-input horasorteo"><div class="flecha-mensaje-input"></div><p>Ingrese Una Hora</p></div>
				<label>Hora</label>
				<input id="hora" type="time" id="hora">
			</div>
				<div id="agregarsorteo" class="boton">Agregar</div>';
			return $r;
		}
		private function Loterias(){
			$r="<div>
			<div class='mensaje-input sleclote'><div class='flecha-mensaje-input'></div><p>Seleccione Una Loteria</p></div>
			<select id='loteriassorteo'>
			<option id='todos' selected>Seleccione Un Sorteo</option>";
			$consulta = $this->Comunicacion->Consultar("SELECT loteria FROM loterias WHERE bloqueo<>'si'");
			while($row = $this->Comunicacion->Recorrido($consulta)){
				$r=$r."<option id='".$row[0]."'>".$row[0]."</option>";
			}
			return $r=$r."</select></div>";
		}
	}
	new Versorteo();
?>