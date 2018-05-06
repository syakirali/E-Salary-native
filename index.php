<!DOCTYPE html>
<html>
    <head>
        <title>
            Beranda
        </title>
        <link href="./css/index.css" rel="stylesheet" type="text/css">
    </head>
    <?php
    session_start();
    if(isset($_POST['nip'])) {
        $nip = $_POST['nip'];
        $link = mysqli_connect("localhost", "root", "", "e-salary");
        $result = mysqli_query($link, "select * from pegawai where nip='$nip'");
        if (mysqli_num_rows($result) > 0) {
            date_default_timezone_set('Asia/Jakarta');
            $tanggal = date("Y-m-d");
            $jam =  date("H:i:s");
            if (mysqli_num_rows(mysqli_query($link, "select * from absensi where nip='$nip' and tanggal='$tanggal'")) == 0){
                if (mysqli_query($link, "insert into absensi(tanggal, nip, jam) values('$tanggal','$nip', '$jam')")){
                    $data = mysqli_fetch_array($result);
                    ?><script>alert('Selamat Datang, <?php echo $data['nama'];?> !');</script><?php
                } else {
                    ?><script>alert('Absen gagal !');</script><?php
                }
            } else {
                ?><script>alert('Anda telah absen hari ini !');</script><?php
            }
        } else {
            ?><script>alert('NIP anda tidak terdaftar !');</script><?php
        }
        ?><script>window.location=('index.php');</script><?php
        mysqli_close($link);
    }
    ?>
    <body>
        <?php include_once 'kehadiranHariIni.php';?>
        <div id="kanan">
            <div id="kanan_atas">
                <div id="judul_kiri">
                    <div id="text-center">Absensi Karyawan</div>
                </div>

                <div id="judul_kanan">
                    <div id="tanggal"></div>
                    <div id="jam"></div>
                </div>

            </div>

            <div id="kanan_tengah">
                
                <form action="index.php" method="POST" onsubmit="return check()">
                    <div id="inputAbsen">
                        <input type="text" id="nip" name="nip" placeholder="Nomor Induk Pegawai" required>
                    </div>
                    <div id="submitAbsen">
                        <input type="submit" id="submit" value="Absen">
                    </div>
                </form>

            </div>
            
            <footer id="kanan_bawah">
                <a id="login" href="formPegawai.php">Form Pegawai</a>
                <a id="login2" href="tampilPegawai.php">Tampil Pegawai</a>
                <?php if(isset($_SESSION['nip'])){
                ?>
                <a id="login2" href="logout.php">Keluar</a>
                <?php    
                }
                ?>
            </footer>
        </div>
        <div id="adm">
            <a href="formAdmin.php">Form Admin</a>
        </div>
    </body>
    
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
        updateClock(); // initial call
        document.getElementById('nip').focus();
        
        function check(){
            if (isNaN(document.getElementById('nip').value)) {
                alert('Nilai NIP harus berupa angka !');
                return false;
            }

            if (document.getElementById('nip').value.length !== 4) {
                alert('Angka harus 4 digit !');
                return false;
            }

            return true;
        }
    </script>
</html>
