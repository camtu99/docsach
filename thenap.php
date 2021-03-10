<?php
    include 'function.php';
    if(!isset($_SESSION["tai_khoan"]) || $_SESSION["tai_khoan"]!="admin"|| !isset($_SESSION["mat_khau"]) || $_SESSION["mat_khau"]!=$_SESSION['pass'])
    header("Location: login.php");
    topadmin();
    if(isset($_GET['suathe'])){
        $suathe=mysqli_query($conn,"update the_nap set trang_thai_the='".$_POST['trangthai']."' where id_the=".$_GET['suathe']);
        if($_POST['trangthai']=='Hoàn thành'){
            $congtien=mysqli_query($conn,"call cong_tien('".$_GET['matv']."',".$_GET['cong'].")");
        }
        echo'
            <script>    
                if(typeof window.history.pushState == "function") {
                    window.history.pushState({}, "Hide", "thenap.php");
                }
                alert("Đã thay đổi");
                location.reload();
            </script>
            '
        ;
    }
?>
<div class="container-fluid">
    <div class="row" style="display: flex;">
        <?php menuadmin(); ?>
        <div class="col-lg-10 thenap">
            <div>
                <form action="?tim" method="post">
                    <label for="">Nhập seri: </label>
                    <input type="text" name="seri">
                    <button type="submit">Tìm</button>
                </form>
            </div>
            <div class="">
                <table style="width:100%">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Thành viên</th>
                            <th>Seri thẻ</th>
                            <th>Mã thẻ</th>
                            <th>Loại thẻ</th>
                            <th>Mệnh giá</th>
                            <th>Ngày nạp</th>
                            <th>Trạng thái</th>
                        </tr>
                    </thead>
                    <tbody class="bangthenap">
                        <?php
                        if(isset($_GET['tim'])){
                            $danhsach=mysqli_query($conn,"  select ROW_NUMBER() OVER (order by ngay_nap desc) AS 'stt',id_the,seri_the,ma_the ,menh_gia ,loai_the,trang_thai_the ,ma_thanh_vien,ngay_nap  from the_nap where seri_the like '%".$_POST['seri']."%';");
                        }else{
                            $danhsach=mysqli_query($conn,"  select ROW_NUMBER() OVER (order by ngay_nap desc) AS 'stt',id_the,seri_the,ma_the ,menh_gia ,loai_the,trang_thai_the ,ma_thanh_vien,ngay_nap  from the_nap;");
                        }
                        if(mysqli_num_rows($danhsach)>0){
                            while($thenap=mysqli_fetch_array($danhsach)){
                                $giaxu=0;
                                if($thenap['menh_gia']==10000){$giaxu=20;};
                                if($thenap['menh_gia']==20000){$giaxu=45;};
                                if($thenap['menh_gia']==50000){$giaxu=120;};
                                if($thenap['menh_gia']==100000){$giaxu=250;};
                                echo'
                                    <tr>
                                        <td>'.$thenap['stt'].'</td>
                                        <td>'.$thenap['ma_thanh_vien'].'</td>
                                        <td>'.$thenap['seri_the'].'</td>
                                        <td>'.$thenap['ma_the'].'</td>
                                        <td>'.$thenap['loai_the'].'</td>
                                        <td>'.$thenap['menh_gia'].'</td>
                                        <td>'.$thenap['ngay_nap'].'</td>
                                        <td >
                                            <form action="?suathe='.$thenap['id_the'].'&&cong='.$giaxu.'&&matv='.$thenap['ma_thanh_vien'].'" style="display:flex;" method="post">
                                                <select class="form-control" name="trangthai" id="sel1" values="">
                                                    <option values="'.$thenap['trang_thai_the'].'">'.$thenap['trang_thai_the'].'</option>';
                                                    if($thenap['trang_thai_the']=='Đang xử lí'){
                                                        echo'   <option values="Hoàn thành">Hoàn thành</option>
                                                                <option values="Thẻ lỗi">Thẻ lỗi</option>';
                                                    }else{
                                                        if($thenap['trang_thai_the']=='Thẻ lỗi'){
                                                            echo'   <option values="Hoàn thành">Hoàn thành</option>
                                                                    <option values="Đang xử lí">Đang xử lí</option>';
                                                        }else{
                                                            echo'   <option values="Thẻ lỗi">Thẻ lỗi</option>
                                                                    <option values="Đang xử lí">Đang xử lí</option>';
                                                        }
                                                    }
                                                    echo' 
                                                </select>
                                                <button type="submit" class="btn button-thenap">Đổi</button>
                                            </form>
                                        </td>
                                    </tr>
                                ';
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>