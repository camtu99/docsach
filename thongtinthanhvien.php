<?php
include 'function.php';
menu();
$thongtinthanhvien=mysqli_query($conn,"select * from thanh_vien where ma_thanh_vien='".$_SESSION['tai_khoan_tv']."'");
$thongtin=mysqli_fetch_array($thongtinthanhvien);

?>
<div class="container">
    <hr>
    <div>
        <dialog class="formnapthe" id="napthe">
            <div class="row">
                <div class="col-md-12">
                    <div>
                        <button style="float: right;" onclick="closenapthe()">x</button>
                        <h5>Nạp thẻ vào tài khoản</h5>
                        
                    </div>
                    <form action="xulithenap.php" method="POST">
                        <div class="luachon col-md-12"> 
                            <div class="col-md-8 luachonthe">       
                                <div class="col-md-4 ">
                                    <label ><input checked  type="radio" name="loaithe" id="viettel" value="viettel"><img class="anh" width="95px" height="75px"  src="Viettel.png" alt="" ></label>
                                </div> 
                                <div class="col-md-4 ">
                                <label ><input  type="radio" name="loaithe" id="mobi" value="mobi" reg><img  class="anh" width="95px"height="75px"  src="mobi.jpg" alt=""></label>
                                </div>
                                <div class="col-md-4 ">
                                    <label><input type="radio" name="loaithe" id="vina"value="vina"><img class="anh" width="95px"height="75px"  src="vina.png" alt=""></label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <h6 style="background-color: #9efafb;">Chú ý: Chọn sai mệnh giá,thẻ sẽ bị hủy.</h6>
                                <h6 style="    background-color: gold;">Quá 5 phút không hiện xu vui lòng liên hệ <a href="">tại đây</a>.</h6>
                            </div>

                        </div>
                        <div class="col-md-12" style="display:flex;flex-wrap:nowrap">
                            <div class="col-md-8" style="margin-top: 30px;">
                                <div class="form-group">
                                    <label class="dndk col-md-4">Seri <span style="color: red;">(*)</span> :</label>
                                    <input type="text" class="form-control col-md-8"  placeholder="Nhập seri" value="" name="seri" required>
                                </div>
                                <div class="form-group">
                                    <label class="dndk col-md-4" >Mã thẻ <span style="color: red;">(*)</span>:</label>
                                    <input type="text" class="form-control col-md-8"  placeholder="Nhập mã thẻ" value="" name="mathe" required>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4">Mệnh giá :</label>
                                    <select class="form-control col-md-8 col-sm-8" name="vnd">
                                        <option value="10000">10.000 VND</option>
                                        <option value="20000">20.000 VND</option>
                                        <option value="50000">50.000 VND</option>
                                        <option value="100000">100.000 VND</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <h5>Quy đổi xu:</h5>
                                <p>10.000 VND = <span>20 xu</span></p>
                                <p>20.000 VND = <span>45 xu</span></p>
                                <p>50.000 VND = <span>120 xu</span></p>
                                <p>100.000 VND = <span>250 xu</span></p>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </dialog>
        <div class="nap btn">
            <a type="button" onclick="shownapthe();">Nạp thẻ</a>
        </div>
        <div>
            <h4>Thông tin cá nhân</h4>
            <div class="user-profile">
                <div class="row">
                    <div class="col-md-12 khungthongtin">
                        <div class="row">
                            <div class="col-md-6">
                                <form id="profile" class="form-horizontal">
                                    <div class="profile">
                                        <div class="form-group">
                                            <label class="col-sm-4 control-label">Họ và tên</label>
                                            <div class="col-sm-8">
                                            <span class="form-control input-sm"><strong class="text-danger"><?php echo $thongtin['ten_thanh_vien'] ?></strong></span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-4 control-label">Số dư hiện tại</label>
                                            <div class="col-sm-8">
                                            <span class="form-control input-sm"><?php echo $thongtin['so_tien'] ?></span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-4 control-label" >Số ĐT <a href="" data-toggle="tooltip" title="Dùng để hỗ trợ khi gặp sự cố"><i class="fa fa-question-circle"></i></a></label>
                                            <div class="col-sm-8">
                                                <div class="input-group input-group-sm">
                                                    <input class="form-control" type="text"  name="phone" value="<?php echo $thongtin['sdt'] ?>" placeholder="Số điện thoại">
                                                    <span class="input-group-btn">
                                                    <a href="" class="btn btn-primary" data-toggle="tooltip" title="Lưu">
                                                        <i class="fa fa-save"></i>
                                                    </a>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-6">
                                <form id="profile" class="form-horizontal">
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label" for="thanh_vien_id">Tài khoản</label>
                                        <div class="col-sm-8">
                                            <span class="form-control input-sm"><strong class="text-danger"><?php echo $thongtin['ma_thanh_vien'] ?></strong></span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label" >Email <a href="" data-toggle="tooltip" title="Dùng để đăng nhập bằng tài khoản"><i class="fa fa-question-circle"></i></a></label>
                                        <div class="col-sm-8">
                                            <div class="input-group input-group-sm">
                                                <input class="form-control" type="text"  name="email" value="<?php echo $thongtin['email'] ?>" placeholder="Email">
                                                <span class="input-group-btn">
                                                    <a href="" class="btn btn-primary" data-toggle="tooltip" title="Lưu" id="update-email">
                                                        <i class="fa fa-save"></i>
                                                    </a>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label" for="password">Mật khẩu <a href="" data-toggle="tooltip" title="Dùng để đăng nhập bằng tài khoản"><i class="fa fa-question-circle"></i></a></label>
                                        <div class="col-sm-8">
                                            <div class="input-group input-group-sm">
                                                <input class="form-control" type="text" id="password" name="password" value="" placeholder="Mật khẩu">
                                                <span class="input-group-btn">
                                                    <a href="" class="btn btn-primary" data-toggle="tooltip" title="Lưu" >
                                                        <i class="fa fa-save"></i>
                                                    </a>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="input-group input-group-sm">
                                    <span class="input-group-addon">Tin nhắn từ admin</span>
                                        <input type="text" name="" value="" class="form-control" readonly />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <div>
            <div class="row">
                <div class="col-md-12">
                    <ul class="nav nav-tabs">
                        <li style="margin-left: 10px;margin-right:10px"><a href="#mo-khoa" data-toggle="tab">Lịch sử mở khóa</a></li>
                        <li style="margin-left: 10px;margin-right:10px"><a href="#nap-the" data-toggle="tab">Lịch sử nạp thẻ</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="mo-khoa">
                            <div class="">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <td class="text-left">STT</td>
                                            <td class="text-left">Tên sách</td>
                                            <td class="text-left">Mở khóa lúc</td>
                                            <td class="text-left">Giá</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $mokhoa=mysqli_query($conn,"select * from gio_hang gh join sach s on gh.ma_sach=s.ma_sach where ma_thanh_vien='".$_SESSION['tai_khoan_tv']."'");
                                            if(mysqli_num_rows($mokhoa)>0){
                                                $stt=1;
                                                while($ketqua=mysqli_fetch_array($mokhoa)){
                                                    echo'
                                                    <tr>
                                                        <td class="text-left">'.$stt.'</td>
                                                        <td class="text-left">'.$ketqua['ten_sach'].'</td>
                                                        <td class="text-left">'.$ketqua['ngay_mua'].'</td>
                                                        <td class="text-left">'.$ketqua['gia_mo_khoa'].' <i class="fas fa-coins    "></td>
                                                    </tr>                                                   
                                                    ';
                                                    $stt=$stt+1;
                                                }
                                            }else{
                                                echo '
                                                <tr>
                                                    <td colspan="4" class="text-left">Chưa có dữ liệu.</td>
                                                </tr>
                                                ';
                                            };
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane" id="nap-the">
                            <div class="">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <td class="text-left">STT</td>
                                            <td class="text-left">Mệnh giá</td>
                                            <td class="text-left">Seri</td>
                                            <td class="text-left">Ngày nạp</td>
                                            <td class="text-left">Trạng thái</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $thenap=mysqli_query($conn,"select * from the_nap where ma_thanh_vien='".$_SESSION['tai_khoan_tv']."' order by ngay_nap desc");
                                            if(mysqli_num_rows($thenap)>0){
                                                $sttnap=1;
                                                while($ketquanap=mysqli_fetch_array($thenap)){
                                                    echo'
                                                    <tr>
                                                        <td class="text-left">'.$sttnap.'</td>
                                                        <td class="text-left">'.$ketquanap['menh_gia'].'</td>
                                                        <td class="text-left">'.$ketquanap['seri_the'].'</td>
                                                        <td class="text-left">'.$ketquanap['ngay_nap'].'</td>
                                                        <td class="text-left">'.$ketquanap['trang_thai_the'].'</td>
                                                    </tr>                                                   
                                                    ';
                                                    $sttnap=$sttnap+1;
                                                }
                                            }else{
                                                echo '
                                                <tr>
                                                    <td colspan="5" class="text-left">Chưa có dữ liệu.</td>
                                                </tr>
                                                ';
                                            }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-6">
        <h3 class="title">Hướng dẫn khắc phục các lỗi thường gặp</h3>
        <p>1. Tài khoản đăng nhập sai mật khẩu<br>
        2. Không thể mở khóa truyện<br>
        3. Tài khoản bị đăng nhập ở nơi khác<br>
        4. Không hiển thị truyện<br>
        5. Tài khoản đã bị khóa<br>
        6. Hướng dẫn kích hoạt tài khoản<br>
        7. Các vấn đề khác
        </div>
    <div class="col-md-6">
    </div>
  </div>
</div>
<?php bottomadmin();?>