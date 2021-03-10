-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th12 26, 2020 lúc 06:29 AM
-- Phiên bản máy phục vụ: 10.4.14-MariaDB
-- Phiên bản PHP: 7.4.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `do_an_doc_sach`
--

DELIMITER $$
--
-- Thủ tục
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `cong_tien` (`matv` CHAR(20), `tiencong` INT)  BEGIN
DECLARE tien_moi int;
DECLARE tien int;
    SELECT so_tien into tien
    FROM thanh_vien
    WHERE ma_thanh_vien=matv;
	 set tien_moi = tien+tiencong; 
    update thanh_vien set so_tien=tien_moi where ma_thanh_vien=matv;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `luotdoc` (`masach` CHAR(7))  begin
DECLARE luotdoccu int;
DECLARE luotmoi int;
    SELECT luot_doc into luotdoccu
    FROM sach
    WHERE ma_sach=masach;
	 set luotmoi = luotdoccu+1; 
    update sach set luot_doc=luotmoi where ma_sach=masach;
    insert into luot_doc(ma_sach,ngay_doc) values (masach,CURRENT_DATE);
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `maxmkngay` (`ngay` DATE)  begin
create temporary table tam as select count(*) tong, ma_sach 
 from gio_hang where date(ngay_mua)=ngay group by ma_sach;
select tong ,ma_sach from tam where tong=(select max(tong) from tam);
drop temporary table if exists tam;
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `maxmkthang` (`thang` INT, `nam` INT)  begin
create temporary table thangtam as select count(*) tong, ma_sach 
 from gio_hang where month(ngay_mua)=thang and year(ngay_mua)=nam group by ma_sach;
select tong ,ma_sach from thangtam where tong=(select max(tong) from thangtam);
drop temporary table if exists thangtam;
end$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `mkngay` (`ngay` DATE)  BEGIN
    SELECT count(date(ngay_mua))
    FROM gio_hang
    WHERE date(ngay_mua)>(SELECT DATE_SUB(ngay, INTERVAL 10 DAY)) and date(ngay_mua)<=ngay group by date(ngay_mua);
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `muasach` (`masach` CHAR(7), `giatien` INT, `thanhvien` CHAR(20))  begin
DECLARE giamoi int;
DECLARE giacu int;
    SELECT so_tien into giacu
    FROM thanh_vien
    WHERE ma_thanh_vien=thanhvien;
	 set giamoi = giacu-giatien; 
    update thanh_vien set so_tien=giamoi where ma_thanh_vien=thanhvien;
    insert into gio_hang(ngay_mua,ma_thanh_vien,ma_sach,gia_mo_khoa) values (CURRENT_DATE,thanhvien,masach,giatien);
end$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `binh_luan`
--

