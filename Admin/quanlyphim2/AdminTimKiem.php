<?php
session_start();
?>
<!doctype html>
<html lang="vi-VN">

<head>
    <title>Tìm Kiếm</title>
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



    // truy vấn thể loại data2
    $sql2 = "SELECT `phim_theloai`.*,`theloai`.`TenTheLoai` FROM `phim_theloai`,`theloai` WHERE `phim_theloai`.`MaTheLoai`=`theloai`.`MaTheLoai`;";
    // kết quả của truy vấn 
    $result2 = mysqli_query($conn, $sql2);
    // biến số hàng trả về, số thuộc tính có trong bảng
    $numRows2 = mysqli_num_rows($result2);
    $numFields2 = mysqli_num_fields($result2);
    $data2 = createData($result2, $numRows2);


    //quốc gia data 3
    $sql3 = "SELECT * FROM `quocgia`";
    // kết quả của truy vấn 
    $result3 = mysqli_query($conn, $sql3);
    // biến số hàng trả về, số thuộc tính có trong bảng
    $numRows3 = mysqli_num_rows($result3);
    $numFields3 = mysqli_num_fields($result3);
    $data3 = createData($result3, $numRows3);

    // nhận truy vấn bảng chính
    $maPhim = $tenPhim = $namPhatHanh = $loaiPhim = $theLoai = "";
    $qmaPhim = $qtenPhim = $qnamPhatHanh = $qloaiPhim = $qtheLoai = " ";
    $sapXep = "MaPhim";
    $sapXepSort = " ASC";
    if (!empty($_GET['maPhim'])) {
        $maPhim = $_GET['maPhim'];
        $qmaPhim = " AND `MaPhim` like '%$maPhim%'";
    }
    if (!empty($_GET['tenPhim'])) {
        $tenPhim = $_GET['tenPhim'];
        $qtenPhim = "AND `TenPhim` like '%$tenPhim%'";
    }
    if (!empty($_GET['namPhatHanh'])) {
        $namPhatHanh = $_GET['namPhatHanh'];
        if ($namPhatHanh != "Tất cả")
            $qnamPhatHanh = "AND `PhatHanh` like '%$namPhatHanh%'";
    }
    if (isset($_GET['loaiPhim'])) {
        $loaiPhim = $_GET['loaiPhim'];
        if ($loaiPhim == "Lẻ" || $loaiPhim == 1)
            $loaiPhim = 1;
        else if ($loaiPhim == "Bộ" || $loaiPhim == 0)
            $loaiPhim = 0;
        else $loaiPhim = 2;
        if ($loaiPhim != 2)
            $qloaiPhim = "AND `KieuPhim` =  '$loaiPhim'";
    }
    if (!empty($_GET['theLoai'])) {
        $theLoai = $_GET['theLoai'];
        foreach ($data2 as $tl) {
            if ($theLoai == $tl[2])
                $theLoai = $tl[1];
        }
        if ($theLoai != "Tất cả")
            $qtheLoai = " AND `MaPhim` = ANY (SELECT `MaPhim` From `phim_theloai` WHERE `MaTheLoai`='$theLoai') ";
    }
    if (!empty($_GET['sapXep'])) {
        $sapXep = $_GET['sapXep'];
        switch ($sapXep) {
            case "Mã phim":
                $sapXep = "`MaPhim`";
                break;
            case  "Tên phim":
                $sapXep = "`TenPhim`";
                break;
            case  "Trạng thái":
                $sapXep = "`TrangThai`";
                break;
            case   "Điểm":
                $sapXep = "`Diem`";
                break;
            case   "Năm Phát hành":
                $sapXep = "`PhatHanh`";
                break;
            case   "Thời lượng":
                $sapXep = "`ThoiLuong`";
                break;
            case  "Lượt xem":
                $sapXep = "`LuotXem`";
                break;
            case   "Lượt đánh giá":
                $sapXep = "`LuotDanhGia`";
                break;
            case   "Thời gian thêm phim":
                $sapXep = "`ThoiGianThemPhim`";
                break;
            case   "Kiểu phim":
                $sapXep = "`KieuPhim`";
                break;
        }
    }
    if (!empty($_GET['sapXepSort'])) {
        $sapXepSort = $_GET['sapXepSort'];
        switch ($sapXepSort) {
            case "tang":
                $sapXepSort = " ASC";
                break;
            case "giam":
                $sapXepSort = " DESC";
                break;
        }
    }


    // viết truy vấn sql Phim
    $sql =
        "SELECT * FROM `phim` AS `p`
    WHERE 1 $qmaPhim $qtenPhim $qnamPhatHanh $qloaiPhim $qtheLoai  
    ORDER BY  $sapXep $sapXepSort";


    // kết quả của truy vấn 
    $result = mysqli_query($conn, $sql);
    // biến số hàng trả về, số thuộc tính có trong bảng
    $numRows = mysqli_num_rows($result);
    $numFields = mysqli_num_fields($result);
    // dữ liệu truy vấn được lấy ra bỏ vô 1 mảng để tiện thao tác, khỏi truy vấn sql mệt 
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
    // in dữ liệu theo trang 
    function printDataPage($data, $pageRecent, $numRowPerPage)
    {
        global $data2, $data3;
        // số dòng, số cột thuộc tính
        $numRows = count($data);
        if ($numRows > 0) {
            $numFields = count($data[0]);

            if ($numRowPerPage < 1)
                $numRowPerPage = 2;

            $index = ($pageRecent - 1) * $numRowPerPage;
            for ($i = 1; $i <= $numRowPerPage; $i++) {
                echo "<tr>";
                // mã nó khó in nên làm vậy
                $maPhim = $data[$index][0];
                echo "<td class='align-middle'>";
                echo "<a href='AdminPhimInfo.php?maPhim=$maPhim' alt='Sửa Phim'><button class='btn btn-warning' >Xem chi tiết</button> </a>";
                echo  "</td>";
                echo "<td class='align-middle'>";
                echo "<a href='../quanlyphim1/phim/suaphim.php?maPhim=$maPhim' alt='Sửa Phim'><button class='btn btn-warning' >Sửa</button> </a>";
                echo  "</td>";
                echo "<td class='align-middle'>";
                echo "<a href='AdminXoaPhim.php?maPhim=$maPhim' alt='Xóa Phim'><button class='btn btn-warning' >Xóa</button> </a>";
                echo  "</td>";
                for ($j = 0; $j < $numFields; $j++) {

                    if ($j != 2 && $j != 10) {
                        if ($j != 11 && $j != 12)
                            echo "<td class='align-middle'>" . $data[$index][$j] . "</td>";

                        else {
                            if ($j == 11) {
                                if ($data[$index][$j] == 1)
                                    echo "<td class='align-middle'>Lẻ</td>";
                                else
                                    echo "<td class='align-middle'>Bộ</td>";
                            }
                            if ($j == 12) {
                                for ($k = 0; $k < count($data3); $k++) {
                                    if ($data[$index][$j] == $data3[$k][0])
                                        echo "<td class='align-middle'>" . $data3[$k][1] . "</td>";
                                }
                            }
                        }
                    }
                }
                echo "<td class='align-middle'>";
                for ($m = 0; $m < count($data2); $m++)
                    if ($data[$index][0] == $data2[$m][0])
                        echo $data2[$m][2] . ", ";

                echo  "</td>";

                // nếu số lượng dòng không đủ 1 trang 
                if ($index + 1 == $numRows)
                    break;
                $index++;
                echo "</tr>";
            }
        } else
            echo "<tr> <td  colspan='14'>Không có dữ liệu</td> </tr>";
    }



    // module phân trang (tự xây) 
    $numRowPerPage = 5;
    // làm tròn vì có những trang không đủ row mong muốn 
    $numPages =  ceil($numRows / $numRowPerPage);
    $numPagesView = 5;
    $pageRecent = 1;
    $pageName = $_SERVER['PHP_SELF'];
    //nhận kết quả truy vấn trang
    if (!empty($_GET['pageRecent']))
        $pageRecent = $_GET['pageRecent'];
    if ($pageRecent > $numPages)
        $pageRecent = $numPages;
    if ($pageRecent < 1)
        $pageRecent = 1;


    // hàm này trả về các trang trước sau của trang hiện tại 
    function aroundPage($pageRecent, $numPages, $numPagesView, $pageName)
    {

        global $maPhim, $tenPhim, $theLoai, $namPhatHanh, $loaiPhim, $sapXep, $sapXepSort;
        if ($numPagesView % 2 == 0) {
            $dlPhai = $numPagesView / 2;
            $dlTrai = $dlPhai - 1;
        }
        if ($numPagesView % 2 != 0) {
            $dlPhai = ($numPagesView - 1) / 2;
            $dlTrai = $dlPhai;
        }
        // trang đầu
        echo " <li class='page-item'> ";
        echo " <a class='page-link' ";
        echo " href='$pageName?pageRecent=1&maPhim=$maPhim&tenPhim=$tenPhim&theLoai=$theLoai&namPhatHanh=$namPhatHanh&loaiPhim=$loaiPhim&sapXep=$sapXep&sapXepSort=$sapXepSort' ";
        echo  "style='background-color: #DCDCDC;'>";
        echo "Start</a></li>";
        // phía trái page recent
        for ($i = $dlTrai; $i >= 1; $i--) {
            $pageTemp = $pageRecent - $i;
            if ($pageTemp >= 1) {
                echo  " <li class='page-item'> ";
                echo  " <a class='page-link' ";
                echo  " href='$pageName?pageRecent=$pageTemp&maPhim=$maPhim&tenPhim=$tenPhim&theLoai=$theLoai&namPhatHanh=$namPhatHanh&loaiPhim=$loaiPhim&sapXep=$sapXep&sapXepSort=$sapXepSort' ";
                echo " style='background-color: #DCDCDC;'> ";
                echo $pageTemp;
                echo "</a></li>";
            }
        }
        // trang hiện tại
        echo  " <li class='page-item'> ";
        echo  " <a class='page-link' ";
        echo  " href='$pageName?pageRecent=$pageRecent&maPhim=$maPhim&tenPhim=$tenPhim&theLoai=$theLoai&namPhatHanh=$namPhatHanh&loaiPhim=$loaiPhim&sapXep=$sapXep&sapXepSort=$sapXepSort' ";
        echo " style='background-color: #696969;'> ";
        echo $pageRecent;
        echo "</a></li>";
        // phía sau page recent
        for ($i = 1; $i <= $dlPhai; $i++) {
            $pageTemp = $pageRecent + $i;
            if ($pageTemp <= $numPages) {
                echo  " <li class='page-item'> ";
                echo  " <a class='page-link' ";
                echo  " href='$pageName?pageRecent=$pageTemp&maPhim=$maPhim&tenPhim=$tenPhim&theLoai=$theLoai&namPhatHanh=$namPhatHanh&loaiPhim=$loaiPhim&sapXep=$sapXep&sapXepSort=$sapXepSort' ";
                echo " style='background-color: #DCDCDC;'> ";
                echo $pageTemp;
                echo "</a></li>";
            }
        }
        // trang cuối
        echo " <li class='page-item'> ";
        echo " <a class='page-link' ";
        echo " href='$pageName?pageRecent=$numPages&maPhim=$maPhim&tenPhim=$tenPhim&theLoai=$theLoai&namPhatHanh=$namPhatHanh&loaiPhim=$loaiPhim&sapXep=$sapXep&sapXepSort=$sapXepSort' ";
        echo  "style='background-color: #DCDCDC;'>";
        echo "End</a></li>";

        //số lượng 
        echo "<li class='page-item'>";
        echo "<span class='page-link' ";
        echo "style='background-color: #DCDCDC;'>";
        // chú ý numpage có thể làm thay đổi giá trị
        if ($numPages == 0) $numPages++;
        echo "Số lượng trang: $numPages</span> </li>";
        $numPages--;
    }

    mysqli_close($conn);
    ?>
    <!-- khối html -->
    <?php include 'header.html' ?>
    <!-- form -->
    <div class="container  border text-center">
        <form action="" class="was-validated" method="GET" name="timKiem" id="form1">
            <!-- row tiêu đề -->
            <div class="form-group row">
                <div class="col-sm-2">
                </div>
                <div class="col-sm-8 text-center">
                    <h3>TRA CỨU PHIM</h3>
                </div>
            </div>
            <!-- row mã phim -->
            <div class="form-group row">
                <div class="col-sm-3 col-form-label font-weight-bold">
                    <label for="maPhim" class="mr-sm-2">Mã phim:</label>
                </div>
                <div class="col-sm-7">
                    <input type="text" class="form-control" id="maPhim" placeholder="Nhập mã phim" name="maPhim" pattern="(MP[0-9]{4})?" value="<?php echo $maPhim ?>">
                    <div class="valid-feedback col-sm">Hợp lệ</div>
                    <div class="invalid-feedback col-sm">Vui lòng nhập đúng định dạng MP[0-9]{4}</div>
                </div>
            </div>
            <!-- row tên phim -->
            <div class="form-group row">
                <div class="col-sm-3 col-form-label font-weight-bold">
                    <label for="tenPhim" class="mr-sm-2">Tên phim:</label>
                </div>
                <div class="col-sm-7">
                    <input type="text" class="form-control" id="tenPhim" placeholder="Nhập tên phim" name="tenPhim" value="<?php echo $tenPhim ?>">
                    <div class="valid-feedback col-sm">Hợp lệ</div>
                    <div class="invalid-feedback col-sm">Vui lòng nhập đúng định dạng</div>
                </div>
            </div>

        </form>
        <!-- bỏ ngoài form cho khỏi vadidate :3  -->
        <!-- Thể loại -->
        <div class="form-group row">
            <div class="col-sm-3 col-form-label font-weight-bold">
                <label for="theLoai">Thể loại:</label>
            </div>
            <div class="col-sm-7">
                <select class="form-control" id="theLoai" name="theLoai" form="form1">
                    <?php
                    // Create connection
                    $conn = mysqli_connect($servername, $username, $password, $dbname);
                    // Check connection
                    if (!$conn) {
                        die("Connection failed: " . mysqli_connect_error());
                    }
                    // thể loại only, data2_2
                    $sql2_2 = "SELECT * FROM `theloai`";
                    $result2_2 =  mysqli_query($conn, $sql2_2);
                    $numRows2_2 = mysqli_num_rows($result2_2);
                    $numFields2_2 = mysqli_num_fields($result2_2);
                    $data2_2 = createData($result2_2, $numRows2_2);
                    echo "<option>Tất cả</option>";
                    foreach ($data2_2 as $l) {

                        if ($theLoai == $l[0])
                            echo "<option selected>" . $l[1] . "</option>";
                        else
                            echo "<option>" . $l[1] . "</option>";
                    }
                    mysqli_close($conn);
                    ?>

                </select>
            </div>
        </div>
        <!-- năm phát hành  -->
        <div class="form-group row">
            <div class="col-sm-3 col-form-label font-weight-bold">
                <label for="namPhatHanh">Năm phát hành:</label>
            </div>
            <div class="col-sm-7">
                <select class="form-control" id="namPhatHanh" name="namPhatHanh" form="form1">
                    <?php
                    // Create connection
                    $conn = mysqli_connect($servername, $username, $password, $dbname);
                    // Check connection
                    if (!$conn) {
                        die("Connection failed: " . mysqli_connect_error());
                    }
                    $namSQL = " SELECT DISTINCT `PhatHanh` FROM `phim` ORDER BY `PhatHanh` ASC ";
                    $resultNam = mysqli_query($conn, $namSQL);
                    $namData = createData($resultNam, mysqli_num_rows($resultNam));
                    echo "<option>Tất cả</option>";
                    foreach ($namData as $n) {
                        if ($namPhatHanh == $n[0])
                            echo "<option selected>" . $n[0] . "</option>";
                        else
                            echo "<option>" . $n[0] . "</option>";
                    }
                    mysqli_close($conn);
                    ?>
                </select>
            </div>
        </div>
        <!-- phim lẻ phim bộ -->
        <div class="form-group row">
            <div class="col-sm-3 col-form-label font-weight-bold">
                <label for="loaiPhim">Loại phim:</label>
            </div>
            <div class="col-sm-7">
                <select class="form-control" id="loaiPhim" name="loaiPhim" form="form1">
                    <option <?php if ($loaiPhim == 2) echo "selected" ?>>Tất cả</option>
                    <option <?php if ($loaiPhim == 1) echo "selected" ?>>Lẻ</option>
                    <option <?php if ($loaiPhim == 0) echo "selected" ?>>Bộ</option>
                </select>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-sm-12">
                <button type="submit" class="btn btn-warning" form="form1">Tra cứu</button>
            </div>
        </div>
    </div>
    <!-- //sắp xếp  -->
    <div class="container form-inline font-weight-bold border ">
        <div class="mr-sm-2 w-25"> </div>
        <label for="sapXep" class="mb-1 mr-sm-2">Sắp xếp theo: </label>
        <div class="mr-sm-2 ">
            <select class="form-control " id="sapXep" name="sapXep" form="form1">
                <option <?php if ($sapXep == "`MaPhim`") echo "selected" ?>>Mã phim</option>
                <option <?php if ($sapXep == "`TenPhim`") echo "selected" ?>>Tên phim</option>
                <option <?php if ($sapXep == "`TrangThai`") echo "selected" ?>>Trạng thái</option>
                <option <?php if ($sapXep == "`Diem`") echo "selected" ?>>Điểm</option>
                <option <?php if ($sapXep == "`PhatHanh`") echo "selected" ?>>Năm Phát hành</option>
                <option <?php if ($sapXep == "`ThoiLuong`") echo "selected" ?>>Thời lượng</option>
                <option <?php if ($sapXep == "`LuotXem`") echo "selected" ?>>Lượt xem</option>
                <option <?php if ($sapXep == "`LuotDanhGia`") echo "selected" ?>>Lượt đánh giá</option>
                <option <?php if ($sapXep == "`ThoiGianThemPhim`") echo "selected" ?>>Thời gian thêm phim</option>
                <option <?php if ($sapXep == "`KieuPhim`") echo "selected" ?>>Kiểu phim</option>
            </select>
        </div>
        <div class="form-check-inline">
            <label class="form-check-label" for="sapXepSort">
                <input type="radio" class="form-check-input" id="sapXepSort" name="sapXepSort" value="tang" form="form1" <?php if ($sapXepSort == " ASC") echo "checked" ?>>Tăng
            </label>
        </div>
        <div class="form-check-inline">
            <label class="form-check-label" for="sapXepSort">
                <input type="radio" class="form-check-input" id="sapXepSort" name="sapXepSort" value="giam" form="form1" <?php if ($sapXepSort == " DESC") echo "checked" ?>>Giảm
            </label>
        </div>
        <button type="submit" class="btn btn-success" form="form1">Sắp xếp</button>

    </div>
    <!-- Bảng kết quả -->
    <!-- table  -->
    <div class="container border text-center">
        <h4>KẾT QUẢ TÌM KIẾM</h4>
    </div>
    <div class="container" style="overflow-x: auto;">

        <table class="table table-striped table-bordered table-hover">
            <thead>
                <!-- sắp xếp theo v.v.v  -->
                <!-- <tr>
                    <th colspan="14">
                        <div class="container form-inline">

                            <label for="sapXep" class="mb-1 mr-sm-2">Sắp xếp theo: </label>
                            <div class="mr-sm-2">
                                <select class="form-control " id="sapXep" name="sapXep" form="form1">

                                    <option>Mã phim</option>
                                    <option>Tên phim</option>
                                    <option>Trạng thái</option>
                                    <option>Điểm</option>
                                    <option>Năm Phát hành</option>
                                    <option>Thời lượng</option>
                                    <option>Lượt xem</option>
                                    <option>Lượt đánh giá</option>
                                    <option>Thời gian thêm phim</option>
                                    <option>Kiểu phim</option>
                                </select>
                            </div>
                            <div class="form-check-inline">
                                <label class="form-check-label" for="sapXepSort">
                                    <input type="radio" class="form-check-input" id="sapXepSort" name="sapXepSort" value="tang" form="form1" checked>Tăng
                                </label>
                            </div>
                            <div class="form-check-inline">
                                <label class="form-check-label" for="sapXepSort">
                                    <input type="radio" class="form-check-input" id="sapXepSort" name="sapXepSort" value="giam" form="form1">Giảm
                                </label>
                            </div>
                            <button type="submit" class="btn btn-primary" form="form1">Sắp xếp</button>

                        </div>
                    </th>
                </tr> -->
                <!-- tiêu đề -->

                <!-- thuộc tính  -->
                <tr class="text-center">
                    <th class="align-middle" colspan="3">
                        <div style="width: 300px;"></div>
                        <h5>Hành động</h5>
                    </th>
                    <th class="align-middle">
                        <h5>Mã phim</h5>
                    </th>
                    <th class="align-middle">
                        <div style="width: 200px;"></div>
                        <h5>Tên phim</h5>
                    </th>
                    <th class="align-middle">
                        <div style="width: 100px;"></div>
                        <h5>Trạng thái</h5>
                    </th>
                    <th class="align-middle">
                        <h5>Điểm</h5>
                    </th>
                    <th class="align-middle">
                        <h5>Năm phát hành</h5>
                    </th>
                    <th class="align-middle">
                        <h5>Thời lượng</h5>
                    </th>
                    <th class="align-middle">
                        <h5>Lượt xem</h5>
                    </th>
                    <th class="align-middle">
                        <h5>Lượt đánh giá</h5>
                    </th>
                    <th class="align-middle">
                        <div style="width: 100px;"></div>
                        <h5>Thời gian thêm</h5>
                    </th>

                    <th class="align-middle">
                        <h5>Kiểu phim</h5>
                    </th>
                    <th class="align-middle">
                        <div style="width: 100px;"></div>
                        <h5>Quốc gia</h5>
                    </th>
                    <th class="align-middle">
                        <div style="width: 200px;"></div>
                        <h5>Thể loại</h5>
                    </th>

                </tr>
            </thead>
            <tbody>
                <?php printDataPage($data, $pageRecent, $numRowPerPage); ?>
            </tbody>
        </table>
    </div>

    <nav aria-label="Page navigation example">
        <ul class="pagination justify-content-center">


            <?php aroundPage($pageRecent, $numPages, $numPagesView, $pageName) ?>



        </ul>

    </nav>

    <!-- footer -->
    <?php include 'footer.html'; ?>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <!-- <script type="text/javascript" src="bootstrap/js/bootstrap.js"></script> -->
</body>

</html>