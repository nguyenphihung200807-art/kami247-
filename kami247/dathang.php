<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$gio_hang = $_SESSION['gio_hang'] ?? [];
$tong_so_luong = 0;
$tien_hang = 0;

foreach ($gio_hang as $item) {
    $tong_so_luong += $item['so_luong'];
    $tien_hang += $item['gia'] * $item['so_luong'];
}

$phi_giao_hang = (!empty($gio_hang)) ? 15000 : 0;
$tong_thanh_toan = $tien_hang + $phi_giao_hang;

// Lấy thông tin user nếu đã đăng nhập
$ho_ten_user = $_SESSION['ho_ten'] ?? '';
$ten_dang_nhap = $_SESSION['user_name'] ?? '';
?>
<!DOCTYPE html>
<html lang="vi">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Giỏ hàng & Đặt hàng - KAMI247</title>
    <link rel="stylesheet" href="site.css">
    <link rel="stylesheet" href="dathang.css">
    <style>
      .mon-trong-gio {
        position: relative;
        padding-bottom: 12px;
        margin-bottom: 12px;
        border-bottom: 1px dashed #eee;
      }
      .nut-xoa-mon {
        color: #d9534f;
        text-decoration: none;
        font-size: 13px;
        margin-left: 8px;
        display: inline-block;
      }
      .nut-xoa-mon:hover {
        text-decoration: underline;
      }
      .dieu-chinh-sl {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        margin-top: 4px;
      }
      .nut-sl-nho {
        background: #f0f0f0;
        border: 1px solid #ccc;
        width: 24px;
        height: 24px;
        border-radius: 4px;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        text-decoration: none;
        color: #333;
      }
      .nut-sl-nho:hover {
        background: #e0e0e0;
      }
      .gio-trong {
        text-align: center;
        padding: 30px 10px;
        color: #666;
      }
      .gio-trong p {
        margin-bottom: 15px;
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
          <?php if (!empty($ten_dang_nhap)): ?>
            <a href="taikhoan.html">Chào, <strong><?= htmlspecialchars($ho_ten_user ?: $ten_dang_nhap) ?></strong></a>
          <?php else: ?>
            <a href="dangnhap.html">Đăng nhập</a>
          <?php endif; ?>
          <a class="gio-hang" href="dathang.php#gio-hang">Giỏ hàng · <?= $tong_so_luong ?></a>
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
      <div class="tieu-de-trang">
        <p class="dong-nho">CỬA HÀNG KAMI247</p>
        <h1>Sắp đủ một bữa ngon.</h1>
        <p>Xem lại các món đã chọn và điền thông tin nhận hàng.</p>
      </div>
      <div class="cot-dat-hang">
        <form action="dathangthanhcong.php" method="post">
          <div class="hop">
            <p class="dong-nho">01 / NGƯỜI NHẬN</p>
            <h2>Thông tin giao hàng</h2>
            <div class="truong">
              <label for="nguoi-nhan">Họ và tên</label>
              <input class="o-nhap" id="nguoi-nhan" type="text" value="<?= htmlspecialchars($ho_ten_user) ?>" maxlength="120" autocomplete="off" name="ten_nguoi_nhan" required>
            </div>
            <div class="truong">
              <label for="so-dien-thoai">Số điện thoại</label>
              <p><small>Dùng định dạng quốc tế, ví dụ +84901234567.</small></p>
              <input class="o-nhap" id="so-dien-thoai" type="text" value="" maxlength="16" autocomplete="off" name="so_dien_thoai_nguoi_nhan" placeholder="+84901234567" required>
            </div>
            <div class="truong">
              <label for="dia-chi">Địa chỉ nhận hàng</label>
              <textarea id="dia-chi" rows="4" cols="30" name="dia_chi_giao_hang" maxlength="500" placeholder="Số nhà, tên đường, phường/xã, quận/huyện..." required></textarea>
            </div>
          </div>
          <div class="hop">
            <p class="dong-nho">02 / GIAO HÀNG</p>
            <h2>Gửi thêm một lời nhắn</h2>
            <div class="truong">
              <label for="ghi-chu">Ghi chú cho đơn hàng</label>
              <textarea id="ghi-chu" rows="4" cols="30" name="ghi_chu_khach_hang" maxlength="1000" placeholder="Ví dụ: giao giờ nghỉ trưa, mang theo tiền lẻ..."></textarea>
            </div>
            <p>Phí giao hàng: <strong><?= number_format($phi_giao_hang, 0, ',', '.') ?> ₫</strong></p>
          </div>
          <div class="hop">
            <p class="dong-nho">03 / THANH TOÁN</p>
            <h2>Bạn muốn thanh toán thế nào?</h2>
            <fieldset>
              <legend>Phương thức thanh toán</legend>
              <p><label><input type="radio" name="phuong_thuc_thanh_toan" value="thu_khi_nhan" checked> Thanh toán khi nhận hàng (COD)</label></p>
              <p><label><input type="radio" name="phuong_thuc_thanh_toan" value="chuyen_khoan"> Chuyển khoản ngân hàng</label></p>
            </fieldset>
          </div>
          <div class="hop" id="xac-nhan">
            <?php if (!empty($gio_hang)): ?>
              <button class="nut" type="submit" style="cursor: pointer; border: none;">Xác nhận đặt hàng</button>
              <input class="nut-phu" type="reset" value="Nhập lại thông tin">
            <?php else: ?>
              <p class="ghi-chu">Giỏ hàng của bạn đang trống. Vui lòng chọn món trước khi đặt hàng.</p>
              <a class="nut" href="trangchu.php#san-pham">Quay lại chọn món</a>
            <?php endif; ?>
          </div>
        </form>
      </div>
      <div class="cot-tom-tat">
        <div class="hop" id="gio-hang">
          <p class="dong-nho">GIỎ HÀNG CỦA BẠN / <?= $tong_so_luong ?> MÓN</p>
          <h2>Những món đã chọn</h2>

          <?php if (empty($gio_hang)): ?>
            <div class="gio-trong">
              <p>Chưa có món nào trong giỏ hàng.</p>
              <a class="nut-phu" href="trangchu.php#san-pham">&larr; Khám phá thực đơn ngay</a>
            </div>
          <?php else: ?>
            <?php foreach ($gio_hang as $ma_sp => $item): 
              $thanh_tien_item = $item['gia'] * $item['so_luong'];
            ?>
              <div class="mon-trong-gio">
                <img src="<?= htmlspecialchars($item['anh']) ?>" alt="<?= htmlspecialchars($item['ten']) ?>">
                <div>
                  <h3><?= htmlspecialchars($item['ten']) ?></h3>
                  <p><?= htmlspecialchars($item['quy_cach'] ?? '') ?></p>
                  <div class="dieu-chinh-sl">
                    <a class="nut-sl-nho" href="them_gio_hang.php?action=cap_nhat&ma_sp=<?= urlencode($ma_sp) ?>&so_luong=<?= $item['so_luong'] - 1 ?>" title="Giảm số lượng">−</a>
                    <span><strong><?= $item['so_luong'] ?></strong></span>
                    <a class="nut-sl-nho" href="them_gio_hang.php?action=cap_nhat&ma_sp=<?= urlencode($ma_sp) ?>&so_luong=<?= $item['so_luong'] + 1 ?>" title="Tăng số lượng">+</a>
                    <a class="nut-xoa-mon" href="them_gio_hang.php?action=xoa&ma_sp=<?= urlencode($ma_sp) ?>" onclick="return confirm('Bạn muốn bỏ món này khỏi giỏ?')">Xóa</a>
                  </div>
                  <strong style="display: block; margin-top: 6px;"><?= number_format($thanh_tien_item, 0, ',', '.') ?> ₫</strong>
                </div>
                <div class="ngat-dong"></div>
              </div>
            <?php endforeach; ?>

            <p class="dong-tien">Tiền hàng <strong><?= number_format($tien_hang, 0, ',', '.') ?> ₫</strong></p>
            <p class="dong-tien">Phí giao hàng <strong><?= number_format($phi_giao_hang, 0, ',', '.') ?> ₫</strong></p>
            <p class="dong-tien tong-tien">Tổng thanh toán <strong><?= number_format($tong_thanh_toan, 0, ',', '.') ?> ₫</strong></p>
            <div style="margin-top: 15px; display: flex; justify-content: space-between;">
              <a href="trangchu.php#san-pham">&larr; Tiếp tục xem món khác</a>
              <a href="them_gio_hang.php?action=xoa_tat_ca" style="color: #d9534f; font-size: 13px;" onclick="return confirm('Bạn có chắc muốn xóa toàn bộ giỏ hàng?')">Xóa hết giỏ</a>
            </div>
          <?php endif; ?>
        </div>
      </div>
      <div class="ngat-dong"></div>
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
          <p>Sản phẩm, giá và đơn hàng là dữ liệu minh họa.</p>
        </div>
      </div>
    </div>
  </body>
</html>
