$(document).ready(function () {
    // default
    $("#content").load("menu/mod_dashboard.html", function () {
        const datatablesSimple = document.getElementById('datatablesSimple');
        if (datatablesSimple) {
            new DataTable(datatablesSimple);
        }
    });

    // Per modules
    // -----------
    $("#nav_dashboard").on("click", function () {
        $("#content").load("menu/mod_dashboard.html", function () {
            const datatablesSimple = document.getElementById('datatablesSimple');
            if (datatablesSimple) {
                new DataTable(datatablesSimple);
            }
        });
    });

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
                    stateSave: true,
                    ajax: {
                        url: "payload.php",
                        type: "POST",
                        dataType: "json",
                        cache: false,
                        data: {
                            action: "load_pasien",
                            filter_date: fdate
                        },
                        // always clear button
                        complete: function () {
                            clearnbtn();
                        },
                        error: function () {
                            clearnbtn();
                        }
                    },
                    buttons: [
                        {
                            text: "Tambah Data",
                            action: function (e, dt, node, config) {
                                $("#simpan_pasien").text("Simpan").removeClass("disabled");
                                $("#form_pasien")[0].reset();
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
                                // hidden value
                                $("#hid").val(data.id.toString());
                                $("#action").val("update");
                                // init value
                                $("#input_tgl_daftar").val(data.tanggal_daftar.toString());
                                $("#input_tgl_daftar").prop("readonly", true);
                                $("#input_nik").val(data.nik.toString());
                                $("#input_nama").val(data.nama.toString());
                                $("#input_tempat_lahir").val(data.tempat_lahir.toString());
                                $("#input_tgl_lahir").val(data.tanggal_lahir.toString());
                                $("#input_nohp").val(data.nohp.toString());
                                $("#input_alamat").val(data.alamat.toString());
                                $("#input_jns_kelamin").val(data.jenis_kelamin.toString()).change();
                                $("#input_sts_nikah").val(data.status_pernikahan.toString()).change();
                                $("#input_pekerjaan").val(data.pekerjaan.toString());
                                $("#input_pendidikan").val(data.pendidikan.toString()).change();
                                $("#input_gol_darah").val(data.golongan_darah.toString()).change();
                                $("#status_skd").prop("checked", data.status_skd.toString() == 1 ? true : false);
                                $("#status_rohani").prop("checked", data.status_rohani.toString() == 1 ? true : false);
                                $("#status_skbn").prop("checked", data.status_skbn.toString() == 1 ? true : false);
                                $("#modal_peserta").modal("show");
                            },
                            enabled: false
                        },
                        {
                            text: "Hapus",
                            action: function (e, dt, node, config) {
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
                                tabel_pasien.ajax.reload();
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
                            data: "dp_tgl_lahir",
                            orderable: false
                        },
                        {
                            data: "dp_nik",
                            orderable: false
                        },
                        {
                            data: "dp_nohp",
                            orderable: false
                        },
                        {
                            data: "dp_kelamin",
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
                    alert("Bagian form tidak boleh ada yang kosong.")
                    return;
                }

                let df = $("#form_pasien").serializeArray();
                df.push({ name: "input_tgl_input", value: today });

                let action = $("#action").val().toString();
                let hid = $("#hid").val().toString();

                // lock button before send data
                $(this).text("Menyimpan Data ...").addClass("disabled");

                $.ajax({
                    url: "payload.php",
                    type: "POST",
                    dataType: "json",
                    data: "action=" + action + "&"
                        + "id=" + hid + "&"
                        + $.param(df),
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
                                $(this).text("Simpan").removeClass("disabled");
                                swal({
                                    text: "Data gagal disimpan!",
                                    icon: "error",
                                    button: false,
                                });
                                break;
                        }
                        tabel_pasien.ajax.reload();
                        clearnbtn();
                    }
                });
            });

            $("#input_tgl_lahir").on("change", function () {
                date = getAge($("#input_tgl_lahir").val());
                $("#input_umur").val(date[0]);
                $("#input_umur_bulan").val(date[1]);
            });

            function getAge(date) {
                if (date == "") return;
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