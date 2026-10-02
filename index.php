<?php

require __DIR__ . '/bootstrap.php';
require __DIR__ . '/functions.php';
require __DIR__ . '/data/products.php';
if (isset($_POST['theme'])) {
    $newTheme = $_POST['theme'];

    if (in_array($newTheme, ['light', 'dark'], true)) {
        setcookie('theme', $newTheme, [
            'expires' => time() + (30 * 24 * 60 * 60),
            'httponly' => true,
            'samesite' => 'Lax',
        ]);

        header('Location: index.php');
        exit;
    }
}


$theme = $_COOKIE['theme'] ?? 'light';

if (!in_array($theme, ['light', 'dark'], true)) {
    $theme = 'light';
}

$flash = pullFlash();
$cartCount = cartCount($_SESSION['cart']);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Katalog Produk</title>
</head>
<body style="background: <?= $theme === 'dark' ? '#222' : '#fff' ?>; color: <?= $theme === 'dark' ? '#fff' : '#000' ?>;">
<form method="post">
    <button type="submit" name="theme" value="light">Light</button>
    <button type="submit" name="theme" value="dark">Dark</button>
</form>

<h1>Katalog Produk</h1>

<?php if ($flash): ?>
    <p><?= e($flash) ?></p>
<?php endif; ?>

<p>Jumlah barang di keranjang: <?= $cartCount ?></p>

<?php foreach ($products as $id => $product): ?>
    <div>
        <h2><?= e($product['name']) ?></h2>
        <p>Rp <?= number_format($product['price'], 0, ',', '.') ?></p>

        <form method="post" action="actions.php">
            <input type="hidden" name="action" value="add">
            <input type="hidden" name="id" value="<?= $id ?>">
            <button type="submit">Tambah ke Keranjang</button>
        </form>
    </div>
<?php endforeach; ?>

</body>
</html>