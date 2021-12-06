<?php session_start(); ?>
<?php include "../../includes/dao.php" ?>
<?php include "../../includes/patients/PatientsController.php";
$patients = new PatientsController();
$GetPatient = $patients->viewChildHeight($_GET['id']);
$patient = $GetPatient->fetch(PDO::FETCH_ASSOC);
?>

<div class="container">
    <?= $jumbo->getJumbo("View " . $patient['firstname'] . " " . $patient['lastname'] . "'s Growth Graph", "") ?>
    <script>
        window.onload = function() {

            var chart = new CanvasJS.Chart("chartContainer", {
                animationEnabled: true,
                title: {
                    text: "Growth Graph"
                },
                axisX: {
                    title: "Weight (in pounds)",
                    crosshair: {
                        valueFormatString: "##0.00p",
                        enabled: true,
                        snapToDataPoint: true
                    }
                },
                axisY: {
                    title: "Height (in Centimeters)",
                    includeZero: false,
                    valueFormatString: "##0.00cm",
                    crosshair: {
                        enabled: true,
                        snapToDataPoint: true,
                        labelFormatter: function(e) {
                            return "$" + CanvasJS.formatNumber(e.value, "##0.00p");
                        }
                    }
                },

                data: [{
                    type: "area",
                    yValueFormatString: "##0.00pounds",
                    dataPoints: [
                        <?php while ($row = $GetPatient->fetch(PDO::FETCH_ASSOC)) { ?> {
                                y: <?= $row['height'] ?>,
                                x: <?= $row['weight'] ?>,
                            },

                        <?php } ?>
                    ]
                }]
            });
            chart.render();

        }
    </script>
    </head>

    <body>
        <div id="chartContainer" style="height: 370px; max-width: 920px; margin: 0px auto;"></div>

        <?php include "../../includes/footer.php"; ?>