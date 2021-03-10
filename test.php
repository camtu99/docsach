<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<canvas id="thang"style="background-color: white;"></canvas>
    <script>
        
  var thang1 = document.getElementById('thang').getContext('2d');
    //Global Options
    Chart.defaults.global.defaultFontFamily = 'Lato';
    Chart.defaults.global.defaultFontSize = 20;
    Chart.defaults.global.defaultFontColor = '#777';

    var thangmk = new Chart(thang1, {
      type:'bar', // bar, horizontalBar, pie, line, doughnut, radar, polarArea
      data:{
       labels:['MS1','MS2','MS3','MS4','MS5'
        ],
        datasets:[{
          label:'Lượt đọc',
          data:[10,4,14,95,11       
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
    });
    
  
    </script>
</body>
</html>