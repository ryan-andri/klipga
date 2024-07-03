<?php
session_start();
require('../configs/config.php');
require('auth.php');

require_once BASE_PATH . '/assets/vendor/phpxls/PhpXlsxGenerator.php';

if (array_key_exists('filter', $_POST) && array_key_exists('ts', $_POST)) {
    $_SESSION['filter'] = $_POST['filter'];
    $_SESSION['date_now'] = $_POST['ts'];
    Header("Content-Type: application/json;charset=UTF-8");
    die(json_encode(array('status' => 'OK')));
}

if (
    !isset($_SESSION['filter']) || !isset($_SESSION['date_now'])
) {
    die(header('HTTP/1.0 403 Forbidden', true, 403));
}

$filter = $_SESSION['filter'];
$now = $_SESSION['date_now'];
$f_filter = $filter ? "-sudah_input-" : "-belum_input-";
$df = $filter ? " IS NOT NULL" : " IS NULL";
$fileName = "data_klipga" . $f_filter . $now . ".xlsx";

$db = DBConnection::getInstance();
$excelData[] = array(
    'NO', 'NAMA PASIEN', 'PANGGILAN', 'NO. NIK', 'NO. BPJS',
    'ALAMAT', 'PEKERJAAN', 'KELAMIN', 'USIA SUBUR', 'TANGGAL LAHIR', 'BERAT BADAN',
    'TINGGI BADAN', 'IMUNISASI BCG', 'SKOR TB ANAK', 'NO. HP', 'PETUGAS KES',
    'UJI TBC', 'TANGGAL TORAKS', 'SERI SCAN TORAKS', 'KESAN TORASK', 'TANGGAL FNAB', 'HASIL FNAB',
    'UJI NONDAHAK', 'NAMA NON-MTB', 'TANGGAL INPUT', 'NAMA PMO', 'ALAMAT PMO', 'FASYANKES PMO',
    'KOTA PMO', 'TBC3 FASYANKES', 'TAHUN PMO', 'PROVINSI PMO', 'TBC3 KOTA', 'TELP PMO',
    'TIPE DIAG', 'KLASIFIKASI ANATOMI', 'LOKASI EKTRAPARU', 'PENGOBATAN SEBELUMNYA', 'KLASIFIKASI ICD10',
    'KLASIFIKASI HIV', 'DIRUJUK', 'RUJUKAN DARI', 'FASYANKES PINDAHAN', 'ALAMAT FASYANKES PINDAHAN', 'KOTA PINDAHAN',
    'PROVINSI PINDAHAN', 'INVESTIGASI KONTAK', 'JUMLAH KONTAK SERUMAH', 'JUMLAH INVESTIGASI KONTAK', 'JUMLAH KONTAK TBC', 'RIWAYAT DM', 'TES DM', 'TERAPI DM', 'JENIS PANDUAN OAT', 'PANDUAN OAT', 'BENTUK OAT', 'SUMBER OBAT', 'ASURANSI'
);
$query = "SELECT dp.*, pmo.*, dip.* FROM data_pasien dp
    LEFT JOIN data_input_pasien dip ON dp.dp_id = dip.dip_dp_id
    LEFT JOIN data_pmo pmo ON dp.dp_id = pmo.dp_id WHERE dp.dp_status=1 AND dip.dip_dp_id" . $df;
$stmt = $db->prepare($query);
$stmt->execute();
$no = 1;
while ($row = $stmt->fetch()) {
    $lineData = array(
        $no, $row['dp_nama'], $row['dp_panggilan'], $row['dp_nik'], $row['dp_bpjs'], $row['dp_alamat'], $row['dp_pekerjaan'], $row['dp_kelamin'], $row['dp_usia_subur'], $row['dp_tgl_lahir'], $row['dp_berat_badan'], $row['dp_tinggi_badan'], $row['dp_imun_bcg'], $row['dp_skor_tb_anak'], $row['dp_nohp'], $row['dp_petugas_kes'], $row['dp_uji_tbc'], $row['dp_date_toraks'], $row['dp_toraks_seri'], $row['dp_toraks_kesan'], $row['dp_date_fnab'], $row['dp_hasil_fnab'], $row['dp_uji_nondahak'], $row['dp_nama_nonmtb'], $row['dp_tgl_input'], $row['pmo_nama'], $row['pmo_alamat'], $row['pmo_fasyankes'], $row['pmo_kota'], $row['pmo_tbc3_faskes'], $row['pmo_tahun'], $row['pmo_provinsi'], $row['pmo_tbc3_kota'], $row['pmo_telpon'], $row['dip_tipe_diagnosis'], $row['dip_klasifikasi_anatomi'], $row['dip_ektraparu_lokasi'], $row['dip_klasifikasi_pengobatan_sebelumnya'], $row['dip_klasifikasi_icd10'], $row['dip_klasifikasi_hiv'], $row['dip_dirujuk_oleh'], $row['dip_dirujuk_oleh_isian'], $row['dip_pindahan_nama_fasyankes'], $row['dip_pindahan_alamat_fasyankes'], $row['dip_pindahan_kota'], $row['dip_pindahan_provinsi'], $row['dip_investigasi_kontak'], $row['dip_jumlah_kontak_serumah'], $row['dip_jumlah_kontak_investigasi'], $row['dip_jumlah_kontak_tbc'], $row['dip_riwayat_dm'], $row['dip_tes_dm'], $row['dip_terapi_dm'], $row['dip_panduan_oat'], $row['dip_panduan_oat_isian'], $row['dip_bentuk_oat'], $row['dip_sumber_obat'], $row['dip_sumber_obat_isian']
    );
    $excelData[] = $lineData;
    $no++;
}

$xlsx = CodexWorld\PhpXlsxGenerator::fromArray($excelData);
$xlsx->downloadAs($fileName);

unset($_SESSION['filter']);
unset($_SESSION['date_now']);

exit;
