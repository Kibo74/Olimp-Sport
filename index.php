<?php
include 'connect.php';
define('UPLPATH', 'img/');

$title  = 'Naslovnica';
$active = 'pocetna';
include 'header.php';

$kategorije = array(
    'nogomet' => 'Nogomet',
    'kosarka' => 'Kosarka',
    'fitness' => 'Fitness'
);

foreach ($kategorije as $kljuc => $naslov) {
    echo '<section>';
    echo '<h2 class="section-title">' . $naslov . '</h2>';
    echo '<div class="grid">';

    $query  = "SELECT * FROM vijesti WHERE arhiva = 0 AND kategorija = '" . $kljuc . "' ORDER BY datum DESC LIMIT 3";
    $result = mysqli_query($dbc, $query);

    while ($row = mysqli_fetch_array($result)) {
        echo '<article class="card">';
        echo   '<a class="thumb" href="clanak.php?id=' . $row['id'] . '">';
        echo     '<img src="' . UPLPATH . $row['slika'] . '" alt="' . htmlspecialchars($row['naslov']) . '">';
        echo   '</a>';
        echo   '<div class="card-body">';
        echo     '<span class="card-cat">' . $naslov . '</span>';
        echo     '<h3 class="card-title"><a href="clanak.php?id=' . $row['id'] . '">' . $row['naslov'] . '</a></h3>';
        echo     '<p class="card-excerpt">' . $row['sazetak'] . '</p>';
        echo   '</div>';
        echo '</article>';
    }

    echo '</div>';
    echo '</section>';
}

mysqli_close($dbc);
include 'footer.php';
