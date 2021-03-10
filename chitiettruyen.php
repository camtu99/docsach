<?php 
    include 'function.php';
    menu();
    if(isset($_GET['masach'])){
    $_SESSION['ma_sach']= $_GET['masach'];}
    $masach=$_SESSION['ma_sach'];
    $result = mysqli_query($conn,"select * from sach where ma_sach = '". $masach."'");
    $row = mysqli_fetch_array($result);
    $result1  = mysqli_query($conn,"select count(ma_binh_luan) from binh_luan where ma_sach='".$masach."'");
    $row1 = mysqli_fetch_array($result1);
    $result2 = mysqli_query($conn,"select ten_tac_gia,ma_tac_gia from tac_gia where ma_tac_gia = '".$row['ma_tac_gia']."'");
    $row2 = mysqli_fetch_array($result2);
    $result3 = mysqli_query($conn,"select * from noi_dung_sach where ma_sach = '". $masach."'");
    $row3 = mysqli_fetch_array($result3);
    $result4 = mysqli_query($conn,"select * from noi_dung_sach where ma_sach='".$masach."' and ngay=(select max(ngay)  from noi_dung_sach where ma_sach = '".$masach."')");
    $row4 = mysqli_fetch_array($result4);
    $result5  = mysqli_query($conn,"select ten_loai from tag_sach ts join the_loai_sach tl on tl.ma_loai=ts.ma_loai where ma_sach='".$masach."'");
    $_SESSION['ten_sach']=$row['ten_sach'];
    $_SESSION['tac_gia']=$row2['ten_tac_gia'];
    $luotdoc=luotdoc($masach);
