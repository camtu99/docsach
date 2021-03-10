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
       
            <div class="row" style="margin: 0;">
        
                    <div class="col-lg-6">
                        <div >        
                            <form action="?ngay" method="Post">
                                <label for="birthday">Chọn:</label>
                                <input type="date" id="birthday" name="birthday">
                                <input type="submit">
                                
                            </form>     
                        </div>
                       
                        <div class="topngay">
                        <div id="columnchart"></div>
                            <?php
                            if(isset($_GET['ngay'])){
                                topngay( $_POST['birthday']);   
                            }
                            else{
                                topngay(date('Y-m-d'));
                            }?>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div>        
                            <form action="?nam" method="Post">
                                <label>Chọn:</label>
                                <select name="nam" id="nam">
                                    <?php
                                    $result =mysqli_query($conn,"select year(ngay_doc) nam from luot_doc group by year(ngay_doc);");
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
                        <div class="topnam">
                        <div id="columnchart_values"></div>
                            <?php
                            if(isset($_GET['nam'])){
                                topnam( $_POST['nam']);                                  
                            }
                            else{
                                topnam(date('Y'));
                                
                            }
                            ?>
                        </div>
                    </div>
            
            </div>
            <div class="topthang">
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
                            $result =mysqli_query($conn,"select year(ngay_doc) nam from luot_doc group by year(ngay_doc);");
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
                <div class="chithang"> 
                    <div id="xdthang"></div>
                    <?php
                            if(isset($_GET['thang'])){
                                topthang( $_POST['thang'],$_POST['nam']);                                  
                            }
                            else{
                                topthang(date('m'),date('Y'));      
                            }
                            ?>       
                </div>
            </div>
        </div>
    </div>       
</div>
</body>
</html>
