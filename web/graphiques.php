<?php
$page_title = "Graphiques - E-Commerce Analytics";
require_once 'config.php';
require_once 'includes/fonctions.inc.php';

$topProducts  = getTopProducts(10);
$topCountries = getTopCountries(10);
?>
<?php include 'includes/header.inc.php'; ?>

<h2><i class="fas fa-chart-bar"></i> Visualisation des Données</h2>

<div class="row">
    <div class="chart-container col-6 fade-in">
        <h4><i class="fas fa-chart-pie"></i> Répartition du CA par Pays</h4>
        <canvas id="pieChart"></canvas>
    </div>
    <div class="chart-container col-6 fade-in">
        <h4><i class="fas fa-chart-bar"></i> Top 10 Produits par CA</h4>
        <canvas id="barChart"></canvas>
    </div>
</div>

<div class="chart-container fade-in mt-2">
    <h4><i class="fas fa-globe"></i> Comparaison des Pays (CA en milliers €)</h4>
    <canvas id="radarChart" height="80"></canvas>
</div>

<script>
const darkColors = ['#555555','#666666','#444444','#777777','#333333','#888888','#3a3a3a','#999999','#2a2a2a','#aaaaaa'];

// Pie
new Chart(document.getElementById('pieChart'), {
    type: 'pie',
    data: {
        labels: <?php echo json_encode(array_column($topCountries, 'Country')); ?>,
        datasets: [{
            data: <?php echo json_encode(array_map(fn($c) => round((float)$c['ca'], 2), $topCountries)); ?>,
            backgroundColor: darkColors,
            borderColor: '#0d0d0d',
            borderWidth: 2
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { position: 'right', labels: { color: '#888888', font: { size: 11 } } },
            tooltip: {
                callbacks: {
                    label: function(ctx) {
                        const total = ctx.dataset.data.reduce((a,b) => a+b, 0);
                        const pct = ((ctx.raw / total) * 100).toFixed(1);
                        return ctx.label + ': ' + ctx.raw.toLocaleString('fr-FR') + ' € (' + pct + '%)';
                    }
                }
            }
        }
    }
});

// Bar horizontal
new Chart(document.getElementById('barChart'), {
    type: 'bar',
    data: {
        labels: <?php echo json_encode(array_map(fn($p) => mb_substr($p['Description'], 0, 28), $topProducts)); ?>,
        datasets: [{
            label: 'CA (€)',
            data: <?php echo json_encode(array_map(fn($p) => round((float)$p['ca'], 2), $topProducts)); ?>,
            backgroundColor: '#333333',
            borderColor: '#555555',
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        indexAxis: 'y',
        plugins: {
            legend: { display: false },
            tooltip: { callbacks: { label: ctx => ctx.raw.toLocaleString('fr-FR') + ' €' } }
        },
        scales: {
            x: { ticks: { color: '#555555', callback: v => v.toLocaleString('fr-FR') + ' €' }, grid: { color: '#1a1a1a' } },
            y: { ticks: { color: '#888888', font: { size: 10 } }, grid: { color: '#1a1a1a' } }
        }
    }
});

// Radar
const radarLabels = <?php echo json_encode(array_map(fn($c) => $c['Country'], array_slice($topCountries, 0, 7))); ?>;
const radarData   = <?php echo json_encode(array_map(fn($c) => round((float)$c['ca'] / 1000, 1), array_slice($topCountries, 0, 7))); ?>;

new Chart(document.getElementById('radarChart'), {
    type: 'radar',
    data: {
        labels: radarLabels,
        datasets: [{
            label: 'CA (milliers €)',
            data: radarData,
            backgroundColor: 'rgba(100,100,100,0.15)',
            borderColor: '#666666',
            pointBackgroundColor: '#999999',
            borderWidth: 2
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { labels: { color: '#888888' } } },
        scales: {
            r: {
                beginAtZero: true,
                grid: { color: '#1f1f1f' },
                angleLines: { color: '#1f1f1f' },
                ticks: { color: '#555555', backdropColor: 'transparent', callback: v => v + 'k €' },
                pointLabels: { color: '#888888', font: { size: 11 } }
            }
        }
    }
});
</script>

<?php include 'includes/footer.inc.php'; ?>
