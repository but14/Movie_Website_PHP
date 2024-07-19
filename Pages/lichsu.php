<!DOCTYPE html>

<html>

<head>
	<meta charset="utf-8">
	<title>Lịch sử phim</title>
	<!-- CSS only -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"></script>
	<script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.6.0/font/bootstrap-icons.css">
	<link rel="stylesheet" type="text/css" href="../Styles/style_01.css">
</head>

<body style="background: url('../Images/bg-haloween.png') black no-repeat top center;">
	<div class="container-fluid p-1 bg-dark " style="max-width: 1280px; border-left: 2px black solid;border-right: 2px black solid; background: linear-gradient(90deg, rgba(2,0,36,1) 0%, rgba(56,15,91,1) 50%, rgba(0,0,0,1) 100%);">
		<?php include("../Includes/Header.php"); ?>
		<div class="row p-0 m-0 row-cols-1 row-cols-md-2 justify-content-center">
			<?php
			if (!(isset($_SESSION['mnd'])))
				header("location: home.php");
			else
				$mnd = $_SESSION['mnd'];
			if (!isset($_GET['page'])) {
				$_GET['page'] = 1;
			}
			$rowsPerPage = 10;
			$offset = ($_GET['page'] - 1) * $rowsPerPage;
			$strSQL = "SELECT * FROM lichsu where MaNguoiDung='$mnd' order by ThoiGianXem desc ";
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
					$matapphim = $row[1];
					$tgxp = $row[3];
					$strSQL2 = "SELECT * FROM tapphim join phim on tapphim.MaPhim = phim.MaPhim WHERE tapphim.MaTapPhim = '$matapphim'";
					$result2 = mysqli_query($dbc, $strSQL2);
					$rows = (mysqli_fetch_array($result2));
					$st=$rows["SoTap"];
					$maphim=$rows["MaPhim"];
					$ten = $rows["TenPhim"] . " Tập " . $st;
					$poster = $rows["Poster"];
					echo "<div class='card' style='background:transparent; border:none;'>
							<a href='watch_film.php?maPhim=$maphim&soTap=$st&maTapPhim=$matapphim'>
								<div class='d-flex m-2 bg-dark bg-gradient bg-opacity-50' style='color:blueviolet; border:2px solid #380f5b; border-radius:100px'>
									<img style='border-radius: 50%;height: 100px; width:100px;' src='../Films/$poster' alt='...'>
									<div class='mx-2'>
										<div class='card-body p-0'>
										<h5 class='card-title mt-2'>$ten</h5>
										<p class='card-text badge' >$tgxp</p>
									</div>
									</div>
								</div>
							</a>
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
		<br>

		<?php
          include("../Includes/footer.html");
          mysqli_close($dbc);
          ?>
	</div>
</body>

</html>