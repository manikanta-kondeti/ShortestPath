<?php 

header('Location: http://127.0.0.1/Project/working.php');
//Database Details 

   $host        = "host=127.0.0.1";
   $port        = "port=5432";
   $dbname      = "dbname=mani";
   $credentials = "user=postgres password=manikanta";
   $db = pg_connect( "$host $port $dbname $credentials" );
   if(!$db){
      echo "Error : Unable to open database\n";
   } else {
      echo "Opened database successfully\n";
   }


//including output path file 
//: format :  $arr1[]   , $arr2[]  , $count 

include('out.php');

///  Run query ::


//Take json file :
$fp_json = fopen('new.json','w');

$i=0 ;


fwrite($fp_json,"{\"type\":\"FeatureCollection\",\"features\":[{\"type\":\"Feature\",\"id\":\"HyderabadRoadMap\",  \"style\":{
      \"fill\":\"#FF0000\",
      \"stroke-width\":\"8\",
      \"stroke\":\"black\",
      \"fill-opacity\":0.6
  } , \"properties\":{\"fips\":\"30\",\"name\":\"Montana\"},\"geometry\":{\"type\":\"MultiLineString\",\"coordinates\":[");



for($i=0; $i<$count ; $i++ )
{
     //Run Query 
   // Dikstra Algorithm starts here 
     $sql =<<<EOF

SELECT seq, id1 AS node, id2 AS edge, cost FROM pgr_dijkstra('
SELECT gid AS id,
source::integer,
target::integer,
length::double precision AS cost
FROM ways',
$arr1[$i], $arr2[$i],  false, false);

EOF;


 $ret = pg_query($db, $sql);
   if(!$ret){
      echo pg_last_error($db);
      exit;
   }


	// Query ends here 

      //Now we need to get x1,y1,x2,y2 of specific gid 

$a = array();
$length_points=0;

while($row = pg_fetch_row($ret))
{

//Testing
echo $row[2]."\n";
//Done 

$result = pg_query("select x1,y1,x2,y2 from ways  where (gid=$row[2] ) ; ");
 while($r = pg_fetch_row($result)){
               // $a[$r[0]]=$r[1];
               // $a[$r[2]]=$r[3];
                $a[$length_points++]=$r[0];
                $a[$length_points++]=$r[1];
                $a[$length_points++]=$r[2];
                $a[$length_points++]=$r[3];


//Testing 
echo "hii";
echo $a[$r[0]];
//Done

}



}
	//Ends here  while (ret ) i.e ... fetching each gid and there x1,y1,x2,y2 .


//Write it into json 

fwrite($fp_json,'[');

$a1=array();
$a1=$a;
$flag=0;
$length=count($a1);
//foreach($a1 as $x=>$x_value)
for($j=0;$j<$length_points;$j=$j+2)
  {
 $flag=$flag+1;
if($flag!=$length)
{
 fwrite($fp_json , " [".$a[ $j ].",". $a[$j+1]."],");
}
else 
{
 fwrite($fp_json , " [".$a[ $j ].",". $a[$j+1]."]");
}



  }

if($i!=$count-1)
{
fwrite($fp_json," ] , \n");
//End it here  writing into json.
}
else 
{
fwrite($fp_json," ]  \n");
//End it here  writing into json.
}



}
//OutofForLoop

//Ending with brackets :
fwrite($fp_json,'] } } ] }');



fclose($fp_json);

?>