CREATE TABLE `binh_luan` (
  `ma_binh_luan` int(11) NOT NULL,
  `noi_dung_bl` varchar(200) NOT NULL,
  `ma_thanh_vien` char(20) NOT NULL,
  `ma_sach` char(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `binh_luan`
--

INSERT INTO `binh_luan` (`ma_binh_luan`, `noi_dung_bl`, `ma_thanh_vien`, `ma_sach`) VALUES
(8, 'test', '123', 'MS4'),
(9, 'Chương 1 tác giả cho quá nhiều cám xúc gây phấn khích. Chương về sau bị nhạt dần nên gây ra chất xúc tác gây chán', 'Hân Hân Hướng Vinh', 'MS21'),
(10, 'Sao nhiều điểm tương đồng với tuổi thơ mình thế mình thích nhất là chò vợ chồng', 'Nguyễn Trà', 'MS21'),
(11, 'Những câu chuyện của Nguyễn Nhật Ánh luôn mang lại cho chúng ta một cảm giác buồn vui lẫn lộn, cảm giác như chúng ta đang hòa mình vào nhân vật.', 'Thu Lăng', 'MS21'),
(12, 'Mình vẫn thắc mắc chương khu vườn trên mây, tại sao nhà chung cư mà lại có sân, có vườn được nhỉ. Lại còn làm bằng tôn nữa. Có ban công thì còn hình dung ra chứ có vườn thì mình ko tài nào hình dung d', ' Nguyễn Jordan', 'MS32'),
(13, '\r\nchỉ biết nhận xét bằng 1 chữ: hay', 'D4C', 'MS32');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `danh_gia`
--

CREATE TABLE `danh_gia` (
  `ma_thanh_vien` char(20) NOT NULL,
  `ma_sach` char(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `danh_gia`
--

INSERT INTO `danh_gia` (`ma_thanh_vien`, `ma_sach`) VALUES
('123', 'MS1'),
('D4C', 'MS32');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `gio_hang`
--

CREATE TABLE `gio_hang` (
  `ma_giao_dich` int(11) NOT NULL,
  `ngay_mua` datetime DEFAULT NULL,
  `ma_thanh_vien` char(20) NOT NULL,
  `ma_sach` char(7) NOT NULL,
  `gia_mo_khoa` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `gio_hang`
--

INSERT INTO `gio_hang` (`ma_giao_dich`, `ngay_mua`, `ma_thanh_vien`, `ma_sach`, `gia_mo_khoa`) VALUES
(173, '2020-12-23 00:00:00', ' A Thuần', 'MS21', 10),
(174, '2020-12-24 00:00:00', 'Thang Viên Hảo Viên', 'MS21', 10),
(175, '2020-12-24 00:00:00', 'Nguyễn Trà', 'MS22', 23),
(176, '2020-12-24 00:00:00', 'Thang Viên Hảo Viên', 'MS25', 10),
(177, '2020-12-25 00:00:00', 'Úy Không', 'MS24', 5),
(178, '2020-12-25 00:00:00', 'Úy Không', 'MS25', 10),
(179, '2020-12-25 00:00:00', 'Nguyệt Hạ Điệp Ảnh', 'MS23', 20),
(180, '2020-12-25 00:00:00', 'Nguyệt Hạ Điệp Ảnh', 'MS22', 23),
(181, '2020-12-25 00:00:00', 'Thời Tinh Thảo', 'MS24', 5),
(182, '2020-12-25 00:00:00', 'Hà Thư', 'MS24', 5),
(183, '2020-12-25 00:00:00', 'Hà Thư', 'MS23', 20),
(184, '2020-12-25 00:00:00', 'Hà Thư', 'MS26', 15),
(185, '2020-12-25 00:00:00', 'Phù Hoa', 'MS25', 10),
(186, '2020-12-25 00:00:00', 'Phù Hoa', 'MS22', 23),
(187, '2020-12-26 00:00:00', ' Nguyễn Jordan', 'MS32', 10),
(188, '2020-12-26 00:00:00', ' Nguyễn Jordan', 'MS24', 5),
(189, '2020-12-26 00:00:00', 'Luyến ★ Luyến', 'MS26', 15),
(190, '2020-12-26 00:00:00', 'Luyến ★ Luyến', 'MS24', 5),
(191, '2020-12-26 00:00:00', 'Luyến ★ Luyến', 'MS25', 10),
(192, '2020-12-26 00:00:00', 'D4C', 'MS25', 10),
(193, '2020-12-26 00:00:00', 'D4C', 'MS32', 10),
(194, '2020-12-26 00:00:00', 'JQ Vạn Niên Khanh', 'MS32', 10),
(195, '2020-12-26 00:00:00', 'camtu', 'MS25', 10);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `luot_doc`
--

CREATE TABLE `luot_doc` (
  `ma_luot` int(11) NOT NULL,
  `ma_sach` char(7) NOT NULL,
  `ngay_doc` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `luot_doc`
--

INSERT INTO `luot_doc` (`ma_luot`, `ma_sach`, `ngay_doc`) VALUES
(1, 'MS1', '2020-01-22'),
(2, 'MS1', '2020-01-22'),
(3, 'MS1', '2020-01-22'),
(4, 'MS1', '2020-01-22'),
(5, 'MS1', '2020-01-22'),
(6, 'MS1', '2020-01-22'),
(7, 'MS1', '2020-01-22'),
(8, 'MS1', '2020-01-22'),
(9, 'MS1', '2020-01-22'),
(10, 'MS1', '2020-01-22'),
(11, 'MS1', '2020-01-22'),
(12, 'MS1', '2020-01-22'),
(13, 'MS1', '2020-01-22'),
(14, 'MS1', '2020-01-22'),
(15, 'MS1', '2020-01-22'),
(16, 'MS1', '2020-01-22'),
(17, 'MS1', '2020-01-22'),
(18, 'MS1', '2020-01-22'),
(19, 'MS1', '2020-01-22'),
(20, 'MS1', '2020-01-22'),
(21, 'MS1', '2020-01-22'),
(22, 'MS1', '2020-07-23'),
(23, 'MS1', '2020-07-23'),
(24, 'MS1', '2020-07-23'),
(25, 'MS1', '2020-07-23'),
(26, 'MS1', '2020-07-23'),
(27, 'MS1', '2020-07-23'),
(28, 'MS1', '2020-07-23'),
(29, 'MS1', '2020-07-23'),
(30, 'MS1', '2020-07-23'),
(31, 'MS1', '2020-07-23'),
(32, 'MS1', '2020-07-23'),
(33, 'MS1', '2020-07-23'),
(34, 'MS1', '2020-07-23'),
(35, 'MS1', '2020-07-23'),
(36, 'MS1', '2020-07-23'),
(37, 'MS1', '2020-07-23'),
(38, 'MS1', '2020-07-23'),
(39, 'MS1', '2020-07-28'),
(40, 'MS1', '2020-07-28'),
(41, 'MS1', '2020-07-28'),
(42, 'MS1', '2020-07-28'),
(43, 'MS1', '2020-07-28'),
(44, 'MS1', '2020-07-28'),
(45, 'MS1', '2020-07-28'),
(46, 'MS1', '2020-07-28'),
(47, 'MS1', '2020-07-28'),
(48, 'MS3', '2020-07-28'),
(49, 'MS3', '2020-07-28'),
(50, 'MS3', '2020-07-28'),
(51, 'MS3', '2020-07-28'),
(52, 'MS3', '2020-07-28'),
(53, 'MS3', '2020-07-28'),
(54, 'MS3', '2020-07-28'),
(55, 'MS3', '2020-07-28'),
(56, 'MS3', '2020-07-28'),
(57, 'MS3', '2020-07-28'),
(58, 'MS3', '2020-07-28'),
(59, 'MS3', '2020-07-28'),
(60, 'MS3', '2020-08-14'),
(61, 'MS3', '2020-08-14'),
(62, 'MS3', '2020-08-14'),
(63, 'MS3', '2020-08-14'),
(64, 'MS3', '2020-08-14'),
(65, 'MS3', '2020-08-14'),
(66, 'MS3', '2020-08-14'),
(67, 'MS3', '2020-08-14'),
(68, 'MS3', '2020-08-14'),
(69, 'MS3', '2020-08-14'),
(70, 'MS3', '2020-08-14'),
(71, 'MS1', '2020-12-13'),
(72, 'MS1', '2020-12-13'),
(73, 'MS1', '2020-12-13'),
(74, 'MS1', '2020-12-13'),
(75, 'MS1', '2020-12-13'),
(76, 'MS1', '2020-12-13'),
(77, 'MS1', '2020-12-13'),
(78, 'MS1', '2020-12-13'),
(79, 'MS1', '2019-07-23'),
(80, 'MS3', '2020-08-14'),
(81, 'MS3', '2020-08-14'),
(82, 'MS3', '2020-08-14'),
(83, 'MS3', '2020-08-14'),
(84, 'MS3', '2020-08-14'),
(85, 'MS3', '2020-08-14'),
(86, 'MS3', '2020-08-14'),
(87, 'MS3', '2020-08-14'),
(88, 'MS3', '2020-08-14'),
(89, 'MS3', '2020-08-14'),
(90, 'MS3', '2020-08-14'),
(91, 'MS3', '2020-08-14'),
(92, 'MS3', '2020-08-14'),
(93, 'MS3', '2020-08-14'),
(94, 'MS1', '2020-12-16'),
(95, 'MS1', '2020-12-16'),
(96, 'MS1', '2020-12-16'),
(99, 'MS1', '2020-12-20'),
(100, 'MS1', '2020-12-20'),
(101, 'MS1', '2020-12-20'),
(102, 'MS1', '2020-12-20'),
(103, 'MS1', '2020-12-20'),
(104, 'MS1', '2020-12-20'),
(105, 'MS1', '2020-12-20'),
(106, 'MS1', '2020-12-20'),
(107, 'MS1', '2020-12-20'),
(108, 'MS1', '2020-12-20'),
(109, 'MS1', '2020-12-20'),
(110, 'MS2', '2020-12-20'),
(111, 'MS2', '2020-12-20'),
(112, 'MS2', '2020-12-20'),
(113, 'MS1', '2020-12-20'),
(114, 'MS8', '2020-12-21'),
(115, 'MS8', '2020-12-21'),
(116, 'MS8', '2020-12-21'),
(117, 'MS9', '2020-12-21'),
(118, 'MS9', '2020-12-21'),
(119, 'MS9', '2020-12-21'),
(120, 'MS9', '2020-12-21'),
(121, 'MS9', '2020-12-21'),
(122, 'MS9', '2020-12-21'),
(123, 'MS9', '2020-12-21'),
(124, 'MS9', '2020-12-21'),
(125, 'MS9', '2020-12-21'),
(126, 'MS9', '2020-12-21'),
(127, 'MS9', '2020-12-21'),
(128, 'MS9', '2020-12-21'),
(129, 'MS9', '2020-12-21'),
(130, 'MS9', '2020-12-21'),
(131, 'MS9', '2020-12-21'),
(132, 'MS9', '2020-12-21'),
(133, 'MS9', '2020-12-21'),
(134, 'MS9', '2020-12-21'),
(135, 'MS9', '2020-12-21'),
(136, 'MS9', '2020-12-21'),
(137, 'MS9', '2020-12-21'),
(138, 'MS9', '2020-12-21'),
(139, 'MS9', '2020-12-21'),
(140, 'MS9', '2020-12-21'),
(141, 'MS9', '2020-12-21'),
(142, 'MS4', '2020-12-22'),
(143, 'MS4', '2020-12-22'),
(144, 'MS4', '2020-12-22'),
(145, 'MS4', '2020-12-22'),
(146, 'MS4', '2020-12-22'),
(147, 'MS4', '2020-12-22'),
(148, 'MS4', '2020-12-22'),
(149, 'MS4', '2020-12-22'),
(150, 'MS4', '2020-12-22'),
(151, 'MS4', '2020-12-22'),
(152, 'MS4', '2020-12-22'),
(153, 'MS4', '2020-12-22'),
(154, 'MS4', '2020-12-22'),
(155, 'MS4', '2020-12-22'),
(156, 'MS4', '2020-12-22'),
(157, 'MS4', '2020-12-22'),
(158, 'MS4', '2020-12-22'),
(159, 'MS4', '2020-12-22'),
(160, 'MS4', '2020-12-22'),
(161, 'MS4', '2020-12-22'),
(162, 'MS4', '2020-12-22'),
(163, 'MS4', '2020-12-22'),
(164, 'MS4', '2020-12-22'),
(165, 'MS4', '2020-12-22'),
(166, 'MS4', '2020-12-22'),
(167, 'MS4', '2020-12-22'),
(168, 'MS4', '2020-12-22'),
(169, 'MS4', '2020-12-22'),
(170, 'MS4', '2020-12-22'),
(171, 'MS4', '2020-12-22'),
(172, 'MS4', '2020-12-22'),
(173, 'MS4', '2020-12-22'),
(174, 'MS4', '2020-12-22'),
(175, 'MS4', '2020-12-22'),
(176, 'MS4', '2020-12-22'),
(177, 'MS4', '2020-12-22'),
(178, 'MS4', '2020-12-22'),
(179, 'MS4', '2020-12-22'),
(180, 'MS4', '2020-12-22'),
(181, 'MS4', '2020-12-22'),
(182, 'MS4', '2020-12-22'),
(183, 'MS4', '2020-12-22'),
(184, 'MS4', '2020-12-22'),
(185, 'MS4', '2020-12-22'),
(186, 'MS4', '2020-12-22'),
(187, 'MS4', '2020-12-22'),
(188, 'MS4', '2020-12-22'),
(189, 'MS4', '2020-12-22'),
(190, 'MS4', '2020-12-22'),
(191, 'MS4', '2020-12-22'),
(192, 'MS8', '2020-12-22'),
(193, 'MS8', '2020-12-22'),
(194, 'MS8', '2020-12-22'),
(195, 'MS8', '2020-12-22'),
(196, 'MS8', '2020-12-22'),
(197, 'MS8', '2020-12-22'),
(198, 'MS21', '2020-12-24'),
(199, 'MS21', '2020-12-24'),
(200, 'MS21', '2020-12-24'),
(201, 'MS21', '2020-12-24'),
(202, 'MS21', '2020-12-24'),
(203, 'MS21', '2020-12-24'),
(204, 'MS21', '2020-12-24'),
(205, 'MS21', '2020-12-24'),
(206, 'MS21', '2020-12-24'),
(207, 'MS21', '2020-12-24'),
(208, 'MS21', '2020-12-24'),
(209, 'MS21', '2020-12-24'),
(210, 'MS21', '2020-12-24'),
(211, 'MS21', '2020-12-24'),
(212, 'MS21', '2020-12-24'),
(213, 'MS21', '2020-12-24'),
(214, 'MS21', '2020-12-24'),
(215, 'MS25', '2020-12-24'),
(216, 'MS25', '2020-12-24'),
(217, 'MS30', '2020-12-25'),
(218, 'MS30', '2020-12-25'),
(219, 'MS30', '2020-12-25'),
(220, 'MS30', '2020-12-25'),
(221, 'MS30', '2020-12-25'),
(222, 'MS30', '2020-12-25'),
(223, 'MS30', '2020-12-25'),
(224, 'MS30', '2020-12-25'),
(225, 'MS30', '2020-12-25'),
(226, 'MS30', '2020-12-25'),
(227, 'MS30', '2020-12-25'),
(228, 'MS30', '2020-12-25'),
(229, 'MS30', '2020-12-25'),
(230, 'MS30', '2020-12-25'),
(231, 'MS30', '2020-12-25'),
(232, 'MS30', '2020-12-25'),
(233, 'MS30', '2020-12-25'),
(234, 'MS30', '2020-12-25'),
(235, 'MS30', '2020-12-25'),
(236, 'MS30', '2020-12-25'),
(237, 'MS30', '2020-12-25'),
(238, 'MS30', '2020-12-25'),
(239, 'MS1', '2020-12-25'),
(240, 'MS1', '2020-12-25'),
(241, 'MS1', '2020-12-25'),
(242, 'MS1', '2020-12-25'),
(243, 'MS1', '2020-12-25'),
(244, 'MS1', '2020-12-25'),
(245, 'MS1', '2020-12-25'),
(246, 'MS10', '2020-12-25'),
(247, 'MS10', '2020-12-25'),
(248, 'MS10', '2020-12-25'),
(249, 'MS10', '2020-12-25'),
(250, 'MS10', '2020-12-25'),
(251, 'MS10', '2020-12-25'),
(252, 'MS5', '2020-12-25'),
(253, 'MS5', '2020-12-25'),
(254, 'MS5', '2020-12-25'),
(255, 'MS5', '2020-12-25'),
(256, 'MS5', '2020-12-25'),
(257, 'MS5', '2020-12-25'),
(258, 'MS5', '2020-12-25'),
(259, 'MS5', '2020-12-25'),
(260, 'MS5', '2020-12-25'),
(261, 'MS5', '2020-12-25'),
(262, 'MS5', '2020-12-25'),
(263, 'MS5', '2020-12-25'),
(264, 'MS5', '2020-12-25'),
(265, 'MS5', '2020-12-25'),
(266, 'MS5', '2020-12-25'),
(267, 'MS5', '2020-12-25'),
(268, 'MS24', '2020-12-25'),
(269, 'MS24', '2020-12-25'),
(270, 'MS24', '2020-12-25'),
(271, 'MS24', '2020-12-25'),
(272, 'MS24', '2020-12-25'),
(273, 'MS24', '2020-12-25'),
(274, 'MS24', '2020-12-25'),
(275, 'MS24', '2020-12-25'),
(276, 'MS24', '2020-12-25'),
(277, 'MS24', '2020-12-25'),
(278, 'MS25', '2020-12-25'),
(279, 'MS24', '2020-12-25'),
(280, 'MS24', '2020-12-25'),
(281, 'MS24', '2020-12-25'),
(282, 'MS24', '2020-12-25'),
(283, 'MS24', '2020-12-25'),
(284, 'MS24', '2020-12-25'),
(285, 'MS24', '2020-12-25'),
(286, 'MS24', '2020-12-25'),
(287, 'MS24', '2020-12-25'),
(288, 'MS24', '2020-12-25'),
(289, 'MS24', '2020-12-25'),
(290, 'MS24', '2020-12-25'),
(291, 'MS24', '2020-12-25'),
(292, 'MS24', '2020-12-25'),
(293, 'MS24', '2020-12-25'),
(294, 'MS24', '2020-12-25'),
(295, 'MS24', '2020-12-25'),
(296, 'MS24', '2020-12-25'),
(297, 'MS24', '2020-12-25'),
(298, 'MS24', '2020-12-25'),
(299, 'MS24', '2020-12-25'),
(300, 'MS26', '2020-12-25'),
(301, 'MS26', '2020-12-25'),
(302, 'MS26', '2020-12-25'),
(303, 'MS26', '2020-12-25'),
(304, 'MS26', '2020-12-25'),
(305, 'MS26', '2020-12-25'),
(306, 'MS26', '2020-12-25'),
(307, 'MS26', '2020-12-25'),
(308, 'MS26', '2020-12-25'),
(309, 'MS26', '2020-12-25'),
(310, 'MS26', '2020-12-25'),
(311, 'MS32', '2020-12-26'),
(312, 'MS32', '2020-12-26'),
(313, 'MS32', '2020-12-26'),
(314, 'MS32', '2020-12-26'),
(315, 'MS32', '2020-12-26'),
(316, 'MS32', '2020-12-26'),
(317, 'MS32', '2020-12-26'),
(318, 'MS32', '2020-12-26'),
(319, 'MS32', '2020-12-26'),
(320, 'MS32', '2020-12-26'),
(321, 'MS32', '2020-12-26'),
(322, 'MS32', '2020-12-26'),
(323, 'MS24', '2020-12-26'),
(324, 'MS24', '2020-12-26'),
(325, 'MS27', '2020-12-26'),
(326, 'MS27', '2020-12-26'),
(327, 'MS30', '2020-12-26'),
(328, 'MS30', '2020-12-26'),
(329, 'MS30', '2020-12-26'),
(330, 'MS30', '2020-12-26'),
(331, 'MS8', '2020-12-26'),
(332, 'MS8', '2020-12-26');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `noi_dung_sach`
--

CREATE TABLE `noi_dung_sach` (
  `ma_chuong` int(11) NOT NULL,
  `ma_sach` char(7) NOT NULL,
  `ten_chuong` varchar(30) NOT NULL,
  `noi_dung_chuong` varchar(30) NOT NULL,
  `ngay` datetime NOT NULL,
  `stt` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `noi_dung_sach`
--

INSERT INTO `noi_dung_sach` (`ma_chuong`, `ma_sach`, `ten_chuong`, `noi_dung_chuong`, `ngay`, `stt`) VALUES
(2, 'MS1', 'Chương 2', 'New Text Document.txt', '2020-09-20 23:21:29', 1),
(3, 'MS1', 'Chương 3', 'chuong3.txt', '2020-09-20 23:21:13', 2),
(4, 'MS2', 'Chương 1', 'chuong1.txt', '2020-09-20 23:21:02', 1),
(5, 'MS2', 'Chương 2', 'chuong2.txt', '2020-09-20 23:21:01', 2),
(6, 'MS1', 'Chương 4', 'chuong4.txt', '2020-09-20 23:21:04', 3),
(7, 'MS1', 'Chương 5', 'chuong5.txt', '2020-09-20 23:21:06', 4),
(8, 'MS1', 'Chương 6', 'chuong6.txt', '2020-09-20 23:21:08', 5),
(9, 'MS1', 'Chương 7', 'chuong7.txt', '2020-09-20 23:21:07', 6),
(10, 'MS1', 'Chương 8', 'chuong8.txt', '2020-09-20 23:21:00', 7),
(11, 'MS1', 'Chương 9', 'chuong9.txt', '2020-09-20 23:21:11', 8),
(12, 'MS1', 'Chương 10', 'chuong10.txt', '2020-09-20 23:21:12', 9),
(13, 'MS1', 'Chương 11', 'chuong11.txt', '2020-09-20 23:21:14', 10),
(14, 'MS1', 'Chương 12', 'chuong12.txt', '2020-09-20 23:21:15', 11),
(15, 'MS1', 'Chương 13', 'chuong13.txt', '2020-09-20 23:21:18', 12),
(16, 'MS1', 'Chương 14', 'chuong14.txt', '2020-09-20 23:21:18', 13),
(17, 'MS1', 'Chương 16', 'chuong14.txt', '2020-09-20 23:21:18', 15),
(18, 'MS1', 'Chương 15', 'chuong14.txt', '2020-09-20 23:21:18', 14),
(19, 'MS10', 'chương 1', 'chuong1.txt', '2020-12-20 17:08:59', 1),
(20, 'MS10', 'chương 2', 'chuong2.txt', '2020-12-20 17:09:10', 2),
(21, 'MS11', 'chương 1', 'chuong1.txt', '2020-12-20 17:09:26', 1),
(22, 'MS11', 'chương 2', 'chuong2.txt', '2020-12-20 17:09:35', 2),
(23, 'MS11', 'chương 3', 'chuong3.txt', '2020-12-20 17:09:45', 3),
(24, 'MS13', 'chương 1', 'chuong1.txt', '2020-12-20 17:10:07', 1),
(25, 'MS13', 'chương 2', 'chuong2.txt', '2020-12-20 17:10:16', 2),
(26, 'MS5', 'chương 1', 'chuong1.txt', '2020-12-20 17:10:38', 1),
(27, 'MS5', 'chương 2', 'chuong2.txt', '2020-12-20 17:10:48', 2),
(28, 'MS4', 'chương 1', 'chuong1.txt', '2020-12-20 17:11:03', 1),
(29, 'MS4', 'chương 2', 'chuong2.txt', '2020-12-20 17:11:14', 2),
(30, 'MS9', 'chương 1', 'chuong1.txt', '2020-12-20 17:11:30', 1),
(31, 'MS9', 'chương 2', 'chuong2.txt', '2020-12-20 17:11:38', 2),
(32, 'MS14', 'chương 1', 'chuong1.txt', '2020-12-20 17:11:52', 1),
(33, 'MS3', 'chương 1', 'chuong1.txt', '2020-12-20 17:12:16', 1),
(34, 'MS7', 'chương 1', 'chuong1.txt', '2020-12-20 17:12:32', 1),
(35, 'MS8', 'chương 1', 'chuong1.txt', '2020-12-20 17:18:08', 1),
(36, 'MS6', 'chương 1', 'chuong1.txt', '2020-12-20 17:20:04', 1),
(37, 'MS12', 'chương 1', 'chuong1.txt', '2020-12-20 17:20:47', 1),
(38, 'MS21', 'chương 1', 'chuong.txt', '2020-12-23 18:16:28', 1),
(39, 'MS21', 'chương 2', 'mota.txt', '2020-12-23 18:17:31', 2),
(44, 'MS21', 'chương 3', 'New Text Document.txt', '2020-12-23 18:39:57', 3),
(45, 'MS24', 'chương 1', 'chuong1.txt', '2020-12-24 12:01:06', 1),
(46, 'MS24', 'chương 2', 'chương 2.txt', '2020-12-24 12:01:50', 2),
(47, 'MS25', 'chương 1', 'chuong1.txt', '2020-12-24 12:05:02', 1),
(48, 'MS25', 'chương 2', 'chương 2.txt', '2020-12-24 12:05:17', 2),
(49, 'MS26', 'chương 1', 'chuong1.txt', '2020-12-24 12:09:33', 1),
(50, 'MS26', 'chương 2', 'chương 2.txt', '2020-12-24 12:09:43', 2),
(51, 'MS27', 'Chương 1', 'chuong1.txt', '2020-12-24 14:59:23', 1),
(52, 'MS27', 'Chương 2', 'chương 2.txt', '2020-12-24 14:59:36', 2),
(53, 'MS30', 'Chướng 1', 'chuong1.txt', '2020-12-24 15:03:40', 1),
(54, 'MS30', 'Chương 2', 'chương 2.txt', '2020-12-24 15:03:53', 2),
(55, 'MS31', 'Chương 1', 'chuong1.txt', '2020-12-24 15:19:21', 1),
(56, 'MS31', 'Chương 2', 'chương 2.txt', '2020-12-24 15:19:32', 2),
(57, 'MS31', 'Chương 3', 'chuong3.txt', '2020-12-24 15:23:41', 3),
(58, 'MS31', 'Chương 4', 'chuon4.txt', '2020-12-24 15:23:54', 4),
(59, 'MS31', 'Chương 5', 'chung5.txt', '2020-12-24 15:24:06', 5),
(61, 'MS31', 'Chương 6', 'chương6.txt', '2020-12-24 15:24:35', 6),
(62, 'MS31', 'Chương 7', 'chuong 7.txt', '2020-12-24 15:24:46', 7),
(63, 'MS31', 'Chương 8', '8.txt', '2020-12-24 15:24:57', 8),
(64, 'MS31', 'Chương 9', 'chuong9.txt', '2020-12-24 15:25:11', 9),
(65, 'MS31', 'Chương 10', 'c10.txt', '2020-12-24 15:25:26', 10),
(67, 'MS1', 'Chương 15', 'chuong.txt', '2020-12-25 14:37:02', 16),
(68, 'MS32', 'Tập 1:Nhà ảo thuật', 'chuong1.txt', '2020-12-26 05:22:20', 1),
(69, 'MS32', 'Tập 1: Nhà ảo thuật(2)', 'chương 2.txt', '2020-12-26 05:23:24', 2),
(70, 'MS32', '	Tập 1: Nhà ảo thuật(3)', 'chuong3.txt', '2020-12-26 05:24:29', 3),
(71, 'MS32', 'Tập 1: Nhà ảo thuật(4)', 'chuon4.txt', '2020-12-26 05:25:15', 4),
(72, 'MS32', 'Tập 1: Nhà ảo thuật(5)', 'chung5.txt', '2020-12-26 05:25:57', 5),
(73, 'MS32', 'Tập 1: Nhà ảo thuật(6)', 'chương6.txt', '2020-12-26 05:26:41', 6),
(74, 'MS32', 'Tập 1: Nhà ảo thuật(7)', 'chuong 7.txt', '2020-12-26 05:26:56', 7),
(75, 'MS32', 'Tập 1: Nhà ảo thuật(8)', '8.txt', '2020-12-26 05:27:12', 8),
(76, 'MS32', 'Tập 1: Nhà ảo thuật(End)', 'chuong9.txt', '2020-12-26 05:28:27', 9),
(77, 'MS32', 'Tập 2: Những con gấu bông', 'c10.txt', '2020-12-26 05:29:56', 10);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `sach`
--

CREATE TABLE `sach` (
  `ma_sach` char(7) NOT NULL,
  `ten_sach` varchar(100) NOT NULL,
  `mo_ta` varchar(500) DEFAULT NULL,
  `tinh_trang` varchar(15) NOT NULL,
  `hinh_anh` char(40) NOT NULL,
  `ma_tac_gia` char(7) NOT NULL,
  `luot_doc` int(11) NOT NULL,
  `gia_tien` int(11) NOT NULL,
  `khoa` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `sach`
--

INSERT INTO `sach` (`ma_sach`, `ten_sach`, `mo_ta`, `tinh_trang`, `hinh_anh`, `ma_tac_gia`, `luot_doc`, `gia_tien`, `khoa`) VALUES
('MS1', 'Bên nhau trọn đời', 'mota.txt', 'Hoàn thành', 'ben_nhau.jpg', 'TG1', 19, 0, 0),
('MS10', 'Khinh Chu Tùy Dạng', 'mota.txt', 'Hoàn thành', '5ed3f30d54b80804801f3f97.jpg', 'TG1', 6, 0, 0),
('MS11', 'Mục tụng lộ chín tháng', 'mota.txt', 'Hoàn thành', '5c5bad5654b808549e1fbde8.jpg', 'TG1', 0, 0, 0),
('MS12', 'Quá thời hạn không chờ', 'mota.txt', 'Hoàn thành', '5e58237d54b8087c74d045ef.jpg', 'TG1', 0, 0, 0),
('MS13', 'Một dược khó cầu', 'mota.txt', 'Hoàn thành', '5e56c43a54b80871dc7513a3.jpg', 'TG1', 0, 0, 0),
('MS14', 'Ngàn lẻ một đêm thư tình', 'New Text Document.txt', 'Hoàn thành', '5ae312c0ef21ec68a6603f49.jpg', 'TG1', 0, 0, 0),
('MS15', 'Cái này con rối sư có điểm kia gì', 'mota.txt', 'Hoàn thành', '5fa88f5554b8083ed525a7b1.jpg', 'TG1', 0, 0, 0),
('MS16', 'Minh tôn', 'mota.txt', 'Hoàn thành', '5dfac05754b808774695e8d6.jpg', 'TG1', 0, 0, 0),
('MS17', 'Quỷ dị đệ nhất định luật', 'mota.txt', 'Hoàn thành', '5fc21c1d54b80869ccd4ead1.jpg', 'TG1', 0, 0, 0),
('MS18', 'Digimon Online Royal Knights', 'mota.txt', 'Hoàn thành', '5c373b2454b80845cc860123.jpg', 'TG1', 0, 0, 0),
('MS19', 'Hỏa Ảnh Chi Vô Hạn Bảo Rương Hệ Thống', 'mota.txt', 'Hoàn thành', '5b6f8bff54b8084554c80397.jpg', 'TG1', 0, 0, 0),
('MS2', 'Bất dạ hồi', 'mota.txt', 'Chưa hoàn thành', 'bat_da.jpg', 'TG3', 3, 0, 0),
('MS20', 'Huyền Huyễn Vạn Giới Giao Dịch', 'mota.txt', 'Hoàn thành', '5c3ee49d54b808236363a9ef.jpg', 'TG1', 0, 0, 0),
('MS21', 'Cho Tôi Xin Một Vé Đi Tuổi Thơ', 'mota.txt', 'Hoàn thành', 'cho-toi-mot-ve-di-tuoi-tho.jpg', 'TG6', 17, 10, 0),
('MS22', 'Mắt Biếc', 'mota.txt', 'Hoàn thành', 'mat-biec.jpg', 'TG6', 0, 23, 0),
('MS23', 'Khói Trời Lộng Lẫy', 'mota.txt', 'Hoàn thành', 'Khói-trời-lộng-lẫy-Nguyễn-Ngọc-Tư.png', 'TG7', 0, 20, 0),
('MS24', 'Bàn có 5 chỗ ngồi', 'mota.txt', 'Hoàn thành', 'ban-co-nam-cho-ngoi.gif', 'TG6', 33, 5, 0),
('MS25', 'Hoa Hồng Xứ Khác', 'mota.txt', 'Hoàn thành', 'hoa-hong-xu-khac.jpg', 'TG6', 3, 10, 0),
('MS26', 'Lá nằm trong lá', 'mota.txt', 'Hoàn thành', 'la-nam-trong-la.jpg', 'TG6', 11, 15, 0),
('MS27', 'Bong bóng lên trời', 'mota.txt', 'Hoàn thành', '27.gif', 'TG2', 2, 0, 0),
('MS28', 'Chuyện xứ Lang Biang', 'mota.txt', 'Hoàn thành', 'langbiang-1.jpg', 'TG6', 0, 0, 0),
('MS29', 'Quán Gò đi lên', 'mota.txt', 'Hoàn thành', 'quan-go-di-len.jpeg', 'TG6', 0, 0, 0),
('MS3', 'Sơ kiến', 'mota.txt', 'Hoàn thành', 'so_kien.jpg', 'TG5', 0, 0, 0),
('MS30', 'Có hai con mèo ngồi bên cửa sổ', 'mota.txt', 'Hoàn thành', 'co-hai-con-meo-ngoi-ben-cua-so.jpg', 'TG6', 26, 0, 0),
('MS31', 'Cánh Đồng Bất Tận', 'mota.txt', 'Hoàn thành', 'canh_dong_bat_tan__nguyen_ngoc_tu.jpg', 'TG7', 0, 0, 0),
('MS32', 'Kính Vạn Hoa', 'mota.txt', 'Hoàn thành', 'kinh-van-hoa-nguyen-nhat-anh-1.jpg', 'TG6', 12, 10, 0),
('MS4', 'Lục xu', 'mota.txt', 'Hoàn thành', 'luc_xu.jpg', 'TG4', 50, 0, 0),
('MS5', 'Tê kiến', 'mota.txt', 'Hoàn thành', 'te_kien.jpg', 'TG2', 16, 0, 0),
('MS6', 'Võng Du Tam Quốc Chi Tối Cường Đế Vương', 'mota.txt', 'Chưa hoàn thành', '5b6f8bff54b8084554c80397.jpg', 'TG1', 0, 0, 0),
('MS7', 'Không thể lại cùng ngươi làm bằng hữu', 'mota.txt', 'Hoàn thành', '5fde1beb54b8085e0db86ed3.jpg', 'TG1', 0, 0, 0),
('MS8', 'Phong tình không lay động', 'mota.txt', 'Hoàn thành', '597c5917ef21ec36621019c4.jpg', 'TG1', 11, 0, 0),
('MS9', 'Sơn thủy lại một thành', 'mota.txt', 'Hoàn thành', '5c5baf0f54b80840f6044a7e.jpg', 'TG1', 25, 0, 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tac_gia`
--

CREATE TABLE `tac_gia` (
  `ma_tac_gia` char(7) NOT NULL,
  `ten_tac_gia` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `tac_gia`
--

INSERT INTO `tac_gia` (`ma_tac_gia`, `ten_tac_gia`) VALUES
('TG1', 'Cố Mạn'),
('TG2', 'Nhất Nhất'),
('TG3', 'Bất Dạ'),
('TG4', 'Mạn Hồi'),
('TG5', 'Như Sơ'),
('TG6', 'Nguyễn Nhật Ánh'),
('TG7', 'Nguyễn Ngọc Tư'),
('TG8', 'Lỗ Tấn');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tag_sach`
--

CREATE TABLE `tag_sach` (
  `ma_sach` char(7) NOT NULL,
  `ma_loai` char(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `tag_sach`
--

INSERT INTO `tag_sach` (`ma_sach`, `ma_loai`) VALUES
('MS1', 'TL1'),
('MS1', 'TL8'),
('MS10', 'TL1'),
('MS10', 'TL8'),
('MS11', 'TL1'),
('MS11', 'TL9'),
('MS12', 'TL1'),
('MS13', 'TL1'),
('MS14', 'TL1'),
('MS15', 'TL2'),
('MS15', 'TL6'),
('MS16', 'TL5'),
('MS16', 'TL6'),
('MS16', 'TL8'),
('MS17', 'TL5'),
('MS17', 'TL6'),
('MS17', 'TL7'),
('MS17', 'TL8'),
('MS18', 'TL5'),
('MS18', 'TL6'),
('MS18', 'TL7'),
('MS18', 'TL8'),
('MS19', 'TL6'),
('MS19', 'TL7'),
('MS19', 'TL8'),
('MS2', 'TL3'),
('MS2', 'TL4'),
('MS2', 'TL5'),
('MS2', 'TL7'),
('MS2', 'TL8'),
('MS20', 'TL5'),
('MS20', 'TL6'),
('MS20', 'TL7'),
('MS20', 'TL8'),
('MS21', 'TL5'),
('MS21', 'TL7'),
('MS21', 'TL8'),
('MS22', 'TL5'),
('MS22', 'TL7'),
('MS22', 'TL8'),
('MS23', 'TL7'),
('MS23', 'TL8'),
('MS24', 'TL5'),
('MS24', 'TL7'),
('MS24', 'TL8'),
('MS25', 'TL5'),
('MS25', 'TL7'),
('MS25', 'TL8'),
('MS26', 'TL7'),
('MS26', 'TL8'),
('MS27', 'TL5'),
('MS27', 'TL7'),
('MS27', 'TL8'),
('MS28', 'TL5'),
('MS28', 'TL7'),
('MS29', 'TL5'),
('MS29', 'TL7'),
('MS3', 'TL1'),
('MS3', 'TL2'),
('MS3', 'TL5'),
('MS30', 'TL7'),
('MS30', 'TL8'),
('MS31', 'TL8'),
('MS32', 'TL7'),
('MS4', 'TL3'),
('MS4', 'TL4'),
('MS4', 'TL5'),
('MS5', 'TL1'),
('MS5', 'TL2'),
('MS5', 'TL3'),
('MS6', 'TL2'),
('MS6', 'TL3'),
('MS7', 'TL1'),
('MS7', 'TL3'),
('MS8', 'TL1'),
('MS9', 'TL1');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `thanh_vien`
--

CREATE TABLE `thanh_vien` (
  `ma_thanh_vien` char(20) NOT NULL,
  `mat_khau` varchar(255) NOT NULL,
  `ten_thanh_vien` varchar(40) NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `sdt` char(11) DEFAULT NULL,
  `so_tien` int(11) NOT NULL,
  `quyen` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `thanh_vien`
--

INSERT INTO `thanh_vien` (`ma_thanh_vien`, `mat_khau`, `ten_thanh_vien`, `email`, `sdt`, `so_tien`, `quyen`) VALUES
(' A Thuần', 'e3b582c6682e6469c877851eb34335cf', ' A Thuần', '', '', 67, 0),
(' Nguyễn Jordan', 'a91faaade07c22d15c76d2e05159dcdd', ' Nguyễn Jordan', '', '', 5, 0),
('123', '202cb962ac59075b964b07152d234b70', '123', '', '', 54, 0),
('1234', '81dc9bdb52d04dc20036dbd8313ed055', '1234', '', '', 234, 0),
('234', '289dff07669d7a23de0ef88d2f7129e7', '234', '', '', 0, 1),
('A Bạch', 'c9fe5d56710553232b32feef09e5c6db', 'A Bạch', '', '', 0, 1),
('Anh Anh', '769c7645a347ad14481cbd366e4872e7', 'Anh Anh', '', '', 0, 0),
('Bạch Mộng Lam', '83e582d6956765605ad474685d58e8f8', 'Bạch Mộng Lam', '', '', 0, 0),
('camtu', '1a61ef312abe5fde71e9d8f29035308a', 'Cẩm Tú', '', '', 10, 0),
('D4C', '7ee51439de47f0d08bab3eb94d036557', 'D4C', '', '', 25, 0),
('Giáp Dã', 'f2855c92ff74d1670a00f6ad883dff1d', 'Giáp Dã', '', '', 45, 0),
('Hà Thư', '448cebd54d363343c409093188790ecd', 'Hà Thư', '', '', 80, 0),
('Hân Hân Hướng Vinh', 'c4e437ba81309c5840efb30fbbac47f0', 'Hân Hân Hướng Vinh', '', '', 40, 0),
('Hoàng Thượng', '397ed022fc063c507f52a8d6ac22bb42', 'Hoàng Thượng', '', '', 0, 0),
('JQ Vạn Niên Khanh', '7d79ffd725bffbe7347282a98f49d722', 'JQ Vạn Niên Khanh', '', '', 10, 0),
('Lacus Clyne', '7b23d5201816727110eb3168795eca48', 'Lacus Clyne', '', '', 20, 0),
('lilivi', '2c82585d6e003dd3f4b3dbce53c3e1a6', 'lilivi', '', '', 45, 0),
('Luyến ★ Luyến', '99663f7d604aada442e71112d4805631', 'Luyến ★ Luyến', '', '', 15, 0),
('Miên Miên Mị', '16ef0f4b1a64e220938f5675644a4fc6', 'Miên Miên Mị', '', '', 20, 0),
('ngốc9518', '457a019b874c7de42ec8d70b9179eddf', 'ngốc9518', '', '', 45, 0),
('Nguyễn Trà', '71854f6c82e59085fe3fb80d5e76139e', 'Nguyễn Trà', '', '', 22, 0),
('Nguyệt Hạ Điệp Ảnh', 'c2ef6ed02af9b92f694ac7a5d8ba54e6', 'Nguyệt Hạ Điệp Ảnh', '', '', 2, 0),
('Niên Tiểu Hoa', '0141359088f13ee01356a977f2ee3ce6', 'Niên Tiểu Hoa', '', '', 0, 0),
('Phù Hoa', 'e69f1aed4341d05c4d5225f094b937ae', 'Phù Hoa', '', '', 217, 0),
('Phù Ngư', '63ee6e7cadc43200a5040b1eb357cefb', 'Phù Ngư', '', '', 165, 0),
('Quỳnh Phi', '2a22ce962d2692274d7d35f53016aba3', 'Quỳnh Phi', '', '', 0, 0),
('tamami', 'c74e48c2ecd5f49f8702f4d123f4520c', 'tamami', '', '', 0, 0),
('Thang Viên Hảo Viên', 'd779c886c12028be0f4ab5cd994c02f3', 'Thang Viên Hảo Viên', '', '', 25, 0),
('Thanh Y Thành Bạch', '6c91bbcc2fb6fe721654822cb8e8e9d1', 'Thanh Y Thành Bạch', '', '', 20, 0),
('Thời Tinh Thảo', 'caa4c5c1c229d558fd4be721d2f6cc3c', 'Thời Tinh Thảo', '', '', 15, 0),
('Thu Lăng', '35857aaf7418c22bc199acf932e14e91', 'Thu Lăng', '', '', 20, 0),
('Tiêu Tương', 'df7dda7050aac886c425a039b385d14d', 'Tiêu Tương', '', '', 120, 0),
('Trạm Rác', '3aa0a901ceade0cdaaa8297e9fc30156', 'Trạm Rác', '', '', 20, 0),
('Trúc Diệc Tâm', 'abbaeca19ee649489f07ddd5bceae834', 'Trúc Diệc Tâm', '', '', 20, 0),
('Trúc Mễ', '10df8a7a5bc462226c1a9c620ca9453b', 'Trúc Mễ', '', '', 45, 0),
('Úy Không', 'f7d16425d1d42dbe6a7ef12eaa9bdfc0', 'Úy Không', '', '', 5, 0),
('vbn', '8bbc2b904d0f41c51ae92c2268935b03', 'vbn', '', '', 0, 0),
('vo nguyen', '06c42f2a6d0e0cfcf5f111da7ce9a2f2', 'vo nguyen', '', '', 0, 0),
('Đại Hạ', 'd9103da91d94b4ae7d4776722dd96258', 'Đại Hạ', '', '', 0, 0),
('Đậu Lê Mai Linh', 'a449f9ebd7e642dd40bc44657dad31bb', 'Đậu Lê Mai Linh', '', '', 20, 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `the_loai_sach`
--

CREATE TABLE `the_loai_sach` (
  `ma_loai` char(7) NOT NULL,
  `ten_loai` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `the_loai_sach`
--

INSERT INTO `the_loai_sach` (`ma_loai`, `ten_loai`) VALUES
('TL1', 'Ngôn tình'),
('TL2', 'Kiếm hiệp'),
('TL3', 'Tiên hiệp'),
('TL4', 'Trinh thám'),
('TL5', 'Kinh dị'),
('TL6', 'Nam sinh'),
('TL7', 'Tuổi học trò'),
('TL8', 'Truyện ngắn'),
('TL9', 'Phá án');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `the_nap`
--

CREATE TABLE `the_nap` (
  `id_the` int(11) NOT NULL,
  `seri_the` char(13) NOT NULL,
  `ma_the` char(15) NOT NULL,
  `menh_gia` int(11) NOT NULL,
  `loai_the` char(12) NOT NULL,
  `trang_thai_the` varchar(20) NOT NULL,
  `ma_thanh_vien` char(20) NOT NULL,
  `ngay_nap` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `the_nap`
--

INSERT INTO `the_nap` (`id_the`, `seri_the`, `ma_the`, `menh_gia`, `loai_the`, `trang_thai_the`, `ma_thanh_vien`, `ngay_nap`) VALUES
(3, '1234567', '12345678', 50000, 'mobi', 'Hoàn thành', '1234', '2020-12-13 07:38:13'),
(37, '1000439642208', '719088993440924', 10000, 'viettel', 'Hoàn thành', ' A Thuần', '2020-12-23 17:34:27'),
(38, '58480344918', '0571646383752', 20000, 'viettel', 'Hoàn thành', 'Thang Viên Hảo Viên', '2020-12-23 17:53:48'),
(39, '1000440302199', '613575701325376', 20000, 'viettel', 'Hoàn thành', 'Nguyễn Trà', '2020-12-24 11:05:31'),
(40, '1000363144104', '710194055367302', 10000, 'viettel', 'Thẻ lỗi', 'Nguyễn Trà', '2020-12-24 11:17:07'),
(41, '1000373233864', '914377370961688', 10000, 'viettel', 'Thẻ lỗi', 'Nguyễn Trà', '2020-12-24 11:17:26'),
(42, '1000363092308', '910568209742906', 10000, 'mobi', 'Hoàn thành', 'Trạm Rác', '2020-12-24 11:46:44'),
(43, '1000442854633', '110719905962265', 20000, 'viettel', 'Hoàn thành', 'Phù Ngư', '2020-12-24 15:38:31'),
(44, '1000417993138', '112038622320081', 50000, 'viettel', 'Hoàn thành', 'Phù Ngư', '2020-12-24 15:38:50'),
(45, '1000417993138', '313331696328254', 10000, 'mobi', 'Hoàn thành', 'Thanh Y Thành Bạch', '2020-12-24 15:39:46'),
(46, '1000417240977', '516298994652076', 10000, 'vina', 'Hoàn thành', 'Thu Lăng', '2020-12-24 15:40:24'),
(47, '1000417240978', '414261963958284', 10000, 'viettel', 'Thẻ lỗi', 'Hân Hân Hướng Vinh', '2020-12-24 15:44:04'),
(48, '1000363111361', '311287522194402', 10000, 'viettel', 'Hoàn thành', 'Hân Hân Hướng Vinh', '2020-12-24 15:44:26'),
(49, '1000415613695', '418078512122876', 10000, 'vina', 'Hoàn thành', 'Hân Hân Hướng Vinh', '2020-12-24 15:44:47'),
(50, '1000417240978', '414261963958284', 20000, 'viettel', 'Hoàn thành', 'Giáp Dã', '2020-12-25 13:45:37'),
(51, '1000363111361', '311287522194402', 10000, 'vina', 'Hoàn thành', 'Lacus Clyne', '2020-12-25 13:46:29'),
(52, '1000415613695', '418078512122876', 10000, 'mobi', 'Thẻ lỗi', 'Niên Tiểu Hoa', '2020-12-25 13:47:32'),
(53, '1000415613695', '318957169534062', 50000, 'mobi', 'Hoàn thành', 'Tiêu Tương', '2020-12-25 13:48:27'),
(54, '1000415613695', '815845887625676', 20000, 'viettel', 'Thẻ lỗi', 'Đại Hạ', '2020-12-25 13:49:15'),
(55, '1000415613695', '618907735724542', 20000, 'mobi', 'Hoàn thành', 'ngốc9518', '2020-12-25 13:50:01'),
(56, '1000422741375', '318227847271068', 10000, 'mobi', 'Thẻ lỗi', 'vo nguyen', '2020-12-25 13:50:46'),
(57, '1000482083243', '019838049531601', 20000, 'mobi', 'Hoàn thành', 'lilivi', '2020-12-25 13:51:37'),
(58, '1000413950785', '416695279595526', 10000, 'vina', 'Hoàn thành', 'Trúc Diệc Tâm', '2020-12-25 13:52:45'),
(59, '1000363091574', '110877887014272', 10000, 'viettel', 'Hoàn thành', 'Úy Không', '2020-12-25 13:53:20'),
(60, '1000415393178', '612578339930584', 20000, 'viettel', 'Hoàn thành', 'Nguyệt Hạ Điệp Ảnh', '2020-12-25 13:58:19'),
(61, '1000415393178', '810137312514952', 20000, 'mobi', 'Thẻ lỗi', 'Quỳnh Phi', '2020-12-25 14:05:10'),
(62, '0153379330218', '10004153943250', 10000, 'viettel', 'Hoàn thành', 'Thời Tinh Thảo', '2020-12-25 14:05:45'),
(63, '1000416823270', '217869893532495', 50000, 'viettel', 'Hoàn thành', 'Hà Thư', '2020-12-25 14:08:15'),
(64, '1000415393178', '017238528000131', 100000, 'mobi', 'Hoàn thành', 'Phù Hoa', '2020-12-25 14:10:48'),
(65, '1000342174129', '515968455622886', 10000, 'viettel', 'Hoàn thành', ' Nguyễn Jordan', '2020-12-26 05:32:14'),
(66, '1000358170501', '710235252655796', 20000, 'viettel', 'Hoàn thành', 'Luyến ★ Luyến', '2020-12-26 05:35:02'),
(67, '1000358170501', '714778507180084', 10000, 'viettel', 'Thẻ lỗi', 'D4C', '2020-12-26 05:38:48'),
(68, '1000336834622', '712903365323508', 20000, 'viettel', 'Hoàn thành', 'D4C', '2020-12-26 05:39:50'),
(69, '1000360294546', '816885059825006', 10000, 'mobi', 'Hoàn thành', 'JQ Vạn Niên Khanh', '2020-12-26 05:43:07'),
(70, '1000340772588', '819707593461798', 10000, 'viettel', 'Hoàn thành', 'Đậu Lê Mai Linh', '2020-12-26 05:44:50'),
(71, '1000342174129', '312547106104902', 20000, 'viettel', 'Hoàn thành', 'Trúc Mễ', '2020-12-26 05:45:27'),
(72, '1000335470983', '618828358462266', 10000, 'vina', 'Hoàn thành', 'Miên Miên Mị', '2020-12-26 05:46:17'),
(73, '1000406273280', '511141482978564', 10000, 'viettel', 'Thẻ lỗi', 'camtu', '2020-12-26 05:50:06'),
(74, '1000413112735', '315837236486062', 10000, 'mobi', 'Hoàn thành', 'camtu', '2020-12-26 05:50:23'),
(75, '1000362200867', '116978372063154', 10000, 'mobi', 'Đang xử lí', 'camtu', '2020-12-26 05:50:39');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `binh_luan`
--
ALTER TABLE `binh_luan`
  ADD PRIMARY KEY (`ma_binh_luan`),
  ADD KEY `fk_thanh_vien_binh_luan` (`ma_thanh_vien`),
  ADD KEY `fk_sach_binh_luan` (`ma_sach`);

--
-- Chỉ mục cho bảng `danh_gia`
--
ALTER TABLE `danh_gia`
  ADD PRIMARY KEY (`ma_thanh_vien`,`ma_sach`),
  ADD KEY `fk_sach_dg` (`ma_sach`);

--
-- Chỉ mục cho bảng `gio_hang`
--
ALTER TABLE `gio_hang`
  ADD PRIMARY KEY (`ma_giao_dich`),
  ADD KEY `fk_thanh_vien_gio_hang` (`ma_thanh_vien`),
  ADD KEY `fk_sach_gio_hang` (`ma_sach`);

--
-- Chỉ mục cho bảng `luot_doc`
--
ALTER TABLE `luot_doc`
  ADD PRIMARY KEY (`ma_luot`),
  ADD KEY `fk_sach_ld` (`ma_sach`);

--
-- Chỉ mục cho bảng `noi_dung_sach`
--
ALTER TABLE `noi_dung_sach`
  ADD PRIMARY KEY (`ma_chuong`),
  ADD KEY `fk_ma_sach` (`ma_sach`);

--
-- Chỉ mục cho bảng `sach`
--
ALTER TABLE `sach`
  ADD PRIMARY KEY (`ma_sach`),
  ADD KEY `fk_ma_tac_gia` (`ma_tac_gia`);

--
-- Chỉ mục cho bảng `tac_gia`
--
ALTER TABLE `tac_gia`
  ADD PRIMARY KEY (`ma_tac_gia`);

--
-- Chỉ mục cho bảng `tag_sach`
--
ALTER TABLE `tag_sach`
  ADD PRIMARY KEY (`ma_sach`,`ma_loai`),
  ADD KEY `fk_maloai` (`ma_loai`);

--
-- Chỉ mục cho bảng `thanh_vien`
--
ALTER TABLE `thanh_vien`
  ADD PRIMARY KEY (`ma_thanh_vien`);

--
-- Chỉ mục cho bảng `the_loai_sach`
--
ALTER TABLE `the_loai_sach`
  ADD PRIMARY KEY (`ma_loai`);

--
-- Chỉ mục cho bảng `the_nap`
--
ALTER TABLE `the_nap`
  ADD PRIMARY KEY (`id_the`),
  ADD KEY `fk_naptv` (`ma_thanh_vien`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `binh_luan`
--
ALTER TABLE `binh_luan`
  MODIFY `ma_binh_luan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT cho bảng `gio_hang`
--
ALTER TABLE `gio_hang`
  MODIFY `ma_giao_dich` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=196;

--
-- AUTO_INCREMENT cho bảng `luot_doc`
--
ALTER TABLE `luot_doc`
  MODIFY `ma_luot` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=333;

--
-- AUTO_INCREMENT cho bảng `noi_dung_sach`
--
ALTER TABLE `noi_dung_sach`
  MODIFY `ma_chuong` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- AUTO_INCREMENT cho bảng `the_nap`
--
ALTER TABLE `the_nap`
  MODIFY `id_the` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `binh_luan`
--
ALTER TABLE `binh_luan`
  ADD CONSTRAINT `fk_sach_binh_luan` FOREIGN KEY (`ma_sach`) REFERENCES `sach` (`ma_sach`),
  ADD CONSTRAINT `fk_thanh_vien_binh_luan` FOREIGN KEY (`ma_thanh_vien`) REFERENCES `thanh_vien` (`ma_thanh_vien`);

--
-- Các ràng buộc cho bảng `danh_gia`
--
ALTER TABLE `danh_gia`
  ADD CONSTRAINT `fk_sach_dg` FOREIGN KEY (`ma_sach`) REFERENCES `sach` (`ma_sach`),
  ADD CONSTRAINT `fk_tv` FOREIGN KEY (`ma_thanh_vien`) REFERENCES `thanh_vien` (`ma_thanh_vien`);

--
-- Các ràng buộc cho bảng `gio_hang`
--
ALTER TABLE `gio_hang`
  ADD CONSTRAINT `fk_sach_gio_hang` FOREIGN KEY (`ma_sach`) REFERENCES `sach` (`ma_sach`),
  ADD CONSTRAINT `fk_thanh_vien_gio_hang` FOREIGN KEY (`ma_thanh_vien`) REFERENCES `thanh_vien` (`ma_thanh_vien`);

--
-- Các ràng buộc cho bảng `luot_doc`
--
ALTER TABLE `luot_doc`
  ADD CONSTRAINT `fk_sach_ld` FOREIGN KEY (`ma_sach`) REFERENCES `sach` (`ma_sach`);

--
-- Các ràng buộc cho bảng `noi_dung_sach`
--
ALTER TABLE `noi_dung_sach`
  ADD CONSTRAINT `fk_ma_sach` FOREIGN KEY (`ma_sach`) REFERENCES `sach` (`ma_sach`);

--
-- Các ràng buộc cho bảng `sach`
--
ALTER TABLE `sach`
  ADD CONSTRAINT `fk_ma_tac_gia` FOREIGN KEY (`ma_tac_gia`) REFERENCES `tac_gia` (`ma_tac_gia`);

--
-- Các ràng buộc cho bảng `tag_sach`
--
ALTER TABLE `tag_sach`
  ADD CONSTRAINT `fk_maloai` FOREIGN KEY (`ma_loai`) REFERENCES `the_loai_sach` (`ma_loai`),
  ADD CONSTRAINT `fk_masach` FOREIGN KEY (`ma_sach`) REFERENCES `sach` (`ma_sach`);

--
-- Các ràng buộc cho bảng `the_nap`
--
ALTER TABLE `the_nap`
  ADD CONSTRAINT `fk_naptv` FOREIGN KEY (`ma_thanh_vien`) REFERENCES `thanh_vien` (`ma_thanh_vien`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
