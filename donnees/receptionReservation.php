<?php
    $typeClient = $_POST['type-client'];
    $nom = $_POST['nom-client'];
    $prenom = $_POST['prenom-client'];
    $email = $_POST['email-client'];
    $telephone = $_POST['telephone-client'];
    $adresse = $_POST['adresse-client'];
    $debutLoc = $_POST['date-debut-reservation'];
    $finLoc = $_POST['date-fin-reservation'] ?? '';
    $message = $_POST['message-reservation'] ?? '';

    if ($typeClient === 'professionnel') {
        $nomEntreprise = $_POST['entreprise-client'] ?? '';
    } else {
        $nomEntreprise = null;
    }

    $reservationJson = $_POST['stockage-espaces'] ?? '[]';
    $reservations = json_decode($reservationJson, true);

    if (!is_array($reservations)) {
        $reservations = [];
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

                <div class="recap-carte">
                    <h2>Récapitulatif de votre réservation</h2>

                    <?php if (empty($reservations)) : ?>
                        <p>Aucun espace sélectionné.</p>
                    <?php else : ?>
                        <?php foreach ($reservations as $reservation) : ?>
                            <ul class="recap-liste recap-liste">
                                <li>
                                    <strong>Espace :</strong>
                                    <span><?php echo $reservation['nomEspace'] ?? ''; ?></span>
                                </li>

                                <li>
                                    <strong>Options :</strong>
                                    <span>
                                        <?php
                                            $options = $reservation['options'] ?? [];
                                            echo !empty($options)
                                                ? implode(', ', $options)
                                                : 'Aucune option';
                                        ?>
                                    </span>
                                </li>

                                <li>
                                    <strong>Équipements :</strong>
                                    <span>
                                        <?php
                                            $equipements = $reservation['equipements'] ?? [];

                                            if (empty($equipements)) {
                                                echo 'Aucun équipement';
                                            } else {
                                                $listeEquipements = [];

                                                foreach ($equipements as $equipement) {
                                                    $nomEquipement = $equipement['nomEquipement'] ?? '';
                                                    $quantite = $equipement['quantite'] ?? 0;
                                                    $listeEquipements[] = $nomEquipement . ' (' . $quantite . ')';
                                                }

                                                echo implode(', ', $listeEquipements);
                                            }
                                        ?>
                                    </span>
                                </li>
                            </ul>
                        <?php endforeach; ?>
                    <?php endif; ?>
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