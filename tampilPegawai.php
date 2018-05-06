<?php
session_start();
if (!isset($_SESSION['nip'])){
    $_SESSION['url'] = "tampilPegawai.php";
    include_once 'loginForm.php';
} else {
    date_default_timezone_set('Asia/Jakarta');
    ?>
    <!DOCTYPE html>
    <html>
        <head>
            <title>Tampil Pegawai</title>
            <link rel="stylesheet" type="text/css" href="./css/tampilPegawai.css"
        </head>
        <body>
            <header>
                <div id="kiri">
                    <div id="namaAdmin">
                        Admin <i><?php if (isset($_SESSION['nama'])){echo $_SESSION['nama'];} else {echo "ROOT";} ?></i>
                    </div>
                    <h1 id="judul">Tampil Pegawai</h1>
                </div>
                <div id="kanan">
                    <div id="nav">
                        <a href="index.php">Beranda</a>
                        <a href="formPegawai.php">Form Pegawai</a>
                        <a href="logout.php">Keluar</a>
                    </div>
                    <div id="waktu">
                        <div id="tanggal"></div>
                        <div id="jam"></div>
                    </div>
                </div>
            </header>
            <table id="tabel">
            <tr>
                <th id="h0" onclick="sortTable(0)">NIP</th>
                <th id="h1" onclick="sortTable(1)">Nama</th>
                <th id="h2" onclick="sortTable(2)">Tempat</th>
                <th id="h3" onclick="sortTable(3)">Lahir</th>
                <th id="h4" onclick="sortTable(4)">Alamat</th>
                <th id="h5" onclick="sortTable(5)">No. Telp</th>
                <th id="h6" onclick="sortTable(6)">Jabatan</th>
                <th id="h7" onclick="sortTable(7)">Kehadiran</th>
                <th id="h8" onclick="sortTable(8)">Gaji</th>
                <th id="h9" onclick="sortTable(9)">Masuk</th>
                <th>Opsi</th>
            </tr>
            <?php
            function getKehadiran($nip){
                $link = mysqli_connect("localhost", "root", "", "e-salary");
                $result = mysqli_query($link, "select * from absensi where nip=$nip");
                $count = 0;
                while($data = mysqli_fetch_array($result)){
                    if(substr($data['tanggal'], 0, 7) === date("Y-m")){
                        $count++;
                    }
                }
                if(date("Y-m"));
                mysqli_close($link);
                return $count;
            }
            
            function getGaji($kehadiran, $jabatan, $nip){
                $link = mysqli_connect("localhost", "root", "", "e-salary");
                $result = mysqli_query($link, "select * from pegawai where nip=$nip");
                $data = mysqli_fetch_array($result);
                $gajiPokok;
                $potongan;
                $tmasuk;
                if(date("Y-m") == substr($data['tmasuk'], 0, 7)){
                    $tmasuk = (int)substr($data['tmasuk'], 8, 2);
                } else {
                    $tmasuk = 0;
                }
                $tHadir = ((int)date("d")-$tmasuk)-($kehadiran-1);
                switch ($jabatan){
                    case 'IT' :
                        $gajiPokok = 100000;
                        $potongan = 17000;
                        break;
                    case 'Manager':
                        $gajiPokok = 110000;
                        $potongan = 20000;
                        break;
                    case 'Staf':
                        $gajiPokok = 90000;
                        $potongan = 15000;
                        break;
                }
                return ($gajiPokok*$kehadiran)-($tHadir*$potongan);
            }
            
            function tampilGaji($gaji){
                $angka = array(3);
                $count = 0;
                while($gaji > 0){
                    $temp = $gaji%1000;
                    if ((int)($gaji/1000) > 0){
                        if ($temp < 10) {
                            $angka[$count] = "00$temp,";
                        } else if ($temp < 100) {
                            $angka[$count] = "0$temp,";
                        } else {
                            $angka[$count] = "$temp,";
                        }
                    } else {
                        $angka[$count] = "$temp,";
                    }
                    $gaji = (int)($gaji/1000);
                    $count++;
                }

                if (!isset($angka[1])){
                    $angka[1] = "";
                }

                if (!isset($angka[2])){
                    $angka[2] = "";
                }
                return "Rp$angka[2]$angka[1]$angka[0]00-";
            }
            
            $link = mysqli_connect("localhost", "root", "", "e-salary");
            $result = mysqli_query($link, "select * from pegawai order by 1");
            while($data = mysqli_fetch_array($result)){
            if ($data['nip'] !== '0000'){
                $kehadiran = getKehadiran($data['nip']);?>
                <tr>
                    <td id="k0"><?php echo $data['nip']?></td>
                    <td id="k1"><?php echo $data['nama']?></td>
                    <td id="k2"><?php echo $data['tempat']?></td>
                    <td id="k3"><?php echo $data['tanggal']?></td>
                    <td id="k4"><?php echo $data['alamat']?></td>
                    <td id="k5"><?php echo $data['telp']?></td>
                    <td id="k6"><?php echo $data['jabatan']?></td>
                    <td id="k7"><?php echo $kehadiran?></td>
                    <td id="k8"><?php echo getGaji($kehadiran, $data['jabatan'], $data['nip'])?></td>
                    <td id="k9"><?php echo $data['tmasuk']?></td>
                    <td>
                        <a id="a_hapus" href="hapus.php?nip=<?php echo $data['nip'] ?>" onclick="return confirm('Apakah anda yakin ingin menghapus <?php echo $data['nama'];?> ?')">Hapus</a>
                        <a id="a_edit" href="formPegawai.php?nip=<?php echo $data['nip'] ?>">Edit</a>
                    </td>
                </tr>
            <?php
            }
            }
            mysqli_close($link);
            ?>
            </table>
            <script>
                function sortTable(n) {
                    var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
                    table = document.getElementById("tabel");
                    switching = true;
                    //Set the sorting direction to ascending:
                    dir = "asc"; 
                    /*Make a loop that will continue until
                    no switching has been done:*/
                    while (switching) {
                        //start by saying: no switching is done:
                        switching = false;
                        rows = table.getElementsByTagName("tr");
                        /*Loop through all table rows (except the
                        first, which contains table headers):*/
                        for (i = 1; i < (rows.length - 1); i++) {
                            //start by saying there should be no switching:
                            shouldSwitch = false;
                            /*Get the two elements you want to compare,
                            one from current row and one from the next:*/
                            x = rows[i].getElementsByTagName("td")[n];
                            y = rows[i + 1].getElementsByTagName("td")[n];
                            /*check if the two rows should switch place,
                            based on the direction, asc or desc:*/
                            if (isNaN(x.innerHTML)) {
                                if (dir == "asc") {
                                    if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                                        //if so, mark as a switch and break the loop:
                                        shouldSwitch= true;
                                        break;
                                    }
                                } else if (dir == "desc") {
                                    if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                                        //if so, mark as a switch and break the loop:
                                        shouldSwitch= true;
                                        break;
                                    }
                                }
                            } else {
                                var xi = parseInt(x.innerHTML);
                                var yi = parseInt(y.innerHTML);
                                if (dir == "asc") {
                                    if (xi > yi) {
                                        //if so, mark as a switch and break the loop:
                                        shouldSwitch= true;
                                        break;
                                    }
                                } else if (dir == "desc") {
                                    if (xi < yi) {
                                        //if so, mark as a switch and break the loop:
                                        shouldSwitch= true;
                                        break;
                                    }
                                }
                            }
                        }
                        if (shouldSwitch) {
                            /*If a switch has been marked, make the switch
                            and mark that a switch has been done:*/
                            rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                            switching = true;
                            //Each time a switch is done, increase this count by 1:
                            switchcount ++; 
                        } else {
                            /*If no switching has been done AND the direction is "asc",
                            set the direction to "desc" and run the while loop again.*/
                            if (switchcount == 0 && dir == "asc") {
                                dir = "desc";
                                switching = true;
                            }
                        }
                    }
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
                updateClock(); // initial call
            </script>
        </body>
    </html>
<?php
}
