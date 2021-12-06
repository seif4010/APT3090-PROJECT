<?php session_start(); ?>
<?php include "../../includes/dao.php" ?>
<?php include "../../includes/req/ReqController.php";
$req = new Req();
?>

<div class="container">
    <?= $jumbo->getJumbo("View Requisition Report", "View Drug Requisition Report") ?>
    <?php if (isset($_GET['from']) && isset($_GET['to'])) : ?>
        <?php $reqs = $req->viewReqByDate($_GET['from'], $_GET['to']) ?>
    <?php else : ?>
        <?php $reqs = $req->viewReqs() ?>
    <?php endif; ?>
    <form method="get">
        <h5><b>Filter by Date</b></h5>
        <div class="row">
            <div class="col-3">
                <input class="form-input form-control form-group" placeholder="from" type="date" name="from" id="" required>
            </div>
            <div class="col-3">

                <input class="form-input form-control form-group" placeholder="to" type="date" name="to" id="" required>
            </div>
            <div class="col-3">
                <input class="btn btn-default btn sm" type="submit" value="Search">
            </div>
        </div>
    </form>
    <input class="btn btn-sm btn-default" onclick="refresh()" value="clear">
    <br>
    <?php $count = $reqs->rowCount(); ?>
    <script>
        window.onload = function() {

            var chart = new CanvasJS.Chart("chartContainer", {
                animationEnabled: true,
                title: {
                    text: "Requisition Sales Report"
                },
                <?php for ($i = 0; $i <= $count; $i++) : ?>
                    axisY<?= $i ?>: {
                        title: "Number Of Sales",
                        titleFontColor: "#4F81BC",
                        lineColor: "#4F81BC",
                        labelFontColor: "#4F81BC",
                        tickColor: "#4F81BC"
                    },

                <?php endfor; ?>
                toolTip: {
                    shared: true
                },
                legend: {
                    cursor: "pointer",
                    itemclick: toggleDataSeries
                },
                data: [
                    <?php while ($req = $reqs->fetch(PDO::FETCH_ASSOC)) { ?>

                        {
                            type: "column",
                            name: "<?= $req['name'] ?>",
                            legendText: "<?= $req['created'] ?>",
                            showInLegend: true,
                            dataPoints: [{
                                label: "<?= $req['name'] ?>",
                                y: <?= $req['count'] * $req['qty'] ?>
                            }, ]
                        },
                    <?php } ?>

                ]
            });
            chart.render();

            function toggleDataSeries(e) {
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

    <div id="chartContainer" style="height: 370px; max-width: 920px; margin: 0px auto;"></div>
    <?php include "../../includes/footer.php"; ?>
</div>

<script>
    function refresh() {
        event.stopPropagation();
        window.location.href = 'report.php';
    }
</script>