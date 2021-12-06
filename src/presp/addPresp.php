<?php session_start(); ?>
<?php include "../../includes/dao.php" ?>
<div class="container">
    <?= $jumbo->getJumbo("Add Drug", "Add Drug") ?>

    <form class='presp' role='form' action='#' onsubmit="addPrep()">
        <input type="hidden" name="type" value="addPresp">
        <div class='form-group'>
            <label for='in_Name' class="fas fa-tablets prefix"> Drug Name</label>
            <input name='in_Name' id='in_Name' class='form-control' type='text' placeholder='Name' required>
        </div>
        <div class='form-group'>
            <label for='in_Expiry' class="fas fa-calendar"> Expiry Date</label>
            <input name='in_Expiry' id='in_Expiry' class='form-control' type='date' placeholder='Expiry' required>
        </div>
        <div class='form-group'>
            <label for='in_Presp' class="fas fa-prescription-bottle-alt prefix"> Prescription</label>
            <input name='in_Presp' id='in_Presp' class='form-control' type='text' placeholder='Prescription'>
        </div>
        <div class='form-group'>
            <label for='in_Price' class="fas fa-money-bill prefix"> Price</label>
            <input name='in_Price' id='in_Price' class='form-control' type='text' placeholder='MWK'>
        </div>
        <div class='form-group'>
            <label for='in_Qty' class="fas fa-sort-numeric-up prefix"> Quantity</label>
            <input name='in_Qty' id='in_Qty' class='form-control' type='number' placeholder='Quantity'>
        </div>
        <div class='form-group'>
            <input class='btn btn-success' type='submit' value="Add Prescription">
        </div>
    </form>
</div>
<?php include "../../includes/footer.php"; ?>

<script>
    function addPrep(e) {
        event.preventDefault();
        var presp = $('.presp').serialize();
        $.ajax({
            type: 'POST',
            url: '../../includes/presp/PrespController.php',
            data: presp,
            beforeSend: function() {
                Swal.fire({
                    title: "Adding Prescription",
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
                        title: "Drug added succesfully",
                        type: "success",
                    }).then(result => {
                        window.location.reload();
                    });

                } else {
                    Swal.fire({
                        title: "Error" + resp,
                        type: "error",
                    });
                }
            },

        })
    }
</script>