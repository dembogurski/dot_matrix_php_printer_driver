<?php


/**
@autor: Doglas Antonio Dembogurski Feix
copyright (c) 2010
*/

//Define printer name for Windows, Linux not needed
$printer_name = 'TM-U220';

$content = $_REQUEST['content'];
$URL = 'localhost';  // Change IP to redirecto to other Computer that have printer

/*
Call this program from other computer to print tickets  
Call Format:  

http://this_computer_ip/ticket.php?content=sometexttoprint

*/



echo nl2br($content);
echo '<form name="ticket" action="http://'.$URL .'/ticket.php" method="POST">
      <input type="hidden" name="content" value="'.$content.'" >
    
      <input type="submit" value="Re imprimir">
      </form> ';
if($URL == 'localhost'){
	if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {  // For Windows
		$printer = printer_open($printer_name);
		if($printer){	
			printer_set_option($printer,PRINTER_MODE,"RAW");
			printer_write($printer, "$content"."\n\n\n\n\n\n\x1B@\x1DV1");
			printer_close($printer);
		}
	}else{  // For Linux
		/**
		 * Define Printer Port
		 */
		$PRINTER_PORT = "/dev/lp0";
		$content = $_REQUEST['content'];
		shell_exec('echo "'.$content.'" > '.$PRINTER_PORT);
		file_put_contents($PRINTER_PORT,  "\x1d"."V\x41".chr(3));  // Corta el papel 
	}
}else{ // Redirect if no localhost
	echo '  <script> document.ticket.submit(); </script> ';
}

?>
