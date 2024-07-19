-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 28, 2021 at 12:32 PM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `quanlyxemphim_v3`
--

-- --------------------------------------------------------
DROP DATABASE IF EXISTS `quanlyxemphim`;
CREATE DATABASE `quanlyxemphim` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `quanlyxemphim`;
--
-- Table structure for table `binhluan`
--

CREATE TABLE `binhluan` (
  `MaBinhLuan` int(11) NOT NULL,
  `MaPhim` varchar(50) NOT NULL,
  `MaNguoiDung` int(11) NOT NULL,
  `BinhLuan` varchar(1000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `binhluan`
--

INSERT INTO `binhluan` (`MaBinhLuan`, `MaPhim`, `MaNguoiDung`, `BinhLuan`) VALUES
(1, 'MP0001', 2, 'Bộ này hay quá'),
(2, 'MP0002', 2, 'Bộ này hay quá luôn'),
(4, 'MP0006', 2, 'Đỉnh'),
(5, 'MP0007', 1, 'Tuyệt vời'),
(6, 'MP0007', 1, 'Quá hay'),
(7, 'MP0008', 2, 'Quá đỉnh'),
(21, 'MP0010', 1, 'Hay quá'),
(22, 'MP0010', 1, 'Quá hay'),
(23, 'MP0010', 1, 'Quá hay'),
(24, 'MP0002', 1, 'Hay'),
(25, 'MP0002', 1, 'Đỉnh'),
(32, 'MP0006', 1, '44'),
(33, 'MP0006', 1, '44'),
(34, 'MP0011', 1, 'Hay'),
(35, 'MP0011', 1, 'Quá hay'),
(36, 'MP0010', 1, 'Hay'),
(37, 'MP0010', 2, 'Alo 123'),
(38, 'MP0010', 3, 'Alo 234'),
(39, 'MP0006', 2, 'Hay quá'),
(40, 'MP0007', 2, 'Hay quá'),
(41, 'MP0008', 2, 'Đỉnh quá'),
(42, 'MP0033', 2, 'Hay'),
(43, 'MP0010', 1, 'Hay'),
(44, 'MP0012', 1, 'Cuốn quá'),
(45, 'MP0006', 4, 'Hay'),
(46, 'MP0007', 1, 'Hay ghê'),
(47, 'MP0007', 1, 'Hay quá đi'),
(48, 'MP0007', 2, 'Đỉnh cao'),
(49, 'MP0006', 1, 'Hay ha');

-- --------------------------------------------------------

--
-- Table structure for table `lichsu`
--

CREATE TABLE `lichsu` (
  `MaLichSu` int(11) NOT NULL,
  `MaTapPhim` varchar(50) NOT NULL,
  `MaNguoiDung` int(11) NOT NULL,
  `ThoiGianXem` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `lichsu`
--

INSERT INTO `lichsu` (`MaLichSu`, `MaTapPhim`, `MaNguoiDung`, `ThoiGianXem`) VALUES
(1, 'P06T002', 1, '2021-10-27 15:57:27'),
(3, 'P07T001', 2, '2021-10-27 16:09:21'),
(4, 'P07T002', 2, '2021-10-27 16:09:32'),
(5, 'P06T002', 2, '2021-10-27 16:10:13'),
(6, 'P06T001', 1, '2021-10-27 16:10:38'),
(7, 'P08T001', 1, '2021-10-27 16:14:58'),
(8, 'P10T002', 1, '2021-10-27 16:15:27'),
(9, 'P07T001', 1, '2021-10-28 14:19:03'),
(10, 'P35T003', 1, '2021-10-28 17:26:59'),
(11, 'P35T002', 1, '2021-10-28 17:30:02'),
(12, 'P01T003', 1, '2021-10-28 17:31:30');

-- --------------------------------------------------------

--
-- Table structure for table `nguoidung`
--

CREATE TABLE `nguoidung` (
  `MaNguoiDung` int(11) NOT NULL,
  `TaiKhoan` varchar(24) NOT NULL,
  `MatKhau` varchar(24) NOT NULL,
  `Admin` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `nguoidung`
--

INSERT INTO `nguoidung` (`MaNguoiDung`, `TaiKhoan`, `MatKhau`, `Admin`) VALUES
(1, 'nvliem', '12345678', 0),
(2, 'vbtoan', '123456', 0),
(3, 'lhphuoc', '123123', 0),
(4, 'ndtin', '123456', 0),
(5, 'admin', 'admin123', 1);

-- --------------------------------------------------------

--
-- Table structure for table `phim`
--

CREATE TABLE `phim` (
  `MaPhim` varchar(50) NOT NULL,
  `TenPhim` varchar(100) NOT NULL,
  `MoTa` varchar(1000) DEFAULT NULL,
  `TrangThai` varchar(50) DEFAULT NULL,
  `Diem` float NOT NULL DEFAULT 0,
  `PhatHanh` int(4) DEFAULT NULL,
  `ThoiLuong` int(11) DEFAULT NULL,
  `LuotXem` int(11) DEFAULT 0,
  `LuotDanhGia` int(11) NOT NULL DEFAULT 0,
  `ThoiGianThemPhim` datetime NOT NULL DEFAULT current_timestamp(),
  `Poster` varchar(100) NOT NULL,
  `KieuPhim` bit(1) NOT NULL,
  `MaQG` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `phim`
--

INSERT INTO `phim` (`MaPhim`, `TenPhim`, `MoTa`, `TrangThai`, `Diem`, `PhatHanh`, `ThoiLuong`, `LuotXem`, `LuotDanhGia`, `ThoiGianThemPhim`, `Poster`, `KieuPhim`, `MaQG`) VALUES
('MP0001', 'Wotaku ni Koi wa Muzukashii', 'Câu chuyện hài hước giữa một anh chàng Otaku Gaming và một cô nàng Fujoshi thích truyện tranh', 'Đã chiếu', 9.5, 2018, 30, 17, 2, '2021-10-24 20:06:22', 'Wotaku ni Koi wa Muzukashii.jpg', b'0', 1),
('MP0002', 'Tensei shitara Slime Datta Ken', 'Một anh chàng bị tên cướp đâm chết khi đi gặp đồng nghiệp cùng vợ chưa cưới của cậu ta. Khi đang thoi thóp trước khi chết, người đầy máu, anh ta nghe được một tiếng nói kỳ lạ. Giọng nói ấy chuyển thể sự tiếc nuối của anh chàng vì vẫn còn tân trước khi đi và ban cho anh ta chiêu thức đặc biệt [tiên nhân vĩ đại]. Liệu đây có phải là trò đùa?', 'Đã chiếu', 0, 2018, 15, 3, 0, '2021-10-24 20:06:22', 'Tensei shitara Slime Datta Ke.jpg', b'0', 1),
('MP0003', 'Sword Art Online', 'Con đường sống duy nhất là đánh bại mọi kẻ thù. Cái chết trong game đồng nghĩa với cái chết ngoài đời thực---- Bằng Nerve Gear, mười ngàn con người lao đầu vào một trò chơi bí ẩn \\\'Sword Art Online\\\', để rồi bị giam cầm trong đó, buộc phải dấn thân vào một đấu trường sinh tử. Anh main của chúng ta, Kirito, một trong số các game thủ, đã nhận ra được \\\'sự thật\\\' khủng khiếp này. Anh đơn thương độc mã, chiến đấu trong một lâu đài bay khổng lồ --- mang tên \\\'Aincrad\\\' Để có thể hoàn thành trò chơi và trở về với thực tại, anh phải vượt qua đủ 100 thử thách. Liệu anh có thể làm được hay anh sẽ về với cát bụi? Cứ xem thì biết', 'Đã chiếu', 0, 2013, 30, 0, 0, '2021-10-24 20:16:21', 'Sword Art Online.jpg', b'0', 1),
('MP0004', 'Shigatsu wa Kimi no Uso', 'Câu chuyện kể về Arima Kousei, một thần đồng piano. Nhưng kể từ sau chấn động tâm lí do cái sự qua đời của mẹ cậu, Kosei đã không thể nghe thấy bất kì âm thanh nào. Cứ tưởng là cậu sẽ không bao giờ động vào những phím piano nữa nhưng đó là trước khi cậu đã gặp Miyazono Kaori...', 'Đã chiếu', 9.5, 2014, 5, 0, 2, '2021-10-24 20:16:21', 'Shigatsu wa Kimi no Uso.jpg', b'0', 1),
('MP0005', 'Saenai Heroine no Sodatekata', 'Saenai Heroine no Sodatekata | Saekano: How to Raise a Boring Girlfriend | Saenai Kanojo no Sodate-kata là anime nói về một thằng otaku (Tomoyo Aki), đi làm thêm để tích tiền mua BD anime. Vào một dịp tình cờ, cậu gặp được một em xinh tươi (Megumi Kato) trên đường về nhà và cuộc sống của cậu bắt đầu đảo lộn… Đảo lộn ra sao thì coi rồi biết…!​', 'Đã chiếu', 0, 2015, 10, 0, 0, '2021-10-24 20:18:02', 'Saenai Heroine no Sodatekata.jpg', b'0', 1),
('MP0006', 'The Veil - Mặt trời đen', 'Mặt Trời Đen - The Veil xoay quanh câu chuyện về một đặc vụ hàng đầu của Cơ quan Tình báo Quốc gia (NIS) - Han Ji Hyuk. Anh được các đồng nghiệp kính nể vì thành tích hoàn hảo và khả năng hoàn thành nhiệm vụ. Sau khoảng thời gian biến mất một cách bí hiểm, anh trở lại một năm sau đó để gây chấn động tổ chức một lần nữa. Bên cạnh Han Ji Hyuk, Seo Soo Yeon là đội trưởng đội 4 của Trung tâm thông tin tội phạm - người rất xuất sắc trong việc thực hiện nhiệm vụ và giải quyết các vụ án. Cô là người sống vô cùng tình cảm và luôn quan tâm đến mọi người, đặc biệt là đồng đội của mình.', 'Đang chiếu', 8.89, 2021, 12, 82, 18, '2021-10-24 20:22:08', 'theveil_poster.jpg', b'0', 2),
('MP0007', 'Vincenzo', 'Năm 8 tuổi, Park Joo-Hyeong đến Ý sau khi anh được nhận làm con nuôi. Bây giờ anh ấy đã trưởng thành và có tên là Vincenzo Casano. Anh ta là một luật sư, người làm việc cho Mafia với tư cách là người gửi hàng. Vì một cuộc chiến tranh giữa các nhóm mafia, anh ta trốn đến Hàn Quốc. Ở Hàn Quốc, anh ấy có quan hệ với Luật sư Hong Cha-Young. Cô ấy là kiểu luật sư sẽ làm mọi cách để thắng kiện. Vincenzo Casano phải lòng cô ấy. Anh ta cũng đạt được công bằng xã hội bằng cách của mình. Jang Jun-woo là một thực tập sinh năm nhất thông minh và chăm chỉ tại một công ty luật. Anh ấy xuất thân từ một gia đình trung lưu, lịch sự và chân thành. Mặc dù có vẻ ngoài điển trai và vẻ ngoài điển trai nhưng Jun-woo lại hơi vụng về và ngây thơ và thường mắc lỗi trong công việc khiến anh ấy gặp rắc rối.', 'Đã chiếu', 8.7, 2021, 20, 39, 13, '2021-10-24 20:22:08', 'vincenzo.jpg', b'0', 2),
('MP0008', 'Avengers: Endgame', 'Avengers: Hồi kết (tên gốc tiếng Anh: Avengers: Endgame) là phim điện ảnh siêu anh hùng Mỹ ra mắt năm 2019, do Marvel Studios sản xuất và Walt Disney Studios Motion Pictures phân phối. Tác phẩm là phần thứ tư của loạt phim Avengers, sau Biệt đội siêu anh hùng (2012), Avengers: Đế chế Ultron (2015) và Avengers: Cuộc chiến vô cực (2018), đồng thời cũng là phim điện ảnh thứ 22 của Vũ trụ Điện ảnh Marvel (MCU). Trong phim, các thành viên còn sống sót của nhóm Avengers cùng các đồng minh hợp tác với nhau để đảo ngược những hậu quả mà Thanos đã gây ra trong Avengers: Cuộc chiến vô cực.', 'Đã chiếu', 9.25, 2019, 181, 3, 8, '2021-10-24 20:28:45', 'endgame_poster.jpg', b'1', 3),
('MP0009', 'Avengers: Infinity War', 'Avengers: Cuộc chiến vô cực (tựa gốc tiếng Anh: Avengers: Infinity War) là một bộ phim điện ảnh đề tài siêu anh hùng của Mỹ năm 2018 dựa trên biệt đội siêu anh hùng Avengers của Marvel Comics. Phim do Marvel Studios sản xuất và Walt Disney Studios Motion Pictures chịu trách nhiệm phân phối, là phần phim tiếp theo của Biệt đội siêu anh hùng (2012) và Avengers: Đế chế Ultron (2015), đồng thời cũng là phim điện ảnh thứ 19 trong loạt phim điện ảnh thuộc Vũ trụ Điện ảnh Marvel (MCU). Trong Avengers: Cuộc chiến vô cực, Biệt đội Avengers hợp tác với nhóm Vệ binh dải Ngân Hà để ngăn chặn Thanos khỏi việc thu thập đầy đủ 6 Viên đá Vô cực và hủy diệt một nửa số sinh vật trong vũ trụ.', 'Đã chiếu', 0, 2018, 149, 0, 0, '2021-10-24 20:28:45', 'infinitywar_poster.jpg', b'1', 3),
('MP0010', 'Jirisan', '“Nơi giao thoa giữa thế giới này và thế giới ngầm”. “Công việc của chúng tôi là sống sót và trở về từ những nơi nguy hiểm”. Sự tương phản của hai tone màu lạnh và nóng, sắc kì bí trong những câu nói đầy hàm ý, liệu Jirisan sẽ mang đến những gì? Tuy nóng lạnh đối lập nhưng đều gợi lên cảm giác khắc nghiệt - sự khắc nghiệt và nguy hiểm này là của thiên nhiên hay lòng người? ', 'Mới chiếu', 7.57, 2021, 16, 22, 19, '2021-10-24 20:35:42', 'jirisan_poster.jpg', b'0', 2),
('MP0011', 'Loki', 'Trong Avengers: Endgame, nhóm Avengers du hành thời gian ngược về New York năm 2012 “mượn” viên đá vô cực một chút thì vô tình gặp phải tai nạn nằm ngoài dự kiến. Không may trong sự cố đó, khối Tesseract rơi vào tay của Loki (2012). Hắn nhanh trí nhặt lên, dịch chuyển vào không gian và rơi xuống sa mạc ở Mông Cổ (một cảnh tượng nhắc lại Iron Man phần 1). Tại đây Loki cố truyền đạt bằng tiếng Anh với người bản xứ rằng anh là một vị thần và họ phải tôn sùng anh, nhưng chưa kịp truyền giáo xong thì TVA (Time Variance Authority) đã xuất hiện gông cổ anh lại vì hành động của Loki là một biến thể ảnh hưởng đến Sacred Timeline, anh bị bắt giữ mang về trụ sở...', 'Đã chiếu', 9, 2021, 8, 0, 1, '2021-10-24 20:35:42', 'loki_poster.jpg', b'0', 3),
('MP0012', 'My Name', 'My Name là bộ phim hành động xã hội đen của Hàn Quốc vừa được Netflix tung ra, dán nhãn 18+. Phim kể về hành trình báo thù của Ji Woo (Han So Hee đóng) cho cái chết thương tâm của cha mình. Để truy sát kẻ giết cha, Ji Woo gia nhập tổ chức xã hội đen Dongcheon của ông trùm ma túy Choi Mu Jin (Park Hee-soon thủ vai) và trui rèn để trở thành một sát thủ. Khi được Choi Mu Jin cho biết kẻ giết hại cha là cảnh sát, Ji Woo thay đổi danh tính thành Oh Hye Jin và hoạt động “nằm vùng” trong lực lượng cảnh sát chống tội phạm ma túy. Từ đây, tấm màn bí mật trong quá khứ của cha cô dần được vén lên, đưa đẩy Ji Woo vào hành trình báo thù đẫm máu và không thể quay đầu.', 'Đã chiếu', 9.29, 2021, 8, 4, 7, '2021-10-24 20:40:32', 'myname_poster.jpg', b'0', 2),
('MP0013', 'Spiderman: Far From Home', 'Peter Parker và bạn bè của mình tham gia vào chuyến du lịch hè đến châu Âu. Nhưng nhóm bạn khó lòng có thể nghỉ ngơi – Peter sẽ phải đồng ý giúp Nick Fury khám phá ra bí ẩn của những sinh vật gây ra các thảm họa tự nhiên và sự hủy diệt trên khắp thế giới.” Mảnh thông tin quan trọng nhất chính là xác nhận Peter thực sự làm việc với Fury. Trước đây người hâm mộ từng đặt giả thiết rằng bộ trang phục bí mật mới của Spidey là do Fury đưa cho, và có vẻ như điều đó đang trở nên chính xác. Mặc dù vậy, không có bất kì mối liên hệ nào giữa S.H.I.E.L.D. và bộ đồ trong bức ảnh đầu tiên về nó. Các chi tiết bổ sung cùng với những cảnh quay có thể xác nhận điều này, trong khi phần còn lại của bản tóm tắt tập trung vào những gì cả hai đang làm.', 'Đã chiếu', 0, 2019, 160, 0, 0, '2021-10-24 20:40:32', 'spiderman_frh_poster.jpg', b'1', 3),
('MP0014', 'Squidgame: Trò chơi con mực', 'Squidgame nói về một nhóm người bị ném vào một đấu trường ”nhân tạo’’, nơi họ phải chiến đấu để giành lấy mạng sống của mình. Trong loạt phim mới của Netflix, đấu trường là một khu phức hợp lớn, bí mật; cuộc thi là một loạt các trò chơi dành cho trẻ con; và 456 con người này đang rất cần số tiền thưởng lên tới 45,6 tỷ won (tương đương 39 triệu đô la) hơn cả sự an toàn của mạng sống – thứ mà có thể cũng mất đi nếu họ trở ra bên ngoài. ', 'Đã chiếu', 0, 2021, 9, 0, 0, '2021-10-24 20:46:58', 'squidgame_poster.jpg', b'0', 2),
('MP0015', 'Vagabond: Lãng khách', 'Lãng Khách - Vagabond là bộ phim hành động kể về hai nhân vật vô tình biết được được những “bí mật đen” của quốc gia. Trong phim, Suzy sẽ vào vai nữ chính Go Hae Ri, một nhân viên tình báo thuộc Cơ quan Tình báo quốc gia. Bố của Go Hae Ri là Go Kang Chul, một Trung úy của Thủy quân lục chiến. Sau khi bố qua đời, Go Hae Ri quyết định trở thành nhân viên công vụ cấp bảy để gánh trách nhiệm chăm lo cho mọi người trong gia đình. Trong khi đó, Lee Seung Gi sẽ vào vai Cha Gun, một diễn viên đóng thế, vì một sự cố hàng không mà anh đã vô tình phát hiện ra những sự thật không mấy hay ho và bị cuốn vào vòng xoáy bí ẩn của Cục tình báo quốc gia NIS.', 'Đã chiếu', 0, 2019, 16, 0, 0, '2021-10-24 20:46:58', 'vagabond_poster.jpg', b'0', 2),
('MP0016', 'Wanda - Vision', 'Lấy bối cảnh ba tuần sau các sự kiện của Avengers: Hồi Kết (2019), Wanda Maximoff và Vision đang sống một cuộc sống ngoại ô bình dị ở thị trấn Westview, cố gắng che giấu sức mạnh của họ. Khi họ bắt đầu bước vào những thập kỷ mới và gặp phải những trò lố trên truyền hình, cặp đôi nghi ngờ rằng mọi thứ không như họ tưởng tượng.', 'Đã chiếu', 0, 2021, 9, 0, 0, '2021-10-24 20:49:25', 'wandavision_poster.jpg', b'0', 3),
('MP0017', 'One Punch Man', 'Câu chuyện diễn ra tại thành phố Z của Nhật Bản tại thời điểm thế giới đầy những quái vật bí ẩn với sức mạnh ghê ghớm đã xuất hiện và gây ra biết bao nhiêu thảm họa. \r\nCâu chuyện sẽ tiếp diễn như thế nào? Mời các bạn theo dõi anime One Punch Man để cùng tham gia vào những cuộc phiêu lưu của Saitama, vị anh hùng với sức mạnh không tưởng nhé. ', 'Đã chiếu', 0, 2015, 12, 0, 0, '2021-10-26 09:58:21', 'One Punch Man.jpg', b'0', 1),
('MP0018', 'One Piece', 'Câu chuyện diễn ra tại thành phố Z của Nhật Bản tại thời điểm thế giới đầy những quái vật bí ẩn với sức mạnh ghê ghớm đã xuất hiện và gây ra biết bao nhiêu thảm họa. \r\nCâu chuyện sẽ tiếp diễn như thế nào? Mời các bạn theo dõi anime One Punch Man để cùng tham gia vào những cuộc phiêu lưu của Saitama, vị anh hùng với sức mạnh không tưởng nhé. ', 'Đã chiếu', 0, 2015, 10, 0, 0, '2021-10-26 09:59:58', 'One Piece.jpg', b'0', 1),
('MP0019', 'Nisekoi', 'Em sẽ giữ chìa, còn anh sẽ giữ ổ khóa. Sau này nếu mình được gặp lại nhau thì đây sẽ là thứ chúng ta dùng để nhận ra nhau, và khi đó, chúng ta sẽ... cưới nhau.\r\n\r\nTuổi thơ con người thật hồn nhiên và trong sáng, nhìn cảnh hai đứa trẻ mới tí tuổi đầu đã nói mấy lời đỡ không nổi như thế thật đáng yêu biết bao...\r\n\r\nCon người là thế... Ai cũng mong rằng mọi thứ sẽ có được một kết quả như những câu chuyện cổ tích...\r\n\r\nẤy thế mà\r\n\r\nCó những lúc sự thật lại không như con người mong muốn <<\r\n\r\nRồi cái ngày định mệnh, ngày hai đứa gặp lại, mọi chuyện sẽ ra sao? Hồi sau sẽ rõ', 'Đã chiếu', 0, 2013, 20, 0, 0, '2021-10-26 10:02:02', 'Nisekoi.jpg', b'0', 1),
('MP0020', 'Naruto', 'Kể về cuộc phưu lưu của Naruto chính là cậu bé đã may mắn sống xót trong một trận phong ba bão táp, tất cả mọi thứ đã ra đi chỉ còn duy nhất một mình cậu với cuộc phưu lưu đầy mạo hiểm, những cơn lốc xoáy và gió cát đã khiến cho biết bao nhiêu người bỏ mạng tại khu làng Lá, may mắn thay cậu đã được sư phụ của mình chính là người đã có nhiều quyền năng tối cao giúp đỡ, ai ai nghe sư phụ Jiraiya củng đều cảm thấy dường như Naruto thật mang mắn, cậu được sư phụ dạy và tập luyện nhiều loại sức mạnh chỉ có những cao thủ mới có thể lĩnh hội hết được.', 'Đã chiếu', 0, 2007, 10, 0, 0, '2021-10-26 10:02:02', 'Naruto.jpg', b'0', 1),
('MP0021', 'Masamune-kun no Revenge', 'Makabe Masamune khi còn nhỏ chỉ là một cậu bé \"heo con\" vô dụng và yếu đuối nhưng từ sau lần tỏ tình thất bại với Adagaki một cô bé xinh đẹp và thông minh, tuyệt vọng vì bị chế nhạo Makabe nỗ lực hết mình để thay đổi bản thân và vạch ra một kế hoạch hoàn hảo chỉ để trả thù cô gái đã từ chối mình, tám năm sau cậu đã trở thành một anh chàng đẹp trai và có thân hình cân đối như một người mẫu thực thụ, đỗ vào trường trung học mà Adagaki đang học với số điểm tuyệt đối, liệu cậu có thể trả thù được hay không, cùng theo dõi tiếp câu chuyện tình gay cấn này nào ...!?', 'Đã chiếu', 0, 2017, 12, 0, 0, '2021-10-26 10:03:17', 'Masamune-kun no Revenge.jpg', b'0', 1),
('MP0022', 'Love is war', 'Shirogane Miyuki và Shinomiya Kaguya là hai thành viên của Hội Học Sinh thuộc Học Viện Shuchiin cao quý dành cho các thiên tài và con cái nhà giàu có. Hai cô cậu này có một quy luật trong tình yêu, \"Ai yêu trước sẽ là người thua cuộc.\", và do đó chẳng ai dám thổ lộ với ai cả. Cách duy nhất để họ đến với nhau là ép đối phương tự tỏ tình với mình, và từ đó họ vạch ra nhiều thủ đoạn chơi khăm nhau, nhiều trò dở khóc dở cười để đạt được điều đó.', 'Đã chiếu', 0, 2019, 12, 0, 0, '2021-10-26 10:03:17', 'Love Is War.jpg', b'0', 1),
('MP0023', 'Love Is War 2', 'Phần 2 của Kaguya-sama wa Kokurasetai', 'Đã chiếu', 0, 2020, 12, 0, 0, '2021-10-26 10:04:24', 'Love Is War 2.jpg', b'0', 1),
('MP0024', 'Koe No Katachi', 'Khi gặp những người Khiếm thính hay khiếm thị các bạn sẽ đối xử với họ thế nào? - câu chuyện ở đây là về một cô bé khiếm thính và cuộc đời bất hạnh của cô cho đến khi cô gặp người ấy! - thể hiện tình trạng xã hội ngày nay một cách rất rõ nét qua ngòi bút của Ooima Yoshitoki!', 'Đã chiếu', 0, 2016, 130, 0, 0, '2021-10-26 10:04:24', 'Koe No Katachi.jpg', b'1', 1),
('MP0025', 'Kimetsu no Yaiba', 'Từ thời xưa luôn có những truyền thuyết về loài quỷ ăn thịt người rình mò trong các khu rừng khi màn đêm buông xuống. Chính điều này khiến người dân không ai dám vào rừng vào ban đêm. Tuy nhiên, Tanjiro, một cậu trai làm nghề bán củi than sống cùng gia đình trên núi lại không tin vào điều này, cậu quá bận rộn làm nuôi các anh em của mình. Nhưng rồi Tanjiro đã sớm phải tin vào những câu chuyện hảo huyền đó khi hiện thực cay nghiệt đến với cậu...', 'Đã chiếu', 0, 2019, 26, 0, 0, '2021-10-26 10:05:29', 'Kimetsu No Yaiba.jpg', b'0', 1),
('MP0026', 'Karakai Jouzu no Takagi-san', 'Một câu truyện kể về cuộc sống học đường thường nhật cũng một cô gái luôn chọc phá một cậu trai mới lớn.', 'Đã chiếu', 0, 2018, 12, 0, 0, '2021-10-26 10:05:29', 'Karakai Jouzu no Takagi-san.jpg', b'0', 1),
('MP0027', 'Karakai Jouzu no Takagi-san 2', 'Mùa thứ hai của Karakai Jouzu no Takagi-san .', 'Đã chiếu', 10, 2019, 12, 0, 1, '2021-10-26 10:06:34', 'Karakai Jouzu no Takagi-san 2.jpg', b'0', 1),
('MP0028', 'Kanojo, Okarishimasu', 'Kazuya 19 năm mới có bồ không bao lâu thì bị đá, thế là cậu ta phải sử dụng dịch vụ Hẹn hò Thuê, cứ trả xiền là ngày đó bạn sẽ có bạn gái ngay! Cậu ta đã thuê Mizuhara làm bạn gái mình, cô nàng thì cứ công việc (méo có yêu thương gì đâu) mà thả thính, còn chàng ta thì đớp thính vô tội vạ, cho đến khi… Đến khi Kazuya bớt sống ảo, cậu ta ngưng đớp thính và tự sẽ kiếm bạn gái thật cho mình thì mới hớ ra Mizuhara học cùng trường với mình, câu chuyện tình dở khóc dở cười này sẽ ra sao đây?', 'Đã chiếu', 0, 2020, 12, 0, 0, '2021-10-26 10:06:34', 'Kanojo, Okarishimasu.jpg', b'0', 1),
('MP0029', 'Gamers!', 'Gamers! là một romcom (hài hước - tình cảm) tập trung vào 5 nhân vật trong trường cao trung Otobuki. Năm con người đến với nhau bởi định mệnh trớ trêu thông qua... game. Họ \"quan tâm\" đến nhau, hành động \"vì người khác\" nhưng không hay biết rằng chính mình đang \"chôn\" những người khác... và \"chôn\" cả bản thân trong vô số hiểu nhầm dở khóc khó cười. Liệu họ có vượt qua được nghịch cảnh và có được điều mình muốn. Hãy cùng đến với câu chuyện về game (không chắc lắm về phần này) và cố nhịn cười trước sự ngớ ngẩn của năm con người kia.', 'Đã chiếu', 0, 2017, 12, 0, 0, '2021-10-26 10:08:50', 'Gamers!.jpg', b'0', 1),
('MP0030', 'Fairy Tail', 'Fairy Tail (Hội Pháp Sư) là một series truyện tranh Nhật Bản được sáng tác bởi tác giả Hiro Mashima. Truyện đã được phát hành thành từng kỳ trên tạp chí Weekly Shōnen từ ngày 23 tháng 8 năm 2006 và cho đến bây giờ vẫn đang được tiếp tục. Sau đó những chương truyện riêng được nhà xuất bản Kodansha tổng hợp và phát hành thành từng tập. Tính đến tháng 10 năm 2008, đã có 12 tập truyện Fairy Tail được phát hành. Xuyên suốt câu chuyện là cuộc phiêu lưu của một Sorceress tên là Lucy Heartphilia, sau khi cô tham gia vào hiệp hội hội Fairy Tail, cô đã cùng với Natsu Dragneel hành trình để đi tìm một con rồng tên là Igneel.', 'Đã chiếu', 0, 2014, 277, 0, 0, '2021-10-26 10:08:50', 'Fairy tail.jpg', b'0', 1),
('MP0031', 'Eromanga Sensei', '\"Bộ phim hài lãng mạn mới của anh chị em\" xoay quanh Masamune Izumi, tác giả tiểu thuyết nhẹ ở trường trung học. Em gái của Masamune là Sagiri, một cô gái đóng cửa, người đã không rời căn phòng của cô ấy suốt cả năm. Cô thậm chí buộc anh trai của cô phải làm và mang bữa ăn của cô khi cô stomps sàn. Masamune muốn em gái rời khỏi phòng của cô, bởi vì hai người trong số họ là gia đình duy nhất của nhau.', 'Đã chiếu', 0, 2017, 12, 0, 0, '2021-10-26 10:09:51', 'Eromanga Sensei.jpg', b'0', 1),
('MP0032', 'Dragon Ball Super', 'Dragon Ball Super (Tên gọi khác : Dragon Ball Chou, 7 viên ngọc rồng siêu cấp) là một anime truyền hình dài tập của Toei Animation bắt đầu phát sóng vào ngày 05 tháng 7 năm 2015. Đó là lần đầu tiên anime Dragon Ball được sản xuất sau 18 năm và bắt đầu sau sự thất bại của Majin Boo, hòa bình đến với Trái Đất một lần nữa. Nó được phát sóng vào ngày chủ nhật tại 9:00 trên Fuji TV.\r\n\r\nSeri phim sẽ bắt đầu từ cuộc chiến của Majin Buu Saga, sau đó sẽ tiếp đến câu chuyện của Dragon Ball Z - Battle of Gods và Sự hồi sinh của Frieza như vòng lập câu chuyện mới. Các phần tiếp theo của Dragon Ball Super (7 viên ngọc rồng siêu cấp) này sẽ diễn ra trong vũ trụ 6 với các chiến binh Z sẽ phải Siêu Ngọc Rồng mới.', 'Đã chiếu', 0, 2015, 131, 0, 0, '2021-10-26 10:09:51', 'Dragon Ball Super.jpg', b'0', 1),
('MP0033', 'Dragon Ball Kai', 'Một phiên bản chỉnh sửa lại của Dragon Ball Z và ít ngoại truyện hơn bám sát câu chuyện từ manga. Phiên bản này bao gồm thoại mới được ghi lại bởi các diễn viên ban đầu bằng giọng nói, hiệu ứng âm thanh mới, trình tự OP / ED mới', 'Đã chiếu', 9, 2009, 97, 0, 1, '2021-10-26 10:11:01', 'Dragon Ball Kai.jpg', b'0', 1),
('MP0034', 'Bokutachi no Remake', 'Hashiba Kyoya, một anh chàng cử nhân 28 tuổi đang bấp bênh trong cuộc sống do vẫn chưa tìm được chính mình. Anh tuy rất say mê được làm nghệ thuật nhưng lại chọn con đường làm một nhân viên văn phòng bình thường, chính điều này đã làm anh hối hận suốt một thời gian dài. Với mong ước duy nhất, Kyoya cầu mong mình được quay ngược về 10 năm trước, vào khoảng thời gian lựa chọn trường đại học với ước mơ làm lại được cuộc đời.', 'Đã chiếu', 0, 2021, 12, 1, 0, '2021-10-26 10:11:01', 'Bokutachi no Remake.jpg', b'0', 1),
('MP0035', 'Blend S', 'Sakura Nomiya là, theo bản chất, một người có vận xui và luôn bị dính vào rắc rối, nhưng cô biết Dino, một quản lý của quán cà phê. Nhưng không phải là quán cà phê thông thường, đó là quán cà phê mà các bồi bàn phải làm đúng theo \"bản chất thật\" của họ.', 'Đã chiếu', 0, 2017, 12, 9, 0, '2021-10-26 10:11:30', 'Blend S.jpg', b'0', 1);

-- --------------------------------------------------------

--
-- Table structure for table `phim_theloai`
--

CREATE TABLE `phim_theloai` (
  `MaPhim` varchar(50) NOT NULL,
  `MaTheLoai` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `phim_theloai`
--

INSERT INTO `phim_theloai` (`MaPhim`, `MaTheLoai`) VALUES
('MP0001', 'TL002'),
('MP0001', 'TL003'),
('MP0001', 'TL011'),
('MP0002', 'TL002'),
('MP0002', 'TL005'),
('MP0002', 'TL011'),
('MP0003', 'TL001'),
('MP0003', 'TL003'),
('MP0003', 'TL009'),
('MP0003', 'TL011'),
('MP0004', 'TL003'),
('MP0004', 'TL006'),
('MP0004', 'TL011'),
('MP0005', 'TL002'),
('MP0005', 'TL003'),
('MP0005', 'TL006'),
('MP0005', 'TL011'),
('MP0006', 'TL001'),
('MP0006', 'TL007'),
('MP0007', 'TL001'),
('MP0007', 'TL002'),
('MP0008', 'TL001'),
('MP0008', 'TL009'),
('MP0008', 'TL010'),
('MP0009', 'TL001'),
('MP0009', 'TL009'),
('MP0009', 'TL010'),
('MP0010', 'TL004'),
('MP0010', 'TL007'),
('MP0011', 'TL007'),
('MP0011', 'TL009'),
('MP0011', 'TL010'),
('MP0012', 'TL001'),
('MP0012', 'TL004'),
('MP0013', 'TL001'),
('MP0013', 'TL009'),
('MP0013', 'TL010'),
('MP0014', 'TL004'),
('MP0014', 'TL008'),
('MP0015', 'TL001'),
('MP0015', 'TL007'),
('MP0016', 'TL001'),
('MP0016', 'TL009'),
('MP0016', 'TL010'),
('MP0017', 'TL001'),
('MP0017', 'TL002'),
('MP0017', 'TL009'),
('MP0017', 'TL011'),
('MP0018', 'TL001'),
('MP0018', 'TL002'),
('MP0018', 'TL011'),
('MP0019', 'TL002'),
('MP0019', 'TL003'),
('MP0019', 'TL011'),
('MP0020', 'TL001'),
('MP0020', 'TL002'),
('MP0020', 'TL010'),
('MP0020', 'TL011'),
('MP0021', 'TL002'),
('MP0021', 'TL003'),
('MP0021', 'TL006'),
('MP0021', 'TL011'),
('MP0022', 'TL001'),
('MP0022', 'TL002'),
('MP0022', 'TL003'),
('MP0022', 'TL011'),
('MP0023', 'TL001'),
('MP0023', 'TL002'),
('MP0023', 'TL003'),
('MP0023', 'TL011'),
('MP0024', 'TL006'),
('MP0024', 'TL011'),
('MP0025', 'TL001'),
('MP0025', 'TL005'),
('MP0025', 'TL010'),
('MP0025', 'TL011'),
('MP0026', 'TL002'),
('MP0026', 'TL003'),
('MP0026', 'TL006'),
('MP0026', 'TL011'),
('MP0027', 'TL002'),
('MP0027', 'TL003'),
('MP0027', 'TL006'),
('MP0027', 'TL011'),
('MP0028', 'TL002'),
('MP0028', 'TL003'),
('MP0028', 'TL006'),
('MP0028', 'TL011'),
('MP0029', 'TL002'),
('MP0029', 'TL003'),
('MP0029', 'TL006'),
('MP0029', 'TL011'),
('MP0030', 'TL002'),
('MP0030', 'TL009'),
('MP0030', 'TL011'),
('MP0031', 'TL002'),
('MP0031', 'TL003'),
('MP0031', 'TL011'),
('MP0032', 'TL001'),
('MP0032', 'TL002'),
('MP0032', 'TL011'),
('MP0033', 'TL001'),
('MP0033', 'TL002'),
('MP0033', 'TL011'),
('MP0034', 'TL001'),
('MP0034', 'TL002'),
('MP0034', 'TL011'),
('MP0035', 'TL002'),
('MP0035', 'TL011');

-- --------------------------------------------------------

--
-- Table structure for table `quocgia`
--

CREATE TABLE `quocgia` (
  `MaQG` int(5) NOT NULL,
  `TenQG` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `quocgia`
--

INSERT INTO `quocgia` (`MaQG`, `TenQG`) VALUES
(1, 'Nhật Bản'),
(2, 'Hàn Quốc'),
(3, 'Âu - Mỹ'),
(4, 'Trung Quốc'),
(5, 'Thái Lan'),
(6, 'Việt Nam');

-- --------------------------------------------------------

--
-- Table structure for table `tapphim`
--

CREATE TABLE `tapphim` (
  `MaTapPhim` varchar(50) NOT NULL,
  `TapPhim` varchar(100) NOT NULL,
  `SoTap` varchar(20) DEFAULT NULL,
  `MaPhim` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tapphim`
--

INSERT INTO `tapphim` (`MaTapPhim`, `TapPhim`, `SoTap`, `MaPhim`) VALUES
('P01T001', 'Wotaku ni Koi wa Muzukashii Tap 1.mp4', '1', 'MP0001'),
('P01T002', 'Wotaku ni Koi wa Muzukashii Tap 2.mp4', '2', 'MP0001'),
('P01T003', 'Wotaku ni Koi wa Muzukashii Tap 3.mp4', 'đặc biệt', 'MP0001'),
('P02T001', 'Tensei shitara Slime Datta Ke Tap 1.mp4', '1', 'MP0002'),
('P02T002', 'Tensei shitara Slime Datta Ke Tap 2.mp4', '2', 'MP0002'),
('P02T003', 'Tensei shitara Slime Datta Ke Tap 3.mp4', '3', 'MP0002'),
('P03T001', 'Sword Art Online Tap 1.mp4', '1', 'MP0003'),
('P03T002', 'Sword Art Online Tap 2.mp4', '2', 'MP0003'),
('P03T003', 'Sword Art Online Tap 3.mp4', 'đặc biệt', 'MP0003'),
('P04T001', 'Shigatsu wa Kimi no Uso Tap 1.mp4', '1', 'MP0004'),
('P04T002', 'Shigatsu wa Kimi no Uso Tap 2.mp4', '2', 'MP0004'),
('P04T003', 'Shigatsu wa Kimi no Uso Tap 3.mp4', '3', 'MP0004'),
('P05T001', 'Saenai Heroine no Sodatekata Tap 1.mp4', '1', 'MP0005'),
('P05T002', 'Saenai Heroine no Sodatekata Tap 2.mp4', '2', 'MP0005'),
('P05T003', 'Saenai Heroine no Sodatekata Tap 3.mp4', '3', 'MP0005'),
('P06T001', 'theveil_tap1.mp4', '1', 'MP0006'),
('P06T002', 'theveil_tap2.mp4', '2', 'MP0006'),
('P07T001', 'vincenzo_tap1.mp4', '1', 'MP0007'),
('P07T002', 'vincenzo_tap2.mp4', '2', 'MP0007'),
('P08T001', 'endgame.mp4', NULL, 'MP0008'),
('P09T001', 'infinitywar.mp4', NULL, 'MP0009'),
('P10T001', 'jirisan_tap1.mp4', '1', 'MP0010'),
('P10T002', 'jirisan_tap2.mp4', '2', 'MP0010'),
('P11T001', 'loki_tap1.mp4', '1', 'MP0011'),
('P11T002', 'loki_tap2.mp4', '2', 'MP0011'),
('P12T001', 'myname_tap1.mp4', '1', 'MP0012'),
('P12T002', 'myname_tap2.mp4', '2', 'MP0012'),
('P12T003', 'myname_tap3.mp4', '3', 'MP0012'),
('P13T001', 'spiderman_frh.mp4', NULL, 'MP0013'),
('P14T001', 'squidgame_tap1.mp4', '1', 'MP0014'),
('P14T002', 'squidgame_tap2.mp4', '2', 'MP0014'),
('P15T001', 'vagabond_tap1.mp4', '1', 'MP0015'),
('P15T002', 'vagabond_tap2.mp4', '2', 'MP0015'),
('P16T001', 'wandavision_tap1.mp4', '1', 'MP0016'),
('P16T002', 'wandavision_tap2.mp4', '2', 'MP0016'),
('P17T001', 'One Punch Man Tap 1.mp4', '1', 'MP0017'),
('P17T002', 'One Punch Man Tap 2.mp4', '2', 'MP0017'),
('P17T003', 'One Punch Man Tap 3.mp4', '3', 'MP0017'),
('P18T001', 'One Piece Tap 1.mp4', '1', 'MP0018'),
('P18T002', 'One Piece Tap 2.mp4', '2', 'MP0018'),
('P18T003', 'One Piece Tap 3.mp4', '3', 'MP0018'),
('P19T001', 'Nisekoi Tap 1.mp4', '1', 'MP0019'),
('P19T002', 'Nisekoi Tap 2.mp4', '2', 'MP0019'),
('P19T003', 'Nisekoi Tap 3.mp4', '3', 'MP0019'),
('P20T001', 'Naruto Tap 1.mp4', '1', 'MP0020'),
('P20T002', 'Naruto Tap 2.mp4', '2', 'MP0020'),
('P20T003', 'Naruto Tap 3.mp4', '3', 'MP0020'),
('P21T001', 'Masamune-kun no Revenge Tap 1.mp4', '1', 'MP0021'),
('P21T002', 'Masamune-kun no Revenge Tap 2.mp4', '2', 'MP0021'),
('P21T003', 'Masamune-kun no Revenge Tap 3.mp4', '3', 'MP0021'),
('P22T001', 'Love Is War Tap 1.mp4', '1', 'MP0022'),
('P22T002', 'Love Is War Tap 2.mp4', '2', 'MP0022'),
('P22T003', 'Love Is War Tap 3.mp4', '3', 'MP0022'),
('P23T001', 'Love Is War 2 Tap 1.mp4', '1', 'MP0023'),
('P23T002', 'Love Is War 2 Tap 2.mp4', '2', 'MP0023'),
('P23T003', 'Love Is War 2 Tap 3.mp4', '3', 'MP0023'),
('P24T001', 'Koe No Katachi.mp4', NULL, 'MP0024'),
('P25T001', 'Kimetsu No Yaiba Tap 1.mp4', '1', 'MP0025'),
('P25T002', 'Kimetsu No Yaiba Tap 2.mp4', '2', 'MP0025'),
('P25T003', 'Kimetsu No Yaiba Tap 3.mp4', '3', 'MP0025'),
('P26T001', 'Karakai Jouzu no Takagi-san Tap 1.mp4', '1', 'MP0026'),
('P26T002', 'Karakai Jouzu no Takagi-san Tap 2.mp4', '2', 'MP0026'),
('P26T003', 'Karakai Jouzu no Takagi-san Tap 3.mp4', '3', 'MP0026'),
('P27T001', 'Karakai Jouzu no Takagi-san 2 Tap 1.mp4', '1', 'MP0027'),
('P27T002', 'Karakai Jouzu no Takagi-san 2 Tap 2.mp4', '2', 'MP0027'),
('P27T003', 'Karakai Jouzu no Takagi-san 2 Tap 3.mp4', '3', 'MP0027'),
('P28T001', 'Kanojo, Okarishimasu Tap 1.mp4', '1', 'MP0028'),
('P28T002', 'Kanojo, Okarishimasu Tap 2.mp4', '2', 'MP0028'),
('P28T003', 'Kanojo, Okarishimasu Tap 3.mp4', '3', 'MP0028'),
('P29T001', 'Gamers! Tap 1.mp4', '1', 'MP0029'),
('P29T002', 'Gamers! Tap 2.mp4', '2', 'MP0029'),
('P29T003', 'Gamers! Tap 3.mp4', '3', 'MP0029'),
('P30T001', 'Fairy tail Tap 1.mp4', '1', 'MP0030'),
('P30T002', 'Fairy tail Tap 2.mp4', '2', 'MP0030'),
('P30T003', 'Fairy tail Tap 3.mp4', '3', 'MP0030'),
('P31T001', 'Eromanga Sensei Tap 1.mp4', '1', 'MP0031'),
('P31T002', 'Eromanga Sensei Tap 2.mp4', '2', 'MP0031'),
('P31T003', 'Eromanga Sensei Tap 3.mp4', '3', 'MP0031'),
('P32T001', 'Dragon Ball Super Tap 1.mp4', '1', 'MP0032'),
('P32T002', 'Dragon Ball Super Tap 2.mp4', '2', 'MP0032'),
('P32T003', 'Dragon Ball Super Tap 3.mp4', '3', 'MP0032'),
('P33T001', 'Dragon Ball Kai Tap 1.mp4', '1', 'MP0033'),
('P33T002', 'Dragon Ball Kai Tap 2.mp4', '2', 'MP0033'),
('P33T003', 'Dragon Ball Kai Tap 3.mp4', '3', 'MP0033'),
('P34T001', 'Bokutachi no Remake Tap 1.mp4', '1', 'MP0034'),
('P34T002', 'Bokutachi no Remake Tap 2.mp4', '2', 'MP0034'),
('P34T003', 'Bokutachi no Remake Tap 3.mp4', '3', 'MP0034'),
('P35T001', 'Blend S Tap 1.mp4', '1', 'MP0035'),
('P35T002', 'Blend S Tap 2.mp4', '2', 'MP0035'),
('P35T003', 'Blend S Tap 3.mp4', 'cuối', 'MP0035');

-- --------------------------------------------------------

--
-- Table structure for table `theloai`
--

CREATE TABLE `theloai` (
  `MaTheLoai` varchar(50) NOT NULL,
  `TenTheLoai` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `theloai`
--

INSERT INTO `theloai` (`MaTheLoai`, `TenTheLoai`) VALUES
('TL001', 'Hành động'),
('TL002', 'Hài hước'),
('TL003', 'Tình cảm'),
('TL004', 'Bi kịch'),
('TL005', 'Giả tưởng'),
('TL006', 'Học đường'),
('TL007', 'Bí ẩn'),
('TL008', 'Kinh dị'),
('TL009', 'Viễn tưởng'),
('TL010', 'Siêu nhiên'),
('TL011', 'Anime');

-- --------------------------------------------------------

--
-- Table structure for table `tuphim`
--

CREATE TABLE `tuphim` (
  `MaTu` int(11) NOT NULL,
  `MaPhim` varchar(50) NOT NULL,
  `MaNguoiDung` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tuphim`
--

INSERT INTO `tuphim` (`MaTu`, `MaPhim`, `MaNguoiDung`) VALUES
(1, 'MP0006', 2),
(14, 'MP0007', 1),
(15, 'MP0006', 1),
(16, 'MP0011', 1),
(17, 'MP0007', 2),
(18, 'MP0010', 2),
(19, 'MP0010', 1),
(20, 'MP0012', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `binhluan`
--
ALTER TABLE `binhluan`
  ADD PRIMARY KEY (`MaBinhLuan`),
  ADD KEY `MaPhim` (`MaPhim`),
  ADD KEY `MaNguoiDung` (`MaNguoiDung`);

--
-- Indexes for table `lichsu`
--
ALTER TABLE `lichsu`
  ADD PRIMARY KEY (`MaLichSu`),
  ADD KEY `MaNguoiDung` (`MaNguoiDung`),
  ADD KEY `MaTapPhim` (`MaTapPhim`) USING BTREE;

--
-- Indexes for table `nguoidung`
--
ALTER TABLE `nguoidung`
  ADD PRIMARY KEY (`MaNguoiDung`);

--
-- Indexes for table `phim`
--
ALTER TABLE `phim`
  ADD PRIMARY KEY (`MaPhim`),
  ADD KEY `MaQG` (`MaQG`);

--
-- Indexes for table `phim_theloai`
--
ALTER TABLE `phim_theloai`
  ADD PRIMARY KEY (`MaPhim`,`MaTheLoai`),
  ADD KEY `MaTheLoai` (`MaTheLoai`);

--
-- Indexes for table `quocgia`
--
ALTER TABLE `quocgia`
  ADD PRIMARY KEY (`MaQG`);

--
-- Indexes for table `tapphim`
--
ALTER TABLE `tapphim`
  ADD PRIMARY KEY (`MaTapPhim`),
  ADD KEY `MaPhim` (`MaPhim`);

--
-- Indexes for table `theloai`
--
ALTER TABLE `theloai`
  ADD PRIMARY KEY (`MaTheLoai`);

--
-- Indexes for table `tuphim`
--
ALTER TABLE `tuphim`
  ADD PRIMARY KEY (`MaTu`),
  ADD KEY `MaPhim` (`MaPhim`),
  ADD KEY `MaNguoiDung` (`MaNguoiDung`) USING BTREE;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `binhluan`
--
ALTER TABLE `binhluan`
  MODIFY `MaBinhLuan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `lichsu`
--
ALTER TABLE `lichsu`
  MODIFY `MaLichSu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `nguoidung`
--
ALTER TABLE `nguoidung`
  MODIFY `MaNguoiDung` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `quocgia`
--
ALTER TABLE `quocgia`
  MODIFY `MaQG` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tuphim`
--
ALTER TABLE `tuphim`
  MODIFY `MaTu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `binhluan`
--
ALTER TABLE `binhluan`
  ADD CONSTRAINT `binhluan_ibfk_1` FOREIGN KEY (`MaNguoiDung`) REFERENCES `nguoidung` (`MaNguoiDung`),
  ADD CONSTRAINT `binhluan_ibfk_2` FOREIGN KEY (`MaPhim`) REFERENCES `phim` (`MaPhim`);

--
-- Constraints for table `lichsu`
--
ALTER TABLE `lichsu`
  ADD CONSTRAINT `lichsu_ibfk_1` FOREIGN KEY (`MaTapPhim`) REFERENCES `tapphim` (`MaTapPhim`);

--
-- Constraints for table `phim`
--
ALTER TABLE `phim`
  ADD CONSTRAINT `phim_ibfk_1` FOREIGN KEY (`MaQG`) REFERENCES `quocgia` (`MaQG`);

--
-- Constraints for table `phim_theloai`
--
ALTER TABLE `phim_theloai`
  ADD CONSTRAINT `phim_theloai_ibfk_1` FOREIGN KEY (`MaTheLoai`) REFERENCES `theloai` (`MaTheLoai`),
  ADD CONSTRAINT `phim_theloai_ibfk_2` FOREIGN KEY (`MaPhim`) REFERENCES `phim` (`MaPhim`);

--
-- Constraints for table `tapphim`
--
ALTER TABLE `tapphim`
  ADD CONSTRAINT `tapphim_ibfk_1` FOREIGN KEY (`MaPhim`) REFERENCES `phim` (`MaPhim`);

--
-- Constraints for table `tuphim`
--
ALTER TABLE `tuphim`
  ADD CONSTRAINT `tuphim_ibfk_1` FOREIGN KEY (`MaNguoiDung`) REFERENCES `nguoidung` (`MaNguoiDung`),
  ADD CONSTRAINT `tuphim_ibfk_2` FOREIGN KEY (`MaPhim`) REFERENCES `phim` (`MaPhim`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
