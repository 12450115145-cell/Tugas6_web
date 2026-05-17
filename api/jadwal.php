<?php
include "../koneksi.php";

$method = $_SERVER['REQUEST_METHOD'];
$input = json_decode(file_get_contents('php://input'), true);

switch ($method) {
    case 'GET':
        // ?aksi=statistik, tampilkan datanya
        $aksi = isset($_GET['aksi']) ? $_GET['aksi'] : '';
        if ($aksi == 'statistik') {
            $query_total = mysqli_query($koneksi, "SELECT COUNT(*) as total_jadwal FROM jadwal");
            $total = mysqli_fetch_assoc($query_total);
            echo json_encode([
                "status" => true, 
                "statistik" => ["total_aktivitas_jadwal" => $total['total_jadwal']]
            ]);
            exit;
        }

        $sql = "SELECT jadwal.id_jadwal, siswa.nama_siswa, guru.nama_guru, mapel.nama_mapel 
                FROM jadwal
                INNER JOIN siswa ON jadwal.id_siswa = siswa.id_siswa
                INNER JOIN guru ON jadwal.id_guru = guru.id_guru
                INNER JOIN mapel ON jadwal.id_mapel = mapel.id_mapel";
        $query = mysqli_query($koneksi, $sql);
        $data = mysqli_fetch_all($query, MYSQLI_ASSOC);
        echo json_encode(["status" => true, "data" => $data]);
        break;

    case 'POST':
        $id_siswa = $input['id_siswa'];
        $id_guru  = $input['id_guru'];
        $id_mapel = $input['id_mapel'];

        $sql = "INSERT INTO jadwal (id_siswa, id_guru, id_mapel) VALUES ('$id_siswa', '$id_guru', '$id_mapel')";
        if (mysqli_query($koneksi, $sql)) {
            echo json_encode(["status" => true, "message" => "Data Jadwal Berhasil Ditambahkan!"]);
        } else {
            echo json_encode(["status" => false, "message" => "Gagal: " . mysqli_error($koneksi)]);
        }
        break;

    case 'PUT':
        $id_jadwal = isset($_GET['id']) ? $_GET['id'] : '';
        $id_siswa  = $input['id_siswa'];
        $id_guru   = $input['id_guru'];
        $id_mapel  = $input['id_mapel'];

        $sql = "UPDATE jadwal SET id_siswa='$id_siswa', id_guru='$id_guru', id_mapel='$id_mapel' WHERE id_jadwal='$id_jadwal'";
        if (mysqli_query($koneksi, $sql)) {
            echo json_encode(["status" => true, "message" => "Data Jadwal ID $id_jadwal Berhasil Diubah!"]);
        } else {
            echo json_encode(["status" => false, "message" => "Gagal mengubah data"]);
        }
        break;

    case 'DELETE':
        $id_jadwal = isset($_GET['id']) ? $_GET['id'] : '';
        $sql = "DELETE FROM jadwal WHERE id_jadwal='$id_jadwal'";
        if (mysqli_query($koneksi, $sql)) {
            echo json_encode(["status" => true, "message" => "Data Jadwal ID $id_jadwal Berhasil Dihapus!"]);
        } else {
            echo json_encode(["status" => false, "message" => "Gagal menghapus data"]);
        }
        break;
}
?>