<?php 
include 'function.php';
if(isset($_SESSION['tai_khoan_tv'])){
    $tientv=mysqli_query($conn,"select so_tien from thanh_vien where ma_thanh_vien='".$_SESSION['tai_khoan_tv']."'");
    $kqtien=mysqli_fetch_array($tientv);
    if($kqtien['so_tien']>$_GET['gia']){
        $muasach=mysqli_query($conn,"call muasach('".$_SESSION['ma_sach']."',".$_GET['gia'].",'".$_SESSION['tai_khoan_tv']."')");
        echo'
            <script>    
                if(typeof window.history.pushState == "function") {
                    window.history.pushState({}, "Hide", "'.$_SESSION['duongdan'].'");
                }
                alert("Mở khóa thành công!");
                location.reload();
            </script>
        ';
    }else{
        echo'
            <script>    
                if(typeof window.history.pushState == "function") {
                    window.history.pushState({}, "Hide", "'.$_SESSION['duongdan'].'");
                }
                alert("Tài khoản không đủ xu !");
                location.reload();
            </script>
        ';
    }
}else{
    echo'
            <script>    
                if(typeof window.history.pushState == "function") {
                    window.history.pushState({}, "Hide", "'.$_SESSION['duongdan'].'");
                }
                alert("Bạn chưa đăng nhập !");
                location.reload();
            </script>
        ';
}

?>