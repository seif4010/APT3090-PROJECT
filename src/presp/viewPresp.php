<?php session_start(); ?>
<?php include "../../includes/dao.php" ?>
<?php include "../../includes/presp/PrespController.php";
$drugs = new Presp();
?>
<div class="container">

    <?= $jumbo->getJumbo("View  Drugs", "View Drug List") ?>

    <?php $drugsList = $drugs->getAllPresp(); ?>
    <div class="row">
        <div class="col-12 text-center">

            <table class="table table-hover table-responsive-sm table-striped">
                <thead>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Prescription</th>
                    <th>Expiry date</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Actions</th>
                </thead>

                <tbody>
                    <?php while ($row = $drugsList->fetch(PDO::FETCH_ASSOC)) {
                        ?>
                        <tr>
                            <td><?= $row['drug_id'] ?></td>
                            <td><?= $row['name'] ?></td>
                            <td><?= $row['presp'] ?></td>
                            <td><?= $row['expiry'] ?></td>
                            <td>MWK <?= $row['price'] ?></td>
                            <td><?= $row['qty'] ?></td>
                            <td><button title="Delete Drug" class="delete btn btn-danger btn-sm fa fa-trash-o" onclick="Delete(<?= $row['drug_id'] ?>)"></button>
                                <a href="updatePresp.php?id=<?= $row['drug_id'] ?>" title="Edit Drug" class="warning btn btn-warning btn-sm fa fa-pencil"></a></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>


    <?php include "../../includes/footer.php"; ?>






    <script>
        function Delete(id) {
            event.preventDefault();
            Swal.fire({
                title: "Are You Sure You want to Delete Drug with ID " + id + " ?",
                text: "You won't be able to revert this!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                animation: true,
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, Delete it!"
            }).then(result => {
                if (result.value) {
                    $.ajax({
                        type: "POST",
                        url: '../../includes/presp/PrespController.php',
                        data: {
                            type: "deleteDrug",
                            id: id
                        },
                        beforeSend: function() {
                            Swal.fire({
                                title: "Deleting Drug",
                                type: "info",
                                text: "Deleting Drug " + id,
                                icon: "info",
                            })
                        },
                        success: function(resp) {
                            if (resp = "success") {
                                Swal.fire({
                                    text: "Drug Deleted",
                                    type: "success",
                                    showConfirmButton: true,
                                    timer: 10000,
                                    animation: true,
                                }).then(result => {
                                    window.location.reload();
                                });
                            } else {
                                Swal.fire({
                                    title: "Error",
                                    type: "error",
                                    text: "Something Went Wrong " + resp,
                                    icon: "error",
                                    button: "Try Again",
                                    showConfirmButton: true,
                                }).then(result => {
                                    window.location.reload();
                                });
                            }
                        }
                    });
                }
            });

        }
    </script>