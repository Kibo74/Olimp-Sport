<?php
define('UPLPATH', 'img/');

$title = isset($_POST['title']) ? $_POST['title'] : '';
$about = isset($_POST['about']) ? $_POST['about'] : '';
$content = isset($_POST['content']) ? $_POST['content'] : '';
$category = isset($_POST['category']) ? $_POST['category'] : '';
$archive = isset($_POST['archive']) ? 'Da' : 'Ne';
$datum = date('d.m.Y.');

$image = '';
if (isset($_FILES['pphoto']) && $_FILES['pphoto']['name'] !== '') {
    $image = basename($_FILES['pphoto']['name']);
    move_uploaded_file($_FILES['pphoto']['tmp_name'], UPLPATH . $image);
}

$title_page = $title !== '' ? $title : 'Pregled proizvoda';
?>
<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($title_page); ?> | Olimp Sport</title>
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
                <li><a href="index.php">Pocetna</a></li>
                <li><a href="kategorija.php?kategorija=nogomet">Nogomet</a></li>
                <li><a href="kategorija.php?kategorija=kosarka">Kosarka</a></li>
                <li><a href="kategorija.php?kategorija=fitness">Fitness</a></li>
                <li><a href="unos.php" class="active">Unos</a></li>
                <li><a href="administracija.php">Administracija</a></li>
            </ul>
        </nav>
    </header>

    <main class="content">
        <section class="article-single" role="main">
            <div class="row">
                <p class="category"><?php echo $category; ?></p>
                <h1 class="title"><?php echo $title; ?></h1>
                <div class="meta">
                    <p>AUTOR: Olimp Sport</p>
                    <p>OBJAVLJENO: <?php echo $datum; ?></p>
                    <p>ARHIVIRANO: <?php echo $archive; ?></p>
                </div>
            </div>

            <?php if ($image !== '') { ?>
            <section class="slika">
                <?php echo '<img src="' . UPLPATH . $image . '" alt="' . htmlspecialchars($title) . '">'; ?>
            </section>
            <?php } ?>

            <section class="about">
                <p><?php echo $about; ?></p>
            </section>

            <section class="sadrzaj">
                <p><?php echo nl2br($content); ?></p>
            </section>

            <a class="back-link" href="unos.html">&larr; Natrag na formu</a>
        </section>
    </main>

    <footer>
        <div>Autor: <strong>Borna Babić</strong></div>
        <div>Kontakt: <a href="mailto:bbabic@tvz.hr">bbabic@tvz.hr</a></div>
        <div class="copyright">&copy; 2026 Olimp Sport &middot; Programiranje web aplikacija</div>
    </footer>

</div>
</body>
</html>
