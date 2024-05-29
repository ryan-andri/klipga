$(document).ready(function () {
    // default
    $("#content").load("menu/mod_dashboard.html", function () {
        $("#loading").removeClass("d-none");

        get_data_dashboard();

        const datatablesSimple = document.getElementById('datatablesSimple');
        if (datatablesSimple) {
            new DataTable(datatablesSimple);
        }
    });

    // Per modules
    // -----------
    $("#nav_dashboard").on("click", function () {
        $("#content").load("menu/mod_dashboard.html", function () {
            $("#loading").removeClass("d-none");

            get_data_dashboard();

            const datatablesSimple = document.getElementById('datatablesSimple');
            if (datatablesSimple) {
                new DataTable(datatablesSimple);
            }
        });
    });

    function get_data_dashboard() {
        $.ajax({
            url: "payload.php",
            type: "POST",
            dataType: "json",
            data: {
                action: "dashboard",
                today: today = new Date().toISOString().split("T")[0]
            },
            success: function (response) {
                switch (response.status) {
                    case "success":
                        $("#total_records").text(response.allrecords + " orang");
                        $("#today_record").text(response.todayrecords + " orang");
                        break;
                    case "failed":
                        console.log(response.messages);
                        break;
                }
            },
            complete: function () {
                $("#loading").addClass("d-none");
                $("#sub_content").removeClass("d-none");
            },
            error: function (xhr, status, error) {
                console.log(error);
                $("#loading").addClass("d-none");
            }
        });
    }

    $("#nav_data_pasien").on("click", function () {
        $("#content").load("menu/mod_data_pasien.html", function () {
            var today = new Date().toISOString().split("T")[0];
            var tabel_pasien = "";

            $("#input_tgl_filter").val(today);

            load_data(today);

            function load_data(fdate) {
                tabel_pasien = $("#tabel_pasien").DataTable({
                    dom: "Bfrtip",
                    order: [[0, "Asc"]],
                    processing: true,
                    serverSide: true,
                    select: true,
                    language: {
                        processing: "<div class='spinner-border'></div>",
                    },
                    // stateSave: true,
                    pageLength: 10,
                    ajax: {
                        url: "payload.php",
                        type: "POST",
                        dataType: "json",
                        cache: false,
                        data: {
                            action: "load_pasien",
                            filter_date: fdate
                        },
                        complete: function () {
                            clearnbtn();
                        },
                        error: function (xhr, status, error) {
                            console.log(error);
                            clearnbtn();
                        },
                    },
                    buttons: [
                        {
                            text: "Tambah Data",
                            action: function (e, dt, node, config) {
                                $("#simpan_pasien").text("Simpan").removeClass("disabled");
                                $("#form_pasien")[0].reset();
                                $("#input_nama_nonmtb").val("-");
                                $("#input_nama_nonmtb").prop('disabled', true);
                                $("#modal_pasien").modal("show");
                                // hidden value
                                $("#hid").val("1");
                                $("#action").val("insert");
                            },
                            enabled: true
                        },
                        {
                            text: "Edit",
                            action: function (e, dt, node, config) {
                                let data = dt.row({ selected: true }).data();

                                $("#form_pasien")[0].reset();
                                // hidden value
                                $("#hid").val(data.dp_id.toString());
                                $("#action").val("update");
                                // init value
                                $("#input_nama").val(data.dp_nama.toString());
                                $("#input_panggilan").val(data.dp_panggilan.toString());
                                $("#input_nik").val(data.dp_nik.toString());
                                $("#input_bpjs").val(data.dp_bpjs.toString());
                                $("#input_alamat").val(data.dp_alamat.toString());
                                $("#input_pekerjaan").val(data.dp_pekerjaan.toString());
                                $("#input_kelamin").val(data.dp_kelamin.toString());
                                $("#input_usia_subur").val(data.dp_usia_subur.toString());
                                $("#input_usia_subur").prop('disabled', (data.dp_kelamin.toString() == "Laki-Laki"));
                                $("#input_tgl_lahir").val(data.dp_tgl_lahir);
                                $("#input_umur").val(getAge(data.dp_tgl_lahir)[0]);
                                $("#input_umur_bulan").val(getAge(data.dp_tgl_lahir)[1]);
                                $("#input_berat_badan").val(data.dp_berat_badan.toString());
                                $("#input_tinggi_badan").val(data.dp_tinggi_badan.toString());
                                $("#input_imun_bcg").val(data.dp_imun_bcg.toString());
                                $("#input_skor_tb_anak").val(data.dp_skor_tb_anak.toString());
                                $("#input_nohp").val(data.dp_nohp.toString());
                                $("#input_petugas_kes").val(data.dp_petugas_kes.toString());
                                $("#input_uji_tbc").val(data.dp_uji_tbc.toString());
                                $("#input_date_toraks").val(data.dp_date_toraks);
                                $("#input_toraks_seri").val(data.dp_toraks_seri.toString());
                                $("#input_toraks_kesan").val(data.dp_toraks_kesan.toString());
                                $("#input_date_fnab").val(data.dp_date_fnab);
                                $("#input_hasil_fnab").val(data.dp_hasil_fnab.toString());
                                $("#input_uji_nondahak").val(data.dp_uji_nondahak.toString());
                                $("#input_nama_nonmtb").val(data.dp_nama_nonmtb.toString());
                                $("#input_nama_nonmtb").prop('disabled', (data.dp_uji_nondahak.toString() == "MTB"));
                                $("#input_tgl_input").val(data.dp_tgl_input);
                                
                                $("#modal_pasien").modal("show");
                            },
                            enabled: false
                        },
                        {
                            text: "Hapus",
                            action: function (e, dt, node, config) {
                                let data = dt.row({ selected: true }).data();
                                console.log(data);
                            },
                            enabled: false
                        },
                        {
                            text: "Input Data Pasien",
                            action: function (e, dt, node, config) {
                                let data = dt.row({ selected: true }).data();
                                $("#form_skd")[0].reset();
                                // hidden value
                                $("#skd_hid").val(data.id.toString());
                                // init Value
                                $("#skd_tgl_daftar").val(data.tanggal_daftar.toString());
                                $("#skd_tgl_daftar").prop("readonly", true);
                                $("#skd_tgl_daftar").addClass("disabled");
                                $("#skd_nama").val(data.nama.toString());
                                $("#skd_nama").prop("readonly", true);
                                $("#skd_nama").addClass("disabled");
                                $("#skd_tempat_lahir").val(data.tempat_lahir.toString());
                                $("#skd_tempat_lahir").prop("readonly", true);
                                $("#skd_tempat_lahir").addClass("disabled");
                                $("#skd_tgl_lahir").val(data.tanggal_lahir.toString());
                                $("#skd_tgl_lahir").prop("readonly", true);
                                $("#skd_tgl_lahir").addClass("disabled");
                                $("#skd_nohp").val(data.nohp.toString());
                                $("#skd_nohp").prop("readonly", true);
                                $("#skd_nohp").addClass("disabled");

                                $("#skd_bmi").prop("readonly", true);
                                $("#skd_bmi").addClass("disabled");

                                if (data.pembayaran_skd == 0) {
                                    $("#mask_status").removeClass("d-none");
                                    $("#mask_status").addClass("d-block");
                                    $("#simpan_skd").prop("disabled", true);
                                } else {
                                    $("#mask_status").removeClass("d-block");
                                    $("#mask_status").addClass("d-none");
                                    $("#simpan_skd").prop("disabled", false);
                                }

                                mod_skd();
                            },
                            enabled: false
                        },
                        {
                            text: "Refresh",
                            action: function (e, dt, node, config) {
                                tabel_pasien.ajax.reload(null, false);
                                clearnbtn();
                            },
                            enabled: true
                        }
                    ],
                    columns: [
                        {
                            data: "dp_id",
                            render: function (data, type, row, meta) {
                                return meta.row + meta.settings._iDisplayStart + 1;
                            }
                        },
                        {
                            data: "dp_nama",
                            orderable: false
                        },
                        {
                            data: "dp_nik",
                            orderable: false
                        },
                        {
                            data: "dp_tgl_lahir",
                            orderable: false
                        },
                        {
                            data: "dp_kelamin",
                            orderable: false
                        },
                        {
                            data: "dp_nohp",
                            orderable: false
                        },
                        {
                            data: "dp_tgl_input",
                            orderable: false
                        }
                    ],
                });
            }

            tabel_pasien.on("select deselect", function (e, dt, node, config) {
                let selectedRows = tabel_pasien.rows({ selected: true }).count();
                let res = dt.row({ selected: true }).data();
                tabel_pasien.button(1).enable(selectedRows > 0);
                tabel_pasien.button(2).enable(selectedRows > 0);
                tabel_pasien.button(3).enable(selectedRows > 0);
            });

            function clearnbtn() {
                for (var i = 1; i <= 3; i++) {
                    tabel_pasien.button(i).enable(false);
                }
            }

            $("#input_tgl_filter").on("change", function () {
                tabel_pasien.clear();
                tabel_pasien.destroy();
                load_data($("#input_tgl_filter").val().toString());
                // force draw after re-init
                tabel_pasien.draw();
            });

            function validation(input) {
                let ele = "empty";
                let valid = true;

                switch (input) {
                    case "pasien":
                        ele = "#form_pasien input, #form_pasien select";
                        break;
                    case "skd":
                        ele = "#form_skd input, #form_skd select";
                        break;
                }

                $(ele).each(function () {
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

            $("#simpan_pasien").on("click", function () {
                if (!validation("pasien")) {
                    alert("Bagian form tidak boleh ada yang kosong.");
                    return;
                }

                let df = $("#form_pasien").serializeArray();
                df.push({ name: "input_tgl_input", value: today });

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

                let action = $("#action").val().toString();
                let hid = $("#hid").val().toString();

                // lock button before send data
                $("#simpan_pasien").text("Menyimpan Data ...").addClass("disabled");

                $.ajax({
                    url: "payload.php",
                    type: "POST",
                    dataType: "json",
                    data: "action=" + action + "&"
                        + "id=" + hid + "&"
                        + $.param(df),
                    complete: function () {
                        $("#simpan_pasien").text("Simpan").removeClass("disabled");
                    },
                    error: function (xhr, status, error) {
                        console.log(error);
                        $("#simpan_pasien").text("Simpan").removeClass("disabled");
                    },
                    success: function (response) {
                        switch (response) {
                            case "success":
                                $("#modal_pasien").modal("hide");
                                swal({
                                    text: "Data Berhasil disimpan!",
                                    icon: "success",
                                    button: false,
                                });
                                break;
                            case "updated":
                                $("#modal_pasien").modal("hide");
                                swal({
                                    text: "Data Berhasil diupdate!",
                                    icon: "success",
                                    button: false,
                                });
                                break;
                            case "exist":
                                $("#modal_pasien").modal("hide");
                                swal({
                                    text: "Data sudah ada pada hari ini",
                                    icon: "info",
                                    button: false,
                                });
                                break;
                            case "failed":
                            case "error":
                                swal({
                                    text: "Data gagal disimpan!",
                                    icon: "error",
                                    button: false,
                                });
                                break;
                        }
                        tabel_pasien.ajax.reload(null, false);
                        clearnbtn();
                    }
                });
            });

            $("#input_tgl_lahir").on("change", function () {
                var date = getAge($("#input_tgl_lahir").val());
                $("#input_umur").val(date[0]);
                $("#input_umur_bulan").val(date[1]);
            });

            // Laki laki gak mungkin hamil!
            $("#input_kelamin").on("change", function () {
                if ($(this).val() == "Laki-Laki") {
                    $("#input_usia_subur").val("-");
                    $("#input_usia_subur").prop('disabled', true);
                } else {
                    $("#input_usia_subur").prop('disabled', false);
                }
            });

            $("#input_uji_nondahak").on("change", function () {
                if ($(this).val() == "Bukan MTB") {
                    $("#input_nama_nonmtb").val("");
                    $("#input_nama_nonmtb").prop('disabled', false);
                } else {
                    $("#input_nama_nonmtb").val("-");
                    $("#input_nama_nonmtb").prop('disabled', true);
                }
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
    });
});