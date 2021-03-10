<?php 
include 'function.php';
menu();
if(isset($_GET['tacgia'])){
    $result=mysqli_query($conn,"select * from sach where ma_tac_gia='".$_GET['tacgia']."'");
    $tacgia=mysqli_query($conn,"select * from tac_gia where ma_tac_gia='".$_GET['tacgia']."'");
    $ten=mysqli_fetch_array($tacgia);
    $search=$ten['ten_tac_gia'];
   
}
if(isset($_GET['tinhtrang'])){
    $search=$_GET['tinhtrang'];
    $result=mysqli_query($conn,"select * from sach where tinh_trang='".$search."'");
   
}
if(isset($_GET['search'])){
    $search=$_GET['search'];
    $result=mysqli_query($conn,"select * from sach where ten_sach like '%".$search."%'");
  
}
if(isset($_GET['theloai'])){
    $search=$_GET['theloai'];
    $result=mysqli_query($conn,"select s.ma_sach,s.ma_tac_gia,s.ten_sach,s.hinh_anh from sach s join tag_sach ts on s.ma_sach=ts.ma_sach join the_loai_sach tl on ts.ma_loai=tl.ma_loai where tl.ten_loai='".$search."'");
}

?>
<div class="container">
    <br>
        <?php search(); ?>
    <div ><h3> Tìm Kiếm: <?php echo $search; ?> </h3></div>
    <hr>
    <div class="chuongmoi">    
        <div class="row">
            <?php if(mysqli_num_rows($result) > 0 ){
                    while ($row = mysqli_fetch_array($result)){
                        $ma_sach=$row['ma_sach'];
                        $result1  = mysqli_query($conn,"select count(ma_binh_luan) from binh_luan where ma_sach='".$ma_sach."'");
                        $row1 = mysqli_fetch_array($result1);
                        $result2 = mysqli_query($conn,"select ten_tac_gia from tac_gia where ma_tac_gia = '".$row['ma_tac_gia']."'");
                        $row2 = mysqli_fetch_array($result2);
                        $luotdoc=luotdoc($ma_sach);
                        echo'
                        <div class="book-item col-lg-3" >
                            <a href="chitiettruyen.php?masach='.$ma_sach.'" data-toggle="tooltip"  data-placement="bottom" title="'.$row['ten_sach'].'">
                                <div class="img-cover">
                                    
                                        <img src="./truyen/'.$row['ten_sach'].'/'.$row['hinh_anh'].'">
                                    
                                </div>
                                <div class="infor">
                                    <div class="infor-item">
                                        
                                            '.$row['ten_sach'].'
                                        
                                    </div>
                                    <div class="author">
                                            '.$row2['ten_tac_gia'].'
                                    </div>
                                    <div class="view-sach">
                                        <i class="fa fa-eye" aria-hidden="true" style=" font-weight: 100;">'.$luotdoc.'</i>
                                        <i class="fa fa-comment" aria-hidden="true" style=" font-weight: 100;">'.$row1['count(ma_binh_luan)'].'</i>
                                    </div>
                                </div>
                            </a>
                        </div>';
                    }
                } 
                else{
                    echo 'Không tìm thấy!
                    <br><br><br><br><br><br><br><br><br><br><br>';
                }?>     
        </div>  
    </div>
</div>
            <?php bottom();
            
?>




