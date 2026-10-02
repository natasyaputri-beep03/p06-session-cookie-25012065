<?php

require __DIR__ . '/bootstrap.php';
require __DIR__ . '/functions.php';
require __DIR__ . '/data/products.php';

$flash = pullFlash();
$cartCount = cartCount($_SESSION['cart']);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Katalog Produk</title>
</head>
<body>

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