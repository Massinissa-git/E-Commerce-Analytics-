<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? htmlspecialchars($page_title) : 'E-Commerce Analytics'; ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<nav>
    <div class="nav-inner">
        <a href="index.php" class="nav-brand">
            <i class="fas fa-chart-line"></i> E-Commerce Analytics
        </a>
        <ul>
            <li>
                <a href="index.php" class="<?php echo basename($_SERVER['PHP_SELF']) === 'index.php' ? 'active' : ''; ?>">
                    <i class="fas fa-home"></i> Accueil
                </a>
            </li>
            <li>
                <a href="dashboard.php" class="<?php echo basename($_SERVER['PHP_SELF']) === 'dashboard.php' ? 'active' : ''; ?>">
                    <i class="fas fa-tachometer-alt"></i> Dashboard
                </a>
            </li>
            <li>
                <a href="graphiques.php" class="<?php echo basename($_SERVER['PHP_SELF']) === 'graphiques.php' ? 'active' : ''; ?>">
                    <i class="fas fa-chart-bar"></i> Graphiques
                </a>
            </li>
            <li>
                <a href="produits.php" class="<?php echo basename($_SERVER['PHP_SELF']) === 'produits.php' ? 'active' : ''; ?>">
                    <i class="fas fa-box"></i> Produits
                </a>
            </li>
            <li>
                <a href="clients.php" class="<?php echo basename($_SERVER['PHP_SELF']) === 'clients.php' ? 'active' : ''; ?>">
                    <i class="fas fa-users"></i> Clients
                </a>
            </li>
        </ul>
    </div>
</nav>

<div class="container">
