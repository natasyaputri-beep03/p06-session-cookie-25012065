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

$isDark = $theme === 'dark';
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog Produk</title>

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
            max-width: 1100px;
            margin: auto;
        }

        header {
            padding: 25px 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 24px;
            font-weight: bold;
        }

        .nav {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        button,
        .cart-button {
            border: none;
            padding: 10px 16px;
            border-radius: 10px;
            cursor: pointer;
            text-decoration: none;
            font-size: 14px;
        }

        .theme-button {
            background: <?= $isDark ? '#374151' : '#e5e7eb' ?>;
            color: <?= $isDark ? '#fff' : '#111827' ?>;
        }

        .cart-button {
            background: #2563eb;
            color: white;
        }

        .hero {
            text-align: center;
            padding: 45px 20px;
        }

        .hero h1 {
            font-size: 38px;
            margin-bottom: 10px;
        }

        .hero p {
            color: <?= $isDark ? '#d1d5db' : '#64748b' ?>;
        }

        .flash {
            background: #dcfce7;
            color: #166534;
            padding: 14px;
            border-radius: 12px;
            margin-bottom: 25px;
            text-align: center;
        }

        .products {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            padding-bottom: 50px;
        }

        .card {
            background: <?= $isDark ? '#374151' : '#ffffff' ?>;
            border-radius: 18px;
            padding: 25px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
        }

        .icon {
            font-size: 45px;
            margin-bottom: 15px;
        }

        .card h2 {
            margin: 0 0 8px;
        }

        .price {
            font-size: 20px;
            font-weight: bold;
            margin: 15px 0;
        }

        .add-button {
            width: 100%;
            background: #2563eb;
            color: white;
        }

        .add-button:hover,
        .cart-button:hover {
            opacity: 0.85;
        }

        footer {
            text-align: center;
            padding: 25px;
            opacity: 0.7;
        }

        @media (max-width: 700px) {
            .products {
                grid-template-columns: 1fr;
            }

            header {
                flex-direction: column;
                gap: 15px;
            }
        }
    </style>
</head>

<body>

<div class="container">

    <header>

        <div class="logo">
            🛍️ My Store
        </div>

        <div class="nav">

            <form method="post">
                <button
                    type="submit"
                    name="theme"
                    value="<?= $isDark ? 'light' : 'dark' ?>"
                    class="theme-button">
                    <?= $isDark ? '☀️ Light' : '🌙 Dark' ?>
                </button>
            </form>

            <a href="cart.php" class="cart-button">
                🛒 Keranjang (<?= $cartCount ?>)
            </a>

        </div>

    </header>

    <section class="hero">

        <h1>Katalog Produk</h1>

        <p>Pilih produk favoritmu dan masukkan ke keranjang 🛍️</p>

    </section>

    <?php if ($flash): ?>

        <div class="flash">
            <?= e($flash) ?>
        </div>

    <?php endif; ?>

    <section class="products">

        <?php foreach ($products as $id => $product): ?>

            <div class="card">

                <div class="icon">
                    <?= $id === 1 ? '☕' : ($id === 2 ? '🍞' : '🍋') ?>
                </div>

                <h2>
                    <?= e($product['name']) ?>
                </h2>

                <div class="price">
                    Rp <?= number_format($product['price'], 0, ',', '.') ?>
                </div>

                <form method="post" action="actions.php">

                    <input
                        type="hidden"
                        name="action"
                        value="add">

                    <input
                        type="hidden"
                        name="id"
                        value="<?= $id ?>">

                    <button
                        type="submit"
                        class="add-button">
                        + Tambah ke Keranjang
                    </button>

                </form>

            </div>

        <?php endforeach; ?>

    </section>

</div>

<footer>
    Pertemuan 6 • Session, Cookie & Keranjang Belanja
</footer>

</body>
</html>