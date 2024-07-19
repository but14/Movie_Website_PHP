<?php
require("connect.php");
session_start();
if (isset($_POST['dx'])) {
     if (isset($_SESSION['nd']))
          unset($_SESSION["nd"]);
     if (isset($_SESSION['IsAdmin']))
          unset($_SESSION["IsAdmin"]);
     header("location: DangNhap.php");
}
if(strpos($_SERVER['REQUEST_URI'],"Pages/DangNhap.php")>-1){
     if (isset($_SESSION['nd']))
          header("location: Home.php");
     if (isset($_SESSION['IsAdmin']))
          unset($_SESSION["IsAdmin"]);
}
if(strpos($_SERVER['REQUEST_URI'],"Pages/lichsu.php")>-1){
     if (!isset($_SESSION['nd']))
          header("location: DangNhap.php");
}
if(strpos($_SERVER['REQUEST_URI'],"Pages/tuphim.php")>-1){
     if (!isset($_SESSION['nd']))
          header("location: DangNhap.php");
}
?>
<style>
     * {
          margin: 0;
          padding: 0;
     }

     a {
          text-decoration: none;
     }

     .dropdown-item {
          color: white;
     }

     .dropdown-item:hover {
          color: red;
     }

     #home:hover {
          filter: drop-shadow(0 0 10px blue);
          font-style: italic;
          font-weight: bold;
     }

     .card {
          color: blueviolet;
     }

     .card:hover {
          filter: drop-shadow(0 0 5px blue);
          font-style: italic;
          font-weight: bold;
          color: White;
     }
</style>
<div class="container-fruild">
     <nav class="navbar navbar-expand-md navbar-dark area p-2 rounded" style="background: linear-gradient(90deg, rgba(2,0,36,1) 0%, rgba(56,15,91,1) 50%, rgba(0,0,0,1) 100%); border: 3px solid #380f5b; font-size:20px;">
          <a class="badge mb-2" id="home" href="home.php" style='text-decoration: none; color: blueviolet;'><span style="font-size: 30px;"><i class='far fa-play-circle mt-2' style='font-size:30px'></i>Phim11</span></a>
          <button class="navbar-toggler " type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
               <span><i class="bi bi-search"></i></span>
          </button>
          <div class="collapse navbar-collapse p-0" id="navbarTogglerDemo01">
               <form class="form-inline d-flex flex-grow-1 px-2 p-0" action="Search.php" method="post">
                    <input class="form-control d-flex flex-grow-1 w-25 p-0" style="min-width:100px;" type="search" name="search_info" placeholder=" Nhập thông tin tìm kiếm" aria-label="Search">
                    <button class="badge btn btn-outline-success p-2" style="margin-left: 10px;" name="search_btn" type="submit">Tìm kiếm</button>
               </form>
          </div>

          <div>
               <a href="LookUp.php" class=" badge btn btn-outline-primary p-2">Danh Mục</a>
               <!-- <a href="#" class="btn btn-outline-primary">Lịch sử</a>
                    <a href="#" class="btn btn-outline-primary">Hộp phim</a> -->
               <!-- Button trigger modal -->
               <?php if (isset($_SESSION['nd'])) {
                    $nd = $_SESSION['nd'];
                    echo "<div class='dropdown mx-1 ' style='display:inline-block;' >
                         <button class='badge btn btn-outline-danger dropdown-toggle p-2 px-3'  type='button' id='dropdownMenuButton1' data-bs-toggle='dropdown' aria-expanded='false' style='font-size:16px;'>
                         <i class='bi bi-person-circle'></i>
                         </button>
                         <ul class='dropdown-menu bg-danger' aria-labelledby='dropdownMenuButton1' style='min-width: 100px;'>
                              <li><center style='font-weight:bold;'>$nd</center></li>
                              <li><center><hr class='m-0 w-75'style='color:white'></center></li>
                              <li><a href='lichsu.php' class='dropdown-item' >Lịch sử</a></li>
                              <li><a href='tuphim.php' class='dropdown-item' >Tủ phim</a></li>
                              <li><form action='' class='dropdown-item' method='post'><input type='submit' name='dx' value='Đăng xuất' style='border:none; background:none;'></form></li>
                         </ul>
                    </div>";
               } else echo "<a href='DangNhap.php' class='badge btn btn-outline-danger p-2'>Đăng nhập</a>";
               ?>
          </div>
     </nav>
</div>