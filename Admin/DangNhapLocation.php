<!-- khối verify -->
<?php 
if (!(isset($_SESSION["IsAdmin"])))
    header('Location: ../../Pages/DangNhap.php');
?>