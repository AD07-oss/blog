<?php
// Connexion MySQL + objet Smarty (Smarty 4 placé à la main dans le dossier "smarty")
require_once __DIR__ . '/smarty/libs/Smarty.class.php';

try {
    $pdo = new PDO(
        'mysql:host=localhost;dbname=blog;charset=utf8mb4',
        'root',   // à adapter
        '',       // à adapter
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
} catch (PDOException $e) {
    die('Erreur de connexion à la base : ' . $e->getMessage());
}

$smarty = new Smarty();
$smarty->setTemplateDir(__DIR__ . '/templates');
$smarty->setCompileDir(__DIR__ . '/templates_c');
$smarty->setCacheDir(__DIR__ . '/cache');
$smarty->setConfigDir(__DIR__ . '/configs');
