<?php session_start(); ?>
<?php include "../../includes/dao.php" ?>
<?php include "../../includes/tests/TestsController.php";
$tests = new Tests();
?>
<div class="container">
    <?= $jumbo->getJumbo("View patients Tests", "View patients Tests") ?>

    <?php $patientsList = $tests->viewTest($_GET['id']); ?>
    <a title="Refer patient" onclick="modal(<?= $_GET['id'] ?>)" class="btn btn-sm btn-default fa fa-ambulance"></a> </td>

    <table class="table table-striped table-hover">
        <thead>
            <th>ID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Test Name</th>
            <th>Result</th>
            <th>Actions</th>
        </thead>


        <tbody>
            <?php while ($row = $patientsList->fetch(PDO::FETCH_ASSOC)) {
                ?>
                <tr>
                    <td><?= $row['user_id'] ?></td>
                    <td><?= $row['firstname'] ?></td>
                    <td><?= $row['lastname'] ?></td>
                    <td><?= $row['test_name'] ?></td>
                    <td><?= $row['result'] ?></td>
                    <td><a title="Add Prescription" href="../patients/addDiagnosis.php?t_id=<?= $row['test_id'] ?>&id=<?= $row['user_id'] ?>" class="btn btn-sm btn-default fa fa-plus"></a>
                        <a title="View Prescriptions" href="../patients/viewDiag.php?t_id=<?= $row['test_id'] ?>&id=<?= $row['user_id'] ?>" class="btn btn-sm btn-default fa fa-eye"></a>
                </tr>
            <?php } ?>
        </tbody>

    </table>

</div>



<?php include "../../includes/footer.php"; ?>


<script>
    function Delete(id) {
        event.preventDefault();
        Swal.fire({
            title: "Are You Sure You want to Delete Patient with ID " + id + " ?",
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
                    url: '../../includes/patients/PatientsController.php',
                    data: {
                        type: "deletePatient",
                        id: id
                    },
                    beforeSend: function() {
                        Swal.fire({
                            title: "Deleting Patient",
                            type: "info",
                            text: "Deleting Patient " + id,
                            icon: "info",
                        })
                    },
                    success: function(resp) {
                        if (resp = "success") {
                            Swal.fire({
                                text: "Patient Deleted",
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

    function refer(e) {
        event.preventDefault();
        var form = $('.refer').serialize();
        $.ajax({
            type: 'POST',
            url: '../../includes/patients/PatientsController.php',
            data: form,
            beforeSend: function() {
                Swal.fire({
                    title: "Refering Patient",
                    type: "info",
                    timer: 10000,
                    onBeforeOpen: () => {
                        Swal.showLoading()
                        timerInterval = setInterval(() => {}, 100)
                    }
                });
            },
            success: function(resp) {
                if (resp == "success") {
                    Swal.fire({
                        title: "Patient Refered succesfully",
                        type: "success",
                    }).then(result => {
                        window.location.reload();
                    });
                } else {
                    Swal.fire({
                        title: "Error" + resp,
                        type: "error",
                    }).then(result => {
                        window.location.reload();
                    });




                }
            },

        })
    }
</script>


<div id="publish" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Refer Patient</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="refer" action="" onsubmit="refer()">
                    <input type="hidden" name="type" value="refer">
                    <input class="id" type="hidden" name="id" value="">
                    <input type="text" name="reason" class="form-control" placeholder="Reason for referal" required>
                    <br>
                    <input type="text" name="name" class="form-control" placeholder="Hospital Refered" required>
                    <input type="submit" class="btn btn-success">
                </form>
            </div>
            <div class="modal-footer">

            </div>
        </div>
    </div>
</div>
<script>
    function modal(id) {
        event.preventDefault();
        $('.modal').modal('show');
        $('.id').attr("value", id);
    }
</script>