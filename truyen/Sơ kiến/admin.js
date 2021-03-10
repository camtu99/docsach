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
  var x = document.getElementById("myDialog");
  x.open = true;
}
function close_chuong(){
  var x = document.getElementById("myDialog");
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