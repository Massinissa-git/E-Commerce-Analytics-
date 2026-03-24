"""
FICHIER 4 - Visualisation.py
Rôle : Créer des graphiques avancés avec numpy (tendance, scatter, etc.)
Ces graphiques sont exportés en PNG pour le site web
"""

import pandas as pd
import numpy as np
import matplotlib.pyplot as plt
import matplotlib.ticker as mticker
import warnings

warnings.filterwarnings('ignore')
plt.rcParams.update({
    'figure.facecolor': '#f9f9f9',
    'axes.facecolor':   '#ffffff',
    'font.family':      'DejaVu Sans',
    'axes.spines.top':  False,
    'axes.spines.right':False,
})
PALETTE = ['#3B8BD4', '#1D9E75', '#BA7517', '#D85A30', '#8172B2',
           '#C44E52', '#64B5CD', '#CCB974', '#55A868', '#E85D24']


def charger_donnees():
    try:
        df = pd.read_csv("donnees_nettoyees.csv")
        print(f" {len(df)} lignes chargées")
        return df
    except FileNotFoundError:
        print(" Lance d'abord Nettoyage.py !")
        return None


def graphique_scatter_tendance(df):
    """
    Nuage de points UnitPrice vs Quantity.
    Numpy calcule la courbe de régression polynomiale
    pour visualiser la corrélation.
    """
    df_filtre = df[(df['UnitPrice'] <= 20) & (df['Quantity'] <= 100)]

    x = df_filtre['UnitPrice'].values
    y = df_filtre['Quantity'].values

    coeffs = np.polyfit(x, y, deg=2)
    poly   = np.poly1d(coeffs)
    x_line = np.linspace(x.min(), x.max(), 200)
    y_line = poly(x_line)

    correlation = np.corrcoef(x, y)[0, 1]

    fig, ax = plt.subplots(figsize=(9, 6))
    ax.scatter(x, y, alpha=0.35, s=20, color=PALETTE[0], label='Produits')
    ax.plot(x_line, y_line, color=PALETTE[3], linewidth=2.5,
            label=f'Tendance polynomiale (r = {correlation:.2f})')

    ax.set_title("Prix Unitaire vs Quantité commandée", fontsize=14, fontweight='bold', pad=12)
    ax.set_xlabel("Prix Unitaire (£)", fontsize=11)
    ax.set_ylabel("Quantité", fontsize=11)
    ax.legend(fontsize=10)
    ax.text(0.98, 0.95, f"Corrélation : {correlation:.2f}",
            transform=ax.transAxes, ha='right', va='top', fontsize=10, color='gray',
            bbox=dict(boxstyle='round,pad=0.3', fc='white', ec='lightgray'))

    plt.tight_layout()
    plt.savefig("scatter_prix_quantite.png", dpi=150, bbox_inches='tight')
    plt.show()
    print(" scatter_prix_quantite.png")


def graphique_scatter_clients(df):
    """
    CA total vs nombre de commandes par client.
    Numpy identifie les clients VIP (top 25%).
    """
    stats = df.groupby('CustomerID').agg(
        CA=('ChiffreAffaires', 'sum'),
        nb_commandes=('InvoiceNo', 'nunique')
    ).reset_index()

    ca_arr  = stats['CA'].values
    cmd_arr = stats['nb_commandes'].values

    seuil_ca  = np.percentile(ca_arr, 75)
    seuil_cmd = np.percentile(cmd_arr, 75)
    vip_mask  = (ca_arr > seuil_ca) & (cmd_arr > seuil_cmd)

    fig, ax = plt.subplots(figsize=(9, 6))
    ax.scatter(cmd_arr[~vip_mask], ca_arr[~vip_mask],
               alpha=0.5, s=30, color=PALETTE[0], label='Clients standard')
    ax.scatter(cmd_arr[vip_mask], ca_arr[vip_mask],
               alpha=0.9, s=60, color=PALETTE[3], label='Clients VIP (top 25%)', zorder=5)

    coeffs = np.polyfit(cmd_arr, ca_arr, 1)
    x_line = np.linspace(cmd_arr.min(), cmd_arr.max(), 100)
    ax.plot(x_line, np.poly1d(coeffs)(x_line),
            color='gray', linewidth=1.5, linestyle='--', label='Tendance', alpha=0.7)

    ax.set_title("Clients — CA total vs Nombre de commandes", fontsize=14, fontweight='bold', pad=12)
    ax.set_xlabel("Nombre de commandes", fontsize=11)
    ax.set_ylabel("CA total (£)", fontsize=11)
    ax.yaxis.set_major_formatter(mticker.FuncFormatter(lambda v, _: f"£{v:,.0f}"))
    ax.legend(fontsize=10)

    plt.tight_layout()
    plt.savefig("scatter_clients_vip.png", dpi=150, bbox_inches='tight')
    plt.show()
    print(f" scatter_clients_vip.png  ({vip_mask.sum()} clients VIP détectés)")


