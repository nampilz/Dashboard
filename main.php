<html>
<head>
    <title>PHP-Test</title>
    <h1>QA Reporting System</h1>
</head>
<body>
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

echo "<table>";
echo "<tr>";
echo "<td>","<b>","Title","</b>","</td>";
echo "<td>","<b>","Assigned To","</b>","</td>";
echo "<td>","<b>","Priority","</b>","</td>";
echo "<td>","<b>","Status","</b>","</td>";
echo "</tr>";
while($row = $result->fetch_assoc()){
    #  echo $row['TESTED_APPLICATION'].'<br />';
    #echo $row['TEST_NAME'].'<br />';
    echo "<tr>";
    echo "<td>",$row['TEST_NAME'],"</td>";
    echo "<td>",$row['TESTER'],"</td>";
    echo "<td>",$row['PRIORITY'],"</td>";
    echo "<td>",$row['RESULT'],"</td>";
    echo "</tr>";
}
echo "</table>";

?>
</body>
</html>