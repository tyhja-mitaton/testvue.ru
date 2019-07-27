<?php 
try 
{
    /*** connect to SQLite database ***/

    $mydb = new PDO("sqlite:task_tz.db");
    $req_body = file_get_contents("php://input");
	$r_data = json_decode($req_body);
	$query = "SELECT * FROM user WHERE email LIKE '".$r_data->email."%';";
	$query2 = "SELECT * FROM user_info WHERE user_id = ";
	
	$r = $mydb->query($query);
	if($r !== false){
		$resp = array();
		$ar = $r->fetchAll();
			foreach($ar as $key => $row){
				$f_id = json_encode($ar[$key]['id']);
				$r2 = $mydb->query($query2.$f_id.";");
				$ar2 = $r2->fetch();
				$ar2[0] = $ar[$key]['email'];
				array_push($resp, $ar2);
			}
		echo json_encode($resp);
	}else{
		echo 'The SQL query failed with error '.$mydb->errorCode;
	}

}
catch(PDOException $e)
{
    echo $e->getMessage();
    echo "<br><br>Database -- NOT -- loaded successfully .. ";
    die( "<br><br>Query Closed !!! $error");
}
//$mydb = sqlite_open('task_tz');

