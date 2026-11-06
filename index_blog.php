<?php
require_once 'config_blog.php';

$where  = '';
$params = [];
$categorie = '';

if (isset($_GET['categorie']) && trim($_GET['categorie']) !== '') {
    $categorie = trim($_GET['categorie']);
    $where  = 'WHERE categorie = ?';
    $params = [$categorie];
}

$stmt = $pdo->prepare(
    "SELECT ID, titre, annonce, categorie,
            DATE_FORMAT(date_billet, '%d/%m/%Y %H:%i') AS date_billet
     FROM billets_blog
     $where
     ORDER BY billets_blog.date_billet DESC
     LIMIT 10"
);
$stmt->execute($params);

$smarty->assign('billets', $stmt->fetchAll(PDO::FETCH_ASSOC));
$smarty->assign('categorie', $categorie);
$smarty->assign('titre', 'Mon blog');
$smarty->display('index_blog.tpl');
