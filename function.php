<?php
session_start();
include 'connection.php';
 /* Chương truyện mới */
function chuongMoi(){   
    include 'connection.php';
    $result = mysqli_query($conn,'select s.ma_sach,s.ten_sach,s.mo_ta,s.tinh_trang,s.hinh_anh,s.ma_tac_gia,s.luot_doc,s.gia_tien,s.khoa from noi_dung_sach nd join sach s on s.ma_sach=nd.ma_sach group by ma_sach order by ngay desc limit 12;');
    if(mysqli_num_rows($result) > 0 ){
        while ($row = mysqli_fetch_array($result)){
            $ma_sach=$row['ma_sach'];
            $result1  = mysqli_query($conn,"select count(ma_binh_luan) from binh_luan where ma_sach='".$ma_sach."'");
            $row1 = mysqli_fetch_array($result1);
            $result2 = mysqli_query($conn,"select ten_tac_gia from tac_gia where ma_tac_gia = '".$row['ma_tac_gia']."'");
            $row2 = mysqli_fetch_array($result2);
            $luotdoc=luotdoc($ma_sach);
           echo'
           <div class="book-item col-md-3" >
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
    };
};
/* Hai bảng quảng cáo */
function ads(){
  echo'
  <div id="ads-left">
        <div style="margin:0 0 5px 0; padding:0;width:300px;position:fixed; left:50%;margin-left: 590px; top:0;">
          <a href="" ><img  height="800" src="qc.jpg" width="300"/></a>
        </div>
      </div>
      <div id="ads-right">
        <div style="margin:0 0 5px 0; padding:0;width:300px;position:fixed; right:50%;margin-right: 590px; top:0;">
          <a href=""><img  height="800" src="qc.jpg" width="300"/></a>
        </div>
      </div>
  ';
}
/* truyện xem nhiều  */
function top_view(){
    
    include 'connection.php';
    $result = mysqli_query($conn,'select * from sach order by luot_doc desc limit 10');
    if(mysqli_num_rows($result) > 0 ){
        echo'<div class="list-top-view">
        <ul class="list-top-ul">';
        while ($row = mysqli_fetch_array($result)){
           echo'
           <li class="list-top-li">
            <a href="chitiettruyen.php?masach='.$row['ma_sach'].'">
                <div class="list-top-img">
                    <img src="./truyen/'.$row['ten_sach'].'/'.$row['hinh_anh'].'" style="height=70px;width:50px;">
                </div>
                <div>
                    <b>'.$row['ten_sach'].'</b>
                    <p><i class="fa fa-eye" aria-hidden="true" style=" font-weight: 100;">&nbsp' .$row['luot_doc'].' lượt đọc</i></p>
                </div>
            </a>
        </li>
           ';
        }
        echo'</ul>
        </div>';
    }
    ;
}
/* chọn tag-truyện */
function tag_truyen(){ 
    include 'connection.php';
    $result =mysqli_query($conn,'select * from the_loai_sach');
    if(mysqli_num_rows($result) > 0 ){
       
        $option =0;
        while ($row = mysqli_fetch_array($result)){
            $option = $option+1;
            echo'
                <div class="form-check loai1">
                    <label class="form-check-label">
                        <input type="checkbox" class="form-check-input" name="'.$option.'" value="'.$row['ma_loai'].'" >'.$row['ten_loai'].'
                    </label>
                </div>
            ';
        }
    }                               
}  
//  chọn tác giả
function tac_gia(){
    include 'connection.php';
    $result =mysqli_query($conn,'select ma_tac_gia,ten_tac_gia from tac_gia');
    if(mysqli_num_rows($result) > 0 ){
       
        $option =0;
        while ($row = mysqli_fetch_array($result)){
            $option = $option+1;
            echo'
                
                        <option value="'.$row['ma_tac_gia'].'">'.$row['ten_tac_gia'].'</option>
            ';
        }      
    }      
 }
/* thanh menu trên index */
function menu(){
  $path=substr($_SERVER['REQUEST_URI'],strripos($_SERVER['REQUEST_URI'],"/")+1);
    $pos = strpos($path, '?');
        if ($pos !== false) {
            $_SESSION['duongdan']=substr($path,0, strpos($path,"?"));
        } else {
            $_SESSION['duongdan']= $path;
        };
  echo'
    <!doctype html>
    <html lang="vn">
  <head>
    <title>Nhã Các | Đọc truyện online</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="main.css">
  </head>
  <body style="background-color: #F5F5F5; font-size: large;height:100%">
      
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <!-- hai bảng quảng cáo -->
    <div style="height:100%">
    <nav class="navbar navbar-expand-sm navbar-dark" style="background-image: url(logo5.jpg);">
          <div class="container">
            <a class="navbar-brand" href="index.php"><img src="logo4.png" alt="" style="height: 45px;width: 160px;"> </a>
            <button class="navbar-toggler d-lg-none" type="button" data-toggle="collapse" data-target="#collapsibleNavId" aria-controls="collapsibleNavId"
                aria-expanded="false" aria-label="Toggle navigation"></button>
            <div class="collapse navbar-collapse" id="collapsibleNavId">
                <ul class="navbar-nav mr-auto mt-2 mt-lg-0" style="width:100%">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Thể loại</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="#">Tác giả</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="#">Tìm truyện</a>
                    </li>
                    <li class="nav-item" style="margin-left: auto;">';
                        if(isset($_SESSION['ten_tk'])){
                          echo 
                          '<a class="nav-link" href="thongtinthanhvien.php">'.$_SESSION['ten_tk'].'</a>     
                                </li>
                          <li class="nav-item" >
                            <a class="nav-link" href="dangxuat.php" ><i class="fa fa-sign-in" aria-hidden="true">Thoát</i></a>
                          </li>';
    
                        }
                        else{
                          dangki();
                          dangnhap();
                         
                          echo '<a class="nav-link" type="button" onclick="showdangnhap()">Đăng nhập</a>
                          </li>
                          <li class="nav-item" >
                            <a class="nav-link" type="button" onclick="showdangki()">Đăng kí</a>
                          </li>';
                        }
                        echo'
                </ul>  
            </div>
          </div>
        </nav>'; 
        echo'
          <div style="padding: 1rem;">
            <div style="text-align: center;color:#007bff;font-weight:700">
              <div style="text-align:left;display:inline-block">
              <i class="fas fa-caret-right    "></i><u>Hướng dẫn nạp thẻ</u><br>
              <i class="fas fa-caret-right    "> </i><u>Hướng dẫn báo cáo truyện lỗi</u><br>
              <i class="fas fa-caret-right    "></i><u>Danh sách ngôn tình đề cử tháng 12</u><br>
              <i class="fas fa-caret-right    "></i> <u>Danh sách ngôn đam mỹ cử tháng 12</u>
              </div>
            </div>
          </div>
        ';
                    
      }
/* icon */
function icon(){
  echo'
      <div style="display: flex;padding:10px;">
      <div class="name1-1">
          <a href="" class="name1">Name</a>
          <a href="" class="name1"><i class="fa fa-comment-o" aria-hidden="true"></i></a>
          <a href="" class="name1">Review</a>
      </div>
      <div class="name1-2">
          <a href="" class="name2">Name</a>
          <a href="" class="name2"><i class="fa fa-comment-o" aria-hidden="true"></i></a>
          <a href="" class="name2">Review</a>
      </div>
    </div>
  ';
}
/* tìm kiếm sách */
function search(){
   echo'
   <div class="search">
    <form action="timkiem.php" method="GET">
        <div class="search-right">
            <input style="border-radius:5px;padding-left:10px;width:290px;" placeholder="Nhập tên cần tìm" type="text" name="search" >
            <button style="border: 0;background-color: transparent;"><i class="fa fa-search" aria-hidden="true" style="color:#00CED1"></i></button>
        </div>
    </form>
  </div> 
   ';
}
/* bình luận */
 function binhluan(){
   check();
   echo'
  <div class="nhanbinhluan">
    <p style="font-size: x-large;width:90%"><i class="fa fa-commenting" aria-hidden="true" style="color:orange"></i>&nbsp<b>Bình luận</b></p>
    <p style="right: auto;">Xếp theo&nbsp<i class="fa fa-angle-down" aria-hidden="true"></i></p>
  </div>
    <div class="binhluan1">
      <i class="far fa-comment-dots" aria-hidden="true" style="font-size:100px;margin:auto;color:#c9c9c9"></i></p>
      <div class="binhluan1-1">
          <form action="xulibinhluan.php">
              <textarea name="message" style="width:100%; height:150px;"></textarea>
              <br>
              <input type="submit" style="float: right;">
          </form>
      </div>
    </div>
   ';
}

 function bottom(){

   echo'<script src="admin.js"></script>
          <footer style="background-color:#27c6da;height: 50px;"><p></p></footer>
        </div>
      </body>
    </html>
   ';
}

function check(){
  if(isset($_SESSION['check'])){
    echo'<script>
          alert("Bạn chưa đăng nhập!");
        </script>';
    unset($_SESSION['check']);
  }
}
function topadmin(){
   echo'
   <!doctype html>
   <html lang="en">
     <head>
       <title>Title</title>
       <!-- Required meta tags -->
       <meta charset="utf-8">
       <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
       <!-- Bootstrap CSS -->
       <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
     </head>
     <body style=" background-color: #c1d6ec;">
         
       <!-- Optional JavaScript -->
       <!-- jQuery first, then Popper.js, then Bootstrap JS -->
       <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
       <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
       <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
       <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.min.js"></script>
       <script src="https://kit.fontawesome.com/a076d05399.js"></script>
       <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
       <link rel="stylesheet" href="admin.css">
   ';
}
function menuadmin(){
   echo'
    <div class="col-lg-2" style="padding: 0;">
        <div class="menu">
          <ul class="list-group">
            <li class="list-group-item"><a href="admin.php" class="menuadmin1">Truyện</a></li>
            <li class="list-group-item"><a href="tacgia.php" class="menuadmin1">Tác giả</a></li>
            <li class="list-group-item"><a href="theloai.php" class="menuadmin1">Thể loại</a></li>
            <li class="list-group-item"><a href="thanhvien.php" class="menuadmin1">Thành viên</a></li>
            <li class="list-group-item"><a href="thenap.php" class="menuadmin1">Thẻ nạp</a></li>
            <li class="list-group-item"><a href="#thongke" data-toggle="collapse">Thống kê</a></li>
            <div id="thongke" class="collapse">
              <li class="list-group-item"><a href="thongke.php" class="menuadmin1">Thống kê lượt đọc</a></li>
              <li class="list-group-item"><a href="thongkemokhoa.php" class="menuadmin1">Thống kê mở khóa</a></li>
              <li class="list-group-item"><a href="thongkethenap.php" class="menuadmin1">Thống kê nạp thẻ</a></li>
            </div>
          </ul>
        </div>       
    </div>
   ';
}
function bottomadmin(){
  echo '<script src="admin.js"></script>
       </div> 
      </div>
    </div>
    </body>
  </html>';
}
function dangnhap(){
  echo '
  <dialog id="dangnhap" class="formdangnhap" >   
      <div style="display:flex;">
        <h2>Đăng nhập  </h2>
        
        <button style="margin-left: auto;" onclick="closedangnhap()">Đóng</button>
      </div>
      <form action="?login" method="post">
          <div class="form-group">
            <label class="dndk">User :</label>
            <input type="text" class="form-control"  placeholder="Tài khoản" value="" name="user" required>
          </div>
          <div class="form-group">
            <label class="dndk" >Password:</label>
            <input type="password" class="form-control"  placeholder="Nhập pass" value="" name="pass" required>
          </div>
          <button type="submit" class="btn btn-primary">Submit</button>
      </form>
   
    
  </dialog>
  <script>

  var dangnhap = document.getElementById("dangnhap"); 
  
  function showdangnhap() { 
    dangnhap.show(); 
  } 
  
  function closedangnhap() { 
    dangnhap.close(); 
  } 
  </script> 
  ';
  if(isset($_GET['login'])){

    include 'connection.php';   
    $_SESSION['tai_khoan_tv']=$_POST['user'];
    $_SESSION['mat_khau_tv']=md5($_POST['pass']) ;
        $user = "select * from thanh_vien where ma_thanh_vien='".$_SESSION['tai_khoan_tv']."';";
        $result = mysqli_query($conn,$user);
        if(mysqli_num_rows($result)>0){
          
            $row1 = mysqli_fetch_assoc($result);
            if($row1['mat_khau']==$_SESSION['mat_khau_tv'] && $row1['quyen']==0){
                
                $_SESSION['ten_tk']=$row1['ten_thanh_vien'];
                echo '

                    <script>    
                    if(typeof window.history.pushState == "function") {
                      window.history.pushState({}, "Hide", "'.$_SESSION['duongdan'].'");
                  }
                        alert("Đăng nhập thành công!");
                        location.reload();
                    </script>
                    ';    
            }else {
                echo'
                    <script>    
                        if(typeof window.history.pushState == "function") {
                            window.history.pushState({}, "Hide", "'.$_SESSION['duongdan'].'");
                        }
                        alert("Sai mật khẩu hoặc tài khoản đã bị chặn");
                        location.reload();
                    </script>
                    ';
            }
        }else {
            echo'
                <script>    
                    if(typeof window.history.pushState == "function") {
                        window.history.pushState({}, "Hide", "'.$_SESSION['duongdan'].'");
                    }
                    alert("Tài khoản không có thật");
                    location.reload();
                </script>
                ';
        }
  }
}
function dangki(){
  include 'connection.php';
  echo '
  <dialog id="dangki" class="formdangnhap" >   
      <div style="display:flex;">
        <h2>Đăng kí  </h2>
        
        <button style="margin-left: auto;" onclick="closedangki()">Đóng</button>
      </div>
      <form action="?dangki" method="post">
                <div class="form-group">
                <label class="dndk">Tên đăng nhập :</label>
                <input type="text" class="form-control"  placeholder="Tài khoản" value="" name="user" required>
                <p id="taikhoan"></p>
                </div>
                <div class="form-group">
                <label class="dndk" >Mật khẩu:</label>
                <input type="password" class="form-control"  placeholder="Nhập pass" value="" name="pass" required>
                </div>
                <div class="form-group">
                <label class="dndk">Tên người dùng:</label>
                <input type="text" class="form-control"  placeholder="Tên người dùng" value="" name="name" required>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
        </form>
   
    
  </dialog>
  <script>

  var y = document.getElementById("dangki"); 
  
  function showdangki() { 
    y.show(); 
  } 
  
  function closedangki() { 
    y.close(); 
  } 
  </script> 
  ';
  if(isset($_GET['dangki'])){
    include 'connection.php';
    $tentk=$_POST['name'];
    $users=$_POST['user'];
    $mk=md5($_POST['pass']);   
        $user = "select * from thanh_vien where ma_thanh_vien='".$users."';";
        $result = mysqli_query($conn,$user);
        if(mysqli_num_rows($result)>0){
                echo '
                    <script> 
                    document.getElementById("taikhoan").innerHTML = "Tài khoản đã được đăng kí. Vui lòng đăng kí tài khoản khác!";
                    showdangki();
                    </script>
                    ';    
            }else {
              $dangki = " insert into thanh_vien values ('".$users."','".$mk."','".$tentk."','','',0,0)";
              $result = mysqli_query($conn,$dangki);
              $_SESSION['tai_khoan_tv']=$users;
              $_SESSION['mat_khau_tv']=$mk;
              $_SESSION['ten_tk']=$tentk;
                echo'
                    <script>    
                        if(typeof window.history.pushState == "function") {
                            window.history.pushState({}, "Hide", "'.$_SESSION['duongdan'].'");
                        }
                        alert("Đăng kí thành công!");
                        location.reload();
                    </script>
                    ';
            }
        }
}
function sualoai($masach){
  include 'connection.php';
  $result = mysqli_query($conn,"select ten_sach from sach where ma_sach='".$masach."'");
  $row= mysqli_fetch_array($result);
  $result1=mysqli_query($conn,"select tl.ma_loai,ten_loai from tag_sach ts join the_loai_sach tl on ts.ma_loai=tl.ma_loai where ma_sach='".$masach."';");
  $result2=mysqli_query($conn,"select * from the_loai_sach");
  echo '
  <dialog id="'.$masach.'" class="formdangnhap" >   
      <div style="display:flex;">
        <h3 style="color: darkviolet;">'.$row['ten_sach'].'  </h3>      
        <button style="margin-left: auto;" onclick="close'.$masach.'()">Đóng</button>
      </div>
      
        <p class="dep">Đã có: </p>
          <div class="row">';
      $loai=array("test");
      while($row1=mysqli_fetch_assoc($result1)){
          echo'
          
              <div class="ctsualoai col-md-3">
                  <p class="tenloai">'.$row1['ten_loai'].'</p>
                  <a href="?sua='.$row1['ma_loai'].'&&masach='.$masach.'" style="padding:0;" class="btn btn-secondary tenloai ">Xóa</a>
              </div>
          
          ';
          array_push($loai,$row1['ten_loai']);
      }
      echo'</div>
        <p class="dep"> Thêm mới: </p>
        <div class="row">
      ';
      while($row2=mysqli_fetch_array($result2)){
          $check=array_search($row2['ten_loai'],$loai);
          
          if(!empty($check)){
              continue;
          }else{
          echo '
          
              <div class="ctsualoai col-md-3">
                  <p class="tenloai">'.$row2['ten_loai'].'</p>
                  <a href="?them='.$row2['ma_loai'].'&&masach='.$masach.'" style="padding:0;" class="btn btn-success tenloai ">Thêm</a>
              </div>
          
          
          ';
        }
      }      
      echo'
      </div>
     
   
    
  </dialog>
  <script>

  var '.$masach.' = document.getElementById("'.$masach.'"); 
  
  function show'.$masach.'() { 
    '.$masach.'.show(); 
  } 
  
  function close'.$masach.'() { 
    '.$masach.'.close(); 
  } 
  </script> 
  ';

  if(isset($_GET['sua'])){
    $path=substr($_SERVER['REQUEST_URI'],strripos($_SERVER['REQUEST_URI'],"/")+1);
    $xoaget=substr($path,0, strpos($path,"?"));
    $result4=mysqli_query($conn,"select * from tag_sach where ma_sach='".$_GET['masach']."' and ma_loai='".$_GET['sua']."'");
    if(mysqli_num_rows($result4)){
    mysqli_query($conn,"delete from tag_sach where ma_sach='".$_GET['masach']."' and ma_loai='".$_GET['sua']."'");
    echo '<script>location.reload();</script>';
      }else{ 
        echo '
        <script> 
        if(typeof window.history.pushState == "function") {
          window.history.pushState({}, "Hide", "'.$xoaget.'");
        }
        show'.$_GET['masach'].'();  
        </script>
        ';  
      }  
  }
  if(isset($_GET['them'])){
    $path=substr($_SERVER['REQUEST_URI'],strripos($_SERVER['REQUEST_URI'],"/")+1);
    $xoaget=substr($path,0, strpos($path,"?"));
    $result4=mysqli_query($conn,"select * from tag_sach where ma_sach='".$_GET['masach']."' and ma_loai='".$_GET['them']."'");
    if(!mysqli_num_rows($result4)){
      mysqli_query($conn,"insert into tag_sach values('".$masach."','".$_GET['them']."')");
      echo '
        <script>location.reload();</script>
        ';
      }else{ 
        echo '<script> 
        if(typeof window.history.pushState == "function") {
          window.history.pushState({}, "Hide", "'.$xoaget.'");
        }
        show'.$_GET['masach'].'();  
        </script>
        ';   
      }
  }
}
function luotdoc($masach){
  include 'connection.php';
  $result=mysqli_query($conn,"select * from luot_doc where ma_sach='".$masach."'");
  $luotdoc=mysqli_num_rows($result);
  return $luotdoc;
}
function topngay($ngay){
  include 'connection.php ';
  $result=mysqli_query($conn,"select count(*)  ct,ten_sach from luot_doc ld join sach s on s.ma_sach=ld.ma_sach where ngay_doc='".$ngay."' group by s.ma_sach order by count(*)DESC limit 5;");
  if(mysqli_num_rows($result)>0){
    echo'
    <script >
    google.charts.load("current", {packages:["corechart"]});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ["Tên truyện", "Lượt đọc",{ role: "style" }] ';
          while($row=mysqli_fetch_array($result)){
            echo'
            ,["'.$row['ten_sach'].'",'.$row['ct'].',"#73AFF7"]
            ';
          }
          
        echo']);
  
        var view = new google.visualization.DataView(data);
        view.setColumns([0, 1,
                         { calc: "stringify",
                           sourceColumn: 1,
                           type: "string",
                           role: "annotation" },
                         2]);
  
        var options = {
          title: "Top truyện trong ngày '.$ngay.'",
          width: 600,
          height: 400,
          bar: {groupWidth: "95%"},
          legend: { position: "none" },
        };
        var chart = new google.visualization.ColumnChart(document.getElementById("columnchart"));
        chart.draw(view, options);
    }</script>
    ';


  }else{
    echo"Danh sách rỗng!";
  }
}
function topnam($ngay){
  include 'connection.php ';
  $result=mysqli_query($conn,"select count(*) ct,ten_sach from luot_doc ld join sach s on s.ma_sach=ld.ma_sach where year(ngay_doc)='".$ngay."' group by s.ma_sach order by count(*)DESC limit 5;");  
  echo' 
  <script >
  google.charts.load("current", {packages:["corechart"]});
    google.charts.setOnLoadCallback(drawo);
    function drawo() {
      var data = google.visualization.arrayToDataTable([
        ["Tên truyện", "Lượt đọc",{ role: "style" }] ';
        while($row=mysqli_fetch_array($result)){
          echo'
          ,["'.$row['ten_sach'].'",'.$row['ct'].',"#15FF7E"]
          ';
        }
        
      echo']);

      var view = new google.visualization.DataView(data);
      view.setColumns([0, 1,
                       { calc: "stringify",
                         sourceColumn: 1,
                         type: "string",
                         role: "annotation" },
                       2]);

      var options = {
        title: "Top truyện trong năm '.$ngay.'",
        width: 600,
        height: 400,
        bar: {groupWidth: "95%"},
        legend: { position: "none" },
      };
      var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values"));
      chart.draw(view, options);
  }</script>
  ';
}
function topthang($thang,$nam){
 
    include 'connection.php ';
    $result=mysqli_query($conn,"select count(*) ct,ten_sach from luot_doc ld join sach s on s.ma_sach=ld.ma_sach where year(ngay_doc)='".$nam."' and month(ngay_doc)='".$thang."' group by s.ma_sach order by count(*)DESC limit 5;");  
    echo'
    <script >
    google.charts.load("current", {packages:["corechart"]});
      google.charts.setOnLoadCallback(ae);
      function ae() {
        var data = google.visualization.arrayToDataTable([
          ["Tên truyện", "Lượt đọc",{ role: "style" }] ';
          while($row=mysqli_fetch_array($result)){
            echo'
            ,["'.$row['ten_sach'].'",'.$row['ct'].',"#FF15EF"]
            ';
          }
          
        echo']);
  
        var view = new google.visualization.DataView(data);
        view.setColumns([0, 1,
                         { calc: "stringify",
                           sourceColumn: 1,
                           type: "string",
                           role: "annotation" },
                         2]);
  
        var options = {
          title: "Top truyện trong tháng '.$thang.'",
          width: 600,
          height: 400,
          bar: {groupWidth: "95%"},
          legend: { position: "none" },
        };
        var chart = new google.visualization.ColumnChart(document.getElementById("xdthang"));
        chart.draw(view, options);
    }</script>
    ';


  
}
function suamota($masach){
 include 'connection.php';
 $result1=mysqli_query($conn,"select * from sach where ma_sach='".$masach."'");
 $row1=mysqli_fetch_array($result1);
    echo'
    <div>
      <dialog id="mota'.$masach.'" class="formmota" >
        <div style="display:flex">
          <h5>Bảng mô tả</h5>
          <button style="margin-left: auto;" onclick="close'.$masach.'mota()">Đóng</button>
        </div>
        <div>';
          $myfile = fopen("./truyen/".$row1['ten_sach']."/".$row1['mo_ta'], "r") or die("Unable to open file!");
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
          };
          echo'
        </div>
      <div>
        <form action="?id='.$masach.'"  method="POST"  enctype="multipart/form-data" required>
          <label style="color: #28a745">Thay đổi:</label>
          <input type="file" class="form-control-file border" name="mota" required> 
          <button type="submit">Sửa</button>
        </form>   
      </div></dialog>
    </div>
    <script>

    var mota'.$masach.' = document.getElementById("mota'.$masach.'"); 
    
    function show'.$masach.'mota() { 
      mota'.$masach.'.show(); 
    } 
    
    function close'.$masach.'mota() { 
      mota'.$masach.'.close(); 
    } 
    </script> 
      
      ';
      if(isset($_GET['id'])&&$_GET['id']==$masach){
        $path=substr($_SERVER['REQUEST_URI'],strripos($_SERVER['REQUEST_URI'],"/")+1);
        $xoaget=substr($path,0, strpos($path,"?"));
        $result=mysqli_query($conn,"select * from sach where  ma_sach ='".$_GET['id']."'");
        $row=mysqli_fetch_assoc($result);
        $filecu='./truyen/'.$row['ten_sach'].'/'.$row['mo_ta'];
        $filemoi='./truyen/'.$row['ten_sach'].'/'.$_FILES['mota']['name'];
        unlink($filecu);
        move_uploaded_file($_FILES['mota']['tmp_name'],$filemoi);
        $result1=mysqli_query($conn,"update sach set mo_ta='".$_FILES['mota']['name']."' where ma_sach='".$_GET['id']."'");
        echo '<script> 
        if(typeof window.history.pushState == "function") {
          window.history.pushState({}, "Hide", "'.$xoaget.'");
        }
        location.reload();</script>
        ';
    }
  
}
function bangdangnhap(){
  echo'<dialog id="myDialog" class="formdangnhap" >   
      <div style="display:flex;">
        <h2>Đăng nhập  </h2>
        
        <button style="margin-left: auto;" onclick="closeDialog()">Đóng</button>
      </div>
      <form action="?login" method="post">
          <div class="form-group">
            <label>User :</label>
            <input type="text" class="form-control"  placeholder="Tài khoản" value="" name="user">
          </div>
          <div class="form-group">
            <label >Password:</label>
            <input type="password" class="form-control"  placeholder="Nhập pass" value="" name="pass">
          </div>
          <button type="submit" class="btn btn-primary">Submit</button>
      </form>
      
  </dialog>';
}
function mkngay($ngay){
  include 'connection.php';
  $bangngay=mysqli_query($conn," Select count(*) soluot,ma_sach FROM gio_hang where date(ngay_mua)='".$ngay."' group by ma_sach order by count(*) desc limit 5; ");
  
  echo"<script>
  var ngaymk = document.getElementById('mkbdngay').getContext('2d');
  //Global Options
  Chart.defaults.global.defaultFontFamily = 'Lato';
  Chart.defaults.global.defaultFontSize = 20;
  Chart.defaults.global.defaultFontColor = '#777';

  var ngaybdmk = new Chart(ngaymk, {
    type:'bar', // bar, horizontalBar, pie, line, doughnut, radar, polarArea
    data:{
     labels:[";
          
     
              $i=0;$y=0;
              while($dsngay=mysqli_fetch_array($bangngay)){
                  if($i==0){
                      echo "'".$dsngay['ma_sach']."'";
                      $i=1;
                  }else{
                      echo ",'".$dsngay['ma_sach']."'";
                  }
              
              }
              


    echo"
      ],
      datasets:[{
        label:'Lượt đọc',
        data:[";
        $bangngay1=mysqli_query($conn," Select count(*) soluot,ma_sach FROM gio_hang where date(ngay_mua)='".$ngay."' group by ma_sach order by count(*) desc limit 5;    ");     
               while($dsngay1=mysqli_fetch_assoc($bangngay1)){
                   if($y==0){
                       echo $dsngay1['soluot'];
                       $y=1;
                   }else{
                       echo ",".$dsngay1['soluot'];
                   }
               }
              
      echo"       
        ],
        
        backgroundColor:'#f56b6b',
        borderWidth:2,
        borderColor:'#f50000a1',
        hoverBorderWidth:0,
        hoverBorderColor:'#f3c0c0'
      }]
    },
    options:{
      title:{
        display:true,
        text:'Lượt mở khóa theo ngày',
        fontSize:20
      },
      legend:{
        display:true,
        position:'right',
        labels:{
          fontColor:'#000000'
        }
      },
      layout:{
        padding:{
          left:0,
          right:0,
          bottom:0,
          top:0
        }
      },
      tooltips:{
        enabled:true
      }
    }
  });</script>";
  $mokhoa=mysqli_query($conn,"call maxmkngay('".$ngay."');");
  if(mysqli_num_rows($mokhoa)>0){
    $songay=mysqli_fetch_assoc($mokhoa);
   echo'
      <div> Mã sách có số lượt mở khóa ngày : '.$songay['ma_sach'].': '.$songay['tong'].' lượt </div>
    ';
    }
  else{echo'<div> Mã sách có số lượt mở khóa ngày '.$ngay.' : 0 lượt </div>';};
}
function mknam($nam){
  include 'connection.php';
  $bangngay=mysqli_query($conn," Select count(*) soluot,ma_sach FROM gio_hang where year(ngay_mua)='".$nam."' group by ma_sach order by count(*) desc limit 5;");
  echo"          
  <script>
  var nammk = document.getElementById('mknam').getContext('2d');
    //Global Options
    Chart.defaults.global.defaultFontFamily = 'Lato';
    Chart.defaults.global.defaultFontSize = 20;
    Chart.defaults.global.defaultFontColor = '#777';

    var nambdmk = new Chart(nammk, {
      type:'bar', // bar, horizontalBar, pie, line, doughnut, radar, polarArea
      data:{
       labels:[";
            
       
                $i=0;$y=0;
                while($dsngay=mysqli_fetch_array($bangngay)){
                    if($i==0){
                        echo "'".$dsngay['ma_sach']."'";
                        $i=1;
                    }else{
                        echo ",'".$dsngay['ma_sach']."'";
                    }
                
                }
                


      echo"
        ],
        datasets:[{
          label:'Lượt đọc',
          data:[";
          $bangngay1=mysqli_query($conn," Select count(*) soluot,ma_sach FROM gio_hang where year(ngay_mua)='".$nam."' group by ma_sach order by count(*) desc limit 5;    ");     
                 while($dsngay1=mysqli_fetch_assoc($bangngay1)){
                     if($y==0){
                         echo $dsngay1['soluot'];
                         $y=1;
                     }else{
                         echo ",".$dsngay1['soluot'];
                     }
                 }
                
        echo"       
          ],
          
          backgroundColor:'#f56b6b',
          borderWidth:2,
          borderColor:'#f50000a1',
          hoverBorderWidth:0,
          hoverBorderColor:'#f3c0c0'
        }]
      },
      options:{
        title:{
          display:true,
          text:'Lượt mở khóa năm ".date($nam)." ',
          fontSize:20
        },
        legend:{
          display:true,
          position:'right',
          labels:{
            fontColor:'#000000'
          }
        },
        layout:{
          padding:{
            left:0,
            right:0,
            bottom:0,
            top:0
          }
        },
        tooltips:{
          enabled:true
        }
      }
    });
    
  </script>";
}
function mkthang($thang,$nam){

  include 'connection.php';
  $bangngay=mysqli_query($conn," Select count(*) soluot,ma_sach FROM gio_hang where month(ngay_mua)=".$thang." and year(ngay_mua)=".$nam." group by ma_sach order by count(*) desc limit 5;");
  echo"          
  <script>
  var thang = document.getElementById('mkthang').getContext('2d');
    //Global Options
    Chart.defaults.global.defaultFontFamily = 'Lato';
    Chart.defaults.global.defaultFontSize = 20;
    Chart.defaults.global.defaultFontColor = '#777';

    var thangmk = new Chart(thang, {
      type:'bar', // bar, horizontalBar, pie, line, doughnut, radar, polarArea
      data:{
       labels:[";
            
       
                $i=0;$y=0;
                while($dsngay=mysqli_fetch_array($bangngay)){
                    if($i==0){
                        echo "'".$dsngay['ma_sach']."'";
                        $i=1;
                    }else{
                        echo ",'".$dsngay['ma_sach']."'";
                    }
                
                }
                


      echo"
        ],
        datasets:[{
          label:'Lượt đọc',
          data:[";
          $bangngay1=mysqli_query($conn,"SELECt count(*) soluot,ma_sach FROM gio_hang where month(ngay_mua)=".$thang." and year(ngay_mua)=".$nam." group by ma_sach order by count(*) desc limit 5;     ");     
                 while($dsngay1=mysqli_fetch_assoc($bangngay1)){
                     if($y==0){
                         echo $dsngay1['soluot'];
                         $y=1;
                     }else{
                         echo ",".$dsngay1['soluot'];
                     }
                 }
                
        echo"       
          ],
          
          backgroundColor:'#ee08f2',
          borderWidth:2,
          borderColor:'#ee08f2',
          hoverBorderWidth:0,
          hoverBorderColor:'#ee08f2'
        }]
      },
      options:{
        title:{
          display:true,
          text:'Lượt mở khóa theo tháng',
          fontSize:20
        },
        legend:{
          display:true,
          position:'right',
          labels:{
            fontColor:'#000000'
          }
        },
        layout:{
          padding:{
            left:0,
            right:0,
            bottom:0,
            top:0
          }
        },
        tooltips:{
          enabled:true
        }
      }
    });
    
  </script>";
  $mokhoa=mysqli_query($conn,"call maxmkthang(".$thang.",".$nam.");");
  if(mysqli_num_rows($mokhoa)>0){
    $songay=mysqli_fetch_assoc($mokhoa);
   echo'
      <div> Mã sách có số lượt mở khóa tháng : '.$songay['ma_sach'].': '.$songay['tong'].' lượt </div>
    ';
    }
  else{echo'<div> Mã sách có số lượt mở khóa tháng '.$thang.' : 0 lượt </div>';};
}
function mkbdngay($ngay){
  include 'connection.php';
  $mokhoa=mysqli_query($conn,"select count(*) songay from gio_hang where date(ngay_mua)='".$ngay."'");
  if(mysqli_num_rows($mokhoa)>0){
    $songay=mysqli_fetch_array($mokhoa);
    echo'
      <div> Tổng số lượt mở khóa trong ngày '.$ngay.' : '.$songay['songay'].' lượt </div>
    ';
  }else{echo'<div> Tổng số lượt mở khóa trong ngày '.$ngay.' : 0 lượt </div>';}
  $bangngay=mysqli_query($conn,"select count(date(ngay_mua)) soluot,date(ngay_mua) ngaymua FROM gio_hang WHERE date(ngay_mua)>(SELECT DATE_SUB('".$ngay."', INTERVAL 10 DAY)) and date(ngay_mua)<='".$ngay."'group by date(ngay_mua)");
  echo"          
  <script>
  var c = document.getElementById('my').getContext('2d');
    //Global Options
    Chart.defaults.global.defaultFontFamily = 'Lato';
    Chart.defaults.global.defaultFontSize = 20;
    Chart.defaults.global.defaultFontColor = '#777';

    var my = new Chart(c, {
      type:'line', // bar, horizontalBar, pie, line, doughnut, radar, polarArea
      data:{
       labels:[";
            
       
                $i=0;$y=0;
                while($dsngay=mysqli_fetch_array($bangngay)){
                    if($i==0){
                        echo "'".$dsngay['ngaymua']."'";
                        $i=1;
                    }else{
                        echo ",'".$dsngay['ngaymua']."'";
                    }
                
                }
                


      echo"
        ],
        datasets:[{
          label:'Lượt đọc',
          data:[";
          $bangngay1=mysqli_query($conn,"select count(date(ngay_mua)) soluot,date(ngay_mua) ngaymua FROM gio_hang WHERE date(ngay_mua)>(SELECT DATE_SUB('".$ngay."', INTERVAL 10 DAY)) and date(ngay_mua)<='".$ngay."'group by date(ngay_mua)");     
                 while($dsngay1=mysqli_fetch_assoc($bangngay1)){
                     if($y==0){
                         echo $dsngay1['soluot'];
                         $y=1;
                     }else{
                         echo ",".$dsngay1['soluot'];
                     }
                 }
                
        echo"       
          ],
          
          backgroundColor:'#c6f0b894',
          borderWidth:3,
          borderColor:'#6cfa63',
          hoverBorderWidth:3,
          hoverBorderColor:'#6cfa63'
        }]
      },
      options:{
        title:{
          display:true,
          text:'Lượt mở khóa theo ngày',
          fontSize:20
        },
        legend:{
          display:true,
          position:'right',
          labels:{
            fontColor:'#000000'
          }
        },
        layout:{
          padding:{
            left:0,
            right:0,
            bottom:0,
            top:0
          }
        },
        tooltips:{
          enabled:true
        }
      }
    });
    
  </script>";
}
function mkbdthang($nam){
  include 'connection.php';
  $bangngay=mysqli_query($conn,"  select count(*) tong, month(ngay_mua) ngaymua from gio_hang where year(ngay_mua)=".$nam." group by month(ngay_mua); ");
  echo"          
  <script>
  var bdthang = document.getElementById('mkbdthang').getContext('2d');
    //Global Options
    Chart.defaults.global.defaultFontFamily = 'Lato';
    Chart.defaults.global.defaultFontSize = 20;
    Chart.defaults.global.defaultFontColor = '#777';

    var mkbdthang = new Chart(bdthang, {
      type:'line', // bar, horizontalBar, pie, line, doughnut, radar, polarArea
      data:{
        labels:[";
            
        
                $i=0;$y=0;
                while($dsngay=mysqli_fetch_array($bangngay)){
                    if($i==0){
                        echo "'tháng ".$dsngay['ngaymua']."'";
                        $i=1;
                    }else{
                        echo ",'tháng ".$dsngay['ngaymua']."'";
                    }
                
                }
                


      echo"
        ],
        datasets:[{
          label:'Lượt đọc',
          data:[";
          $bangngay1=mysqli_query($conn,"select count(*) soluot, month(ngay_mua) ngaymua from gio_hang where year(ngay_mua)=".$nam." group by month(ngay_mua);");     
                  while($dsngay1=mysqli_fetch_assoc($bangngay1)){
                      if($y==0){
                          echo $dsngay1['soluot'];
                          $y=1;
                      }else{
                          echo ",".$dsngay1['soluot'];
                      }
                  }
                
        echo"       
          ],
          
          backgroundColor:'#ee9cf078',
          borderWidth:3,
          borderColor:'#ee08f2',
          hoverBorderWidth:3,
          hoverBorderColor:'#ee9cf078'
        }]
      },
      options:{
        title:{
          display:true,
          text:'Lượt mở khóa theo tháng',
          fontSize:20
        },
        legend:{
          display:true,
          position:'right',
          labels:{
            fontColor:'#000000'
          }
        },
        layout:{
          padding:{
            left:0,
            right:0,
            bottom:0,
            top:0
          }
        },
        tooltips:{
          enabled:true
        }
      }
    });
    
  </script>";
}
function mkbdnam($nam){
  include 'connection.php';
  $mokhoa=mysqli_query($conn,"select count(*) songay from gio_hang where year(ngay_mua)=year('".$nam."')");
  if(mysqli_num_rows($mokhoa)>0){
    $songay=mysqli_fetch_array($mokhoa);
    echo'
      <div> Tổng số lượt mở khóa trong năm '.$nam.' : '.$songay['songay'].' lượt </div>
    ';
  }else{echo'<div> Tổng số lượt mở khóa trong năm '.$nam.' : 0 lượt </div>';}
  $bangngay=mysqli_query($conn,"select count(*) soluot,year(ngay_mua) ngaymua FROM gio_hang WHERE year(ngay_mua)>year((SELECT DATE_SUB('".$nam."', INTERVAL 10 year))) and year(ngay_mua)<=year('".$nam."') group by year(ngay_mua);");
  echo"          
  <script>
  var mkbdnam = document.getElementById('mkbdnam').getContext('2d');
    //Global Options
    Chart.defaults.global.defaultFontFamily = 'Lato';
    Chart.defaults.global.defaultFontSize = 20;
    Chart.defaults.global.defaultFontColor = '#777';

    var bdmknam = new Chart(mkbdnam, {
      type:'line', // bar, horizontalBar, pie, line, doughnut, radar, polarArea
      data:{
       labels:[";
            
       
                $i=0;$y=0;
                while($dsngay=mysqli_fetch_array($bangngay)){
                    if($i==0){
                        echo "'".$dsngay['ngaymua']."'";
                        $i=1;
                    }else{
                        echo ",'".$dsngay['ngaymua']."'";
                    }
                
                }
                


      echo"
        ],
        datasets:[{
          label:'Lượt đọc',
          data:[";
          $bangngay1=mysqli_query($conn,"select count(*) soluot,year(ngay_mua) ngaymua FROM gio_hang WHERE year(ngay_mua)>year((SELECT DATE_SUB('".$nam."', INTERVAL 10 year))) and year(ngay_mua)<=year('".$nam."') group by year(ngay_mua);");     
                 while($dsngay1=mysqli_fetch_assoc($bangngay1)){
                     if($y==0){
                         echo $dsngay1['soluot'];
                         $y=1;
                     }else{
                         echo ",".$dsngay1['soluot'];
                     }
                 }
                
        echo"       
          ],
          
          backgroundColor:'#ff000029',
          borderWidth:3,
          borderColor:'#f50000a1',
          hoverBorderWidth:3,
          hoverBorderColor:'#f50000a1'
        }]
      },
      options:{
        title:{
          display:true,
          text:'Lượt mở khóa năm',
          fontSize:20
        },
        legend:{
          display:true,
          position:'right',
          labels:{
            fontColor:'#000000'
          }
        },
        layout:{
          padding:{
            left:0,
            right:0,
            bottom:0,
            top:0
          }
        },
        tooltips:{
          enabled:true
        }
      }
    });
    
  </script>";
}
function tkthe($ngay){
  include 'connection.php';
  $kqhtngay=mysqli_query($conn,"select count(ngay_nap) sl,date(ngay_nap) ngaynap from the_nap where date(ngay_nap)>
                            (SELECT DATE_SUB('".$ngay."', INTERVAL 10 DAY)) and date(ngay_nap)<='".$ngay."' and trang_thai_the='Hoàn thành' group by date(ngay_nap);");
  $kqtlngay=mysqli_query($conn,"select count(ngay_nap) sl,date(ngay_nap) ngaynap from the_nap where date(ngay_nap)>
  (SELECT DATE_SUB('".$ngay."', INTERVAL 10 DAY)) and date(ngay_nap)<='".$ngay."' and trang_thai_the='Thẻ lỗi' group by date(ngay_nap);");
  echo"
  <script>
  google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(draw);

      function draw() {
        var data = google.visualization.arrayToDataTable([
          ['Ngày', 'Hoàn thành', 'Thẻ lỗi']";
          if(mysqli_num_rows($kqhtngay)>0){
            $kqht=mysqli_fetch_array($kqhtngay);
          }else{$kqht['ngaynap']=$ngay;$kqht['sl']=0;}
          if(mysqli_num_rows($kqtlngay)>0){
            $kqtl=mysqli_fetch_array($kqtlngay);
          }else{$kqtl['ngaynap']=$ngay;$kqtl['sl']=0;}
          $check=true;
          while( $check){
            if ( isset($kqtl) && isset($kqht)){
              if(strtotime($kqtl['ngaynap'])==strtotime($kqht['ngaynap'])){
                echo"
                        ,['".$kqtl['ngaynap']."',  ".$kqht['sl'].",     ".$kqtl['sl']."]
                ";
                  $kqtl=mysqli_fetch_array($kqtlngay);
                  $kqht=mysqli_fetch_array($kqhtngay);
              }
              else{
                  if(strtotime($kqtl['ngaynap'])>strtotime($kqht['ngaynap'])){
                    echo"
                            ,['".$kqht['ngaynap']."',  ".$kqht['sl'].", 0]
                    ";
                      $kqht=mysqli_fetch_array($kqhtngay);
                  }else{
                    echo"
                              ,['".$kqht['ngaynap']."', 0,  ".$kqtl['sl']."]
                    ";
                      $kqtl=mysqli_fetch_array($kqtlngay);
                  }
              }
            }
            else{$check=false;}
          }
  echo"]);
        var options = {
          title: 'Số lượng thẻ nạp',
          hAxis: {title: 'Ngày',  titleTextStyle: {color: '#333'}},
          vAxis: {minValue: 0}
        };

        var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }</script>
  ";
}
function test(){
  include 'connection.php ';
  $result=mysqli_query($conn,"select count(*) ct,ten_sach from luot_doc ld join sach s on s.ma_sach=ld.ma_sach where year(ngay_doc)='".$ngay."' group by s.ma_sach order by count(*)DESC limit 5;");  
  
  echo' <script >
  google.charts.load("current", {packages:["corechart"]});
    google.charts.setOnLoadCallback(drawChart);
    function drawChart() {
      var data = google.visualization.arrayToDataTable([
        ["Element", "Density",{ role: "style" }] ';
        while($row=mysqli_fetch_array($result)){
          echo'
          ,["'.$row['ten_sach'].'",'.$row['ct'].',"red"]
          ';
        }
        
      echo']);

      var view = new google.visualization.DataView(data);
      view.setColumns([0, 1,
                       { calc: "stringify",
                         sourceColumn: 1,
                         type: "string",
                         role: "annotation" },
                       2]);

      var options = {
        title: "Density of Precious Metals, in g/cm^3",
        width: 600,
        height: 400,
        bar: {groupWidth: "95%"},
        legend: { position: "none" },
      };
      var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values"));
      chart.draw(view, options);
  }</script>
  ';
}
function namsinh(){
  include 'connection.php';
    $result = mysqli_query($conn,'select * from tag_sach ts join sach s on s.ma_sach=ts.ma_sach where ma_loai="TL6" limit 4;');
    if(mysqli_num_rows($result) > 0 ){
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
    };
}
function tienhiep(){
  include 'connection.php';
    $result = mysqli_query($conn,'select * from tag_sach ts join sach s on s.ma_sach=ts.ma_sach where ma_loai="TL3" limit 4;');
    if(mysqli_num_rows($result) > 0 ){
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
    };
}
function trinhtham(){
  include 'connection.php';
    $result = mysqli_query($conn,'select * from tag_sach ts join sach s on s.ma_sach=ts.ma_sach where ma_loai="TL4" limit 4;');
    if(mysqli_num_rows($result) > 0 ){
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
    };
}
?>
