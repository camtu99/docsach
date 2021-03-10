<?php
    include 'function.php';
    if(!isset($_SESSION["tai_khoan"]) || $_SESSION["tai_khoan"]!="admin"|| !isset($_SESSION["mat_khau"]) || $_SESSION["mat_khau"]!=$_SESSION['pass'])
    header("Location: login.php");
    topadmin();
?>
<div class="container-fluid">
    <div class="row" style="display: flex;">
        <?php menuadmin(); ?>
        <div class="col-lg-10 thenap">
            <div style="display: flex;flex-wrap:nowrap">
                <form action="?tim" method="post">
                    <label for="">Nhập thể loại: </label>
                    <input type="text" name="ten">
                    <button type="submit">Tìm</button>
                </form>
                <div style="display: flex;flex-wrap:nowrap;margin-left: auto;">
                    <p>Thêm thể loại:</p>
                    <form action="theloai.php?id=create" method="Post">
                        <input type="text" name="theloai">
                        <button>Thêm</button>
                    </form>
                    <p id="them"></p>
                </div>
            </div>      
            <div>
                <table class="tacgia">
                    <thead>
                            <tr>
                                <th>STT</th>
                                <th>Thể loại</th>
                                <th>Sửa</th>
                            </tr>
                    </thead>
                        <tbody>
                            <?php
                            if(isset($_GET['tim'])){
                                $result1=mysqli_query($conn,"select ROW_NUMBER() OVER (order by ma_loai desc) AS 'stt',ma_loai,ten_loai from the_loai_sach where ten_loai like '%".$_POST['ten']."%'");
                            }else{
                                $result1=mysqli_query($conn,"select ROW_NUMBER() OVER (order by ma_loai desc) AS 'stt',ma_loai,ten_loai from the_loai_sach");
                            }   
                            while($row=mysqli_fetch_array($result1)){
                                echo'  
                                    <tr>
                                        <td>
                                            '.$row['stt'].'
                                        </td>
                                        <td>
                                            '.$row['ten_loai'].'
                                            <div id="'.$row['ma_loai'].'" class="collapse">
                                                <form action="theloai.php?TL='.$row['ma_loai'].'" method="Post">
                                                    <input type="text" name="suaten" required>
                                                    <button>Thay đổi</button>
                                                </form>
                                            </div>
                                        </td>
                                        <td>
                                            <button data-toggle="collapse" data-target="#'.$row['ma_loai'].'">Sửa</button>
                                        </td>
                                    </tr> '
                                ;
                            }         
                            ?>
                        </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
    
<?php
    if(isset($_GET['id'])&&$_GET['id']=='create'){
        $result =mysqli_query($conn,"select * from the_loai_sach where ten_loai='".$_POST['theloai']."'");
        if(mysqli_num_rows($result)){
            echo '<script>
            document.getElementById("them").innerHTML = "Thể loại đã có trên web";
            </script>';
        }else{
            $result1=mysqli_query($conn,"select * from the_loai_sach");
            $stt=mysqli_num_rows($result1)+1;
            $ma='TL'.$stt;
            $result2=mysqli_query($conn,"insert into the_loai_sach values ('".$ma."','".$_POST['theloai']."')");
            echo '
            <script>
            if(typeof window.history.pushState == "function") {
                window.history.pushState({}, "Hide", "theloai.php");
            }
            alert("Thêm thành công");
            location.reload();
            </script>
            ';
        }
    }
    if(isset($_GET['TL'])){
        $result4=mysqli_query($conn,"update the_loai_sach set ten_loai='".$_POST['suaten']."' where ma_loai='".$_GET['TL']."'");
        if($result4){
           echo' <script>    
           if(typeof window.history.pushState == "function") {
               window.history.pushState({}, "Hide", "theloai.php");
           }
           alert("Sửa thành công");
           location.reload();
       </script>';
        }
    }
?>
 
