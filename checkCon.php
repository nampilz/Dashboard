<?php
$host="localhost";
$user="root";
$password="";
$db = "GlobalDB";

$con=mysqli_connect($host,$user,$password, $db);
if($con) {
  #echo 'Connected to MySQL'.'<br />';
} else {
   echo '<h1>MySQL Server is not connected</h1>';
}

/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

$sql = "SELECT * FROM TESTREPORTING";
$result = mysqli_query($con, $sql);


while($row = $result->fetch_assoc())
      #  echo $row['TESTED_APPLICATION'].'<br />';
   		echo $row['TEST_NAME'].'<br />';
?>