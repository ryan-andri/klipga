<?php
session_start();
require_once('configs/config.php');

$cmd = !empty($_POST["action"]) ? $_POST["action"] : '';

$db = DBConnection::getInstance();

switch ($cmd) {
    case 'load_pasien':
        try {
            $draw = $_POST['draw'];
            $row = $_POST['start'];
            $rowperpage = $_POST['length'];
            $columnIndex = $_POST['order'][0]['column'];
            $columnName = $_POST['columns'][$columnIndex]['data'];
            $columnSortOrder = $_POST['order'][0]['dir'];
            $searchValue = $_POST['search']['value'];
            $filter_date = $_POST['filter_date'];

            $stmt = $db->prepare("SELECT COUNT(*) AS allcount FROM data_pasien ");
            $stmt->execute();
            $records = $stmt->fetch();
            $totalRecords = $records['allcount'];

            $date_filter = " ";
            if (!empty($filter_date)) {
                $date_filter = " AND data_pasien.dp_tgl_input = '" . $filter_date . "' ";
            }

            $searchArray = array();
            $searchQuery = " ";
            if (!empty($searchValue)) {
                $searchQuery = " AND (data_pasien.dp_nama LIKE :dp_nama OR data_pasien.dp_nik LIKE :dp_nik
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

            $final_filter = "1" . $date_filter . $searchQuery;

            sleep(1);

            $stmt = $db->prepare("SELECT COUNT(*) AS allcount FROM data_pasien WHERE " . $final_filter);
            $stmt->execute($searchArray);
            $records = $stmt->fetch();
            $totalRecordwithFilter = $records['allcount'];

            $stmt = $db->prepare("SELECT * FROM data_pasien WHERE "
                . $final_filter . " ORDER BY " . $columnName . " "
                . $columnSortOrder . " LIMIT :limit,:offset");

            foreach ($searchArray as $key => $search) {
                $stmt->bindValue(':' . $key, $search, PDO::PARAM_STR);
            }

            $stmt->bindValue(':limit', (int)$row, PDO::PARAM_INT);
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
                    'dp_tgl_input' => $row['dp_tgl_input']
                );
            }
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
    default:
        break;
}
