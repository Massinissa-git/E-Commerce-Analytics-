<?php
$page_title = "Accueil - E-Commerce Analytics";
require_once 'config.php';
require_once 'includes/fonctions.inc.php';

$stats       = getStats();
$topProducts = lire_csv('top_produits.csv');
?>
<?php include 'includes/header.inc.php'; ?>

<!-- Hero -->
<div class="hero fade-in">
    <h1><i class="fas fa-chart-line"></i> E-Commerce Analytics</h1>
    <p class="subtitle">Plateforme d'analyse de données e-commerce</p>
    <div class="presentation-card">
        <h2><i class="fas fa-user-graduate"></i> Lomani Massinissa</h2>
        <p><i class="fas fa-graduation-cap"></i> Étudiant en Licence 2 Informatique &nbsp;|&nbsp; CY Cergy Paris Université</p>
    </div>
    <a href="dashboard.php" class="btn btn-primary">
        <i class="fas fa-chart-line"></i> Voir le Dashboard
    </a>
</div>

<!-- Statistiques -->
<div class="row fade-in">
    <div class="stat-card">
        <i class="fas fa-database"></i>
        <div class="stat-value"><?php echo number_format($stats['total_lignes'], 0, ',', ' '); ?></div>
        <div class="stat-label">Transactions</div>
    </div>
    <div class="stat-card">
        <i class="fas fa-euro-sign"></i>
        <div class="stat-value"><?php echo number_format($stats['ca_total'], 0, ',', ' '); ?> €</div>
        <div class="stat-label">Chiffre d'Affaires</div>
    </div>
    <div class="stat-card">
        <i class="fas fa-users"></i>
        <div class="stat-value"><?php echo number_format($stats['nb_clients'], 0, ',', ' '); ?></div>
        <div class="stat-label">Clients Uniques</div>
    </div>
    <div class="stat-card">
        <i class="fas fa-box"></i>
        <div class="stat-value"><?php echo number_format($stats['nb_produits'], 0, ',', ' '); ?></div>
        <div class="stat-label">Produits Distincts</div>
    </div>
</div>

<!-- Top Produits CSV -->
<div class="chart-container fade-in">
    <h4><i class="fas fa-trophy"></i> Top Produits par Chiffre d'Affaires</h4>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Produit</th>
                    <th class="text-end">CA Total (€)</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($topProducts as $i => $product): ?>
                <tr>
                    <td class="text-muted"><?php echo $i + 1; ?></td>
                    <td><?php echo htmlspecialchars($product['Produit']); ?></td>
                    <td class="text-end"><?php echo number_format((float)$product['CA Total (€)'], 2, ',', ' '); ?> €</td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include 'includes/footer.inc.php'; ?>