def graphique_top_pays(df):
    top = (df.groupby('Country')['ChiffreAffaires']
             .sum().sort_values(ascending=False).head(10))

    fig, ax = plt.subplots(figsize=(10, 5))
    bars = ax.bar(top.index, top.values,
                  color=PALETTE[:len(top)], edgecolor='white', linewidth=0.5)

    ax.set_title("Top 10 Pays par Chiffre d'Affaires", fontsize=14, fontweight='bold', pad=12)
    ax.set_ylabel("CA (£)", fontsize=11)
    ax.set_xticklabels(top.index, rotation=30, ha='right')
    ax.yaxis.set_major_formatter(mticker.FuncFormatter(lambda v, _: f"£{v:,.0f}"))

    for bar in bars:
        ax.text(bar.get_x() + bar.get_width()/2, bar.get_height() + 200,
                f"£{bar.get_height():,.0f}", ha='center', va='bottom', fontsize=8)

    plt.tight_layout()
    plt.savefig("graphique_top_pays.png", dpi=150, bbox_inches='tight')
    plt.show()
    print(" graphique_top_pays.png")


def graphique_donut_pays(df):
    ca_pays = df.groupby('Country')['ChiffreAffaires'].sum().sort_values(ascending=False)
    top5    = ca_pays.head(5)
    autres  = ca_pays.iloc[5:].sum()
    data    = pd.concat([top5, pd.Series({'Autres': autres})])

    total  = np.sum(data.values)
    pcts   = np.round((data.values / total) * 100, 1)
    labels = [f"{l}\n{p}%" for l, p in zip(data.index, pcts)]

    fig, ax = plt.subplots(figsize=(8, 6))
    ax.pie(data.values, labels=labels,
           colors=PALETTE[:6],
           startangle=140,
           wedgeprops=dict(width=0.55))

    ax.set_title("Répartition du CA par Pays", fontsize=14, fontweight='bold', pad=15)
    plt.tight_layout()
    plt.savefig("graphique_donut_pays.png", dpi=150, bbox_inches='tight')
    plt.show()
    print(" graphique_donut_pays.png")


def graphique_top_produits(df):
    top = (df.groupby('Description')['ChiffreAffaires']
             .sum().sort_values(ascending=False).head(10))

    labels = [l[:35] + '…' if len(l) > 35 else l for l in top.index[::-1]]

    fig, ax = plt.subplots(figsize=(11, 6))
    bars = ax.barh(labels, top.values[::-1],
                   color=PALETTE[1], edgecolor='white', linewidth=0.5)

    ax.set_title("Top 10 Produits par Chiffre d'Affaires", fontsize=14, fontweight='bold', pad=12)
    ax.set_xlabel("CA (£)", fontsize=11)
    ax.xaxis.set_major_formatter(mticker.FuncFormatter(lambda v, _: f"£{v:,.0f}"))

    for bar in bars:
        ax.text(bar.get_width() + 50, bar.get_y() + bar.get_height()/2,
                f"£{bar.get_width():,.0f}", va='center', fontsize=8)

    plt.tight_layout()
    plt.savefig("graphique_top_produits.png", dpi=150, bbox_inches='tight')
    plt.show()
    print(" graphique_top_produits.png")


def graphique_histogramme_prix(df):
    prix = df[df['UnitPrice'] <= 15]['UnitPrice'].values

    x_kde = np.linspace(prix.min(), prix.max(), 300)
    h     = 1.06 * np.std(prix) * len(prix)**(-1/5)
    kde   = np.mean(np.exp(-0.5 * ((x_kde[:, None] - prix) / h)**2), axis=1) / (h * np.sqrt(2 * np.pi))

    fig, ax1 = plt.subplots(figsize=(9, 5))
    ax2 = ax1.twinx()

    ax1.hist(prix, bins=40, color=PALETTE[0], alpha=0.6, edgecolor='white', label='Fréquence')
    ax2.plot(x_kde, kde, color=PALETTE[3], linewidth=2.5, label='Densité (KDE numpy)')

    ax1.set_title("Distribution des Prix Unitaires (≤ £15)", fontsize=14, fontweight='bold', pad=12)
    ax1.set_xlabel("Prix Unitaire (£)", fontsize=11)
    ax1.set_ylabel("Nombre de produits", fontsize=11)
    ax2.set_ylabel("Densité", fontsize=11, color=PALETTE[3])
    ax2.tick_params(axis='y', colors=PALETTE[3])

    stats_txt = (f"Moyenne : £{np.mean(prix):.2f}\n"
                 f"Médiane : £{np.median(prix):.2f}\n"
                 f"Écart-type : £{np.std(prix):.2f}")
    ax1.text(0.97, 0.95, stats_txt, transform=ax1.transAxes,
             ha='right', va='top', fontsize=9, color='gray',
             bbox=dict(boxstyle='round,pad=0.4', fc='white', ec='lightgray'))

    lines1, labels1 = ax1.get_legend_handles_labels()
    lines2, labels2 = ax2.get_legend_handles_labels()
    ax1.legend(lines1 + lines2, labels1 + labels2, fontsize=10, loc='upper left')

    plt.tight_layout()
    plt.savefig("graphique_distribution_prix.png", dpi=150, bbox_inches='tight')
    plt.show()
    print(" graphique_distribution_prix.png")


if __name__ == "__main__":
    df = charger_donnees()
    if df is not None:
        print("\n Génération des graphiques...\n")
        graphique_scatter_tendance(df)
        graphique_scatter_clients(df)
        graphique_top_pays(df)
        graphique_donut_pays(df)
        graphique_top_produits(df)
        graphique_histogramme_prix(df)
        print("\n Tous les graphiques générés !")
        print(" 6 fichiers PNG prêts pour le site web.")
