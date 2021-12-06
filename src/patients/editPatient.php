<?php session_start(); ?>
<?php include "../../includes/dao.php" ?>
<?php include "../../includes/patients/PatientsController.php";
$patients = new PatientsController();
$GetPatient = $patients->viewDiag($_GET['id']);
$patient = $GetPatient->fetch(PDO::FETCH_ASSOC);
?>
<div class="container">
    <?= $jumbo->getJumbo("Add " . $patient['firstname'] . " " . $patient['lastname'] . "'s Diagnosis", "<a href='viewPatients.php'>View Patients List</a>") ?>

    <form method='POST' class='editP' action='#' onsubmit="editPatient()">
        <input type="hidden" name="type" value="editPatient" id="">
        <input type="hidden" name="id" value="<?= $_GET['id'] ?>" id="">
        <div class='form-group'>
            <label for='in_Firstname'>Firstname</label>
            <input name='in_Firstname' value="<?= $patient['firstname'] ?>" id='in_Firstname' class='form-control' type='text' placeholder='Firstname' required>
        </div>
        <div class='form-group'>
            <label for='in_Lastname'>Lastname</label>
            <input name='in_Lastname' value="<?= $patient['lastname'] ?>" id='in_Lastname' class='form-control' type='text' placeholder='Lastname' required>
        </div>
        <div class='form-group'>
            <label for='in_Dob'>Dob</label>
            <input name='in_Dob' id='in_Dob' value="<?= $patient['dob'] ?>" class='form-control' type='date' placeholder='Dob' required>
        </div>
        <div class='form-group'>
            <label for='in_Address'>Address</label>
            <input value='<?= $patient['address'] ?>' name='in_Address' id='in_Address' class=' form-control' rows='5' placeholder='Address'>
        </div>
        <label for='in_Married'>Marrital Status</label>
        <div class='form-group'>
            <select name="in_Married" id="" class="form-control browser-default">
                <option value="<?= $patient['married'] ?>"><?= $patient['married'] ?></option>
                <option value="married">Married</option>
                <option value="single">Single</option>
                <option value="divorced">Divorced</option>
            </select>
        </div>

        <div class='form-group'>
            <label for='in_Dor'>Dor</label>
            <input name='in_Dor' id='in_Dor' value="<?= $patient['dor'] ?>" class='form-control' type='date' placeholder='Dor' required>
        </div>
        <div class='form-group'>
            <label for='in_Contact'>Contact</label>
            <input name='in_Contact' id='in_Contact' value="<?= $patient['contact'] ?>" class='form-control' type='text' placeholder='Contact' required>
        </div>
        <div class='form-group'>
            <label for='in_Referred'>Referred</label>
            <select class='form-control browser-default' value="<?= $patient['referred'] ?>" id='in_Referred' name='in_Referred' required>
                <option value="doc">Dept</option>
            </select>
        </div>
        <label for='in_Doctor'>Doctor</label>
        <div class='form-group'>
            <select class='form-control browser-default' value="<?= $patient['doctor'] ?>" id='in_Doctor' name='in_Doctor' required>
                <option value="doc">Doc</option>
            </select>
        </div>

        <div class='form-group'>
            <input type="submit" value="Edit Patient" class="btn btn-success">
        </div>
</div>

<?php include "../../includes/footer.php"; ?>


<script>
    function editPatient(e) {
        event.preventDefault();
        var form = $('.editP').serialize();
        $.ajax({
            type: 'POST',
            url: '../../includes/patients/PatientsController.php',
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
                        title: "Patient Updated succesfully",
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