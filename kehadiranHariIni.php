<?php
$link = mysqli_connect("localhost", "root", "", "e-salary");
date_default_timezone_set("Asia/Jakarta");
$tanggal = date("Y-m-d");
$result = mysqli_query($link, "select * from absensi where tanggal='$tanggal'");
if(mysqli_num_rows($result) > 0){
    function getKehadiran($nip){
        $link = mysqli_connect("localhost", "root", "", "e-salary");
        $result = mysqli_query($link, "select * from absensi where nip=$nip");
        $count = 0;
        date_default_timezone_set('Asia/Jakarta');
        while($data = mysqli_fetch_array($result)){
            if(substr($data['tanggal'], 0, 7) === date("Y-m")){
                $count++;
            }
        }
        mysqli_close($link);
        return $count;
    }
    function getNama($nip){
        $link2 = mysqli_connect("localhost", "root", "", "e-salary");
        $result2 = mysqli_query($link2, "select * from pegawai where nip=$nip");
        $data = mysqli_fetch_array($result2);
        mysqli_close($link2);
        return $data['nama'];
    }
?>

<div id="tabelKehadiran">
    <table>
        <tr id="tabelKehadiran_header">
            <th>No</th>
            <th>Nama</th>
            <th>Kedatangan</th>
            <th>Total</th>
        </tr>
        <?php
        $no = 1;
        while($data = mysqli_fetch_array($result)){
            $nama = getNama($data['nip']);
            $jam = $data['jam'];
            $kehadiran = getKehadiran($data['nip']);
            echo "
            <tr>
                <td id=\"tabelKehadiran_lain\">$no</td>
                <td id=\"tabelKehadiran_nama\">$nama</td>
                <td id=\"tabelKehadiran_lain\">$jam</td>
                <td id=\"tabelKehadiran_lain\">$kehadiran</td>
            </tr>
            ";
            $no++;
        }
        ?>
    </table>
</div>
<?php
}
