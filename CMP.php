<?php include ("DBConnection.php"); ?>
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

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {'packages':['line']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {

            var data = new google.visualization.DataTable();
            data.addColumn('number', 'Day');
            data.addColumn('number', 'Passed');
            data.addColumn('number', 'Failed');


            data.addRows([
                [1, 4, 0],
                [2, 3, 1],
                [3, 3, 1],
                [4, 4, 0],
                [5, 2, 2],
                [6, 4, 0]
            ]);

            var options = {
                chart: {
                    title: 'CMP'
                },
                width: 1000,
                height: 300
            };

            var chart = new google.charts.Line(document.getElementById('linechart_material'));

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
                    <a href="ReportPage.php"><i class="fa fa-fw fa-bar-chart-o"></i> Reports</a>
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
                        CMP Overview
                    </h1>
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
                            <tr>
                                <td width="90%"><h5>Name</h5></td>
                                <td width="50%"><h5>Datum</h5></td>
                                <td><h5>Tester</h5></td>
                            </tr>
                            <tr>
                                <td><a href="TestReportPage.php">CMP Sprint 1</a></td>
                                <td>27.08.2016</td>
                                <td>Tester</td>
                            </tr>
                            <tr>
                                <td><a href="TestReportPage.php">CMP Sprint 2</a></td>
                                <td>28.08.2016</td>
                                <td>Tester</td>
                            </tr>
                            <tr>
                                <td><a href="TestReportPage.php">CMP Sprint 3</a></td>
                                <td>29.08.2016</td>
                                <td>Tester</td>
                            </tr>
                            <tr>
                                <td><a href="TestReportPage.php">CMP Sprint 4</a></td>
                                <td>30.08.2016</td>
                                <td>Tester</td>
                            </tr>
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

</body>

</html>
