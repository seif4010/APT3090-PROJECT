<?php session_start(); ?>
<?php include "../../includes/dao.php" ?>
<?php include "../../includes/patients/PatientsController.php";
$patients = new PatientsController();
$GetPatient = $patients->viewChildHeight($_GET['id']);
$patient = $GetPatient->fetch(PDO::FETCH_ASSOC);

?>
<div class="container">
    <?= $jumbo->getJumbo("" . $patient['firstname'] . " " . $patient['lastname'] . "'s Percetiles", "") ?>

    <script>
        window.onload = function() {

            var chart = new CanvasJS.Chart("chartContainer", {
                title: {
                    text: "Percetiles (0-10 Years)"
                },
                axisX: {
                    title: "",
                    suffix: "lb"
                },
                axisY2: {
                    title: "Weight (KG)",
                    suffix: "Kg"
                },
                toolTip: {
                    shared: true
                },
                legend: {
                    cursor: "pointer",
                    verticalAlign: "top",
                    horizontalAlign: "center",
                    itemclick: toogleDataSeries
                },
                data: [{
                        type: "line",
                        axisYType: "secondary",
                        name: "P3",
                        showInLegend: true,
                        markerSize: 0,
                        dataPoints: [{
                                x: 0.5,
                                y: 2.799548641
                            },
                            {
                                x: 1.0,
                                y: 3.614688072
                            },
                            {
                                x: 1.5,
                                y: 4.34234145
                            },
                            {
                                x: 2.0,
                                y: 4.992897896
                            },
                            {
                                x: 2.5,
                                y: 5.575169066
                            },
                            {
                                x: 3.0,
                                y: 6.096775274
                            },
                            {
                                x: 3.5,
                                y: 6.564430346
                            },
                            {
                                x: 4.0,
                                y: 6.984123338
                            },
                            {
                                x: 4.5,
                                y: 7.361236116
                            },
                            {
                                x: 5.0,
                                y: 7.700624405
                            }
                        ]
                    },
                    {
                        type: "line",
                        axisYType: "secondary",
                        name: "P5",
                        showInLegend: true,
                        markerSize: 0,
                        dataPoints: [{
                                x: 0.5,
                                y: 2.964655655
                            },
                            {
                                x: 1.0,
                                y: 3.774848862
                            },
                            {
                                x: 1.5,
                                y: 4.503255345
                            },
                            {
                                x: 2.0,
                                y: 5.157411653
                            },
                            {
                                x: 2.5,
                                y: 5.744751566
                            },
                            {
                                x: 3.0,
                                y: 6.272175299
                            },
                            {
                                x: 3.5,
                                y: 6.745992665
                            },
                            {
                                x: 4.0,
                                y: 7.171952393
                            },
                            {
                                x: 4.5,
                                y: 7.555286752
                            },
                            {
                                x: 5.0,
                                y: 7.90075516
                            }
                        ]
                    },
                    {
                        type: "line",
                        axisYType: "secondary",
                        name: "Measure",
                        showInLegend: true,
                        markerSize: 0,
                        dataPoints: [
                            <?php while ($row = $GetPatient->fetch(PDO::FETCH_ASSOC)) { ?> {
                                    y: <?= $row['height'] ?>,
                                    x: <?= $row['weight'] ?>,
                                },

                            <?php } ?>
                        ]
                    },
                    {
                        type: "line",
                        axisYType: "secondary",
                        name: "P10",
                        showInLegend: true,
                        markerSize: 0,
                        dataPoints: [{
                                x: 0.5,
                                y: 3.209510017
                            },
                            {
                                x: 1.0,
                                y: 4.020561446
                            },
                            {
                                x: 1.5,
                                y: 4.754479354
                            },
                            {
                                x: 2.0,
                                y: 5.416802856
                            },
                            {
                                x: 2.5,
                                y: 6.01371624
                            },
                            {
                                x: 3.0,
                                y: 6.551379244
                            },
                            {
                                x: 3.5,
                                y: 7.035656404
                            },
                            {
                                x: 4.0,
                                y: 7.472021438
                            },
                            {
                                x: 4.5,
                                y: 7.865532922
                            },
                            {
                                x: 5.0,
                                y: 8.220839211
                            }
                        ]
                    },
                    {
                        type: "line",
                        axisYType: "secondary",
                        name: "P25",
                        showInLegend: true,
                        markerSize: 0,
                        dataPoints: [{
                                x: 0.5,
                                y: 3.597395573
                            },
                            {
                                x: 1.0,
                                y: 4.428872952
                            },
                            {
                                x: 1.5,
                                y: 5.183377547
                            },
                            {
                                x: 2.0,
                                y: 5.866806254
                            },
                            {
                                x: 2.5,
                                y: 6.484969167
                            },
                            {
                                x: 3.0,
                                y: 7.043626918
                            },
                            {
                                x: 3.5,
                                y: 7.548345716
                            },
                            {
                                x: 4.0,
                                y: 8.004398775
                            },
                            {
                                x: 4.5,
                                y: 8.416718775
                            },
                            {
                                x: 5.0,
                                y: 8.789881892
                            }

                        ]
                    }
                ]
            });
            chart.render();

            function toogleDataSeries(e) {
                if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
                    e.dataSeries.visible = false;
                } else {
                    e.dataSeries.visible = true;
                }
                chart.render();
            }

        }
    </script>
    </head>

    <body>
        <div id="chartContainer" style="height: 370px; max-width: 920px; margin: 0px auto;"></div>
        <?php include "../../includes/footer.php"; ?>
    </body><?php session_start(); ?>
    <?php include "../../includes/dao.php" ?>
    <?php include "../../includes/patients/PatientsController.php";
    $patients = new PatientsController();
    $GetPatient = $patients->viewChildHeight($_GET['id']);
    $patient = $GetPatient->fetch(PDO::FETCH_ASSOC);

    ?>
    <div class="container">
        <?= $jumbo->getJumbo("" . $patient['firstname'] . " " . $patient['lastname'] . "'s Percetiles", "") ?>

        <script>
            window.onload = function() {

                var chart = new CanvasJS.Chart("chartContainer", {
                    title: {
                        text: "Percetiles (0-10 Years)"
                    },
                    axisX: {
                        title: "",
                        suffix: "lb"
                    },
                    axisY2: {
                        title: "Weight (KG)",
                        suffix: "Kg"
                    },
                    toolTip: {
                        shared: true
                    },
                    legend: {
                        cursor: "pointer",
                        verticalAlign: "top",
                        horizontalAlign: "center",
                        itemclick: toogleDataSeries
                    },
                    data: [{
                            type: "line",
                            axisYType: "secondary",
                            name: "P3",
                            showInLegend: true,
                            markerSize: 0,
                            dataPoints: [{
                                    x: 0.5,
                                    y: 2.799548641
                                },
                                {
                                    x: 1.0,
                                    y: 3.614688072
                                },
                                {
                                    x: 1.5,
                                    y: 4.34234145
                                },
                                {
                                    x: 2.0,
                                    y: 4.992897896
                                },
                                {
                                    x: 2.5,
                                    y: 5.575169066
                                },
                                {
                                    x: 3.0,
                                    y: 6.096775274
                                },
                                {
                                    x: 3.5,
                                    y: 6.564430346
                                },
                                {
                                    x: 4.0,
                                    y: 6.984123338
                                },
                                {
                                    x: 4.5,
                                    y: 7.361236116
                                },
                                {
                                    x: 5.0,
                                    y: 7.700624405
                                }
                            ]
                        },
                        {
                            type: "line",
                            axisYType: "secondary",
                            name: "P5",
                            showInLegend: true,
                            markerSize: 0,
                            dataPoints: [{
                                    x: 0.5,
                                    y: 2.964655655
                                },
                                {
                                    x: 1.0,
                                    y: 3.774848862
                                },
                                {
                                    x: 1.5,
                                    y: 4.503255345
                                },
                                {
                                    x: 2.0,
                                    y: 5.157411653
                                },
                                {
                                    x: 2.5,
                                    y: 5.744751566
                                },
                                {
                                    x: 3.0,
                                    y: 6.272175299
                                },
                                {
                                    x: 3.5,
                                    y: 6.745992665
                                },
                                {
                                    x: 4.0,
                                    y: 7.171952393
                                },
                                {
                                    x: 4.5,
                                    y: 7.555286752
                                },
                                {
                                    x: 5.0,
                                    y: 7.90075516
                                }
                            ]
                        },
                        {
                            type: "line",
                            axisYType: "secondary",
                            name: "Measure",
                            showInLegend: true,
                            markerSize: 0,
                            dataPoints: [
                                <?php while ($row = $GetPatient->fetch(PDO::FETCH_ASSOC)) { ?> {
                                        y: <?= $row['height'] ?>,
                                        x: <?= $row['weight'] ?>,
                                    },

                                <?php } ?>
                            ]
                        },
                        {
                            type: "line",
                            axisYType: "secondary",
                            name: "P10",
                            showInLegend: true,
                            markerSize: 0,
                            dataPoints: [{
                                    x: 0.5,
                                    y: 3.209510017
                                },
                                {
                                    x: 1.0,
                                    y: 4.020561446
                                },
                                {
                                    x: 1.5,
                                    y: 4.754479354
                                },
                                {
                                    x: 2.0,
                                    y: 5.416802856
                                },
                                {
                                    x: 2.5,
                                    y: 6.01371624
                                },
                                {
                                    x: 3.0,
                                    y: 6.551379244
                                },
                                {
                                    x: 3.5,
                                    y: 7.035656404
                                },
                                {
                                    x: 4.0,
                                    y: 7.472021438
                                },
                                {
                                    x: 4.5,
                                    y: 7.865532922
                                },
                                {
                                    x: 5.0,
                                    y: 8.220839211
                                }
                            ]
                        },
                        {
                            type: "line",
                            axisYType: "secondary",
                            name: "P25",
                            showInLegend: true,
                            markerSize: 0,
                            dataPoints: [{
                                    x: 0.5,
                                    y: 3.597395573
                                },
                                {
                                    x: 1.0,
                                    y: 4.428872952
                                },
                                {
                                    x: 1.5,
                                    y: 5.183377547
                                },
                                {
                                    x: 2.0,
                                    y: 5.866806254
                                },
                                {
                                    x: 2.5,
                                    y: 6.484969167
                                },
                                {
                                    x: 3.0,
                                    y: 7.043626918
                                },
                                {
                                    x: 3.5,
                                    y: 7.548345716
                                },
                                {
                                    x: 4.0,
                                    y: 8.004398775
                                },
                                {
                                    x: 4.5,
                                    y: 8.416718775
                                },
                                {
                                    x: 5.0,
                                    y: 8.789881892
                                }

                            ]
                        }
                    ]
                });
                chart.render();

                function toogleDataSeries(e) {
                    if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
                        e.dataSeries.visible = false;
                    } else {
                        e.dataSeries.visible = true;
                    }
                    chart.render();
                }

            }
        </script>
        </head>

        <body>
            <div id="chartContainer" style="height: 370px; max-width: 920px; margin: 0px auto;"></div>
            <?php include "../../includes/footer.php"; ?>
        </body>