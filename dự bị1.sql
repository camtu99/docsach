drop database do_an_doc_sach;
create database do_an_doc_sach;
use do_an_doc_sach;
create table the_loai_sach(
	ma_loai char(7) primary key,
    ten_loai varchar(40) not null
);
create table tac_gia(
	ma_tac_gia char(7) primary key,
    ten_tac_gia varchar(30) not null
);
create table sach(
	ma_sach char(7) primary key,
    ten_sach varchar(100) not null,
    mo_ta varchar(500),
    tinh_trang varchar(15) not null,
    hinh_anh char(40) not null,
    ma_tac_gia char(7) not null,
    luot_doc int,
    khoa int not null,
    constraint fk_ma_tac_gia foreign key (ma_tac_gia) references tac_gia(ma_tac_gia)
);
create table tag_sach(
	ma_sach char(7) not null,
    ma_loai char(7) not null,
    constraint pk_tag primary key (ma_sach,ma_loai),
    constraint fk_masach foreign key(ma_sach) references sach(ma_sach),
    constraint fk_maloai foreign key (ma_loai) references the_loai_sach(ma_loai)
);
create table noi_dung_sach(
	ma_chuong int  PRIMARY KEY AUTO_INCREMENT,
    ma_sach char(7) not null ,
    ten_chuong varchar(30) not null,
    noi_dung_chuong varchar(30) not null,
    ngay datetime,
    stt int,
    constraint  fk_ma_sach foreign key (ma_sach) references sach(ma_sach)
    
);
create table thanh_vien(
	ma_thanh_vien char (20) primary key,
    mat_khau varchar (255) not null,
    ten_thanh_vien varchar(40) not null,
    email varchar (50),
    so_thich varchar (100),
    quyen int not null
);

