<?php
include 'function.php';
topadmin();
?>
<div style="display: flex;">
<?php menuadmin();
if(isset($_GET['ML'])){$_SESSION['truyen']=$_GET['ML'];}
if(isset($_GET['tim'])){
    $result=mysqli_query($conn,"select * from noi_dung_sach where ma_sach='".$_SESSION['truyen']."' and ten_chuong like '%".$_POST['ten']."%'");
}else{

    $result = mysqli_query($conn,"select * from noi_dung_sach where ma_sach='".$_SESSION['truyen']."'  order by stt ASC");
}
$tongstt=mysqli_num_rows($result)+1;
if($tongstt>0){
    $path=substr($_SERVER['REQUEST_URI'],strripos($_SERVER['REQUEST_URI'],"/")+1);
    $xoaget=substr($path,0, strpos($path,"?"));
    $ten=mysqli_query($conn,"select * from sach where ma_sach='".$_SESSION['truyen']."'");
    $tensach=mysqli_fetch_array($ten);?>
    <div class="col-lg-10" style="padding: 5px;">
        <div class="chuong">
            <div style="display:flex">
                <h4><?php echo $tensach['ten_sach'];?></h4>
                <p type="button" class="btn btn-primary" style="margin:0;margin-left:auto" <?php echo'onclick="themchuong('.$tongstt.')"'; ?>>Thêm chương mới</p>

            </div>
            <div class="danhsachchuong">
                <dialog id="myDialog" class="bangchuong">                   
                    <form action=""  method="POST" id="chinhsuachuong" enctype="multipart/form-data" >
                        <div style="display: flex;">
                            <p id="thongtin"></p>
                            <p id="tenchuong1" class="mauchuong"></p>
                            <p id="tenchuong" class="mauchuong2"></p>
                            <p id="x"></p>
                            <p class="closechuong" onclick="close_chuong()">X</p>
                        </div>
                        <div>
                            <p id="sua"></p> 
                            <input id="suatenchuong" type="text" name="suatenchuong" value="" required>
                        </div>
                        <div style="display: flex;">
                            <p class="mauchuong" id="tenfile1">File:</p>
                            <p id="tenfile"  class="mauchuong2"></p>
                        </div>
                        <div>
                            <p id="sua1"></p>
                            <input type="file" class="form-control-file border" name="fileupload" value="" >
                            <p id="stt"  class="mauchuong" ></p>
                            <input id="sttchen" type="number" name="chen" min="1" value="0" <?php echo 'max="'.$tongstt.'"'; ?>  >   
                        </div>
                        <button type="submit" class="xn">Xác nhận</button>
                    </form>
                </dialog>
                <div>               
                    <form action="?tim" method="post">
                        <label for="">Nhập tên chương: </label>
                        <input type="text" name="ten">
                        <button type="submit">Tìm</button>
                    </form>                   
                </div>
                <div class="chuong1">
                    <table style="width:100%;">
                        <tr>
                            <th>STT</th>
                            <th>Tên chương</th>
                            <th>Nội dung chương</th>
                            <th>Ngày cập nhật</th>
                            <th>Cài đặt</th>
                        </tr>
                        
                        <?php
                        $stt=1;
                        while($row=mysqli_fetch_array($result)){?>
                        <tr>
                            <td><?php echo $stt;?></td>
                            <td><?php echo $row['ten_chuong'];?></td>
                            <td><?php echo $row['noi_dung_chuong'];?></td>
                            <td><?php echo $row['ngay'];?></td>
                            <td>
                                <div style="display: flex;">                                   
                                    <p class="caidatchuong" type="button" onclick="<?php echo "myFunction(".$row['ma_chuong'].",'".$row['noi_dung_chuong']."','".$row['ten_chuong']."')" ?>"><i class="fas fa-tools "></i></p>
                                    <a <?php echo 'href="?xoa='.$row['ma_chuong'].'"';?> class="xoachuong" type="button" ><i class="fas fa-trash-alt "></i></a>
                                </div>
                            </td>
                        </tr>
                        <?php $stt=$stt+1;}
                        ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php }
