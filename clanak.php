<?php
include 'connect.php';
define('UPLPATH', 'img/');

$active = 'pocetna';

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

$query  = "SELECT * FROM vijesti WHERE id = " . $id;
$result = mysqli_query($dbc, $query);
$row    = mysqli_fetch_array($result);

$title  = $row ? $row['naslov'] : 'Proizvod nije pronaden';
if ($row) { $active = $row['kategorija']; }
include 'header.php';

if ($row) {
?>
    <section class="article-single" role="main">
        <div class="row">
            <p class="category"><?php echo $row['kategorija']; ?></p>
            <h1 class="title"><?php echo $row['naslov']; ?></h1>
            <div class="meta">
                <p>AUTOR: Olimp Sport</p>
                <p>OBJAVLJENO: <?php echo $row['datum']; ?></p>
            </div>
        </div>

        <section class="slika">
            <?php echo '<img src="' . UPLPATH . $row['slika'] . '" alt="' . htmlspecialchars($row['naslov']) . '">'; ?>
        </section>

        <section class="about">
            <p><?php echo $row['sazetak']; ?></p>
        </section>

        <section class="sadrzaj">
            <p><?php echo nl2br($row['tekst']); ?></p>
        </section>

        <a class="back-link" href="index.php">&larr; Natrag na naslovnicu</a>
    </section>
<?php
} else {
    echo '<p class="message error">Trazeni proizvod ne postoji.</p>';
    echo '<a class="back-link" href="index.php">&larr; Natrag na naslovnicu</a>';
}

mysqli_close($dbc);
include 'footer.php';