-- create table gio_hang(
-- 	ma_giao_dich char(7) primary key,
--     ngay_mua datetime,
--     ma_thanh_vien char (20) not null,
--     ma_sach char(7) not null,
--     constraint fk_thanh_vien_gio_hang foreign key (ma_thanh_vien) references thanh_vien(ma_thanh_vien),
--     constraint fk_sach_gio_hang foreign key (ma_sach) references sach(ma_sach)
--     );
    create table binh_luan(
			ma_binh_luan int not null,
            noi_dung_bl varchar (200) not null,
            ma_thanh_vien char (20) not null,
            ma_sach char(7) not null,
            constraint pk_binh_luan primary key (ma_binh_luan),
			constraint fk_thanh_vien_binh_luan foreign key (ma_thanh_vien) references thanh_vien(ma_thanh_vien),
			constraint fk_sach_binh_luan foreign key (ma_sach) references sach(ma_sach)
	);
    create table danh_gia (
		ma_thanh_vien char (20) not null,
		ma_sach char(7) not null,
        constraint pk_dg primary key (ma_thanh_vien,ma_sach),
        constraint fk_tv foreign key (ma_thanh_vien) references thanh_vien(ma_thanh_vien),
		constraint fk_sach_dg foreign key (ma_sach) references sach(ma_sach)
	);
    create table luot_doc(
		ma_luot int PRIMARY KEY AUTO_INCREMENT,
        ma_sach char(7) not null,
        ngay_doc date,
        constraint fk_sach_ld foreign key (ma_sach) references sach(ma_sach)
    );
    
    -- th??m t??c gi??? 
    insert into tac_gia values ('TG1','C??? M???n');
    insert into tac_gia values ('TG2','Nh???t Nh???t');
    insert into tac_gia values ('TG3','B???t D???');
    insert into tac_gia values ('TG4','M???n H???i');
    insert into tac_gia values ('TG5','Nh?? S??');
    -- th??m th??? lo???i
    insert into the_loai_sach values('TL1','Ng??n t??nh');
    insert into the_loai_sach values('TL2','Ki???m hi???p');
    insert into the_loai_sach values('TL3','Ti??n hi???p');
    insert into the_loai_sach values('TL4','Trinh th??m');
    insert into the_loai_sach values('TL5','Kinh d???');
    -- th??m s??ch
    insert into sach values('MS1','B??n nhau tr???n ?????i','mota.txt','Ho??n th??nh','ben_nhau.jpg','TG1',0,0);
    insert into sach values('MS2','B???t d??? h???i','mota.txt','Ho??n th??nh','bat_da.jpg','TG3',0,0);
    insert into sach values('MS3','S?? ki???n','mota.txt','Ho??n th??nh','so_kien.jpg','TG5',0,0);
    insert into sach values('MS4','L???c xu','mota.txt','Ho??n th??nh','luc_xu.jpg','TG4',0,0);
    insert into sach values('MS5','T?? ki???n','mota.txt','Ho??n th??nh','te_kien.jpg','TG2',0,0);
    -- tag s??ch
    insert into tag_sach values('MS1','TL1');
    insert into tag_sach values('MS1','TL2');
    insert into tag_sach values('MS2','TL3');
    insert into tag_sach values('MS2','TL4');
    insert into tag_sach values('MS3','TL5');
    insert into tag_sach values('MS3','TL1');
    insert into tag_sach values('MS3','TL2');
    insert into tag_sach values('MS4','TL3');
    insert into tag_sach values('MS4','TL4');
    insert into tag_sach values('MS4','TL5');
    insert into tag_sach values('MS5','TL1');
    insert into tag_sach values('MS5','TL2');
    insert into tag_sach values('MS5','TL3');
    -- th??nh vi??n
    insert into thanh_vien values ('user1','abc','m??t chi???c thuy???n','','',0);
    insert into thanh_vien values ('user2','abc','m??t chi???c thuy???n 1','','',0);
    insert into thanh_vien values ('user3','abc','m??t chi???c thuy???n 2','','',0);
    insert into thanh_vien values ('user4','abc','m??t chi???c thuy???n 3','','',0);
    insert into thanh_vien values ('user5','abc','m??t chi???c thuy???n 4','','',0);
    -- n??i dung s??ch
    insert into noi_dung_sach(ma_sach,ten_chuong,noi_dung_chuong,ngay,stt) values ('MS1','Ch????ng 1','chuong1.txt','2020-09-20 23:21:19',1);
    insert into noi_dung_sach(ma_sach,ten_chuong,noi_dung_chuong,ngay,stt)  values ('MS1','Ch????ng 2','chuong2.txt','2020-09-20 23:21:29',2);
    insert into noi_dung_sach(ma_sach,ten_chuong,noi_dung_chuong,ngay,stt)  values ('MS1','Ch????ng 3','chuong3.txt','2020-09-20 23:21:13',3);
    insert into noi_dung_sach(ma_sach,ten_chuong,noi_dung_chuong,ngay,stt)  values ('MS2','Ch????ng 1','chuong1.txt','2020-09-20 23:21:02',1);
    insert into noi_dung_sach(ma_sach,ten_chuong,noi_dung_chuong,ngay,stt)  values ('MS2','Ch????ng 2','chuong2.txt','2020-09-20 23:21:01',2);
    insert into noi_dung_sach(ma_sach,ten_chuong,noi_dung_chuong,ngay,stt)  values ('MS1','Ch????ng 4','chuong4.txt','2020-09-20 23:21:04',4);
    insert into noi_dung_sach(ma_sach,ten_chuong,noi_dung_chuong,ngay,stt)  values ('MS1','Ch????ng 5','chuong5.txt','2020-09-20 23:21:06',5);
    insert into noi_dung_sach(ma_sach,ten_chuong,noi_dung_chuong,ngay,stt)  values ('MS1','Ch????ng 6','chuong6.txt','2020-09-20 23:21:08',6);
    insert into noi_dung_sach(ma_sach,ten_chuong,noi_dung_chuong,ngay,stt)  values ('MS1','Ch????ng 7','chuong7.txt','2020-09-20 23:21:07',7);
    insert into noi_dung_sach(ma_sach,ten_chuong,noi_dung_chuong,ngay,stt)  values ('MS1','Ch????ng 8','chuong8.txt','2020-09-20 23:21:00',8);
    insert into noi_dung_sach(ma_sach,ten_chuong,noi_dung_chuong,ngay,stt)  values ('MS1','Ch????ng 9','chuong9.txt','2020-09-20 23:21:11',9);
    insert into noi_dung_sach(ma_sach,ten_chuong,noi_dung_chuong,ngay,stt)  values ('MS1','Ch????ng 10','chuong10.txt','2020-09-20 23:21:12',10);
    insert into noi_dung_sach(ma_sach,ten_chuong,noi_dung_chuong,ngay,stt)  values ('MS1','Ch????ng 11','chuong11.txt','2020-09-20 23:21:14',11);
    insert into noi_dung_sach(ma_sach,ten_chuong,noi_dung_chuong,ngay,stt)  values ('MS1','Ch????ng 12','chuong12.txt','2020-09-20 23:21:15',12);
    insert into noi_dung_sach(ma_sach,ten_chuong,noi_dung_chuong,ngay,stt)  values ('MS1','Ch????ng 13','chuong13.txt','2020-09-20 23:21:18',13);
    insert into noi_dung_sach(ma_sach,ten_chuong,noi_dung_chuong,ngay,stt)  values ('MS1','Ch????ng 14','chuong14.txt','2020-09-20 23:21:18',14);
     insert into noi_dung_sach(ma_sach,ten_chuong,noi_dung_chuong,ngay,stt)  values ('MS1','Ch????ng 16','chuong14.txt','2020-09-20 23:21:18',16);
       insert into noi_dung_sach(ma_sach,ten_chuong,noi_dung_chuong,ngay,stt)  values ('MS1','Ch????ng 15','chuong14.txt','2020-09-20 23:21:18',15);
    -- gio h??ng
   --  insert into gio_hang values ('1','22-02-2020','user1',1);
