<?php 
    include 'function.php';
  if(!isset($_SESSION["tai_khoan"]) || $_SESSION["tai_khoan"]!="admin"|| !isset($_SESSION["mat_khau"]) || $_SESSION["mat_khau"]!=$_SESSION['pass'])
  header("Location: login.php");
  topadmin();
?>
<div class="container-fluid">
            <div class="form-infor-story">
                <h1 class="a1">Tạo truyện mới</h1>
                <?php
                     $path=substr($_SERVER['REQUEST_URI'],strripos($_SERVER['REQUEST_URI'],"/")+1);
                     $xoaget=substr($path,0, strpos($path,"?"));
                    if(isset($_GET['id']) && $_GET['id'] == 'create'){
                        $demma=mysqli_query($conn,"select * from sach");
                        $ma = mysqli_num_rows($demma)+1;
                        $masach='MS'.$ma;      
                        $tentruyen = $_POST['name'];
                        $tinhtrang = $_POST['tinh-trang'];
                        $tacgia = $_POST['tac-gia'];
                        $mota = $_FILES['mota']['name'];
                        $hinhanh = $_FILES['fileupload']['name'];
                        $giatien=$_POST['gia_tien'];
                        $luotdoc = 0;
                        $khoa=0;
                        $duongdan = './truyen/'.$tentruyen.'/'.$_FILES['fileupload']['name'];
                        $duongdan1='./truyen/'.$tentruyen.'/'.$_FILES['mota']['name'];
                        $thumuc = './truyen/'.$tentruyen;
                        $sql = "Insert into sach values('".$masach."','".$tentruyen."','".$mota."','".$tinhtrang."','".$hinhanh."','".$tacgia."',".$luotdoc.",".$giatien.",".$khoa.");";
                        $insert = mysqli_query($conn,$sql);
                        if (!$insert) {
                            if (strpos(mysqli_error($conn), "Duplicate entry") !== FALSE) {
                                echo '
                                    <script type="text/javascript">
                                        if(typeof window.history.pushState == "function") {
                                            window.history.pushState({}, "Hide", "'.$xoaget.'");
                                        }
                                        alert("Sách đã tồn tại!");
                                        location.reload();
                                    </script>
                                ';
                            }
                        }
                        else {   
                            //tao thu muc
                            mkdir($thumuc,0777);
                            //upload anh
                            move_uploaded_file($_FILES['fileupload']['tmp_name'],$duongdan);
                            move_uploaded_file($_FILES['mota']['tmp_name'],$duongdan1);
                            $result =mysqli_query($conn,'select ma_loai from the_loai_sach');
                            $row = mysqli_num_rows($result);
                            $option = 1;
                                while($option<=$row){
                                    if(isset($_POST[$option])){
                                        $sql = "Insert into tag_sach values('".$masach."','".$_POST[$option]."');";
                                        $insert = mysqli_query($conn,$sql);;
                                    }
                                    $option=$option+1;
                                }
                                echo '
                                    <script type="text/javascript">
                                        if(typeof window.history.pushState == "function") {
                                            window.history.pushState({}, "Hide", "'.$xoaget.'");
                                        }
                                        alert("Thêm sách thành công!");
                                        location.reload();
                                    </script>
                                ';
                                
                        }

                    }
                    else{
                ?>
                <form action="create-story.php?id=create" id="new-story" method="POST"  enctype="multipart/form-data" >
                    <table>
                        
                        <tr>
                            <td>
                                <div class="form-group">
                                    <label>Tên truyện:</label>
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <input type="text" name="name" required>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="form-group">
                                    <label for="usr">Tình trạng:</label>
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <select class="form-control" id="sel1" name="tinh-trang">
                                        <option value="Hoàn thành">Hoàn thành</option>
                                        <option value="Chưa hoàn thành">Chưa hoàn thành</option>
                                    </select>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="form-group">
                                    <label >Thể loại:</label>
                                </div>
                            </td>
                            <td class="loai">
                                <?php 
                                    tag_truyen();                            
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="form-group">
                                    <label >Hình ảnh:</label>
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <input type="file" class="form-control-file border" name="fileupload" required>    
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="form-group">
                                    <label >Tên Tác giả:</label>
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <select class="form-control" id="sel1" name="tac-gia">
                                        <?php tac_gia(); ?>
                                    </select>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="form-group">
                                    <label >Giá tiền:</label>
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                <input id="gia" type="number" name="gia_tien" min="0" value="0" required  >  
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div class="form-group">
                                    <label >Mô tả:</label>
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <input type="file" class="form-control-file border" name="mota" required>    
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <button type="submit">Tạo</button>
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
            <a href="admin.php">Quay lại</a>
        </div>
                        <?php }; ?>
        </body>
    </html>