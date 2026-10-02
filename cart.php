<?php
require __DIR__ . '/bootstrap.php';
require __DIR__ . '/functions.php';
require __DIR__ . '/data/products.php';

$cart = $_SESSION['cart'];
$total = 0;
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Keranjang</title>
</head>
<body>

<h1>Keranjang Belanja</h1>

<?php if (!$cart): ?>

    <p>Keranjang masih kosong.</p>

<?php else: ?>

    <?php foreach ($cart as $id => $qty): ?>

        <?php
        if (!isset($products[$id])) {
            continue;
        }

        $product = $products[$id];
        $subtotal = $product['price'] * $qty;
        $total += $subtotal;
        ?>

        <div>
            <h2><?= e($product['name']) ?></h2>
            <p>Harga: Rp <?= number_format($product['price'], 0, ',', '.') ?></p>
            <p>Jumlah: <?= $qty ?></p>
            <p>Subtotal: Rp <?= number_format($subtotal, 0, ',', '.') ?></p>
        </div>

    <?php endforeach; ?>

    <h2>Total: Rp <?= number_format($total, 0, ',', '.') ?></h2>

<?php endif; ?>

<a href="index.php">Kembali ke Katalog</a>

</body>
</html>