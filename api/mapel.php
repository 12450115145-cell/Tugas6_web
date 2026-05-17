<?php
include "../koneksi.php";

$method = $_SERVER['REQUEST_METHOD'];
$input = json_decode(file_get_contents('php://input'), true);

switch ($method) {
    case 'GET':
        $query = mysqli_query($koneksi, "SELECT * FROM mapel");
        $data = mysqli_fetch_all($query, MYSQLI_ASSOC);
        echo json_encode(["status" => true, "data" => $data]);
        break;

    case 'POST':
        $nama_mapel = $input['nama_mapel'];
        $biaya      = isset($input['biaya']) ? $input['biaya'] : 0;
        $sql = "INSERT INTO mapel (nama_mapel, biaya) VALUES ('$nama_mapel', '$biaya')";
        if (mysqli_query($koneksi, $sql)) {
            echo json_encode(["status" => true, "message" => "Data Mapel Berhasil Ditambahkan!"]);
        } else {
            echo json_encode(["status" => false, "message" => "Gagal: " . mysqli_error($koneksi)]);
        }
        break;

    case 'PUT':
        $id_mapel = isset($_GET['id']) ? $_GET['id'] : '';
        $nama_mapel = $input['nama_mapel'];
        $biaya      = isset($input['biaya']) ? $input['biaya'] : 0;
        $sql = "UPDATE mapel SET nama_mapel='$nama_mapel', biaya='$biaya' WHERE id_mapel='$id_mapel'";
        if (mysqli_query($koneksi, $sql)) {
            echo json_encode(["status" => true, "message" => "Data Mapel ID $id_mapel Berhasil Diubah!"]);
        } else {
            echo json_encode(["status" => false, "message" => "Gagal mengubah data"]);
        }
        break;

    case 'DELETE':
        $id_mapel = isset($_GET['id']) ? $_GET['id'] : '';
        $sql = "DELETE FROM mapel WHERE id_mapel='$id_mapel'";
        if (mysqli_query($koneksi, $sql)) {
            echo json_encode(["status" => true, "message" => "Data Mapel ID $id_mapel Berhasil Dihapus!"]);
        } else {
            echo json_encode(["status" => false, "message" => "Gagal menghapus data"]);
        }
        break;
}
?>