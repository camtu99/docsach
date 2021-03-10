<?php 
include 'function.php';

?>
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
  <body>
      
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.min.js"></script>
    <canvas id="myChart1" height="300" width="500"></canvas>
    <canvas id="my" width="400" height="400"></canvas>
    $result=mysqli_query($conn,"select count(*) ct,ma_sach from luot_doc where year(ngay_doc)='".$ngay."' group by ma_sach order by count(*)DESC;");  
  echo"          
<script>
var c = document.getElementById('my').getContext('2d');
    //Global Options
    Chart.defaults.global.defaultFontFamily = 'Lato';
    Chart.defaults.global.defaultFontSize = 20;
    Chart.defaults.global.defaultFontColor = '#777';

    var my = new Chart(c, {
      type:'bar', // bar, horizontalBar, pie, line, doughnut, radar, polarArea
      data:{
       labels:[";
            
       
                $i=0;$y=0;
                while($topngay=mysqli_fetch_assoc($result)){
                    if($i==0){
                        echo "'".$topngay['ma_sach']."'";
                        $i=1;
                    }else{
                        echo ",'".$topngay['ma_sach']."'";
                    }
                
                }
                


      echo"
        ],
        datasets:[{
          label:'Lượt đọc',
          data:[";       
            $ngay1=mysqli_query($conn,"select count(*) ct,ma_sach from luot_doc where year(ngay_doc)='".$ngay."' group by ma_sach order by count(*)DESC;");  
                 while($luotdoc1=mysqli_fetch_assoc($ngay1)){
                     if($y==0){
                         echo $luotdoc1['ct'];
                         $y=1;
                     }else{
                         echo ",".$luotdoc1['ct'];
                     }
                 }
                
        echo"       
          ],
          
          backgroundColor:[";
          $ngay2=mysqli_query($conn,"select count(*) ct,ma_sach from luot_doc where year(ngay_doc)='".$ngay."' group by ma_sach order by count(*)DESC;");
          while($luotdoc2=mysqli_fetch_assoc($ngay2)){
            echo"'rgba(70, 190, 132, 1)',";
        }
           
          echo"],
          borderWidth:0,
          borderColor:'#7977',
          hoverBorderWidth:2,
          hoverBorderColor:'#0080'
        }]
      },
      options:{
        title:{
          display:true,
          text:'Top Truyện đọc nhiều trong ngày ".$ngay."',
          fontSize:20
        },
        legend:{
          display:true,
          position:'right',
          labels:{
            fontColor:'#22ef4'
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
    
</script>
</div>
</body>
</html>