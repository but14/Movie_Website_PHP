<?php
    session_start();
?>
<!DOCTYPE html>
<?php
    require_once("../connect.php");
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.6.0/font/bootstrap-icons.css">
    <link rel="stylesheet" type="text/css" href="../styles/tapphimstyle.css">
    <title>Cập nhật tập phim</title>

</head>
<body class="container-fluid">
    <?php
        include_once("../../DangNhapLocation2.php");
        include_once("../header.html");
    ?> 

    <?php  
        $maPhim = $_GET['maPhim'];
        $maTapPhim = $_GET['maTapPhim'];

        $sql1 = "SELECT * FROM phim WHERE MaPhim = '$maPhim'";
        $result1 = mysqli_query($conn, $sql1);
        $row1 = mysqli_fetch_assoc($result1);

        $sql2 = "SELECT * FROM tapphim WHERE MaPhim = '$maPhim' AND MaTapPhim = '$maTapPhim'";
        $result2 = mysqli_query($conn, $sql2);
        $row2 = mysqli_fetch_assoc($result2);

        $tenPhim = $row1['TenPhim'];
        $soTap = $row2['SoTap'];
        echo "<h3>Bạn đang cập nhật tập $soTap phim cho phim $tenPhim</h3>";
    ?>

    <!-- Xử lý dữ liệu post lên -->
    <?php
        $maTapPhim = $row2['MaTapPhim'];
        $soTap = $row2['SoTap'];
        $name = $row2['TapPhim'];

        $maPhim = $maPhim ?? "";

        $error = array();

        $maTapPhimErr = $soTapErr = $fileTapPhimErr = "";

        if (isset($_POST['capNhapTapPhim'])) {
            $maPhim = $_POST['maPhim'];
            $maTapPhim = $_POST['maTapPhim'];
            $soTap = $_POST['soTap'];
            $fileTapPhim = $_FILES['fileTapPhim'];


            $name = empty($fileTapPhim['name']) ? $_POST['fileCu'] : $fileTapPhim['name'];
            $type = $fileTapPhim['type'];
            $tmp = $fileTapPhim['tmp_name'];
            $size = $fileTapPhim['size'];

            if (empty($soTap)) {
                $soTapErr = "Vui lòng nhập số tập phim!";
                $error[] = $soTapErr;
            }

            if (empty($name)) {
                $fileTapPhimErr = "Vui lòng tải file phim lên!";
                $error[] = $fileTapPhimErr;
            }

            if (empty($error)) {
                if (!is_dir("KhoPhim\\$maPhim"))
                    mkdir("KhoPhim\\$maPhim");

                move_uploaded_file($tmp, "../../../Films/" . $name);

                $sql = "UPDATE tapphim 
                        SET MaTapPhim = '$maTapPhim', SoTap = '$soTap', TapPhim = '$name', MaPhim = '$maPhim'
                        WHERE MaTapPhim = '$maTapPhim'
                    ";

                if (mysqli_query($conn, $sql)) {
                    echo "
                        <div class='alert alert-success' role='alert'>
                            Bạn đã cập nhật thành công tập phim!
                        </div>                    
                    ";
                } else {
                    echo "
                        <div class='alert alert-danger' role='alert'>
                            Đã có sự cố ngoài ý muốn xảy ra!!!
                        </div>                    
                    ". mysqli_error($conn);
                }
            }
        }



        $maPhim = $_GET['maPhim'];
    ?>

    <br>

    <form action="" method="post" enctype="multipart/form-data">
        <input type="hidden" class="form-control" name="maPhim" value="<?php echo $maPhim; ?>">

        <div class="row mb-1">
            <label for="maPhim" class="col-sm-2 col-form-label">Mã tập phim:</label>
            <div class="col-sm-3">
                <input type="text" class="form-control" readonly name="maTapPhim" value="<?php echo $maTapPhim; ?>">
            </div>
            <?php
                if (empty($maTapPhimErr)) {
                    echo "";
                } else {
                    echo "
                    <div class='alert alert-danger col-sm-3' role='alert'>
                        $maTapPhimErr
                    </div>
                    ";
                }
            ?>
        </div>

        <div class="row mb-1">
            <label for="maPhim" class="col-sm-2 col-form-label">Số tập:</label>
            <div class="col-sm-3">
                <input type="text" class="form-control" name="soTap" value="<?php echo $soTap; ?>">
            </div>
            <?php
                if (empty($soTapErr)) {
                    echo "";
                } else {
                    echo "
                    <div class='alert alert-danger col-sm-3' role='alert'>
                        $soTapErr
                    </div>
                    ";
                }
            ?>
        </div>

        <div class="row mb-1">
            <label for="maPhim" class="col-sm-2 col-form-label">File tập phim:</label>
            <div class="col-sm-3">
                <input type="file" class="form-control" name="fileTapPhim">
                <input type="hidden" name="fileCu" value="<?php echo $name; ?>">
                <p><?php echo $name; ?></p>
            </div>
            <?php
                if (empty($fileTapPhimErr)) {
                    echo "";
                } else {
                    echo "
                    <div class='alert alert-danger col-sm-3' role='alert'>
                        $fileTapPhimErr
                    </div>
                    ";
                }
            ?>
        </div>
        
        <button type="submit" class="btn btn-warning" name="capNhapTapPhim">Cập nhật</button>
    </form>
    
    <?php
        include_once("../footer.html");
    ?>  

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
</body>
</html>