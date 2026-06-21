<?php
if (!isset($title))  { $title  = 'Olimp Sport'; }
if (!isset($active)) { $active = ''; }

function navAktivno($name, $active) {
    return $name === $active ? ' active' : '';
}
?>
<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($title); ?> | Olimp Sport</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<div class="wrapper">

    <header>
        <div class="logo">
            <a href="index.php">Olimp<span class="logo-sport">Sport</span></a>
        </div>

        <nav role="navigation">
            <ul>
                <li><a href="index.php" class="<?php echo navAktivno('pocetna', $active); ?>">Pocetna</a></li>
                <li><a href="kategorija.php?kategorija=nogomet" class="<?php echo navAktivno('nogomet', $active); ?>">Nogomet</a></li>
                <li><a href="kategorija.php?kategorija=kosarka" class="<?php echo navAktivno('kosarka', $active); ?>">Kosarka</a></li>
                <li><a href="kategorija.php?kategorija=fitness" class="<?php echo navAktivno('fitness', $active); ?>">Fitness</a></li>
                <li><a href="unos.php" class="<?php echo navAktivno('unos', $active); ?>">Unos</a></li>
                <li><a href="administracija.php" class="<?php echo navAktivno('administracija', $active); ?>">Administracija</a></li>
            </ul>
        </nav>
    </header>

    <main class="content">
