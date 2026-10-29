<?php
ob_start();
session_start();
require_once 'kami247.php';
$tt = new ketnoi;
$loi ="";
$thong_bao = "";

if (isset($_POST['dangky'])) {
    $user = trim($_POST['ten_dang_nhap']);
    $hoten = trim($_POST['ho_ten']);
    $gmail = strtolower(trim($_POST['gmail']));
    $sdt = trim($_POST['so_dien_thoai']);
    $pass = $_POST['mat_khau'];
    $nhap_lai = $_POST['nhap_lai_mat_khau'];

    if (empty($user) || empty($gmail) || empty($sdt) || empty($pass)) {
        $loi = "Vui lòng điền đầy đủ các trường bắt buộc!";
    } elseif (!preg_match('/^[a-z0-9_.-]{3,50}$/', $user)) {
        $loi = "Tên đăng nhập từ 3–50 ký tự, chỉ gồm chữ thường không dấu, số, '.', '_' hoặc '-'!";
    } elseif (!filter_var($gmail, FILTER_VALIDATE_EMAIL)) {
        $loi = "Định dạng Email không hợp lệ!";
    } elseif (!preg_match('/^[+][1-9][0-9]{7,14}$/', $sdt)) {
        $loi = "Số điện thoại phải thuộc định dạng quốc tế (VD: +84901234567)!";
    } elseif ($pass !== $nhap_lai) {
        $loi = "Mật khẩu nhập lại không trùng khớp!";
    } else {
        // 3. Kiểm tra trùng lặp thông tin trong CSDL
        $kq = $tt->KiemTraTrung($user, $gmail, $sdt);

        if (mysqli_num_rows($kq) > 0) {
            $row = $kq->fetch_assoc();
            if ($row['ten_dang_nhap'] === $user) {
                echo $loi = "Tên đăng nhập đã được sử dụng!";
            } elseif (strtolower($row['gmail']) === $gmail) {
                $loi = "Địa chỉ Email đã được đăng ký!";
            } else {
                $loi = "Số điện thoại đã được đăng ký!";
            }
        } else {
            // 4. Mã hóa mật khẩu an toàn với Bcrypt
            $pass_bam = password_hash($pass, PASSWORD_BCRYPT);

            // 5. Gọi hàm thêm người dùng mới vào CSDL
            $kq = $tt->XuLyDangKy($user, $hoten, $gmail, $sdt, $pass_bam);

            if ($kq) {
                $_SESSION['thong_bao_dang_nhap'] = "Tạo tài khoản thành công! Vui lòng đăng nhập.";
                header("Location: dangnhap.html");
                exit();
            } else {
                $loi = "Đăng ký thất bại do lỗi hệ thống CSDL!";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Đăng ký - KAMI247</title>
    <link rel="stylesheet" href="site.css">
    <link rel="stylesheet" href="dangky.css">
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
      <div class="duong-dan"><a href="trangchu.html">Trang chủ</a> / Đăng ký
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
            <h1>Tạo tài khoản mới</h1>
            <p>Điền thông tin để làm quen với KAMI.</p>

            <?php if (!empty($loi)): ?>
                <p style="color: #d9534f; font-weight: bold; margin-bottom: 15px;"><?php echo $loi; ?></p>
            <?php endif; ?>

            <p class="ghi-chu">Giao diện thực hành. Thông tin nhập chưa được gửi hoặc lưu.</p>
            <form action="dangky.php" method="POST" id="dangky">
              <div class="truong">
                <label for="ten-dang-nhap">Tên đăng nhập</label><p><small>3–50 ký tự: chữ thường không dấu, số, dấu chấm, gạch dưới hoặc gạch ngang.</small></p>
                <input class="o-nhap" id="ten-dang-nhap" type="text" value="" maxlength="50" autocomplete="off" name="ten_dang_nhap" required>
              </div>
              <div class="truong">
                <label for="ho-ten">Họ và tên</label>
                <input class="o-nhap" id="ho-ten" type="text" value="" maxlength="120" autocomplete="off" name="ho_ten">
              </div>
              <div class="truong">
                <label for="email">Email</label>
                <input class="o-nhap" id="email" type="text" value="" maxlength="254" autocomplete="off" name="gmail" required>
              </div>
              <div class="truong">
                <label for="dien-thoai">Số điện thoại</label><p><small>Dùng định dạng quốc tế, ví dụ +84901234567. Khi lưu dữ liệu, không để trống.</small></p>
                <input class="o-nhap" id="dien-thoai" type="text" value="" maxlength="16" autocomplete="off" name="so_dien_thoai" required>
              </div>
              <div class="truong">
                <label for="mat-khau">Mật khẩu</label>
                <input class="o-nhap" id="mat-khau" type="password" value="" maxlength="120" autocomplete="off" name="mat_khau" required>
              </div>
              <div class="truong">
                <label for="nhap-lai">Nhập lại mật khẩu</label>
                <input class="o-nhap" id="nhap-lai" type="password" value="" maxlength="120" autocomplete="off" name="nhap_lai_mat_khau" required>
              </div>
              <input class="nut nut-tat" name="dangky" type="submit" value="Tạo tài khoản">
              <input class="nut-phu" name="reset" type="reset" value="Nhập lại">
            </form>
            <p class="chuyen-trang">Đã có tài khoản? <a href="dangnhap.html">Đăng nhập</a></p><a href="taikhoan.html">Xem hồ sơ người dùng &rarr;</a>
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