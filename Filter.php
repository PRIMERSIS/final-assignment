<!-- filepath: /c:/xampp/htdocs/final-ex/filter.php -->
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sapovn";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $prefix = $_POST['prefix'];
    $tenDanhMuc = $_POST['tenDanhMuc'];
    $giaTu = $_POST['giaTu'];
    $giaDen = $_POST['giaDen'];

    $query = "SELECT * FROM DichVu WHERE DaXoa = 0";
    $params = [];
    $types = "";

    if (!empty($prefix)) {
        $query .= " AND prefix = ?";
        $params[] = $prefix;
        $types .= "s";
    }

    if (!empty($tenDanhMuc)) {
        $query .= " AND TenDanhMuc = ?";
        $params[] = $tenDanhMuc;
        $types .= "s";
    }

    if (!empty($giaTu)) {
        $query .= " AND Gia >= ?";
        $params[] = $giaTu;
        $types .= "d";
    }

    if (!empty($giaDen)) {
        $query .= " AND Gia <= ?";
        $params[] = $giaDen;
        $types .= "d";
    }

    $stmt = $conn->prepare($query);
    if (!empty($params)) {
        $stmt->bind_param($types, ...$params);
    }
    $stmt->execute();
    $result = $stmt->get_result();
    $filterResults = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    $conn->close();

    session_start();
    $_SESSION['filterResults'] = $filterResults;
    header("Location: index2.php");
    exit;
}
?>