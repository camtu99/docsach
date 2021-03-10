<?php
    include 'function.php';
    if(!isset($_SESSION['ten_tk'])){
     //  $_SESSION['check']='no';
       echo'
       <script>    
           if(typeof window.history.pushState == "function") {
               window.history.pushState({}, "Hide", "'.$_SESSION['duongdan'].'");
           }
           alert("Bạn chưa đăng nhập!");
           location.reload();
       </script>
       ';
    }else{
    $binhluan=$_GET['message'];
    $metqua="insert into binh_luan(noi_dung_bl,ma_thanh_vien,ma_sach) values('".$binhluan."','".$_SESSION['tai_khoan_tv']."','".$_SESSION['ma_sach']."')";
    $result1=mysqli_query($conn,$metqua);
    echo'
    <script>    
        if(typeof window.history.pushState == "function") {
            window.history.pushState({}, "Hide", "'.$_SESSION['duongdan'].'");
        }
        alert("Đăng bình luận thành công!");
        location.reload();
    </script>
    ';
    }


?>