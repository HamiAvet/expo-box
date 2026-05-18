<?php
    $typeClient = htmlspecialchars($_POST['type-client'] ?? '');
    $nom        = htmlspecialchars($_POST['nom-client'] ?? '');
    $prenom     = htmlspecialchars($_POST['prenom-client'] ?? '');
    $email      = htmlspecialchars($_POST['email-client'] ?? '');
    $telephone  = htmlspecialchars($_POST['telephone-client'] ?? '');
    $adresse    = htmlspecialchars($_POST['adresse-client'] ?? '');
    $message    = htmlspecialchars($_POST['message-contact'] ?? '');
    $nomEntreprise = null;

    if ($typeClient === 'professionnel') {
        $nomEntreprise = htmlspecialchars($_POST['entreprise-client'] ?? '');
    } else if ($typeClient === 'particulier') {
        $nomEntreprise = NULL;
    }

    // Chargement des variables d'environnement à partir du fichier .env
    require_once __DIR__ . '/../vendor/autoload.php';
    $dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
    $dotenv->load();

    // Établir la connexion à la base de données
    try {
        // Initialiser le DSN (Data Source Name) pour la connexion à la base de données
        $dns = "mysql:host={$_ENV['hote']};port={$_ENV['port']};dbname={$_ENV['base_de_donnees']}";
        // Options de connexion pour PDO
        $options = [
            PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT => false, // Désactive la vérification du certificat SSL
            PDO::MYSQL_ATTR_SSL_CA => true, // Active l'utilisation de SSL
        ];

        // L'utilisateur de la base de données
        $utilisateur = $_ENV['utilisateur'];

        // Mot de passe de la base de données (vide par défaut)
        $motDePasse = $_ENV['mot_de_passe'];
        
        // Création de la connexion PDO
        $connection = new PDO($dns, $utilisateur, $motDePasse, $options);

    } catch (Exception $ex) {
        // Affichage de l'erreur de connexion
        echo "Erreur de connexion à la base de données : {$ex->getMessage()}";
    }

    // Préparer la requête SQL pour insérer les données du contact
    $cmd = "INSERT INTO messages (type_client, nom_client, prenom_client, nom_entreprise_client, email_client, tel_client, adresse_client, message_client) 
    VALUES (:type_client, :nom_client, :prenom_client, :nom_entreprise_client, :email_client, :tel_client, :adresse_client, :message_client)";

    // Préparer la requête d'insertion
    $requete = $connection->prepare($cmd);

    // Exécuter la requête d'insertion
    $requete->execute([
        ':type_client' => $typeClient,
        ':nom_client' => $nom,
        ':prenom_client' => $prenom,
        ':nom_entreprise_client' => $nomEntreprise,
        ':email_client' => $email,
        ':tel_client' => $telephone,
        ':adresse_client' => $adresse,
        ':message_client' => $message,
    ]);
?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Message envoyé – ExpoBox</title>
        <link rel="stylesheet" href="../style/global.css">
        <link rel="stylesheet" href="../style/menu.css">
        <link rel="stylesheet" href="../style/reception.css">
    </head>
    <body>
        <nav>
            <div class="logo">
                <a href="../index.html"><img src="../public/images/logo_expobox.png" alt="Logo ExpoBox"></a>
            </div>
            <ul class="menu">
                <li><a class="menu_link" href="../index.html">ACCUEIL</a><div class="underline"></div></li>
                <li><a class="menu_link" href="../pages/espaces.html">NOS ESPACES</a><div class="underline"></div></li>
                <li><a class="menu_link" href="../pages/reservation.html">RÉSERVATION</a><div class="underline"></div></li>
                <li><a class="menu_link" href="../pages/contact.html">CONTACT</a><div class="underline"></div></li>
            </ul>
        </nav>

        <main>
            <div class="confirmation">
                <div class="confirmation-entete">
                    <div class="icone-succes">✓</div>
                    <h1>Merci, <?php echo $prenom . ' ' . $nom; ?> !</h1>
                    <p>Votre message a bien été envoyé. Nous vous répondrons dans les plus brefs délais.</p>
                    <div class="bordure-bas"></div>
                </div>

                <div class="recap-carte">
                    <h2>Récapitulatif de votre message</h2>
                    <ul class="recap-liste">
                        <li><strong>Type :</strong> <span><?php echo $typeClient; ?></span></li>
                        <li><strong>Nom :</strong> <span><?php echo $nom; ?></span></li>
                        <li><strong>Prénom :</strong> <span><?php echo $prenom; ?></span></li>
                        <?php if ($nomEntreprise !== NULL) {
                            echo '<li><strong>Entreprise :</strong> <span>' . $nomEntreprise . '</span></li>';
                        } ?>
                        <li><strong>Email :</strong> <span><?php echo $email; ?></span></li>
                        <li><strong>Téléphone :</strong> <span><?php echo $telephone; ?></span></li>
                        <li><strong>Adresse :</strong> <span><?php echo $adresse; ?></span></li>
                        <li><strong>Message :</strong> <span class="message-texte"><?php echo $message; ?></span></li>
                    </ul>
                </div>

                <div class="actions-confirmation">
                    <a href="../index.html" class="btn-retour">Retour à l'accueil</a>
                </div>
            </div>
        </main>

        <footer>
            <p class="copyright">© 2024 Parc Chanot. Tous droits réservés.</p>
            <div class="liens-legaux">
                <a href=""><p>Mentions légales</p></a>
                <a href=""><p>Politique de confidentialité</p></a>
            </div>
        </footer>
    </body>
</html>