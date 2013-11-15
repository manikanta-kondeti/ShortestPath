<?php 

echo $_POST;
$age=$_POST;

include('id.php');

$fp = fopen('input_algo.txt','w');

foreach($age as $x=>$x_value)
  {
if($x!="GetMap")
{
  fwrite( $fp,$array_id[$x]."\n"); 
}

  }


system("gcc convert_to_given_nodes.c");
system("./a.out < input_algo.txt");
system("gcc actualcode.c");
system("./a.out < output.txt");


header('Location: http://127.0.0.1/Project/create_json.php');


fclose($fp);

?>
