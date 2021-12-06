<?php session_start(); ?>
<?php include "../../includes/dao.php" ?>
<?php include "../../includes/req/ReqController.php";
$req = new Req();
?>

<div class="container">
    <?= $jumbo->getJumbo("View Requisition", "View Drug Requisition") ?>
    <?php if (isset($_GET['id'])) : ?>
        <?php $reeqs = $req->viewReq($_GET['id']) ?>
        <a href="viewReq.php">Back</a>
        <table class="table table-responsive-sm table-striped">
            <thead>
                <th>REQ_ID</th>
                <th>DRUG NAME</th>
                <th>QTY</th>
                <th>PRICE</th>
                <th>STATUS</th>
            </thead>
            <tbody>
                <?php while ($req = $reeqs->fetch(PDO::FETCH_ASSOC)) { ?>
                    <tr>
                        <td><?= $req['req_id'] ?></td>
                        <td><?= $req['name'] ?></td>
                        <td><?= $req['qty'] ?></td>
                        <td><?= $req['price'] ?></td>
                        <td><?= ($req['status'] == 0) ? "Not Approved" : "Approved"; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

    <?php elseif ($_SESSION['role'] == "admin") : ?>
        <?php $reqs = $req->findReqs(); ?>

        <table class="table table-responsive-sm table-striped">
            <thead>
                <th>REQ_ID</th>
                <th>ITEMS COUNT</th>
                <th>CREATED</th>
                <th>STATUS</th>
                <th>ACTIONS</th>
            </thead>
            <tbody>
                <?php while ($req = $reqs->fetch(PDO::FETCH_ASSOC)) { ?>
                    <tr>
                        <td><a href="viewReq.php?id=<?= $req['req_id'] ?>"><?= $req['req_id'] ?></a></td>
                        <td><?= $req['count'] ?></td>
                        <td><?= $req['created'] ?></td>
                        <td><?php if ($req['status'] == 0) {
                                echo "Pending";
                            } else if ($req['status'] == 1) {
                                echo "Approved";
                            } else if ($req['status'] == 2) {
                                echo "Denied";
                            }
                            ?>
                        </td>
                        <td><a href="viewReq.php?id=<?= $req['req_id'] ?>">View Requisition</a></td>
                        <td><?php if ($req['status'] == 0) {
                                echo "<a title='Approve' onclick='approve(" . $req['req_id'] . ") 'class='btn btn-success btn-sm fa fa-check'></a>";
                                echo "<a title='Deny' onclick='deny(" . $req['req_id'] . ") 'class='btn btn-warning btn-sm fa fa-remove'></a>";
                            } else if ($req['status'] == 1) {
                                echo "<a onclick='deny(" . $req['req_id'] . ") 'class='btn btn-warning btn-sm fa fa-remove'></a>";
                            } else if ($req['status'] == 2) {
                                echo "<a title='Approve' onclick='approve(" . $req['req_id'] . ") 'class='btn btn-success btn-sm fa fa-check'></a>";
                            }
                            ?>
                        </td>
                    </tr>
                <?php } ?>

            </tbody>
        </table>

    <?php else : ?>
        <?php $reqs = $req->findReqsByID($_SESSION['email']); ?>

        <table class="table table-responsive-sm table-striped">
            <thead>
                <th>REQ_ID</th>
                <th>ITEMS COUNT</th>
                <th>CREATED</th>
                <th>STATUS</th>
                <th>ACTIONS</th>
            </thead>
            <tbody>
                <?php while ($req = $reqs->fetch(PDO::FETCH_ASSOC)) { ?>
                    <tr>
                        <td><a href="viewReq.php?id=<?= $req['req_id'] ?>"><?= $req['req_id'] ?></a></td>
                        <td><?= $req['count'] ?></td>
                        <td><?= $req['created'] ?></td>
                        <td><?php if ($req['status'] == 0) {
                                echo "Pending";
                            } else if ($req['status'] == 1) {
                                echo "Approved";
                            } else if ($req['status'] == 2) {
                                echo "Denied";
                            }
                            ?>
                        </td>
                        <td><a href="viewReq.php?id=<?= $req['req_id'] ?>">View Requisition</a></td>
                    </tr>
                <?php } ?>

            </tbody>
        </table>

    <?php endif; ?>
</div>


<?php include "../../includes/footer.php"; ?>

<script>
    function approve(id) {
        event.stopPropagation();

        $.ajax({
            type: 'POST',
            url: '../../includes/req/ReqController.php',
            data: {
                type: 'approve',
                id: id
            },
            beforeSend: function() {
                Swal.fire({
                    title: "Verifying Requisition",
                    timer: 10000,
                    type: "info",
                    onBeforeOpen: () => {
                        Swal.showLoading();
                    }
                });
            },
            success: function(resp) {
                if (resp == "success") {
                    Swal.fire({
                        title: "Requisition Aprroved",
                        width: "100",
                        type: "success",
                        timer: 10000,
                        showConfirmButton: true,
                    }).then(result => {
                        window.location.reload();
                    });

                } else {
                    Swal.fire({
                        title: "Failed to Approve:  " + resp,
                        width: "100",
                        type: "error",
                        timer: 10000,
                        showConfirmButton: true,
                    }).then(result => {

                        window.location.reload();

                    });
                }
            },


        });
    }

    function deny(id) {
        event.stopPropagation();

        $.ajax({
            type: 'POST',
            url: '../../includes/req/ReqController.php',
            data: {
                type: 'deny',
                id: id
            },
            beforeSend: function() {
                Swal.fire({
                    title: "Verifying Requisition",
                    type: "info",
                    timer: 10000,
                    onBeforeOpen: () => {
                        Swal.showLoading();
                    }
                });
            },
            success: function(resp) {
                if (resp == "success") {
                    Swal.fire({
                        title: "Requisition Denied",
                        width: "100",
                        type: "warning",
                        timer: 10000,
                        showConfirmButton: true,
                    }).then(result => {
                        window.location.reload();
                    });

                } else {
                    Swal.fire({
                        title: "Failed to Deny:  " + resp,
                        width: "100",
                        type: "error",
                        timer: 10000,
                        showConfirmButton: true,
                    }).then(result => {

                        window.location.reload();

                    });
                }
            },


        });
    }
</script>