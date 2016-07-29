<?php
/**
 * Created by IntelliJ IDEA.
 * User: Nam
 * Date: 29/07/16
 * Time: 12:42
 */
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

$sql = "SELECT * FROM TESTREPORTING WHERE `TESTED_APPLICATION` = \"CMP\"";
$result = mysqli_query($con, $sql);

function printTable(){
    global $result;
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>",$row['TEST_NAME'],"</td>";
        echo "<td>",$row['TESTER'],"</td>";
        echo "<td>",$row['PRIORITY'],"</td>";
        echo "<td>",$row['RESULT'],"</td>";
        echo "</tr>";
    }
}
echo "<table>";
printTable();
echo "</table>";