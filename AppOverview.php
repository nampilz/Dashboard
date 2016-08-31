<?php
$title = $_GET["title"];

$host="localhost";
$user="root";
$password="";
$db = "GlobalDB";
$labelColor="";
$today = date("Y-m-d");
$pastNineDaysFromToday = date("Y-m-d", strtotime("-10 days"));
/* Connect to DB */
$con=mysqli_connect($host,$user,$password, $db);

/* Check DB connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

/* Get data from DB */
$sqlGetApplicationData = "SELECT DISTINCT TESTRUN_NAME, TESTED_ON, TESTER FROM TESTREPORTING WHERE TESTED_APPLICATION ='".$title."' ORDER BY TESTED_ON DESC";
$res = mysqli_query($con, $sqlGetApplicationData);

/* Get data from DB for line chart */
$sqlDataForChartPassed = "SELECT COUNT(RESULT) AS COUNTER, TESTED_ON FROM TESTREPORTING WHERE RESULT = '"."Passed"."'AND TESTED_APPLICATION = '".$title."' AND TESTED_ON BETWEEN '".$pastNineDaysFromToday."' AND '".$today."' GROUP BY TESTED_ON DESC";
$dataForChartPassed = mysqli_query($con, $sqlDataForChartPassed);

/* Get number of test cases */
$sqlCountTestCases = "SELECT COUNT(RESULT) AS COUNTER, TESTED_ON FROM TESTREPORTING WHERE TESTED_APPLICATION = '".$title."' AND TESTED_ON BETWEEN '".$pastNineDaysFromToday."' AND '".$today."' GROUP BY TESTED_ON DESC";
$countTestCases = mysqli_query($con, $sqlCountTestCases);

/* Close DB connection */
mysqli_close($con);

/* Date for the line chart (for the last past 10 days)*/
$dateRow = array(
    date("Y-m-d"),
    date("Y-m-d", strtotime("-1 days")),
    date("Y-m-d", strtotime("-2 days")),
    date("Y-m-d", strtotime("-3 days")),
    date("Y-m-d", strtotime("-4 days")),
    date("Y-m-d", strtotime("-5 days")),
    date("Y-m-d", strtotime("-6 days")),
    date("Y-m-d", strtotime("-7 days")),
    date("Y-m-d", strtotime("-8 days")),
    date("Y-m-d", strtotime("-9 days"))
);

/* Save total number of test cases of each test run in an array */
$countTestCasesArray = array();
while($row = $countTestCases->fetch_assoc()) {
    $countTestCasesArray[] = $row;
}


/*
 * Get the number of passed and failed test cases
 * Find the right date for passed and failed and add it to the arrays
*/
$numberFailed = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
$numberPassed = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0);

while($rowPassed = $dataForChartPassed->fetch_assoc()) {
    for($i = 0; $i < count($dateRow); $i++){
        if($dateRow[$i] == $rowPassed['TESTED_ON']){
            $numberPassed[$i] = $rowPassed['COUNTER'];
            for($q = 0; $q < count($countTestCasesArray); $q++){
                if($dateRow[$i] == $countTestCasesArray[$q]['TESTED_ON']){
                    $numberFailed[$i] = $countTestCasesArray[$q]['COUNTER'] - $rowPassed['COUNTER'];
                }
            }
        }
    }
}


/**
 * Function to print the report table
 */
function printReportTable()
{
    global $res;
    global $title;
    while ($row = $res->fetch_assoc()) {
        echo "<tr>";
        echo "<td>", "<a href='TestReportPage.php?testrun=".$row['TESTRUN_NAME']."&title=".$title."'>",$row['TESTRUN_NAME'],"</a>", "</td>";
        echo "<td>", $row['TESTED_ON'], "</td>";
        echo "<td>", $row['TESTER'], "</td>";
        echo "</tr>";
    }
}

