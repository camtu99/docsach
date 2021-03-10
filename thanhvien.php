<?php
include 'function.php';
if(!isset($_SESSION["tai_khoan"]) || $_SESSION["tai_khoan"]!="admin"|| !isset($_SESSION["mat_khau"]) || $_SESSION["mat_khau"]!=$_SESSION['pass'])
  header("Location: login.php");
topadmin();
if(isset($_GET['TV'])&&isset($_GET['quyen'])){
    $quyen=$_GET['quyen'];
    $matv=$_GET['TV'];
    $result=mysqli_query($conn,"update thanh_vien set quyen=".$quyen." where ma_thanh_vien='".$matv."'");
    if(mysqli_error($result)){
        echo'
        <script>    
        if(typeof window.history.pushState == "function") {
            window.history.pushState({}, "Hide", "thanhvien.php");
        }
        alert("Khóa không thành công");
        location.reload();
    </script>
        ';
    }else{
        echo'
        <script>    
            if(typeof window.history.pushState == "function") {
                window.history.pushState({}, "Hide", "thanhvien.php");
            }
            alert("Khóa thành công");
            location.reload();
        </script>
        ';
    }
}
if(isset($_GET['tv'])){
   $tien= $_POST['tien_cong'];
   $cong=mysqli_query($conn,"call cong_tien('".$_GET['tv']."',".$tien.")");
   echo'
        <script>    
            if(typeof window.history.pushState == "function") {
                window.history.pushState({}, "Hide", "thanhvien.php");
            }
            alert("Cộng thành công");
            location.reload();
        </script>
        ';
}
?>
<div class="container-fluid">
    <div  class="row">
        <?php menuadmin();?>      
        <div class=" col-lg-10" style="padding: 5px;">
            <div>
                <form action="?tim" method="post">
                    <label for="">Nhập tên thành viên: </label>
                    <input type="text" name="ten">
                    <button type="submit">Tìm</button>
                </form>
            </div>
            <div>
                <dialog id="congtien" class="formcongtien">
                    <form id="cong" action="" method="post">
                        <div >
                            <button style="float: right;" onclick="closecongtien()">x</button>
                            <h6>Thêm xu cho tài khoản: <span id="tentv"></span></h6>
                        </div>
                        <div>
                            <input type="number" name="tien_cong" required>
                            <button type="submit">Cộng</button>
                        </div>

                    </form>
                </dialog> 
            </div>
            <div class="list-truyen">
                <table style="width:100%;">
                    <tr>
                        <th >Tên thành viên</th>
                        <th>Số tiền</th>
                        <th>Khóa</th>
                        
                    </tr>
                    <?php
                    if(isset($_GET['tim'])){
                        $thanhvien ="select * from thanh_vien where ten_thanh_vien like '%".$_POST['ten']."%'";
                    }else{
                        $thanhvien ='select * from thanh_vien';
                    }
                    $result=mysqli_query($conn,$thanhvien);
                        if(mysqli_num_rows($result) > 0 ){
                            while ($row = mysqli_fetch_array($result)){                  
                                echo'<tr>
                                <td >'.$row['ten_thanh_vien'].'</td>
                                <td> <p type="button" onclick="'; echo"showcongtien('".$row['ma_thanh_vien']."','".$row['ten_thanh_vien']."');";  echo'">'.$row['so_tien'].'</p></td>';                                       
                                if($row['quyen']==0){
                                    echo'
                                    <td><button><a href="thanhvien.php?TV='.$row['ma_thanh_vien'].'&&quyen=1">Khóa</a></button></td>
                                        </tr>';
                                }else{
                                    echo'
                                    <td><button><a href="thanhvien.php?TV='.$row['ma_thanh_vien'].'&&quyen=0">Mở khóa</a></button></td>
                                        </tr>';
                                }     
                            }
                        }else {
                            echo "Danh sách rỗng";
                        }
                            ?>
                </table>
            </div>
        </div>
        <script src="admin.js"></script>
    </div>        
</div>
</body>
</html>
