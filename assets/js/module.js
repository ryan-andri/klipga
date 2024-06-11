$(document).ready(function () {
    var today = new Date().toISOString().split("T")[0];

    // default
    $("#content").load("menu/mod_dashboard.html", function () {
        get_data_dashboard();
    });

    // Per modules
    // -----------
    $("#nav_dashboard").on("click", function () {
        $("#content").load("menu/mod_dashboard.html", function () {
            get_data_dashboard();
        });
    });

    function get_data_dashboard() {
        $("#loading").removeClass("d-none");

        $.ajax({
            url: "payload.php",
            type: "POST",
            dataType: "json",
            data: {
                action: "dashboard",
                today: today = today
            },
            success: function (response) {
                switch (response.status) {
                    case "success":
                        $("#record_sudah").text(response.record_sudah + " orang");
                        $("#record_belum").text(response.record_belum + " orang");
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

        const datatablesSimple = document.getElementById('datatablesSimple');
        if (datatablesSimple) {
            new DataTable(datatablesSimple);
        }
    }

    $("#nav_data_pasien").on("click", function () {
        $("#content").load("menu/mod_data_pasien.html", function () {
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
                                $("#tambahPasien").text("Form Tambah Data Pasien");
                                $("#simpan_pasien").text("Simpan").removeClass("disabled");
                                $("#form_pasien")[0].reset();
                                $("#input_nama_nonmtb").val("-");
                                $("#input_nama_nonmtb").prop('disabled', true);

                                // hidden value
                                $("#hid").val("1");
                                $("#action").val("insert");
                                $("#input_tgl_input").val(today);

                                // force disabled
                                $("#input_pmo_tbc3_fasyankes").val("04");
                                $("#input_pmo_tbc3_fasyankes").prop('readonly', true);
                                $("#input_pmo_tbc3_fasyankes").addClass("disabled");
                                $("#input_pmo_tbc3_kota").val("05");
                                $("#input_pmo_tbc3_kota").prop('readonly', true);
                                $("#input_pmo_tbc3_kota").addClass("disabled");

                                // show modal
                                $("#modal_pasien").modal("show");
                            },
                            enabled: true
                        },
                        {
                            text: "Edit",
                            action: function (e, dt, node, config) {
                                let data = dt.row({ selected: true }).data();

                                $("#tambahPasien").text("Form Edit Data Pasien");
                                $("#simpan_pasien").text("Update").removeClass("disabled");

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
                                $("#input_tgl_input").val(data.dp_tgl_input.toString());
                                // init pmo
                                $("#input_pmo_nama").val(data.pmo_nama.toString());
                                $("#input_pmo_alamat").val(data.pmo_alamat.toString());
                                $("#input_pmo_fasyankes").val(data.pmo_fasyankes.toString());
                                $("#input_pmo_kota").val(data.pmo_kota.toString());
                                $("#input_pmo_tbc3_fasyankes").val(data.pmo_tbc3_faskes.toString());
                                $("#input_pmo_tahun").val(data.pmo_tahun);
                                $("#input_pmo_provinsi").val(data.pmo_provinsi.toString());
                                $("#input_pmo_tbc3_kota").val(data.pmo_tbc3_kota.toString());
                                $("#input_pmo_telp").val(data.pmo_telpon.toString());

                                // force disabled
                                $("#input_pmo_tbc3_fasyankes").prop('readonly', true);
                                $("#input_pmo_tbc3_fasyankes").addClass("disabled");
                                $("#input_pmo_tbc3_kota").prop('readonly', true);
                                $("#input_pmo_tbc3_kota").addClass("disabled");

                                console.log(data.dp_tgl_input.toString());

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
                                $("#form_input_pasien")[0].reset();

                                // hidden value
                                $("#hid_pasien").val(data.dp_id.toString());
                                $("#action_input").val("input_pasien");

                                $("#ro_input_nama").val(data.dp_nama.toString());
                                $("#ro_input_panggilan").val(data.dp_panggilan.toString());
                                $("#ro_input_nik").val(data.dp_nik.toString());
                                $("#ro_input_bpjs").val(data.dp_bpjs.toString());
                                $("#ro_input_nama").prop("readonly", true);
                                $("#ro_input_panggilan").prop("readonly", true);
                                $("#ro_input_nik").prop("readonly", true);
                                $("#ro_input_bpjs").prop("readonly", true);

                                module_input_pasien();
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
                    case "pasien_lanjutan":
                        ele = "#form_input_pasien input, #form_input_pasien select";
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
                        + "dp_id=" + hid + "&"
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

            function module_input_pasien() {
                $("#simpan_input_pasien").text("Simpan data lanjutan").removeClass("disabled");
                $.ajax({
                    url: "payload.php",
                    type: "POST",
                    dataType: "json",
                    data: {
                        action: "search_pasien",
                        dp_id: $("#hid_pasien").val()
                    },
                    success: function (response) {
                        if (response["status"]) {
                            $("#input_tipe_diagnosis").val(response["result"]["dip_tipe_diagnosis"]);
                            $("#input_klasifikasi_anatomi").val(response["result"]["dip_klasifikasi_anatomi"]);
                            $("#input_ektraparu_lokasi").val(response["result"]["dip_ektraparu_lokasi"]);

                            if (response["result"]["dip_klasifikasi_anatomi"] == "TBC Ekstraparu") {
                                $("#input_ektraparu_lokasi").prop('disabled', false);
                            } else {
                                $("#input_ektraparu_lokasi").prop('disabled', true);
                            }

                            $("#input_klasifikasi_pengobatan_sebelumnya").val(response["result"]["dip_klasifikasi_pengobatan_sebelumnya"]);
                            $("#input_klasifikasi_icd10").val(response["result"]["dip_klasifikasi_icd10"]);
                            $("#input_klasifikasi_hiv").val(response["result"]["dip_klasifikasi_hiv"]);
                            $("#input_dirujuk_oleh").val(response["result"]["dip_dirujuk_oleh"]);
                            $("#input_dirujuk_oleh_isian").val(response["result"]["dip_dirujuk_oleh_isian"]);
                            $("#input_pindahan_nama_fasyankes").val(response["result"]["dip_pindahan_nama_fasyankes"]);
                            $("#input_pindahan_alamat_fasyankes").val(response["result"]["dip_pindahan_alamat_fasyankes"]);
                            $("#input_pindahan_kota").val(response["result"]["dip_pindahan_kota"]);
                            $("#input_pindahan_provinsi").val(response["result"]["dip_pindahan_provinsi"]);
                            $("#input_investigasi_kontak").val(response["result"]["dip_investigasi_kontak"]);
                            $("#input_jumlah_kontak_serumah").val(response["result"]["dip_jumlah_kontak_serumah"]);
                            $("#input_jumlah_kontak_investigasi").val(response["result"]["dip_jumlah_kontak_investigasi"]);

                            if ($("#input_investigasi_kontak").val() == "Tidak") {
                                $("#input_jumlah_kontak_serumah").prop("readonly", true);
                                $("#input_jumlah_kontak_serumah").addClass("disabled");
                                $("#input_jumlah_kontak_investigasi").prop("readonly", true);
                                $("#input_jumlah_kontak_investigasi").addClass("disabled");
                                $("#input_jumlah_kontak_tbc").prop("readonly", true);
                                $("#input_jumlah_kontak_tbc").addClass("disabled");
                            } else {
                                $("#input_jumlah_kontak_serumah").prop("readonly", false);
                                $("#input_jumlah_kontak_serumah").removeClass("disabled");
                                $("#input_jumlah_kontak_investigasi").prop("readonly", false);
                                $("#input_jumlah_kontak_investigasi").removeClass("disabled");
                                $("#input_jumlah_kontak_tbc").prop("readonly", false);
                                $("#input_jumlah_kontak_tbc").removeClass("disabled");
                            }

                            $("#input_jumlah_kontak_tbc").val(response["result"]["dip_jumlah_kontak_tbc"]);
                            $("#input_riwayat_dm").val(response["result"]["dip_riwayat_dm"]);
                            $("#input_tes_dm").val(response["result"]["dip_tes_dm"]);
                            $("#input_terapi_dm").val(response["result"]["dip_terapi_dm"]);
                        } else {
                            if ($("#input_investigasi_kontak").val() == "Tidak") {
                                $("#input_jumlah_kontak_serumah").val("-");
                                $("#input_jumlah_kontak_serumah").prop("readonly", true);
                                $("#input_jumlah_kontak_serumah").addClass("disabled");
                                $("#input_jumlah_kontak_investigasi").val("-");
                                $("#input_jumlah_kontak_investigasi").prop("readonly", true);
                                $("#input_jumlah_kontak_investigasi").addClass("disabled");
                                $("#input_jumlah_kontak_tbc").val("-");
                                $("#input_jumlah_kontak_tbc").prop("readonly", true);
                                $("#input_jumlah_kontak_tbc").addClass("disabled");
                            }
                        }
                    },
                    complete: function (response) {
                        $("#modal_input_pasien").modal("show");
                    }
                });
            }

            $("#simpan_input_pasien").on("click", function () {
                if (!validation("pasien_lanjutan")) {
                    alert("Bagian form tidak boleh ada yang kosong.");
                    return;
                }

                let df = $("#form_input_pasien").serializeArray();

                if ($("#input_klasifikasi_anatomi").val() == "TBC Paru") {
                    df.push({
                        name: "input_ektraparu_lokasi",
                        value: "-"
                    });
                }

                let action = $("#action_input").val().toString();
                let hid = $("#hid_pasien").val().toString();

                // lock button before send data
                $("#simpan_input_pasien").text("Menyimpan Data ...").addClass("disabled");

                $.ajax({
                    url: "payload.php",
                    type: "POST",
                    dataType: "json",
                    data: "action=" + action + "&"
                        + "dp_id=" + hid + "&"
                        + $.param(df),
                    complete: function () {
                        $("#simpan_input_pasien").text("Simpan data lanjutan").removeClass("disabled");
                    },
                    error: function (xhr, status, error) {
                        console.log(error);
                        $("#simpan_input_pasien").text("Simpan data lanjutan").removeClass("disabled");
                    },
                    success: function (response) {
                        switch (response) {
                            case "success":
                                $("#modal_input_pasien").modal("hide");
                                swal({
                                    text: "Data Berhasil disimpan!",
                                    icon: "success",
                                    button: false,
                                });
                                break;
                            case "updated":
                                $("#modal_input_pasien").modal("hide");
                                swal({
                                    text: "Data Berhasil diupdate!",
                                    icon: "success",
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

            $("#input_klasifikasi_anatomi").on("change", function () {
                if ($(this).val() == "TBC Ekstraparu") {
                    $("#input_ektraparu_lokasi").val("");
                    $("#input_ektraparu_lokasi").prop('disabled', false);
                } else {
                    $("#input_ektraparu_lokasi").val("-");
                    $("#input_ektraparu_lokasi").prop('disabled', true);
                }
            });

            $("#input_investigasi_kontak").on("change", function () {
                if ($(this).val() == "Tidak") {
                    $("#input_jumlah_kontak_serumah").val("-");
                    $("#input_jumlah_kontak_serumah").prop("readonly", true);
                    $("#input_jumlah_kontak_serumah").addClass("disabled");
                    $("#input_jumlah_kontak_investigasi").val("-");
                    $("#input_jumlah_kontak_investigasi").prop("readonly", true);
                    $("#input_jumlah_kontak_investigasi").addClass("disabled");
                    $("#input_jumlah_kontak_tbc").val("-");
                    $("#input_jumlah_kontak_tbc").prop("readonly", true);
                    $("#input_jumlah_kontak_tbc").addClass("disabled");
                } else {
                    $("#input_jumlah_kontak_serumah").val("");
                    $("#input_jumlah_kontak_serumah").prop("readonly", false);
                    $("#input_jumlah_kontak_serumah").removeClass("disabled");
                    $("#input_jumlah_kontak_investigasi").val("");
                    $("#input_jumlah_kontak_investigasi").prop("readonly", false);
                    $("#input_jumlah_kontak_investigasi").removeClass("disabled");
                    $("#input_jumlah_kontak_tbc").val("");
                    $("#input_jumlah_kontak_tbc").prop("readonly", false);
                    $("#input_jumlah_kontak_tbc").removeClass("disabled");
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

    // nav yang belum di input
    $("#nav_belum_input").on("click", function () {
        $("#content").load("menu/mod_data_pasien_belum_input.html", function () {
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
                            action: "load_pasien_belum_input",
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
                            text: "Input Data Pasien",
                            action: function (e, dt, node, config) {
                                let data = dt.row({ selected: true }).data();
                                $("#form_input_pasien")[0].reset();

                                // hidden value
                                $("#hid_pasien").val(data.dp_id.toString());
                                $("#action_input").val("input_pasien");

                                $("#ro_input_nama").val(data.dp_nama.toString());
                                $("#ro_input_panggilan").val(data.dp_panggilan.toString());
                                $("#ro_input_nik").val(data.dp_nik.toString());
                                $("#ro_input_bpjs").val(data.dp_bpjs.toString());
                                $("#ro_input_nama").prop("readonly", true);
                                $("#ro_input_panggilan").prop("readonly", true);
                                $("#ro_input_nik").prop("readonly", true);
                                $("#ro_input_bpjs").prop("readonly", true);

                                module_input_pasien();
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
                tabel_pasien.button(0).enable(selectedRows > 0);
            });

            function clearnbtn() {
                tabel_pasien.button(0).enable(false);
            }

            $("#input_tgl_filter").on("change", function () {
                tabel_pasien.clear();
                tabel_pasien.destroy();
                load_data($("#input_tgl_filter").val().toString());
                // force draw after re-init
                tabel_pasien.draw();
            });

            function validation(input) {
                var valid = true;
                var ele = "#form_input_pasien input, #form_input_pasien select";

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

            function module_input_pasien() {
                $("#simpan_input_pasien").text("Simpan data lanjutan").removeClass("disabled");
                $.ajax({
                    url: "payload.php",
                    type: "POST",
                    dataType: "json",
                    data: {
                        action: "search_pasien",
                        dp_id: $("#hid_pasien").val()
                    },
                    success: function (response) {
                        if (response["status"]) {
                            $("#input_tipe_diagnosis").val(response["result"]["dip_tipe_diagnosis"]);
                            $("#input_klasifikasi_anatomi").val(response["result"]["dip_klasifikasi_anatomi"]);
                            $("#input_ektraparu_lokasi").val(response["result"]["dip_ektraparu_lokasi"]);

                            if (response["result"]["dip_klasifikasi_anatomi"] == "TBC Ekstraparu") {
                                $("#input_ektraparu_lokasi").prop('disabled', false);
                            } else {
                                $("#input_ektraparu_lokasi").prop('disabled', true);
                            }

                            $("#input_klasifikasi_pengobatan_sebelumnya").val(response["result"]["dip_klasifikasi_pengobatan_sebelumnya"]);
                            $("#input_klasifikasi_icd10").val(response["result"]["dip_klasifikasi_icd10"]);
                            $("#input_klasifikasi_hiv").val(response["result"]["dip_klasifikasi_hiv"]);
                            $("#input_dirujuk_oleh").val(response["result"]["dip_dirujuk_oleh"]);
                            $("#input_dirujuk_oleh_isian").val(response["result"]["dip_dirujuk_oleh_isian"]);
                            $("#input_pindahan_nama_fasyankes").val(response["result"]["dip_pindahan_nama_fasyankes"]);
                            $("#input_pindahan_alamat_fasyankes").val(response["result"]["dip_pindahan_alamat_fasyankes"]);
                            $("#input_pindahan_kota").val(response["result"]["dip_pindahan_kota"]);
                            $("#input_pindahan_provinsi").val(response["result"]["dip_pindahan_provinsi"]);
                            $("#input_investigasi_kontak").val(response["result"]["dip_investigasi_kontak"]);
                            $("#input_jumlah_kontak_serumah").val(response["result"]["dip_jumlah_kontak_serumah"]);
                            $("#input_jumlah_kontak_investigasi").val(response["result"]["dip_jumlah_kontak_investigasi"]);
                            $("#input_jumlah_kontak_tbc").val(response["result"]["dip_jumlah_kontak_tbc"]);

                            if ($("#input_investigasi_kontak").val() == "Tidak") {
                                $("#input_jumlah_kontak_serumah").prop("readonly", true);
                                $("#input_jumlah_kontak_serumah").addClass("disabled");
                                $("#input_jumlah_kontak_investigasi").prop("readonly", true);
                                $("#input_jumlah_kontak_investigasi").addClass("disabled");
                                $("#input_jumlah_kontak_tbc").prop("readonly", true);
                                $("#input_jumlah_kontak_tbc").addClass("disabled");
                            } else {
                                $("#input_jumlah_kontak_serumah").val("");
                                $("#input_jumlah_kontak_serumah").prop("readonly", false);
                                $("#input_jumlah_kontak_serumah").removeClass("disabled");
                                $("#input_jumlah_kontak_investigasi").val("");
                                $("#input_jumlah_kontak_investigasi").prop("readonly", false);
                                $("#input_jumlah_kontak_investigasi").removeClass("disabled");
                                $("#input_jumlah_kontak_tbc").val("");
                                $("#input_jumlah_kontak_tbc").prop("readonly", false);
                                $("#input_jumlah_kontak_tbc").removeClass("disabled");
                            }

                            $("#input_riwayat_dm").val(response["result"]["dip_riwayat_dm"]);
                            $("#input_tes_dm").val(response["result"]["dip_tes_dm"]);
                            $("#input_terapi_dm").val(response["result"]["dip_terapi_dm"]);
                        } else {
                            if ($("#input_investigasi_kontak").val() == "Tidak") {
                                $("#input_jumlah_kontak_serumah").val("-");
                                $("#input_jumlah_kontak_serumah").prop("readonly", true);
                                $("#input_jumlah_kontak_serumah").addClass("disabled");
                                $("#input_jumlah_kontak_investigasi").val("-");
                                $("#input_jumlah_kontak_investigasi").prop("readonly", true);
                                $("#input_jumlah_kontak_investigasi").addClass("disabled");
                                $("#input_jumlah_kontak_tbc").val("-");
                                $("#input_jumlah_kontak_tbc").prop("readonly", true);
                                $("#input_jumlah_kontak_tbc").addClass("disabled");
                            }
                        }
                    },
                    complete: function (response) {
                        $("#modal_input_pasien").modal("show");
                    }
                });
            }

            $("#simpan_input_pasien").on("click", function () {
                if (!validation("pasien_lanjutan")) {
                    alert("Bagian form tidak boleh ada yang kosong.");
                    return;
                }

                let df = $("#form_input_pasien").serializeArray();

                if ($("#input_klasifikasi_anatomi").val() == "TBC Paru") {
                    df.push({
                        name: "input_ektraparu_lokasi",
                        value: "-"
                    });
                }

                let action = $("#action_input").val().toString();
                let hid = $("#hid_pasien").val().toString();

                // lock button before send data
                $("#simpan_input_pasien").text("Menyimpan Data ...").addClass("disabled");

                $.ajax({
                    url: "payload.php",
                    type: "POST",
                    dataType: "json",
                    data: "action=" + action + "&"
                        + "dp_id=" + hid + "&"
                        + $.param(df),
                    complete: function () {
                        $("#simpan_input_pasien").text("Simpan data lanjutan").removeClass("disabled");
                    },
                    error: function (xhr, status, error) {
                        console.log(error);
                        $("#simpan_input_pasien").text("Simpan data lanjutan").removeClass("disabled");
                    },
                    success: function (response) {
                        switch (response) {
                            case "success":
                                $("#modal_input_pasien").modal("hide");
                                swal({
                                    text: "Data Berhasil disimpan!",
                                    icon: "success",
                                    button: false,
                                });
                                break;
                            case "updated":
                                $("#modal_input_pasien").modal("hide");
                                swal({
                                    text: "Data Berhasil diupdate!",
                                    icon: "success",
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

            $("#input_klasifikasi_anatomi").on("change", function () {
                if ($(this).val() == "TBC Ekstraparu") {
                    $("#input_ektraparu_lokasi").val("");
                    $("#input_ektraparu_lokasi").prop('disabled', false);
                } else {
                    $("#input_ektraparu_lokasi").val("-");
                    $("#input_ektraparu_lokasi").prop('disabled', true);
                }
            });

            $("#input_investigasi_kontak").on("change", function () {
                if ($(this).val() == "Tidak") {
                    $("#input_jumlah_kontak_serumah").val("-");
                    $("#input_jumlah_kontak_serumah").prop("readonly", true);
                    $("#input_jumlah_kontak_serumah").addClass("disabled");
                    $("#input_jumlah_kontak_investigasi").val("-");
                    $("#input_jumlah_kontak_investigasi").prop("readonly", true);
                    $("#input_jumlah_kontak_investigasi").addClass("disabled");
                    $("#input_jumlah_kontak_tbc").val("-");
                    $("#input_jumlah_kontak_tbc").prop("readonly", true);
                    $("#input_jumlah_kontak_tbc").addClass("disabled");
                } else {
                    $("#input_jumlah_kontak_serumah").val("");
                    $("#input_jumlah_kontak_serumah").prop("readonly", false);
                    $("#input_jumlah_kontak_serumah").removeClass("disabled");
                    $("#input_jumlah_kontak_investigasi").val("");
                    $("#input_jumlah_kontak_investigasi").prop("readonly", false);
                    $("#input_jumlah_kontak_investigasi").removeClass("disabled");
                    $("#input_jumlah_kontak_tbc").val("");
                    $("#input_jumlah_kontak_tbc").prop("readonly", false);
                    $("#input_jumlah_kontak_tbc").removeClass("disabled");
                }
            });
        });
    });
});