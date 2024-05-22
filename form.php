<?php
session_start();
require('configs/config.php');
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

    <title>TBC Dashboard</title>

    <link href="<?php echo BASE_URL; ?>/assets/css/styles.css" rel="stylesheet" />
    <link href="<?php echo BASE_URL; ?>/assets/css/custom.css" rel="stylesheet" />
    <script src="<?php echo BASE_URL; ?>/assets/vendor/fontawesome-6.3.0/all.js"></script>

    <style>
        ::-webkit-scrollbar {
            display: none;
        }
    </style>
</head>

<body class="sb-nav-fixed">

    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-2">
                <div class="text-center mt-2 mb-4">
                    <h3>Form Pasien TBC</h3>
                </div>
                <div class="card p-3 mb-4" style="background-color: #ff000000;">
                    <form id="form_peserta">
                        <div class=" row">
                            <!-- Col 1  -->
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="text" name="input_nama" class="form-control" id="input_nik" placeholder="Nama Pasien">
                                    <label for="input_nama">Nama Pasien TBC</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input class="form-control" id="input_nama_panggilan" type="text" name="input_nama_panggilan" placeholder="Nama Lengkap" />
                                    <label for="input_nama_panggilan">Nama Panggilan</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input class="form-control" id="input_nik" type="text" name="input_nik" placeholder="input_nik" />
                                    <label for="input_nik">NIK</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input class="form-control" id="input_bpjs" type="text" name="input_bpjs" placeholder="NIK" />
                                    <label for="input_bpjs">No. BPJS</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="text" name="input_nohp" class="form-control" id="input_nohp" placeholder="No. Handphone">
                                    <label for="input_nohp">No. Handphone</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="text" name="input_alamat" class="form-control" id="input_alamat" placeholder="Alamat">
                                    <label for="input_alamat">Alamat Lengkap</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <select name="input_jns_kelamin" class="form-select" id="input_jns_kelamin" placeholder="Jenis Kelamin">
                                        <option value="" selected disabled>-</option>
                                        <option value="Laki-Laki">Laki-Laki</option>
                                        <option value="Perempuan">Perempuan</option>
                                    </select>
                                    <label for="input_jns_kelamin">Jenis Kelamin</label>
                                </div>

                                <div class="form-floating mb-3">
                                    <input class="form-control" id="input_tgl_lahir" type="date" name="input_tgl_lahir" placeholder="Tanggal Lahir" />
                                    <label for="input_tgl_lahir">Tanggal Lahir</label>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-floating mb-3">
                                            <input type="text" name="input_umur" class="form-control" id="input_umur" placeholder="Umur" disabled>
                                            <label for="input_umur">Umur</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating mb-3">
                                            <input type="text" name="input_umur_bulan" class="form-control" id="input_umur_bulan" placeholder="Bulan" disabled>
                                            <label for="input_umur_bulan">Bulan</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Col 2  -->
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="text" name="input_alamat" class="form-control" id="input_alamat" placeholder="Alamat">
                                    <label for="input_alamat">Alamat</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <select name="input_jns_kelamin" class="form-select" id="input_jns_kelamin" placeholder="Jenis Kelamin">
                                        <option value="" selected disabled>-</option>
                                        <option value="Laki-Laki">Laki-Laki</option>
                                        <option value="Perempuan">Perempuan</option>
                                    </select>
                                    <label for="input_jns_kelamin">Jenis Kelamin</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <select name="input_sts_nikah" class="form-select" id="input_sts_nikah" placeholder="Status Pernikahan">
                                        <option value="" selected disabled>-</option>
                                        <option value="Belum Menikah">Belum Menikah</option>
                                        <option value="Menikah">Menikah</option>
                                        <option value="Cerai">Cerai</option>
                                    </select>
                                    <label for="input_sts_nikah">Status Pernikahan</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="text" name="input_pekerjaan" class="form-control" id="input_pekerjaan" placeholder="Pekerjaan">
                                    <label for="input_pekerjaan">Pekerjaan</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <select name="input_pendidikan" class="form-select" id="input_pendidikan" placeholder="Pendidikan">
                                        <option value="" selected disabled>?</option>
                                        <option value="-">-</option>
                                        <option value="S3">S3</option>
                                        <option value="S2">S2</option>
                                        <option value="Diploma/S1">Diploma/S1</option>
                                        <option value="SMA">SMA</option>
                                        <option value="SMP">SMP</option>
                                        <option value="SD">SD</option>
                                    </select>
                                    <label for="input_pendidikan">Pendidikan</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <select name="input_gol_darah" class="form-select" id="input_gol_darah" placeholder="Golongan Darah">
                                        <option value="" selected disabled>?</option>
                                        <option value="-">-</option>
                                        <option value="A">A</option>
                                        <option value="B">B</option>
                                        <option value="AB">AB</option>
                                        <option value="O">O</option>
                                    </select>
                                    <label for="input_gol_darah">Golongan Darah</label>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" id="simpan_pasien" class="btn btn-dark form-control">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
        <footer class="py-2 mt-auto">
            <div class="d-flex justify-content-center small">
                <div>Copyright &copy; IT Rumah Sakit Tk. II dr. AK Gani</div>
            </div>
        </footer>
    </div>
    <script src="<?php echo BASE_URL; ?>/assets/vendor/jquery-3.7.1/jquery.min.js"></script>
    <script src="<?php echo BASE_URL; ?>/assets/vendor/bootstrap-5.2.3/bootstrap.bundle.min.js"></script>
    <script src="<?php echo BASE_URL; ?>/assets/vendor/sweetalert/sweetalert.min.js"></script>

    <script>
        $(document).ready(function() {
            $("#input_tgl_lahir").on("change", function() {
                date = getAge($("#input_tgl_lahir").val());
                $("#input_umur").val(date[0]);
                $("#input_umur_bulan").val(date[1]);
            });

            $("#simpan_pasien").on("click", function() {
                swal({
                    text: "Data Berhasil disimpan!",
                    icon: "success",
                    button: false,
                });
            });

            function getAge(date) {
                var now = new Date();
                var entry = new Date(date);
                var year = now.getFullYear() - entry.getFullYear();
                if (now.getMonth() >= entry.getMonth()) {
                    var month = now.getMonth() - entry.getMonth();
                } else {
                    year--;
                    var month = 12 + now.getMonth() - entry.getMonth();
                }
                return new Array(year + " Tahun", month + " Bulan");
            }
        });
    </script>
</body>

</html>