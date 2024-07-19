<!DOCTYPE html>
<html lang="vi">

<head>
    <title>Chi tiết phim</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.6.0/font/bootstrap-icons.css">
    <link rel="stylesheet" type="text/css" href="../Styles/style_01.css">
</head>

<body>

    <div class="container" style="max-width: 1280px;">
        <?php
        include("../Includes/Header.php");
        

        if (isset($_GET['maPhim'])) { // From home.php
            $maPhim = $_GET['maPhim'];
        } elseif (isset($_POST['maPhim'])) { // Form submission.
            $maPhim = $_POST['maPhim'];
        } else { // No valid ID, kill the script.
            echo '<p class="error">This page has been accessed in error.</p>';
            // include ('includes/footer.html'); 
            exit();
        }
        //Lấy dữ liệu phim
        //Thực hiện truy vấn 
        //Chọn tất cả các cột của bảng phim và quocgia
        //truy vấn này sẽ lấy thông tin của một bộ phim bao gồm cả tên quốc gia của bộ phim đó
        $query = "select phim.*, quocgia.TenQG from phim, quocgia where phim.MaQG=quocgia.MaQG and MaPhim='$maPhim';";
        $result = mysqli_query($dbc, $query);
        $tenPhim = '';
        $moTa = '';
        $trangThai = '';
        $diem = '';
        $phatHanh = '';
        $thoiLuong = '';
        $luotDanhGia = '';
        $thoiGianThemPhim = '';
        $poster = '';
        $kieuPhim = '';
        $quocGia = '';
        $maQG = '';
        $luotXem = '';
        //Kiểm tra xem số bản ghi trả về từ truy vấn database lớn hơn 0 hay không
        //Nếu có, thì lặp qua các bản ghi và lưu trữ thông tin chi tiết của bộ phim vào các biến tương ứng.
        if (mysqli_num_rows($result) <> 0) {
            while ($row = mysqli_fetch_array($result)) {
                $tenPhim = $row['TenPhim'];
                $moTa = $row['MoTa'];
                $trangThai = $row['TrangThai'];
                $diem = $row['Diem'];
                if($diem==0) $diem="?";
                $phatHanh = $row['PhatHanh'];
                $thoiLuong = $row['ThoiLuong'];
                $luotDanhGia = $row['LuotDanhGia'];
                $thoiGianThemPhim = $row['ThoiGianThemPhim'];
                $poster = $row['Poster'];
                $kieuPhim = $row['KieuPhim'];
                $quocGia = $row['TenQG'];
                $maQG = $row['MaQG'];
                $luotXem = $row['LuotXem'];
            }
        }
        mysqli_free_result($result);
        //Lấy dữ liệu các thể loại phim
        $query_theloai = "select theloai.TenTheLoai
                        from `phim`,`theloai`,`phim_theloai`
                            where phim.MaPhim = '$maPhim' AND phim.MaPhim=phim_theloai.MaPhim 
                            AND phim_theloai.MaTheLoai = theloai.MaTheLoai;";
        $result_theloai = mysqli_query($dbc, $query_theloai);
        //Lấy dữ liệu số tập phim
        $query_tapphim = "SELECT tapphim.* FROM `tapphim`,`phim` WHERE phim.MaPhim = tapphim.MaPhim AND phim.MaPhim='$maPhim';";
        $result_tapphim = mysqli_query($dbc, $query_tapphim);
        $query_xemphim = "SELECT tapphim.* FROM `tapphim`,`phim` WHERE phim.MaPhim = tapphim.MaPhim AND phim.MaPhim='$maPhim' LIMIT 1;";
        $result_xemphim = mysqli_query($dbc, $query_xemphim);
        //Lấy mã người dùng
        if (isset($_SESSION['nd'])) {
            $query_userid = "SELECT MaNguoiDung FROM `nguoidung` WHERE TaiKhoan = '" . $_SESSION['nd'] . "' LIMIT 1;";
            $result_userid = mysqli_query($dbc, $query_userid);
            if (mysqli_num_rows($result_userid) == 1) {
                $row = mysqli_fetch_array($result_userid);
                $userid = $row['MaNguoiDung'];
            }
        }
        ?>
        <div class="container p-2 text-white-50 text-center mt-5 rounded shadow" style="background: linear-gradient(90deg, rgba(0,0,0,0.7315301120448179) 7%, rgba(9,32,31,0.9023984593837535) 33%, rgba(34,8,28,0.8883928571428571) 73%, rgba(0,0,0,0.7455357142857143) 93%);">
            <h1><?php echo $tenPhim ?></h1>
        </div>

        <div class="container mt-2 bg-dark rounded py-2 shadow">
            <div class="container add-radius mt-1 mb-2 p-2 t_1 shadow">
                <div class="spinner-grow text-danger" style="margin-bottom: -5px;"></div>
                <a href='home.php' style='text-decoration: none; color:#e6e6e6;'>
                    <span class="t_2">
                        <i class='fas fa-home' style='font-size:24px'></i> Trang chủ
                    </span>
                </a>
                <?php
                echo "<span class='t_2'><i class='fas fa-chevron-right' style='font-size:20px'></i>
                        &nbsp;$tenPhim</span>";
                ?>

            </div>
            <div class="row">
                <div class="col-sm-4">
                    <div class="card bg-dark">
                        <?php
                        echo '<img class="card-img shadow rounded" src="../Films/' . $poster . '" alt="' . $poster . '" width="430" height="600">'
                        ?>
                        <div class="card-img-overlay d-flex align-items-end">
                            <div class="card-body justify-content-center d-flex">

                                <?php
                                $mess = '';
                                if (isset($_POST['themtuphim'])) {
                                    //Kiểm tra phim đã có trong tủ chưa
                                    $query_check_tuphim = "SELECT * FROM `tuphim` WHERE MaPhim = '$maPhim' AND MaNguoiDung = $userid;";
                                    $result_check_tuphim = mysqli_query($dbc, $query_check_tuphim);
                                    if (mysqli_num_rows($result_check_tuphim) == 1) {
                                        $mess = "Phim đã tồn tại trong tủ phim!";
                                    } else {
                                        //Thêm vào tủ phim
                                        $query_tuphim = "INSERT INTO `tuphim`(`MaPhim`, `MaNguoiDung`) VALUES ('$maPhim', $userid);";
                                        $result_tuphim = mysqli_query($dbc, $query_tuphim);
                                        if (mysqli_affected_rows($dbc) == 1) {
                                            $mess = "Đã thêm vào tủ phim";
                                        }
                                    }
                                }
                                if (isset($_SESSION['nd'])) {
                                    echo "<form action='' method='post'>
                                        <button type='submit' name='themtuphim' class='btn btn-success'>
                                            <i class='far fa-bookmark shadow' style='font-size:20px'></i> Thêm vào tủ phim
                                        </button>
                                    </form><p>&nbsp;&nbsp;&nbsp;&nbsp;</p>";
                                }
                                $s1 = 1;
                                if (mysqli_num_rows($result_xemphim) == 1) {
                                    $row = mysqli_fetch_array($result_xemphim);
                                    echo "<a href='watch_film.php?maPhim=$maPhim&soTap=$s1&maTapPhim=" . $row["MaTapPhim"] . "' style='text-decoration: none;'>
                                            <button type='button' name='xemphim' class='btn btn-danger shadow'>
                                            <i class='far fa-play-circle' style='font-size:20px'></i> Xem phim
                                        </button>
                                    </a>";
                                }
                                mysqli_free_result($result_xemphim);
                                ?>

                            </div>
                        </div>
                    </div>
                    <?php echo "<h3 class='text-white-50 text-center'>$mess</h3>" ?>
                </div>
                <div class="col-sm-8 py-1">
                    <table class="table table-dark table-striped">
                        <tr>
                            <td>Thể loại:</td>
                            <td>
                                <h5>
                                    <?php
                                    if (mysqli_num_rows($result_theloai) <> 0) {
                                        while ($row = mysqli_fetch_array($result_theloai)) {
                                            echo '<span class="badge bg-secondary shadow">' . $row['TenTheLoai'] . '</span>&nbsp';
                                        }
                                    }
                                    mysqli_free_result($result_theloai);
                                    ?>
                                </h5>
                            </td>
                        </tr>
                        <tr>
                            <td>Trạng thái:</td>
                            <td><?php echo $trangThai; ?></td>
                        </tr>
                        <tr>
                            <td>Điểm:</td>
                            <td><?php echo "$diem || $luotDanhGia đánh giá"; ?></td>
                        </tr>
                        <tr>
                            <td>Lượt xem:</td>
                            <td><?php echo $luotXem ?></td>
                        </tr>
                        <tr>
                            <td>Phát hành:</td>
                            <td><?php echo $phatHanh; ?></td>
                        </tr>
                        <tr>
                            <td>Thời lượng:</td>
                            <td><?php
                                if ($kieuPhim == 0) {
                                    echo $thoiLuong . " tập";
                                } else {
                                    echo $thoiLuong . " phút";
                                }
                                ?></td>
                        </tr>
                        <tr>
                            <td>Kiểu phim:</td>
                            <td><?php
                                $convert_kieuphim = ($kieuPhim == 0) ? 'Phim bộ' : 'Phim lẻ';
                                echo $convert_kieuphim;
                                ?></td>
                        </tr>
                        <tr>
                            <td>Quốc gia:</td>
                            <td><?php echo $quocGia; ?></td>
                        </tr>
                    </table>
                    <div class="text-white-50">
                        <h3>Nội dung:</h3>
                        <p>
                            <?php echo $moTa; ?>
                        </p>
                    </div>
                    <div class="text-white-50">
                        <?php
                        if ($kieuPhim == 0) echo "<h3>Danh sách tập: </h3>";
                        if (mysqli_num_rows($result_tapphim) <> 0 && $kieuPhim == 0) {
                            while ($row = mysqli_fetch_array($result_tapphim)) {
                                echo "<a href='watch_film.php?maPhim=$maPhim&soTap=" . $row["SoTap"] . "&maTapPhim=" . $row["MaTapPhim"] . "' style='text-decoration: none;'>
                                    <button type='button' class='btn btn-dark b_1 shadow'>Tập " . $row["SoTap"] . "</button>
                                </a>";
                            }
                        }
                        mysqli_free_result($result_tapphim);
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <h1 class="title_1 mt-5 mb-3" style="color: #f1b722;">Có thể bạn cũng muốn xem</h1>
            <div class="row">
                <?php
                $x = 0;
                $y = 0;
                $phim_goi_y = [];
                //Lấy dữ liệu các bộ phim cùng quốc gia, cùng kiểu phim
                $query_phim_quocgia = "SELECT * FROM `phim` WHERE MaQG = $maQG LIMIT 5;";
                $result_phim_quocgia = mysqli_query($dbc, $query_phim_quocgia);
                if (mysqli_num_rows($result_phim_quocgia) <> 0) {
                    while ($row = mysqli_fetch_array($result_phim_quocgia)) {
                        $maPhim_new1 = $row['MaPhim'];
                        $phim_goi_y[] = $row['MaPhim'];
                        if ($maPhim != $maPhim_new1) {
                            echo "<div class='col-sm-3'>
                                <div class='panel panel-primary'>
                                    <a href='detail_film.php?maPhim=" . $row['MaPhim'] . "' class='a_1'>
                                        <div class='panel-body shadow'><img src='../Films/" . $row['Poster'] . "' class='img-responsive add-radius' style='width:300px;height:450px;' alt='Image'></div>
                                        <div class='panel-footer'><h3 class='text-white title_1'>" . $row['TenPhim'] . "</h3></div>
                                    </a>
                                </div>
                            </div>";
                            $x++;
                        }
                        if ($x == 2)
                            break;
                    }
                }
                mysqli_free_result($result_phim_quocgia);
                $query_phim_kieuphim = "SELECT * FROM `phim` WHERE KieuPhim = $kieuPhim ORDER BY MaPhim DESC LIMIT 5;";
                $result_phim_kieuphim = mysqli_query($dbc, $query_phim_kieuphim);

                if (mysqli_num_rows($result_phim_kieuphim) <> 0) {
                    while ($row = mysqli_fetch_array($result_phim_kieuphim)) {
                        $maPhim_new2 = $row['MaPhim'];
                        if ($maPhim != $maPhim_new2) {
                            if ($maPhim_new2 != $phim_goi_y[0] && $maPhim_new2 != $phim_goi_y[1]) {
                                echo "<div class='col-sm-3'>
                                <div class='panel panel-primary'>
                                    <a href='detail_film.php?maPhim=" . $row['MaPhim'] . "' class='a_1'>
                                        <div class='panel-body shadow'><img src='../Films/" . $row['Poster'] . "' class='img-responsive add-radius' style='width:300px;height:450px;' alt='Image'></div>
                                        <div class='panel-footer'><h3 class='text-white title_1'>" . $row['TenPhim'] . "</h3></div>
                                    </a>
                                </div>
                            </div>";
                                $y++;
                            }
                        }
                        if ($y == 2)
                            break;
                    }
                }
                // mysqli_free_result($result_phim_kieuphim);
                // if (($x + $y) < 4) {
                //     echo "<div class='col-sm-3'>
                //                 <div class='panel panel-primary'>
                //                     <a href='detail_film.php?maPhim=" . "MP0006" . "' class='a_1'>
                //                         <div class='panel-body shadow'><img src='../Films/theveil_poster.jpg' class='img-responsive add-radius' style='width:300px;height:450px;' alt='Image'></div>
                //                         <div class='panel-footer'><h3 class='text-white title_1'>The Veil</h3></div>
                //                     </a>
                //                 </div>
                //             </div>";
                // }


                ?>


            </div>
            <div class="d-flex justify-content-center">
            <h3 class="title_1 text-white-50 mt-5 mb-3 bg-dark p-3 shadow" style="width: 500px; border-radius: 50px;
            background: linear-gradient(0deg, rgba(34,183,195,1) 0%, rgba(63,15,70,1) 100%);">Nguyễn Văn Tèo</h3>
        </div>
        </div><br>
        <?php
        include("../Includes/footer.html");
        mysqli_close($dbc);
        ?>
    </div>


</body>

</html>