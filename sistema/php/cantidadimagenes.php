<?php
	Class Cantidadimagenes{
		function Cantidadimagenes(){
			if(isset($_POST["cantidad"])){
				if($_POST["cantidad"]==""){
					echo "";
				}else{
					echo $this->Input();
				}
			}
		}
		private function Input(){
			$r="";
			$contador=1;
			while($contador<=$_POST["cantidad"]){
				$r=$r."<input type='text' placeholder='Nombre Jugada'><input type='file'>";
				$contador++;
			}
			return $r;
		}
	}
	new Cantidadimagenes();
?>