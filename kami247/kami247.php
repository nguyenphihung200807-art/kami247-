<?php
    class ketnoi {
    public $host = "localhost";
    public $user = "root";
    public $pass = "";
    public $dbname = "kami247";
    public $db; 

    function __construct()
    {
        $this->db = new mysqli ($this->host, $this->user, $this->pass, $this->dbname);

        if ($this->db->connect_error) {
                die("Kết nối CSDL thất bại: " . $this->db->connect_error);
            }

        $this->db->set_charset("utf8");
    }   
        
    function XuLyDangNhap($user) {
        $stmt = $this->db->prepare(
            "SELECT * FROM nguoi_dung WHERE ten_dang_nhap = ?"
        );
        if (!$stmt) {
            return false;
        }

        $stmt->bind_param("s", $user);
        if (!$stmt->execute()) {
            $stmt->close();
            return false;
        }

        $kq = $stmt->get_result();
        $stmt->close();
        return $kq;
    }

    function KiemTraTrung($user, $gmail, $sdt) {
        $sql = "SELECT ma, ten_dang_nhap, gmail, so_dien_thoai FROM nguoi_dung 
                WHERE ten_dang_nhap = '$user' 
                   OR gmail = '$gmail' 
                   OR so_dien_thoai = '$sdt'";
        $kq = $this->db->query($sql);
        return $kq;
    }

    function XuLyDangKy($user, $hoten, $gmail, $sdt, $pass_bam) {
        $ho_ten_sql = empty($hoten) ? "NULL" : "'$hoten'";
        
        $sql = "INSERT INTO nguoi_dung (ten_dang_nhap, ho_ten, gmail, so_dien_thoai, mat_khau_bam, vai_tro, dang_hoat_dong) 
                VALUES ('$user', $ho_ten_sql, '$gmail', '$sdt', '$pass_bam', DEFAULT ,1)";
        $kq = $this->db->query($sql);
        return $kq;
    }

}
?>