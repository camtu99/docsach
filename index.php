<?php 
include 'function.php';
   /*  bảng quảng cáo */
   // ads();
      /* thanh menu */
     menu();
  ?>
   <!-- thanh truyện đề cử -->
    <div class="chuongmoi">
      <div class="container">
        <div class="row" style="width:100%;">
          <?php search();?>
          <div class="col-lg-9">
            <div ><h3> Truyện mới cập nhật </h3></div>
            <div class="row">
              <?php chuongMoi(); ?>
            </div>
            <div ><p style="width: 150px;margin-left: auto;margin-bottom: 0;" ><a href=""> &lt;&lt;	Xem thêm &gt;&gt;</a></p></div>
            <hr style="margin: 0;">
            <div><h3>Nam sinh</h3></div>
            <div class="new_chap">
              <?php namsinh(); ?>
            </div>
            <div ><p style="width: 150px;margin-left: auto;margin-bottom: 0;" ><a href=""> &lt;&lt;	Xem thêm &gt;&gt;</a></p></div>
            <hr style="margin: 0;">
            <div><h3>Tiên hiệp</h3></div>
            <div class="new_chap">
              <?php tienhiep(); ?>
            </div>
            <div ><p style="width: 150px;margin-left: auto;margin-bottom: 0;" ><a href=""> &lt;&lt;	Xem thêm &gt;&gt;</a></p></div>
            <hr style="margin: 0;">
            <div><h3>Trinh thám</h3></div>
            <div class="new_chap">
              <?php trinhtham(); ?>
            </div>
            <div ><p style="width: 150px;margin-left: auto;margin-bottom: 0;" ><a href=""> &lt;&lt;	Xem thêm &gt;&gt;</a></p></div>
            <hr style="margin: 0;">

          </div>
          <div class="col-lg-3">
            <div class="top_view">
              <h4>Top truyện xem nhiều</h4>
              <?php top_view(); ?>
            </div>
          </div>
        </div>  
      </div>
    </div>
 <?php bottom();?>