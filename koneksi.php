<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Allow-Headers: Content-Type');

$koneksi = mysqli_connect("localhost", "root", "", "les_privat");

if (mysqli_connect_errno()) {
    echo json_encode(["status" => false, "message" => "Koneksi database gagal: " . mysqli_connect_error()]);
    exit();
}
?>