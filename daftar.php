<?php
session_start();
if (isset($_SESSION['nip'])) {
    $nip = $_POST['nip'];
    $nama = $_POST['nama'];
    $tempat = $_POST['tempat'];
    $tanggal = $_POST['tanggal'];
    $alamat = $_POST['alamat'];
    $noHp = $_POST['noHp'];
    $jabatan = $_POST['jabatan'];
    date_default_timezone_set('Asia/Jakarta');
    $tmasuk = date("Y-m-d");
    $link = mysqli_connect("localhost", "root", "", "e-salary");
    if (mysqli_num_rows(mysqli_query($link, "select * from pegawai where nip='$nip'")) > 0){
        if (mysqli_query($link, "update pegawai set nama='$nama', tempat='$tempat', tanggal='$tanggal', alamat='$alamat', telp='$noHp', jabatan='$jabatan' where nip='$nip'")) {
            ?>
            <script>
                alert('Update sukses!');
            </script>
            <?php
            if($jabatan !== "IT"){
                if (mysqli_num_rows(mysqli_query($link, "select * from it_user where nip='$nip'")) > 0){
                    if (mysqli_query($link, "delete from it_user where nip='$nip'")){
                        ?><script>alert('IT user dengan nip <?php echo $nip;?> dihapus');</script><?php
                    }
                }
            }
        } else {
            ?>
            <script>
                alert('Update gagal!');
            </script>
            <?php
        }
        ?>
        <script>
            window.location="tampilPegawai.php";
        </script>
        <?php
    } else {
        if (mysqli_query($link, "insert into pegawai(nip, nama, tempat, tanggal, alamat, telp, jabatan, tmasuk) values('$nip', '$nama', '$tempat', '$tanggal', '$alamat', '$noHp', '$jabatan', '$tmasuk')")){
            ?>
            <script>
                alert('Daftar sukses!');
            </script>
            <?php
        } else {
            ?>
            <script>
                alert('Daftar gagal!');
            </script>
            <?php
        }
        ?>
        <script>
            window.location="formPegawai.php";
        </script>
        <?php
    }
    mysqli_close($link);
} else {
    header("location: index.php");
}
