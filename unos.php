<?php
session_start();
include 'connect.php';

if (!isset($_SESSION['razina']) || $_SESSION['razina'] !== 1) {
    $title  = 'Pristup odbijen';
    $active = 'unos';
    include 'header.php';
    echo '<div class="message error" style="text-align:center;margin:3rem auto;max-width:480px;">' . '<strong>Nemate ovlasti za pristup ovoj stranici.</strong><br><br>' . '<a href="administracija.php" style="color:var(--accent);">Prijavi se kao administrator</a>' . '</div>';
    include 'footer.php';
    exit;
}

define('UPLPATH', 'img/');

$title  = 'Unos proizvoda';
$active = 'unos';
$poruka = '';

if (isset($_POST['prihvati'])) {

    $naslov = $_POST['title'];
    $sazetak = $_POST['about'];
    $tekst = $_POST['content'];
    $kat = $_POST['category'];
    $datum = date('d.m.Y.');

    //ako je oznacen arhiva = 1 inace je 0
    $arhiva   = isset($_POST['archive']) ? 1 : 0;

    $slika = '';
    if (isset($_FILES['pphoto']) && $_FILES['pphoto']['name'] !== '') {
        $slika      = basename($_FILES['pphoto']['name']);
        $odrediste  = UPLPATH . $slika;
        move_uploaded_file($_FILES['pphoto']['tmp_name'], $odrediste);
    }

    $naslov = mysqli_real_escape_string($dbc, $naslov);
    $sazetak = mysqli_real_escape_string($dbc, $sazetak);
    $tekst = mysqli_real_escape_string($dbc, $tekst);
    $kat = mysqli_real_escape_string($dbc, $kat);
    $slika = mysqli_real_escape_string($dbc, $slika);

    $query = "INSERT INTO vijesti (datum, naslov, sazetak, tekst, slika, kategorija, arhiva)
              VALUES ('$datum', '$naslov', '$sazetak', '$tekst', '$slika', '$kat', '$arhiva')";

    if (mysqli_query($dbc, $query)) {
        $noviId = mysqli_insert_id($dbc);
        $poruka = '<div class="message ok">Proizvod je uspjesno spremljen u bazu. '
                . '<a href="clanak.php?id=' . $noviId . '">Pogledaj proizvod</a>.</div>';
    } else {
        $poruka = '<div class="message error">Greska pri spremanju: ' . mysqli_error($dbc) . '</div>';
    }
}

include 'header.php';
?>

<div class="form-wrap">
    <h1 class="page-heading">Unos novog proizvoda</h1>

    <?php echo $poruka; ?>

    <form action="unos.php" method="POST" enctype="multipart/form-data" autocomplete="on">

        <div class="form-item">
            <label for="title">Naziv proizvoda</label>
            <div class="form-field">
                <input type="text" name="title" id="title" class="form-field-textual" autofocus required>
            </div>
        </div>

        <div class="form-item">
            <label for="about">Kratki opis (sazetak)</label>
            <div class="form-field">
                <textarea name="about" id="about" cols="30" rows="3" class="form-field-textual" required></textarea>
            </div>
        </div>

        <div class="form-item">
            <label for="content">Detaljan opis proizvoda</label>
            <div class="form-field">
                <textarea name="content" id="content" cols="30" rows="8" class="form-field-textual" required></textarea>
            </div>
        </div>

        <div class="form-item">
            <label for="category">Kategorija</label>
            <div class="form-field">
                <select name="category" id="category" class="form-field-textual">
                    <option value="nogomet">Nogomet</option>
                    <option value="kosarka">Kosarka</option>
                    <option value="fitness">Fitness</option>
                </select>
            </div>
        </div>

        <div class="form-item">
            <label for="pphoto">Slika proizvoda</label>
            <div class="form-field">
                <input type="file" name="pphoto" id="pphoto" accept="image/jpeg,image/png,image/gif" class="input-text">
            </div>
        </div>

        <label class="form-check">
            <input type="checkbox" name="archive">
            Spremi u arhivu (NE prikazuj proizvod na stranici)
        </label>

        <div class="form-item">
            <button type="reset">Ponisti</button>
            <button type="submit" name="prihvati" value="Prihvati">Spremi proizvod</button>
        </div>

    </form>
</div>

<?php
mysqli_close($dbc);
include 'footer.php';
