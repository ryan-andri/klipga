<?php
session_start();
require_once('configs/config.php');
if (isset($_SESSION['is_loged'])) {
    header('location:' . BASE_URL . '/app');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>KLIPGA - RS AK GANI</title>
    <link rel="icon" type="image/x-icon" href="<?= BASE_URL ?>/assets/img/hesti.png">
    <link href="<?= BASE_URL ?>/assets/css/styles.css" rel="stylesheet" />
    <link href="<?= BASE_URL ?>/assets/css/custom.css" rel="stylesheet" />
    <style>
        html,
        body {
            height: 100%;
        }

        body {
            display: flex;
            align-items: center;
            padding-top: 20px;
            padding-bottom: 40px;
            background-color: #f5f5f5;
        }

        .form-signin {
            width: 100%;
            max-width: 450px;
            padding: 15px;
            margin: auto;
        }

        .form-signin .form-floating:focus-within {
            z-index: 2;
        }

        .form-signin input[type="email"] {
            margin-bottom: -1px;
        }

        .form-signin input[type="password"] {
            margin-bottom: 10px;
        }

        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }
    </style>
</head>

<body class="text-center">
    <main class="form-signin">
        <form id="form_login">
            <img class="mb-2" src="<?= BASE_URL ?>/assets/img/hesti.png" alt="logo" width="75" height="75">
            <h4>KLIPGA</h4>
            <h4 class="mb-3">Rumah Sakit Umum dr. AK Gani</h4>
            <div class="form-floating mb-2">
                <input type="text" class="form-control" name="username" id="username" placeholder="Username">
                <label for="username">Username</label>
            </div>
            <div class="form-floating mb-2">
                <input type="password" class="form-control" name="password" id="password" placeholder="Password">
                <label for="password">Password</label>
            </div>
            <button type="button" class="w-100 btn btn-lg btn-primary" id="btn_login">Sign in</button>
        </form>
        <p class="mt-5 mb-2 text-muted">&copy; IT Rumah Sakit Umum dr. AK Gani</p>
    </main>

    <script src="<?php echo BASE_URL; ?>/assets/vendor/jquery-3.7.1/jquery.min.js"></script>
    <script src="<?php echo BASE_URL; ?>/assets/vendor/bootstrap-5.2.3/bootstrap.bundle.min.js"></script>
    <script src="<?php echo BASE_URL; ?>/assets/vendor/sweetalert/sweetalert.min.js"></script>
    <script>
        $(document).ready(function() {
            function validation() {
                let valid = true;
                $("#form_login input").each(function() {
                    if ($.trim($(this).val()).length == 0) {
                        $(this).addClass("error");
                        valid = false;
                        // $(this).focus();
                    } else {
                        $(this).removeClass("error");
                    }
                });
                return valid;
            }
            $("#btn_login").on("click", function() {
                let user = $("#username").val().toString();
                let pass = $("#password").val().toString();

                if (!validation()) {
                    swal({
                        text: "Username dan Password Tidak Boleh kosong!",
                        icon: "info",
                        button: false,
                    })
                    return;
                }

                $.ajax({
                    url: "payload",
                    type: "POST",
                    dataType: "json",
                    data: {
                        action: "login",
                        user: user,
                        pass: pass
                    },
                    success: function(response) {
                        switch (response) {
                            case "sukses":
                                $(location).attr('href', 'app');
                                break;
                            case "gagal":
                                swal({
                                    text: "Username atau Password Salah!",
                                    icon: "error",
                                    button: false,
                                })
                                break;
                        }
                    },
                    // complete: function() {}
                });
            });
        });
    </script>
</body>

</html>