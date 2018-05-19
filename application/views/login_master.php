<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>Login</title>
        <!-- Bootstrap core CSS-->
        <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <!-- Custom fonts for this template-->
        <link href="assets/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <!-- Custom styles for this template-->
        <link href="assets/css/sb-admin.css" rel="stylesheet">
    </head>

    <body class="bg-dark">
        <div class="container">
            <div class="card card-login mx-auto mt-5">
                <div class="card-header">Login</div>
                <div class="card-body">
                    <?php echo form_open('', array("id" => "form_login")); ?>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Email address</label>
                        <input class="form-control" name="user" type="email" aria-describedby="emailHelp" placeholder="Enter email">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Password</label>
                        <input class="form-control" name="pass" type="password" placeholder="Password">
                    </div>
                    <div class="form-group">
                        <div class="form-check">
                            <label class="form-check-label">
                                <input class="form-check-input" type="checkbox"> Remember Password</label>
                        </div>
                    </div>
                    <button id="btn_login" class="btn btn-primary btn-block" type="button">Login</button>
                    </form>
                    <br/>
                    <div class="alert alert-danger" id="error-alert" style="display: none;">
                        Username or Password is Incorrect.
                    </div>
                    <div class="text-center">
                        <a class="d-block small mt-3" href="#">Register an Account</a>
                        <a class="d-block small" href="#">Forgot Password?</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Bootstrap core JavaScript-->
        <script src="assets/vendor/jquery/jquery.min.js"></script>
        <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
        <!-- Core plugin JavaScript-->
        <script src="assets/vendor/jquery-easing/jquery.easing.min.js"></script>

        <script>
            $(document).ready(function () {
                $("#btn_login").on("click", function () {
                    $.post({
                        url: "<?php echo base_url(); ?>" + "login/verify_login",
                        data: $("#form_login").serialize()
                    }).done(function (response) {
                        if (IsJsonString(response)) {
                            data = JSON.parse(response);
                            if (data == true) {
                                location.href = base + "orders";
                            } else {
                                $("#error-alert").fadeTo(2000, 500).slideUp(500, function () {
                                    $("#error-alert").slideUp(500);
                                });
                            }
                        }
                    });
                });
            });

        </script>
        <?php $this->view('common'); ?>
    </body>

</html>
