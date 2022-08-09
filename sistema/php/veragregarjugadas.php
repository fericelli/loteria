<?php
	Class Veragregarjugadas{
		private $Comunicacion;
		function Veragregarjugadas(){
			include("../../php/conexion.php");
			$this->Comunicacion = new Conexion();
			echo $this->Ver(); 
		}
		private function Ver(){
			$r="<div style='display:none' class='mensajeagregarloteria boton'>Jugada Agregada</div>
			<div style='display:none' class='mensjeerror boton'>Intente De Nuevo</div>
			<div>
			<div class='mensaje-input seleccionloteria'><div class='flecha-mensaje-input'></div><p>Seleccione Una Loteria</p></div>
			<select id='loteriass' style='width:100%'><option id='todos'>Seleccciones Una Loteria</option>";
			$consulta = $this->Comunicacion->Consultar("SELECT loteria FROM loterias WHERE bloqueo<>'si' ORDER BY loteria ASC");
			while($loterias = $this->Comunicacion->Recorrido($consulta)){
				$r=$r."<option id='".$loterias[0]."'>".$loterias[0]."</option>";
			}
			$r=$r."</select></div>
			<div>
				<div class='mensaje-input selecciontipojugada'><div class='flecha-mensaje-input'></div><p>Seleccione El Tipo Jugada</p></div>
				<select id='tipojugada' style='width:100%'>
					<option id='todos'>Seleccciones El Tipo De Jugada</option>
					<option id='normal'>Jugada Normal</option>
					<option id='especial'>Jugada Especial</option>
				</select>
			</div>
			<div>
				<div class='mensaje-input ingresejugada'><div class='flecha-mensaje-input'></div><p>Ingrese El Nombre De La Jugada</p></div>
				<div class='mensaje-input jugadaexiste'><div class='flecha-mensaje-input'></div><p>Jugada Existente</p></div>
				<input type='text' id='nombrejugada' placeholder='Nombre Jugada'>
			</div>
			<div>
				<div class='mensaje-input ingresecodigo'><div class='flecha-mensaje-input'></div><p>Ingrese El Código De La Jugada</p></div>
				<div class='mensaje-input codigoexiste'><div class='flecha-mensaje-input'></div><p>Codigo Existente</p></div>
				<div class='mensaje-input codigojugadanumero'><div class='flecha-mensaje-input'></div><p>Ingrese Valor Numérico</p></div>
				<input type='text' id='codigojugada' placeholder='Codigo Jugada'>
			</div>
			<div>
				<div class='mensaje-input seleccionimagen'><div class='flecha-mensaje-input'></div><p>Seleccione Una Imagen</p></div>
				<input name='foto-registro' id='foto-registro' type='file'>
			</div>
			<div style='tex-aling:center' id='agregarjugada' class='boton'>Agregar</div>";
			return $r;
		}
	}
	new Veragregarjugadas();
?>