<?php
session_start();
?>
<!doctype html>
<html lang="vi-VN">

<head>
    <title>Xem chi tiết phim</title>
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
    <!-- khối xử lý  -->
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

    $maPhim = "";
    if (isset($_GET['maPhim']))
        $maPhim = $_GET['maPhim'];


    $sql = "SELECT * FROM `phim` WHERE `MaPhim`= '$maPhim' ";
    // kết quả của truy vấn 
    $result = mysqli_query($conn, $sql);
    // biến số hàng trả về, số thuộc tính có trong bảng
    $numRows = mysqli_num_rows($result);
    $numFields = mysqli_num_fields($result);
    $data = createData($result, $numRows);

    // truy vấn thể loại data2
    $sql2 = "SELECT `phim_theloai`.*,`theloai`.`TenTheLoai` FROM `phim_theloai`,`theloai` WHERE `phim_theloai`.`MaTheLoai`=`theloai`.`MaTheLoai`;";
    // kết quả của truy vấn 
    $result2 = mysqli_query($conn, $sql2);
    // biến số hàng trả về, số thuộc tính có trong bảng
    $numRows2 = mysqli_num_rows($result2);
    $numFields2 = mysqli_num_fields($result2);
    $data2 = createData($result2, $numRows2);



    // quốc gia data 3
    $sql3 = "SELECT * FROM `quocgia`";
    // kết quả của truy vấn 
    $result3 = mysqli_query($conn, $sql3);
    // biến số hàng trả về, số thuộc tính có trong bảng
    $numRows3 = mysqli_num_rows($result3);
    $numFields3 = mysqli_num_fields($result3);
    $data3 = createData($result3, $numRows3);

    // danh sách tập 
    $sql4 = "SELECT * FROM `tapphim` WHERE `MaPhim`='$maPhim' ";
    // kết quả của truy vấn 
    $result4 = mysqli_query($conn, $sql4);
    // biến số hàng trả về, số thuộc tính có trong bảng
    $numRows4 = mysqli_num_rows($result4);
    $numFields4 = mysqli_num_fields($result4);
    $data4 = createData($result4, $numRows4);



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
    <?php include 'header.html' ?>
    <?php if ($numRows == 0) echo "<div class='container-fluid' style='height:300px;'><h1> Xin lỗi, có thể không tìm thấy phim này</h1> </div>" ?>
    <div <?php if ($numRows == 0) echo "hidden" ?>>
        <!-- table  -->
        <div class="container" style="overflow-x: auto;">
            <table class="table table-striped table-bordered table-hover">
                <tbody>
                    <tr>
                        <th colspan="4" class="text-center"> Chi tiết phim </th>
                    </tr>
                    <tr>
                        <td rowspan="3" style="width: 250px;height: 300px;">
                            <image src='<?php echo "../../Films/" . $data[0][10] . ""; ?>' alt="ảnh" style="width: 100%;height: 100%;"></image>
                        </td>
                        <td>
                            <b> Mã phim:</b> <?php echo $data[0][0]; ?>
                        </td>

                        <td colspan="2">
                            <b> Tên phim:</b> <?php echo $data[0][1]; ?>
                        </td>
                    </tr>
                    <tr>

                        <td>
                            <b> Thể loại</b>: <?php
                                                foreach ($data2 as $tl)
                                                    if ($data[0][0] == $tl[0])
                                                        echo $tl[2] . ", ";
                                                ?>
                        </td>
                        <td>
                            <b>Trạng thái:</b> <?php echo $data[0][3]; ?>
                        </td>

                        <td>
                            <b>Năm phát hành:</b> <?php echo $data[0][5]; ?>
                        </td>
                    </tr>
                    <tr>

                        <td>
                            <b>Quốc gia:</b> <?php foreach ($data3 as $qg)
                                                    if ($data[0][12] == $qg[0])
                                                        echo $qg[1]; ?>
                        </td>
                        <td>
                            <b>Thời lượng:</b> <?php echo $data[0][6]; ?>
                        </td>

                        <td>
                            <b>Lượt xem</b> <?php echo $data[0][7]; ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-center">
                            <a href='<?php echo "../quanlyphim1/tapphim/themtapphim.php?maPhim=$maPhim" ?>'> <button class="btn btn-warning">Thêm tập</button> </a>
                            <a href='<?php echo "../quanlyphim1/phim/suaphim.php?maPhim=$maPhim" ?>'> <button class="btn  btn-warning">Sửa</button> </a>
                            <a href='<?php echo "AdminXoaPhim.php?maPhim=$maPhim" ?>'> <button class="btn  btn-warning">Xóa</button> </a>
                        </td>
                        <td>
                            <b>Điểm</b> <?php echo $data[0][4]; ?>
                        </td>
                        <td>
                            <b>Lượt đánh giá</b> <?php echo $data[0][8]; ?>
                        </td>
                        <td>
                            <b>Thời gian thêm:</b> <?php echo $data[0][9]; ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4">
                            <b>Mô tả</b>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4">
                            <p><?php echo $data[0][2]; ?></p>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="4"> <b> Bình luận</b></td>
                    </tr>
                    <tr>
                        <td colspan="4">
                            <iframe src='<?php echo "BinhLuan.php?maPhim=$maPhim" ?>' style="border:none;" height="200px" width="100%" title="Bình luận">

                            </iframe>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <!-- bảng tập  phim -->
        <div class="container" style="overflow-x: auto;">
            <table class="table table-striped table-bordered table-hover">
                <thead>
                    <tr>
                        <th colspan="5" class="text-center"> Danh sách tập </th>
                    </tr>
                    <tr>
                        <th>
                            Mã tập phim
                        </th>
                        <th>
                            Tên file tập phim
                        </th>
                        <th>
                            Tập phim
                        </th>
                        <th colspan="2">
                            Hành động
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($numRows4 == 0) echo "<tr> <td colspan='4'>Chưa có tập phim</td></tr>";
                    for ($i = 0; $i < $numRows4; $i++) {
                        echo "<tr>";
                        for ($j = 0; $j < $numFields4 - 1; $j++) {

                            echo "<td>";
                            echo $data4[$i][$j];
                            echo "</td>";
                        }
                        $maTapPhim = $data4[$i][0];
                        echo "<td class='align-middle'>";
                        echo "<a href='../quanlyphim1/tapphim/suatapphim.php?maPhim=$maPhim&maTapPhim=$maTapPhim' alt='Sửa tập phim'> <button class='btn btn-warning' >Sửa</button> </a>";
                        echo  "</td>";
                        echo "<td class='align-middle'>";
                        echo "<a href='AdminXoaTapPhim.php?maPhim=$maPhim&maTapPhim=$maTapPhim' alt='Xóa tập phim'> <button class='btn btn-warning' >Xóa</button> </a>";
                        echo  "</td>";
                        echo "</tr>";
                    } ?>
                </tbody>
            </table>
        </div>
    </div>
    <!-- footer -->
    <?php include 'footer.html'; ?>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <!-- <script type="text/javascript" src="bootstrap/js/bootstrap.js"></script> -->
</body>

</html>