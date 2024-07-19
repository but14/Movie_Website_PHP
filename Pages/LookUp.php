<!DOCTYPE html>
<html lang="en">

<head>
     <meta charset="UTF-8">
     <meta http-equiv="X-UA-Compatible" content="IE=edge">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Tra cứu</title>
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.6.0/font/bootstrap-icons.css">
     <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
     <link rel="stylesheet" type="text/css" href="../Styles/style_01.css">
     <style>
          * {
               margin: 0;
               padding: 0;
          }

          .filterDiv {
               display: none;
          }

          .area {
               text-align: center;
               border: 1px black solid;
               margin-bottom: 20px;
          }

          a {
               text-decoration: none;
          }

          img:hover {
               filter: drop-shadow(0 0 10px blue);
               font-style: italic;
               font-weight: bold;
          }

          .btn.active {
               color: blueviolet;
          }

          .show.show1 {
               display: block;
          }
     </style>
</head>

<body style="background: url('../Images/backgr.png') black no-repeat top center;">
     <div class="container-fluid p-0 " style="max-width: 1280px; border: 2px black solid; background: linear-gradient(90deg, rgba(2,0,36,1) 0%, rgba(56,15,91,1) 50%, rgba(0,0,0,1) 100%);">
          <?php include("../Includes/Header.php"); ?>
          <div class="area bg-dark" style="color:blueviolet; background: linear-gradient(90deg, rgba(2,0,36,1) 0%, rgba(56,15,91,1) 50%, rgba(0,0,0,1) 100%);">
               <h2>Thể loại</h2>
               <div id="myBtnContainer">
                    <?php
                    $strSQL_tl = "SELECT * FROM  theloai";
                    $result_tl = mysqli_query($dbc, $strSQL_tl);
                    if (mysqli_num_rows($result_tl) == 0) {
                         echo "Chưa có dữ liệu";
                    } else {
                         while ($row = mysqli_fetch_array($result_tl)) {
                              $mtl = $row[0];
                              $tl = $row[1];
                              echo "<span class='btn badge bg-dark bg-gradient p-2 m-2 $mtl' style='border: 1px blueviolet solid;' onclick=" . 'filterSelection(' . "'$mtl'" . ')' . ">$tl</span>";
                         }
                    }
                    ?>
               </div>
               <h2>Quốc gia</h2>
               <div id="myBtnContainer2">
                    <?php
                    echo "<span class=' active btn badge bg-dark bg-gradient p-2 m-2 all' style='border: 1px blueviolet solid;' onclick=" . 'filterSelection2(' . "'all'" . ')' . ">Tất cả</span>";
                    $strSQL_qg = "SELECT * FROM  quocgia";
                    $result_qg = mysqli_query($dbc, $strSQL_qg);
                    if (mysqli_num_rows($result_qg) == 0) {
                         echo "Chưa có dữ liệu";
                    } else {
                         while ($row = mysqli_fetch_array($result_qg)) {
                              $mtl = "qg-" . $row[0];
                              $tl = $row[1];
                              echo "<span class='btn badge bg-dark bg-gradient p-2 m-2 $mtl' style='border: 1px blueviolet solid;' onclick=" . 'filterSelection2(' . "'$mtl'" . ')' . ">$tl</span>";
                         }
                    }
                    ?>
               </div>

          </div>
          <div class="area p-2 bg-dark" style="min-height: 500px ;color:blueviolet;background: linear-gradient(90deg, rgba(2,0,36,1) 0%, rgba(56,15,91,1) 50%, rgba(0,0,0,1) 100%);">
               <h1>Danh sách Phim</h1>
               <div class="row no-gutters row-cols-2 row-cols-md-4">
                    <?php
                    if (!isset($_GET['page'])) {
                         $_GET['page'] = 1;
                    }
                    $strSQL1 = "SELECT * FROM  phim order by ThoiGianThemPhim desc ";
                    $result = mysqli_query($dbc, $strSQL1);
                    if (mysqli_num_rows($result) == 0) {
                         echo "";
                    } else {
                         while ($row = mysqli_fetch_array($result)) {
                              $mp = $row["MaPhim"];
                              $strSQL2 = "SELECT phim_theloai.MaTheLoai, phim.MaQG FROM  phim join phim_theloai on phim.MaPhim=phim_theloai.MaPhim where phim.MaPhim='$mp'";
                              $result2 = mysqli_query($dbc, $strSQL2);
                              $_tl = "";
                              $_qg = "";
                              if (mysqli_num_rows($result) != 0)
                                   while ($row1 = mysqli_fetch_array($result2)) {
                                        $_tl .= " " . $row1["MaTheLoai"];
                                        $_qg .= " qg-" . $row1["MaQG"];
                                   };
                              echo "<div class='filterDiv col mb-4 p-2 $_tl $_qg'><a href='detail_film.php?maPhim=" . $row["MaPhim"] . "'>
                              <div class='card bg-transparent' style='border: none;'>
                              <img src='../Films/" . $row["Poster"] . "' style=' width: 285px; height: 340px; border-radius:10px; border: 3px solid black'>
                              <div class='card-body p-0'>
                                   <p class='card-text'style='color:blueviolet' >" . $row['TenPhim'] . "</p>
                              </div>
                         </div></a>
                         </div>";
                         }
                    }
                    ?>
               </div>
          </div>
     </div>
     <?php
     include("../Includes/footer.html");
     mysqli_close($dbc);
     ?>
     <script>
          var arr = [];
          filterSelection2("all")

          function filterSelection(c) {
               var x, i;
               if (c == "all") c = "";
               if (!(arr.indexOf(c) > -1))
                    arr.push(c);
               else
                    arr.splice(arr.indexOf(c), 1);
               x = document.getElementsByClassName("filterDiv");

               for (i = 0; i < x.length; i++) {
                    w3RemoveClass(x[i], "show");
                    for (var j = 0; j < arr.length; j++) {
                         if (!(x[i].className.indexOf(arr[j]) > -1))
                              break;
                         else
                         if (j + 1 == arr.length)
                              w3AddClass(x[i], "show");
                    }
               }
          }

          function filterSelection2(c) {
               var x, i;
               x = document.getElementsByClassName("filterDiv");
               if (c == "all") c = "";
               for (i = 0; i < x.length; i++) {
                    w3RemoveClass(x[i], "show1");
                    if (x[i].className.indexOf(c) > -1) w3AddClass(x[i], "show1");
               }
          }

          function w3AddClass(element, name) {
               var i, arr1, arr2;
               arr1 = element.className.split(" ");
               arr2 = name.split(" ");
               for (i = 0; i < arr2.length; i++) {
                    if (arr1.indexOf(arr2[i]) == -1) {
                         element.className += " " + arr2[i];
                    }
               }
          }

          function w3RemoveClass(element, name) {
               var i, arr1, arr2;
               arr1 = element.className.split(" ");
               arr2 = name.split(" ");
               for (i = 0; i < arr2.length; i++) {
                    while (arr1.indexOf(arr2[i]) > -1) {
                         arr1.splice(arr1.indexOf(arr2[i]), 1);
                    }
               }
               element.className = arr1.join(" ");
          }
          // Add active class to the current button (highlight it)
          var btnContainer = document.getElementById("myBtnContainer");
          var btns = btnContainer.getElementsByClassName("btn");
          for (var i = 0; i < btns.length; i++) {
               btns[i].addEventListener("click", function() {
                    if ((this.className.indexOf("active") > -1))
                         this.className = this.className.replace(" active", "");
                    else
                         this.className += " active";
               });
          }
          var btnContainer2 = document.getElementById("myBtnContainer2");
          var btns2 = btnContainer2.getElementsByClassName("btn");
          for (var i = 0; i < btns2.length; i++) {
               btns2[i].addEventListener("click", function() {
                    var current = btnContainer2.getElementsByClassName("active");
                    if (current.length > 0)
                         current[0].className = current[0].className.replace(" active", "");
                    this.className += " active";
               });
          }
     </script>
</body>

</html>