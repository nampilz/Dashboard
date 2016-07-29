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

function countResult(){
    global $result;
    global $passedCount;
    global $failedCount;
    while($row = $result->fetch_assoc()) {
       # echo $row['TEST_NAME'] . '<br />';
        if ($row['RESULT'] == 'Passed') {
            $passedCount = $passedCount + 1;
        } else {
            $failedCount = $failedCount + 1;
        }
    }
    echo $passedCount.'<br />';
    echo $failedCount;
}
countResult();

function printTable(){
    global $result2;
    while($row = $result2->fetch_assoc()) {
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

echo "TEST";
