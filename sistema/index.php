<?php

	Class Index{
		Private $Comunicacion;
		function Index(){
			include ("../php/conexion.php");
			$this->Comunicacion = new Conexion();
			echo $this->Interfaz();
			
		}
		private function Interfaz(){
			return '<!DOCTYPE html>
					<html>
					<head>
						<title>Control Sistema</title>
						<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
						<meta name="viewport" contents="width=device.width, user-scalable=no, initial.scale=1, maximum.scale=1" />
						<meta http-equiv="Last-Modified" content="0">
						<link rel="stylesheet" href="css/estilos.css">
					</head>
					<body>
						'.$this->IniciarSesion().'	
					</body>
					<script type="text/javascript" src="js/jquery-1.11.3.min.js"></script>
					<script type="text/javascript" src="js/jquery.nicescroll.js"></script>
					<script type="text/javascript" src="js/jquery.PrintArea.js"></script>
					<script type="text/javascript" src="js/script.js"></script>
				</html>
			';
		}
		 
		private function IniciarSesion(){
			$retornohtml = '<div class="contenedor-principal">
					'.$this->Formulario().'
				</div>';
			return $retornohtml;
		}
		private function Formulario(){
			$retornohtml = "<div class='formulario'>
				<h2>".$this->Comunicacion->Traductor("iniciar sesion")."</h2>
				<div>
					<div class='mensaje-input usuario'><div class='flecha-mensaje-input'></div><p>".$this->Comunicacion->Traductor("ingrese el nombre de usuario")."</p></div>
					<div class='mensaje-input noregistrado'><div class='flecha-mensaje-input'></div><p>".$this->Comunicacion->Traductor("usuario no registrado")."</p></div>
					<div class='mensaje-input usuariobloqueado'><div class='flecha-mensaje-input'></div><p>Usuario Bloqueado</p></div>
					<input id='usuario' type='text' placeholder='".$this->Comunicacion->Traductor("usuario")."'>
				</div>
				<div>
					<div class='mensaje-input contraseña'><div class='flecha-mensaje-input'></div><p>".$this->Comunicacion->Traductor("ingrese la contraseña")."</p></div>
					<div class='mensaje-input contraseñaincorrecta'><div class='flecha-mensaje-input'></div><p>".$this->Comunicacion->Traductor("contraseña incorecta")."</p></div>
					<input id='contraseña' type='password' placeholder='".$this->Comunicacion->Traductor("contraseña")."'>
				</div>
				<div class='botones'>
					<div id='ingresar' class='boton'>".$this->Comunicacion->Traductor("ingresar")."</div>
					<div class='boton'>".$this->Comunicacion->Traductor("cancelar")."</div>
				</div>
			</div>";
			return $retornohtml;
		}
		
		
	}
	$Index = new Index();
?>
