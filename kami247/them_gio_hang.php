<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Khởi tạo giỏ hàng nếu chưa có
if (!isset($_SESSION['gio_hang']) || !is_array($_SESSION['gio_hang'])) {
    $_SESSION['gio_hang'] = [];
}

// Danh mục sản phẩm dự phòng nếu CSDL chưa kết nối hoặc dữ liệu tĩnh
$san_pham_mau = [
    'mi-cay-hai-san' => ['ten' => 'Mì cay hải sản', 'gia' => 12000, 'quy_cach' => 'Gói 75 g', 'anh' => 'assets/anh-web/mi-nuoc.jpg'],
    'mi-tron-tuong-den' => ['ten' => 'Mì trộn tương đen', 'gia' => 18000, 'quy_cach' => 'Gói 85 g', 'anh' => 'assets/anh-web/mi-tron.jpg'],
    'mi-ly-nam' => ['ten' => 'Mì ly vị nấm', 'gia' => 16000, 'quy_cach' => 'Ly 65 g', 'anh' => 'assets/anh-web/mi-nuoc.jpg'],
    'tra-dao' => ['ten' => 'Trà đào thanh mát', 'gia' => 15000, 'quy_cach' => 'Chai 450 ml', 'anh' => 'assets/anh-web/tra-dao.jpg'],
    'tra-xanh' => ['ten' => 'Trà xanh nguyên vị', 'gia' => 13000, 'quy_cach' => 'Chai 450 ml', 'anh' => 'assets/anh-web/tra-xanh.jpg'],
    'ca-phe-sua' => ['ten' => 'Cà phê sữa đá', 'gia' => 18000, 'quy_cach' => 'Chai 330 ml', 'anh' => 'assets/anh-web/ca-phe-sua.jpg'],
    'com-nam-ca-ngu' => ['ten' => 'Cơm nắm cá ngừ mayo', 'gia' => 16000, 'quy_cach' => 'Cái 110 g', 'anh' => 'assets/anh-web/com-nam.jpg'],
    'banh-bao-xa-xiu' => ['ten' => 'Bánh bao xá xíu', 'gia' => 17000, 'quy_cach' => 'Cái 130 g', 'anh' => 'assets/anh-web/banh-bao.jpg'],
    'xoi-thap-cam' => ['ten' => 'Xôi mặn thập cẩm', 'gia' => 22000, 'quy_cach' => 'Hộp 200 g', 'anh' => 'assets/anh-web/xoi-man.jpg'],
    'snack-khoai-tay' => ['ten' => 'Snack khoai tây vị rong biển', 'gia' => 14000, 'quy_cach' => 'Gói 54 g', 'anh' => 'assets/anh-web/snack.jpg'],
    'kho-ga-la-chanh' => ['ten' => 'Khô gà lá chanh', 'gia' => 28000, 'quy_cach' => 'Hũ 80 g', 'anh' => 'assets/anh-web/kho-ga.jpg'],
    'banh-socola-nhan-kem' => ['ten' => 'Bánh socola nhân kem', 'gia' => 15000, 'quy_cach' => 'Hộp 2 cái (56 g)', 'anh' => 'assets/anh-web/banh-ngot.jpg'],
    'kem-socola' => ['ten' => 'Kem que socola hạnh nhân', 'gia' => 19000, 'quy_cach' => 'Cây 70 g', 'anh' => 'assets/anh-web/kem-socola.jpg'],
    'kem-oc-que-vani' => ['ten' => 'Kem ốc quế vani', 'gia' => 18000, 'quy_cach' => 'Cây 110 ml', 'anh' => 'assets/anh-web/kem-oc-que.jpg'],
    'kem-hop-dau' => ['ten' => 'Kem hộp vị dâu', 'gia' => 16000, 'quy_cach' => 'Hộp 90 ml', 'anh' => 'assets/anh-web/kem-hop.jpg'],
];

