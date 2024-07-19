<!DOCTYPE html>
<html lang="en">

<head>
     <meta charset="UTF-8">
     <meta http-equiv="X-UA-Compatible" content="IE=edge">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Trang chủ</title>
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.6.0/font/bootstrap-icons.css">
     <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
     <link rel="stylesheet" type="text/css" href="../Styles/style_01.css">
     <style>
          .area {
               text-align: center;
               border-bottom: 2px black solid;
               border-top: 2px black solid;
               margin-bottom: 20px;
          }

          img:hover {
               filter: drop-shadow(0 0 10px blue);
               font-style: italic;
               font-weight: bold;
          }
     </style>

</head>

<body style="background: url('../Images/backgr.png') black no-repeat top center;">

     <div class="container-fluid p-1 bg-dark " style="max-width: 1280px; border-left: 2px black solid;border-right: 2px black solid; background: linear-gradient(90deg, rgba(2,0,36,1) 0%, rgba(56,15,91,1) 50%, rgba(0,0,0,1) 100%);">
          <?php include("../Includes/Header.php"); ?>

          <div class="area rounded  d-none d-lg-block" style="color:blueviolet; background: linear-gradient(90deg, rgba(56,15,91,1) 0%, rgba(0,0,0,1) 50%, rgba(56,15,91,1) 100%);">
               
               <?php
               //Câu truy vấn này sẽ lấy ra các bộ phim có lượt xem cao và lấy ra  6 bộ phim có lượt xem cao nhất
               $SQL_DeXuat = "SELECT * FROM  phim order by LuotXem desc Limit 0,6";
               $result_DeXuat = mysqli_query($dbc, $SQL_DeXuat);
               //Nếu chưa có bộ phim nào sẽ không hiện
               if (mysqli_num_rows($result_DeXuat) == 0) {
                    echo "";
               } else {
                    //Nếu có sẽ hiển thị ra theo dạng carousel là kiểu băng chuyền lướt lướt
                    echo "<h2>Đề Xuất</h2><div id='carouselExampleCaptions' class='carousel slide' data-bs-ride='carousel'> 
                         <div class='carousel-inner'>";
                    //Khởi tạo biến act để kiểm soát trạng thái của mục carou
                    $act="active";
                    while ($row_DeXuat = mysqli_fetch_array($result_DeXuat)) {
                         $poster = $row_DeXuat["Poster"];
                         $tenphim = $row_DeXuat["TenPhim"];
                         $update= $row_DeXuat["ThoiGianThemPhim"];
                         $namph =$row_DeXuat['PhatHanh'];
                         $dg=$row_DeXuat['Diem'];
                         if($dg==0) $dg= "?";
                         $mota= $row_DeXuat["MoTa"];
                         $lx =$row_DeXuat["LuotXem"];
                         echo "<div class='carousel-item $act ' align='center' style='font-weight: bold;'>
                                   <a href='detail_film.php?maPhim=" . $row_DeXuat["MaPhim"] . "'> 
                                        <div class='card mb-3 col-10' style='background:transparent;'>
                                             <div class='row g-0'>
                                             <div class='col-lg-4'>
                                             <img src='../Films/$poster' style='max-width: 300px;height: 450px' class='rounded' alt='...'>
                                             </div>
                                             <div class='col-lg-8'>
                                             <div class='card-body'>
                                                  <h3 class='card-title text-warning'><center>$tenphim</center></h3>
                                                  <p class='card-text' ><center class='' style='height:240px;'>$mota</center></p>
                                                  <p class='card-text '><center class='text-success'> Lượt Xem: $lx</center></p>
                                                  <p class='card-text'><center class='text-success'> Điểm: $dg</center></p>
                                                  <p class='card-text'><center class='text-success'> Năm phát hành: $namph</center></p>
                                                  <p class='card-text'><small class='text-muted'>Last motad $update</small></p>
                                             </div>
                                             </div>
                                        </div>
                                   </div>
                                 </a>
                              </div>";
                         $act="";
                    }
                    echo "</div><button class='carousel-control-prev' type='button' data-bs-target='#carouselExampleCaptions' data-bs-slide='prev'>
                    <span class='carousel-control-prev-icon' aria-hidden='true'></span>
                    <span class='visually-hidden'>Previous</span>
               </button>
               <button class='carousel-control-next' type='button' data-bs-target='#carouselExampleCaptions' data-bs-slide='next'>
                    <span class='carousel-control-next-icon' aria-hidden='true'></span>
                    <span class='visually-hidden'>Next</span>
               </button> 
                </div>
               " ;
               }
               ?>
     </div>
     <div class="area p-4 rounded" style="color:blueviolet; background: linear-gradient(90deg, rgba(2,0,36,1) 0%, rgba(56,15,91,1) 50%, rgba(0,0,0,1) 100%);">
          <h1>Mới cập nhật</h1>
          <div class="row no-gutters row-cols-2 row-cols-md-4">
               <?php
               if (!isset($_GET['page'])) {
                    $_GET['page'] = 1;
               }
               $rowsPerPage = 12;
               $offset = ($_GET['page'] - 1) * $rowsPerPage;
               $strSQL = "SELECT * FROM  phim order by ThoiGianThemPhim desc ";

               //tổng số mẩu tin cần hiển thị
               $numRows = mysqli_num_rows(mysqli_query($dbc, $strSQL));
               //tổng số trang
               $maxPage = ceil($numRows / $rowsPerPage);
               $strSQL1 = $strSQL . "LIMIT $offset, $rowsPerPage";
               $result = mysqli_query($dbc, $strSQL);
               $result1 = mysqli_query($dbc, $strSQL1);
               if (mysqli_num_rows($result1) == 0) {
                    echo "Chưa có dữ liệu";
               } else {
                    while ($row = mysqli_fetch_array($result1)) {
                         echo "<div class='col mb-4 p-2'><a href='detail_film.php?maPhim=" . $row["MaPhim"] . "'>
                              <div class='card bg-transparent' style='border: none;'>
                              <img src='../Films/" . $row["Poster"] . "' style='width: 285px; height: 340px; border-radius:10px; border: 3px solid black'>
                              <div class='card-body p-0'>
                                   <p class='card-text'>" . $row['TenPhim'] . "</p>
                              </div>
                         </div></a>
                         </div>";
                    }
               }
               ?>
          </div>
          <div>
               <?php
               if (mysqli_num_rows($result) > $rowsPerPage) {
                    echo "<center style='font-size:20px;'>";

                    if ($_GET['page'] >= 2) {
                         echo "<a class='btn btn-outline-primary badge p-2' href=" . $_SERVER['PHP_SELF'] . "?page="
                              . 1 . "><<</a>";
                         echo "<a class='btn btn-outline-primary badge p-2' href=" . $_SERVER['PHP_SELF'] . "?page="
                              . ($_GET['page'] - 1) . "><</a> ";
                    } else {
                         echo "<a class='btn btn-outline-primary badge p-2 disabled' href=" . $_SERVER['PHP_SELF'] . "?page="
                              . 1 . "><<</a>";
                         echo "<a class='btn btn-outline-primary badge p-2 badge disabled' href=" . $_SERVER['PHP_SELF'] . "?page="
                              . ($_GET['page']) . "><</a> ";
                    }

                    for ($i = 1; $i <= $maxPage; $i++) {
                         if ($i == $_GET['page']) {
                              echo "<a class='btn btn-outline-danger badge p-2 disabled font-weight-bold' href=" . $_SERVER['PHP_SELF'] . "?page="
                                   . $i . ">" . $i . "</a> ";
                         } else
                              echo "<a class='btn btn-outline-primary badge p-2 badge' href=" . $_SERVER['PHP_SELF'] . "?page="
                                   . $i . ">" . $i . "</a> ";
                    }

                    if ($_GET['page'] < $maxPage) {
                         echo "<a class='btn btn-outline-primary badge p-2 badge' href=" . $_SERVER['PHP_SELF'] . "?page="
                              . ($_GET['page'] + 1) . ">></a>";
                         echo "<a class='btn btn-outline-primary badge p-2 badge' href=" . $_SERVER['PHP_SELF'] . "?page="
                              . ($maxPage) . ">>></a>";
                    } else {
                         echo "<a class='btn btn-outline-primary badge p-2 badge disabled' href=" . $_SERVER['PHP_SELF'] . "?page="
                              . ($_GET['page']) . ">></a>";
                         echo "<a class='btn btn-outline-primary badge p-2 badge disabled' href=" . $_SERVER['PHP_SELF'] . "?page="
                              . ($maxPage) . ">>></a>";
                    }

                    echo "</center>";
                    // echo "<p align='center'>Tong so trang la: " . $maxPage . "</p>";
               }
               ?>
          </div>
     </div>
     <?php
     include("../Includes/footer.html");
     mysqli_close($dbc);
     ?>
     </div>

</body>

</html>