<?php 
include "service/database.php";

session_start();

$register_message = "";

// Redirect jika sudah login
if (isset($_SESSION["is_login"])) {
    header("location: dashboard.php");
    exit;
} 

// Proses registrasi
if (isset($_POST["register"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $hash_password = hash("sha256", $password); // Hash password

    // Query untuk memasukkan data
    $sql = "INSERT INTO users (username, password) VALUES ('$username', '$hash_password')";

    // Eksekusi query dan cek hasil
    if (mysqli_query($db, $sql)) {
        $register_message = "Daftar akun berhasil, silahkan login";
    } else {
        // Menangani kesalahan jika username sudah digunakan
        if (mysqli_errno($db) == 1062) { // 1062 adalah kode error untuk duplikat entry
            $register_message = "Username sudah digunakan, silahkan ganti";
        } else {
            $register_message = "Daftar akun gagal, silahkan coba lagi";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <?php include "layout/header.html" ?>

    <main>
        <form method="post" action="register.php">
            <h2>Register</h2>
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            
            <button type="submit" name="register">Register</button>
        </form>
        <p><?php echo $register_message; ?></p>
    </main>

    <?php include "layout/footer.html" ?>
</body>
</html>