// Hàm lấy thông tin sản phẩm (ưu tiên từ MySQL database kami247, nếu lỗi thì dùng mảng fallback)
function layThongTinSanPham($ma_sp, $san_pham_mau) {
    if (file_exists('kami247.php')) {
        try {
            include_once 'kami247.php';
            if (isset($conn) && $conn) {
                $stmt = mysqli_prepare($conn, "SELECT ma, ten, gia_ban, quy_cach, duong_dan_anh FROM san_pham WHERE duong_dan = ? OR ma_hang = ? LIMIT 1");
                if ($stmt) {
                    mysqli_stmt_bind_param($stmt, "ss", $ma_sp, $ma_sp);
                    mysqli_stmt_execute($stmt);
                    $res = mysqli_stmt_get_result($stmt);
                    if ($row = mysqli_fetch_assoc($res)) {
                        mysqli_stmt_close($stmt);
                        return [
                            'ma_sp' => $ma_sp,
                            'ten' => $row['ten'],
                            'gia' => (int)$row['gia_ban'],
                            'quy_cach' => $row['quy_cach'],
                            'anh' => $row['duong_dan_anh'] ?: 'assets/anh-web/mi-nuoc.jpg'
                        ];
                    }
                    mysqli_stmt_close($stmt);
                }
            }
        } catch (Throwable $e) {
            // Không ngắt trang nếu database tạm thời không truy cập được
        }
    }

    if (isset($san_pham_mau[$ma_sp])) {
        $sp = $san_pham_mau[$ma_sp];
        return [
            'ma_sp' => $ma_sp,
            'ten' => $sp['ten'],
            'gia' => (int)$sp['gia'],
            'quy_cach' => $sp['quy_cach'],
            'anh' => $sp['anh']
        ];
    }

    return null;
}

// Xử lý các thao tác: them, cap_nhat, xoa, xoa_tat_ca
$action = $_POST['action'] ?? $_GET['action'] ?? 'them';
$is_ajax = (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') 
            || isset($_POST['ajax']) || isset($_GET['ajax']);

if ($action === 'them') {
    $ma_sp = trim($_POST['ma_sp'] ?? $_GET['ma_sp'] ?? '');
    $so_luong = (int)($_POST['so_luong'] ?? $_GET['so_luong'] ?? 1);
    if ($so_luong < 1) $so_luong = 1;

    if (!empty($ma_sp)) {
        $info = layThongTinSanPham($ma_sp, $san_pham_mau);
        if ($info) {
            if (isset($_SESSION['gio_hang'][$ma_sp])) {
                $_SESSION['gio_hang'][$ma_sp]['so_luong'] += $so_luong;
            } else {
                $_SESSION['gio_hang'][$ma_sp] = [
                    'ma_sp' => $ma_sp,
                    'ten' => $info['ten'],
                    'gia' => $info['gia'],
                    'quy_cach' => $info['quy_cach'],
                    'anh' => $info['anh'],
                    'so_luong' => $so_luong
                ];
            }
        }
    }

    // Tính tổng số lượng
    $tong_so_luong = 0;
    foreach ($_SESSION['gio_hang'] as $item) {
        $tong_so_luong += $item['so_luong'];
    }

    if ($is_ajax) {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode([
            'success' => true,
            'message' => 'Đã thêm sản phẩm vào giỏ hàng!',
            'tong_so_luong' => $tong_so_luong,
            'so_loai' => count($_SESSION['gio_hang'])
        ]);
        exit;
    }

    // Nếu bấm nút "Mua ngay" hoặc gửi thông thường
    if (isset($_POST['mua_ngay']) || isset($_GET['mua_ngay']) || isset($_POST['chuyen_huong'])) {
        header('Location: dathang.php#gio-hang');
        exit;
    }

    // Mặc định chuyển hướng sang dathang.php
    header('Location: dathang.php#gio-hang');
    exit;

} elseif ($action === 'cap_nhat') {
    $ma_sp = trim($_POST['ma_sp'] ?? $_GET['ma_sp'] ?? '');
    $so_luong = (int)($_POST['so_luong'] ?? $_GET['so_luong'] ?? 1);

    if (isset($_SESSION['gio_hang'][$ma_sp])) {
        if ($so_luong <= 0) {
            unset($_SESSION['gio_hang'][$ma_sp]);
        } else {
            $_SESSION['gio_hang'][$ma_sp]['so_luong'] = $so_luong;
        }
    }

    if ($is_ajax) {
        $tong_so_luong = 0;
        $tong_tien = 0;
        foreach ($_SESSION['gio_hang'] as $item) {
            $tong_so_luong += $item['so_luong'];
            $tong_tien += $item['gia'] * $item['so_luong'];
        }
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode([
            'success' => true,
            'tong_so_luong' => $tong_so_luong,
            'tong_tien' => $tong_tien
        ]);
        exit;
    }

    header('Location: dathang.php#gio-hang');
    exit;

} elseif ($action === 'xoa') {
    $ma_sp = trim($_POST['ma_sp'] ?? $_GET['ma_sp'] ?? '');
    if (isset($_SESSION['gio_hang'][$ma_sp])) {
        unset($_SESSION['gio_hang'][$ma_sp]);
    }

    if ($is_ajax) {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(['success' => true]);
        exit;
    }

    header('Location: dathang.php#gio-hang');
    exit;

} elseif ($action === 'xoa_tat_ca') {
    $_SESSION['gio_hang'] = [];
    header('Location: dathang.php#gio-hang');
    exit;
}
