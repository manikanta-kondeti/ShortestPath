<?php
echo "hii bitch ";
   $host        = "host=127.0.0.1";
   $port        = "port=5432";
   $dbname      = "dbname=mani";
   $credentials = "user=postgres password=manikanta";

   $db = pg_connect( "$host $port $dbname $credentials"  );
   if(!$db){
      echo "Error : Unable to open database\n";
   } else {
      echo "Opened database successfully\n";
   }

   $sql =<<<EOF



EOF;

   $ret = pg_query($db, $sql);
   if(!$ret){
      echo pg_last_error($db);
      exit;
   } 
   while($row = pg_fetch_row($ret)){
      echo "lon = ". $row[0] ;
      echo " lat = ". $row[1] ;
      echo " id = ". $row[2] ;
	echo "\n";
   }

///bitch : json 


   echo "Operation done successfully\n";
   pg_close($db)
?>
