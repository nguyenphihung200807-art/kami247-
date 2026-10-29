<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$gio_hang = $_SESSION['gio_hang'] ?? [];
$don_hang = $_SESSION['don_hang_vua_dat'] ?? null;

// Nếu gửi form đặt hàng từ dathang.php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($gio_hang)) {
    $ten_nguoi_nhan = trim($_POST['ten_nguoi_nhan'] ?? '');
    $so_dien_thoai = trim($_POST['so_dien_thoai_nguoi_nhan'] ?? '');
    $dia_chi = trim($_POST['dia_chi_giao_hang'] ?? '');
    $ghi_chu = trim($_POST['ghi_chu_khach_hang'] ?? '');
    $phuong_thuc = $_POST['phuong_thuc_thanh_toan'] ?? 'thu_khi_nhan';

    $tien_hang = 0;
    foreach ($gio_hang as $item) {
        $tien_hang += $item['gia'] * $item['so_luong'];
    }
    $phi_giao_hang = 15000;
    $tong_thanh_toan = $tien_hang + $phi_giao_hang;
    $ma_don_hang = 'KM-' . date('Ymd') . '-' . strtoupper(substr(md5(uniqid()), 0, 4));

    // Thử lưu vào database nếu có thể
    if (file_exists('kami247.php')) {
        try {
            include_once 'kami247.php';
            if (isset($conn) && $conn && isset($_SESSION['user_id'])) {
                $user_id = $_SESSION['user_id'];
                $pt_tt = in_array($phuong_thuc, ['thu_khi_nhan', 'chuyen_khoan']) ? $phuong_thuc : 'thu_khi_nhan';
                
                $sql_don = "INSERT INTO don_hang (ma_don_hang, ma_nguoi_dung, trang_thai, tien_hang, phi_giao_hang, phuong_thuc_thanh_toan, trang_thai_thanh_toan, ghi_chu_khach_hang) 
                            VALUES (?, ?, 'cho_xac_nhan', ?, ?, ?, 'chua_thanh_toan', ?)";
                $stmt_don = mysqli_prepare($conn, $sql_don);
                if ($stmt_don) {
                    mysqli_stmt_bind_param($stmt_don, "siddss", $ma_don_hang, $user_id, $tien_hang, $phi_giao_hang, $pt_tt, $ghi_chu);
                    if (mysqli_stmt_execute($stmt_don)) {
                        $ma_don_db = mysqli_insert_id($conn);
                        
                        // Lưu thông tin người nhận
                        $sql_nhan = "INSERT INTO thong_tin_giao_hang (ma_don, ten_nguoi_nhan, so_dien_thoai_nguoi_nhan, dia_chi_giao_hang) VALUES (?, ?, ?, ?)";
                        $stmt_nhan = mysqli_prepare($conn, $sql_nhan);
                        if ($stmt_nhan) {
                            mysqli_stmt_bind_param($stmt_nhan, "isss", $ma_don_db, $ten_nguoi_nhan, $so_dien_thoai, $dia_chi);
                            mysqli_stmt_execute($stmt_nhan);
                            mysqli_stmt_close($stmt_nhan);
                        }
                    }
                    mysqli_stmt_close($stmt_don);
                }
            }
        } catch (Throwable $e) {
            // Không làm gián đoạn trải nghiệm của khách
        }
    }

    // Lưu vào session đơn hàng vừa đặt để hiển thị
    $_SESSION['don_hang_vua_dat'] = [
        'ma_don_hang' => $ma_don_hang,
        'ngay_dat' => date('d/m/Y H:i'),
        'ten_nguoi_nhan' => $ten_nguoi_nhan,
        'so_dien_thoai' => $so_dien_thoai,
        'dia_chi' => $dia_chi,
        'ghi_chu' => $ghi_chu,
        'phuong_thuc' => ($phuong_thuc === 'chuyen_khoan') ? 'Chuyển khoản ngân hàng' : 'Thanh toán khi nhận hàng (COD)',
        'items' => $gio_hang,
        'tien_hang' => $tien_hang,
        'phi_giao_hang' => $phi_giao_hang,
        'tong_thanh_toan' => $tong_thanh_toan
    ];

    // Xóa giỏ hàng sau khi đặt thành công
    $_SESSION['gio_hang'] = [];
    $don_hang = $_SESSION['don_hang_vua_dat'];
}
?>
<!DOCTYPE html>
<html lang="vi">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Đặt hàng thành công - KAMI247</title>
    <link rel="stylesheet" href="site.css">
    <link rel="stylesheet" href="dathangthanhcong.css">
    <style>
      .thong-tin-nhan-hang {
        background: #fdfdfd;
        border: 1px solid #eee;
        padding: 12px 16px;
        border-radius: 6px;
        margin: 15px 0;
        font-size: 14px;
        line-height: 1.6;
      }
    </style>
  </head>
  <body>
    <div class="thanh-thong-bao">
      <div class="khung">Một chút ngon lành mỗi ngày
        <div class="ngat-dong"></div>
      </div>
    </div>
    <div class="dau-trang">
      <div class="khung">
        <a class="thuong-hieu" href="trangchu.php">kami<span>247</span><small>TIỆM NHỎ CỦA BẠN</small></a>
        <div class="lien-ket-dau">
          <a href="trangchu.php#san-pham">Khám phá cửa hàng</a>
          <a href="dangnhap.html">Đăng nhập</a>
          <a class="gio-hang" href="dathang.php#gio-hang">Giỏ hàng · 0</a>
        </div>
        <div class="ngat-dong"></div>
      </div>
    </div>
    <div class="thanh-danh-muc">
      <div class="khung">
        <a href="trangchu.php#mi">Mì &amp; đồ ăn liền</a>
        <a href="trangchu.php#nuoc">Nước giải khát</a>
        <a href="trangchu.php#com">Cơm &amp; đồ ăn nóng</a>
        <a href="trangchu.php#snack">Snack &amp; bánh kẹo</a>
        <a href="trangchu.php#kem">Kem mát lạnh</a>
        <div class="ngat-dong"></div>
      </div>
    </div>
    <div id="noi-dung" class="khung">
      <div class="xac-nhan-thanh-cong">
        <p class="dong-nho">KAMI247 / HOÀN TẤT ĐẶT HÀNG</p>
        <p class="dau-thanh-cong">&#10003;</p>
        <h1>Đặt hàng thành công!</h1>
        <p>Cảm ơn bạn đã lựa chọn KAMI247. Đơn hàng của bạn đang được chuẩn bị.</p>
      </div>

      <?php if ($don_hang): ?>
        <div class="chi-tiet-xac-nhan hop">
          <p class="dong-nho">MÃ ĐƠN HÀNG: <strong><?= htmlspecialchars($don_hang['ma_don_hang']) ?></strong> (<?= htmlspecialchars($don_hang['ngay_dat']) ?>)</p>
          
          <div class="thong-tin-nhan-hang">
            <strong>Người nhận:</strong> <?= htmlspecialchars($don_hang['ten_nguoi_nhan']) ?> (<?= htmlspecialchars($don_hang['so_dien_thoai']) ?>)<br>
            <strong>Địa chỉ giao:</strong> <?= htmlspecialchars($don_hang['dia_chi']) ?><br>
            <strong>Hình thức thanh toán:</strong> <?= htmlspecialchars($don_hang['phuong_thuc']) ?><br>
            <?php if (!empty($don_hang['ghi_chu'])): ?>
              <strong>Ghi chú:</strong> <?= htmlspecialchars($don_hang['ghi_chu']) ?>
            <?php endif; ?>
          </div>

          <h2>Những món đã đặt</h2>
          <ul class="dong-hang">
            <?php foreach ($don_hang['items'] as $item): 
              $thanh_tien = $item['gia'] * $item['so_luong'];
            ?>
              <li>
                <?= htmlspecialchars($item['ten']) ?> × <?= $item['so_luong'] ?>
                <strong><?= number_format($thanh_tien, 0, ',', '.') ?> ₫</strong>
                <div class="ngat-dong"></div>
              </li>
            <?php endforeach; ?>
          </ul>
          <p class="dong-tien">Tiền hàng <strong><?= number_format($don_hang['tien_hang'], 0, ',', '.') ?> ₫</strong></p>
          <p class="dong-tien">Phí giao hàng <strong><?= number_format($don_hang['phi_giao_hang'], 0, ',', '.') ?> ₫</strong></p>
          <p class="dong-tien tong-tien">Tổng thanh toán <strong><?= number_format($don_hang['tong_thanh_toan'], 0, ',', '.') ?> ₫</strong></p>
          <div class="ngat-dong"></div>
          <p class="loi-nhan">KAMI sẽ liên hệ số điện thoại của bạn trước khi giao hàng.</p>
          <a class="nut" href="trangchu.php#san-pham">Tiếp tục mua sắm</a>
          <a class="nut-phu" href="trangchu.php">Về trang chủ</a>
        </div>
      <?php else: ?>
        <div class="chi-tiet-xac-nhan hop" style="text-align: center;">
          <p>Chưa có thông tin đơn hàng mới.</p>
          <a class="nut" href="trangchu.php#san-pham">Dạo một vòng cửa hàng</a>
        </div>
      <?php endif; ?>
    </div>
    <div class="chan-trang">
      <div class="khung">
        <div class="cot-chan">
          <p class="ten-chan">kami247</p>
          <p>Món quen, vị mới.<br>Một góc nhỏ cho những điều ngon lành.</p>
        </div>
        <div class="cot-chan">
          <h2>Khám phá</h2>
          <a href="trangchu.php#san-pham">Danh mục sản phẩm</a>
          <a href="dathang.php">Giỏ hàng & đặt hàng</a>
          <a href="taikhoan.html">Hồ sơ người dùng</a>
        </div>
        <div class="cot-chan">
          <h2>KAMI247</h2>
          <a href="dangnhap.html">Đăng nhập</a>
          <a href="dangky.html">Tạo tài khoản</a>
          <a href="quantri.html">Hồ sơ quản trị viên</a>
        </div>
        <div class="ngat-dong"></div>
        <div class="dong-ban-quyen">
          <p>KAMI247 · Bài thực hành HTML & CSS & PHP</p>
        </div>
      </div>
    </div>
  </body>
</html>
