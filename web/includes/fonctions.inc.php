<?php

function getStats() {
    $conn = getDBConnection();
    $stats = [];

    $result = $conn->query("SELECT COUNT(*) AS total FROM donnees");
    $stats['total_lignes'] = $result ? (int)$result->fetch_assoc()['total'] : 0;

    $result = $conn->query("SELECT SUM(Quantity * UnitPrice) AS ca_total FROM donnees WHERE Quantity > 0 AND UnitPrice > 0");
    $stats['ca_total'] = $result ? (float)($result->fetch_assoc()['ca_total'] ?? 0) : 0;

    $result = $conn->query("SELECT COUNT(DISTINCT CustomerID) AS nb_clients FROM donnees WHERE CustomerID IS NOT NULL AND CustomerID != ''");
    $stats['nb_clients'] = $result ? (int)$result->fetch_assoc()['nb_clients'] : 0;

    $result = $conn->query("SELECT COUNT(DISTINCT StockCode) AS nb_produits FROM donnees");
    $stats['nb_produits'] = $result ? (int)$result->fetch_assoc()['nb_produits'] : 0;

    $conn->close();
    return $stats;
}

function getTopProducts($limit = 10) {
    $conn = getDBConnection();
    $query = "SELECT Description, SUM(Quantity) AS total_qte, SUM(Quantity * UnitPrice) AS ca
              FROM donnees
              WHERE Description IS NOT NULL AND Description != '' AND Quantity > 0 AND UnitPrice > 0
              GROUP BY Description
              ORDER BY ca DESC
              LIMIT ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $limit);
    $stmt->execute();
    $result = $stmt->get_result();
    $products = [];
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
    $stmt->close();
    $conn->close();
    return $products;
}

function getTopCountries($limit = 10) {
    $conn = getDBConnection();
    $query = "SELECT Country, SUM(Quantity * UnitPrice) AS ca, COUNT(DISTINCT InvoiceNo) AS nb_commandes
              FROM donnees
              WHERE Country IS NOT NULL AND Quantity > 0 AND UnitPrice > 0
              GROUP BY Country
              ORDER BY ca DESC
              LIMIT ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $limit);
    $stmt->execute();
    $result = $stmt->get_result();
    $countries = [];
    while ($row = $result->fetch_assoc()) {
        $countries[] = $row;
    }
    $stmt->close();
    $conn->close();
    return $countries;
}

function getEvolutionCA() {
    $conn = getDBConnection();
    $query = "SELECT DATE(InvoiceDate) AS date, SUM(Quantity * UnitPrice) AS ca_journalier
              FROM donnees
              WHERE Quantity > 0 AND UnitPrice > 0
              GROUP BY DATE(InvoiceDate)
              ORDER BY date DESC
              LIMIT 30";
    $result = $conn->query($query);
    $dates = [];
    $ca = [];
    while ($row = $result->fetch_assoc()) {
        array_unshift($dates, $row['date']);
        array_unshift($ca, round($row['ca_journalier'], 2));
    }
    $conn->close();
    return ['dates' => $dates, 'ca' => $ca];
}
?>
