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

$a=30 ;
$b=60 ;

   $sql =<<<EOF

SELECT seq, id1 AS node, id2 AS edge, cost FROM pgr_dijkstra('
SELECT gid AS id,
source::integer,
target::integer,
length::double precision AS cost
FROM ways',
$a, $b, false, false);

EOF;

   $ret = pg_query($db, $sql);
   if(!$ret){
      echo pg_last_error($db);
      exit;
   } 
  echo "</br>";
$a = array();
   while($row = pg_fetch_row($ret)){
      echo "Id = ". $row[2] . "</br>\n";

//Array Works :

 $result = pg_query("select source from ways  where (gid=2346908503   ) ; ");
 $rows1 = array();
   while($r = pg_fetch_row($result)){
	        $rows1['object_name'][] = $r;
		$a[$r[0]]=$r[1];
		$a[$r[2]]=$r[3];
		echo $r[0];
//		echo $a[$r[0]];
   }


// print json_encode($rows1);


   //   echo "Id = ". $row[0] . "</br>\n";
    //  echo "Id = ". $row[1] . "</br>\n";
 // echo "<hr>";
   }

///bitch : json 



///Json Template 

echo  "
    { \"type\": \"Feature\",
      \"geometry\": {
        \"type\": \"LineString\",
        \"coordinates\": [
          ";
$age=array();

$age=$a;
foreach($age as $x=>$x_value)
  {
 echo " [". $x . ", " . $x_value ."], ";
 // echo "<br>";
  }
       
echo "] },
      \"properties\": {
        \"prop0\": \"value0\",
        \"prop1\": 0.0
        }
      },";







   echo "Operation done successfully\n";
   pg_close($db)
?>
