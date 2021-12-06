<?php session_start(); ?>
<?php include "../../includes/dao.php" ?>
<?php include "../../includes/users/UsersController.php";
?>

<div class="container">
    <?= $jumbo->getJumbo("Add User", "") ?>
    <form method='POST' class='addUser' action='#' onsubmit="adduser()">
        <input type="hidden" name="type" value="addUser" id="">
        <div class='form-group'>
            <label for='in_Email'>Email</label>
            <input name='in_Email' id='in_Email' class='form-control' type='text' placeholder='Email' required>
        </div>
        <div class='form-group'>
            <label for='in_Password'>Password</label>
            <input name='in_Password' id='in_Password' class='form-control' type='password' placeholder='Password'>
        </div>
        <div class='form-group'>
            <label for='in_Role'>Referred</label>
            <select class='form-control browser-default' id='in_Role' name='in_Role' required>
                <option value="user">User</option>
                <option value="admin">Admin</option>
            </select>
        </div>
        <div class='form-group'>
            <input type="submit" value="Add User" class="btn btn-success">
        </div>
    </form>

    <?php include "../../includes/footer.php"; ?>

    <script>
        function adduser(e) {
            event.preventDefault();
            var form = $('.addUser').serialize();
            $.ajax({
                type: 'POST',
                url: '../../includes/users/UsersController.php',
                data: form,
                beforeSend: function() {
                    Swal.fire({
                        title: "Adding User",
                        type: "info",
                        onBeforeOpen: () => {
                            Swal.showLoading()
                            timerInterval = setInterval(() => {}, 100)
                        }
                    });
                },
                success: function(resp) {
                    if (resp == "success") {
                        Swal.fire({
                            title: "User added succesfully",
                            type: "success",
                        }).then(result => {
                            window.location.reload();
                        });
                    } else {
                        Swal.fire({
                            title: "Error",
                            text: resp,
                            type: "error",
                        }).then(result => {
                            window.location.reload();
                        });
                    }
                },

            })
        }
    </script>