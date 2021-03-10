<?php
include 'function.php';
if(!isset($_SESSION["tai_khoan"]) || $_SESSION["tai_khoan"]!="admin"|| !isset($_SESSION["mat_khau"]) || $_SESSION["mat_khau"]!=$_SESSION['pass'])
header("Location: login.php");
topadmin();
?>
<div class="container-fluid" >
    <div class="row" style="display: flex;">
        <?php menuadmin(); ?>
        <div class="col-lg-10">
            <div>
                <div>
                    <form action="?ngaymo" method="post">
                        <label for="">Ngày: </label>
                        <input type="date" name="ngay">
                        <button type="submit">Chọn</button>
                    </form>
                </div>
            </div>
            <div class="row" style="display: flex;">
                <div class="col-lg-6">
                    <div>
                    <canvas id="my"style="background-color: white;"></canvas>
                        <?php
                            if(isset($_GET['ngaymo'])){
                                mkbdngay($_POST['ngay']);
                            }else{
                                mkbdngay(date('Y-m-d'));
                            }
                        ?>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div>
                    <canvas id="mkbdngay"style="background-color: white;"></canvas>
                        <?php
                            if(isset($_GET['ngaymo'])){
                                mkngay($_POST['ngay']);
                            }else{
                                mkngay(date('Y-m-d'));
                            }
                        ?>
                    </div>
                </div>
            </div>
            <div>
                <form action="?thang" method="Post">
                    <label>Chọn</label>
                    <select name="thang" id="thang">
                        <?php
                            for($i=1;$i<=12;$i++){
                                echo'
                                    <option value="'.$i.'">Tháng '.$i.'</option>
                                ';
                            }
                        ?>   
                    </select>
                    <select name="nam" id="nam">
                        <?php
                        $result =mysqli_query($conn,"select year(ngay_mua) nam from gio_hang group by year(ngay_mua);");
                        while($row=mysqli_fetch_array($result)){
                            echo'
                                <option value="'.$row['nam'].'">'.$row['nam'].'</option>
                            ';
                        }
                        ?>
                    </select>
                    <input type="submit"> 
                </form>  
            </div>
            <div class="row" style="display:flex;">
                <div class="col-lg-6">
                        <div>
                            <canvas id="mkbdthang"style="background-color: white;"></canvas>
                            <?php
                                if(isset($_GET['thang'])){
                                    mkbdthang($_POST['nam']);
                                }else{
                                    mkbdthang(date('Y'));
                                }
                            ?>
                        </div>
                    </div>
                <div class="col-lg-6">
                    <div>
                        <canvas id="mkthang"style="background-color: white;"></canvas>
                        <?php
                            if(isset($_GET['thang'])){
                                mkthang($_POST['thang'],$_POST['nam']);
                            }else{
                                mkthang(date('m'),date('Y'));
                            }
                        ?>
                    </div>
                </div>
            </div>
            <div>
                <form action="?nam" method="Post">
                    <label>Chọn:</label>
                    <select name="nam" id="nam">
                        <?php
                        $result =mysqli_query($conn,"select year(ngay_mua) nam from gio_hang group by year(ngay_mua);");
                        while($row=mysqli_fetch_array($result)){
                            echo'
                                <option value="'.$row['nam'].'">'.$row['nam'].'</option>
                            ';
                        }
                        ?>
                    </select>
                    <button type="submit">Chọn</button>   
                </form>
            </div>
            <div class="row" style="display:flex;">
                <div class="col-lg-6">
                    <div>
                    <canvas id="mkbdnam"style="background-color: white;"></canvas>
                        <?php
                            if(isset($_GET['nam'])){
                                $nam=$_POST['nam']."-01-01";
                                mkbdnam($nam);
                            }else{
                                mkbdnam(date('Y-m-d'));
                            }
                        ?>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div>
                    <canvas id="mknam"style="background-color: white;"></canvas>
                        <?php
                            if(isset($_GET['nam'])){
                                mknam($_POST['nam']);
                            }else{
                                mknam(date('Y'));
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>