function myFunction(machuong,noidung,tenchuong) {
  document.getElementById("tenfile").innerHTML=noidung;
  document.getElementById("tenchuong").innerHTML=tenchuong;
  document.getElementById("tenfile1").innerHTML="Nội dung: ";
  document.getElementById("tenchuong1").innerHTML="Tên chương: ";
  document.getElementById("sua").innerHTML="Sửa thành: ";
  document.getElementById("sua1").innerHTML="Sửa thành: ";
  document.getElementById("sttchen").style.display = 'none';
  document.getElementById("sua").style.display = 'block';
  document.getElementById("sua1").style.display = 'block';
  document.getElementById("tenfile").style.display = 'block';
  document.getElementById("tenchuong").style.display = 'block';
  document.getElementById("stt").style.display = 'none';
  document.getElementById("chinhsuachuong").action="?sua="+machuong;
  document.getElementById("suatenchuong").value=tenchuong;
  var x = document.getElementById("myDialog");
  x.open = true;
}
function close_chuong(){
  var x = document.getElementById("myDialog");
  x.open = false;
}function close_suachuong(){
  var x = document.getElementById("sua");
  x.open = false;
}
function themchuong(stt) {
  document.getElementById("sua").style.display = 'none';
  document.getElementById("sua1").style.display = 'none';
  document.getElementById("tenfile").style.display = 'none';
  document.getElementById("tenchuong").style.display = 'none';
  document.getElementById("stt").innerHTML="Chèn vào vị trí:";
  document.getElementById("sttchen").value = stt;
  document.getElementById("sttchen").style.display = 'block';
  document.getElementById("stt").style.display = 'block';
  document.getElementById("tenfile1").innerHTML="Nội dung:";
  document.getElementById("tenchuong1").innerHTML="Tên chương";
  document.getElementById("chinhsuachuong").action="?them";
  var x = document.getElementById("myDialog");
  x.open = true;
}
function suachuong(stt) {
  document.getElementById("sua").style.display = 'none';
  document.getElementById("sua1").style.display = 'none';
  document.getElementById("tenfile").style.display = 'none';
  document.getElementById("tenchuong").style.display = 'none';
  document.getElementById("sttchen").style.display = 'block';
  document.getElementById("stt").style.display = 'block';
  document.getElementById("tenfile1").innerHTML="Nội dung:";
  document.getElementById("tenchuong1").innerHTML="Tên chương";
  document.getElementById("chinhsuachuong").action="?them";
  var x = document.getElementById("myDialog");
  x.open = true;
}
var y = document.getElementById("dangki"); 
  
  function shownapthe() { 
    var y = document.getElementById("napthe"); 
    y.show(); 
  } 
  
  function closenapthe() { 
    var y = document.getElementById("napthe"); 
    y.close(); 
  } 
  function showcongtien(matv,tentv){
    document.getElementById("cong").action='?tv='+matv;
    document.getElementById("tentv").innerHTML=tentv;
    var congtien = document.getElementById("congtien");
    congtien.show();

  }
  function closecongtien(){
    var closetien = document.getElementById("congtien");
    closetien.close();
  }

