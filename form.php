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
                    <form autocomplete="off" id="form_pasien">
                        <div class="row">
                            <!-- DATA PASIEN -->
                            <div class="d-flex justify-content-center">
                                <div class="text-center form-control bg-dark mb-3 p-2">
                                    <strong class="text-light">DATA PASIEN</strong>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="text" name="input_nama" class="form-control" id="input_nama" placeholder="Nama Pasien">
                                    <label for="input_nama">Nama Pasien TBC</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input class="form-control" id="input_panggilan" type="text" name="input_panggilan" placeholder="Nama Panggilan" />
                                    <label for="input_panggilan">Nama Panggilan</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input class="form-control" id="input_nik" type="text" name="input_nik" placeholder="NIK" />
                                    <label for="input_nik">NIK</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input class="form-control" id="input_bpjs" type="text" name="input_bpjs" placeholder="No. BPJS" />
                                    <label for="input_bpjs">No. BPJS</label>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-floating mb-3">
                                            <select name="input_kelamin" class="form-select" id="input_kelamin" placeholder="Jenis Kelamin">
                                                <option value="-" selected disabled>-</option>
                                                <option value="Laki-Laki">Laki-Laki</option>
                                                <option value="Perempuan">Perempuan</option>
                                            </select>
                                            <label for="input_kelamin">Jenis Kelamin</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating mb-3">
                                            <select name="input_usia_subur" class="form-select" id="input_usia_subur" placeholder="Usia Subur (Jika Perempuan)">
                                                <option value="-" selected>-</option>
                                                <option value="Hamil">Hamil</option>
                                                <option value="Tidak Hamil">Tidak Hamil</option>
                                            </select>
                                            <label for="input_usia_subur">Usia Subur (Jika Perempuan)</label>
                                        </div>
                                    </div>
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
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-floating mb-3">
                                            <input type="text" name="input_berat_badan" class="form-control" id="input_berat_badan" placeholder="Berat Badan (KG)">
                                            <label for="input_berat_badan">Berat Badan (kg)</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating mb-3">
                                            <input type="text" name="input_tinggi_badan" class="form-control" id="input_tinggi_badan" placeholder="Tinggi Badan (cm)">
                                            <label for="input_tinggi_badan">Tinggi Badan (cm)</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="text" name="input_alamat" class="form-control" id="input_alamat" placeholder="Alamat">
                                    <label for="input_alamat">Alamat Lengkap</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="text" name="input_pekerjaan" class="form-control" id="input_pekerjaan" placeholder="Pekerjaan">
                                    <label for="input_pekerjaan">Pekerjaan</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <select name="input_imun_bcg" class="form-select" id="input_imun_bcg" placeholder="Imunisasi BCG">
                                        <option value="Tidak Ada">Tidak Ada</option>
                                        <option value="Ada">Ada</option>
                                    </select>
                                    <label for="input_imun_bcg">Imunisasi BCG</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="text" name="input_nohp" class="form-control" id="input_nohp" placeholder="No. Handphone">
                                    <label for="input_nohp">No. Handphone</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="text" name="input_skor_tb_anak" class="form-control" id="input_skor_tb_anak" placeholder="Skor TB Anak">
                                    <label for="input_skor_tb_anak">Skor TB Anak</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <select name="input_petugas_kes" class="form-select" id="input_petugas_kes" placeholder="Petugas Kesehatan">
                                        <option value="Tidak">Tidak</option>
                                        <option value="Ya">Ya</option>
                                    </select>
                                    <label for="input_petugas_kes">Petugas Kesehatan</label>
                                </div>
                            </div>

                            <!-- DATA LAINNYA -->
                            <div class="d-flex justify-content-center">
                                <div class="text-center form-control bg-dark mb-3 p-2">
                                    <strong class="text-light">DATA PEMERIKSAAN LAIN - LAIN</strong>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="text" name="input_uji_tbc" class="form-control" id="input_uji_tbc" placeholder="Uji Tuberkulin">
                                    <label for="input_uji_tbc">Uji Tuberkulin - mm (Indurasi Bukan eritema))</label>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-floating mb-3">
                                            <input type="date" name="input_date_toraks" class="form-control" id="input_date_toraks" placeholder="Tanggal Foto Toraks">
                                            <label for="input_date_toraks">Tanggal Foto Toraks</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating mb-3">
                                            <input type="text" name="input_toraks_seri" class="form-control" id="input_toraks_seri" placeholder="No. Seri Foto toraks">
                                            <label for="input_toraks_seri">No. Seri Foto Toraks</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="text" name="input_toraks_kesan" class="form-control" id="input_toraks_kesan" placeholder="Kesan Foto Toraks">
                                    <label for="input_toraks_kesan">Kesan Foto Toraks</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-floating mb-3">
                                            <input type="date" name="input_date_fnab" class="form-control" id="input_date_fnab" placeholder="Tanggal Biopsi Jarum halus (FNAB)">
                                            <label for="input_date_fnab">Tanggal Biopsi Jarum halus (FNAB)</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating mb-3">
                                            <select name="input_hasil_fnab" class="form-select" id="input_hasil_fnab" placeholder="Hasil Biopsi Jarum halus (FNAB)">
                                                <option value="Tidak" selected>Tidak</option>
                                                <option value="Ya">Ya</option>
                                            </select>
                                            <label for="input_hasil_fnab">Hasil Biopsi Jarum halus (FNAB)</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-floating mb-3">
                                    <select name="input_uji_nondahak" class="form-select" id="input_uji_nondahak" placeholder="Hasil Contoh Uji selain dahak">
                                        <option value="MTB" selected>MTB</option>
                                        <option value="Bukan MTB">Bukan MTB</option>
                                    </select>
                                    <label for="input_uji_nondahak">Hasil Contoh Uji selain dahak</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="text" name="input_nama_nonmtb" class="form-control" id="input_nama_nonmtb" placeholder="Jika Bukan MTB, sebutkan">
                                    <label for="input_nama_nonmtb">Jika Bukan MTB, sebutkan</label>
                                </div>
                            </div>
                            <!-- DATA PMO -->
                            <div class="d-flex justify-content-center">
                                <div class="text-center form-control bg-dark mb-3 p-2">
                                    <strong class="text-light">DATA PMO</strong>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-floating mb-3">
                                            <input type="text" name="input_pmo_nama" class="form-control" id="input_pmo_nama" placeholder="Nama PMO">
                                            <label for="input_pmo_nama">Nama PMO</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating mb-3">
                                            <input type="text" name="input_pmo_telp" class="form-control" id="input_pmo_telp" placeholder="No. Telp/HP">
                                            <label for="input_pmo_telp">No. Telp/HP</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="text" name="input_pmo_alamat" class="form-control" id="input_pmo_alamat" placeholder="Alamat PMO">
                                    <label for="input_pmo_alamat">Alamat PMO</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="text" name="input_pmo_fasyankes" class="form-control" id="input_pmo_fasyankes" placeholder="Nama Fasyankes">
                                    <label for="input_pmo_fasyankes">Nama Fasyankes</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="text" name="input_pmo_kota" class="form-control" id="input_pmo_kota" placeholder="Kab/Kota">
                                    <label for="input_pmo_kota">Kab/Kota</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="text" name="input_pmo_tbc3_fasyankes" class="form-control" id="input_pmo_tbc3_fasyankes" placeholder="No. Reg TBC.03 Fasyankes">
                                    <label for="input_pmo_tbc3_fasyankes">No. Reg TBC.03 Fasyankes</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="number" min="0" max="2099" name="input_pmo_tahun" class="form-control" id="input_pmo_tahun" placeholder="Tahun">
                                    <label for="input_pmo_tahun">Tahun</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="text" name="input_pmo_provinsi" class="form-control" id="input_pmo_provinsi" placeholder="Provinsi">
                                    <label for="input_pmo_provinsi">Provinsi</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="text" name="input_pmo_tbc3_kota" class="form-control" id="input_pmo_tbc3_kota" placeholder="No. Reg TBC.03 Kab/Kota">
                                    <label for="input_pmo_tbc3_kota">No. Reg TBC.03 Kab/Kota</label>
                                </div>
                            </div>
                        </div>
                        <button type="button" id="simpan_pasien" class="btn btn-primary form-control mb-0">Simpan</button>
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
            $("#input_nama_nonmtb").val("-");
            $("#input_nama_nonmtb").prop('disabled', true);
            $("#input_pmo_tbc3_fasyankes").val("04");
            $("#input_pmo_tbc3_fasyankes").prop('readonly', true);
            $("#input_pmo_tbc3_fasyankes").addClass("disabled");
            $("#input_pmo_tbc3_kota").val("05");
            $("#input_pmo_tbc3_kota").prop('readonly', true);
            $("#input_pmo_tbc3_kota").addClass("disabled");

            $("#input_tgl_lahir").on("change", function() {
                date = getAge($("#input_tgl_lahir").val());
                $("#input_umur").val(date[0]);
                $("#input_umur_bulan").val(date[1]);
            });

            function validation(input) {
                let ele = "empty";
                let valid = true;

                switch (input) {
                    case "pasien":
                        ele = "#form_pasien input, #form_pasien select";
                        break;
                }

                $(ele).each(function() {
                    if ($.trim($(this).val()).length == 0) {
                        $(this).addClass("error");
                        valid = false;
                        $(this).focus();
                    } else {
                        $(this).removeClass("error");
                    }
                });
                return valid;
            }

            // Laki laki gak mungkin hamil!
            $("#input_kelamin").on("change", function() {
                if ($(this).val() == "Laki-Laki") {
                    $("#input_usia_subur").val("-");
                    $("#input_usia_subur").prop('disabled', true);
                } else {
                    $("#input_usia_subur").prop('disabled', false);
                }
            });

            $("#input_uji_nondahak").on("change", function() {
                if ($(this).val() == "Bukan MTB") {
                    $("#input_nama_nonmtb").val("");
                    $("#input_nama_nonmtb").prop('disabled', false);
                } else {
                    $("#input_nama_nonmtb").val("-");
                    $("#input_nama_nonmtb").prop('disabled', true);
                }
            });

            $("#simpan_pasien").on("click", function() {
                if (!validation("pasien")) {
                    alert("Bagian form tidak boleh ada yang kosong.");
                    return;
                }

                let df = $("#form_pasien").serializeArray();
                df.push({
                    name: "input_tgl_input",
                    value: new Date().toISOString().split("T")[0]
                });

                // force to - value (disabled element)
                if ($("#input_kelamin").val() == "Laki-Laki") {
                    df.push({
                        name: "input_usia_subur",
                        value: "-"
                    });
                }

                if ($("#input_uji_nondahak").val() != "Bukan MTB") {
                    df.push({
                        name: "input_nama_nonmtb",
                        value: "-"
                    });
                }

                // lock button before send data
                $("#simpan_pasien").text("Menyimpan Data ...").addClass("disabled");

                $.ajax({
                    url: "payload",
                    type: "POST",
                    dataType: "json",
                    data: "action=insert&" + $.param(df),
                    complete: function() {
                        $("#simpan_pasien").text("Simpan").removeClass("disabled");
                    },
                    error: function(xhr, status, error) {
                        console.log(error);
                        $("#simpan_pasien").text("Simpan").removeClass("disabled");
                    },
                    success: function(response) {
                        switch (response) {
                            case "success":
                                swal({
                                    text: "Data Berhasil disimpan!",
                                    icon: "success",
                                    button: true,
                                });
                                $("#form_pasien")[0].reset();
                                break;
                            case "exist":
                                swal({
                                    text: "Data sudah ada pada hari ini!",
                                    icon: "info",
                                    button: true,
                                });
                                $("#form_pasien")[0].reset();
                                break;
                            case "failed":
                            case "error":
                                swal({
                                    text: "Data gagal disimpan!",
                                    icon: "error",
                                    button: false,
                                });
                                break;
                            default:
                                break;
                        }
                    }
                });
            });

            function getAge(date) {
                if (date == "") return new Array("", "");
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