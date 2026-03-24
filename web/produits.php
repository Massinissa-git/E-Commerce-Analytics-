<?php
$page_title = "Produits - E-Commerce Analytics";
require_once 'config.php';
require_once 'includes/fonctions.inc.php';

$produits = lire_csv('top_produits.csv');
?>
<?php include 'includes/header.inc.php'; ?>

<h2><i class="fas fa-box"></i> Top Produits</h2>

<div class="chart-container fade-in">
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
                <?php foreach ($produits as $i => $produit): ?>
                <tr>
                    <td class="text-muted"><?php echo $i + 1; ?></td>
                    <td><?php echo htmlspecialchars($produit['Produit']); ?></td>
                    <td class="text-end"><?php echo number_format((float)$produit['CA Total (€)'], 2, ',', ' '); ?> €</td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include 'includes/footer.inc.php'; ?>
