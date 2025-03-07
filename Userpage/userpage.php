<!-- filepath: /c:/xampp/htdocs/final-ex/Userpage/userpage.php -->
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

// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: ../login/user_login.php");
    exit;
}

// Truy vấn lấy danh mục
$sql_categories = "SELECT DISTINCT TenDanhMuc, prefix FROM dichvu";
$result_categories = $conn->query($sql_categories);

// Lấy danh mục được chọn từ query string
$category = isset($_GET['category']) ? $_GET['category'] : 'Tất cả';
$price = isset($_GET['price']) ? $_GET['price'] : '';

// Truy vấn lấy sản phẩm dựa trên danh mục và khoảng giá được chọn
$sql = "SELECT * FROM dichvu WHERE DaXoa = 0";

if ($category != 'Tất cả') {
    $sql .= " AND prefix = '$category'";
}

if ($price == 'Miễn phí') {
    $sql .= " AND Gia = 0";
} elseif ($price == '500,000 - 1,000,000 đ') {
    $sql .= " AND Gia BETWEEN 500000 AND 1000000";
} elseif ($price == '1,000,000 - 2,000,000 đ') {
    $sql .= " AND Gia BETWEEN 1000000 AND 2000000";
} elseif ($price == '2,000,000 - 3,000,000 đ') {
    $sql .= " AND Gia BETWEEN 2000000 AND 3000000";
}

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sapo -Kho giao diện</title>
  <link rel="stylesheet" href="Home.css">
</head>
<body>

<header class="header">
    <div class="logo">
      <img src="//www.sapo.vn/Themes/Portal/Default/StylesV2/images/logo/Sapo-logo.svg?v=202412010539" alt="Logo" class="logo-img">
    </div>
    <nav class="nav">
      <ul>
        <li class="dropdown">
          <a href="#" id="giảiPháp">Giải pháp</a>
        </li>
        <li><a href="#">Khách hàng</a></li>
        <li><a href="#">Sapo có gì mới</a></li>
        <li><a href="#">Thêm</a></li>
        <li><a href="../login/user_login.php" class="btn login-btn">Đăng nhập</a></li>
        <li><a href="../login/register.php" class="btn register-btn">Đăng ký</a></li>
      </ul>
    </nav>
  </header>

  <!-- Mega Menu -->
<div class="mega-menu" id="megaMenu">
    <div class="menu-column">
      <h3>Bán hàng đa kênh</h3>
      <ul>
        <li>Bán tại cửa hàng
          <span class="description">Tính tiền và in hóa đơn nhanh chóng</span>
        </li>
        <li>Bán trên sàn TMĐT
          <span class="description">Tăng doanh thu từ Shopee,TikTok,Tiki,...</span>
        </li>
        <li>Bán trên mạng xã hội
          <span class="description">Tối ưu bán hàng trên Facebook và Instagram</span>
        </li>
        <li>Bán hàng trên Website
          <span class="description">Thiết kế website bán hàng chuyên nghiệp</span>
        </li>
        <li>Bán hàng hợp kênh
          <span class="description">Bán hợp kênh từ online đến offline</span>
        </li>
      </ul>
    </div>
    <div class="menu-column">
      <h3>Quản lý hợp kênh</h3>
      <ul>
        <li>Quản lý kho
          <span class="description">Nắm bắt chính xác lượng hàng trong kho</span>
        </li>
        <li>Quản lý khách hàng
          <span class="description">Lưu thông tin và chăm sóc sau bán</span>
        </li>
        <li>Quản lý nhân viên
          <span class="description">Phân quyền,theo dõi doanh số nhân viên</span>
        </li>
        <li>Quản lý giao hàng
          <span class="description">Tự động hóa quy trình giao hàng</span>
        </li>
        <li>Quản lý tập trung kênh
          <span class="description">Quản lý tập trung tất cả các kênh</span>
        </li>
      </ul>
    </div>
    <div class="menu-column">
      <h3>Quản lý dịch vụ ăn uống</h3>
      <ul>
        <li>Quản lý nhà hàng, quán ăn
          <span class="description">Tính tiền và quản lý nhà hàng toàn diện</span>
        </li>
        <li>Quản lý quán cafe, tiệm bánh
          <span class="description">Order nhanh,quản lý doanh thu chính xác</span>
        </li>
        <li>Quản lý quán trà sữa, trà chanh
          <span class="description">Bán hàng dễ dàng,quản lý topping chi tiết</span>
        </li>
        <li>Quản lý quán bida
          <span class="description">Đặt bàn nhanh chóng,quản lý từ xa dễ dàng</span>
        </li>
        <li>Quản lý quán bar, karaoke
          <span class="description">Thiết lập giá theo giờ,tính tiền linh hoạt</span>
        </li>
      </ul>
    </div>
    <div class="menu-column">
      <h3>Doanh nghiệp lớn</h3>
      <ul>
        <li>Giải pháp chuyển đổi số toàn diện từ bán hàng đa kênh đến vận hành quản lý tập trung dành riêng cho các doanh nghiệp lớn</li>
      </ul>
      <div class="solution-image">
        <img src="https://themes.sapo.vn/Themes/Portal/Default/images/img-big-business.png?v=1" alt="Hình ảnh giải pháp chuyển đổi số">
      </div>
    </div> 
