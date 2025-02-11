<?php
session_start();
require('../configs/config.php');
require('auth.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="Ryan Andri" />
    <link rel="icon" type="image/x-icon" href="<?= BASE_URL ?>/assets/img/paru.png">

    <title>KLIPGA</title>

    <link href="<?php echo BASE_URL; ?>/assets/vendor/datatables-1.13.6/css/jquery.dataTables.min.css" rel="stylesheet" />
    <link href="<?php echo BASE_URL; ?>/assets/vendor/buttons-2.4.2/css/buttons.dataTables.min.css" rel="stylesheet" />
    <link href="<?php echo BASE_URL; ?>/assets/vendor/responsive-2.5.0/css/responsive.dataTables.min.css" rel="stylesheet" />
    <link href="<?php echo BASE_URL; ?>/assets/vendor/select-1.7.0/css/select.dataTables.min.css" rel="stylesheet" />
    <link href="<?php echo BASE_URL; ?>/assets/vendor/select2-4.0.13/css/select2.min.css" rel="stylesheet" />
    <link href="<?php echo BASE_URL; ?>/assets/css/styles.css" rel="stylesheet" />
    <link href="<?php echo BASE_URL; ?>/assets/css/custom.css" rel="stylesheet" />
    <script src="<?php echo BASE_URL; ?>/assets/vendor/fontawesome-6.3.0/all.js"></script>
</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <a class="navbar-brand ps-3" href="<?php echo BASE_URL; ?>/app">KLIPGA
            <span><img class="img-fluid mb-2 ms-3" src="<?= BASE_URL ?>/assets/img/paru.png" width="35px">
            </span>
        </a>
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="javascript:void(0);"><i class="fas fa-bars"></i></button>
        <ul class="navbar-nav ms-auto me-3">
            <li class="nav-item dropdown">
                <a class="dropdown-toggle" id="navbarDropdown" href="javascript:void(0);" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="color:grey;"><i class="fas fa-user fa-fw"></i></a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" id="ubah_password" href="#!"><i class="fas fa-key me-2"></i><span>Ubah Password</span></a></li>
                    <li><a class="dropdown-item" id="logout" href="#!">Logout</a></li>
                </ul>
            </li>
        </ul>
    </nav>

    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">Home</div>
                        <a class="nav-link active" id="nav_dashboard">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Dashboard
                        </a>
                        <div class="sb-sidenav-menu-heading">Module</div>
                        <a class="nav-link" id="nav_data_pasien">
                            <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                            Data Pasien
                        </a>
                        <?php if ($_SESSION['role'] == "admin") { ?>
                            <div class="sb-sidenav-menu-heading">Settings</div>
                            <a class="nav-link" id="nav_users">
                                <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                                Pengguna
                            </a>
                        <?php } ?>
                    </div>
                </div>
                <div class="sb-sidenav-footer">
                    <div class="small">Logged in as:</div>
                    <strong><?php echo $_SESSION['user']; ?></strong>
                </div>
            </nav>
        </div>

        <div class="modal fade" id="modal_ubah_pass" tabindex="-1" aria-labelledby="ubahPassword" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Ubah Password</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form autocomplete="off" id="form_ubah_pass">
                            <input type="text" name="hid_user" class="form-control" id="hid_user" value="<?php echo $_SESSION['id_sess']; ?>" hidden>
                            <div class="input-group mb-3">
                                <div class="form-floating">
                                    <input id="pass_lama" type="password" class="form-control" name="pass_lama" placeholder="Password lama">
                                    <label for="pass_lama">Password lama</label>
                                </div>
                                <span class="input-group-text pl"><i class="fa fa-eye fa-eye-slash" id="pl"></i></span>
                            </div>
                            <div class="input-group mb-3">
                                <div class="form-floating">
                                    <input id="pass_baru" type="password" class="form-control" name="pass_baru" placeholder="Password baru">
                                    <label for="pass_baru">Password baru</label>
                                </div>
                                <span class="input-group-text pb"><i class="fa fa-eye fa-eye-slash" id="pb"></i></span>
                            </div>
                            <div class="input-group mb-3">
                                <div class="form-floating">
                                    <input id="pass_baru_repeat" type="password" class="form-control" name="pass_baru_repeat" placeholder="Ulangi password baru">
                                    <label for="pass_baru_repeat">Ulangi password baru</label>
                                </div>
                                <span class="input-group-text pbr"><i class="fa fa-eye fa-eye-slash" id="pbr"></i></span>
                            </div>
                            <div class="modal-footer">
                                <button type="button" id="btn_chg_pass" class="btn btn-danger form-control mb-0">Ubah Password</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-2">
                    <div id="content"></div>
                </div>
            </main>
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-center small">
                        <div class="text-muted">Copyright &copy; IT Rumah Sakit Tk. II dr. AK Gani</div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <script src="<?php echo BASE_URL; ?>/assets/vendor/jquery-3.7.1/jquery.min.js"></script>
    <script src="<?php echo BASE_URL; ?>/assets/vendor/bootstrap-5.2.3/bootstrap.bundle.min.js"></script>
    <script src="<?php echo BASE_URL; ?>/assets/vendor/chart-2.8.0/Chart.min.js"></script>
    <script src="<?php echo BASE_URL; ?>/assets/vendor/datatables-1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="<?php echo BASE_URL; ?>/assets/vendor/buttons-2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="<?php echo BASE_URL; ?>/assets/vendor/responsive-2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="<?php echo BASE_URL; ?>/assets/vendor/select-1.7.0/js/dataTables.select.min.js"></script>
    <script src="<?php echo BASE_URL; ?>/assets/vendor/select2-4.0.13/js/select2.min.js"></script>
    <script src="<?php echo BASE_URL; ?>/assets/vendor/sweetalert/sweetalert.min.js"></script>
    <script src="<?php echo BASE_URL; ?>/assets/js/custom.js"></script>
    <script src="<?php echo BASE_URL; ?>/assets/js/module.js"></script>
</body>

</html>