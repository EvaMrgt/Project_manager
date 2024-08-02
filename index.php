<?php
session_start();
require_once './_db/dbconnect.php';

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Archivo+Black&family=Libre+Barcode+128+Text&family=Special+Elite&display=swap" rel="stylesheet">
    <link rel="icon" href="./assets/imgs/couronne.png">
    <title>Gestion de Projets</title>
</head>

<body>
    <header>
        <h1>Accueil</h1>
    </header>
    <main>
        <?php
        if (isset($_SESSION['error'])) {
            echo "<p>" . $_SESSION['error'] . "</p>";
            unset($_SESSION['error']);
        }
        ?>
        <div id="container">
            <div id="inscription-container">
                <form action="_db/register.php" autocomplete="off" id="inscription" method="POST" onsubmit="return validatePassword()">
                    <h2>Inscription</h2>
                    <label for="username">Pseudo :</label>
                    <input type="text" id="username" name="username" required>
                    <label for="email">Email :</label>
                    <input type="email" id="email" name="email" required>
                    <label for="password">Mot de passe :</label>
                    <input type="password" id="password" name="password" required>
                    <label for="confirm-password">Confirmer le mot de passe :</label>
                    <input type="password" id="confirm-password" name="confirm-password" required>
                    <button type="submit">S'inscrire</button>
                </form>
            </div>
            <div id="connexion-container">
                <form action="_db/login.php" autocomplete="off" id="connexion" method="POST">
                    <h2>Connexion</h2>
                    <label for="email">Email :</label>
                    <input type="email" id="email" name="email" required>
                    <label for="login-password">Mot de passe :</label>
                    <input type="password" id="login-password" name="password" required>
                    <button type="submit">Se connecter</button>
                </form>
            </div>
        </div>
    </main>
    <footer>
        <p>&copy; 2024 - Gestion de Projets. Tous droits reserves. Eva Margot</p>
    </footer>
    <script src="./assets/js/darkmode.js"></script>
</body>

</html>