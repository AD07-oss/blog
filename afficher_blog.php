<?php
require_once 'config_blog.php';

// Vérification du paramètre ID
$id = filter_input(INPUT_GET, 'ID', FILTER_VALIDATE_INT);
if (!$id) {
    header('Location: index_blog.php');
    exit;
}

// Le billet
$stmt = $pdo->prepare(
    "SELECT ID, titre, contenu, categorie,
            DATE_FORMAT(date_billet, '%d/%m/%Y %H:%i') AS date_billet
     FROM billets_blog WHERE ID = ?"
);
$stmt->execute([$id]);
$billet = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$billet) {
    header('Location: index_blog.php');
    exit;
}

// Ses commentaires
$stmt = $pdo->prepare(
    "SELECT nom, comment,
            DATE_FORMAT(date_comment, '%d/%m/%Y %H:%i') AS date
     FROM commentaires_blog WHERE ID = ? ORDER BY commentaires_blog.date_comment"
);
$stmt->execute([$id]);

$smarty->assign('titre', $billet['titre']);
$smarty->assign('billet', $billet);
$smarty->assign('commentaires', $stmt->fetchAll(PDO::FETCH_ASSOC));
$smarty->display('afficher_blog.tpl');
