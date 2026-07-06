<?php
require_once __DIR__ . '/../includes/header.php';

if (!$est_connecte) {
    header('Location: /connexion.php');
    exit;
}

$id_article = (int)($_GET['id'] ?? 0);

// vérifier qu'il existe
$stmt = $pdo->prepare("SELECT * FROM article WHERE id_article = ?");
$stmt->execute([$id_article]);
$article = $stmt->fetch();

if (!$article) {
    header('Location: /index.php');
    exit;
}

// juste l'auteur peut modifier article
if ($article['id_utilisateur'] != $_SESSION['id_utilisateur']) {
    header('Location: /index.php');
    exit;
}

$erreur = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titre   = trim($_POST['titre'] ?? '');
    $contenu = trim($_POST['contenu'] ?? '');

    if ($titre === '' || $contenu === '') {
        $erreur = "Le titre et le contenu sont obligatoires.";
    } else {
        $stmt = $pdo->prepare(
            "UPDATE article
             SET titre = ?, contenu = ?
             WHERE id_article = ? AND id_utilisateur = ?"
        );
        $stmt->execute([$titre, $contenu, $id_article, $_SESSION['id_utilisateur']]);

        header('Location: /index.php');
        exit;
    }
}
?>

<div class="form-card">
    <h1>Modifier l'article</h1>

    <?php if ($erreur): ?>
        <div class="message erreur"><?= htmlspecialchars($erreur) ?></div>
    <?php endif; ?>

    <form method="POST" action="/modifier_article.php?id=<?= $id_article ?>">
        <div class="form-group">
            <label for="titre">Titre</label>
            <input type="text" id="titre" name="titre" required
                   value="<?= htmlspecialchars($_POST['titre'] ?? $article['titre']) ?>">
        </div>

        <div class="form-group">
            <label for="contenu">Contenu</label>
            <textarea id="contenu" name="contenu" required><?= htmlspecialchars($_POST['contenu'] ?? $article['contenu']) ?></textarea>
        </div>

        <button type="submit" class="btn">Enregistrer les modification</button>
    </form>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
