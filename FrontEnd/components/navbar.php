<head>
    <link rel="stylesheet" href="../components/navbarstyle.css">
</head>

<body>
    <nav class="sidebar">
        <div class="logo-menu">
            <h2 class="logo">FlyingWeb</h2>
            <i class='bx bx-menu toggle-btn'></i>
        </div>

        <ul class="list">
            <li class="list-item">
                <a href="../home/index.php">
                    <i class='bx bxs-home'></i>
                    <span class="link-name" style="--i:1;">Accueil</span>
                </a>
            </li>
            <!-- <li class="list-item">
                <a href="#">
                    <i class='bx bxs-store'></i>
                    <span class="link-name" style="--i:2;">Boutique</span>
                </a>
            </li> -->
            <li class="list-item">
                <a href="../profil/profil.php">
                    <i class='bx bxs-contact'></i>
                    <span class="link-name" style="--i:3;">Profil</span>
                </a>
            </li>
            <li class="list-item">
                <a href="../connexion/connexion.php">
                    <i class='bx bxs-user'></i>
                    <span class="link-name" style="--i:4;">Se connecter</span>
                </a>
            </li>
            <?php
            session_start();
            
            if (isset($_SESSION['user'])) {
                $user = $_SESSION['user'];
                if ($user['rank'] === 'admin') {
                    echo"<li class=\"list-item\">
                        <a href=\"../admin/admin.php\">
                            <i class='bx bxs-data'></i>
                            <span class=\"link-name\" style=\"--i:5;\">Admin Panel</span>
                        </a>
                    </li>";
                }
            }
            ?>
        </ul>
    </nav>

    <script src="../components/navbarscript.js"></script>
</body>