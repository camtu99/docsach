<?php
include 'function.php';
$seri=$_POST['seri'];
$mathe=$_POST['mathe'];
$trangthai='Đang xử lí';
$menhgia=$_POST['vnd'];
$loaithe=$_POST['loaithe'];
$matv=$_SESSION['tai_khoan_tv'];
$ngaynap=date('Y-m-d H:i:s');
$ketqua=mysqli_query($conn,"insert into the_nap(seri_the,ma_the ,menh_gia ,loai_the,trang_thai_the ,ma_thanh_vien ,ngay_nap)
                                values('".$seri."','".$mathe."',".$menhgia.",'".$loaithe."','".$trangthai."','".$matv."','".$ngaynap."')");
echo'
    <script>    
    if(typeof window.history.pushState == "function") {
        window.history.pushState({}, "Hide", "'.$_SESSION['duongdan'].'");
    }
    alert("Thẻ đã được nạp lên web. Vui lòng chờ 5p để duyệt.");
    location.reload();
    </script>
';

?>