?>
<div class="chitiettruyen">
    <div class="container">
        <br>
        <?php search(); ?>
        <div class="tennd">
            <p>Truyện <i class="fa fa-angle-right" aria-hidden="true"><?php echo " ".$row['ten_sach']?> </i></p>
        </div>
        <hr style="margin-top: -1rem;">            
        <div class="thong_tin">
            <div class="row">  
                <div class="col-lg-9">  
                    <div id="thongtintruyen" id="thongtin" class="thong-tin-1">
                        <div class="thong-tin-1-1">
                            <div class="detail_img" style="margin: 20px;" >
                                <?php echo '<img src="./truyen/'.$row['ten_sach'].'/'.$row['hinh_anh'].'" alt="" style="width: 200px;height: 240px;">';  ?> 
                            </div>  
                            <div class="detail_product">
                                <?php
                                $checkgia=0;
                                if(isset($_SESSION['tai_khoan_tv'])){
                                    $checksach=mysqli_query($conn,"select * from gio_hang where ma_thanh_vien='".$_SESSION['tai_khoan_tv']."' and ma_sach='".$masach."'");
                                    if(mysqli_num_rows($checksach)>0){
                                        $checkgia=1;
                                    }
                                }
                                
                                echo 
                                '<h2>'.$row['ten_sach'].'</h2>
                                <div class="view-sach" style="display:flex;font-weight:100">
                                <p class="iconct"> <i class="fa fa-eye" aria-hidden="true"style="font-weight: 100;">'.$luotdoc.'</i></p>
                                <p class="iconct">   <i class="fa fa-comment" aria-hidden="true"style="font-weight: 100;">'.$row1['count(ma_binh_luan)'].'</i></p>';
                                    $danhgia=mysqli_query($conn,"select count(*) danhgia from danh_gia where ma_sach='".$masach."'");
                                    if(mysqli_num_rows($danhgia)>0){
                                        $kqdanhgia=mysqli_fetch_array($danhgia);
                                        if(isset($_SESSION['tai_khoan_tv'])){
                                            $checkdanhgia=mysqli_query($conn,"select * from danh_gia where ma_thanh_vien='".$_SESSION['tai_khoan_tv']."' and ma_sach='".$masach."'");
                                            if(mysqli_num_rows($checkdanhgia)>0){
                                                echo '
                                                <a href="xulidanhgia.php?huy" type="buttom" style="color:yellow"> <i class="fas fa-star    " style="font-weight: 100;"> <span style="color:black;">'.$kqdanhgia['danhgia'].'</span> </i></a>'
                                                ;
                                            }else{
                                                echo '
                                                <a href="xulidanhgia.php?chon"type="buttom" style="color:black">  <i class="fas fa-star    "style="font-weight: 100;">'.$kqdanhgia['danhgia'].' </i></a>'
                                            ; 
                                            }
                                        }else{
                                            echo '
                                            <a href=""type="buttom" style="color:black">  <i class="fas fa-star    "style="font-weight: 100;">'.$kqdanhgia['danhgia'].' </i></a>'
                                            ; 
                                        }
                                    }else {echo '
                                        <a href=""type="buttom" style="color:black">  <i class="fas fa-star    "style="font-weight: 100;"> 0 </i></a>
                                        ';}
                                echo'
                                </div>
                                <p>Tên tác giả: <a href="timkiem.php?tacgia='.$row['ma_tac_gia'].'">' .$_SESSION['tac_gia'].'</a></p>';
                                if($row['gia_tien']>0 && $checkgia==0){        
                                       echo'
                                       <p>Mới nhất: '.$row4['ten_chuong'].'</p>
                                       ';
                                }else{
                                    echo'
                                        <p>Mới nhất: <a href="noidungchuong.php?chuong='.$row4['ma_chuong'].'">'.$row4['ten_chuong'].'</a></p>
                                    ';
                                }
                                
                                
                                echo'
                                <p>Thời gian đổi mới: '.$row4['ngay'].'</p>
                                <p>Tình trạng: <a href="timkiem.php?tinhtrang='.$row['tinh_trang'].'">'.$row['tinh_trang'].'</a></p>';
                                if($row['gia_tien']>0 ){
                                    if($checkgia==0){
                                       echo'
                                        <p>Giá tiền :'.$row['gia_tien'].'&nbsp xu</p>
                                        <a href="xulimuasach.php?gia='.$row['gia_tien'].'" type="button" class="btn btn-danger  btn-sm">Mở khóa</a>
                                       ';
                                        
                                    }
                                }
                                
                                
                        
                                ?>
                            </div>
                        </div>
                        <div class="thong-tin-1-2">
                            <div>
                                <p> Thể loại : 
                                    <?php
                                        $option=0;
                                        while ($row5 = mysqli_fetch_array($result5)){
                                            $maloai[$option] =$row5['ten_loai'];   
                                            echo'<a href="timkiem.php?theloai='.$row5['ten_loai'].'">'. $row5['ten_loai'].'</a>';
                                            $option = $option+1;
                                        }      
                                    ?>
                                </p>
                            </div>
                            <div>
                                <?php
                                    $myfile = fopen("./truyen/".$row['ten_sach']."/".$row['mo_ta'], "r") or die("Unable to open file!");
                                    if (!$myfile) {
                                        echo "Can't open file";
                                    }
                                    else
                                    {
                                        // Lặp qua từng dòng để đọc
                                        while(!feof($myfile))
                                        {   
                                            echo "<p>".fgets($myfile)."</p>";
                                        }
                                    }
                                ?>
                            </div>
                            <?php icon(); ?>
                        </div>
                    </div>    
                </div>
                <div class="col-lg-3" style="padding-left: 0;">
                    <div id="cungloai" class="right">
                        <div id="cungtheloai" class="right1" >
                            <ul id="hihi" style="overflow: scroll;">
                                    <li><b>Cùng thể loại</b></li>
                                    <?php 
                                        $result7=mysqli_query($conn,"select * from sach where ma_tac_gia='".$row['ma_tac_gia']."';");
                                        if(mysqli_num_rows($result7) > 1 ){
                                            $dem=0;
                                            while ($row7 = mysqli_fetch_array($result7)){
                                                
                                                if($row7['ma_sach']==$masach){continue;}
                                                if($dem>15){continue;};
                                                echo'
                                                <li>
                                                    <div class="rr">
                                                        <a href="">
                                                            <img src="./truyen/'.$row7['ten_sach'].'/'.$row7['hinh_anh'].'" alt="">
                                                        </a>
                                                        <div class="rrr">
                                                            <p class="ts"><a href="chitiettruyen.php?tentruyen='.$row7['ten_sach'].'&&masach='.$row7['ma_sach'].'">'.$row7['ten_sach'].'</a></p>
                                                            <p class="tacgia"><a href="timkiem.php?tacgia='.$row2['ma_tac_gia'].'">'.$row2['ten_tac_gia'].'</a></p>
                                                            <p class="tinhtrang"><a href="timkiem.php?tinhtrang='.$row7['tinh_trang'].'">'.$row7['tinh_trang'].'</a></p>
                                                        </div>
                                                    </div>
                                                </li>
                                                ';
                                                $dem=$dem+1;
                                            }
                                            if($dem<15){ 
                                                $result8=mysqli_query($conn,"select ma_sach from tag_sach ts join the_loai_sach tl on ts.ma_loai=tl.ma_loai where ten_loai='".$maloai[0]."';");
                                                while ($row8 = mysqli_fetch_array($result8)){
                                                    $result9=mysqli_query($conn,"select * from sach where ma_sach='".$row8['ma_sach']."';");
                                                    $row9 = mysqli_fetch_array($result9);
                                                    if($row9['ma_tac_gia']==$row['ma_tac_gia']){continue;}
                                                    if($dem>15){continue;};
                                                    $dem=$dem+1;
                                                    $result10=mysqli_query($conn,"select * from tac_gia where ma_tac_gia='".$row9['ma_tac_gia']."';");
                                                    $row10 = mysqli_fetch_array($result10);
                                                    echo'
                                                    <li>
                                                        <div class="rr">
                                                            <a href="">
                                                                <img src="./truyen/'.$row9['ten_sach'].'/'.$row9['hinh_anh'].'" alt="">
                                                            </a>
                                                            <div class="rrr">
                                                                <p class="ts"><a href="chitiettruyen.php?tentruyen='.$row9['ten_sach'].'&&masach='.$row9['ma_sach'].'">'.$row9['ten_sach'].'</a></p>
                                                                <p class="tacgia"><a href="timkiem.php?tacgia='.$row10['ma_tac_gia'].'">'.$row10['ten_tac_gia'].'</a></p>
                                                                <p class="tinhtrang"><a href="timkiem.php?tinhtrang='.$row9['tinh_trang'].'">'.$row9['tinh_trang'].'</a></p>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    ';
                                                }
                                            }
                                        }else{
                                            $result8=mysqli_query($conn,"select ma_sach from tag_sach ts join the_loai_sach tl on ts.ma_loai=tl.ma_loai where ten_loai='".$maloai[0]."';");
                                            $dem=0;    
                                            while ($row8 = mysqli_fetch_array($result8)){
                                                    $result9=mysqli_query($conn,"select * from sach where ma_sach='".$row8['ma_sach']."';");
                                                    $row9 = mysqli_fetch_array($result9);
                                                    $dem=$dem+1;
                                                    if($row9['ma_tac_gia']==$row['ma_tac_gia']){continue;}
                                                    if($dem>15){continue;};
                                                    $result10=mysqli_query($conn,"select * from tac_gia where ma_tac_gia='".$row9['ma_tac_gia']."';");
                                                    $row10 = mysqli_fetch_array($result10);
                                                    echo'
                                                    <li>
                                                        <div class="rr">
                                                            <a href="">
                                                                <img src="./truyen/'.$row9['ten_sach'].'/'.$row9['hinh_anh'].'" alt="">
                                                            </a>
                                                            <div class="rrr">
                                                                <p class="ts"><a href="chitiettruyen.php?tentruyen='.$row9['ten_sach'].'&&masach='.$row9['ma_sach'].'">'.$row9['ten_sach'].'</a></p>
                                                                <p class="tacgia"><a href="timkiem.php?tacgia='.$row10['ma_tac_gia'].'">'.$row10['ten_tac_gia'].'</a></p>
                                                                <p class="tinhtrang"><a href="timkiem.php?tinhtrang='.$row9['tinh_trang'].'">'.$row9['tinh_trang'].'</a></p>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    ';
                                                }
                                        }
                                    
                                    ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mucluc">
            <div class="mucluc1">
                <p>Mục lục</p>
            </div>
            <div class="mucluc2">
                <ul>
                    <?php 
                    $result6 = mysqli_query($conn,"select * from noi_dung_sach where ma_sach = '".$masach."' order by stt ASC");
                        while ($row6 = mysqli_fetch_assoc($result6)){
                            if($row['gia_tien']>0 && $checkgia==0){
                                echo '<li class="mucluc2-2"><a id="khoachuong" class="btn disabled" href="noidungchuong.php?chuong='.$row6['ma_chuong'].'">'.$row6['ten_chuong'].'</a></li>'
                                ;
                            }else{
                               echo'<li class="mucluc2-2"><a href="noidungchuong.php?chuong='.$row6['ma_chuong'].'">'.$row6['ten_chuong'].'</a></li>';
                            }
                        }
                        $them = mysqli_num_rows($result6)%3;
                        if($them>0){
                            for($i=0;$i<3-$them;$i++){
                                echo '<li class="mucluc2-2"><a href=""></a>&nbsp</li>';
                            }
                        }

                    ?>
                </ul>
            </div>   
        </div>
        <div class="binhluan">
            <?php
            binhluan();
            $result11=mysqli_query($conn,"select * from binh_luan where ma_sach='".$masach."'");
            if(mysqli_num_rows($result11) > 0 ){
                $a=0;
                while ($row11 = mysqli_fetch_array($result11)){
                    $a=$a+1;
                    if($a%2===0){
                        $comt='comment-box1';
                    }else{$comt='comment-box2';}
                    $result12=mysqli_query($conn,"select * from thanh_vien where ma_thanh_vien='".$row11['ma_thanh_vien']."'");
                    $row12 = mysqli_fetch_array($result12);
                    echo'
                    <div class="listcmt">
                        <div class="m-avatar">
                            <div class="avatar">
                                <img src="./truyen/doraemon.jpg" alt="">
                            </div> 
                        </div>
                        <div class="comment">
                            <div class="'.$comt.'">
                                <div class="cmt-name">
                                    <b>'.$row12['ten_thanh_vien'].'</b>
                                </div>
                                <div class="cmt-nd">
                                    <p>'.$row11['noi_dung_bl'].'</p>  
                                    
                                </div>
                                <div class="cmt-rep">
                                    <div style="margin-left: auto;">
                                    <b>Cử báo</b>
                                    <b>Trả lời</b>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                   '
                    ;
                }
            }   
            ?>
        </div>
    </div>
</div>
<script>
 var x = document.getElementById("thongtintruyen").getBoundingClientRect();
  h = x.height;
  document.getElementById("hihi").style.height=h+"px";
</script>
<?php

bottom();?>
