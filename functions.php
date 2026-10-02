<?php

function e(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

function setFlash(string $message): void
{
    $_SESSION['flash'] = $message;
}

function pullFlash(): ?string
{
    $message = $_SESSION['flash'] ?? null;
    unset($_SESSION['flash']);

    return $message;
}

function cartCount(array $cart): int
{
    return array_sum($cart);
}