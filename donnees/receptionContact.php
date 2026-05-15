<?php
    $typeClient = $_POST['type-client'];
    $nom        = $_POST['nom-client'];
    $prenom     = $_POST['prenom-client'];
    $email      = $_POST['email-client'];
    $telephone  = $_POST['telephone-client'];
    $adresse    = $_POST['adresse-client'];
    $message    = $_POST['message-contact'];

    if ($typeClient === 'professionnel') {
        $nomEntreprise = $_POST['entreprise-client'];
    } else if ($typeClient === 'particulier') {
        $nomEntreprise = NULL;
    }
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
                <li class="selected"><a class="menu_link" href="../pages/contact.html">CONTACT</a><div class="underline"></div></li>
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