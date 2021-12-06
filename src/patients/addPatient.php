<?php session_start(); ?>
<?php include "../../includes/dao.php" ?>
<?php include "../../includes/patients/PatientsController.php";
?>

<div class="container">
    <?= $jumbo->getJumbo("Add patient", "Add patients Details") ?>
    <form method='POST' class='addP' action='#' onsubmit="addPatient()">
        <input type="hidden" name="type" value="addPatient" id="">
        <div class='form-group'>
            <label for='in_Firstname'>Firstname</label>
            <input name='in_Firstname' id='in_Firstname' class='form-control' type='text' placeholder='Firstname' required>
        </div>
        <div class='form-group'>
            <label for='in_Lastname'>Lastname</label>
            <input name='in_Lastname' id='in_Lastname' class='form-control' type='text' placeholder='Lastname' required>
        </div>
        <div class='form-group'>
            <label for='in_Dob'>Dob</label>
            <input name='in_Dob' id='in_Dob' class='form-control' type='date' placeholder='Dob' required>
        </div>
        <div class='form-group'>
            <label for='in_Address'>Address</label>
            <textarea name='in_Address' id='in_Address' class=' form-control' rows='5' placeholder='Address' required></textarea>
        </div>
        <label for='in_Married'>Marrital Status</label>
        <div class='form-group'>
            <select name="in_Married" id="" class="form-control browser-default">
                <option value="married">Married</option>
                <option value="single">Single</option>
                <option value="divorced">Divorced</option>
            </select>
        </div>
        <div class='form-group'>
            <label for='in_Contact'>Contact</label>
            <input name='in_Contact' id='in_Contact' class='form-control' type='text' placeholder='Contact' required>
        </div>
        <div class='form-group'>
            <input type="submit" value="Add Patient" class="btn btn-success">
        </div>
    </form>

    <?php include "../../includes/footer.php"; ?>

    <script>
        function addPatient(e) {
            event.preventDefault();
            var form = $('.addP').serialize();
            $.ajax({
                type: 'POST',
                url: '../../includes/patients/PatientsController.php',
                data: form,
                beforeSend: function() {
                    Swal.fire({
                        title: "Adding Patient",
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
                            title: "Patient added succesfully",
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