if(isset($_GET['sua'])){
    $machuong=$_GET['sua'];
    if($_POST['suatenchuong']!=''){
        $suachuong=mysqli_query($conn,"update noi_dung_sach set ten_chuong='".$_POST['suatenchuong']."' where ma_chuong=".$machuong);
    }
    if($_FILES['fileupload']['name']!=''){
        $file=mysqli_query($conn,"select * from noi_dung_sach nd join sach s on nd.ma_sach=s.ma_sach where ma_chuong=".$machuong);
        $tenfilecu=mysqli_fetch_array($file);
        $duongdanfilecu='./truyen/'.$tensach['ten_sach'].'/'.$tenfilecu['noi_dung_chuong'];
        $filemoi='./truyen/'.$tensach['ten_sach'].'/'.$_FILES['fileupload']['name'];
        unlink($duongdanfilecu);
        move_uploaded_file($_FILES['fileupload']['tmp_name'],$filemoi);
        $suafile=mysqli_query($conn,"update noi_dung_sach set noi_dung_chuong='".$_FILES['fileupload']['name']."' where ma_chuong=".$machuong);
    }
    echo'
        <script>    
            if(typeof window.history.pushState == "function") {
                window.history.pushState({}, "Hide", "'.$xoaget.'");
            }
            location.reload();
        </script>
    ';
}
if(isset($_GET['them'])){
    $vitri=$_POST['chen'];
    $thaydoistt=mysqli_query($conn,"select * from noi_dung_sach where ma_sach='".$_SESSION['truyen']."' and stt>=".$vitri."  order by stt ASC");
    $tong=mysqli_num_rows($thaydoistt);
    while($row=mysqli_fetch_array($thaydoistt)){
        $sttdoi=$row['stt']+1;
        $doi=mysqli_query($conn,"update noi_dung_sach set stt=".$sttdoi." where ma_chuong=".$row['ma_chuong']);
    }
    $filemoi='./truyen/'.$tensach['ten_sach'].'/'.$_FILES['fileupload']['name'];
    move_uploaded_file($_FILES['fileupload']['tmp_name'],$filemoi);
    $them=mysqli_query($conn," insert into noi_dung_sach(ma_sach,ten_chuong,noi_dung_chuong,ngay,stt)  values ('".$_SESSION['truyen']."','".$_POST['suatenchuong']."','".$_FILES['fileupload']['name']."','".date("Y-m-d H:i:s")."',".$vitri.");");
    echo'
        <script>    
            if(typeof window.history.pushState == "function") {
                window.history.pushState({}, "Hide", "'.$xoaget.'");
            }
            alert("Thêm thành công!");
            location.reload();
        </script>
    ';
}
if(isset($_GET['xoa'])){
    $vitrixoa=mysqli_query($conn,"select * from noi_dung_sach where ma_chuong='".$_GET['xoa']."'");
    $sttxoa=mysqli_fetch_array($vitrixoa);
    $xoa=mysqli_query($conn,"delete from noi_dung_sach where ma_chuong='".$_GET['xoa']."'");
    $doistt=mysqli_query($conn,"select * from noi_dung_sach where ma_sach='".$_SESSION['truyen']."' and stt>=".$sttxoa['stt']."  order by stt ASC");
    if(mysqli_num_rows($doistt)>0){
        while($row1=mysqli_fetch_array($doistt)){
            $sttdoi1=$row1['stt']-1;
            $doi1=mysqli_query($conn,"update noi_dung_sach set stt=".$sttdoi1." where ma_chuong=".$row1['ma_chuong']);
        }
    }
    echo'
        <script>    
            if(typeof window.history.pushState == "function") {
                window.history.pushState({}, "Hide", "'.$xoaget.'");
            }
            location.reload();
        </script>
    ';
}

?>
<script src="admin.js"></script>
</BOdy>
</HTml>