--     insert into gio_hang values ('2','22-02-2020','user1',2);
--     insert into gio_hang values ('3','22-02-2020','user1',3);
--     insert into gio_hang values ('4','22-02-2020','user2',1);
--     insert into gio_hang values ('5','22-02-2020','user3',1);
    -- d??nh gi??
    insert into danh_gia values ('user1','MS1');
    insert into danh_gia values ('user1','MS2');
	insert into danh_gia values ('user2','MS1');
	insert into danh_gia values ('user3','MS1');
	insert into danh_gia values ('user2','MS2');
	-- b??nh lu???n
  insert into binh_luan values(1,'kh??ng hay','user1','MS1');
insert into binh_luan values(2,'kh??ng hay l???m','user1','MS1');
   insert into binh_luan values(3,'kh?? hay','user1','MS1');
   insert into binh_luan values(4,'t???m hay','user2','MS1');
  insert into binh_luan values(5,'kh??ng hay m?? ?????c ???????c','user3','MS1');
  insert into binh_luan values(6,'kh??ng hay m?? ?????c ???????c','user3','MS3');
    insert into binh_luan values(7,'kh??ng hay m?? ?????c ???????c','user3','MS2');
    -- luot doc

    insert into luot_doc(ma_sach,ngay_doc) values ('MS1','2020-01-22');
    insert into luot_doc(ma_sach,ngay_doc) values ('MS1','2020-01-22');
    insert into luot_doc(ma_sach,ngay_doc) values ('MS1','2020-01-22');
    insert into luot_doc(ma_sach,ngay_doc) values ('MS1','2020-01-22');
    insert into luot_doc(ma_sach,ngay_doc) values ('MS1','2020-01-22');
    insert into luot_doc(ma_sach,ngay_doc) values ('MS1','2020-01-22');
    insert into luot_doc(ma_sach,ngay_doc) values ('MS1','2020-01-22');
    insert into luot_doc(ma_sach,ngay_doc) values ('MS1','2020-01-22');
    insert into luot_doc(ma_sach,ngay_doc) values ('MS1','2020-01-22');
    insert into luot_doc(ma_sach,ngay_doc) values ('MS1','2020-01-22');
    insert into luot_doc(ma_sach,ngay_doc) values ('MS1','2020-01-22');
    insert into luot_doc(ma_sach,ngay_doc) values ('MS1','2020-01-22');
    insert into luot_doc(ma_sach,ngay_doc) values ('MS1','2020-01-22');
    insert into luot_doc(ma_sach,ngay_doc) values ('MS1','2020-01-22');
    insert into luot_doc(ma_sach,ngay_doc) values ('MS1','2020-01-22');
    insert into luot_doc(ma_sach,ngay_doc) values ('MS1','2020-01-22');
    insert into luot_doc(ma_sach,ngay_doc) values ('MS1','2020-01-22');
    insert into luot_doc(ma_sach,ngay_doc) values ('MS1','2020-01-22');
    insert into luot_doc(ma_sach,ngay_doc) values ('MS1','2020-01-22');
    insert into luot_doc(ma_sach,ngay_doc) values ('MS1','2020-01-22');
    insert into luot_doc(ma_sach,ngay_doc) values ('MS1','2020-01-22');
    insert into luot_doc(ma_sach,ngay_doc) values ('MS1','2020-07-23');
     insert into luot_doc(ma_sach,ngay_doc) values ('MS1','2020-07-23');
    insert into luot_doc(ma_sach,ngay_doc) values ('MS1','2020-07-23');
    insert into luot_doc(ma_sach,ngay_doc) values ('MS1','2020-07-23');
    insert into luot_doc(ma_sach,ngay_doc) values ('MS1','2020-07-23');
    insert into luot_doc(ma_sach,ngay_doc) values ('MS1','2020-07-23');
    insert into luot_doc(ma_sach,ngay_doc) values ('MS1','2020-07-23');
    insert into luot_doc(ma_sach,ngay_doc) values ('MS1','2020-07-23');
    insert into luot_doc(ma_sach,ngay_doc) values ('MS1','2020-07-23');
    insert into luot_doc(ma_sach,ngay_doc) values ('MS1','2020-07-23');
    insert into luot_doc(ma_sach,ngay_doc) values ('MS1','2020-07-23');
    insert into luot_doc(ma_sach,ngay_doc) values ('MS1','2020-07-23');
    insert into luot_doc(ma_sach,ngay_doc) values ('MS1','2020-07-23');
    insert into luot_doc(ma_sach,ngay_doc) values ('MS1','2020-07-23');
    insert into luot_doc(ma_sach,ngay_doc) values ('MS1','2020-07-23');
    insert into luot_doc(ma_sach,ngay_doc) values ('MS1','2020-07-23');
    insert into luot_doc(ma_sach,ngay_doc) values ('MS1','2020-07-23');
	insert into luot_doc(ma_sach,ngay_doc) values ('MS1','2020-07-28');
  insert into luot_doc(ma_sach,ngay_doc) values ('MS1','2020-07-28');
  insert into luot_doc(ma_sach,ngay_doc) values ('MS1','2020-07-28');
  insert into luot_doc(ma_sach,ngay_doc) values ('MS1','2020-07-28');
  insert into luot_doc(ma_sach,ngay_doc) values ('MS1','2020-07-28');
  insert into luot_doc(ma_sach,ngay_doc) values ('MS1','2020-07-28');
  insert into luot_doc(ma_sach,ngay_doc) values ('MS1','2020-07-28');
  insert into luot_doc(ma_sach,ngay_doc) values ('MS1','2020-07-28');
  insert into luot_doc(ma_sach,ngay_doc) values ('MS1','2020-07-28');
  insert into luot_doc(ma_sach,ngay_doc) values ('MS3','2020-07-28');
  insert into luot_doc(ma_sach,ngay_doc) values ('MS3','2020-07-28');
  insert into luot_doc(ma_sach,ngay_doc) values ('MS3','2020-07-28');
  insert into luot_doc(ma_sach,ngay_doc) values ('MS3','2020-07-28');
  insert into luot_doc(ma_sach,ngay_doc) values ('MS3','2020-07-28');
  insert into luot_doc(ma_sach,ngay_doc) values ('MS3','2020-07-28');
  insert into luot_doc(ma_sach,ngay_doc) values ('MS3','2020-07-28');
  insert into luot_doc(ma_sach,ngay_doc) values ('MS3','2020-07-28');
  insert into luot_doc(ma_sach,ngay_doc) values ('MS3','2020-07-28');
  insert into luot_doc(ma_sach,ngay_doc) values ('MS3','2020-07-28');
  insert into luot_doc(ma_sach,ngay_doc) values ('MS3','2020-07-28');
  insert into luot_doc(ma_sach,ngay_doc) values ('MS3','2020-07-28');
  insert into luot_doc(ma_sach,ngay_doc) values ('MS3','2020-08-14');
  insert into luot_doc(ma_sach,ngay_doc) values ('MS3','2020-08-14');
  insert into luot_doc(ma_sach,ngay_doc) values ('MS3','2020-08-14');
  insert into luot_doc(ma_sach,ngay_doc) values ('MS3','2020-08-14');
  insert into luot_doc(ma_sach,ngay_doc) values ('MS3','2020-08-14');
  insert into luot_doc(ma_sach,ngay_doc) values ('MS3','2020-08-14');
  insert into luot_doc(ma_sach,ngay_doc) values ('MS3','2020-08-14');
  insert into luot_doc(ma_sach,ngay_doc) values ('MS3','2020-08-14');
  insert into luot_doc(ma_sach,ngay_doc) values ('MS3','2020-08-14');
  insert into luot_doc(ma_sach,ngay_doc) values ('MS3','2020-08-14');
  insert into luot_doc(ma_sach,ngay_doc) values ('MS3','2020-08-14');
  
    select * from luot_doc where ma_sach='MS1';
 select * from noi_dung_sach where ma_sach='MS1';
 select * from noi_dung_sach where ma_sach='MS1' order by stt ASC