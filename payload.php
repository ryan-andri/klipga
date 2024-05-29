<?php
session_start();
require_once('configs/config.php');

$cmd = !empty($_POST["action"]) ? $_POST["action"] : '';

$db = DBConnection::getInstance();

switch ($cmd) {
    case 'insert':
    case 'update':
        try {
            $query = "SELECT dp_nik, dp_tgl_input FROM data_pasien WHERE dp_nik ='" . $_POST['input_nik'] . "' AND dp_tgl_input = '" . $_POST['input_tgl_input'] . "'";
            $stmt = $db->prepare($query);
            $stmt->execute();
            $result = $stmt->fetch();
            $indexed = [
                htmlspecialchars($_POST['input_nama']),
                htmlspecialchars($_POST['input_panggilan']),
                htmlspecialchars($_POST['input_nik']),
                htmlspecialchars($_POST['input_bpjs']),
                htmlspecialchars($_POST['input_alamat']),
                htmlspecialchars($_POST['input_pekerjaan']),
                htmlspecialchars($_POST['input_kelamin']),
                htmlspecialchars($_POST['input_usia_subur']),
                htmlspecialchars($_POST['input_tgl_lahir']),
                htmlspecialchars($_POST['input_berat_badan']),
                htmlspecialchars($_POST['input_tinggi_badan']),
                htmlspecialchars($_POST['input_imun_bcg']),
                htmlspecialchars($_POST['input_skor_tb_anak']),
                htmlspecialchars($_POST['input_nohp']),
                htmlspecialchars($_POST['input_petugas_kes']),
                htmlspecialchars($_POST['input_uji_tbc']),
                htmlspecialchars($_POST['input_date_toraks']),
                htmlspecialchars($_POST['input_toraks_seri']),
                htmlspecialchars($_POST['input_toraks_kesan']),
                htmlspecialchars($_POST['input_date_fnab']),
                htmlspecialchars($_POST['input_hasil_fnab']),
                htmlspecialchars($_POST['input_uji_nondahak']),
                htmlspecialchars($_POST['input_nama_nonmtb']),
                htmlspecialchars($_POST['input_tgl_input'])
            ];

            sleep(1);

            if ($result) {
                if ($_POST["action"] == "update") {
                    $query = "UPDATE data_pasien SET dp_nama=?, dp_panggilan=?, dp_nik=?, dp_bpjs=?, dp_alamat=?, dp_pekerjaan=?, dp_kelamin=?, dp_usia_subur=?, dp_tgl_lahir=?, dp_berat_badan=?, dp_tinggi_badan=?, dp_imun_bcg=?, dp_skor_tb_anak=?, dp_nohp=?, dp_petugas_kes=?, dp_uji_tbc=?, dp_date_toraks=?, dp_toraks_seri=?, dp_toraks_kesan=?, dp_date_fnab=?, dp_hasil_fnab=?, dp_uji_nondahak=?, dp_nama_nonmtb=?, dp_tgl_input=? WHERE dp_id=" . $_POST['dp_id'];
                    $stmt = $db->prepare($query);
                    $res = $stmt->execute($indexed);
                    if ($res) {
                        $dt_pmo = [
                            htmlspecialchars($_POST['input_pmo_nama']),
                            htmlspecialchars($_POST['input_pmo_telp']),
                            htmlspecialchars($_POST['input_pmo_alamat']),
                            htmlspecialchars($_POST['input_pmo_fasyankes']),
                            htmlspecialchars($_POST['input_pmo_kota']),
                            htmlspecialchars($_POST['input_pmo_tbc3_fasyankes']),
                            htmlspecialchars($_POST['input_pmo_tahun']),
                            htmlspecialchars($_POST['input_pmo_provinsi']),
                            htmlspecialchars($_POST['input_pmo_tbc3_kota'])
                        ];
                        $query = "UPDATE data_pmo SET pmo_nama=?, pmo_alamat=?, pmo_fasyankes=?, pmo_kota=?, pmo_tbc3_faskes=?, pmo_tahun=?, pmo_provinsi=?, pmo_tbc3_kota=?, pmo_telpon=? WHERE pmo_id=" . $_POST['pmo_id'];
                        $stmt = $db->prepare($query);
                        $pmo = $stmt->execute($dt_pmo);
                        echo json_encode($pmo ? "success" : "failed");
                    } else {
                        echo json_encode("failed");
                    }
                } else {
                    echo json_encode("exist");
                }
            } else {
                $query = "INSERT INTO data_pasien (dp_nama, dp_panggilan, dp_nik, dp_bpjs, dp_alamat, dp_pekerjaan, dp_kelamin, dp_usia_subur, dp_tgl_lahir, dp_berat_badan, dp_tinggi_badan, dp_imun_bcg, dp_skor_tb_anak, dp_nohp, dp_petugas_kes, dp_uji_tbc, dp_date_toraks, dp_toraks_seri, dp_toraks_kesan, dp_date_fnab, dp_hasil_fnab, dp_uji_nondahak, dp_nama_nonmtb, dp_tgl_input) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
                $stmt = $db->prepare($query);
                $res = $stmt->execute($indexed);
                if ($res) {
                    $dt_pmo = [
                        htmlspecialchars($db->lastInsertId()),
                        htmlspecialchars($_POST['input_pmo_nama']),
                        htmlspecialchars($_POST['input_pmo_alamat']),
                        htmlspecialchars($_POST['input_pmo_fasyankes']),
                        htmlspecialchars($_POST['input_pmo_kota']),
                        htmlspecialchars($_POST['input_pmo_tbc3_fasyankes']),
                        htmlspecialchars($_POST['input_pmo_tahun']),
                        htmlspecialchars($_POST['input_pmo_provinsi']),
                        htmlspecialchars($_POST['input_pmo_tbc3_kota']),
                        htmlspecialchars($_POST['input_pmo_telp'])
                    ];
                    $query = "INSERT INTO data_pmo (dp_id, pmo_nama, pmo_alamat, pmo_fasyankes, pmo_kota, pmo_tbc3_faskes, pmo_tahun, pmo_provinsi, pmo_tbc3_kota, pmo_telpon) VALUES (?,?,?,?,?,?,?,?,?,?)";
                    $stmt = $db->prepare($query);
                    $pmo = $stmt->execute($dt_pmo);
                    echo json_encode($pmo ? "success" : "failed");
                } else {
                    echo json_encode("failed");
                }
            }
        } catch (PDOException $e) {
            echo json_encode("error");
        }
        break;
    case 'load_pasien':
        try {
            $draw = $_POST['draw'];
            $rows = $_POST['start'];
            $rowperpage = $_POST['length'];
            $columnIndex = $_POST['order'][0]['column'];
            $columnName = $_POST['columns'][$columnIndex]['data'];
            $columnSortOrder = $_POST['order'][0]['dir'];
            $searchValue = $_POST['search']['value'];
            $filter_date = $_POST['filter_date'];

            $stmt = $db->prepare("SELECT COUNT(*) AS allcount FROM data_pasien WHERE data_pasien.dp_status=1 ");
            $stmt->execute();
            $records = $stmt->fetch();
            $totalRecords = $records['allcount'];

            $date_filter = " ";
            if (!empty($filter_date)) {
                $date_filter = "AND data_pasien.dp_tgl_input = '" . $filter_date . "' ";
            }

            $searchArray = array();
            $searchQuery = " ";
            if (!empty($searchValue)) {
                $searchQuery = "AND (data_pasien.dp_nama LIKE :dp_nama OR data_pasien.dp_nik LIKE :dp_nik
                    OR data_pasien.dp_panggilan LIKE :dp_panggilan OR data_pasien.dp_nohp LIKE :dp_nohp
                    OR data_pasien.dp_kelamin LIKE :dp_kelamin OR data_pasien.dp_bpjs LIKE :dp_bpjs) ";
                $searchArray = array(
                    'dp_nama' => "%$searchValue%",
                    'dp_nik' => "%$searchValue%",
                    'dp_panggilan' => "%$searchValue%",
                    'dp_nohp' => "%$searchValue%",
                    'dp_kelamin' => "%$searchValue%",
                    'dp_bpjs' => "%$searchValue%"
                );
            }

            $final_filter = " 1 AND data_pasien.dp_status=1 " . $date_filter . $searchQuery;

            // usleep(200000);

            $stmt = $db->prepare("SELECT COUNT(*) AS allcount FROM data_pasien WHERE" . $final_filter);
            $stmt->execute($searchArray);
            $records = $stmt->fetch();
            $totalRecordwithFilter = $records['allcount'];

            usleep(400000);

            $fields = "SELECT data_pasien.dp_id, data_pasien.dp_nama, data_pasien.dp_panggilan, data_pasien.dp_nik, data_pasien.dp_bpjs, data_pasien.dp_alamat, data_pasien.dp_pekerjaan, data_pasien.dp_kelamin, data_pasien.dp_usia_subur, data_pasien.dp_tgl_lahir, data_pasien.dp_berat_badan, data_pasien.dp_tinggi_badan, data_pasien.dp_imun_bcg, data_pasien.dp_skor_tb_anak, data_pasien.dp_nohp, data_pasien.dp_petugas_kes, data_pasien.dp_uji_tbc, data_pasien.dp_date_toraks, data_pasien.dp_toraks_seri, data_pasien.dp_toraks_kesan, data_pasien.dp_date_fnab, data_pasien.dp_hasil_fnab, data_pasien.dp_uji_nondahak, data_pasien.dp_nama_nonmtb, data_pasien.dp_tgl_input, data_pasien.dp_status, data_pmo.pmo_id, data_pmo.dp_id as pmo_dp_id, data_pmo.pmo_nama, data_pmo.pmo_alamat, data_pmo.pmo_fasyankes, data_pmo.pmo_kota, data_pmo.pmo_tbc3_faskes, data_pmo.pmo_tahun, data_pmo.pmo_provinsi, data_pmo.pmo_tbc3_kota, data_pmo.pmo_telpon FROM data_pasien ";
            $join = " JOIN data_pmo ON data_pasien.dp_id = data_pmo.dp_id WHERE ";

            $stmt = $db->prepare($fields . $join . $final_filter
                . " ORDER BY " . $columnName . " " . $columnSortOrder . " LIMIT :limit,:offset");

            foreach ($searchArray as $key => $search) {
                $stmt->bindValue(':' . $key, $search, PDO::PARAM_STR);
            }

            $stmt->bindValue(':limit', (int)$rows, PDO::PARAM_INT);
            $stmt->bindValue(':offset', (int)$rowperpage, PDO::PARAM_INT);
            $stmt->execute();
            $res = $stmt->fetchAll();
            $data = array();

            foreach ($res as $row) {
                $data[] = array(
                    'dp_id' => $row['dp_id'],
                    'dp_nama' => $row['dp_nama'],
                    'dp_panggilan' => $row['dp_panggilan'],
                    'dp_nik' => $row['dp_nik'],
                    'dp_bpjs' => $row['dp_bpjs'],
                    'dp_alamat' => $row['dp_alamat'],
                    'dp_pekerjaan' => $row['dp_pekerjaan'],
                    'dp_kelamin' => $row['dp_kelamin'],
                    'dp_usia_subur' => $row['dp_usia_subur'],
                    'dp_tgl_lahir' => $row['dp_tgl_lahir'],
                    'dp_berat_badan' => $row['dp_berat_badan'],
                    'dp_tinggi_badan' => $row['dp_tinggi_badan'],
                    'dp_imun_bcg' => $row['dp_imun_bcg'],
                    'dp_skor_tb_anak' => $row['dp_skor_tb_anak'],
                    'dp_nohp' => $row['dp_nohp'],
                    'dp_petugas_kes' => $row['dp_petugas_kes'],
                    'dp_uji_tbc' => $row['dp_uji_tbc'],
                    'dp_date_toraks' => $row['dp_date_toraks'],
                    'dp_toraks_seri' => $row['dp_toraks_seri'],
                    'dp_toraks_kesan' => $row['dp_toraks_kesan'],
                    'dp_date_fnab' => $row['dp_date_fnab'],
                    'dp_hasil_fnab' => $row['dp_hasil_fnab'],
                    'dp_uji_nondahak' => $row['dp_uji_nondahak'],
                    'dp_nama_nonmtb' => $row['dp_nama_nonmtb'],
                    'dp_tgl_input' => $row['dp_tgl_input'],
                    'dp_status' => $row['dp_status'],
                    'pmo_id' => $row['pmo_id'],
                    'pmo_dp_id' => $row['pmo_dp_id'],
                    'pmo_nama' => $row['pmo_nama'],
                    'pmo_alamat' => $row['pmo_alamat'],
                    'pmo_fasyankes' => $row['pmo_fasyankes'],
                    'pmo_kota' => $row['pmo_kota'],
                    'pmo_tbc3_faskes' => $row['pmo_tbc3_faskes'],
                    'pmo_tahun' => $row['pmo_tahun'],
                    'pmo_provinsi' => $row['pmo_provinsi'],
                    'pmo_tbc3_kota' => $row['pmo_tbc3_kota'],
                    'pmo_telpon' => $row['pmo_telpon']
                );
            }

            // usleep(200000);

            echo json_encode(array(
                "draw" => intval($draw),
                "recordsTotal" => $totalRecords,
                "recordsFiltered" => $totalRecordwithFilter,
                "data" => $data
            ));
        } catch (PDOException $e) {
            echo json_encode(array(
                "draw" => 0,
                "recordsTotal" => 0,
                "recordsFiltered" => 0,
                "data" => null
            ));
        }
        break;
    case 'dashboard':
        try {
            $today = $_POST['today'];
            $query = "SELECT COUNT(*) AS allrecords FROM data_pasien WHERE dp_status=1 ";

            $stmt = $db->prepare($query);
            $stmt->execute();
            $records = $stmt->fetch();
            $allrecords = $records['allrecords'];

            sleep(1);

            $stmt = $db->prepare($query . "AND dp_tgl_input = '" . $today . "'");
            $stmt->execute();
            $records = $stmt->fetch();
            $todayrecords = $records['allrecords'];

            echo json_encode(
                array(
                    "status" => "success",
                    "allrecords" => $allrecords,
                    "todayrecords" => $todayrecords,
                    "messages" => ""
                )
            );
        } catch (PDOException $e) {
            echo json_encode(
                array(
                    "status" => "failed",
                    "allrecords" => 0,
                    "todayrecords" => 0,
                    "messages" => $e
                )
            );
        }
        break;
    default:
        break;
}
