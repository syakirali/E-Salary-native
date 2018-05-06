<?php
session_start();
if (isset($_SESSION['level']) && $_SESSION['level'] === "ROOT") {
    ?>
    <!DOCTYPE html>
    <html>
        <head>
            <title>Form Admin</title>
            <link href="./css/formAdmin.css" type="text/css" rel="stylesheet">
        </head>
        <?php
        $link = mysqli_connect("localhost", "root", "", "e-salary");
        if (isset($_POST['pegawai'])){
            $pegawai = explode("-", $_POST['pegawai']);
            $password = $_POST['password'];
            $kpassword = $_POST['kpassword'];
            $data = mysqli_fetch_array(mysqli_query($link, "select * from pegawai where nip='$pegawai[0]'"));
            if (mysqli_query($link, "insert into it_user values('$pegawai[0]', '$password', 'IT')")) {
                ?><script>alert('<?php echo $pegawai[1]; ?> berhasil didaftarkan !');</script><?php
            } else {
                ?><script>alert('Pendaftaran gagal !');</script><?php
            }
        }
        
        if (isset($_GET['hapus'])){
            $nip = $_GET['hapus'];
            if (mysqli_query($link, "delete from it_user where nip='$nip'")){
                ?><script>alert('Admin dengan nip <?php echo $nip; ?> berhasil dihapus !');</script><?php
            } else {
                ?><script>alert('Penghapusan gagal !');</script><?php
            }
            unset($_GET['hapus']);
            ?><script>window.location = "formAdmin.php";</script><?php
        }
        ?>
        <body>
            <script>
                function tambahnol(a){
                    if (a < 10) {
                        return "0"+a;
                    } else {
                        return a;
                    }
                }

                function updateClock() {
                    var sekarang = new Date(), bulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus','September','Oktober','November','Desember'];
                    var hari = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];

                    var jam = tambahnol(sekarang.getHours()) + ':' + tambahnol(sekarang.getMinutes())+':'+tambahnol(sekarang.getSeconds());
                    var h = sekarang.getDay();
                    var tanggal = [sekarang.getDate(), 
                                bulan[sekarang.getMonth()],
                                sekarang.getFullYear()].join(' ');


                    document.getElementById('tanggal').innerHTML = hari[h]+", "+tanggal;
                    document.getElementById('jam').innerHTML = jam;
                    setTimeout(updateClock, 1000);
                }
            </script>
            <div id="admin">
                Admin <i>ROOT</i>
                <div id="tanggal"></div>
                <div id="jam"></div>
                <script>updateClock();</script>
            </div>
            <div id="bawah">
                <div id="listITAdmin">
                    <table>
                        <tr><th>NIP</th><th>Nama</th><th>Password</th><th>Aksi</th></tr>
                    <?php 
                    $it = mysqli_query($link, "select * from it_user");
                    while($dIT = mysqli_fetch_array($it)){
                        $nip = $dIT['nip'];
                        $password = $dIT['password'];
                        if ($nip != '0000'){
                            $m = mysqli_fetch_array(mysqli_query($link, "select * from pegawai where nip='$nip'"));
                            $nama = $m['nama'];
                            echo "
                        <tr>
                            <td>$nip</td>
                            <td>$nama</td>
                            <td>$password</td>
                            <td id=\"aksi\"><a href=\"formAdmin.php?hapus=$nip\" onclick=\"return confirm('Apakah anda yakin ingin menghapus admin NIP $nip ?')\">Hapus</a></td>
                        </tr>
                            ";
                        }
                    }
                    ?>
                    </table>
                </div>
                <div id="kanan">
                    <p id="c"></p>
                    <div id="input">
                        <div id="judulForm">Form Admin</div>
                        <script>
                            function check(){
                                var a = document.getElementById('pegawai');
                                
                                if (a[a.selectedIndex].value === "-kosong-") {
                                    alert('Pegawai kosong !');
                                    return false;
                                }
                                
                                if(document.getElementById('password').value !== document.getElementById('kpassword').value){
                                    alert('Password tidak valid !');
                                    return false;
                                }
                                return true;
                            }
                        </script>
                        <form id="form" action="formAdmin.php" method="POST" onsubmit="return check()">
                            <select id="pegawai" name="pegawai" autofocus><?php
                            $result = mysqli_query($link, "select * from pegawai where jabatan='IT'");
                            while($data = mysqli_fetch_array($result)){
                                $nip=$data['nip'];
                                $result2 = mysqli_query($link, "select * from it_user where nip='$nip'");
                                if(mysqli_num_rows($result2) === 0){
                                    $nama=$data['nama'];
                                    $nip = $data['nip'];
                                    echo "<option value=\"$nip-$nama\" onselect=\"setNip($nip)\">$nip  -  $nama</option>";
                                }
                            }
                            ?>
                                <option>-kosong-</option>
                            </select>
                            <input type="password" id="password" name="password" placeholder="Password" required>
                            <input type="password" id="kpassword" name="kpassword" placeholder="Konfirmasi Password" required>
                            <input id="submit" type="submit" value="Daftar">
                        </form>
                    </div>
                    <div id="nav_menu">
                        <a href="index.php">Beranda</a>
                        <a href="tampilPegawai.php">Tampil Pegawai</a>
                        <a href="formPegawai.php">Form Pegawai</a>
                        <a href="logout.php">Keluar</a>
                    </div>
                    <p id="konf"></p>
                </div>
            </div>
        </body>
    </html>
<?php
        mysqli_close($link);
} else {
    session_destroy();
    ?><script>alert('Dibutuhkan akses ROOT !');</script><?php
    $_SESSION['url'] = "formAdmin.php";
    include_once 'loginForm.php';
}
