<?php session_start(); ?>
<?php include "../../includes/dao.php" ?>
<?php include "../../includes/patients/PatientsController.php";
$patients = new PatientsController();
?>
<div class="container">
    <?= $jumbo->getJumbo("View Children", "View childrens List") ?>

    <?php if (isset($_GET['years'])) : ?>
        <?php $patientsList = $patients->viewAllChildrenByDate($_GET['years']); ?>
    <?php else : ?>
        <?php $patientsList = $patients->viewAllChildren();


        ?>

    <?php endif; ?>
    <form method="get">
        <input class="form-input form-control form-check form-group" placeholder="Filter by Years Old" type="text" name="years" id="">
    </form>
    <button onclick="refresh()" class="btn btn-default btn-sm text-left">Clear Filter</button>
    <table class="table table-responsive table-striped table-hover">
        <thead>
            <th>ID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Date Of Birth</th>
            <th>Address</th>
            <th>Marital Status</th>
            <th>Date Of Registration</th>
            <th>Contact Number</th>
            <th>Actions</th>
        </thead>


        <tbody>
            <?php while ($row = $patientsList->fetch(PDO::FETCH_ASSOC)) {
                ?>
                <tr>
                    <td><?= $row['user_id'] ?></td>
                    <td><?= $row['firstname'] ?></td>
                    <td><?= $row['lastname'] ?></td>
                    <td><?= $row['dob'] ?></td>
                    <td><?= $row['address'] ?></td>
                    <td><?= $row['married'] ?></td>
                    <td><?= $row['dor'] ?></td>
                    <td><?= $row['contact'] ?></td>
                    <td>

                        <button type="button" class="btn btn-primary" data-toggle="popover" data-html='true' data-placement="top" title="Chart Type" data-content="
                                                <a class='btn btn-sm btn-default' href='wfa.php?id=<?= $row['user_id'] ?>'>Percetiles</a><br>
                                                <a class='btn btn-sm btn-default' href='hfa.php?id=<?= $row['user_id'] ?>'>Height for Age</a><br>
                                                <a class='btn btn-sm btn-default' href='wfh.php?id=<?= $row['user_id'] ?>'>Weight for Height</a><br>
                                                <a class='btn btn-sm btn-default' href='bfa.php?id=<?= $row['user_id'] ?>'>BMI for age</a><br>
                                                <a class='btn btn-sm btn-default' href='hcfa.php?id=<?= $row['user_id'] ?>'>Head Circumference for Age</a><br>
                                        ">Graph</button>
                    </td>
                    <td><a title="update Details" href="updateChild.php?id=<?= $row['user_id'] ?>" class="btn btn-sm btn-default fa fa-pencil"></a> </td>
                </tr>
            <?php } ?>
        </tbody>

    </table>

</div>



<?php include "../../includes/footer.php"; ?>

<script>
    function refresh() {
        window.location.href = 'viewChildren.php';
    }

    $(function() {
        $('[data-toggle="popover"]').popover()
    })
</script>