<?php
    $host="localhost";
    $user="root";
    $password="";
    $db = "GlobalDB";
    $passedCount = 0;
    $failedCount = 0;

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
    $result2 = mysqli_query($con, $sql);
   # $rows = array();
   # while($r = $result->fetch_assoc()) {
   # $rows[] = $r;
   #  }
     
   # $locations =(json_encode($rows));
   # echo $locations;

    while($row = $result->fetch_assoc()) {
        if ($row['RESULT'] == 'Passed') {
            $passedCount = $passedCount + 1;
        } else {
            $failedCount = $failedCount + 1;
        }
    }

    mysqli_close($con);

/**
 *
 */
function printTable(){
    global $result2;
    while($row = $result2->fetch_assoc()) {
        $classAttribute = 'danger';
        if ($row['RESULT'] == 'Passed') {
            $classAttribute = 'success';
        }
        echo "<tr class='$classAttribute'>";
        echo "<td>",$row['TEST_NAME'],"</td>";
        echo "<td>",$row['TESTER'],"</td>";
        echo "<td>",$row['PRIORITY'],"</td>";
        echo "<td>",$row['RESULT'],"</td>";
        echo "</tr>";
    }
}
