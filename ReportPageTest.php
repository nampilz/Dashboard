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
       <!-- AJAX API laden -->
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
        // Visualization-API mit dem Paket 'corechart' laden.
        google.load('visualization', '1.0', {'packages':['corechart']});
        
        // Die Funktion drawVisualization wird aufgerufen wenn die API funktionsbereit ist
        google.setOnLoadCallback(drawVisualization);
        
        var a = <?php echo $num1; ?>; // Daten aus php in Variable speichern
        var b = <?php echo $num2; ?>; 
        function drawVisualization() {
    
        // In der Variable options wird ein assoziatives Array mit den Einstellungen gespeichert.
        var options = {'title':'',
                        is3D: true,
                        colors: ['#33cc33', '#ff3300', '#CCCCCC', '#e6e600'],
                        chartArea:{left:20,top:20,width:'100%',height:'80%'}};
        
        // In der Variable data werden die Daten als DataTable gespeichert
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Result');
        data.addColumn('number', 'Anteil (in %)');
        data.addRows([
          ['Passed'     , a],
          ['Failed', b],
          ['Untested'  , 0.0],
          ['Retested' , 0.0],
        ]);

        // Erstellen und Zeichnen des Diagramms
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
                            Test Summary
                        </h1>
                    </div>
                </div>
                <!-- /.row -->


                <div class="row">                
                    <div class="col-lg-6">
                        <form role="form">
                            <div class="form-group">
                                <label for="disabledSelect">Tested Application
                                <select id="disabledSelect" class="form-control">
                                    <option>Client Portal</option>
                                    <option>CMP</option>
                                    <option>ServiceBank</option>
                                </select>
                                </label>
                            </div>
                        </form>

                        <!--Pie Chart-->
                        <div id="result-pie-chart" style="width: 700; height: 400px";></div>

                        <!-- Table -->
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th>Testname</th>
                                        <th>Tester</th>
                                        <th>Priority</th>
                                        <th>Result</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="success">
                                        <td>Scenario: Search for an active employee</td>
                                        <td>Selenium</td>
                                        <td>High</td>
                                        <td>Passed</td>
                                    </tr>
                                    <tr class="success">
                                        <td>Scenario: Create new Roadshow</td>
                                        <td>Selenium</td>
                                        <td>High</td>
                                        <td>Passed</td>
                                    </tr>
                                    <tr class="success">
                                        <td>Scenario: Search for a team</td>
                                        <td>Selenium</td>
                                        <td>High</td>
                                        <td>Passed</td>
                                    </tr>
                                    <tr class="danger">
                                        <td>Scenario: Click all links</td>
                                        <td>Selenium</td>
                                        <td>High</td>
                                        <td>Failed</td>
                                    </tr>
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
