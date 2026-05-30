<?php
$headers = getallheaders();

if (!isset($headers['Authorization'])) {
    http_response_code(401);
    echo json_encode([
        "status" => false,
        "message" => "Token autentikasi tidak ada."
    ]);
    exit();
}

$token = $headers['Authorization'];

$check_token = mysqli_query($koneksi, "SELECT * FROM users WHERE token = '$token'");

if (mysqli_num_rows($check_token) == 0) {
    http_response_code(401);
    echo json_encode([
        "status" => false,
        "message" => "Akses Ditolak! Token salah."
    ]);
    exit();
}

?>