<?php
require_once 'config_blog.php';

// Mode 1 : le formulaire a été envoyé -> on enregistre le billet
if (isset($_POST['titre'], $_POST['contenu'], $_POST['categorie'])) {
    $titre     = trim($_POST['titre']);
    $contenu   = trim($_POST['contenu']);
    $categorie = trim($_POST['categorie']);

    if ($titre !== '' && $contenu !== '') {
        // annonce = extrait sans aucune balise
        $annonce = mb_substr(strip_tags($contenu), 0, 100);

        $stmt = $pdo->prepare(
            'INSERT INTO billets_blog (titre, contenu, annonce, date_billet, categorie)
             VALUES (?, ?, ?, NOW(), ?)'
        );
        $stmt->execute([
            $titre,
            $contenu,
            $annonce,
            mb_substr($categorie, 0, 12),
        ]);

        // Redirection vers l'affichage du billet créé
        header('Location: afficher_blog.php?ID=' . $pdo->lastInsertId());
        exit;
    }
}

// Mode 2 : on affiche le formulaire
$smarty->assign('titre', 'Nouveau billet');
$smarty->display('edition_blog.tpl');
