<?php
session_start();
include 'connect.php';
define('UPLPATH', 'img/');

$title  = 'Administracija';
$active = 'administracija';

$uspjesnaPrijava = isset($_SESSION['username']);
$admin           = (isset($_SESSION['razina']) && $_SESSION['razina'] == 1);
$loginPoruka     = '';

if (isset($_GET['odjava'])) {
    session_unset();
    session_destroy();
    header('Location: administracija.php');
    exit;
}

if (isset($_POST['prijava'])) {
    $unosUser = $_POST['username'];
    $unosPass = $_POST['lozinka'];

    $sql  = "SELECT id, ime, korisnicko_ime, lozinka, razina FROM korisnik WHERE korisnicko_ime = ?";
    $stmt = mysqli_stmt_init($dbc);

    if (mysqli_stmt_prepare($stmt, $sql)) {
        mysqli_stmt_bind_param($stmt, 's', $unosUser);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        mysqli_stmt_bind_result($stmt, $idK, $imeK, $userK, $hashK, $razinaK);

        if (mysqli_stmt_num_rows($stmt) == 1 && mysqli_stmt_fetch($stmt)
            && password_verify($unosPass, $hashK)) {

            $_SESSION['username'] = $userK;
            $_SESSION['ime'] = $imeK;
            $_SESSION['razina'] = $razinaK;
            $uspjesnaPrijava = true;
            $admin = ($razinaK == 1);
        } else {
            $loginPoruka = '<div class="message error">Neispravno korisnicko ime ili lozinka. '
                         . 'Ako nemate racun, <a href="registracija.php">registrirajte se</a>.</div>';
        }
        mysqli_stmt_close($stmt);
    }
}

