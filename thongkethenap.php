<?php
include 'function.php';
if(!isset($_SESSION["tai_khoan"]) || $_SESSION["tai_khoan"]!="admin"|| !isset($_SESSION["mat_khau"]) || $_SESSION["mat_khau"]!=$_SESSION['pass'])
header("Location: login.php");
topadmin();
$kqthengay['the']=0;
$kqtheloi['the']=0;
$kqthenhan['the']= 0;
$kqsotien['the']= 0;
$kqthethang['the']=0;
$kqtheloithang['the']=0;
$kqthenhanthang['the']= 0;
$kqsotienthang['the']= 0;
$kqthenam['the']=0;
$kqtheloinam['the']=0;
$kqthenhannam['the']= 0;
$kqsotiennam['the']= 0;
if(isset($_GET['ngay'])){
    $ngay=$_POST['ngay'];
}else $ngay=date('Y-m-d');
$thengay=mysqli_query($conn,"select count(*) the from the_nap where date(ngay_nap)='".$ngay."';");
    if(mysqli_num_rows($thengay)>0) $kqthengay=mysqli_fetch_array($thengay);
$theloi=mysqli_query($conn,"select count(*) the from the_nap where date(ngay_nap)='".$ngay."' and trang_thai_the='Thẻ lỗi';");
    if(mysqli_num_rows($theloi)>0) $kqtheloi=mysqli_fetch_array($theloi);
$thenhan=mysqli_query($conn,"select count(*) the from the_nap where date(ngay_nap)='".$ngay."' and trang_thai_the='Hoàn thành';");
    if(mysqli_num_rows($thenhan)>0) $kqthenhan=mysqli_fetch_array($thenhan);
$sotien=mysqli_query($conn,"select sum(menh_gia) the from the_nap where date(ngay_nap)='".$ngay."' and trang_thai_the='Hoàn thành';");
    if(mysqli_num_rows($sotien)>0) $kqsotien=mysqli_fetch_array($sotien);
if(isset($_GET['thang'])){
    $thang=$_POST['thang'];
    $thangnam=$_POST['nam'];
}else $thang=date('m');$thangnam=date('Y');
$thethang=mysqli_query($conn,"select count(*) the from the_nap where month(ngay_nap)='".$thang."' and year(ngay_nap)='".$thangnam."';");
    if(mysqli_num_rows($thethang)>0) $kqthethang=mysqli_fetch_array($thethang);
$theloithang=mysqli_query($conn,"select count(*) the from the_nap where month(ngay_nap)='".$thang."' and year(ngay_nap)='".$thangnam."' and trang_thai_the='Thẻ lỗi';");
    if(mysqli_num_rows($theloithang)>0) $kqtheloithang=mysqli_fetch_array($theloithang);
$thenhanthang=mysqli_query($conn,"select count(*) the from the_nap where month(ngay_nap)='".$thang."' and year(ngay_nap)='".$thangnam."' and trang_thai_the='Hoàn thành';");
    if(mysqli_num_rows($thenhanthang)>0) $kqthenhanthang=mysqli_fetch_array($thenhanthang);
$sotienthang=mysqli_query($conn,"select sum(menh_gia) the from the_nap where month(ngay_nap)='".$thang."' and year(ngay_nap)='".$thangnam."' and trang_thai_the='Hoàn thành';");
    if(mysqli_num_rows($sotienthang)>0) $kqsotienthang=mysqli_fetch_array($sotienthang);
if(isset($_GET['nam'])){
    $nam=$_POST['nam'];
}else $nam=date('Y');
$thenam=mysqli_query($conn,"select count(*) the from the_nap where year(ngay_nap)='".$nam."';");
    if(mysqli_num_rows($thenam)>0) $kqthenam=mysqli_fetch_array($thenam);
$theloinam=mysqli_query($conn,"select count(*) the from the_nap where year(ngay_nap)='".$nam."' and trang_thai_the='Thẻ lỗi';");
    if(mysqli_num_rows($theloinam)>0) $kqtheloinam=mysqli_fetch_array($theloinam);
$thenhannam=mysqli_query($conn,"select count(*) the from the_nap where year(ngay_nap)='".$nam."' and trang_thai_the='Hoàn thành';");
    if(mysqli_num_rows($thenhannam)>0) $kqthenhannam=mysqli_fetch_array($thenhannam);
