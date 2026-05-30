<?php
header("Content-Type: application/json");
include "../koneksi.php";

$method = $_SERVER['REQUEST_METHOD'];
$input = json_decode(file_get_contents('php://input'), true);

if ($method === 'POST') {
    $username = isset($input['username']) ? $input['username'] : '';
    $password = isset($input['password']) ? $input['password'] : '';

    $query = mysqli_query($koneksi, "SELECT * FROM users WHERE username='$username' AND password='$password'");
    
    if (mysqli_num_rows($query) > 0) {
        $user = mysqli_fetch_assoc($query);
        
        $token = bin2hex(random_bytes(16)); 
        $id_user = $user['id_user'];
        
        mysqli_query($koneksi, "UPDATE users SET token='$token' WHERE id_user='$id_user'");

        echo json_encode([
            "status" => true,
            "message" => "Login Berhasil!",
            "token" => $token
        ]);
    } else {
        echo json_encode([
            "status" => false,
            "message" => "Username atau Password Salah!"
        ]);
    }
} else {
    echo json_encode([
        "status" => false,
        "message" => "Method tidak diizinkan! Harus POST."
    ]);
}
?>