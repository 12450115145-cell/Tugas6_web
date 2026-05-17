<?php
include "../koneksi.php";

$method = $_SERVER['REQUEST_METHOD'];
$input = json_decode(file_get_contents('php://input'), true);

switch ($method) {
    case 'GET':
        $query = mysqli_query($koneksi, "SELECT * FROM siswa");
        $data = mysqli_fetch_all($query, MYSQLI_ASSOC);
        echo json_encode(["status" => true, "data" => $data]);
        break;

    case 'POST':
        $nama_siswa = $input['nama_siswa'];
        $sql = "INSERT INTO siswa (nama_siswa) VALUES ('$nama_siswa')";
        if (mysqli_query($koneksi, $sql)) {
            echo json_encode(["status" => true, "message" => "Data Siswa Berhasil Ditambahkan!"]);
        } else {
            echo json_encode(["status" => false, "message" => "Gagal: " . mysqli_error($koneksi)]);
        }
        break;

    case 'PUT':
        $id_siswa = isset($_GET['id']) ? $_GET['id'] : '';
        $nama_siswa = $input['nama_siswa'];
        $sql = "UPDATE siswa SET nama_siswa='$nama_siswa' WHERE id_siswa='$id_siswa'";
        if (mysqli_query($koneksi, $sql)) {
            echo json_encode(["status" => true, "message" => "Data Siswa ID $id_siswa Berhasil Diubah!"]);
        } else {
            echo json_encode(["status" => false, "message" => "Gagal mengubah data"]);
        }
        break;

    case 'DELETE':
        $id_siswa = isset($_GET['id']) ? $_GET['id'] : '';
        $sql = "DELETE FROM siswa WHERE id_siswa='$id_siswa'";
        if (mysqli_query($koneksi, $sql)) {
            echo json_encode(["status" => true, "message" => "Data Siswa ID $id_siswa Berhasil Dihapus!"]);
        } else {
            echo json_encode(["status" => false, "message" => "Gagal menghapus data"]);
        }
        break;
}
?>