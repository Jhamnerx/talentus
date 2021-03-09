<?php

send_message('51.79.48.161','9999','<TEST1234;T5H-942;356895037534289;20170221 14:48:50;-5.771183;-78.785336;25.5;120;1;0;1;0;0;POSEIDON SAC>');

function send_message($ipServer,$portServer,$message)
{
  $fp = stream_socket_client("tcp://$ipServer:$portServer", $errno, $errstr);
  if (!$fp)
  {
     echo "ERREUR : $errno - $errstr<br />\n";
  }
  else
  {
     fwrite($fp,"$message\n");
     $response =  fread($fp, 4);
     if ($response != "OK\n")
        {echo 'The command couldn\'t be executed...\ncause :'.$response;}
     else
        {echo 'Execution successfull...';}
     fclose($fp);
  }
}
?>