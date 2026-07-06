<?php
require_once __DIR__ . '/../includes/header.php';

if (!$est_connecte) {
    header('Location: /connexion.php');
    exit;
}

$erreur = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titre   = trim($_POST['titre'] ?? '');
    $contenu = trim($_POST['contenu'] ?? '');

    if ($titre === '' || $contenu === '') {
        $erreur = "Le titre et le texte est obligatoire.";
    } else {
        $stmt = $pdo->prepare(
            "INSERT INTO article (titre, contenu, id_utilisateur)
             VALUES (?, ?, ?)"
        );
        $stmt->execute([$titre, $contenu, $_SESSION['id_utilisateur']]);

        header('Location: /index.php');
        exit;
    }
}
?>

<div class="form-card">
    <h1>Nouvel article</h1>

    <?php if ($erreur): ?>
        <div class="message erreur"><?= htmlspecialchars($erreur) ?></div>
    <?php endif; ?>

    <form method="POST" action="/nouvel_article.php">
        <div class="form-group">
            <label for="titre">Titre</label>
            <input type="text" id="titre" name="titre" required
                   value="<?= htmlspecialchars($_POST['titre'] ?? '') ?>">
        </div>

        <div class="form-group">
            <label for="contenu">Contenu</label>
            <textarea id="contenu" name="contenu" required><?= htmlspecialchars($_POST['contenu'] ?? '') ?></textarea>
        </div>

        <button type="submit" class="btn">Publier</button>
    </form>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
