<?php
    include 'function.php';
    if(!isset($_SESSION["tai_khoan"]) || $_SESSION["tai_khoan"]!="admin"|| !isset($_SESSION["mat_khau"]) || $_SESSION["mat_khau"]!=$_SESSION['pass'])
    header("Location: login.php");
    topadmin();
    if(isset($_GET['ML'])){
    $masach=$_GET['ML'];
    $result=mysqli_query($conn,"select * from sach where ma_sach='".$masach."';");
    $row=mysqli_fetch_array($result);
        if(isset($_GET['loai'])&& $_GET['loai']=='suaten'){
            echo'
            <div>
            <div class="suatruyen">

                <div>
                    <p><b>Tên sách:</b>'.$row['ten_sach'].'</p>
                </div>
                <div>
                <form action="suatruyen.php?id='.$row['ma_sach'].'" method="post">
                    <p>Sửa thành:<input type="text" name="suaten" value="" required></p>
                    <button>Đổi</button>
                    </form>    
                </div>
                <div><a href="admin.php">Quay lại</a></div>
            </div>
            </div>
            ';

        }
        if(isset($_GET['loai']) && $_GET['loai']=='suatrangthai'){
            echo $_POST['trangthai'];
            $result=mysqli_query($conn,"update sach set tinh_trang='".$_POST['trangthai']."' where ma_sach='".$masach."'");
            header('Location: admin.php');
        }
        if(isset($_GET['khoa'])){
            $result=mysqli_query($conn,"update sach set khoa=".$_GET['khoa']." where ma_sach='".$_GET['ML']."'");
            header('Location: admin.php');
        }
  
    }
    if(isset($_POST['suaten'])){
        $result1=mysqli_query($conn,"select * from sach where ma_sach ='".$_GET['id']."'");
        $row1=mysqli_fetch_array($result1);
        $result=mysqli_query($conn,"update sach set ten_sach='".$_POST['suaten']."' where ma_sach='".$_GET['id']."'");
        $tencu='truyen/'.$row1['ten_sach'];
        $tenmoi='truyen/'.$_POST['suaten'];
        rename($tencu,$tenmoi);
        header('Location: admin.php');
    }
    if(isset($_GET['id'])){
        $result=mysqli_query($conn,"select * from sach where  ma_sach ='".$_GET['id']."'");
        $row=mysqli_fetch_assoc($result);
        $filecu='./truyen/'.$row['ten_sach'].'/'.$row['mo_ta'];
        $filemoi='./truyen/'.$row['ten_sach'].'/'.$_FILES['mota']['name'];
        unlink($filecu);
        move_uploaded_file($_FILES['mota']['tmp_name'],$filemoi);
        $result1=mysqli_query($conn,"update sach set mo_ta='".$_FILES['mota']['name']."' where ma_sach='".$_GET['id']."'");
        header('Location: admin.php');
    }
    ?>
