<!-- filepath: /c:/xampp/htdocs/final-ex/login/register.php -->
<?php
$servername = "localhost";
$username = "root";
$password = ""; // Đảm bảo rằng mật khẩu này là chính xác
$dbname = "sapovn";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $sdt = $_POST['sdt'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Kiểm tra xem email hoặc tên người dùng đã tồn tại chưa
    $stmt = $conn->prepare("SELECT Id FROM users WHERE email = ? OR UserName = ?");
    $stmt->bind_param("ss", $email, $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo "<script>alert('Email hoặc tên người dùng đã tồn tại!'); window.location.href='register.php';</script>";
    } else {
        // Lưu thông tin người dùng vào cơ sở dữ liệu
        $stmt = $conn->prepare("INSERT INTO users (Email, SDT, UserName, Password) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $email, $sdt, $username, $password);
        if ($stmt->execute()) {
            echo "<script>alert('Đăng ký thành công!'); window.location.href='user_login.php';</script>";
        } else {
            echo "<script>alert('Đăng ký thất bại!'); window.location.href='register.php';</script>";
        }
    }
    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="login.css">
    <title>Đăng ký</title>
    <style>
        .back-link {
            display: block;
            margin-bottom: 10px;
            text-decoration: none;
            color: #007bff;
        }
        .back-link i {
            margin-right: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="login-form">
            <a href="user_login.php" class="back-link"><i class="fas fa-arrow-left"></i> Quay lại</a>
            <h2>Đăng ký</h2>
            <form action="register.php" method="POST">
                <div class="input-group">
                    <label>Email</label>
                    <input type="email" name="email" placeholder="Nhập email" required>
                </div>
                <div class="input-group">
                    <label>Số điện thoại</label>
                    <input type="text" name="sdt" placeholder="Nhập số điện thoại" required>
                </div>
                <div class="input-group">
                    <label>Tên người dùng</label>
                    <input type="text" name="username" placeholder="Nhập tên người dùng" required>
                </div>
                <div class="input-group">
                    <label>Mật khẩu</label>
                    <input type="password" name="password" placeholder="Nhập mật khẩu" required>
                </div>
                <button type="submit" class="login-btn">Đăng ký</button>
            </form>
        </div>
        <div class="image-container"></div>
    </div>
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
</body>
</html>