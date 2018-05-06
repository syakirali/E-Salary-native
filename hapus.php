<!DOCTYPE html>
<html>
    <head><title>system</title></head>
    <body>
        
    </body>
</html>
<?php
session_start();
if (isset($_SESSION['nip'])) {
    if(isset($_GET['nip'])){
        $nip = $_GET['nip'];
        $link = mysqli_connect("localhost", "root", "", "e-salary");
        
        if (mysqli_query($link, "delete from pegawai where nip=$nip")){
            mysqli_query($link, "delete from absensi where nip=$nip");
            mysqli_query($link, "delete from it_user where nip=$nip");
            ?>
            <script>
                alert('data dengan nip <?php echo $nip?> berhasil dihapus !');
                window.location="tampilPegawai.php";
            </script>
            <?php
        } else {?>
            <script>
                alert('gagal menghapus !');
                window.location="tampilPegawai.php";
            </script>
            <?php
        }
        mysqli_close($link);
    }
} else {
    header("location: index.php");
}