/*  Switch-case to set the color of the line chart */
switch ($title) {
    case "CMP":
        $labelColor="primary";
        break;
    case "Client Portal":
        $labelColor="green";
        break;
    case "Service Bank":
        $labelColor="yellow";
        break;
    case "Tosca":
        $labelColor="red";
        break;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>QA Reporting System</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/sb-admin.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

<div id="wrapper">

    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="Overview.php">QA Reporting System</a>
        </div>

        <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
        <div class="collapse navbar-collapse navbar-ex1-collapse">
            <ul class="nav navbar-nav side-nav">
                <li>
                    <a href="Overview.php"><i class="fa fa-fw fa-dashboard"></i> Overview</a>
                </li>
                <li>
                    <a href="AppOverview.php?title=CMP"><i class="fa fa-fw fa-bar-chart-o"></i> CMP</a>
                </li>
                <li>
                    <a href="AppOverview.php?title=Client Portal"><i class="fa fa-fw fa-bar-chart-o"></i> Client Portal</a>
                </li>
                <li>
                    <a href="AppOverview.php?title=Service Bank"><i class="fa fa-fw fa-bar-chart-o"></i> Service Bank</a>
                </li>
                <li>
                    <a href="AppOverview.php?title=Tosca"><i class="fa fa-fw fa-bar-chart-o"></i> Tosca</a>
                </li>
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </nav>

    <div id="page-wrapper">

        <div class="container-fluid">

            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        <?php echo $title ?> Overview
                    </h1>
                </div>
            </div>
            <!-- /.row -->

            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-<?php echo $labelColor ?>">
                        <div class="panel-heading">
                            <h3 class="panel-title"><i class="fa fa-bar-chart-o"></i> Summary of the last 10 days </h3>
                        </div>
                        <div class="panel-body">
                            <div id="morris_line_chart"></div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->

            <div class="row">
                <div class="col-lg-12">

                    <!--Line Chart-->
                    <div id="linechart_material"></div>
                    <hr>
                </div>
                <!-- List of test runs -->
                <div class="col-lg-12">
                    <h3>Reports</h3>
                </div>
                <div class="col-lg-12">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-striped">
                            <thead>
                                <tr>
                                    <th width="90%">Testrun</th>
                                    <th width="50%">Datum</th>
                                    <th>Tester</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            printReportTable();
                            ?>
                            </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->

<!-- jQuery -->
<script src="js/jquery.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="js/bootstrap.min.js"></script>

<!-- Morris Charts JavaScript -->
<script src="js/plugins/morris/raphael.min.js"></script>
<script src="js/plugins/morris/morris.min.js"></script>
<script>
    new Morris.Line({
        // ID of the element in which to draw the chart.
        element: 'morris_line_chart',
        // Chart data records -- each entry in this array corresponds to a point on
        // the chart.

        data: [
            { datum: '<?php echo $dateRow[0] ?>', passed: <?php echo $numberPassed[0]?>, failed: <?php echo $numberFailed[0]?> },
            { datum: '<?php echo $dateRow[1] ?>', passed: <?php echo $numberPassed[1]?>, failed: <?php echo $numberFailed[1]?> },
            { datum: '<?php echo $dateRow[2] ?>', passed: <?php echo $numberPassed[2]?>, failed: <?php echo $numberFailed[2]?> },
            { datum: '<?php echo $dateRow[3] ?>', passed: <?php echo $numberPassed[3]?>, failed: <?php echo $numberFailed[3]?> },
            { datum: '<?php echo $dateRow[4] ?>', passed: <?php echo $numberPassed[4]?>, failed: <?php echo $numberFailed[4]?> },
            { datum: '<?php echo $dateRow[5] ?>', passed: <?php echo $numberPassed[5]?>, failed: <?php echo $numberFailed[5]?> },
            { datum: '<?php echo $dateRow[6] ?>', passed: <?php echo $numberPassed[6]?>, failed: <?php echo $numberFailed[6]?> },
            { datum: '<?php echo $dateRow[7] ?>', passed: <?php echo $numberPassed[7]?>, failed: <?php echo $numberFailed[7]?> },
            { datum: '<?php echo $dateRow[8] ?>', passed: <?php echo $numberPassed[8]?>, failed: <?php echo $numberFailed[8]?> },
            { datum: '<?php echo $dateRow[9] ?>', passed: <?php echo $numberPassed[9]?>, failed: <?php echo $numberFailed[9]?> },
        ],
        xkey: 'datum',
        ykeys: ['passed', 'failed'],
        xLabels: 'day',
        labels: ['Passed', 'Failed'],
        lineColors: ['#34cb34', '#ff0000'],
    });
</script>

</body>

</html>
