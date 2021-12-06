<?php session_start(); ?>
<?php include "../../includes/dao.php" ?>
<?php include "../../includes/presp/PrespController.php";
$drugs = new Presp();
?>
<div class="container">

    <?= $jumbo->getJumbo("Update Drugs", "Update Drug List") ?>

    <?php $drugsList = $drugs->getSinglePresp($_GET['id']);
    $row = $drugsList->fetch(PDO::FETCH_ASSOC); ?>
    <div class="row">
        <div class="col-12 text-center">

            <form class='editPresp' role='form' action='#' onsubmit="updatePresp()">
                <input type="hidden" name="type" value="updatePrespc">
                <input type="hidden" name="id" value='<?= $_GET['id'] ?>'>
                <div class='form-group'>
                    <label for='in_Name' class="fas fa-tablets prefix"> Drug Name</label>
                    <input value="<?= $row['name'] ?>" name='in_Name' id='in_Name' class='form-control' type='text' placeholder='Name' required>
                </div>
                <div class='form-group'>
                    <label for='in_Expiry' class="fas fa-calendar"> Expiry Date</label>
                    <input value="<?= $row['expiry'] ?>" name='in_Expiry' id='in_Expiry' class='form-control' type='date' placeholder='Expiry' required>
                </div>
                <div class='form-group'>
                    <label for='in_Presp' class="fas fa-prescription-bottle-alt prefix"> Prescription</label>
                    <input value="<?= $row['presp'] ?>" name='in_Presp' id='in_Presp' class='form-control' type='text' placeholder='Prescription'>
                </div>
                <div class='form-group'>
                    <label for='in_Price' class="fas fa-money-bill prefix"> Price</label>
                    <input value="<?= $row['price'] ?>" name='in_Price' id='in_Price' class='form-control' type='text' placeholder='MWK'>
                </div>
                <div class='form-group'>
                    <label for='in_Qty' class="fas fa-sort-numeric-up prefix"> Quantity</label>
                    <input value="<?= $row['qty'] ?>" name='in_Qty' id='in_Qty' class='form-control' type='number' placeholder='Quantity'>
                </div>
                <div class='form-group'>
                    <input class='btn btn-success' type='submit' value="Update Prescription">
                </div>
            </form>

            <?php include "../../includes/footer.php"; ?>


            <script>
                function updatePresp(e) {
                    event.preventDefault();
                    var form = $('.editPresp').serialize();
                    $.ajax({
                        type: 'POST',
                        url: '../../includes/presp/PrespController.php',
                        data: form,
                        beforeSend: function() {
                            Swal.fire({
                                title: "Processing request",
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
                                    title: "Prescription Updated succesfully",
                                    type: "success",
                                }).then(result => {
                                    window.history.back();
                                });
                            } else {
                                Swal.fire({
                                    title: "Error" + resp,
                                    type: "error",
                                }).then(result => {
                                    window.history.back();
                                });
                            }
                        },

                    })
                }
            </script>