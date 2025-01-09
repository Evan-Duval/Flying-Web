<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <!-- Flatpickr CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="admin.css">
    <title>Admin</title>
</head>
<body>

    <?php 
        include '../components/navbar.php';
    ?>
  
    <a href="plane/plane.php">
        <button>Ajouter un avion</button> 
    </a>
    
    <a href="aeroport/aeroport.php">
        <button>Ajouter un aéroport</button>
    </a>
    
    <a href="piste/piste.php">
        <button>Ajouter une/des piste(s) à un aéroport</button>
    </a>

    <!-- Flatpickr JS -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
</body>
</html>