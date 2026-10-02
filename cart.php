<?php

require __DIR__ . '/bootstrap.php';
require __DIR__ . '/functions.php';
require __DIR__ . '/data/products.php';

$cart = $_SESSION['cart'];

$total = 0;

$theme = $_COOKIE['theme'] ?? 'light';

if (!in_array($theme, ['light', 'dark'], true)) {
    $theme = 'light';
}

$isDark = $theme === 'dark';

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Keranjang Belanja</title>

    <style>

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: <?= $isDark ? '#1f2937' : '#f8fafc' ?>;
            color: <?= $isDark ? '#f9fafb' : '#1f2937' ?>;
        }

        .container {
            width: 90%;
            max-width: 900px;
            margin: auto;
            padding: 40px 0;
        }

        .top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .back {
            text-decoration: none;
            background: #e5e7eb;
            color: #111827;
            padding: 10px 16px;
            border-radius: 10px;
        }

        .cart-box {
            background: <?= $isDark ? '#374151' : '#ffffff' ?>;
            border-radius: 18px;
            padding: 25px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
        }

        .item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 18px 0;
            border-bottom: 1px solid <?= $isDark ? '#4b5563' : '#e5e7eb' ?>;
        }

        .item-name {
            font-weight: bold;
        }

        .item-info {
            margin-top: 6px;
            opacity: 0.7;
        }

        .remove {
            background: #ef4444;
            color: white;
        }

        .total {
            text-align: right;
            font-size: 22px;
            font-weight: bold;
            margin-top: 25px;
        }

        .actions {
            display: flex;
            justify-content: space-between;
            margin-top: 25px;
        }

        .clear {
            background: #ef4444;
            color: white;
            border: none;
            padding: 12px 18px;
            border-radius: 10px;
            cursor: pointer;
        }

        .empty {
            text-align: center;
            padding: 50px 20px;
        }

    </style>

</head>

<body>

<div class="container">

    <div class="top">

        <h1>🛒 Keranjang Belanja</h1>

        <a href="index.php" class="back">
            ← Kembali
        </a>

    </div>

    <div class="cart-box">

        <?php if (empty($cart)): ?>

            <div class="empty">

                <h2>Keranjang masih kosong 🛒</h2>

                <p>Yuk pilih produk terlebih dahulu.</p>

                <a href="index.php" class="back">
                    Lihat Produk
                </a>

            </div>

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

                <div class="item">

                    <div>

                        <div class="item-name">
                            <?= e($product['name']) ?>
                        </div>

                        <div class="item-info">
                            <?= $qty ?> ×
                            Rp <?= number_format($product['price'], 0, ',', '.') ?>
                        </div>

                    </div>

                    <div>

                        <strong>
                            Rp <?= number_format($subtotal, 0, ',', '.') ?>
                        </strong>

                        <form
                            method="post"
                            action="actions.php"
                            style="display:inline;">

                            <input
                                type="hidden"
                                name="action"
                                value="remove">

                            <input
                                type="hidden"
                                name="id"
                                value="<?= $id ?>">

                            <button
                                type="submit"
                                class="remove">
                                Hapus
                            </button>

                        </form>

                    </div>

                </div>

            <?php endforeach; ?>

            <div class="total">

                Total:
                Rp <?= number_format($total, 0, ',', '.') ?>

            </div>

            <div class="actions">

                <a href="index.php" class="back">
                    + Tambah Produk
                </a>

                <form method="post" action="actions.php">

                    <input
                        type="hidden"
                        name="action"
                        value="clear">

                    <button
                        type="submit"
                        class="clear">
                        Kosongkan Keranjang
                    </button>

                </form>

            </div>

        <?php endif; ?>

    </div>

</div>

</body>
</html>