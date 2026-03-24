<?php
$page_title = "Dashboard - E-Commerce Analytics";
require_once 'config.php';
require_once 'includes/fonctions.inc.php';

$stats   = getStats();
$topPays = lire_csv('top_pays.csv');
?>
<?php include 'includes/header.inc.php'; ?>

<h2><i class="fas fa-tachometer-alt"></i> Tableau de Bord</h2>

<!-- Statistiques -->
<div class="row fade-in">
    <div class="stat-card">
        <i class="fas fa-euro-sign"></i>
        <div class="stat-value"><?php echo number_format($stats['ca_total'], 0, ',', ' '); ?> €</div>
        <div class="stat-label">CA Total</div>
    </div>
    <div class="stat-card">
        <i class="fas fa-users"></i>
        <div class="stat-value"><?php echo number_format($stats['nb_clients'], 0, ',', ' '); ?></div>
        <div class="stat-label">Clients</div>
    </div>
    <div class="stat-card">
        <i class="fas fa-box"></i>
        <div class="stat-value"><?php echo number_format($stats['nb_produits'], 0, ',', ' '); ?></div>
        <div class="stat-label">Produits</div>
    </div>
    <div class="stat-card">
        <i class="fas fa-receipt"></i>
        <div class="stat-value"><?php echo number_format($stats['total_lignes'], 0, ',', ' '); ?></div>
        <div class="stat-label">Transactions</div>
    </div>
</div>

<!-- Top Pays -->
<div class="chart-container fade-in">
    <h4><i class="fas fa-globe"></i> Top Pays par Chiffre d'Affaires</h4>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Pays</th>
                    <th class="text-end">CA (€)</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($topPays as $i => $pays): ?>
                <tr>
                    <td class="text-muted"><?php echo $i + 1; ?></td>
                    <td><?php echo htmlspecialchars($pays['Pays']); ?></td>
                    <td class="text-end"><?php echo number_format((float)$pays['CA Total (€)'], 2, ',', ' '); ?> €</td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include 'includes/footer.inc.php'; ?>