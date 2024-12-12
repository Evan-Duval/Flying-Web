<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <!-- Flatpickr CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="style.css">
    <title>FlyingWeb Accueil</title>
</head>
<body>

    <?php 
        include '../components/navbar.php';
    ?>

    <div class="title">
        <h1>FlyingWeb</h1>
    </div>

    <div class="blank">
        <div class="resa-info">
            <div class="left">
                <form class="reservation-form">
                    <h2>Réserver</h2>
                    <label for="depart">Départ de :</label>
                    <input type="text" id="depart" name="depart" placeholder="Départ">

                    <label for="destination">Destination :</label>
                    <input type="text" id="destination" name="destination" placeholder="Votre destination">

                    <label for="type">Type de billet :</label>
                    <select id="type" name="type">
                        <option value="">Aller simple</option>
                        <option value="aller-retour">Aller-Retour</option>
                    </select>

                    <label for="date">Date de départ :</label>
                    <!-- Champ texte pour Flatpickr -->
                    <input type="text" id="date" name="date" placeholder="Choisir une date">

                    <label id="date-retour-label" for="date-retour" style="display: none;">Date de retour :</label>
                    <!-- Champ texte pour Flatpickr -->
                    <input id="date-retour" type="text" name="date-retour" style="display: none;" placeholder="Choisir une date de retour">

                    <button type="submit">Voir les prix</button>
      n       </form>
            </div>
            <div class="right">
                
            </div>
        </div>
    </div>

    <div class="banderolle">
        <div class="text">
            <div class="text-object">
                <h3>Voyagez sans limites avec Flying Web</h3>
                <p>Explorez les villes les plus fascinantes au monde. Notre flotte moderne garantit un confort inégalé et un service à la hauteur de vos attentes.</p>
            </div>
            <div class="text-object">
                <h3>Des horizons plus proches que jamais</h3>
                <p>Flying Web vous emmène plus loin avec des connexions rapides et des vols réguliers vers les destinations les plus prisées.</p>
            </div>
            <div class="text-object">
                <h3>Explorez le monde avec confort</h3>
                <p>Prenez les airs avec style grâce à nos services premium, conçus pour vous offrir une expérience unique et inoubliable.</p>
            </div>
        </div>
    </div>

    <!-- Flatpickr JS -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="script.js"></script>
</body>
</html>

