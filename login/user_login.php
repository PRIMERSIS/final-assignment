<!-- filepath: /c:/xampp/htdocs/final-ex/login/user_login.php -->
<?php
session_start();
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
    $password = $_POST['password'];

    // Kiểm tra thông tin đăng nhập
    $stmt = $conn->prepare("SELECT Id, Password FROM users WHERE Email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($userId, $passwordHash);
    $stmt->fetch();
    $stmt->close();

    if ($userId && $password === $passwordHash) {
        // Thiết lập phiên làm việc
        $_SESSION['loggedin'] = true;
        $_SESSION['userId'] = $userId;
        $_SESSION['email'] = $email;

        // Lưu thông tin phiên đăng nhập vào bảng session
        $stmt = $conn->prepare("INSERT INTO session (UserId) VALUES (?)");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $stmt->close();

        header("Location: ../Userpage/userpage.php");
    } else {
        echo "<script>alert('Thông tin đăng nhập không chính xác!'); window.location.href='user_login.php';</script>";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="login.css">
    <title>Đăng nhập người dùng</title>
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
        .register-btn {
            display: block;
            margin-top: 20px;
            text-align: center;
            text-decoration: none;
            color: #007bff;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="login-form">
            <a href="login.php" class="back-link"><i class="fas fa-arrow-left"></i> Quay lại</a>
            <h2>Đăng nhập người dùng</h2>
            <form action="user_login.php" method="POST">
                <div class="input-group">
                    <label>Email</label>
                    <input type="email" name="email" placeholder="Nhập email" required>
                </div>
                <div class="input-group">
                    <label>Mật khẩu</label>
                    <input type="password" name="password" placeholder="Nhập mật khẩu" required>
                </div>
                <button type="submit" class="login-btn">Đăng nhập</button>
            </form>
            <a href="Fogotpass.php" class="forgot-password">Quên mật khẩu?</a>
            <a href="register.php" class="register-btn">Đăng ký</a>
        </div>
        <div class="image-container"></div>
    </div>
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
</body>
</html>