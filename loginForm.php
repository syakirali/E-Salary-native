<?php
$url;
if (isset($_SESSION['url'])) {
    $url = $_SESSION['url'];
} else {
    header("location: index.php");
}
if(isset($_POST['nip']) && isset($_POST['pw'])){
    $nip = $_POST['nip'];
    $password = $_POST['pw'];

    $link = mysqli_connect("localhost", "root", "", "e-salary");
    $result = mysqli_query($link, "select * from it_user where nip='$nip' and password='$password'");
    if (mysqli_num_rows($result)>0){
        session_start();
        $_SESSION['nip'] = $nip;
        if ($nip === '0000') {
            $_SESSION['level'] = "ROOT";
        } else {
            $data = mysqli_fetch_array(mysqli_query($link, "select * from pegawai where nip='$nip'"));
            $_SESSION['level'] = "IT";
            $_SESSION['nama'] = $data['nama'];
        }
        mysqli_close($link);
        header("location: $url");
    } else {
        ?>
        <script>
        alert('Username atau Password salah !');
        mysqli_close($link);
        window.location = "<?php echo $url; ?>";
        </script>
        <?php
    }
}
if (!isset($_SESSION['nip'])){
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Login</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link type="text/css" rel="stylesheet" href="css/style.css" media="screen" />
        
        <script type="text/javascript" src="./js/jquery.js"></script>
	<script type="text/javascript" src="./js/jquery.query-2.1.7.js"></script>
	<script type="text/javascript" src="./js/rainbows.js"></script>
        
        <script>
            $(document).ready(function(){
                $("#submit1").hover(
                    function() {
                        $(this).animate({"opacity": "0"}, "slow");
                    }, function() {
                        $(this).animate({"opacity": "1"}, "slow");
                });
            });
        </script>
    </head>
    <body>
        <header>
            
        </header>
	<div id="kotak">
		<div id="kotakAtas"></div>
		<div id="kotakTengah">
                    <h2>Login</h2>
                    <form action="<?php $url ?>" method="POST">
                        
                        <div id="input_nip">
                            <div id="input_nip_kiri"></div>
                            <div id="input_nip_tengah">
                                <input id="url" type="text" name="nip" placeholder="Nomor Induk Pegawai" autofocus required>
                                <img id="url_nip" src="./images/mailicon.png" alt="">
                            </div>
                            <div id="input_nip_kanan"></div>
                        </div>

                        <div id="input_password">
                            <div id="input_password_kiri"></div>
                            <div id="input_password_tengah">
                                <input type="password" id="url" name="pw" placeholder="Password" required>
                                <img id="url_password" src="./images/passicon.png" alt="">
                            </div>
                            <div id="input_password_kanan"></div>
                        </div>

                        <div id="submit">
                            <input type="image" src="./images/submit_hover.png" id="submit1" value="Sign In">
                            <input type="image" src="./images/submit.png" id="submit2" value="Sign In">
                        </div>

                        <div id="link_kiri"><a href="index.php">Beranda</a></div>
                    </form>
		</div>

		<div id="kotakBawah"></div>
		
		<div id="powered">
                    <p>Powered by <a href="#">Cyber</a></p>
		</div>
	</div>
        <footer>
            
        </footer>
    </body>
</html>

<?php
} else {
    header("location: $url");
}
