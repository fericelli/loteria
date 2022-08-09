<?php 
	class Conexion{
		private $Servidor;
		private $UsuarioDeMysql;
		private $ClaveDeMysql;
		private $BaseDeDatos;
		private $Conectar;
		
		function Conexion(){
			$this->Conexiones("localhost","u956446715_lotomiranda","Apuesta2324**","u956446715_loto");
		}
		function Conexiones($S,$U,$C,$B){
			$this->Servidor = $S;
			$this->UsuarioDeMysql = $U;
			$this->ClaveDeMysql = $C;
			$this->BaseDeDatos = $B;
			$this->ConectarAMysql();
		}
		
		private function ConectarAMysql(){
			$this->Conectar =  new mysqli($this->Servidor, 
			$this->UsuarioDeMysql,
			$this->ClaveDeMysql,$this->BaseDeDatos);
			mysqli_set_charset($this->Conectar,"utf8");
			
            date_default_timezone_set('America/Santiago');
		}
		
		public function Consultar($sql){
			$resultado = mysqli_query($this->Conectar,$sql);
			return $resultado;
		}
		public function NFilas($sql){
			return mysqli_num_rows($sql);
		}
		public function NColumnas($sql){
			return mysqli_num_fields($sql);
		}
		public function NomCampo($sql,$numerodelcampo){
			return mysqli_field_name($sql,$numerodelcampo);
		}
		public function Recorrido($consulta){
			return mysqli_fetch_array($consulta);
		}
		public function Traductor($frase){
			$sqlregistros = "SELECT DISTINCT frase FROM traductor";
			$consucontar = $this->Consultar($sqlregistros);
			$numero = $this->NFilas($consucontar);
			$contaridioma = "SELECT traduccion FROM traductor";
			$consustacontaridiomas = $this->Consultar($contaridioma);
			$numeroidioma = $this->NFilas($consustacontaridiomas);
			$numero." ".$numeroidioma;
			if($numero == $numeroidioma){
				$sql = "SELECT traduccion FROM traductor WHERE frase='".$frase."'";
				$consultar = $this->Consultar($sql);
				if($row = $this->Recorrido($consultar)){
					return $row["traduccion"];
				}else{
					return "no registrado";
				}
			}else{
				return "no se puede";
			}
		}
	}
?>