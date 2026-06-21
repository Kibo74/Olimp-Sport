<?php
include 'connect.php';
define('UPLPATH', 'img/');

$dozvoljene = array('nogomet' => 'Nogomet', 'kosarka' => 'Kosarka', 'fitness' => 'Fitness');

$kategorija = isset($_GET['kategorija']) ? $_GET['kategorija'] : '';
$naslovKat  = isset($dozvoljene[$kategorija]) ? $dozvoljene[$kategorija] : null;

$title  = $naslovKat ? $naslovKat : 'Kategorija';
$active = isset($dozvoljene[$kategorija]) ? $kategorija : '';
include 'header.php';

if ($naslovKat) {
    echo '<section>';
    echo '<h2 class="section-title">' . $naslovKat . '</h2>';
    echo '<div class="grid">';

    $kat    = mysqli_real_escape_string($dbc, $kategorija);
    $query  = "SELECT * FROM vijesti WHERE arhiva = 0 AND kategorija = '" . $kat . "'";
    $result = mysqli_query($dbc, $query);

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_array($result)) {
            echo '<article class="card">';
            echo   '<a class="thumb" href="clanak.php?id=' . $row['id'] . '">';
            echo     '<img src="' . UPLPATH . $row['slika'] . '" alt="' . htmlspecialchars($row['naslov']) . '">';
            echo   '</a>';
            echo   '<div class="card-body">';
            echo     '<span class="card-cat">' . $naslovKat . '</span>';
            echo     '<h3 class="card-title"><a href="clanak.php?id=' . $row['id'] . '">' . $row['naslov'] . '</a></h3>';
            echo     '<p class="card-excerpt">' . $row['sazetak'] . '</p>';
            echo   '</div>';
            echo '</article>';
        }
    } else {
        echo '<p class="message info">Trenutno nema proizvoda u ovoj kategoriji.</p>';
    }

    echo '</div>';
    echo '</section>';
} else {
    echo '<p class="message error">Nepoznata kategorija.</p>';
    echo '<a class="back-link" href="index.php">&larr; Natrag na naslovnicu</a>';
}

mysqli_close($dbc);
include 'footer.php';