$sotiennam=mysqli_query($conn,"select sum(menh_gia) the from the_nap where year(ngay_nap)='".$nam."' and trang_thai_the='Hoàn thành';");
    if(mysqli_num_rows($sotiennam)>0) $kqsotiennam=mysqli_fetch_array($sotiennam);
?>
<div class="container-fluid" >
    <div class="row" style="display: flex;">
        <?php menuadmin(); ?>
        <div class="col-lg-10" >
            <div>
                <h4>Thẻ nạp</h4>
            </div>
            <div class="tkthenap"> 
                <div class="row">
                    <div class="col-lg-5 thenaptong">
                        <div>
                            <form action="?ngay" method="post">
                                <label for="">Ngày: </label>
                                <input type="date" name="ngay">
                                <button type="submit">Chọn</button>
                            </form>
                        </div>
                            <p class="napngay">Tổng số thẻ nạp trong ngày <?php echo "<span class='ngaynap'>".$ngay .'</span> : <span>'. $kqthengay['the']; ?> thẻ.</span> </p>
                            <p class="naploi">Thẻ lỗi: <span><?php echo $kqtheloi['the']; ?> thẻ.</span> </p>
                            <p class="napok">Thực nhận: <span><?php echo $kqthenhan['the']; ?> thẻ.</span></p>
                            <p class="naptong">Tổng số tiền: <span><?php echo $kqsotien['the']; ?> đồng.</span></p>
                        <div>
                            <form action="?thang" method="Post">
                                <label>Chọn</label>
                                <select name="thang" id="thang">
                                    <?php
                                        for($i=1;$i<=12;$i++){
                                            echo'
                                                <option value="'.$i.'">Tháng '.$i.'</option>
                                            ';
                                        }
                                    ?>   
                                </select>
                                <select name="nam" id="nam">
                                    <?php
                                    $result =mysqli_query($conn,"select year(ngay_nap) nam from the_nap group by year(ngay_nap);");
                                    while($row=mysqli_fetch_array($result)){
                                        echo'
                                            <option value="'.$row['nam'].'">'.$row['nam'].'</option>
                                        ';
                                    }
                                    ?>
                                </select>
                                <button type="submit"> Chọn </button>
                            </form>  
                        </div>
                        <p class="napngay">Tổng số thẻ nạp trong tháng <?php echo "<span class='ngaynap'>".$thang .'</span>: <span>'. $kqthethang['the']; ?> thẻ.</span> </p>
                        <p class="naploi">Thẻ lỗi: <span><?php echo $kqtheloithang['the']; ?> thẻ.</span> </p>
                        <p class="napok">Thực nhận: <span><?php echo $kqthenhanthang['the']; ?> thẻ.</span></p>
                        <p class="naptong">Tổng số tiền: <span><?php echo $kqsotienthang['the']; ?> đồng.</span></p>
                        <div>
                            <form action="?nam" method="Post">
                                <label>Chọn:</label>
                                <select name="nam" id="nam">
                                    <?php
                                    $result =mysqli_query($conn,"select year(ngay_mua) nam from gio_hang group by year(ngay_mua);");
                                    while($row=mysqli_fetch_array($result)){
                                        echo'
                                            <option value="'.$row['nam'].'">'.$row['nam'].'</option>
                                        ';
                                    }
                                    ?>
                                </select>
                                <button type="submit">Chọn</button>   
                            </form>
                        </div>
                        <p class="napngay">Tổng số thẻ nạp trong năm <?php echo "<span class='ngaynap'>".$nam .'</span>: <span>'. $kqthenam['the']; ?> thẻ.</span> </p>
                        <p class="naploi">Thẻ lỗi: <span><?php echo $kqtheloinam['the']; ?> thẻ.</span> </p>
                        <p class="napok">Thực nhận: <span><?php echo $kqthenhannam['the']; ?> thẻ.</span></p>
                        <p class="naptong">Tổng số tiền: <span><?php echo $kqsotiennam['the']; ?> đồng.</span></p>
                    </div>
                    <div class="col-lg-7">
                        <div id="chart_div" style="height: 600px;"></div>
                        <?php tkthe(date('Y-m-d'));?>
                    </div>
                </div>
            </div>   
        </div>
    </div>
</div>