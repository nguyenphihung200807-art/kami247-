-- KAMI247 v10: nhập một file cho cơ sở dữ liệu MỚI.
-- 8 bảng tiếng Việt không dấu; danh_muc chỉ gồm ma và ten.
-- nguoi_dung bổ sung mật khẩu băm, vai trò và trạng thái hoạt động.
-- don_hang không lưu tên, số điện thoại người nhận hoặc địa chỉ giao hàng.
-- 5 danh mục và 15 sản phẩm minh họa.

-- KAMI247 - cấu trúc cơ sở dữ liệu v10, tên tiếng Việt không dấu theo giao diện cửa hàng và tài khoản.
-- MySQL >= 8.0.16 (khuyến nghị 8.4); tương thích MariaDB >= 10.4.
-- Chỉ nhập vào database mới. Không xóa hoặc thay thế bảng đã tồn tại.
-- Lệnh đổi cấu trúc có thể tự xác nhận thay đổi; không coi toàn bộ file là một giao dịch.

SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci;
SET time_zone = '+00:00';

CREATE DATABASE IF NOT EXISTS kami247
    CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE kami247;

CREATE TABLE nguoi_dung (
    ma BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    ten_dang_nhap VARCHAR(50) CHARACTER SET ascii COLLATE ascii_general_ci NOT NULL,
    ho_ten VARCHAR(120) NULL,
    gmail VARCHAR(254) CHARACTER SET ascii COLLATE ascii_general_ci NOT NULL,
    so_dien_thoai VARCHAR(16) CHARACTER SET ascii COLLATE ascii_bin NOT NULL,
    mat_khau_bam VARCHAR(255) CHARACTER SET ascii COLLATE ascii_bin NULL,
    vai_tro VARCHAR(20) CHARACTER SET ascii COLLATE ascii_bin NOT NULL DEFAULT 'khach_hang',
    dang_hoat_dong TINYINT NOT NULL DEFAULT 0,
    PRIMARY KEY (ma),
    UNIQUE KEY duy_nhat_nguoi_dung_1 (ten_dang_nhap),
    UNIQUE KEY duy_nhat_nguoi_dung_2 (gmail),
    UNIQUE KEY duy_nhat_nguoi_dung_3 (so_dien_thoai),
    CONSTRAINT kiem_tra_nguoi_dung_1 CHECK (
        ten_dang_nhap REGEXP '^[a-z0-9_.-]{3,50}$'
        AND BINARY ten_dang_nhap = BINARY LOWER(ten_dang_nhap)
    ),
    CONSTRAINT kiem_tra_nguoi_dung_2 CHECK (
        ho_ten IS NULL OR CHAR_LENGTH(TRIM(ho_ten)) > 0
    ),
    CONSTRAINT kiem_tra_nguoi_dung_3 CHECK (
        CHAR_LENGTH(gmail) >= 3 AND gmail LIKE '%@%'
        AND BINARY gmail = BINARY LOWER(TRIM(gmail))
    ),
    CONSTRAINT kiem_tra_nguoi_dung_4 CHECK (so_dien_thoai REGEXP '^[+][1-9][0-9]{7,14}$'),
    CONSTRAINT kiem_tra_nguoi_dung_5 CHECK (vai_tro IN ('khach_hang', 'quan_tri')),
    CONSTRAINT kiem_tra_nguoi_dung_6 CHECK (dang_hoat_dong IN (0, 1)),
    CONSTRAINT kiem_tra_nguoi_dung_7 CHECK (
        mat_khau_bam IS NULL OR CHAR_LENGTH(TRIM(mat_khau_bam)) >= 60
    ),
    CONSTRAINT kiem_tra_nguoi_dung_8 CHECK (
        dang_hoat_dong = 0 OR mat_khau_bam IS NOT NULL
    )
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE danh_muc (
    ma BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    ten VARCHAR(120) NOT NULL,
    PRIMARY KEY (ma),
    UNIQUE KEY duy_nhat_danh_muc_1 (ten),
    CONSTRAINT kiem_tra_danh_muc_2 CHECK (CHAR_LENGTH(TRIM(ten)) > 0)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE san_pham (
    ma BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    ma_danh_muc BIGINT UNSIGNED NOT NULL,
    ma_hang VARCHAR(64) CHARACTER SET ascii COLLATE ascii_general_ci NOT NULL,
    duong_dan VARCHAR(150) CHARACTER SET ascii COLLATE ascii_bin NOT NULL,
    ten VARCHAR(200) NOT NULL,
    mo_ta TEXT NULL,
    quy_cach VARCHAR(60) NULL,
    gia_ban DECIMAL(12, 0) NOT NULL,
    gia_truoc_giam DECIMAL(12, 0) NULL,
    so_luong_ton INT NOT NULL DEFAULT 0,
    duong_dan_anh VARCHAR(1024) NULL,
    dang_hoat_dong TINYINT NOT NULL DEFAULT 1,
    thoi_diem_tao DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
    thoi_diem_cap_nhat DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6)
        ON UPDATE CURRENT_TIMESTAMP(6),
    PRIMARY KEY (ma),
    UNIQUE KEY duy_nhat_san_pham_1 (ma_hang),
    UNIQUE KEY duy_nhat_san_pham_2 (duong_dan),
    KEY chi_muc_san_pham_1 (ma_danh_muc, dang_hoat_dong, gia_ban, ma),
    KEY chi_muc_san_pham_2 (dang_hoat_dong, gia_ban, ma),
    CONSTRAINT khoa_ngoai_san_pham_1 FOREIGN KEY (ma_danh_muc) REFERENCES danh_muc (ma)
        ON DELETE RESTRICT,
    CONSTRAINT kiem_tra_san_pham_1 CHECK (
        CHAR_LENGTH(TRIM(ma_hang)) > 0 AND BINARY ma_hang = BINARY TRIM(ma_hang)
    ),
    CONSTRAINT kiem_tra_san_pham_2 CHECK (duong_dan REGEXP '^[a-z0-9]+(-[a-z0-9]+)*$'),
    CONSTRAINT kiem_tra_san_pham_3 CHECK (CHAR_LENGTH(TRIM(ten)) > 0),
    CONSTRAINT kiem_tra_san_pham_4 CHECK (quy_cach IS NULL OR CHAR_LENGTH(TRIM(quy_cach)) > 0),
    CONSTRAINT kiem_tra_san_pham_5 CHECK (gia_ban >= 0),
    CONSTRAINT kiem_tra_san_pham_6 CHECK (
        gia_truoc_giam IS NULL OR gia_truoc_giam >= gia_ban
    ),
    CONSTRAINT kiem_tra_san_pham_7 CHECK (so_luong_ton >= 0),
    CONSTRAINT kiem_tra_san_pham_8 CHECK (dang_hoat_dong IN (0, 1))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 4. Một giỏ hiện tại cho mỗi tài khoản; chưa hỗ trợ giỏ khách vãng lai.
CREATE TABLE gio_hang (
    ma BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    ma_nguoi_dung BIGINT UNSIGNED NOT NULL,
    thoi_diem_tao DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
    thoi_diem_cap_nhat DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6)
        ON UPDATE CURRENT_TIMESTAMP(6),
    PRIMARY KEY (ma),
    UNIQUE KEY duy_nhat_gio_hang_1 (ma_nguoi_dung),
    CONSTRAINT khoa_ngoai_gio_hang_1 FOREIGN KEY (ma_nguoi_dung) REFERENCES nguoi_dung (ma)
        ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 5. Giá giỏ lấy từ san_pham; thêm giỏ chưa giữ/trừ tồn kho.
CREATE TABLE chi_tiet_gio_hang (
    ma_gio_hang BIGINT UNSIGNED NOT NULL,
    ma_san_pham BIGINT UNSIGNED NOT NULL,
    so_luong INT NOT NULL,
    thoi_diem_tao DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
    thoi_diem_cap_nhat DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6)
        ON UPDATE CURRENT_TIMESTAMP(6),
    PRIMARY KEY (ma_gio_hang, ma_san_pham),
    KEY chi_muc_chi_tiet_gio_hang_1 (ma_san_pham),
    CONSTRAINT khoa_ngoai_chi_tiet_gio_hang_1 FOREIGN KEY (ma_gio_hang) REFERENCES gio_hang (ma)
        ON DELETE CASCADE,
    CONSTRAINT khoa_ngoai_chi_tiet_gio_hang_2 FOREIGN KEY (ma_san_pham) REFERENCES san_pham (ma)
        ON DELETE RESTRICT,
    CONSTRAINT kiem_tra_chi_tiet_gio_hang_1 CHECK (so_luong BETWEEN 1 AND 999)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 6. Lịch sử mua hàng liên kết với tài khoản qua ma_nguoi_dung.
-- Các cột thanh toán chỉ ghi nhận trạng thái, không kết nối cổng thanh toán.
CREATE TABLE don_hang (
    ma BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    ma_don_hang VARCHAR(40) CHARACTER SET ascii COLLATE ascii_bin NOT NULL,
    ma_nguoi_dung BIGINT UNSIGNED NOT NULL,
    trang_thai VARCHAR(20) CHARACTER SET ascii COLLATE ascii_bin NOT NULL DEFAULT 'cho_xac_nhan',
    ghi_chu_khach_hang VARCHAR(1000) NULL,
    ghi_chu_quan_tri VARCHAR(1000) NULL,
    tien_hang DECIMAL(14, 0) NOT NULL,
    phi_giao_hang DECIMAL(14, 0) NOT NULL DEFAULT 0,
    tien_giam_gia DECIMAL(14, 0) NOT NULL DEFAULT 0,
    tong_thanh_toan DECIMAL(14, 0) GENERATED ALWAYS AS
        (tien_hang + phi_giao_hang - tien_giam_gia) STORED,
    phuong_thuc_thanh_toan VARCHAR(20) CHARACTER SET ascii COLLATE ascii_bin NOT NULL DEFAULT 'thu_khi_nhan',
    trang_thai_thanh_toan VARCHAR(20) CHARACTER SET ascii COLLATE ascii_bin NOT NULL DEFAULT 'chua_thanh_toan',
    thoi_diem_dat_hang DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
    thoi_diem_thanh_toan DATETIME(6) NULL,
    thoi_diem_giao_thanh_cong DATETIME(6) NULL,
    thoi_diem_huy DATETIME(6) NULL,
    ly_do_huy VARCHAR(500) NULL,
    thoi_diem_cap_nhat DATETIME(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6)
        ON UPDATE CURRENT_TIMESTAMP(6),
    PRIMARY KEY (ma),
    UNIQUE KEY duy_nhat_don_hang_1 (ma_don_hang),
    KEY chi_muc_don_hang_1 (ma_nguoi_dung, trang_thai, thoi_diem_dat_hang, ma),
    KEY chi_muc_don_hang_2 (ma_nguoi_dung, thoi_diem_dat_hang, ma),
    CONSTRAINT khoa_ngoai_don_hang_1 FOREIGN KEY (ma_nguoi_dung) REFERENCES nguoi_dung (ma)
        ON DELETE RESTRICT,
    CONSTRAINT kiem_tra_don_hang_1 CHECK (ma_don_hang REGEXP '^[A-Z0-9]+(-[A-Z0-9]+)*$'),
    CONSTRAINT kiem_tra_don_hang_2 CHECK (
        trang_thai IN ('cho_xac_nhan', 'da_xac_nhan', 'dang_dong_goi', 'dang_giao', 'da_giao', 'da_huy')
    ),
    CONSTRAINT kiem_tra_don_hang_6 CHECK (
        tien_hang >= 0 AND phi_giao_hang >= 0 AND tien_giam_gia >= 0
        AND tien_giam_gia <= tien_hang + phi_giao_hang
    ),
    CONSTRAINT kiem_tra_don_hang_7 CHECK (phuong_thuc_thanh_toan IN ('thu_khi_nhan', 'chuyen_khoan')),
    CONSTRAINT kiem_tra_don_hang_8 CHECK (trang_thai_thanh_toan IN ('chua_thanh_toan', 'da_thanh_toan', 'da_hoan_tien')),
    CONSTRAINT kiem_tra_don_hang_9 CHECK (
        (trang_thai_thanh_toan = 'chua_thanh_toan' AND thoi_diem_thanh_toan IS NULL)
        OR (trang_thai_thanh_toan IN ('da_thanh_toan', 'da_hoan_tien') AND thoi_diem_thanh_toan IS NOT NULL AND thoi_diem_thanh_toan >= thoi_diem_dat_hang)
    ),
    CONSTRAINT kiem_tra_don_hang_10 CHECK (
        (trang_thai = 'da_giao' AND thoi_diem_giao_thanh_cong IS NOT NULL AND thoi_diem_giao_thanh_cong >= thoi_diem_dat_hang)
        OR (trang_thai <> 'da_giao' AND thoi_diem_giao_thanh_cong IS NULL)
    ),
    CONSTRAINT kiem_tra_don_hang_11 CHECK (
        (trang_thai = 'da_huy' AND thoi_diem_huy IS NOT NULL AND thoi_diem_huy >= thoi_diem_dat_hang
            AND ly_do_huy IS NOT NULL AND CHAR_LENGTH(TRIM(ly_do_huy)) > 0)
        OR (trang_thai <> 'da_huy' AND thoi_diem_huy IS NULL AND ly_do_huy IS NULL)
    )
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 7. Tên, SKU, quy cách, ảnh và giá giữ nguyên theo thời điểm đặt hàng.
CREATE TABLE chi_tiet_don_hang (
    ma BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    ma_don BIGINT UNSIGNED NOT NULL,
    ma_san_pham BIGINT UNSIGNED NOT NULL,
    ma_hang_luc_dat VARCHAR(64) CHARACTER SET ascii COLLATE ascii_general_ci NOT NULL,
    ten_san_pham_luc_dat VARCHAR(200) NOT NULL,
    quy_cach VARCHAR(60) NULL,
    duong_dan_anh VARCHAR(1024) NULL,
    don_gia DECIMAL(12, 0) NOT NULL,
    so_luong INT NOT NULL,
    thanh_tien DECIMAL(14, 0) GENERATED ALWAYS AS (don_gia * so_luong) STORED,
    PRIMARY KEY (ma),
    UNIQUE KEY duy_nhat_chi_tiet_don_hang_1 (ma_don, ma_san_pham),
    KEY chi_muc_chi_tiet_don_hang_1 (ma_san_pham),
    CONSTRAINT khoa_ngoai_chi_tiet_don_hang_1 FOREIGN KEY (ma_don) REFERENCES don_hang (ma)
        ON DELETE RESTRICT,
    CONSTRAINT khoa_ngoai_chi_tiet_don_hang_2 FOREIGN KEY (ma_san_pham) REFERENCES san_pham (ma)
        ON DELETE RESTRICT,
    CONSTRAINT kiem_tra_chi_tiet_don_hang_1 CHECK (CHAR_LENGTH(TRIM(ma_hang_luc_dat)) > 0),
    CONSTRAINT kiem_tra_chi_tiet_don_hang_2 CHECK (CHAR_LENGTH(TRIM(ten_san_pham_luc_dat)) > 0),
    CONSTRAINT kiem_tra_chi_tiet_don_hang_3 CHECK (quy_cach IS NULL OR CHAR_LENGTH(TRIM(quy_cach)) > 0),
    CONSTRAINT kiem_tra_chi_tiet_don_hang_4 CHECK (don_gia >= 0),
    CONSTRAINT kiem_tra_chi_tiet_don_hang_5 CHECK (so_luong BETWEEN 1 AND 999)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 8. Một bản thông tin người nhận cho mỗi đơn; không thay đổi theo hồ sơ tài khoản.
-- Khi đặt hàng, backend phải tạo đơn, chi tiết và thông tin giao hàng cùng giao dịch.
CREATE TABLE thong_tin_giao_hang (
    ma_don BIGINT UNSIGNED NOT NULL,
    ten_nguoi_nhan VARCHAR(120) NOT NULL,
    so_dien_thoai_nguoi_nhan VARCHAR(16) CHARACTER SET ascii COLLATE ascii_bin NOT NULL,
    dia_chi_giao_hang VARCHAR(500) NOT NULL,
    PRIMARY KEY (ma_don),
    CONSTRAINT khoa_ngoai_thong_tin_giao_hang_1 FOREIGN KEY (ma_don) REFERENCES don_hang (ma)
        ON DELETE RESTRICT,
    CONSTRAINT kiem_tra_thong_tin_giao_hang_1 CHECK (CHAR_LENGTH(TRIM(ten_nguoi_nhan)) > 0),
    CONSTRAINT kiem_tra_thong_tin_giao_hang_2 CHECK (so_dien_thoai_nguoi_nhan REGEXP '^[+][1-9][0-9]{7,14}$'),
    CONSTRAINT kiem_tra_thong_tin_giao_hang_3 CHECK (CHAR_LENGTH(TRIM(dia_chi_giao_hang)) > 0)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tùy chọn: các nhóm hàng lấy từ giao diện hiện tại.
-- Phần này chỉ thêm danh mục; phần tiếp theo thêm 15 sản phẩm minh họa.
-- Chạy lại không tạo nhóm trùng tên. Mã danh mục do database tự cấp.
SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci;
USE kami247;

INSERT INTO danh_muc (ten) VALUES
    ('Mì & đồ ăn liền'),
    ('Nước giải khát'),
    ('Cơm & đồ ăn nóng'),
    ('Snack & bánh kẹo'),
    ('Kem mát lạnh')
ON DUPLICATE KEY UPDATE ten = danh_muc.ten;

-- KAMI247: 15 sản phẩm MINH HỌA cho bài thực hành. Không phải hàng hoặc giá bán thật.
-- Cấu trúc bảng và danh mục đã tạo ở trên. Không sửa các sản phẩm đã có.
SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci;
USE kami247;
START TRANSACTION;

INSERT INTO san_pham (ma_danh_muc, ma_hang, duong_dan, ten, mo_ta, quy_cach, gia_ban, so_luong_ton, duong_dan_anh, dang_hoat_dong)
SELECT c.ma, 'DEMO-001', 'mi-cay-hai-san', 'Mì cay hải sản', 'Gói 75 g. Sản phẩm và giá minh họa cho bài thực hành.', 'Gói 75 g', 12000, 0, 'assets/anh-web/mi-nuoc.jpg', 1
FROM danh_muc AS c WHERE c.ten = 'Mì & đồ ăn liền'
ON DUPLICATE KEY UPDATE ma_hang = san_pham.ma_hang;

INSERT INTO san_pham (ma_danh_muc, ma_hang, duong_dan, ten, mo_ta, quy_cach, gia_ban, so_luong_ton, duong_dan_anh, dang_hoat_dong)
SELECT c.ma, 'DEMO-002', 'mi-tron-tuong-den', 'Mì trộn tương đen', 'Gói 85 g. Sản phẩm và giá minh họa cho bài thực hành.', 'Gói 85 g', 18000, 0, 'assets/anh-web/mi-tron.jpg', 1
FROM danh_muc AS c WHERE c.ten = 'Mì & đồ ăn liền'
ON DUPLICATE KEY UPDATE ma_hang = san_pham.ma_hang;

INSERT INTO san_pham (ma_danh_muc, ma_hang, duong_dan, ten, mo_ta, quy_cach, gia_ban, so_luong_ton, duong_dan_anh, dang_hoat_dong)
SELECT c.ma, 'DEMO-003', 'mi-ly-nam', 'Mì ly vị nấm', 'Ly 65 g. Sản phẩm và giá minh họa cho bài thực hành.', 'Ly 65 g', 16000, 0, 'assets/anh-web/mi-nuoc.jpg', 1
FROM danh_muc AS c WHERE c.ten = 'Mì & đồ ăn liền'
ON DUPLICATE KEY UPDATE ma_hang = san_pham.ma_hang;

INSERT INTO san_pham (ma_danh_muc, ma_hang, duong_dan, ten, mo_ta, quy_cach, gia_ban, so_luong_ton, duong_dan_anh, dang_hoat_dong)
SELECT c.ma, 'DEMO-004', 'tra-dao', 'Trà đào thanh mát', 'Chai 450 ml. Sản phẩm và giá minh họa cho bài thực hành.', 'Chai 450 ml', 15000, 0, 'assets/anh-web/tra-dao.jpg', 1
FROM danh_muc AS c WHERE c.ten = 'Nước giải khát'
ON DUPLICATE KEY UPDATE ma_hang = san_pham.ma_hang;

INSERT INTO san_pham (ma_danh_muc, ma_hang, duong_dan, ten, mo_ta, quy_cach, gia_ban, so_luong_ton, duong_dan_anh, dang_hoat_dong)
SELECT c.ma, 'DEMO-005', 'tra-xanh', 'Trà xanh nguyên vị', 'Chai 450 ml. Sản phẩm và giá minh họa cho bài thực hành.', 'Chai 450 ml', 13000, 0, 'assets/anh-web/tra-xanh.jpg', 1
FROM danh_muc AS c WHERE c.ten = 'Nước giải khát'
ON DUPLICATE KEY UPDATE ma_hang = san_pham.ma_hang;

INSERT INTO san_pham (ma_danh_muc, ma_hang, duong_dan, ten, mo_ta, quy_cach, gia_ban, so_luong_ton, duong_dan_anh, dang_hoat_dong)
SELECT c.ma, 'DEMO-006', 'nuoc-chanh', 'Nước chanh tươi', 'Chai 350 ml. Sản phẩm và giá minh họa cho bài thực hành.', 'Chai 350 ml', 14000, 0, 'assets/anh-web/nuoc-chanh.jpg', 1
FROM danh_muc AS c WHERE c.ten = 'Nước giải khát'
ON DUPLICATE KEY UPDATE ma_hang = san_pham.ma_hang;

INSERT INTO san_pham (ma_danh_muc, ma_hang, duong_dan, ten, mo_ta, quy_cach, gia_ban, so_luong_ton, duong_dan_anh, dang_hoat_dong)
SELECT c.ma, 'DEMO-007', 'com-nam-ca-ngu', 'Cơm nắm cá ngừ', 'Phần 110 g. Sản phẩm và giá minh họa cho bài thực hành.', 'Phần 110 g', 22000, 0, 'assets/anh-web/com-nam.jpg', 1
FROM danh_muc AS c WHERE c.ten = 'Cơm & đồ ăn nóng'
ON DUPLICATE KEY UPDATE ma_hang = san_pham.ma_hang;

INSERT INTO san_pham (ma_danh_muc, ma_hang, duong_dan, ten, mo_ta, quy_cach, gia_ban, so_luong_ton, duong_dan_anh, dang_hoat_dong)
SELECT c.ma, 'DEMO-008', 'com-nam-ga', 'Cơm nắm gà teriyaki', 'Phần 110 g. Sản phẩm và giá minh họa cho bài thực hành.', 'Phần 110 g', 24000, 0, 'assets/anh-web/com-nam.jpg', 1
FROM danh_muc AS c WHERE c.ten = 'Cơm & đồ ăn nóng'
ON DUPLICATE KEY UPDATE ma_hang = san_pham.ma_hang;

INSERT INTO san_pham (ma_danh_muc, ma_hang, duong_dan, ten, mo_ta, quy_cach, gia_ban, so_luong_ton, duong_dan_anh, dang_hoat_dong)
SELECT c.ma, 'DEMO-009', 'com-nam-nam', 'Cơm nắm nấm mè', 'Phần 100 g. Sản phẩm và giá minh họa cho bài thực hành.', 'Phần 100 g', 20000, 0, 'assets/anh-web/com-nam.jpg', 1
FROM danh_muc AS c WHERE c.ten = 'Cơm & đồ ăn nóng'
ON DUPLICATE KEY UPDATE ma_hang = san_pham.ma_hang;

INSERT INTO san_pham (ma_danh_muc, ma_hang, duong_dan, ten, mo_ta, quy_cach, gia_ban, so_luong_ton, duong_dan_anh, dang_hoat_dong)
SELECT c.ma, 'DEMO-010', 'snack-khoai-tay', 'Snack khoai tây', 'Gói 60 g. Sản phẩm và giá minh họa cho bài thực hành.', 'Gói 60 g', 17000, 0, 'assets/anh-web/snack.jpg', 1
FROM danh_muc AS c WHERE c.ten = 'Snack & bánh kẹo'
ON DUPLICATE KEY UPDATE ma_hang = san_pham.ma_hang;

INSERT INTO san_pham (ma_danh_muc, ma_hang, duong_dan, ten, mo_ta, quy_cach, gia_ban, so_luong_ton, duong_dan_anh, dang_hoat_dong)
SELECT c.ma, 'DEMO-011', 'snack-rong-bien', 'Snack rong biển', 'Gói 45 g. Sản phẩm và giá minh họa cho bài thực hành.', 'Gói 45 g', 19000, 0, 'assets/anh-web/snack.jpg', 1
FROM danh_muc AS c WHERE c.ten = 'Snack & bánh kẹo'
ON DUPLICATE KEY UPDATE ma_hang = san_pham.ma_hang;

INSERT INTO san_pham (ma_danh_muc, ma_hang, duong_dan, ten, mo_ta, quy_cach, gia_ban, so_luong_ton, duong_dan_anh, dang_hoat_dong)
SELECT c.ma, 'DEMO-012', 'banh-quy-cacao', 'Bánh quy cacao', 'Gói 80 g. Sản phẩm và giá minh họa cho bài thực hành.', 'Gói 80 g', 23000, 0, 'assets/anh-web/banh-quy.jpg', 1
FROM danh_muc AS c WHERE c.ten = 'Snack & bánh kẹo'
ON DUPLICATE KEY UPDATE ma_hang = san_pham.ma_hang;

INSERT INTO san_pham (ma_danh_muc, ma_hang, duong_dan, ten, mo_ta, quy_cach, gia_ban, so_luong_ton, duong_dan_anh, dang_hoat_dong)
SELECT c.ma, 'DEMO-013', 'kem-dau', 'Kem que vị dâu', 'Que 70 g. Sản phẩm và giá minh họa cho bài thực hành.', 'Que 70 g', 15000, 0, 'assets/anh-web/kem.jpg', 1
FROM danh_muc AS c WHERE c.ten = 'Kem mát lạnh'
ON DUPLICATE KEY UPDATE ma_hang = san_pham.ma_hang;

INSERT INTO san_pham (ma_danh_muc, ma_hang, duong_dan, ten, mo_ta, quy_cach, gia_ban, so_luong_ton, duong_dan_anh, dang_hoat_dong)
SELECT c.ma, 'DEMO-014', 'kem-matcha', 'Kem que matcha', 'Que 70 g. Sản phẩm và giá minh họa cho bài thực hành.', 'Que 70 g', 18000, 0, 'assets/anh-web/kem.jpg', 1
FROM danh_muc AS c WHERE c.ten = 'Kem mát lạnh'
ON DUPLICATE KEY UPDATE ma_hang = san_pham.ma_hang;

INSERT INTO san_pham (ma_danh_muc, ma_hang, duong_dan, ten, mo_ta, quy_cach, gia_ban, so_luong_ton, duong_dan_anh, dang_hoat_dong)
SELECT c.ma, 'DEMO-015', 'kem-socola', 'Kem que sô-cô-la', 'Que 75 g. Sản phẩm và giá minh họa cho bài thực hành.', 'Que 75 g', 19000, 0, 'assets/anh-web/kem-socola.jpg', 1
FROM danh_muc AS c WHERE c.ten = 'Kem mát lạnh'
ON DUPLICATE KEY UPDATE ma_hang = san_pham.ma_hang;

COMMIT;
