<!DOCTYPE html>

<html>

<head>
	<meta charset="utf-8">
	<title>Tủ phim</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"></script>
	<script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.6.0/font/bootstrap-icons.css">
	<link rel="stylesheet" type="text/css" href="../Styles/style_01.css">
	<style>
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
		<div class="row no-gutters row-cols-3 row-cols-md-5 " align="center">
			<?php
			//truy vấn dữ liệu từ table tủ phim
			$strSQL = "SELECT * FROM tuphim";
			$result = mysqli_query($dbc, $strSQL);
			if (!(isset($_SESSION['mnd'])))
				header("location: home.php");
			else
				$mnd = $_SESSION['mnd'];
			if (!isset($_GET['page'])) {
				$_GET['page'] = 1;
			}
			echo $_SESSION["mnd"];
			if (isset($_POST['del_sm'])) {
				$mp = $_POST['mp'];
				$mnd = $_SESSION["mnd"];
				$sql_del = "DELETE FROM `tuphim` WHERE MaPhim='$mp' and MaNguoiDung='$mnd'";
				$r = mysqli_query($dbc, $sql_del);
			}
			$rowsPerPage = 20;
			$offset = ($_GET['page'] - 1) * $rowsPerPage;
			$strSQL = "SELECT * FROM tuphim a join phim b on a.MaPhim =b.MaPhim where MaNguoiDung='$mnd'";
			//tổng số mẩu tin cần hiển thị
			$numRows = mysqli_num_rows(mysqli_query($dbc, $strSQL));
			//tổng số trang
			$maxPage = ceil($numRows / $rowsPerPage);
			$strSQL1 = $strSQL . "LIMIT $offset, $rowsPerPage";
			$result = mysqli_query($dbc, $strSQL);
			$result1 = mysqli_query($dbc, $strSQL1);
			if (mysqli_num_rows($result1) == 0) {
				echo "";
			} else {
				while ($row = mysqli_fetch_array($result1)) {
					$mp = $row["MaPhim"];
					echo "<div class='col mb-4 p-2'>
						<a href='detail_film.php?maPhim=" . $row["MaPhim"] . "'>
                              <div class='card bg-transparent' style='border: none;'>

                              <img src='../Films/" . $row["Poster"] . "' style='border-radius:10px; border: 3px solid black'>
						<form action='' method='post' align='end' class='p-0 card-img-overlay '><input value='$mp' class='d-none' name='mp'><button class =' p-0 px-1 bg-gradient rounded btn btn-danger'style='font-size:30px; border: 1px red solid; margin:3px;' type='submit' name='del_sm'> <i class='bi bi-trash'></i></button></form>
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
			//kiểm tra xem số hàng trong tập kết quả có lớn hơn số hàng cần hiển thị trên mỗi trang
			if (mysqli_num_rows($result) > $rowsPerPage) {
				//Hiển thị phân trang
				echo "<center style='font-size:20px;'>";
				//nếu người đung đang ở trang 2 trở lên, hiển thị liên kết trang trước và tragn đầu tiên
				if ($_GET['page'] >= 2) {
					echo "<a class='btn btn-outline-primary badge p-2' href=" . $_SERVER['PHP_SELF'] . "?page="
						. 1 . "><<</a>";
					echo "<a class='btn btn-outline-primary badge p-2' href=" . $_SERVER['PHP_SELF'] . "?page="
						. ($_GET['page'] - 1) . "><</a> ";
				} else {
					//Vô hiệu quá liên kết đến tragn trước và tragn đầu tiên nếu người dùng đã ở trang đầu tiên
					echo "<a class='btn btn-outline-primary badge p-2 disabled' href=" . $_SERVER['PHP_SELF'] . "?page="
						. 1 . "><<</a>";
					echo "<a class='btn btn-outline-primary badge p-2 badge disabled' href=" . $_SERVER['PHP_SELF'] . "?page="
						. ($_GET['page']) . "><</a> ";
				}
				//Lặp các trang và hiển thị liên kết đến mỗi trang
				for ($i = 1; $i <= $maxPage; $i++) {
					if ($i == $_GET['page']) {
						//vô hiệu hóa trang hiện tại
						echo "<a class='btn btn-outline-danger badge p-2 disabled font-weight-bold' href=" . $_SERVER['PHP_SELF'] . "?page="
							. $i . ">" . $i . "</a> ";
					} else
					//Hiển thị liên kết các trang
						echo "<a class='btn btn-outline-primary badge p-2 badge' href=" . $_SERVER['PHP_SELF'] . "?page="
							. $i . ">" . $i . "</a> ";
				}

				//Nếu người dùng đang ở trang 1 trở xuống, hãy hiển thị liên kết đến các trang tiếp theo
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
		<br>
		<?php
		include("../Includes/footer.html");
		mysqli_close($dbc);
		?>
	</div>
</body>

</html>