</div>
<!-- Nav riêng biệt -->
<div class="header-container">
  <nav class="custom-nav">
    <ul>
      <li><a href="#">Kênh Website</a></li>
      <li><a href="#">Tính năng nổi bật</a></li>
      <li><a href="#">Bảng giá</a></li>
      <li><a href="#">Giao diện</a></li>
      <li><a href="#">Ứng dụng</a></li>
      <li><a href="#">Khách hàng</a></li>
    </ul>
  </nav>

  <div class="hero-section">
    <h1 class="hero-title">Danh sách tất cả giao diện</h1>
    <p class="hero-description">
      Hơn 400 mẫu giao diện website chuẩn SEO, tùy biến dễ dàng, phù hợp với mọi ngành hàng
    </p>
  </div>
</div>

  <!-- MAIN CONTAINER -->
<div class="container">
  <!-- THANH DANH MỤC -->
  <div class="sidebar">
    <h3>Danh mục</h3>
    <form method="GET" action="">
      <ul>
        <li>
          <input type="radio" id="tat-ca" name="category" value="Tất cả" <?php echo ($category == 'Tất cả') ? 'checked' : ''; ?>> 
          <label for="tat-ca">Tất cả</label>
        </li>
        <?php
        if ($result_categories->num_rows > 0) {
            while ($row = $result_categories->fetch_assoc()) {
                echo '<li>
                        <input type="radio" id="'.$row["prefix"].'" name="category" value="'.$row["prefix"].'" '.(($category == $row["prefix"]) ? 'checked' : '').'> 
                        <label for="'.$row["prefix"].'">'.$row["TenDanhMuc"].'</label>
                      </li>';
            }
        }
        ?>
      </ul>
      
      <h3>Khoảng giá</h3>
      <ul>
        <li>
          <input type="radio" id="mien-phi" name="price" value="Miễn phí" <?php echo ($price == 'Miễn phí') ? 'checked' : ''; ?>> 
          <label for="mien-phi">Miễn phí</label>
        </li>
        <li>
          <input type="radio" id="500k-1m" name="price" value="500,000 - 1,000,000 đ" <?php echo ($price == '500,000 - 1,000,000 đ') ? 'checked' : ''; ?>> 
          <label for="500k-1m">500,000 - 1,000,000 đ</label>
        </li>
        <li>
          <input type="radio" id="1m-2m" name="price" value="1,000,000 - 2,000,000 đ" <?php echo ($price == '1,000,000 - 2,000,000 đ') ? 'checked' : ''; ?>> 
          <label for="1m-2m">1,000,000 - 2,000,000 đ</label>
        </li>
        <li>
          <input type="radio" id="2m-3m" name="price" value="2,000,000 - 3,000,000 đ" <?php echo ($price == '2,000,000 - 3,000,000 đ') ? 'checked' : ''; ?>> 
          <label for="2m-3m">2,000,000 - 3,000,000 đ</label>
        </li>
      </ul>
      <button type="submit">Lọc</button>
    </form>
  </div>
  <!-- NỘI DUNG CHÍNH -->
  <main class="main-content">
      <!-- Thanh sắp xếp -->
      <div class="sort-bar">
        <ul>
          <li class="sort-item" data-sort="ascending">Giá</li>
          <li class="sort-item" data-sort="descending">Dưới 1 triệu</li>
          <li class="sort-item" data-sort="price">Được mua nhiều</li>
          <li class="sort-item" data-sort="newest">Mới nhất</li>
        </ul>
      </div>
      <div class="separator"></div>
      <!-- Lưới sản phẩm -->

      <div class="product-grid"> 
          <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="product-card">
                            <div class="containerimg">
                                <span class="img_item">';
                    echo '<img src="'.$row["HinhAnh"].'" alt="'.$row["Ten"].'" class="product-img">
                                </span>
                            </div>
                            <div class="product-info">
                                <h3 class="product-title">'.$row["Ten"].'</h3>
                                <div class="price">'.number_format($row["Gia"], 0, ",", ".").'đ</div>
                                <div class="button-container">
                                    <li><a href="#" class="btn">Xem thử</a></li>
                                    <li><a href="Detailsp.html?id='.$row["IdDichVu"].'" class="btn">Chi tiết</a></li>
                                </div>                  
                            </div>
                        </div>';
                }
            } else {
                echo "<p>Không có dịch vụ nào.</p>";
            }
          ?>
        </div>
        <?php
        $conn->close();
        ?>
   </main>
  </div>
</div>

</body>
</html>