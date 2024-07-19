<?php
session_start();
?>
<!doctype html>
<html lang="vi-VN">

<head>
    <title>Bình luận</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.css"> -->
    <!-- bootstrap cdn  -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- CSS manual -->
    <link rel="stylesheet" href="css/AdminStyle.css">
</head>

<body style="background-color: #d3cfcf;">
    <?php include '../DangNhapLocation.php' ?>
    <!-- khối xử lý -->
    <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "databasephim";

    // Create connection
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $maPhim = $maBinhLuan =  "";
    if (isset($_GET['maPhim']))
        $maPhim = $_GET['maPhim'];
    if (isset($_GET['maBinhLuan'])) {
        $maBinhLuan = $_GET['maBinhLuan'];
        $sqlBl = "DELETE FROM `binhluan` WHERE `MaBinhLuan`='$maBinhLuan';";
        // xóa bình luận
        $resultBl = mysqli_query($conn, $sqlBl);
    }

    $sql = "SELECT * FROM `binhluan` WHERE `MaPhim`= '$maPhim' ";
    // kết quả của truy vấn 
    $result = mysqli_query($conn, $sql);
    // biến số hàng trả về, số thuộc tính có trong bảng
    $numRows = mysqli_num_rows($result);
    $numFields = mysqli_num_fields($result);
    $data = createData($result, $numRows);

    function createData($result, $numRows)
    {
        $data = array();
        if ($numRows > 0) {
            // output data of each row
            for ($i = 1; $i <= $numRows; $i++) {
                array_push($data, mysqli_fetch_row($result));
            }
        }
        return $data;
    }
    //close
    mysqli_close($conn);
    ?>

    <!-- khối giao diện  -->
    <div class="container-fluid" style="overflow-x: auto;">
        <table class="table table-striped table-bordered table-hover">
            <thead>
                <tr>

                    <th>
                        Mã bình luận
                    </th>
                    <th>
                        Mã người dùng
                    </th>
                    <th>
                        Bình luận
                    </th>
                    <th>
                        Hành động
                    </th>
                </tr>
            </thead>
            <tbody>

                <?php
                if ($numRows == 0)
                    echo "<tr> <td colspan='4'>Chưa có bình luận</td> </tr>";
                else
                    for ($i = 0; $i < $numRows; $i++) {
                        echo "<tr>";
                        for ($j = 0; $j < $numFields; $j++) {
                            if ($j != 1) {
                                echo "<td>";
                                echo $data[$i][$j];
                                echo "</td>";
                            }
                        }
                        $maBinhLuan = $data[$i][0];
                        echo "<td class='align-middle'>";
                        echo "<a href='BinhLuan.php?maPhim=$maPhim&maBinhLuan=$maBinhLuan' alt='Xóa bình luận'> <button class='btn btn-warning'  >Xóa</button> </a>";
                        echo  "</td>";
                        echo "</tr>";
                    }
                ?>

            </tbody>
        </table>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <!-- <script type="text/javascript" src="bootstrap/js/bootstrap.js"></script> -->
</body>

</html>