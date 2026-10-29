<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$gio_hang = $_SESSION['gio_hang'] ?? [];
$tong_so_luong_gio = 0;
foreach ($gio_hang as $item) {
    $tong_so_luong_gio += $item['so_luong'];
}
$ho_ten_user = $_SESSION['ho_ten'] ?? '';
$ten_dang_nhap = $_SESSION['user_name'] ?? '';
?>
<!DOCTYPE html>
<html lang="vi">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Cửa hàng - KAMI247</title>
  <link rel="stylesheet" href="site.css">
  <link rel="stylesheet" href="trangchu.css">
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
      <form class="tim-kiem-nho-gon" action="#san-pham" method="get" onsubmit="locSanPham(event)">
        <input id="tu-khoa" name="tu_khoa" type="text" maxlength="200" placeholder="Tìm món ăn, đồ uống..." oninput="locSanPham(event)">
        <button type="submit">Tìm kiếm</button>
      </form>
      <div class="lien-ket-dau"><a href="trangchu.php#san-pham">Khám phá cửa hàng</a><?php if (!empty($ten_dang_nhap)): ?><a href="taikhoan.html">Chào, <strong><?= htmlspecialchars($ho_ten_user ?: $ten_dang_nhap) ?></strong></a><?php else: ?><a href="dangnhap.html">Đăng nhập</a><?php endif; ?><a class="gio-hang" href="dathang.php#gio-hang">Giỏ hàng · <?= $tong_so_luong_gio ?></a>
      </div>
      <div class="ngat-dong"></div>
    </div>
  </div>
  <div class="thanh-danh-muc">
    <div class="khung"><a href="trangchu.html#mi">Mì &amp; đồ ăn liền</a><a href="trangchu.html#nuoc">Nước giải
        khát</a><a href="trangchu.html#com">Cơm &amp; đồ ăn nóng</a><a href="trangchu.html#snack">Snack &amp; bánh
        kẹo</a><a href="trangchu.html#kem">Kem mát lạnh</a>
      <div class="ngat-dong"></div>
    </div>
  </div>
  <div id="noi-dung" class="khung">
    <div id="thong-bao-tim-kiem" class="thong-bao-tim-kiem"></div>
    <div class="gioi-thieu">
      <div class="loi-chao">
        <div class="loi-chao-trong">
          <p class="dong-nho">GÓC ĐỒ NGON MỖI NGÀY</p>
          <h1>Một chút ngon,<br><em>một ngày vui.</em></h1>
          <p>Từ bữa nhanh gọn đến món nhâm nhi.<br>Ghé KAMI, tìm món hợp tâm trạng hôm nay.</p>
          <a class="nut" href="#san-pham">Dạo một vòng cửa hàng &rarr;</a>
          <p class="chi-so">05 danh mục <span>·</span> 15 món để khám phá</p>
        </div>
      </div>
      <div class="anh-gioi-thieu"><img src="assets/anh-web/cua-hang.jpg"
          alt="Giỏ thực phẩm và đồ uống tại cửa hàng tiện lợi">
        <p>Một bữa nhỏ. Nhiều điều ngon.</p>
      </div>
      <div class="ngat-dong"></div>
    </div>
    <div class="mo-dau" id="san-pham">
      <p class="dong-nho">BẠN ĐANG MUỐN ĂN GÌ?</p>
      <h2>Chọn một chút ngon.</h2>
      <p>Mì nóng, trà mát hay một món ngọt cho giờ nghỉ?</p>
    </div>
    <div class="cac-danh-muc"><a class="o-danh-muc" href="#mi"><img src="assets/anh-web/mi-nuoc.jpg"
          alt="Mì &amp; đồ ăn liền"><span>Mì &amp; đồ ăn liền</span></a><a class="o-danh-muc" href="#nuoc"><img
          src="assets/anh-web/tra-dao.jpg" alt="Nước giải khát"><span>Nước giải khát</span></a><a class="o-danh-muc"
        href="#com"><img src="assets/anh-web/com-nam.jpg" alt="Cơm &amp; đồ ăn nóng"><span>Cơm &amp; đồ ăn
          nóng</span></a><a class="o-danh-muc" href="#snack"><img src="assets/anh-web/snack.jpg"
          alt="Snack &amp; bánh kẹo"><span>Snack &amp; bánh kẹo</span></a><a class="o-danh-muc" href="#kem"><img
          src="assets/anh-web/kem-socola.jpg" alt="Kem mát lạnh"><span>Kem mát lạnh</span></a>
      <div class="ngat-dong"></div>
    </div>
    <p class="chu-thich-anh">Ảnh minh họa món ăn; tên, quy cách và giá dưới đây là dữ liệu mẫu của cửa hàng.</p>
    <div class="nhom-san-pham" id="mi">
      <div class="dau-nhom">
        <p class="dong-nho">DANH MỤC / 01</p>
        <h2>Mì &amp; đồ ăn liền</h2>
        <p>Cho những lúc muốn ăn một món nóng.</p>
      </div>
      <div class="hang-san-pham">
        <div class="cot-san-pham" id="mi-cay-hai-san">
          <div class="the-san-pham">
            <img src="assets/anh-web/mi-nuoc.jpg" alt="Ảnh minh họa nhóm món Mì &amp; đồ ăn liền">
            <div class="noi-dung-the">
              <p class="quy-cach">Gói 75 g</p>
              <h3>Mì cay hải sản</h3>
              <p class="gia">12.000 ₫</p><form class="khung-mua-hang" action="them_gio_hang.php" method="post">
                <input type="hidden" name="ma_sp" value="mi-cay-hai-san">
                <input type="hidden" name="ten_sp" value="Mì cay hải sản">
                <div class="dong-so-luong">
                  <span>Số lượng</span>
                  <div class="bo-chon-so-luong">
                    <button type="button" class="nut-sl" onclick="doiSoLuong(this, -1)">−</button>
                    <input type="number" name="so_luong" class="o-so-luong" value="1" min="1" max="99">
                    <button type="button" class="nut-sl" onclick="doiSoLuong(this, 1)">+</button>
                  </div>
                </div>
                <div class="nhom-nut-mua">
                  <button type="button" class="nut-them-gio" onclick="themVaoGio(this, 'Mì cay hải sản')">+ Thêm vào giỏ</button>
                  <button type="submit" name="mua_ngay" value="1" class="nut-mua-ngay">Mua ngay</button>
                </div>
              </form>
            </div>
          </div>
        </div>
        <div class="cot-san-pham" id="mi-tron-tuong-den">
          <div class="the-san-pham">
            <img src="assets/anh-web/mi-tron.jpg" alt="Ảnh minh họa nhóm món Mì &amp; đồ ăn liền">
            <div class="noi-dung-the">
              <p class="quy-cach">Gói 85 g</p>
              <h3>Mì trộn tương đen</h3>
              <p class="gia">18.000 ₫</p><form class="khung-mua-hang" action="them_gio_hang.php" method="post">
                <input type="hidden" name="ma_sp" value="mi-tron-tuong-den">
                <input type="hidden" name="ten_sp" value="Mì trộn tương đen">
                <div class="dong-so-luong">
                  <span>Số lượng</span>
                  <div class="bo-chon-so-luong">
                    <button type="button" class="nut-sl" onclick="doiSoLuong(this, -1)">−</button>
                    <input type="number" name="so_luong" class="o-so-luong" value="1" min="1" max="99">
                    <button type="button" class="nut-sl" onclick="doiSoLuong(this, 1)">+</button>
                  </div>
                </div>
                <div class="nhom-nut-mua">
                  <button type="button" class="nut-them-gio" onclick="themVaoGio(this, 'Mì trộn tương đen')">+ Thêm vào giỏ</button>
                  <button type="submit" name="mua_ngay" value="1" class="nut-mua-ngay">Mua ngay</button>
                </div>
              </form>
            </div>
          </div>
        </div>
        <div class="cot-san-pham" id="mi-ly-nam">
          <div class="the-san-pham">
            <img src="assets/anh-web/mi-nuoc.jpg" alt="Ảnh minh họa nhóm món Mì &amp; đồ ăn liền">
            <div class="noi-dung-the">
              <p class="quy-cach">Ly 65 g</p>
              <h3>Mì ly vị nấm</h3>
              <p class="gia">16.000 ₫</p><form class="khung-mua-hang" action="them_gio_hang.php" method="post">
                <input type="hidden" name="ma_sp" value="mi-ly-nam">
                <input type="hidden" name="ten_sp" value="Mì ly vị nấm">
                <div class="dong-so-luong">
                  <span>Số lượng</span>
                  <div class="bo-chon-so-luong">
                    <button type="button" class="nut-sl" onclick="doiSoLuong(this, -1)">−</button>
                    <input type="number" name="so_luong" class="o-so-luong" value="1" min="1" max="99">
                    <button type="button" class="nut-sl" onclick="doiSoLuong(this, 1)">+</button>
                  </div>
                </div>
                <div class="nhom-nut-mua">
                  <button type="button" class="nut-them-gio" onclick="themVaoGio(this, 'Mì ly vị nấm')">+ Thêm vào giỏ</button>
                  <button type="submit" name="mua_ngay" value="1" class="nut-mua-ngay">Mua ngay</button>
                </div>
              </form>
            </div>
          </div>
        </div>
        <div class="ngat-dong"></div>
      </div>
    </div>
    <div class="nhom-san-pham" id="nuoc">
      <div class="dau-nhom">
        <p class="dong-nho">DANH MỤC / 02</p>
        <h2>Nước giải khát</h2>
        <p>Một ngụm mát lành cho giờ nghỉ.</p>
      </div>
      <div class="hang-san-pham">
        <div class="cot-san-pham" id="tra-dao">
          <div class="the-san-pham">
            <img src="assets/anh-web/tra-dao.jpg" alt="Ảnh minh họa nhóm món Nước giải khát">
            <div class="noi-dung-the">
              <p class="quy-cach">Chai 450 ml</p>
              <h3>Trà đào thanh mát</h3>
              <p class="gia">15.000 ₫</p><form class="khung-mua-hang" action="them_gio_hang.php" method="post">
                <input type="hidden" name="ma_sp" value="tra-dao">
                <input type="hidden" name="ten_sp" value="Trà đào thanh mát">
                <div class="dong-so-luong">
                  <span>Số lượng</span>
                  <div class="bo-chon-so-luong">
                    <button type="button" class="nut-sl" onclick="doiSoLuong(this, -1)">−</button>
                    <input type="number" name="so_luong" class="o-so-luong" value="1" min="1" max="99">
                    <button type="button" class="nut-sl" onclick="doiSoLuong(this, 1)">+</button>
                  </div>
                </div>
                <div class="nhom-nut-mua">
                  <button type="button" class="nut-them-gio" onclick="themVaoGio(this, 'Trà đào thanh mát')">+ Thêm vào giỏ</button>
                  <button type="submit" name="mua_ngay" value="1" class="nut-mua-ngay">Mua ngay</button>
                </div>
              </form>
            </div>
          </div>
        </div>
        <div class="cot-san-pham" id="tra-xanh">
          <div class="the-san-pham">
            <img src="assets/anh-web/tra-xanh.jpg" alt="Ảnh minh họa nhóm món Nước giải khát">
            <div class="noi-dung-the">
              <p class="quy-cach">Chai 450 ml</p>
              <h3>Trà xanh nguyên vị</h3>
              <p class="gia">13.000 ₫</p><form class="khung-mua-hang" action="them_gio_hang.php" method="post">
                <input type="hidden" name="ma_sp" value="tra-xanh">
                <input type="hidden" name="ten_sp" value="Trà xanh nguyên vị">
                <div class="dong-so-luong">
                  <span>Số lượng</span>
                  <div class="bo-chon-so-luong">
                    <button type="button" class="nut-sl" onclick="doiSoLuong(this, -1)">−</button>
                    <input type="number" name="so_luong" class="o-so-luong" value="1" min="1" max="99">
                    <button type="button" class="nut-sl" onclick="doiSoLuong(this, 1)">+</button>
                  </div>
                </div>
                <div class="nhom-nut-mua">
                  <button type="button" class="nut-them-gio" onclick="themVaoGio(this, 'Trà xanh nguyên vị')">+ Thêm vào giỏ</button>
                  <button type="submit" name="mua_ngay" value="1" class="nut-mua-ngay">Mua ngay</button>
                </div>
              </form>
            </div>
          </div>
        </div>
        <div class="cot-san-pham" id="nuoc-chanh">
          <div class="the-san-pham">
            <img src="assets/anh-web/nuoc-chanh.jpg" alt="Ảnh minh họa nhóm món Nước giải khát">
            <div class="noi-dung-the">
              <p class="quy-cach">Chai 350 ml</p>
              <h3>Nước chanh tươi</h3>
              <p class="gia">14.000 ₫</p><form class="khung-mua-hang" action="them_gio_hang.php" method="post">
                <input type="hidden" name="ma_sp" value="nuoc-chanh">
                <input type="hidden" name="ten_sp" value="Nước chanh tươi">
                <div class="dong-so-luong">
                  <span>Số lượng</span>
                  <div class="bo-chon-so-luong">
                    <button type="button" class="nut-sl" onclick="doiSoLuong(this, -1)">−</button>
                    <input type="number" name="so_luong" class="o-so-luong" value="1" min="1" max="99">
                    <button type="button" class="nut-sl" onclick="doiSoLuong(this, 1)">+</button>
                  </div>
                </div>
                <div class="nhom-nut-mua">
                  <button type="button" class="nut-them-gio" onclick="themVaoGio(this, 'Nước chanh tươi')">+ Thêm vào giỏ</button>
                  <button type="submit" name="mua_ngay" value="1" class="nut-mua-ngay">Mua ngay</button>
                </div>
              </form>
            </div>
          </div>
        </div>
        <div class="ngat-dong"></div>
      </div>
    </div>
    <div class="nhom-san-pham" id="com">
      <div class="dau-nhom">
        <p class="dong-nho">DANH MỤC / 03</p>
        <h2>Cơm &amp; đồ ăn nóng</h2>
        <p>Bữa nhỏ gọn, thêm một lựa chọn cho ngày bận.</p>
      </div>
      <div class="hang-san-pham">
        <div class="cot-san-pham" id="com-nam-ca-ngu">
          <div class="the-san-pham">
            <img src="assets/anh-web/com-nam.jpg" alt="Ảnh minh họa nhóm món Cơm &amp; đồ ăn nóng">
            <div class="noi-dung-the">
              <p class="quy-cach">Phần 110 g</p>
              <h3>Cơm nắm cá ngừ</h3>
              <p class="gia">22.000 ₫</p><form class="khung-mua-hang" action="them_gio_hang.php" method="post">
                <input type="hidden" name="ma_sp" value="com-nam-ca-ngu">
                <input type="hidden" name="ten_sp" value="Cơm nắm cá ngừ">
                <div class="dong-so-luong">
                  <span>Số lượng</span>
                  <div class="bo-chon-so-luong">
                    <button type="button" class="nut-sl" onclick="doiSoLuong(this, -1)">−</button>
                    <input type="number" name="so_luong" class="o-so-luong" value="1" min="1" max="99">
                    <button type="button" class="nut-sl" onclick="doiSoLuong(this, 1)">+</button>
                  </div>
                </div>
                <div class="nhom-nut-mua">
                  <button type="button" class="nut-them-gio" onclick="themVaoGio(this, 'Cơm nắm cá ngừ')">+ Thêm vào giỏ</button>
                  <button type="submit" name="mua_ngay" value="1" class="nut-mua-ngay">Mua ngay</button>
                </div>
              </form>
            </div>
          </div>
        </div>
        <div class="cot-san-pham" id="com-nam-ga">
          <div class="the-san-pham">
            <img src="assets/anh-web/com-nam.jpg" alt="Ảnh minh họa nhóm món Cơm &amp; đồ ăn nóng">
            <div class="noi-dung-the">
              <p class="quy-cach">Phần 110 g</p>
              <h3>Cơm nắm gà teriyaki</h3>
              <p class="gia">24.000 ₫</p><form class="khung-mua-hang" action="them_gio_hang.php" method="post">
                <input type="hidden" name="ma_sp" value="com-nam-ga">
                <input type="hidden" name="ten_sp" value="Cơm nắm gà teriyaki">
                <div class="dong-so-luong">
                  <span>Số lượng</span>
                  <div class="bo-chon-so-luong">
                    <button type="button" class="nut-sl" onclick="doiSoLuong(this, -1)">−</button>
                    <input type="number" name="so_luong" class="o-so-luong" value="1" min="1" max="99">
                    <button type="button" class="nut-sl" onclick="doiSoLuong(this, 1)">+</button>
                  </div>
                </div>
                <div class="nhom-nut-mua">
                  <button type="button" class="nut-them-gio" onclick="themVaoGio(this, 'Cơm nắm gà teriyaki')">+ Thêm vào giỏ</button>
                  <button type="submit" name="mua_ngay" value="1" class="nut-mua-ngay">Mua ngay</button>
                </div>
              </form>
            </div>
          </div>
        </div>
        <div class="cot-san-pham" id="com-nam-nam">
          <div class="the-san-pham">
            <img src="assets/anh-web/com-nam.jpg" alt="Ảnh minh họa nhóm món Cơm &amp; đồ ăn nóng">
            <div class="noi-dung-the">
              <p class="quy-cach">Phần 100 g</p>
              <h3>Cơm nắm nấm mè</h3>
              <p class="gia">20.000 ₫</p><form class="khung-mua-hang" action="them_gio_hang.php" method="post">
                <input type="hidden" name="ma_sp" value="com-nam-nam">
                <input type="hidden" name="ten_sp" value="Cơm nắm nấm mè">
                <div class="dong-so-luong">
                  <span>Số lượng</span>
                  <div class="bo-chon-so-luong">
                    <button type="button" class="nut-sl" onclick="doiSoLuong(this, -1)">−</button>
                    <input type="number" name="so_luong" class="o-so-luong" value="1" min="1" max="99">
                    <button type="button" class="nut-sl" onclick="doiSoLuong(this, 1)">+</button>
                  </div>
                </div>
                <div class="nhom-nut-mua">
                  <button type="button" class="nut-them-gio" onclick="themVaoGio(this, 'Cơm nắm nấm mè')">+ Thêm vào giỏ</button>
                  <button type="submit" name="mua_ngay" value="1" class="nut-mua-ngay">Mua ngay</button>
                </div>
              </form>
            </div>
          </div>
        </div>
        <div class="ngat-dong"></div>
      </div>
    </div>
    <div class="nhom-san-pham" id="snack">
      <div class="dau-nhom">
        <p class="dong-nho">DANH MỤC / 04</p>
        <h2>Snack &amp; bánh kẹo</h2>
        <p>Một chút giòn vui để nhâm nhi.</p>
      </div>
      <div class="hang-san-pham">
        <div class="cot-san-pham" id="snack-khoai-tay">
          <div class="the-san-pham">
            <img src="assets/anh-web/snack.jpg" alt="Ảnh minh họa nhóm món Snack &amp; bánh kẹo">
            <div class="noi-dung-the">
              <p class="quy-cach">Gói 60 g</p>
              <h3>Snack khoai tây</h3>
              <p class="gia">17.000 ₫</p><form class="khung-mua-hang" action="them_gio_hang.php" method="post">
                <input type="hidden" name="ma_sp" value="snack-khoai-tay">
                <input type="hidden" name="ten_sp" value="Snack khoai tây">
                <div class="dong-so-luong">
                  <span>Số lượng</span>
                  <div class="bo-chon-so-luong">
                    <button type="button" class="nut-sl" onclick="doiSoLuong(this, -1)">−</button>
                    <input type="number" name="so_luong" class="o-so-luong" value="1" min="1" max="99">
                    <button type="button" class="nut-sl" onclick="doiSoLuong(this, 1)">+</button>
                  </div>
                </div>
                <div class="nhom-nut-mua">
                  <button type="button" class="nut-them-gio" onclick="themVaoGio(this, 'Snack khoai tây')">+ Thêm vào giỏ</button>
                  <button type="submit" name="mua_ngay" value="1" class="nut-mua-ngay">Mua ngay</button>
                </div>
              </form>
            </div>
          </div>
        </div>
        <div class="cot-san-pham" id="snack-rong-bien">
          <div class="the-san-pham">
            <img src="assets/anh-web/snack.jpg" alt="Ảnh minh họa nhóm món Snack &amp; bánh kẹo">
            <div class="noi-dung-the">
              <p class="quy-cach">Gói 45 g</p>
              <h3>Snack rong biển</h3>
              <p class="gia">19.000 ₫</p><form class="khung-mua-hang" action="them_gio_hang.php" method="post">
                <input type="hidden" name="ma_sp" value="snack-rong-bien">
                <input type="hidden" name="ten_sp" value="Snack rong biển">
                <div class="dong-so-luong">
                  <span>Số lượng</span>
                  <div class="bo-chon-so-luong">
                    <button type="button" class="nut-sl" onclick="doiSoLuong(this, -1)">−</button>
                    <input type="number" name="so_luong" class="o-so-luong" value="1" min="1" max="99">
                    <button type="button" class="nut-sl" onclick="doiSoLuong(this, 1)">+</button>
                  </div>
                </div>
                <div class="nhom-nut-mua">
                  <button type="button" class="nut-them-gio" onclick="themVaoGio(this, 'Snack rong biển')">+ Thêm vào giỏ</button>
                  <button type="submit" name="mua_ngay" value="1" class="nut-mua-ngay">Mua ngay</button>
                </div>
              </form>
            </div>
          </div>
        </div>
        <div class="cot-san-pham" id="banh-quy-cacao">
          <div class="the-san-pham">
            <img src="assets/anh-web/banh-quy.jpg" alt="Ảnh minh họa nhóm món Snack &amp; bánh kẹo">
            <div class="noi-dung-the">
              <p class="quy-cach">Gói 80 g</p>
              <h3>Bánh quy cacao</h3>
              <p class="gia">23.000 ₫</p><form class="khung-mua-hang" action="them_gio_hang.php" method="post">
                <input type="hidden" name="ma_sp" value="banh-quy-cacao">
                <input type="hidden" name="ten_sp" value="Bánh quy cacao">
                <div class="dong-so-luong">
                  <span>Số lượng</span>
                  <div class="bo-chon-so-luong">
                    <button type="button" class="nut-sl" onclick="doiSoLuong(this, -1)">−</button>
                    <input type="number" name="so_luong" class="o-so-luong" value="1" min="1" max="99">
                    <button type="button" class="nut-sl" onclick="doiSoLuong(this, 1)">+</button>
                  </div>
                </div>
                <div class="nhom-nut-mua">
                  <button type="button" class="nut-them-gio" onclick="themVaoGio(this, 'Bánh quy cacao')">+ Thêm vào giỏ</button>
                  <button type="submit" name="mua_ngay" value="1" class="nut-mua-ngay">Mua ngay</button>
                </div>
              </form>
            </div>
          </div>
        </div>
        <div class="ngat-dong"></div>
      </div>
    </div>
    <div class="nhom-san-pham" id="kem">
      <div class="dau-nhom">
        <p class="dong-nho">DANH MỤC / 05</p>
        <h2>Kem mát lạnh</h2>
        <p>Dành một khoảng nghỉ thật ngọt ngào.</p>
      </div>
      <div class="hang-san-pham">
        <div class="cot-san-pham" id="kem-dau">
          <div class="the-san-pham">
            <img src="assets/anh-web/kem.jpg" alt="Ảnh minh họa nhóm món Kem mát lạnh">
            <div class="noi-dung-the">
              <p class="quy-cach">Que 70 g</p>
              <h3>Kem que vị dâu</h3>
              <p class="gia">15.000 ₫</p><form class="khung-mua-hang" action="them_gio_hang.php" method="post">
                <input type="hidden" name="ma_sp" value="kem-dau">
                <input type="hidden" name="ten_sp" value="Kem que vị dâu">
                <div class="dong-so-luong">
                  <span>Số lượng</span>
                  <div class="bo-chon-so-luong">
                    <button type="button" class="nut-sl" onclick="doiSoLuong(this, -1)">−</button>
                    <input type="number" name="so_luong" class="o-so-luong" value="1" min="1" max="99">
                    <button type="button" class="nut-sl" onclick="doiSoLuong(this, 1)">+</button>
                  </div>
                </div>
                <div class="nhom-nut-mua">
                  <button type="button" class="nut-them-gio" onclick="themVaoGio(this, 'Kem que vị dâu')">+ Thêm vào giỏ</button>
                  <button type="submit" name="mua_ngay" value="1" class="nut-mua-ngay">Mua ngay</button>
                </div>
              </form>
            </div>
          </div>
        </div>
        <div class="cot-san-pham" id="kem-matcha">
          <div class="the-san-pham">
            <img src="assets/anh-web/kem.jpg" alt="Ảnh minh họa nhóm món Kem mát lạnh">
            <div class="noi-dung-the">
              <p class="quy-cach">Que 70 g</p>
              <h3>Kem que matcha</h3>
              <p class="gia">18.000 ₫</p><form class="khung-mua-hang" action="them_gio_hang.php" method="post">
                <input type="hidden" name="ma_sp" value="kem-matcha">
                <input type="hidden" name="ten_sp" value="Kem que matcha">
                <div class="dong-so-luong">
                  <span>Số lượng</span>
                  <div class="bo-chon-so-luong">
                    <button type="button" class="nut-sl" onclick="doiSoLuong(this, -1)">−</button>
                    <input type="number" name="so_luong" class="o-so-luong" value="1" min="1" max="99">
                    <button type="button" class="nut-sl" onclick="doiSoLuong(this, 1)">+</button>
                  </div>
                </div>
                <div class="nhom-nut-mua">
                  <button type="button" class="nut-them-gio" onclick="themVaoGio(this, 'Kem que matcha')">+ Thêm vào giỏ</button>
                  <button type="submit" name="mua_ngay" value="1" class="nut-mua-ngay">Mua ngay</button>
                </div>
              </form>
            </div>
          </div>
        </div>
        <div class="cot-san-pham" id="kem-socola">
          <div class="the-san-pham">
            <img src="assets/anh-web/kem-socola.jpg" alt="Ảnh minh họa nhóm món Kem mát lạnh">
            <div class="noi-dung-the">
              <p class="quy-cach">Que 75 g</p>
              <h3>Kem que sô-cô-la</h3>
              <p class="gia">19.000 ₫</p><form class="khung-mua-hang" action="them_gio_hang.php" method="post">
                <input type="hidden" name="ma_sp" value="kem-socola">
                <input type="hidden" name="ten_sp" value="Kem que sô-cô-la">
                <div class="dong-so-luong">
                  <span>Số lượng</span>
                  <div class="bo-chon-so-luong">
                    <button type="button" class="nut-sl" onclick="doiSoLuong(this, -1)">−</button>
                    <input type="number" name="so_luong" class="o-so-luong" value="1" min="1" max="99">
                    <button type="button" class="nut-sl" onclick="doiSoLuong(this, 1)">+</button>
                  </div>
                </div>
                <div class="nhom-nut-mua">
                  <button type="button" class="nut-them-gio" onclick="themVaoGio(this, 'Kem que sô-cô-la')">+ Thêm vào giỏ</button>
                  <button type="submit" name="mua_ngay" value="1" class="nut-mua-ngay">Mua ngay</button>
                </div>
              </form>
            </div>
          </div>
        </div>
        <div class="ngat-dong"></div>
      </div>
    </div>
    <div class="loi-moi">
      <div class="loi-moi-chu">
        <p class="dong-nho">GÓC RIÊNG CỦA BẠN</p>
        <h2>Món quen ở đây.<br>Lần sau, ghé lại nhé.</h2><a class="nut" href="dangky.html">Tạo tài khoản &rarr;</a>
      </div>
      <div class="loi-moi-anh"><img src="assets/anh-web/banh-quy.jpg" alt="Bánh quy sô-cô-la trên đĩa">
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
        <h2>Khám phá</h2><a href="trangchu.php#san-pham">Danh mục sản phẩm</a><a href="dathang.php">Giỏ hàng & đặt
          hàng</a><a href="taikhoan.html">Hồ sơ người dùng</a>
      </div>
      <div class="cot-chan">
        <h2>KAMI247</h2><a href="dangnhap.html">Đăng nhập</a><a href="dangky.html">Tạo tài khoản</a><a
          href="quantri.html">Hồ sơ quản trị viên</a>
      </div>
      <div class="ngat-dong"></div>
      <div class="dong-ban-quyen">
        <p>KAMI247 · Bài thực hành HTML & CSS</p>
        <p>Sản phẩm, giá và đơn hàng là dữ liệu minh họa. Ảnh chụp từ <a href="https://unsplash.com">Unsplash</a>, dùng
          minh họa nhóm món ăn.</p>
      </div>
    </div>
  </div>
  <div id="thong-bao-gio-noi" class="thong-bao-gio-noi"></div>
  <script>
    function doiSoLuong(btn, thayDoi) {
      var oNhap = btn.parentElement.querySelector('.o-so-luong');
      var hienTai = parseInt(oNhap.value, 10) || 1;
      var moi = hienTai + thayDoi;
      if (moi >= 1 && moi <= 99) {
        oNhap.value = moi;
      }
    }

    var tongGioHang = <?= (int)$tong_so_luong_gio ?>;
    function themVaoGio(btn, tenMon) {
      var form = btn.closest('.khung-mua-hang');
      var sl = parseInt(form.querySelector('.o-so-luong').value, 10) || 1;
      
      var formData = new FormData(form);
      formData.append('ajax', '1');
      formData.append('action', 'them');

      fetch('them_gio_hang.php', {
        method: 'POST',
        body: formData
      })
      .then(function(res) { return res.json(); })
      .then(function(data) {
        if (data && data.success) {
          tongGioHang = data.tong_so_luong;
          var nutGio = document.querySelector('.lien-ket-dau .gio-hang');
          if (nutGio) {
            nutGio.textContent = 'Giỏ hàng · ' + tongGioHang;
          }
          var tb = document.getElementById('thong-bao-gio-noi');
          if (tb) {
            tb.textContent = '✓ Đã thêm ' + sl + ' × "' + tenMon + '" vào giỏ hàng!';
            tb.style.display = 'block';
            clearTimeout(window._henGioTb);
            window._henGioTb = setTimeout(function() {
              tb.style.display = 'none';
            }, 2500);
          }
        }
      })
      .catch(function(err) {
        // Fallback gửi form thông thường nếu trình duyệt lỗi fetch
        form.submit();
      });
    }

    function xuLyMuaHang(event, form) {
      // Chuyển sang trang đặt hàng (sau này bạn chỉ cần đổi action="them_gio_hang.php" method="post")
      return true;
    }

    function boDauTiengViet(str) {
      return str.normalize('NFD').replace(/[\u0300-\u036f]/g, '').replace(/đ/g, 'd').replace(/Đ/g, 'D').toLowerCase();
    }

    function locSanPham(event) {
      if (event && event.type === 'submit') {
        event.preventDefault();
      }
      var oTim = document.getElementById('tu-khoa');
      var tuKhoaGoc = oTim ? oTim.value.trim() : '';
      var tuKhoa = boDauTiengViet(tuKhoaGoc);
      var cacNhom = document.querySelectorAll('.nhom-san-pham');
      var tongTimThay = 0;

      cacNhom.forEach(function(nhom) {
        var cacMon = nhom.querySelectorAll('.cot-san-pham');
        var demTrongNhom = 0;
        cacMon.forEach(function(mon) {
          var noiDung = boDauTiengViet(mon.innerText);
          if (tuKhoa === '' || noiDung.indexOf(tuKhoa) !== -1) {
            mon.style.display = '';
            demTrongNhom++;
            tongTimThay++;
          } else {
            mon.style.display = 'none';
          }
        });
        nhom.style.display = (demTrongNhom > 0 || tuKhoa === '') ? '' : 'none';
      });

      var thongBao = document.getElementById('thong-bao-tim-kiem');
      if (thongBao) {
        if (tuKhoaGoc !== '') {
          thongBao.style.display = 'block';
          if (tongTimThay > 0) {
            thongBao.innerHTML = 'Tìm thấy <strong>' + tongTimThay + '</strong> món phù hợp với từ khóa "<strong>' + tuKhoaGoc + '</strong>".';
          } else {
            thongBao.innerHTML = 'Không tìm thấy món hàng nào khớp với từ khóa "<strong>' + tuKhoaGoc + '</strong>".';
          }
        } else {
          thongBao.style.display = 'none';
        }
      }

      if (event && event.type === 'submit' && tuKhoaGoc !== '') {
        var khuSanPham = document.getElementById('san-pham');
        if (khuSanPham) {
          khuSanPham.scrollIntoView({ behavior: 'smooth' });
        }
      }
    }
  </script>
</body>

</html>
