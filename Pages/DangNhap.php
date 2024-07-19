<html lang="en">

<head>
     <meta charset="UTF-8">
     <meta http-equiv="X-UA-Compatible" content="IE=edge">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.6.0/font/bootstrap-icons.css">
     <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
     <link rel="stylesheet" type="text/css" href="../Styles/style_01.css">
     <title>Đăng nhập</title>
</head>

<body style="background: url('../Images/backgr.png') black no-repeat top center;">
     <div class="container-fluid p-1 bg-dark " style="max-width: 1280px; border-left: 2px black solid;border-right: 2px black solid; background: linear-gradient(90deg, rgba(2,0,36,1) 0%, rgba(56,15,91,1) 50%, rgba(0,0,0,1) 100%);">
          <?php

          //Thêm đường đường dẫn của trang header vào trang web
          include("../Includes/Header.php");
          
          //Khởi tạo cái biến $ac = 0 biến này dùng để làm gì thì xíu nữa mới bíc nha
          // $ac = 0;
          // Nếu biến $_POST['dn_sm'] tồn tại, tức là người dùng đã nhấn nút Đăng nhập
          // 'dn_sm' tức là đăng nhập submit
          if (isset($_POST['dn_sm'], $_POST['dn_tk'], $_POST['dn_mk'])) {
               //Truyền giá trị của các input vào hàm kiem tra đăng
               $tk = $_POST['dn_tk'];
               $mk = $_POST['dn_mk'];
               //Thực hiện truy vấn để kiểm tra tài khoản và mật khẩu có tồn tại trong database hay không
               $strSQL = "SELECT * FROM nguoidung where TaiKhoan='$tk' and MatKhau='$mk'";
               $result = mysqli_query($dbc, $strSQL);
               //Nếu kết quả trả về của truy vấn là rỗng, tức là tài khoản hoặc mật khẩu không đúng
               //Nếu kết quả trả về của truy vấn không rỗng tức là tk và mk đúng
               if (mysqli_num_rows($result) == 0)
                    $dn_tb = "Tài khoản hoặc mật khẩu không đúng !";
               else {
                    $r = mysqli_fetch_array($result);
                    $mnd = $r["MaNguoiDung"];
                    $_SESSION["nd"] = $tk;
                    $_SESSION["mnd"] = $mnd;
                    //Nếu có tồn tại các thông tin như tk và mk sẽ được lưu vào trong biến session
                    //Nếu người dùng nhập vào tài khoản có quyền admin tức là $r sẽ bằng 1 thì sẽ lưu thông tin vào biến session isadmin
                    if ($r["Admin"] == 1)
                         $_SESSION["IsAdmin"] = 1;
               }
          }

          //Đây là phần thêm các thông tin đăng ký tài khoản mới
          if (isset($_POST['dk_sm'], $_POST['dk_tk'], $_POST['dk_mk2'], $_POST['dk_mk2'])) {
               $tk = $_POST['dk_tk'];
               $mk1 = $_POST['dk_mk1'];
               $mk2 = $_POST['dk_mk2'];
               //khởi tạo một biến ac bằng 1
               $ac = 1;//biến này được sử dụng để đánh dấu các trạng thái đăng nhập của người dùng
               //thực hiện truy vấn SQL 
               $strSQL = "SELECT * FROM nguoidung where TaiKhoan='$tk'";
               $result = mysqli_query($dbc, $strSQL);
               //thực hiện tạo format cho phần mật khẩu
               //Nếu mật khẩu không chưa ký tự đặc biệt hoặc khoảng trống và có ít nhất 6 ký tự, thì thực hiện đăng ký
               if (preg_match('/^[0-9a-zA-Z]{6,}+$/', $tk))
                    if (preg_match('/^[0-9a-zA-Z]{6,}+$/', $mk1))
                         if ($mk1 == $mk2)
                              if (mysqli_num_rows($result) == 0) {
                                   //Thêm tai khoản vào database
                                   $strSQL = "INSERT INTO `nguoidung`(`TaiKhoan`, `MatKhau`) VALUES ('$tk','$mk1')";
                                   $result = mysqli_query($dbc, $strSQL);
                                   //Thực hiện lấy thông tin người dùng vừa đăng ký
                                   $strSQL = "SELECT * FROM nguoidung where TaiKhoan='$tk'";
                                   $result = mysqli_query($dbc, $strSQL);
                                   $r = mysqli_fetch_array($result);
                                   $mnd = $r["MaNguoiDung"];
                                   $_SESSION["nd"] = $tk;
                                   $_SESSION["mnd"] = $mnd;
                                   //Nếu người dùng có quyền admin thì lưu thông tin vào biến session admin
                                   if ($r["Admin"] == 1)
                                        $_SESSION["IsAdmin"] = 1;
                                   //chuyển hướng đến trang chủ
                              header("location: home.php");
                              } else
                                   $dk_tb = "Tài khoản đã tồn tại";
                         else
                              $dk_tb = "Mật khẩu xác nhận không đúng";
                    else
                         $dk_tb = "Mật khẩu không được chứa ký tự đặc biệt hoặc khoảng trống và phải hơn 6 ký tự";
               else
                    $dk_tb = "Tài khoản không được chứa ký tự đặc biệt hoặc khoảng trống và phải hơn 6 ký tự";
          }
          //Nếu tài khoản là admin thì chuyển hướng đến trang admin
          if (isset($_SESSION["IsAdmin"]))
               header("location: ../Admin/Index.php");
          else
          //Nếu người dùng bình thường chuyển hướng đến trang home
          if (isset($_SESSION["nd"]))
               header("location: home.php");
          ?>
          <div style="min-height:720px;">
               <div class=" container col-4 bg-white p-5 my-5" align="center" style="border:3px black solid; border-radius:25px; min-width:320px; ">
                    <nav>
                         <div class="nav nav-tabs" id="nav-tab" role="tablist">
                              <button class='nav-link <?php if ($ac == 0) echo "active"; ?>' id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Đăng nhập</button>
                              <button class='nav-link <?php if ($ac != 0) echo "active"; ?>' id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Đăng ký</button>
                         </div>
                    </nav>
                    <div class="tab-content" id="nav-tabContent">
                         <div class='tab-pane fade <?php if ($ac == 0) echo "show active"; ?> ' id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                              <form action="" method="post">
                                   </br>
                                   <div class="mb-3">
                                        <input type="text" name="dn_tk" class="form-control" placeholder=" Tài khoản" required>
                                   </div>
                                   <div class="mb-3">
                                        <input type="password" name="dn_mk" class="form-control" placeholder=" Mật khẩu" required>
                                   </div>
                                   <div class="mb-3" style="color:blue">
                                        <?php if (isset($dn_tb)) echo $dn_tb ?>
                                   </div>
                                   <button type="submit" name="dn_sm" class="btn btn-primary">Đăng nhập</button>
                              </form>
                         </div>
                         <div class='tab-pane fade <?php if ($ac != 0) echo "show active"; ?>' id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                              <form action="" method="post">
                                   </br>
                                   <div class="mb-3">
                                        <input type="text" name="dk_tk" class="form-control" placeholder=" Tài khoản" required>
                                   </div>
                                   <div class="mb-3">
                                        <input type="password" name="dk_mk1" class="form-control" placeholder=" Mật khẩu" required>
                                   </div>
                                   
                                   <div class="mb-3">
                                        <input type="password" name="dk_mk2" class="form-control" placeholder=" Mật khẩu" required>
                                   </div>
                                   <div class="mb-3" style="color:blue">
                                        <?php if (isset($dk_tb)) echo $dk_tb ?>
                                   </div>
                                   <button type="submit" name="dk_sm" class="btn btn-primary">Đăng ký</button>
                              </form>
                         </div>
                    </div>
               </div>

          </div>
          <?php
          include("../Includes/footer.html");
          mysqli_close($dbc);
          ?>
     </div>

</body>

</html>