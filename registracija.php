<?php
include 'connect.php';

$title  = 'Registracija';
$active = '';

$msg = '';
$registriranKorisnik = false;

if (isset($_POST['registracija'])) {
    $ime = $_POST['ime'];
    $prezime = $_POST['prezime'];
    $username = $_POST['username'];
    $lozinka = $_POST['pass'];
    $lozinka2 = $_POST['passRep'];
    $razina = 0;

    if ($lozinka !== $lozinka2) {
        $msg = 'Lozinke nisu identicne!';
    } else {
        $hashed_password = password_hash($lozinka, PASSWORD_BCRYPT);

        $sql  = "SELECT korisnicko_ime FROM korisnik WHERE korisnicko_ime = ?";
        $stmt = mysqli_stmt_init($dbc);
        if (mysqli_stmt_prepare($stmt, $sql)) {
            mysqli_stmt_bind_param($stmt, 's', $username);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);

            if (mysqli_stmt_num_rows($stmt) > 0) {
                $msg = 'Korisnicko ime vec postoji!';
            } else {
                $sql2  = "INSERT INTO korisnik (ime, prezime, korisnicko_ime, lozinka, razina)
                          VALUES (?, ?, ?, ?, ?)";
                $stmt2 = mysqli_stmt_init($dbc);
                if (mysqli_stmt_prepare($stmt2, $sql2)) {
                    mysqli_stmt_bind_param($stmt2, 'ssssi', $ime, $prezime, $username, $hashed_password, $razina);
                    mysqli_stmt_execute($stmt2);
                    mysqli_stmt_close($stmt2);
                    $registriranKorisnik = true;
                }
            }
            mysqli_stmt_close($stmt);
        }
    }
}

mysqli_close($dbc);
include 'header.php';
?>

<div class="form-wrap">
    <h1 class="page-heading">Registracija korisnika</h1>

    <?php if ($registriranKorisnik) { ?>

        <div class="message ok">Korisnik je uspjesno registriran! Sada se mozete
            <a href="administracija.php">prijaviti</a>.</div>

    <?php } else { ?>

        <form action="registracija.php" method="POST">

            <div class="form-item">
                <span id="porukaIme" class="bojaPoruke"></span>
                <label for="ime">Ime</label>
                <div class="form-field">
                    <input type="text" name="ime" id="ime" class="form-field-textual">
                </div>
            </div>

            <div class="form-item">
                <span id="porukaPrezime" class="bojaPoruke"></span>
                <label for="prezime">Prezime</label>
                <div class="form-field">
                    <input type="text" name="prezime" id="prezime" class="form-field-textual">
                </div>
            </div>

            <div class="form-item">
                <span id="porukaUsername" class="bojaPoruke"></span>
                <label for="username">Korisnicko ime</label>
                <?php if ($msg !== '') { echo '<div class="bojaPoruke">' . $msg . '</div>'; } ?>
                <div class="form-field">
                    <input type="text" name="username" id="username" class="form-field-textual">
                </div>
            </div>

            <div class="form-item">
                <span id="porukaPass" class="bojaPoruke"></span>
                <label for="pass">Lozinka</label>
                <div class="form-field">
                    <input type="password" name="pass" id="pass" class="form-field-textual">
                </div>
            </div>

            <div class="form-item">
                <span id="porukaPassRep" class="bojaPoruke"></span>
                <label for="passRep">Ponovite lozinku</label>
                <div class="form-field">
                    <input type="password" name="passRep" id="passRep" class="form-field-textual">
                </div>
            </div>

            <div class="form-item">
                <button type="submit" name="registracija" id="slanje" value="Registracija">Registracija</button>
            </div>
        </form>

        <script type="text/javascript">
        document.getElementById("slanje").onclick = function (event) {
            var slanjeForme = true;

            function provjeri(idPolja, idPoruke, uvjet, tekst) {
                var polje = document.getElementById(idPolja);
                if (uvjet) {
                    slanjeForme = false;
                    polje.style.border = "1px dashed red";
                    document.getElementById(idPoruke).innerHTML = tekst;
                } else {
                    polje.style.border = "1px solid green";
                    document.getElementById(idPoruke).innerHTML = "";
                }
            }

            var ime      = document.getElementById("ime").value;
            var prezime  = document.getElementById("prezime").value;
            var username = document.getElementById("username").value;
            var pass     = document.getElementById("pass").value;
            var passRep  = document.getElementById("passRep").value;

            provjeri("ime", "porukaIme", ime.length === 0, "Unesite ime!");
            provjeri("prezime", "porukaPrezime", prezime.length === 0, "Unesite prezime!");
            provjeri("username", "porukaUsername", username.length === 0, "Unesite korisnicko ime!");

            var lozinkaProblem = (pass.length === 0 || passRep.length === 0 || pass !== passRep);
            provjeri("pass", "porukaPass", lozinkaProblem, "Lozinke nisu iste!");
            provjeri("passRep", "porukaPassRep", lozinkaProblem, "Lozinke nisu iste!");

            if (!slanjeForme) {
                event.preventDefault();
            }
        };
        </script>

    <?php } ?>
</div>

<?php
include 'footer.php';
