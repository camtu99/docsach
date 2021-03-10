<?php
include 'function.php';
if(!isset($_SESSION["tai_khoan"]) || $_SESSION["tai_khoan"]!="admin"|| !isset($_SESSION["mat_khau"]) || $_SESSION["mat_khau"]!=$_SESSION['pass'])
  header("Location: login.php");
topadmin();
?>
    
    <div class="container-fluid" >
        <div style="margin: 5px;">
            <div class="row">
            <?php menuadmin();?>
            <div class="col-lg-10" style="padding: 0;">
                <div style="display: flex;">
                    <div>
                        <form action="?tim" method="post">
                            <label for="">Nhập tên truyện: </label>
                            <input type="text" name="tensach">
                            <button type="submit">Tìm</button>
                        </form>
                    </div>
                    <div style="width: 150px;margin-left: auto;">
                        <a href="create-story.php" class="btn btn-success">Thêm truyện mới</a>
                    </div>
                </div>             
                <div class="list-truyen">
                    <table style="width:100%;">
                        <tr>
                            <th ><p>Tên truyện</p></th>
                            <th ><p>Hình ảnh</p></th>
                            <th > <p>Tình trạng</p></th>
                            <th > <p>Thể loại</p></th>
                            <th > <p>Mô tả</p></th>
                            <th > <p>Tác giả</p></th>
                            <th><p>Giá tiền</p></th>
                            <th > <p>Cài đặt</p></th>
                        </tr>
                        <?php
                        if(isset($_GET['tim'])){
                            $sach="select * from sach where ten_sach like '%".$_POST['tensach']."%'";
                        }else{
                            $sach ='select * from sach';
                        }
                            $result=mysqli_query($conn,$sach);
                            if(mysqli_num_rows($result) > 0 ){
                                while ($row = mysqli_fetch_array($result)){
                                    $result1=mysqli_query($conn,"select tl.ten_loai from tag_sach ts join the_loai_sach tl on ts.ma_loai=tl.ma_loai where ma_sach='".$row['ma_sach']."';");
                                    $result2=mysqli_query($conn,"select * from tac_gia where ma_tac_gia='".$row['ma_tac_gia']."'");
                                    $row2=mysqli_fetch_array($result2);
                                    
                                    echo'<tr>
                                        <td ><a href="suatruyen.php?ML='.$row['ma_sach'].'&&loai=suaten" >'.$row['ten_sach'].'</a></td>
                                        <td ><a href="suatruyen.php?ML='.$row['ma_sach'].'&&loai=suahinhanh" ><img src="./truyen/'.$row['ten_sach'].'/'.$row['hinh_anh'].'" alt=""></a></td>
                                        <td >
                                            <form action="suatruyen.php?ML='.$row['ma_sach'].'&&loai=suatrangthai" method="POST" style="display: flex;" >
                                            <select name="trangthai">';
                                    if($row['tinh_trang']=='Hoàn thành'){
                                        echo'
                                            <option value="Hoàn thành">Hoàn thành</option>
                                            <option value="Chưa hoàn thành">Chưa hoàn thành</option>';
                                    }
                                    else{
                                        echo'
                                        <option value="Chưa hoàn thành">Chưa hoàn thành</option>
                                        <option value="Hoàn thành">Hoàn thành</option>';
                                    }
                                    echo'
                                        </select>
                                        <button type="submit">Thay đổi</button>
                                        </form>
                                    
                                        </td>
                                        <td >';sualoai($row['ma_sach']);echo'<a type="button" onclick="show'.$row['ma_sach'].'()" >';
                                    if(mysqli_num_rows($result1)>0){
                                        while($row1=mysqli_fetch_array($result1)){
                                        echo$row1['ten_loai'].' ';
                                        }
                                    }else{ echo'Rỗng';}
                                        
                                    echo '</a></td>
                                        <td >';suamota($row['ma_sach']);echo'<a type="button" onclick="show'.$row['ma_sach'].'mota()">'.$row['mo_ta'].'</td>
                                        <td ><a href="suatruyen.php?ML='.$row['ma_sach'].'&&loai=suatacgia" >'.$row2['ten_tac_gia'].'</a></td>
                                        <td ><a  type="button" onclick="showgiatien()" >'.$row['gia_tien'].'</a></td>
                                        ';
                                    if($row['khoa']==0){
                                        echo'
                                        <td>
                                            <div style="display :flex">
                                                <a type="button" style=" padding: 0.01rem 0.3rem;"  class=" btn btn-success caidattruyen" href="suatruyen.php?ML='.$row['ma_sach'].'&&khoa=1"><i class="fa fa-unlock-alt" aria-hidden="true"></i></a>
                                                <a type="button" style=" padding: 0.01rem 0.3rem;"  class="btn btn-secondary caidattruyen" href="danhsachchuong.php?ML='.$row['ma_sach'].'"><i class="fa fa-list-alt" aria-hidden="true"></i></a>
                                            </div>
                                        </td>
                                            </tr>';
                                    }else{
                                        echo'
                                        <td>
                                            <div style="display :flex">
                                                <a type="button" style=" padding: 0.01rem 0.3rem;" class="caidattruyen btn btn-danger" href="suatruyen.php?ML='.$row['ma_sach'].'&&khoa=0"><i class="fa fa-lock" aria-hidden="true"></i></a>
                                                <a type="button" style=" padding: 0.01rem 0.3rem;" class="caidattruyen btn btn-secondary" href="danhsachchuong.php?ML='.$row['ma_sach'].'"><i class="fa fa-list-alt" aria-hidden="true"></i></a>
                                            </div>
                                        </td>
                                            </tr>';
                                    }     
                                }
                            }
                            else {
                                echo "Danh sách rỗng";
                            }
                        ?>
                    </table>
                </div>
            </div>
        </div> 
        
    </div>
</body>
</html>
