
<?php
$host="localhost";
$user="root";
$password="";
$db = "GlobalDB";
$passedCount = 0;
$failedCount = 0;
$testrunName = $_GET["testrun"];
$title = $_GET["title"];

/* Connect to db */
$con=mysqli_connect($host,$user,$password, $db);

/* Check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

$sql = "SELECT * FROM TESTREPORTING WHERE TESTED_APPLICATION ='".$title."'"." AND TESTRUN_NAME = '".$testrunName."' ORDER BY FEATURE";
$result = mysqli_query($con, $sql);
$result2 = mysqli_query($con, $sql);

/* Close connection */
mysqli_close($con);


/* Count the total number of passed and failed test cases for the pie chart*/
while($row = $result->fetch_assoc()) {
    if ($row['RESULT'] == 'Passed') {
        $passedCount = $passedCount + 1;
    } else {
        $failedCount = $failedCount + 1;
    }
}

/**
 * This function prints a table with all the test cases of the test run
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
        echo "<td>",$row['FEATURE'],"</td>";
        echo "<td>",$row['ELAPSED']/100,"s","</td>";
        echo "<td>",$row['PRIORITY'],"</td>";
        echo "<td>",$row['RESULT'],"</td>";
        echo "</tr>";
    }
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
       <!-- AJAX API laden -->
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
        // Visualization-API mit dem Paket 'corechart' laden.
        google.load('visualization', '1.0', {'packages':['corechart']});
        
        // The function drawVisualization is called when the API is ready
        google.setOnLoadCallback(drawVisualization);

        var passedTotal = 0;
        var failedTotal = 0;
        passedTotal = <?php echo $passedCount ?>; // Save data from php in variables
        failedTotal = <?php echo $failedCount ?>;

        function drawVisualization() {

        // The variable options saved an array with the configurations
        var options = {'title':'',
                        is3D: true,
                        colors: ['#33cc33', '#ff3300', '#CCCCCC', '#e6e600'],
                        chartArea:{left:20,top:20,width:'50%',height:'80%'}};

        // The variable data saved the data as a DataTable
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Result');
        data.addColumn('number', 'Anteil (in %)');
        data.addRows([
          [passedTotal + ' Passed', passedTotal],
          [failedTotal + ' Failed', failedTotal],
          ['Untested'  , 0.0],
          ['Retested' , 0.0],
        ]);

        // Create and draw the diagram
        var chart = new google.visualization.PieChart(document.getElementById('result-pie-chart'));
        chart.draw(data, options);
        }
    </script>

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
                            Test Report
                        </h1>
                        <h3>
                            <?php echo $testrunName ?>
                        </h3>
                    </div>
                </div>
                <!-- /.row -->


                <div class="row">
                    <div class="col-lg-12">

                        <!--Pie Chart-->
                        <div id="result-pie-chart" style="width: 700; height: 400px";></div>

                        <!-- Table -->
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th>Testname</th>
                                        <th>Feature</th>
                                        <th>Elapsed</th>
                                        <th>Priority</th>
                                        <th>Result</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        printTable();
                                    ?>
                                </tbody>
                            </table>
                        </div>
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

</body>

</html>
