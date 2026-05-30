<?php
include "../koneksi.php";
include "auth.php";

$method = $_SERVER['REQUEST_METHOD'];
$input = json_decode(file_get_contents('php://input'), true);

switch ($method) {
    case 'GET':
        $query = mysqli_query($koneksi, "SELECT * FROM guru");
        $data = mysqli_fetch_all($query, MYSQLI_ASSOC);
        echo json_encode(["status" => true, "data" => $data]);
        break;

    case 'POST':
        $nama_guru = $input['nama_guru'];
        $sql = "INSERT INTO guru (nama_guru) VALUES ('$nama_guru')";
        if (mysqli_query($koneksi, $sql)) {
            echo json_encode(["status" => true, "message" => "Data Guru Berhasil Ditambahkan!"]);
        } else {
            echo json_encode(["status" => false, "message" => "Gagal: " . mysqli_error($koneksi)]);
        }
        break;

    case 'PUT':
        $id_guru = isset($_GET['id']) ? $_GET['id'] : '';
        $nama_guru = $input['nama_guru'];
        $sql = "UPDATE guru SET nama_guru='$nama_guru' WHERE id_guru='$id_guru'";
        if (mysqli_query($koneksi, $sql)) {
            echo json_encode(["status" => true, "message" => "Data Guru ID $id_guru Berhasil Diubah!"]);
        } else {
            echo json_encode(["status" => false, "message" => "Gagal mengubah data"]);
        }
        break;

    case 'DELETE':
        $id_guru = isset($_GET['id']) ? $_GET['id'] : '';
        $sql = "DELETE FROM guru WHERE id_guru='$id_guru'";
        if (mysqli_query($koneksi, $sql)) {
            echo json_encode(["status" => true, "message" => "Data Guru ID $id_guru Berhasil Dihapus!"]);
        } else {
            echo json_encode(["status" => false, "message" => "Gagal menghapus data"]);
        }
        break;
}
?>