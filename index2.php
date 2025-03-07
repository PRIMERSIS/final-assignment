<!-- filepath: /c:/xampp/htdocs/final-ex/index.php -->
<?php
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: login/login.php");
    exit;
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sapovn";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

// Lấy kết quả tìm kiếm và lọc từ session
$searchResults = isset($_SESSION['searchResults']) ? $_SESSION['searchResults'] : [];
$filterResults = isset($_SESSION['filterResults']) ? $_SESSION['filterResults'] : [];
$searchTotalPages = isset($_SESSION['searchTotalPages']) ? $_SESSION['searchTotalPages'] : 1;
$searchCurrentPage = isset($_SESSION['searchCurrentPage']) ? $_SESSION['searchCurrentPage'] : 1;

// Xóa kết quả tìm kiếm và lọc khỏi session sau khi lấy
unset($_SESSION['searchResults']);
unset($_SESSION['filterResults']);
unset($_SESSION['searchTotalPages']);
unset($_SESSION['searchCurrentPage']);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý sản phẩm</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        .modal-content {
            border-radius: 10px;
        }
        .select-container {
            display: flex;
            align-items: center;
            width: 100%;
        }
        .select-container select {
            flex: 1;
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Quản lý sản phẩm</h1>

        <!-- Nút quay lại -->
        <form action="index.php" method="GET" class="mb-3">
            <button class="btn btn-secondary" type="submit">Quay lại</button>
        </form>

        <!-- Form tìm kiếm sản phẩm -->
        <form action="search.php" method="POST" class="mb-3">
            <div class="input-group">
                <input type="text" class="form-control" name="tenSanPham" placeholder="Nhập tên sản phẩm">
                <div class="input-group-append">
                    <button class="btn btn-primary" type="submit">Tìm kiếm</button>
                    <button class="btn btn-secondary" type="button" onclick="document.getElementById('filterModal').style.display='block'">
                        <i class="fas fa-filter"></i>
                    </button>
                </div>
            </div>
        </form>

        <!-- Hiển thị kết quả tìm kiếm -->
        <?php if (!empty($searchResults)): ?>
            <h2>Kết quả tìm kiếm</h2>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên sản phẩm</th>
                        <th>Giá</th>
                        <th>Hình ảnh</th>
                        <th>Mã sản phẩm</th>
                        <th>Prefix</th>
                        <th>Danh mục</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($searchResults as $row): ?>
                        <tr>
                            <td><?php echo $row['IdDichVu']; ?></td>
                            <td><?php echo $row['Ten']; ?></td>
                            <td><?php echo number_format($row['Gia'], 0, ',', '.') . ' VNĐ'; ?></td>
                            <td><img src="<?php echo $row['HinhAnh']; ?>" alt="<?php echo $row['Ten']; ?>" width="100"></td>
                            <td><?php echo $row['MaSP']; ?></td>
                            <td><?php echo $row['prefix']; ?></td>
                            <td><?php echo $row['TenDanhMuc']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <!-- Hiển thị phân trang cho kết quả tìm kiếm -->
            <nav aria-label="Page navigation">
                <ul class="pagination justify-content-center">
                    <?php if ($searchCurrentPage > 1): ?>
                        <li class="page-item">
                            <a class="page-link" href="#" onclick="submitSearchForm(<?php echo $searchCurrentPage - 1; ?>)" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php for ($i = 1; $i <= $searchTotalPages; $i++): ?>
                        <li class="page-item <?php if ($i == $searchCurrentPage) echo 'active'; ?>">
                            <a class="page-link" href="#" onclick="submitSearchForm(<?php echo $i; ?>)"><?php echo $i; ?></a>
                        </li>
                    <?php endfor; ?>
                    <?php if ($searchCurrentPage < $searchTotalPages): ?>
                        <li class="page-item">
                            <a class="page-link" href="#" onclick="submitSearchForm(<?php echo $searchCurrentPage + 1; ?>)" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>
        <?php endif; ?>

        <!-- Hiển thị kết quả lọc -->
        <?php if (!empty($filterResults)): ?>
            <h2>Kết quả lọc</h2>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên sản phẩm</th>
                        <th>Giá</th>
                        <th>Hình ảnh</th>
                        <th>Mã sản phẩm</th>
                        <th>Prefix</th>
                        <th>Danh mục</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($filterResults as $row): ?>
                        <tr>
                            <td><?php echo $row['IdDichVu']; ?></td>
                            <td><?php echo $row['Ten']; ?></td>
                            <td><?php echo number_format($row['Gia'], 0, ',', '.') . ' VNĐ'; ?></td>
                            <td><img src="<?php echo $row['HinhAnh']; ?>" alt="<?php echo $row['Ten']; ?>" width="100"></td>
                            <td><?php echo $row['MaSP']; ?></td>
                            <td><?php echo $row['prefix']; ?></td>
                            <td><?php echo $row['TenDanhMuc']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>

        <!-- Hiển thị danh sách sản phẩm nếu không có kết quả tìm kiếm hoặc lọc -->
        <?php if (empty($searchResults) && empty($filterResults)): ?>
            <?php
            // Thiết lập số sản phẩm trên mỗi trang
            $limit = 5;

            // Lấy trang hiện tại từ URL, nếu không có thì mặc định là trang 1
            $page = isset($_GET['page']) ? $_GET['page'] : 1;
            $start = ($page - 1) * $limit;

            // Lấy tổng số sản phẩm
            $result = $conn->query("SELECT COUNT(*) AS total FROM DichVu WHERE DaXoa = 0");
            $total = $result->fetch_assoc()['total'];
            $total_pages = ceil($total / $limit);

            // Lấy danh sách sản phẩm cho trang hiện tại
            $sql = "SELECT * FROM DichVu WHERE DaXoa = 0 LIMIT $start, $limit";
            $result = $conn->query($sql);
            ?>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên sản phẩm</th>
                        <th>Giá</th>
                        <th>Hình ảnh</th>
                        <th>Mã sản phẩm</th>
                        <th>Prefix</th>
                        <th>Danh mục</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            $giaFormatted = number_format($row['Gia'], 0, ',', '.') . ' VNĐ';
                            echo "<tr>
                                    <td>{$row['IdDichVu']}</td>
                                    <td>{$row['Ten']}</td>
                                    <td>{$giaFormatted}</td>
                                    <td><img src='{$row['HinhAnh']}' alt='{$row['Ten']}' width='100'></td>
                                    <td>{$row['MaSP']}</td>
                                    <td>{$row['prefix']}</td>
                                    <td>{$row['TenDanhMuc']}</td>
                                    <td>
                                        <button class='btn btn-warning' onclick=\"editProduct({$row['IdDichVu']}, '{$row['Ten']}', {$row['Gia']}, '{$row['HinhAnh']}', '{$row['prefix']}', '{$row['TenDanhMuc']}')\">Sửa</button>
                                        <button class='btn btn-danger' onclick=\"deleteProduct({$row['IdDichVu']})\">Xóa</button>
                                    </td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='8'>Không có sản phẩm nào</td></tr>";
                    }
                    ?>
                </tbody>
            </table>

            <!-- Hiển thị phân trang -->
            <nav aria-label="Page navigation">
                <ul class="pagination justify-content-center">
                    <?php if ($page > 1): ?>
                        <li class="page-item">
                            <a class="page-link" href="?page=<?php echo $page - 1; ?>" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                        <li class="page-item <?php if ($i == $page) echo 'active'; ?>">
                            <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                        </li>
                    <?php endfor; ?>
                    <?php if ($page < $total_pages): ?>
                        <li class="page-item">
                            <a class="page-link" href="?page=<?php echo $page + 1; ?>" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>
        <?php endif; ?>
    </div>

    <!-- Modal lọc sản phẩm -->
    <div id="filterModal" class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Lọc sản phẩm</h5>
                    <button type="button" class="close" onclick="document.getElementById('filterModal').style.display='none'" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="filter.php" method="POST">
                        <div class="form-group">
                            <label for="prefix">Prefix:</label>
                            <select class="form-control" id="prefix" name="prefix">
                                <option value="">Chọn Prefix</option>
                                <?php
                                $conn = new mysqli("localhost", "root", "", "sapovn");
                                $prefixes = [];
                                $result = $conn->query("SELECT DISTINCT prefix FROM DichVu");
                                while ($row = $result->fetch_assoc()) {
                                    $prefixes[] = $row['prefix'];
                                }
                                foreach ($prefixes as $prefixOption) {
                                    echo "<option value='$prefixOption'>$prefixOption</option>";
                                }
                                $conn->close();
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="tenDanhMuc">Danh mục:</label>
                            <select class="form-control" id="tenDanhMuc" name="tenDanhMuc">
                                <option value="">Chọn Danh mục</option>
                                <?php
                                $conn = new mysqli("localhost", "root", "", "sapovn");
                                $danhMucs = [];
                                $result = $conn->query("SELECT DISTINCT TenDanhMuc FROM DichVu");
                                while ($row = $result->fetch_assoc()) {
                                    $danhMucs[] = $row['TenDanhMuc'];
                                }
                                foreach ($danhMucs as $danhMucOption) {
                                    echo "<option value='$danhMucOption'>$danhMucOption</option>";
                                }
                                $conn->close();
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="giaTu">Giá từ:</label>
                            <input type="number" class="form-control" id="giaTu" name="giaTu">
                        </div>
                        <div class="form-group">
                            <label for="giaDen">Giá đến:</label>
                            <input type="number" class="form-control" id="giaDen" name="giaDen">
                        </div>
                        <button class="btn btn-primary" type="submit">Lọc</button>
                        <button class="btn btn-secondary" type="button" onclick="document.getElementById('filterModal').style.display='none'">Đóng</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal sửa sản phẩm -->
    <div id="editProductModal" class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Sửa sản phẩm</h5>
                    <button type="button" class="close" onclick="document.getElementById('editProductModal').style.display='none'" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="edit_product.php" method="POST" enctype="multipart/form-data">
                        <input type="hidden" id="editId" name="id">
                        <input type="hidden" id="currentImage" name="currentImage">
                        <div class="form-group">
                            <label for="editTenSanPham">Tên sản phẩm:</label>
                            <input type="text" class="form-control" id="editTenSanPham" name="tenSanPham">
                        </div>
                        <div class="form-group">
                            <label for="editGia">Giá:</label>
                            <input type="text" class="form-control" id="editGia" name="gia" oninput="formatCurrency(this)">
                        </div>
                        <div class="form-group">
                            <label for="editHinhAnh">Hình ảnh:</label>
                            <input type="file" class="form-control" id="editHinhAnh" name="hinhAnh">
                            <img id="currentImageDisplay" src="" alt="" width="100" class="mt-2">
                        </div>
                        <div class="form-group">
                            <label for="editPrefix">Prefix:</label>
                            <div class="select-container">
                                <select class="form-control" id="editPrefix" name="prefix">
                                    <option value="">Chọn Prefix</option>
                                    <?php
                                    // Lấy danh sách mã Prefix từ cơ sở dữ liệu
                                    $conn = new mysqli("localhost", "root", "", "sapovn");
                                    $prefixes = [];
                                    $result = $conn->query("SELECT DISTINCT prefix FROM DichVu");
                                    while ($row = $result->fetch_assoc()) {
                                        $prefixes[] = $row['prefix'];
                                    }
                                    foreach ($prefixes as $prefixOption) {
                                        echo "<option value='$prefixOption'>$prefixOption</option>";
                                    }
                                    $conn->close();
                                    ?>
                                </select>
                                <button type="button" class="btn btn-secondary" onclick="toggleNewEditPrefix()">Thêm Prefix</button>
                            </div>
                        </div>
                        <div id="newEditPrefixContainer" class="form-group" style="display: none;">
                            <label for="newEditPrefix">Nhập Prefix mới:</label>
                            <input type="text" class="form-control" id="newEditPrefix" name="newEditPrefix">
                        </div>
                        <div class="form-group">
                            <label for="editDanhMuc">Danh mục:</label>
                            <input type="text" class="form-control" id="editDanhMuc" name="danhMuc">
                        </div>
                        <button type="submit" class="btn btn-primary">Sửa</button>
                        <button type="button" class="btn btn-secondary" onclick="document.getElementById('editProductModal').style.display='none'">Hủy</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function editProduct(id, tenSanPham, gia, hinhAnh, prefix, danhMuc) {
            document.getElementById('editId').value = id;
            document.getElementById('editTenSanPham').value = tenSanPham;
            document.getElementById('editGia').value = gia;
            document.getElementById('currentImage').value = hinhAnh;
            document.getElementById('currentImageDisplay').src = 'uploads/' + hinhAnh;
            document.getElementById('editPrefix').value = prefix;
            document.getElementById('editDanhMuc').value = danhMuc;
            document.getElementById('editProductModal').style.display = 'block';
        }
        function deleteProduct(id) {
            if (confirm('Bạn có chắc chắn muốn xóa sản phẩm này?')) {
                window.location.href = 'delete_product.php?id=' + id;
            }
        }
        function submitSearchForm(page) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = 'search.php';

            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'page';
            input.value = page;
            form.appendChild(input);

            document.body.appendChild(form);
            form.submit();
        }
    </script>

    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>