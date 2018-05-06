<?php
session_start();
if (!isset($_SESSION['nip'])){
    $_SESSION['url'] = "formPegawai.php";
    include_once 'loginForm.php';
} else {
    function cariNip(){
        $link = mysqli_connect("localhost", "root", "", "e-salary");
        $hasil = mysqli_query($link, "select * from pegawai order by 1");
        $count = 0;

        while ($data = mysqli_fetch_array($hasil)){
            $dnip = $data['nip'];
            if ($count != (int)$dnip) {
                break;
            }
            $count++;
        }

        mysqli_close($link);

        if ($count < 10) {
            return "000$count";
        } else if ($count < 100) {
            return "00$count";
        } else if ($count < 1000) {
            return "0$count";
        } else {
            return "$count";
        }
    }
    $nip;
    $nama;
    $tempat;
    $tanggal;
    $alamat;
    $noHp;
    $jabatan;
    $proses;
    if(isset($_GET['nip'])){
        $nip = $_GET['nip'];
        $link = mysqli_connect("localhost", "root", "", "e-salary");
        $result = mysqli_query($link, "select * from pegawai where nip='$nip'");
        $data = mysqli_fetch_array($result);
        $nama = $data['nama'];
        $tempat = $data['tempat'];
        $tanggal = $data['tanggal'];
        $alamat = $data['alamat'];
        $noHp = $data['telp'];
        $jabatan = $data['jabatan'];
        $proses = "Edit";
    } else {
        $nip = cariNip();
        $nama = "";
        $tempat = "";
        $tanggal = "";
        $alamat = "";
        $noHp = "";
        $jabatan = "Staf";
        $proses = "Daftar";
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Form Pegawai</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="./css/formPegawai.css">
    </head>
    <body>
        <script>
            function check(){
                var tanggal = document.getElementById('tanglah').value.split("-");
                if (tanggal.length !== 3) {
                    alert('Format tanggal salah !');
                    document.getElementById('tanglah').focus();
                    return false;
                } else {
                    validDate = new Date();
                    validDate.setTime((new Date(tanggal[0], parseInt(tanggal[1])-1, tanggal[2])).getTime());
                    
                    if (validDate.getDate() !== parseInt(tanggal[2])){
                        alert('Tanggal tidak valid !');
                        document.getElementById('tanglah').focus();
                        return false;
                    }
                    
                    if (validDate.getMonth() !== (parseInt(tanggal[1])-1)){
                        alert('Bulan tidak valid !');
                        document.getElementById('tanglah').focus();
                        return false;
                    }
                }
                
                if (isNaN(document.getElementById('noHp').value)){
                    alert('Nomor Handpone tidak valid !');
                    document.getElementById('noHp').focus();
                    return false;
                }
                return true;
                
            }
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
        
        <div id="header">
            <div id="selamatDatang">
                Admin <i id="namaAdmin"><?php if (isset($_SESSION['nama'])){echo $_SESSION['nama'];} else {echo "ROOT";}?></i>
            </div>
            <div id="tanggal"></div>
            <div id="jam"></div>
            <script>updateClock();</script>
            <nav>
                <a id="nav_beranda" href="index.php">Beranda</a>
                <a id="nav_tampilPegawai" href="tampilPegawai.php">Tampil Pegawai</a>
                <a id="nav_logout" href="logout.php">Keluar</a>
            </nav>
        </div>
        <div class="input" id="input">
            <div id="JudulForm">Form Pegawai Baru</div>
            <div id="myForm">
                <form action="daftar.php" method="post" onsubmit="return check()">
                    <div>
                        <div id="input_kiri"></div>
                        <div id="input_tengah">
                            <input type="text" id="nip" name="nip" placeholder="NIP" <?php echo "value=\"$nip\""?> readonly>
                        </div>
                        <div id="input_kanan"></div>
                    </div>
                    <div>
                        <div id="input_kiri"></div>
                        <div id="input_tengah">
                            <input type="text" id="nama" name="nama" placeholder="Nama" <?php echo "value=\"$nama\""?> required>
                        </div>
                        <div id="input_kanan"></div>
                    </div>
                    <div>
                        <div id="input_kiri"></div>
                        <div id="input_tengah">
                            <input type="text" id="tempat" name="tempat" placeholder="Tempat lahir" <?php echo "value=\"$tempat\""?> required>
                        </div>
                        <div id="input_kanan"></div>
                    </div>
                    <div>
                        <div id="input_kiri"></div>
                        <div id="input_tengah">
                            <input type="date" id="tanglah" name="tanggal" placeholder="Tahun-Bulan-Tanggal" <?php echo "value=\"$tanggal\""?> required>
                        </div>
                        <div id="input_kanan"></div>
                    </div>
                    <div>
                        <div id="input_kiri"></div>
                        <div id="input_tengah">
                            <input type="text" id="alamat" name="alamat" placeholder="Alamat" <?php echo "value=\"$alamat\""?> required>
                        </div>
                        <div id="input_kanan"></div>
                    </div>
                    <div>
                        <select id="jabatan" name="jabatan">
                            <option value="IT" <?php if($jabatan == "IT"){ echo "selected";}?>>IT</option>
                            <option value="Staf" <?php if($jabatan == "Staf"){ echo "selected";}?>>Staf</option>
                            <option value="Manager" <?php if($jabatan == "Manager"){ echo "selected";}?>>Manager</option>
                        </select>
                    </div>
                    <div>
                        <div id="input_kiri"></div>
                        <div id="input_tengah">
                            <input type="text" id="noHp" name="noHp" placeholder="Nomor Handphone" <?php echo "value=\"$noHp\""?> required>
                        </div>
                        <div id="input_kanan"></div>
                    </div>
                    <div>
                        <div id="input_kiri"></div>
                        <div id="input_tengah">
                            <input type="submit" id="submit" value="<?php echo $proses;?>">
                        </div>
                        <div id="input_kanan"></div>
                    </div>
                </form>
            </div>
        </div>
   </body>
</html>

<?php
}
