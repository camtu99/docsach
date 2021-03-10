<?php 
    include 'function.php';
    if(isset($_GET['chon'])){
        $binhchon=mysqli_query($conn,"insert into danh_gia values('".$_SESSION['tai_khoan_tv']."','".$_SESSION['ma_sach']."');");
        if(mysqli_error($binhchon)){
            echo'
            <script>    
            if(typeof window.history.pushState == "function") {
                window.history.pushState({}, "Hide", "'.$_SESSION['duongdan'].'");
            }
            alert("Bị lỗi");
            location.reload();
        </script>
            ';
        }else{
            echo'
            <script>    
                if(typeof window.history.pushState == "function") {
                    window.history.pushState({}, "Hide", "'.$_SESSION['duongdan'].'");
                }
                alert("Đã đánh giá");
                location.reload();
            </script>
            ';
        }
    }
    if(isset($_GET['huy'])){
        $huy=mysqli_query($conn,"delete from danh_gia where ma_thanh_vien='".$_SESSION['tai_khoan_tv']."' and ma_sach='".$_SESSION['ma_sach']."';");
        if(mysqli_error($huy)){
            echo'
            <script>    
            if(typeof window.history.pushState == "function") {
                window.history.pushState({}, "Hide", "'.$_SESSION['duongdan'].'");
            }
            alert("Bị lỗi");
            location.reload();
        </script>
            ';
        }else{
            echo'
            <script>    
                if(typeof window.history.pushState == "function") {
                    window.history.pushState({}, "Hide", "'.$_SESSION['duongdan'].'");
                }
                alert("Đã xóa đánh giá");
                location.reload();
            </script>
            ';
        }
    }
?>