if (isset($_POST['delete']) && $admin) {
    $id   = (int) $_POST['id'];
    $sql  = "DELETE FROM vijesti WHERE id = ?";
    $stmt = mysqli_stmt_init($dbc);
    if (mysqli_stmt_prepare($stmt, $sql)) {
        mysqli_stmt_bind_param($stmt, 'i', $id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }

    $_SESSION['flash'] = '<div class="message ok">Proizvod je obrisan.</div>';
    header('Location: administracija.php');
    exit;
}


if (isset($_POST['update']) && $admin) {
    $id      = (int) $_POST['id'];
    $naslov  = $_POST['title'];
    $sazetak = $_POST['about'];
    $tekst   = $_POST['content'];
    $kat     = $_POST['category'];
    $arhiva  = isset($_POST['archive']) ? 1 : 0;


    $slika = $_POST['stara_slika'];
    if (isset($_FILES['pphoto']) && $_FILES['pphoto']['name'] !== '') {
        $slika = basename($_FILES['pphoto']['name']);
        move_uploaded_file($_FILES['pphoto']['tmp_name'], UPLPATH . $slika);
    }

    $sql  = "UPDATE vijesti SET naslov=?, sazetak=?, tekst=?, slika=?, kategorija=?, arhiva=? WHERE id=?";
    $stmt = mysqli_stmt_init($dbc);
    if (mysqli_stmt_prepare($stmt, $sql)) {
        mysqli_stmt_bind_param($stmt, 'sssssii', $naslov, $sazetak, $tekst, $slika, $kat, $arhiva, $id);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
    $_SESSION['flash'] = '<div class="message ok">Proizvod je azuriran.</div>';
    header('Location: administracija.php');
    exit;
}

$flash = '';
if (isset($_SESSION['flash'])) {
    $flash = $_SESSION['flash'];
    unset($_SESSION['flash']);
}

$editId  = isset($_GET['edit']) ? (int) $_GET['edit'] : 0;
$editRow = null;
if ($admin && $editId > 0) {
    $sql = "SELECT * FROM vijesti WHERE id = ?";
    $stmt = mysqli_stmt_init($dbc);
    if (mysqli_stmt_prepare($stmt, $sql)) {
        mysqli_stmt_bind_param($stmt, 'i', $editId);
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);
        $editRow = mysqli_fetch_array($res);
        mysqli_stmt_close($stmt);
    }
}

include 'header.php';
?>

<h1 class="page-heading">Administracija</h1>

<?php

if ($uspjesnaPrijava && $admin) {

    echo '<div class="admin-toolbar">';
    echo   '<div class="who">Prijavljeni ste kao <strong>' . htmlspecialchars($_SESSION['ime']) . '</strong> (administrator)</div>';
    echo   '<div class="actions">';
    if ($editRow) {
        echo '<a class="btn-link" href="administracija.php">&larr; Natrag na listu</a>';
    }
    echo     '<a class="btn-link" href="administracija.php?odjava=1">Odjava</a>';
    echo   '</div>';
    echo '</div>';

    echo $flash;

    if ($editRow) {
        $row = $editRow;
        $sel_nogomet = $row['kategorija'] == 'nogomet' ? ' selected' : '';
        $sel_kosarka = $row['kategorija'] == 'kosarka' ? ' selected' : '';
        $sel_fitness = $row['kategorija'] == 'fitness' ? ' selected' : '';
        $checked     = $row['arhiva'] == 1 ? ' checked' : '';
        ?>
        <div class="admin-card">
            <h2 style="font-family:'Sora',sans-serif;font-size:20px;margin-bottom:18px;">
                Uredivanje: <?php echo htmlspecialchars($row['naslov']); ?>
            </h2>

            <form action="administracija.php" method="POST" enctype="multipart/form-data">

                <div class="form-item">
                    <label>Naziv proizvoda</label>
                    <div class="form-field">
                        <input type="text" name="title" class="form-field-textual"
                               value="<?php echo htmlspecialchars($row['naslov']); ?>">
                    </div>
                </div>

                <div class="form-item">
                    <label>Kratki opis</label>
                    <div class="form-field">
                        <textarea name="about" rows="2" class="form-field-textual"><?php echo htmlspecialchars($row['sazetak']); ?></textarea>
                    </div>
                </div>

                <div class="form-item">
                    <label>Detaljan opis</label>
                    <div class="form-field">
                        <textarea name="content" rows="6" class="form-field-textual"><?php echo htmlspecialchars($row['tekst']); ?></textarea>
                    </div>
                </div>

                <div class="form-item">
                    <label>Slika</label>
                    <div class="form-field">
                        <input type="file" name="pphoto" class="input-text" accept="image/jpeg,image/png,image/gif">
                        <img class="thumb-mini" src="<?php echo UPLPATH . $row['slika']; ?>" alt="">
                    </div>
                </div>

                <div class="form-item">
                    <label>Kategorija</label>
                    <div class="form-field">
                        <select name="category" class="form-field-textual">
                            <option value="nogomet"<?php echo $sel_nogomet; ?>>Nogomet</option>
                            <option value="kosarka"<?php echo $sel_kosarka; ?>>Kosarka</option>
                            <option value="fitness"<?php echo $sel_fitness; ?>>Fitness</option>
                        </select>
                    </div>
                </div>

                <label class="form-check">
                    <input type="checkbox" name="archive"<?php echo $checked; ?>>
                    Arhivirano (sakriveno sa stranice)
                </label>

                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                <input type="hidden" name="stara_slika" value="<?php echo htmlspecialchars($row['slika']); ?>">

                <div class="form-item" style="display:flex;gap:10px;flex-wrap:wrap;align-items:center;">
                    <button type="submit" name="update" value="Spremi">Spremi promjene</button>
                    <button type="submit" name="delete" value="Izbrisi"
                            onclick="return confirm('Sigurno obrisati ovaj proizvod?');">Izbrisi</button>
                    <a class="btn-link" href="administracija.php" style="margin-left:auto;">Natrag na listu</a>
                </div>
            </form>
        </div>
        <?php
    } else {
        $query  = "SELECT * FROM vijesti ORDER BY id DESC";
        $result = mysqli_query($dbc, $query);

        if (mysqli_num_rows($result) == 0) {
            echo '<p class="message info">Nema proizvoda u bazi. <a href="unos.php">Dodaj prvi proizvod</a>.</p>';
        } else {
            echo '<p style="font-size:14px;color:#64748b;margin-bottom:18px;">Odaberi proizvod za uredivanje:</p>';
            echo '<div class="admin-list">';
            while ($row = mysqli_fetch_array($result)) {
                $katLabel = ucfirst($row['kategorija']);
                echo '<div class="admin-list-item">';
                echo   '<div class="thumb"><img src="' . UPLPATH . $row['slika'] . '" alt=""></div>';
                echo   '<div class="body">';
                echo     '<div class="row-top">';
                echo       '<span class="cat">' . $katLabel . '</span>';
                if ($row['arhiva'] == 1) {
                    echo   '<span class="badge-archived">Arhivirano</span>';
                }
                echo     '</div>';
                echo     '<h3>' . htmlspecialchars($row['naslov']) . '</h3>';
                echo     '<div class="actions">';
                echo       '<a href="administracija.php?edit=' . $row['id'] . '">Uredi</a>';
                echo     '</div>';
                echo   '</div>';
                echo '</div>';
            }
            echo '</div>';
        }
    }

} else if ($uspjesnaPrijava && !$admin) {
    echo '<div class="message error">Bok ' . htmlspecialchars($_SESSION['ime'])
       . ', nemate dovoljna prava za pristup ovoj stranici.</div>';
    echo '<a class="back-link" href="administracija.php?odjava=1">Odjava</a>';

} else {
    echo $loginPoruka;
    ?>
    <div class="form-wrap">
        <p class="message info">Prijavite se za pristup administraciji.</p>
        <form action="administracija.php" method="POST">
            <div class="form-item">
                <label for="username">Korisnicko ime</label>
                <div class="form-field">
                    <input type="text" name="username" id="username" class="form-field-textual" required autofocus>
                </div>
            </div>
            <div class="form-item">
                <label for="lozinka">Lozinka</label>
                <div class="form-field">
                    <input type="password" name="lozinka" id="lozinka" class="form-field-textual" required>
                </div>
            </div>
            <div class="form-item">
                <button type="submit" name="prijava" value="Prijava">Prijava</button>
            </div>
            <p style="font-size:14px;color:#64748b;margin-top:6px;">
                Nemate racun? <a href="registracija.php" style="color:var(--accent);font-weight:700;">Registrirajte se</a>.
            </p>
        </form>
    </div>
    <?php
}

mysqli_close($dbc);
include 'footer.php';
