<?php
    include 'function.php';
    if(!isset($_SESSION["tai_khoan"]) || $_SESSION["tai_khoan"]!="admin"|| !isset($_SESSION["mat_khau"]) || $_SESSION["mat_khau"]!=$_SESSION['pass'])
    header("Location: login.php");
    topadmin();
?>
<div class="class="container-fluid>
    <div class="row" style="display: flex;">
        <?php menuadmin(); ?>
        <div class="col-lg-10 thenap">
            <div>
                <div class="timtacgia">              
                        <form action="?tim" method="post">
                            <label for="">Nhập tên tác giả: </label>
                            <input type="text" name="ten">
                            <button type="submit">Tìm</button>
                        </form>
                    <div style="display: flex;flex-wrap:nowrap;margin-left:auto"> 
                        
                            <p>Thêm tác giả</p>
                        
                        
                            <form action="tacgia.php?id=create" method="Post">
                                <input type="text" name="tacgia">
                                <button>Thêm</button>
                            </form>
                        <p id="them"></p>
                    </div>
                </div>
            <div class="col-lg-12">
                <table class="tacgia">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Tên tác giả</th>
                            <th>Sửa</th>
                        </tr>
                    </thead>
                    <tbody style="font-weight: normal;">
                        <?php
                        if(isset($_GET['tim'])){
                            $result1=mysqli_query($conn,"select ROW_NUMBER() OVER (order by ten_tac_gia) AS 'stt',ten_tac_gia,ma_tac_gia from tac_gia where ten_tac_gia like '%".$_POST['ten']."%'");
                        }else{
                            $result1=mysqli_query($conn,"select ROW_NUMBER() OVER (order by ten_tac_gia) AS 'stt',ten_tac_gia,ma_tac_gia from tac_gia");
                        }
                            while($row=mysqli_fetch_array($result1)){
                            echo'  
                                <tr>
                                    <td>'.$row['stt'].'</td>
                                    <td>
                                        '.$row['ten_tac_gia'].'
                                        <div id="'.$row['ma_tac_gia'].'" class="collapse">
                                        <form action="tacgia.php?TG='.$row['ma_tac_gia'].'" method="Post">
                                        <input type="text" name="suaten" required>
                                        <button>Thay đổi</button>
                                        </form>
                                        </div>
                                    </td>
                                    <td>
                                        <button data-toggle="collapse" data-target="#'.$row['ma_tac_gia'].'">Sửa</button>
                                    
                                    </td>
                                </tr> ';
                            }
                        ?>
                    </tbody>
                </table>
   </div> 
<?php
    if(isset($_GET['id'])&&$_GET['id']=='create'){
        $result =mysqli_query($conn,"select * from tac_gia where ten_tac_gia='".$_POST['tacgia']."'");
        if(mysqli_num_rows($result)){
            echo '<script>
            document.getElementById("them").innerHTML = "Tác giả đã có trên web";
            </script>';
        }else{
            $result1=mysqli_query($conn,"select * from tac_gia");
            $stt=mysqli_num_rows($result1)+1;
            $ma='TG'.$stt;
            $result2=mysqli_query($conn,"insert into tac_gia values ('".$ma."','".$_POST['tacgia']."')");
            echo '
            <script>
            if(typeof window.history.pushState == "function") {
                window.history.pushState({}, "Hide", "tacgia.php");
            }
            alert("Thêm tác giả thành công");
            location.reload();
            </script>
            ';
        }
    }
    if(isset($_GET['TG'])){
        $result4=mysqli_query($conn,"update tac_gia set ten_tac_gia='".$_POST['suaten']."' where ma_tac_gia='".$_GET['TG']."'");
        if($result4){
           echo' <script>    
           if(typeof window.history.pushState == "function") {
               window.history.pushState({}, "Hide", "tacgia.php");
           }
           alert("Sửa thành công");
           location.reload();
       </script>';
        }
    }
    ?>
    <?php
bottomadmin();   
?>
