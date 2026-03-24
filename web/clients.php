<?php
$page_title = "Clients - E-Commerce Analytics";
require_once 'config.php';
require_once 'includes/fonctions.inc.php';

$clients = lire_csv('top_clients.csv');
?>
<?php include 'includes/header.inc.php'; ?>

<h2><i class="fas fa-users"></i> Top Clients</h2>

<div class="chart-container fade-in">
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>ID Client</th>
                    <th class="text-end">CA Total (€)</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($clients as $i => $client): ?>
                <tr>
                    <td class="text-muted"><?php echo $i + 1; ?></td>
                    <td><?php echo htmlspecialchars($client['CustomerID']); ?></td>
                    <td class="text-end"><?php echo number_format((float)$client['CA Total (€)'], 2, ',', ' '); ?> €</td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include 'includes/footer.inc.php'; ?>
