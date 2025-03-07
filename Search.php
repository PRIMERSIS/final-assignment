<!-- filepath: /c:/xampp/htdocs/final-ex/search.php -->
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
    $tenSanPham = $_POST['tenSanPham'];
    $limit = 10;
    $page = isset($_POST['page']) ? $_POST['page'] : 1;
    $start = ($page - 1) * $limit;

    // Lấy tổng số sản phẩm tìm kiếm được
    $stmt = $conn->prepare("SELECT COUNT(*) AS total FROM DichVu WHERE Ten LIKE CONCAT('%', ?, '%') AND DaXoa = 0");
    $stmt->bind_param("s", $tenSanPham);
    $stmt->execute();
    $result = $stmt->get_result();
    $total = $result->fetch_assoc()['total'];
    $total_pages = ceil($total / $limit);
    $stmt->close();

    // Lấy danh sách sản phẩm cho trang hiện tại
    $stmt = $conn->prepare("SELECT * FROM DichVu WHERE Ten LIKE CONCAT('%', ?, '%') AND DaXoa = 0 LIMIT ?, ?");
    $stmt->bind_param("sii", $tenSanPham, $start, $limit);
    $stmt->execute();
    $result = $stmt->get_result();
    $searchResults = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    $conn->close();

    session_start();
    $_SESSION['searchResults'] = $searchResults;
    $_SESSION['searchTotalPages'] = $total_pages;
    $_SESSION['searchCurrentPage'] = $page;
    header("Location: index2.php");
    exit;
}
?>