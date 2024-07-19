<!DOCTYPE html>
<html lang="vi">

<head>
    <title>Xem phim</title>
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

        //Lấy thông tin theo GET từ detail_film
        if (isset($_GET['maPhim'], $_GET['maTapPhim'], $_GET['soTap'])) { // From detail_film.php
            $maPhim = $_GET['maPhim'];
            $maTapPhim = $_GET['maTapPhim'];
            if ($_GET['soTap'] != null)
                $_SESSION['s'] = $_GET['soTap'];
        } elseif (isset($_POST['maPhim'], $_POST['maTapPhim'], $_POST['soTap'])) { // Form submission.
            $maPhim = $_POST['maPhim'];
            $maTapPhim = $_POST['maTapPhim'];
            if ($_GET['soTap'] != null)
                $_SESSION['s'] = $_POST['soTap'];
        } else { // No valid ID, kill the script.
            echo '<p class="error">This page has been accessed in error.</p>';
            // include ('includes/footer.html'); 
            exit();
        }
        //Cập nhật view cho phim
        $query_views = "SELECT LuotXem FROM `phim` WHERE MaPhim = '$maPhim' LIMIT 1;";
        $result_views = mysqli_query($dbc, $query_views);
        $row_views = mysqli_fetch_array($result_views);
        if (isset($_SESSION['views'])) {
            $_SESSION['views'] = $row_views['LuotXem'] + 1;
            $query_views_count = "UPDATE `phim` SET `LuotXem`= " . $_SESSION['views'] . " WHERE MaPhim = '$maPhim';";
            $result_views_count = mysqli_query($dbc, $query_views_count);
        } else {
            $_SESSION['views'] = $row_views['LuotXem'];
        }
        //Lấy dữ liệu phim
        $query_tenphim = "select TenPhim, KieuPhim, Diem, LuotDanhGia, MaQG
             from phim
            where MaPhim='$maPhim'";
        $result_tenphim = mysqli_query($dbc, $query_tenphim);
        $tenPhim = '';
        $kieuPhim = '';
        $diem = '';
        $luotDanhGia = '';
        $maQG = '';
        if (mysqli_num_rows($result_tenphim) <> 0) {
            while ($row = mysqli_fetch_array($result_tenphim)) {
                $tenPhim = $row['TenPhim'];
                $kieuPhim = $row['KieuPhim'];
                $diem = $row['Diem'];
                $luotDanhGia = $row['LuotDanhGia'];
                $maQG = $row['MaQG'];
            }
        }
        mysqli_free_result($result_tenphim);
        //Lấy tập phim
        $query_tapphim = "SELECT tapphim.TapPhim FROM `tapphim`,`phim` WHERE phim.MaPhim=tapphim.MaPhim AND TapPhim.MaTapPhim='$maTapPhim';";
        $result_tapphim = mysqli_query($dbc, $query_tapphim);
        $tapPhim = '';
        if (mysqli_num_rows($result_tapphim) == 1) {
            while ($row = mysqli_fetch_array($result_tapphim)) {
                $tapPhim = trim($row['TapPhim']);
            }
        }
        mysqli_free_result($result_tapphim);
        //Lấy dữ liệu số tập phim
        $query_sotapphim = "SELECT tapphim.* FROM `tapphim`,`phim` WHERE phim.MaPhim = tapphim.MaPhim AND phim.MaPhim='$maPhim';";
        $result_sotapphim = mysqli_query($dbc, $query_sotapphim);
        //Đăng bình luận
        $errors = '';
        $cmt = '';
        $userid = '';
        //Lấy mã người dùng
        if (isset($_SESSION['nd'])) {
            $query_userid = "SELECT MaNguoiDung FROM `nguoidung` WHERE TaiKhoan = '" . $_SESSION['nd'] . "' LIMIT 1;";
            $result_userid = mysqli_query($dbc, $query_userid);
            if (mysqli_num_rows($result_userid) == 1) {
                $row = mysqli_fetch_array($result_userid);
                $userid = $row['MaNguoiDung'];
            }
        }
        //Đăng bình luận theo userid
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            if (empty($_POST['comment'])) {
                $errors = "Bạn chưa nhập bình luận!";
            } else {
                $comment = trim($_POST['comment']);
                $query = "INSERT INTO `binhluan`(`MaPhim`, `MaNguoiDung`, `BinhLuan`) 
                                    VALUES ('$maPhim','$userid','$comment');";
                $result = mysqli_query($dbc, $query);
                if (mysqli_affected_rows($dbc) == 1) {
                    $errors = "Đăng bình luận thành công!";
                }
            }
        }
        //Phân trang bình luận
        $rowsPerPage = 4; //số mẩu tin trên mỗi trang, giả sử là 10
        if (!isset($_GET['page'])) {
            $_GET['page'] = 1;
        }
        //vị trí của mẩu tin đầu tiên trên mỗi trang
        $offset = ($_GET['page'] - 1) * $rowsPerPage;
        //Lấy dữ liệu bình luận
        $query_binhluan = "SELECT nguoidung.TaiKhoan, binhluan.BinhLuan, binhluan.MaBinhLuan FROM `binhluan`,`phim`,`nguoidung` 
        WHERE nguoidung.MaNguoiDung =    binhluan.MaNguoiDung AND phim.MaPhim=binhluan.MaPhim AND phim.MaPhim='$maPhim' ORDER BY binhluan.MaBinhLuan DESC LIMIT $offset, $rowsPerPage;";
        $result_binhluan = mysqli_query($dbc, $query_binhluan);
        $query_binhluan_sum = "SELECT nguoidung.TaiKhoan, binhluan.BinhLuan, binhluan.MaBinhLuan FROM `binhluan`,`phim`,`nguoidung` 
            WHERE nguoidung.MaNguoiDung =    binhluan.MaNguoiDung AND phim.MaPhim=binhluan.MaPhim AND phim.MaPhim='$maPhim' ORDER BY binhluan.MaBinhLuan DESC;";
        $result_binhluan_sum = mysqli_query($dbc, $query_binhluan_sum);
        $num_cmt = 0;
        $num_cmt = mysqli_num_rows($result_binhluan_sum);
        //Form đánh giá
        $rating = 0;
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            if (isset($_POST['one']))
                $rating = 1;
            elseif (isset($_POST['two']))
                $rating = 2;
            elseif (isset($_POST['three']))
                $rating = 3;
            elseif (isset($_POST['four']))
                $rating = 4;
            elseif (isset($_POST['five']))
                $rating = 5;
            elseif (isset($_POST['six']))
                $rating = 6;
            elseif (isset($_POST['seven']))
                $rating = 7;
            elseif (isset($_POST['eight']))
                $rating = 8;
            elseif (isset($_POST['nine']))
                $rating = 9;
            elseif (isset($_POST['ten']))
                $rating = 10;
            else
                $rating = 0;
            //Tính điểm update vào csdl và reload lại trang
            if ($rating != 0) {
                $tinhLuotDanhGia = $luotDanhGia + 1;
                $tinhDiem = round(($diem * $luotDanhGia + $rating) / $tinhLuotDanhGia, 2);
                $query_rating = "UPDATE `phim` SET `Diem`= $tinhDiem,`LuotDanhGia`=$tinhLuotDanhGia WHERE MaPhim = '$maPhim';";
                $result_rating = mysqli_query($dbc, $query_rating);
            }
            echo("<script>location.href = '".$_SERVER["PHP_SELF"]."?maPhim=$maPhim&soTap=".$_SESSION['s']."&maTapPhim=$maTapPhim';</script>");
            exit;
        }
        //Lưu lại tập phim vào lịch sử theo userid
        if (isset($_SESSION['nd'])) {
            //Kiểm tra tập phim đã có trong lịch sử chưa
            $query_check_history = "SELECT * FROM `lichsu` WHERE MaTapPhim = '$maTapPhim' AND MaNguoiDung = $userid;";
            $result_check_history = mysqli_query($dbc, $query_check_history);
            if (mysqli_num_rows($result_check_history) < 1) {
                //Thêm vào lịch sử
                $query_history = "INSERT INTO `lichsu` (`MaLichSu`, `MaTapPhim`, `MaNguoiDung`, `ThoiGianXem`) VALUES (NULL, '$maTapPhim', '$userid', current_timestamp());";
                $result_history = mysqli_query($dbc, $query_history);
            }
        }

        ?>
        <div class="container p-2 text-white-50 text-center mt-5 add-radius shadow" style="background: linear-gradient(90deg, rgba(0,0,0,0.7315301120448179) 7%, rgba(9,32,31,0.9023984593837535) 33%, rgba(34,8,28,0.8883928571428571) 73%, rgba(0,0,0,0.7455357142857143) 93%);">
            <h1><?php echo $tenPhim ?></h1>
        </div>
        <div class="container mt-2 add-radius py-2 shadow" style="background: linear-gradient(90deg, rgba(0,0,0,0.7315301120448179) 7%, rgba(9,32,31,0.9023984593837535) 33%, rgba(34,8,28,0.8883928571428571) 73%, rgba(0,0,0,0.7455357142857143) 93%);">
            <div class="container add-radius mt-1 mb-2 p-2 t_1 shadow">
                <div class="spinner-grow text-danger" style="margin-bottom: -5px;"></div>
                <a href='home.php' style='text-decoration: none; color:#e6e6e6;'>
                    <span class="t_2">
                        <i class='fas fa-home' style='font-size:24px'></i> Trang chủ

                    </span>
                </a>
                <?php
                echo "<a href='detail_film.php?maPhim=$maPhim' style='text-decoration: none; color:#e6e6e6;'>
                        <span class='t_2'><i class='fas fa-chevron-right' style='font-size:20px'></i>
                        &nbsp;$tenPhim</span>
                     </a>";
                if ($kieuPhim == 0) {
                    echo '<span class="t_2"><i class="fas fa-chevron-right" style="font-size:20px"></i>
                    &nbsp;Đang xem tập ' . $_SESSION['s'] . '</span>';
                }
                ?>

            </div>
            <div class="container_1">
                <?php
                //Đổi đường dẫn Film nếu lỗi
                echo '<iframe  class="responsive-iframe_1 rounded shadow" src="../Films/' . $tapPhim . '" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            ';
                ?>
            </div>
            <?php
            if (isset($_SESSION['nd'])) {
                echo '<div class="t_1 add-radius mt-3 p-3 shadow">
                    <h3 class="text-center">Đánh giá phim:</h3>
                    <div class="btn-group d-flex justify-content-center">
                        <div>
                            <form action="" name="rating" method="post">
                                <button type="submit" name="one" class="btn btn-hover"><span class="fa fa-star checked text-warning"></span></button>
                                <button type="submit" name="two" class="btn btn-hover"><span class="fa fa-star checked text-warning"></span></button>
                                <button type="submit" name="three" class="btn btn-hover"><span class="fa fa-star checked text-warning"></span></button>
                                <button type="submit" name="four" class="btn btn-hover"><span class="fa fa-star checked text-warning"></span></button>
                                <button type="submit" name="five" class="btn btn-hover"><span class="fa fa-star checked text-warning"></span></button>
                                <button type="submit" name="six" class="btn btn-hover"><span class="fa fa-star checked text-warning"></span></button>
                                <button type="submit" name="seven" class="btn btn-hover"><span class="fa fa-star checked text-warning"></span></button>
                                <button type="submit" name="eight" class="btn btn-hover"><span class="fa fa-star checked text-warning"></span></button>
                                <button type="submit" name="nine" class="btn btn-hover"><span class="fa fa-star checked text-warning"></span></button>
                                <button type="submit" name="ten" class="btn btn-hover"><span class="fa fa-star checked text-warning"></span></button>
                            </form>
                        </div>
                    </div>
                    <h4 class="text-center"> 
                        (Điểm: ' . $diem . ' / ' . $luotDanhGia . ' lượt đánh giá)
                    </h4>
                </div>';
            }

            ?>

            <?php
            if ($kieuPhim == 0) {
                echo '<div class="t_1 add-radius mt-3 p-3 shadow">
                    <h3>Danh sách tập:</h3>';
            }
            if (mysqli_num_rows($result_sotapphim) <> 0 && $kieuPhim == 0) {
                while ($row = mysqli_fetch_array($result_sotapphim)) {
                    if ($_GET["maTapPhim"] == $row["MaTapPhim"])
                        echo "<a href='" . $_SERVER["PHP_SELF"] . "?maPhim=$maPhim&soTap=" . $row["SoTap"] . "&maTapPhim=" . $row["MaTapPhim"] . "' style='text-decoration: none;'>
                    <button type='button' class='btn bg-success btn-dark b_1 shadow add-radius'>Tập " . $row["SoTap"] . "</button>
                </a>";
                    else
                        echo "<a href='" . $_SERVER["PHP_SELF"] . "?maPhim=$maPhim&soTap=" . $row["SoTap"] . "&maTapPhim=" . $row["MaTapPhim"] . "' style='text-decoration: none;'>
                                <button type='button' class='btn btn-dark b_1 shadow add-radius'>Tập " . $row["SoTap"] . "</button>
                            </a>";
                }
            }
            mysqli_free_result($result_sotapphim);
            if ($kieuPhim == 0) {
                echo '</div>';
            }
            ?>

            <div class="t_1 add-radius mt-3 p-3 shadow mb-5 shadow">
                <h3><i class='far fa-comment-dots' style='font-size:24px'></i> Bình luận (<?php echo $num_cmt; ?>):</h3>
                <?php
                if (!isset($_SESSION['nd'])) {
                    echo "<a href='DangNhap.php' class='text-white'>
                            <button type='button' class='btn btn-danger d-flex mx-auto mb-3'>
                                <i class='fas fa-user-check shadow' style='font-size:20px'></i>&nbsp;Đăng nhập để bình luận và đánh giá
                            </button>
                        </a>";
                } else {
                    echo '<form action="" method="post">
                            <div class="p-2">
                                <textarea class="form-control w-100 m-2 shadow" name="comment" placeholder="Nhập bình luận ở đây"></textarea>
                            </div>
                            <div class="d-flex justify-content-end mb-3">
                                <button type="submit" name="gui" class="btn btn-danger shadow">&nbsp;&nbsp;Gửi&nbsp;&nbsp;</button>
                            </div>
                        </form>';
                }
                ?>


                <?php
                $cmt_id = '';
                echo "<h3 class='text-center'>$errors</h3>";
                if (mysqli_num_rows($result_binhluan) <> 0) {
                    while ($row = mysqli_fetch_array($result_binhluan)) {

                        echo "<div class='p-2 m-2 cmt shadow'>
                        <div class='row'>
                            <div class='col-sm-1'>
                                <img src='../Images/avt.png' alt='avatar' width='80' height='80' class='avt shadow'>
                            </div>
                            <div class='col-sm-11'>
                                <h5 class='color_name'>" . $row['TaiKhoan'] . "</h5>
                                <p>" . $row['BinhLuan'] . "</p>
                            </div>
                        </div>
                    </div>";
                    }
                }
                mysqli_free_result($result_binhluan);
                //Phân trang
                //tổng số mẩu tin cần hiển thị
                $numRows = mysqli_num_rows($result_binhluan_sum);
                //tổng số trang
                // $maxPage = floor($numRows/$rowsPerPage) + 1; 
                $maxPage = ceil($numRows / $rowsPerPage);
                //Căn giữa
                echo "<div class='text-center mt-3'>";
                $trangdau = 1;
                if ($_GET['page'] != 1) {
                    echo "<a class='btn btn-warning shadow' href=" . $_SERVER['PHP_SELF'] . "?maPhim=$maPhim&soTap=" . $_SESSION['s'] . "&maTapPhim=$maTapPhim&page=" . $trangdau . ">
                    <i class='fas fa-angle-double-left' style='font-size:24px'></i>
                    </a> ";
                }
                //gắn thêm nút Back
                if ($_GET['page'] > 1) {
                    echo "<a class='btn btn-dark shadow' href=" . $_SERVER['PHP_SELF'] . "?maPhim=$maPhim&soTap=" . $_SESSION['s'] . "&maTapPhim=$maTapPhim&page=" . ($_GET['page'] - 1) . ">
                    <i class='fas fa-angle-left' style='font-size:24px'></i>
                    </a> ";
                }
                //tạo link tương ứng tới các trang
                for ($i = 1; $i <= $maxPage; $i++) {
                    if ($i == $_GET['page']) {
                        echo '<b class="btn btn-primary shadow">' . $i . '</b> '; //trang hiện tại sẽ được bôi đậm
                    } else
                        echo "<a class='btn btn-secondary shadow text-white-50' href=" . $_SERVER['PHP_SELF'] . "?maPhim=$maPhim&soTap=" . $_SESSION['s'] . "&maTapPhim=$maTapPhim&page="
                            . $i . ">" . $i . "</a> ";
                }
                //gắn thêm nút Next
                if ($_GET['page'] < $maxPage) {
                    echo "<a class='btn btn-dark shadow' href = " . $_SERVER['PHP_SELF'] . "?maPhim=$maPhim&soTap=" . $_SESSION['s'] . "s&maTapPhim=$maTapPhim&page=" . ($_GET['page'] + 1) . ">
                    <i class='fas fa-angle-right' style='font-size:24px'></i>
                    </a> ";
                }
                if ($_GET['page'] != $maxPage && $num_cmt != 0) {
                    echo "<a class='btn btn-warning shadow' href=" . $_SERVER['PHP_SELF'] . "?maPhim=$maPhim&soTap=" . $_SESSION['s'] . "&maTapPhim=$maTapPhim&page=" . $maxPage . ">
                    <i class='fas fa-angle-double-right' style='font-size:24px'></i>
                    </a> ";
                }

                echo "</div>";
                // echo "<p align='center' class='text-success'>Tổng số trang là: ".$maxPage ."</p>";

                ?>

            </div>
        </div><br><br>

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
                //                     </a >
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