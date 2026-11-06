<?php
// Pas de template : ce script n'affiche rien, il enregistre puis redirige.
require_once 'config_blog.php';

$id = filter_input(INPUT_POST, 'ID', FILTER_VALIDATE_INT);
if (!$id) {
    header('Location: index_blog.php');
    exit;
}

// Le billet existe-t-il ?
$stmt = $pdo->prepare('SELECT ID FROM billets_blog WHERE ID = ?');
$stmt->execute([$id]);
if (!$stmt->fetch()) {
    header('Location: index_blog.php');
    exit;
}

$nom         = trim($_POST['nom'] ?? '');
$commentaire = trim($_POST['commentaire'] ?? '');

if ($nom !== '' && $commentaire !== '') {
    $stmt = $pdo->prepare(
        'INSERT INTO commentaires_blog (nom, comment, ID) VALUES (?, ?, ?)'
    );
    $stmt->execute([mb_substr($nom, 0, 50), $commentaire, $id]);
}

header('Location: afficher_blog.php?ID=' . $id);
exit;
