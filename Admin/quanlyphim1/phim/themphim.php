<?php
    session_start();
?>
<!DOCTYPE html>
<?php
    require_once("../connect.php");
?>
<html lang="en">
<head>
	<title>Thêm phim</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link href='https://fonts.googleapis.com/css?family=Roboto:400,100,300,700' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="includes/css/style.css">

    <style>
        .error{
            color: #f65c78;
        }
    </style>
</head>
<body>
    <?php
        include_once("../../DangNhapLocation2.php");
        include_once("../header.html");
    ?>

    <!-- Xử lý dữ liệu post lên -->
    <?php
        $maPhim = $tenPhim = $moTa = $trangThai = $phatHanh = $thoiLuong = $poster = $kieuPhim = $quocGia = "";

        $error = array();

        $maPhimErr = $tenPhimErr = $moTaErr = $trangThaiErr = $phatHanhErr = $thoiLuongErr = "";
        $posterErr = $kieuPhimErr = $quocGiaErr = "";
        $thongBao = "";

        if (isset($_POST['them'])) {
            $maPhim = $_POST['maPhim'];
            $tenPhim = $_POST['tenPhim'];
            $moTa = $_POST['moTa'];
            $trangThai = $_POST['trangThai'] ?? "";
            $phatHanh = $_POST['phatHanh'];
            $thoiLuong = $_POST['thoiLuong'];
            $kieuPhim = $_POST['kieuPhim'] ?? "";
            $quocGia = $_POST['quocGia'] ?? "";

            $poster = $_FILES['poster'];

            $tenPoster = $poster['name'];
            $loaiAnh = $poster['type'];
            $tmp = $poster['tmp_name'];
            $size = $poster['size'];

            if (empty($maPhim)) {
                $maPhimErr = "Vui lòng nhập mã phim!";
                $error[] = $maPhimErr;
            }

            // nếu xuất hiện mã này trong danh sách thì thông báo.
            $checkMaPhim = "SELECT * FROM phim WHERE MaPhim = '$maPhim'";
            $result = mysqli_query($conn, $checkMaPhim);
            if (mysqli_num_rows($result) > 0) {
                $maPhimErr = "Mã này đã tồn tại vui lòng nhập mã khác!";
                $error[] = $maPhimErr;
            }

            if (empty($tenPhim)) {
                $tenPhimErr = "Vui lòng nhập tên phim!";
                $error[] = $tenPhimErr;
            }

            if (empty($moTa)) {
                $moTaErr = "Vui lòng nhập mô tả!";
                $error[] = $moTaErr;
            }

            if (empty($trangThai)) {
                $trangThaiErr = "Vui lòng chọn trạng thái!";
                $error[] = $trangThaiErr;
            }

            if (empty($phatHanh)) {
                $phatHanhErr = "Vui lòng nhập năm phát hành!";
                $error[] = $phatHanhErr;
            }

            if (empty($thoiLuong)) {
                $thoiLuongErr = "Vui lòng nhập thời lượng!";
                $error[] = $thoiLuongErr;
            }

            if ($kieuPhim != 0 && $kieuPhim != 1) {
                $kieuPhimErr = "Vui lòng chọn kiểu phim!";
                $error[] = $kieuPhimErr;
            }

            if (empty($tenPoster)) {
                $posterErr = "Vui lòng chọn poster cho phim!";
                $error[] = $posterErr;
            }

            if (empty($quocGia)) {
                $quocGiaErr = "Vui lòng chọn quốc gia!";
                $error[] = $quocGiaErr;
            }

            if (empty($error)) {
                move_uploaded_file($tmp, "../../../Films/" . $tenPoster);
            }
        }
    ?>

    
    <!-- Thêm phim vào dữ liệu -->
    <?php
        if (isset($_POST['them']) && empty($error)) {
            $sql = "
                INSERT INTO `phim`
                (MaPhim, TenPhim, MoTa, TrangThai, PhatHanh, ThoiLuong, Poster, KieuPhim, MaQG)
                VALUES
                ('$maPhim', '$tenPhim', '$moTa', '$trangThai', '$phatHanh', '$thoiLuong', '$tenPoster', $kieuPhim, '$quocGia')
            ";

            if (mysqli_query($conn, $sql)) {
                $thongBao = "Bạn đã thêm thành công phim này vào danh sách!";

                echo '<script language="javascript">';
                echo "alert('$thongBao')";
                echo '</script>';
            } else {
                $thongBao = "Đã có sự cố ngoài ý muốn xảy ra! <br>" . mysqli_error($conn);

                echo '<script language="javascript">';
                echo "alert('$thongBao')";
                echo '</script>';
            }
        }
    ?>

    <!-- Form nhập liệu -->
	<section class="ftco-section">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-6 text-center mb-5">
				<h2 class="heading-section">Thêm phim</h2>
			</div>
		</div>
        
		<div class="row justify-content-center">
			<div class="col-lg-10 col-md-12">
				<div class="wrapper">
					<div class="row justify-content-center">
                        						<div class="col-lg-8 mb-5">
							<div class="row">
							<div class="col-md-4">
								<div class="dbox w-100 text-center">
								<div class="icon d-flex align-items-center justify-content-center">
									<span class="fa fa-map-marker"></span>
								</div>
								<div class="text">
									<p><span>Nhóm:</span> 11</p>
								</div>
								</div>
							</div>
							<div class="col-md-4">
								<div class="dbox w-100 text-center">
								<div class="icon d-flex align-items-center justify-content-center">
									<span class="fa fa-phone"></span>
								</div>
								<div class="text">
									<p><span>Phone:</span> <a href="tel://1234567920">+ 1235 2355 98</a></p>
								</div>
								</div>
							</div>
							<div class="col-md-4">
								<div class="dbox w-100 text-center">
								<div class="icon d-flex align-items-center justify-content-center">
									<span class="fa fa-paper-plane"></span>
								</div>
								<div class="text">
									<p><span>Email:</span> <a href="mailto:info@yoursite.com">nhom11@yoursite.com</a></p>
								</div>
								</div>
							</div>
							</div>
						</div>
						<div class="col-lg-8">
							<div class="contact-wrap">
								<h3 class="mb-4 text-center">Hãy thêm một bộ phim hấp dẫn</h3>
								<form class="contactForm" action="" method="POST" enctype="multipart/form-data">
								<div class="row">
								<div class="col-md-12">
									<div class="form-group">
										<input type="text" class="form-control" name="maPhim" placeholder="Mã phim"
                                            value="<?php echo $maPhim; ?>">
                                        <span class="error">
                                            <?php echo $maPhimErr; ?>
                                        </span>
									</div>
								</div>
								<div class="col-md-12">
									<div class="form-group">
										<input type="text" class="form-control" name="tenPhim" placeholder="Tên phim"
                                            value="<?php echo $tenPhim; ?>">
                                        <span class="error">
                                            <?php echo $tenPhimErr; ?>
                                        </span>
									</div>
								</div>
								<div class="col-md-12">
									<div class="form-group">
										<textarea name="moTa" class="form-control" cols="30" rows="8" placeholder="Mô tả"><?php
                                            echo $moTa;
                                        ?></textarea>
                                        <span class="error">
                                            <?php echo $moTaErr; ?>
                                        </span>
									</div>
								</div>
								<div class="col-md-12">
									<div class="form-group">
                                        <select class="form-control" name="trangThai">
                                            <option disabled selected value> Trạng thái </option>
                                            <option class="select-items" value="Chuẩn bị chiếu"
                                                <?php if (isset($_POST['trangThai']) && $_POST['trangThai'] == 'Chuẩn bị chiếu') echo "selected";?>>
                                                Chuẩn bị chiếu
                                            </option>
                                            <option class="select-items" value="Đang cập nhật"
                                                <?php if (isset($_POST['trangThai']) && $_POST['trangThai'] == 'Đang cập nhật') echo "selected";?>>
                                                Đang cập nhật
                                            </option>
                                            <option class="select-items" value="Đầy đủ"
                                                <?php if (isset($_POST['trangThai']) && $_POST['trangThai'] == 'Đầy đủ') echo "selected";?>>
                                                Đầy đủ
                                            </option>
                                        </select>
                                        <span class="error">
                                            <?php echo $trangThaiErr; ?>
                                        </span>
									</div>
								</div>
								<div class="col-md-12"> 
									<div class="form-group">
										<input type="text" class="form-control" name="phatHanh" placeholder="Phát hành"
                                            value="<?php echo $phatHanh; ?>">
                                    <span class="error">
                                        <?php echo $phatHanhErr; ?>
                                    </span>									
                                    </div>
								</div>
								<div class="col-md-12">
									<div class="form-group">
										<input type="text" class="form-control" name="thoiLuong" placeholder="Thời lượng"
                                            value="<?php echo $thoiLuong; ?>">
                                    <span class="error">
                                        <?php echo $thoiLuongErr; ?>
                                    </span>
                                    </div>
								</div>
								<div class="col-md-12">
									<div class="form-group">
										<input type="file" class="form-control" name="poster">
                                        <span class="error">
                                            <?php echo $posterErr; ?>
                                    </span>
									</div>
								</div>
								<div class="col-md-12">
									<div class="form-group">
										<label>Kiểu phim: </label>
										<input type="radio" name="kieuPhim" value="0"
                                            <?php if (isset($_POST['kieuPhim']) && $_POST['kieuPhim'] == '0') echo "checked"; ?>>Phim bộ
                                        <input type="radio" name="kieuPhim" value="1"
                                            <?php if (isset($_POST['kieuPhim']) && $_POST['kieuPhim'] == '1') echo "checked"; ?>>Phim lẻ
									<span class="error">
                                        <?php echo $kieuPhimErr; ?>
                                    </span>
                                    </div>
								</div>
								</div>
                                <div class="form-group">
                                    <select class="form-control" name="quocGia">
                                        <option disabled selected value>Chọn quốc gia</option>
                                        <?php
                                            $query = "SELECT * FROM quocgia";
                                            $result = mysqli_query($conn, $query);

                                            if (mysqli_num_rows($result) > 0) {
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    $ma = $row['MaQG'];
                                                    $ten = $row['TenQG'];
                                                    echo "<option class='select-items' value='$ma'";
                                                        if (isset($_REQUEST['quocGia']) && $_REQUEST['quocGia'] == $ma) echo "selected";
                                                    echo ">$ten</option>";
                                                }
                                            }
                                        ?>
                                    </select>
                                    <span class="error">
                                            <?php echo $quocGiaErr; ?>
                                    </span>
                                </div>
								<div class="col-md-12">
									<div class="form-group">
										<input type="submit" name="them" value="Thêm phim" class="btn btn-primary">
									</div>
								</div>
								</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	</section>

    <?php
        include_once("../footer.html");
    ?>
	<script src="includes/js/jquery.min.js"></script>
	<script src="includes/js/popper.js"></script>
	<script src="includes/js/bootstrap.min.js"></script>
	<script src="includes/js/jquery.validate.min.js"></script>
</body>
</html>

