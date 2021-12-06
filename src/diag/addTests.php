<?php session_start(); ?>
<?php include "../../includes/dao.php" ?>
<?php include "../../includes/patients/PatientsController.php";
?>

<div class="container">
    <?= $jumbo->getJumbo("Add Tests", "Add patients Test Diagnosis") ?>
    <form method='POST' role='form' class="addTest" action='#' onsubmit="addTest()">
        <input type="hidden" name="type" value="addTest" id="">
        <div class='form-group'>
            <label for='in_TestName'>Test Name</label>
            <input name='in_TestName' placeholder='Test Name' id='in_TestName' class='form-control' type='text' required>
        </div>
        <div class='form-group'>
            <label for='in_Result'>Result</label>
            <input name='in_Result' id='in_Result' class='form-control' type='text' placeholder='Result' required>
        </div>
        <div class='form-group'>
            <input name='in_UserId' id='in_UserId' class='form-control' type='hidden' value="<?= $_GET['id'] ?>">
        </div>
        <div class='form-group'>
            <input type="submit" value="Add Test" class="btn btn-success">
        </div>
    </form>
    <?php include "../../includes/footer.php"; ?>


    <script>
        function addTest(e) {
            event.preventDefault();
            var form = $('.addTest').serialize();
            $.ajax({
                type: 'POST',
                url: '../../includes/tests/TestsController.php',
                data: form,
                beforeSend: function() {
                    Swal.fire({
                        title: "Adding Patient Test",
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
                            title: "Patient Test added succesfully",
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