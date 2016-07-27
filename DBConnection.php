<?php
    $host="localhost";
    $user="root";
    $password="";
    $db = "GlobalDB";
    $num1 = 75;
    $num2 = 25;

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

   # $rows = array();
   # while($r = $result->fetch_assoc()) {
   # $rows[] = $r;
   #  }
     
   # $locations =(json_encode($rows));
   # echo $locations;

    mysqli_close($con);
?>