<?php session_start(); ?>
<?php include "../../includes/dao.php" ?>
<?php include "../../includes/users/UsersController.php";
$patients = new User();
?>
<div class="container">
    <?= $jumbo->getJumbo("View  Users", "View Users List") ?>

    <?php $patientsList = $patients->viewAllUsers(); ?>

    <table class="table table-striped table-hover">
        <thead>
            <th>ID</th>
            <th>email</th>
            <th>role</th>
        </thead>
        <tbody>
            <?php while ($row = $patientsList->fetch(PDO::FETCH_ASSOC)) {
                ?>
                <tr>
                    <td><?= $row['user_id'] ?></td>
                    <td><?= $row['email'] ?></td>
                    <td><?= $row['role'] ?></td>
                <?php } ?>
</div>
<?php include "../../includes/footer.php"; ?>