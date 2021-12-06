<?php include "../../includes/header.php"; ?>
<link href="../../public/css/login.css" rel="stylesheet">

<!--Main Layout-->
<!--Intro Section-->
<section class="view intro-2">
    <div class="mask rgba-stylish-strong h-100 justify-content-center align-items-center">
        <div class="container">
            <div class="row">
                <div class="col-xl-5 col-lg-6 col-md-10 col-sm-12 mx-auto mt-lg-5">

                    <!--Form with header-->
                    <div class="mt-5 card wow fadeIn" data-wow-delay="0.4s">
                        <div class="card-body">
                            <form action="#" class="login" id="login">
                                <input type="hidden" name="type" value="login">
                                <!--Header-->
                                <div class="form-header blue-gradient">
                                    <h3><i class="fa fa-user mt-2 mb-2"></i> Log in:</h3>
                                </div>

                                <!--Body-->
                                <div class="md-form">
                                    <i class="fa fa-user prefix white-text"></i>
                                    <input name="email" type="text" id="orangeForm-name" class="form-control">
                                    <label for="orangeForm-name">Email</label>
                                </div>

                                <div class="md-form">
                                    <i class="fa fa-lock prefix white-text"></i>
                                    <input name="password" type="password" id="orangeForm-pass" class="form-control">
                                    <label for="orangeForm-pass">Your password</label>
                                </div>

                                <div class="text-center">
                                    <button onclick="submitForm()" class="btn blue-gradient btn-lg">Sign In</button>
                                    <hr>
                                    <p class="text-white">&copy; 2021 Copyright:
                                </div>
                            </form>
                        </div>
                    </div>
                    <!--/Form with header-->

                </div>
            </div>
        </div>
    </div>
</section>
<!--Main Layout-->

<?php include "../../includes/footer.php"; ?>


<script>
    function submitForm(e) {
        event.preventDefault();
        var loginInfo = $('.login').serialize();
        $.ajax({
            type: 'POST',
            url: '../../includes/users/UsersController.php',
            data: loginInfo,
            beforeSend: function() {
                Swal.fire({
                    title: "Logging You In",
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
                    window.location.href = "../admin/admin.php";
                } else if (resp == "manager") {
                    window.location.href = "user.php";
                } else {
                    Swal.fire({
                        title: resp,
                        type: "error",
                    });
                }
            },

        })
    }
</script>