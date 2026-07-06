<?php
require_once __DIR__ . '/../includes/header.php';

// si connecté rediriger vers l'accueil
if ($est_connecte) {
    header('Location: /index.php');
    exit;
}

$erreur = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom_utilisateur = trim($_POST['nom_utilisateur'] ?? '');
    $mot_de_passe    = $_POST['mot_de_passe'] ?? '';

    if ($nom_utilisateur === '' || $mot_de_passe === '') {
        $erreur = "Tous les champs sont obligatoires.";
    } else {
        $stmt = $pdo->prepare(
            "SELECT id_utilisateur, nom, nom_utilisateur, mot_de_passe
             FROM utilisateur
             WHERE nom_utilisateur = ?"
        );
        $stmt->execute([$nom_utilisateur]);
        $utilisateur = $stmt->fetch();

        if ($utilisateur && password_verify($mot_de_passe, $utilisateur['mot_de_passe'])) {
            session_regenerate_id(true);

            $_SESSION['id_utilisateur']  = $utilisateur['id_utilisateur'];
            $_SESSION['nom_utilisateur'] = $utilisateur['nom'];

            header('Location: /index.php');
            exit;
        } else {
            $erreur = "Nom d'utilisateur ou mot de passe incorrect.";
        }
    }
}
?>

<div class="form-card">
    <h1>Connexion</h1>

    <?php if ($erreur): ?>
        <div class="message erreur"><?= htmlspecialchars($erreur) ?></div>
    <?php endif; ?>

    <form method="POST" action="/connexion.php">
        <div class="form-group">
            <label for="nom_utilisateur">Nom de user</label>
            <input type="text" id="nom_utilisateur" name="nom_utilisateur" required
                   value="<?= htmlspecialchars($_POST['nom_utilisateur'] ?? '') ?>">
        </div>

        <div class="form-group">
            <label for="mot_de_passe">Mot de passe</label>
            <input type="password" id="mot_de_passe" name="mot_de_passe" required>
        </div>

        <button type="submit" class="btn">Se connecter</button>
    </form>

    <p style="margin-top: 15px; text-align: center;">
        Pas de comptes?<a href="/inscription.php">S'inscrire</a>
    </p>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
