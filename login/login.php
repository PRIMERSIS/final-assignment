<!-- filepath: /c:/xampp/htdocs/final-ex/login/login.php -->
<?php
session_start();
$servername = "localhost";
$username = "root";
$password = ""; 
$dbname = "sapovn";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = isset($_POST['role']) ? $_POST['role'] : 'admin'; // Mặc định là admin nếu không có role

    if ($role == 'admin') {
        // Đăng nhập admin
        $stmt = $conn->prepare("CALL KiemTraDangNhap(?, ?)");
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        $stmt->bind_result($result);
        $stmt->fetch();
        $stmt->close();

        if ($result > 0) {
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $username;
            $_SESSION['role'] = $role;
            header("Location: ../index.php");
        } else {
            echo "<script>alert('Thông tin đăng nhập không chính xác!'); window.location.href='login.php';</script>";
        }
    } else {
        // Đăng nhập user
        $stmt = $conn->prepare("SELECT Id, Password FROM users WHERE UserName = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->bind_result($userId, $passwordHash);
        $stmt->fetch();
        $stmt->close();

        if ($userId && $password === $passwordHash) {
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $username;
            $_SESSION['role'] = $role;

            // Lưu thông tin phiên đăng nhập vào bảng session
            $stmt = $conn->prepare("INSERT INTO session (UserId) VALUES (?)");
            $stmt->bind_param("i", $userId);
            $stmt->execute();
            $stmt->close();

            header("Location: ../index.php");
        } else {
            echo "<script>alert('Thông tin đăng nhập không chính xác!'); window.location.href='login.php';</script>";
        }
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
    <title>Đăng nhập</title>
</head>
<body>
    <div class="container">
        <div class="login-form">
            <h2>Đăng nhập</h2>
            <form action="login.php" method="POST">
                <div class="input-group">
                    <label>Username</label>
                    <input type="text" name="username" placeholder="Nhập username" required>
                </div>
                <div class="input-group">
                    <label>Mật khẩu</label>
                    <input type="password" name="password" placeholder="Nhập mật khẩu" required>
                </div>
                <button type="submit" class="login-btn">Đăng nhập</button>
            </form>
            <button onclick="showUserLogin()">Đăng nhập User</button>
        </div>
        <div class="image-container"></div>
    </div>

    <script>
        function showUserLogin() {
            window.location.href = 'user_login.php';
        }
    </script>
</body>
</html>