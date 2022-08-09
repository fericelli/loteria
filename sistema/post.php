<?php
	Class Post{
		function Post(){
			
 $port_name = '/dev/ttyS0';
 $port_attr = array('baud' => 1200, 'bits' => 7, 'stop' => 2, 'parity' =>2);

 $protek = dio_open($port_name, O_RDWR | O_NOCTTY | O_NONBLOCK);
 dio_fcntl($protek, F_SETFL, O_SYNC);
 dio_tcsetattr($protek, $port_attr);

 $i = 0;
 do {
  dio_write($protek, ' ');
  while (($char = dio_read($protek)) != chr(13)) {
   echo $char;
  }
  echo "\n";
  sleep(1);
 } while (++$i < 10);
 dio_close($protek);
		}
		
	}
	new Post();
?>