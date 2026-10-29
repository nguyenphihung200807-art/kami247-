<?php
ob_start();
session_start();
require_once 'kami247.php';
$tt = new ketnoi;
$loi = "";
$thong_bao = "";

if (isset($_SESSION['thong_bao_dang_nhap'])) {
    $thong_bao = $_SESSION['thong_bao_dang_nhap'];
    unset($_SESSION['thong_bao_dang_nhap']); 
}

if (isset($_POST['dangnhap'])) {
    $user = trim($_POST['ten_dang_nhap']);
    $pass = $_POST['mat_khau'];

    if (empty($user) || empty($pass)) {
        $loi = "Vui lòng nhập Tên đăng nhập và Mật khẩu!";
    } else {
        $kq = $tt->XuLyDangNhap($user);

        if (mysqli_num_rows($kq) > 0) {
            $row = $kq->fetch_assoc();

            if ($row['dang_hoat_dong'] == 0) {
                echo $loi = "Tài khoản của bạn hiện đang bị khóa!";
            } elseif (password_verify($pass, $row['mat_khau_bam'])) {
                // Mật khẩu đúng -> Tạo Session và chuyển hướng
                $_SESSION['idUser']   = $row['ma'];
                $_SESSION['username'] = $row['ten_dang_nhap'];
                $_SESSION['hoten']    = $row['ho_ten'];
                $_SESSION['vaitro']   = $row['vai_tro'];

                if ($row['vai_tro'] == 'quan_tri') {
                    header("Location: quantri.html");
                } else {
                    header("Location: trangchu.html");
                }
                exit();
            } else {
                $loi = "Mật khẩu không chính xác!";
            }
        } else {
            // NẾU FALSE (Không tìm thấy tài khoản):
            $loi = "Tên đăng nhập không tồn tại!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Đăng nhập - KAMI247</title>
    <link rel="stylesheet" href="site.css">
    <link rel="stylesheet" href="dangnhap.css">
  </head>
  <body>
    <div class="thanh-thong-bao">
      <div class="khung">Một chút ngon lành mỗi ngày
        <div class="ngat-dong"></div>
      </div>
    </div>
    <div class="dau-trang">
      <div class="khung">
        <a class="thuong-hieu" href="trangchu.html">kami<span>247</span><small>TIỆM NHỎ CỦA BẠN</small></a>
        <div class="lien-ket-dau"><a href="trangchu.html#san-pham">Khám phá cửa hàng</a><a href="dangnhap.html">Đăng nhập</a><a class="gio-hang" href="dathang.html#gio-hang">Giỏ hàng mẫu · 3</a>
        </div>
        <div class="ngat-dong"></div>
      </div>
    </div>
    <div id="noi-dung" class="khung">
      <div class="duong-dan"><a href="trangchu.html">Trang chủ</a> / Đăng nhập
      </div>
      <div class="bo-cuc-tai-khoan">
        <div class="cot-trai-auth">
          <div class="gioi-thieu-tai-khoan">
            <p class="dong-nho">TIỆM NHỎ CỦA BẠN</p>
            <h2>Món quen.<br>Vị mới.<br><em>Ghé KAMI thôi.</em></h2><img src="assets/anh-web/cua-hang.jpg" alt="Giỏ đồ ăn tiện lợi">
            <p>Một bữa nhanh gọn, một giờ nghỉ thật vui.</p>
          </div>
        </div>
        <div class="cot-phai-auth">
          <div class="hop-form">
            <p class="dong-nho">TÀI KHOẢN KAMI247</p>
            <h1>Chào bạn trở lại.</h1>
            <p>Đăng nhập vào góc riêng của bạn.</p>

            <?php if (!empty($loi)): ?>
                <p style="color: #d9534f; font-weight: bold; margin-bottom: 15px; background-color: #f2dede; padding: 10px; border-radius: 4px; border: 1px solid #ebccd1;">
                    <?php echo $loi; ?>
                </p>
            <?php endif; ?>

            <?php if (!empty($thong_bao)): ?>
                <p style="color: #3c763d; font-weight: bold; margin-bottom: 15px; background-color: #dff0d8; padding: 10px; border-radius: 4px; border: 1px solid #d6e9c6;">
                    <?php echo $thong_bao; ?>
                </p>
            <?php endif; ?>

            <p class="ghi-chu">Giao diện thực hành. Thông tin nhập chưa được gửi hoặc lưu.</p>
            <form action="dangnhap.php" method="POST" id="dangnhap">
              <div class="truong">
                <label for="ten-dang-nhap">Tên đăng nhập</label><p><small>3–50 ký tự: chữ thường không dấu, số, dấu chấm, gạch dưới hoặc gạch ngang.</small></p>
                <input class="o-nhap" id="ten-dang-nhap" type="text" value="" maxlength="50" autocomplete="off" name="ten_dang_nhap" required>
              </div>
              <div class="truong">
                <label for="mat-khau">Mật khẩu</label>
                <input class="o-nhap" id="mat-khau" type="password" value="" maxlength="120" autocomplete="off" name="mat_khau" required>
              </div>
              <input class="nut nut-tat" name="dangnhap" type="submit" value="Đăng nhập">
              <input class="nut-phu" name="reset" type="reset" value="Nhập lại">
            </form>
            <p class="chuyen-trang">Lần đầu ghé KAMI? <a href="dangky.html">Đăng ký ngay</a></p><a href="taikhoan.html">Xem hồ sơ người dùng &rarr;</a>
          </div>
        </div>
        <div class="ngat-dong"></div>
      </div>
    </div>
    <div class="chan-trang">
      <div class="khung">
        <div class="cot-chan">
          <p class="ten-chan">kami247</p>
          <p>Món quen, vị mới.<br>Một góc nhỏ cho những điều ngon lành.</p>
        </div>
        <div class="cot-chan">
          <h2>Khám phá</h2><a href="trangchu.html#san-pham">Danh mục sản phẩm</a><a href="dathang.html">Giỏ hàng & đặt hàng</a><a href="taikhoan.html">Hồ sơ người dùng</a>
        </div>
        <div class="cot-chan">
          <h2>KAMI247</h2><a href="dangnhap.html">Đăng nhập</a><a href="dangky.html">Tạo tài khoản</a><a href="quantri.html">Hồ sơ quản trị viên</a>
        </div>
        <div class="ngat-dong"></div>
        <div class="dong-ban-quyen">
          <p>KAMI247 · Bài thực hành HTML & CSS</p>
          <p>Sản phẩm, giá và đơn hàng là dữ liệu minh họa. Ảnh chụp từ <a href="https://unsplash.com">Unsplash</a>, dùng minh họa nhóm món ăn.</p>
        </div>
      </div>
    </div>
  </body>
</html>
