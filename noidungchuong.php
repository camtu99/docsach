<?php 
include 'function.php';
menu();
$machuong=$_GET['chuong'];
$luotdoc=mysqli_query($conn," call luotdoc('".$_SESSION['ma_sach']."')");
?>
<div class="truyen">
    <div class="container">
        <br>
        <?php search(); ?>
        <div class="tieude">
            <div class="tieude1">
                <p>
                    <?php
                    $result=mysqli_query($conn,"select * from noi_dung_sach where ma_chuong=".$machuong);
                    $row= mysqli_fetch_assoc($result);
                    $chuongtruoc=$row['stt']-1;
                    $chuongsau=$row['stt']+1;
                        echo $_SESSION['ten_sach']." > ".$row['ten_chuong'];
                    ?> 
                </p>
                <div class="muclucchuong">
                    <?php
                        $result1=mysqli_query($conn,"select * from noi_dung_sach where ma_sach='".$_SESSION['ma_sach']."';");
                        $result2=mysqli_query($conn,"select * from noi_dung_sach where ma_sach='".$_SESSION['ma_sach']."' and stt=".$chuongtruoc);
                        $result3=mysqli_query($conn,"select * from noi_dung_sach where ma_sach='".$_SESSION['ma_sach']."' and stt=".$chuongsau);
                        $truoc=mysqli_fetch_array($result2);
                        $sau=mysqli_fetch_array($result3);
                        $tong=mysqli_num_rows($result1);
                        if($row['stt']==1){
                            echo'  
                            <a href="chitiettruyen.php">Mục lục</a>
                            <a href="noidungchuong.php?chuong='.$sau['ma_chuong'].'">Chương sau</a>
                        ';
                        }else{
                            if($row['stt']==$tong){
                                echo '
                                    <a href="noidungchuong.php?chuong='.$truoc['ma_chuong'].'">< Chương trước </a>
                                    <a href="chitiettruyen.php">Mục lục</a>
                                    
                                ';
                            }
                            else{
                                echo'
                                    <a href="noidungchuong.php?chuong='.$truoc['ma_chuong'].'">< Chương trước </a>
                                    <a href="chitiettruyen.php">&nbsp Mục lục &nbsp </a>
                                    <a href="noidungchuong.php?chuong='.$sau['ma_chuong'].'"> Chương sau ></a>
                                ';
                            }
                        }
                    ?>
                </div>
            </div>
            <hr style="margin: 0;">
        </div>
        <br>
            <div class="tentua">
                <b class="tentua1"><?php echo $_SESSION['ten_sach']?></b>
                <p style="margin: 0;"><?php echo $row['ten_chuong']?></p>
                <p > <?php echo'Tác giả: <a href="">' .$_SESSION['tac_gia'].'</a>';?></p>
            </div>
        <br>
        <br>
        <div>
            <div class="noidungne">
                <?php
                    $myfile = fopen("./truyen/".$_SESSION['ten_sach']."/".$row['noi_dung_chuong'], "r") or die("Unable to open file!");
                    if (!$myfile) {
                        echo "Can't open file";
                    }
                    else
                    {  
                        while(!feof($myfile))
                        {   
                            echo "<p>".fgets($myfile)."</p>";
                        }
                    }
                ?>
            </div>
        </div>
        <br>
        <br>
        <div>
            <div class="cuoi">
            <?php                        
                if($row['stt']==1){
                    echo'  
                    <a class="ct" href="chitiettruyen.php">Mục lục</a>
                    <a class="ct" href="noidungchuong.php?chuong='.($machuong+1).'">Chương sau</a>
                ';
                }else{
                    if($row['stt']==$tong){
                        echo '
                            <a class="ct" href="noidungchuong.php?chuong='.($machuong-1).'">< Chương trước </a>
                            <a class="ct" href="chitiettruyen.php">Mục lục</a>
                            
                        ';
                    }
                    else{
                        echo'
                            <a class="ct" href="noidungchuong.php?chuong='.($machuong-1).'">< Chương trước </a>
                            <a class="ct" href="chitiettruyen.php">&nbsp Mục lục &nbsp </a>
                            <a class="ct" href="noidungchuong.php?chuong='.($machuong+1).'"> Chương sau ></a>
                        ';
                    }
                }
                    ?>
            </div>
        </div>
        <br>
        <br>
        <div class="binhluan">
            <?php 
                binhluan();
            ?>
        </div>
    </div>
</div>
<?php bottom(); ?>



