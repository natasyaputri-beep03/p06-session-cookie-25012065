<?php

require __DIR__ . '/bootstrap.php';
require __DIR__ . '/functions.php';
require __DIR__ . '/data/products.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    setFlash('Aksi tidak valid.');
    header('Location: index.php');
    exit;
}

$action = $_POST['action'] ?? '';
$id = (int) ($_POST['id'] ?? 0);

if (!isset($products[$id])) {
    setFlash('Produk tidak ditemukan.');
    header('Location: index.php');
    exit;
}

if ($action === 'add') {
    $_SESSION['cart'][$id] = ($_SESSION['cart'][$id] ?? 0) + 1;
    setFlash('Produk berhasil ditambahkan ke keranjang.');
} else {
    setFlash('Aksi tidak valid.');
}

header('Location: index.php');
exit;