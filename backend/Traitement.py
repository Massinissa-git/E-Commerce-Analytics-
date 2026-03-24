import pandas as pd

def charger_donnees_nettoyees():
    try:
        df = pd.read_csv("donnees_nettoyees.csv")
        print(f"✅ Données chargées : {len(df)} lignes")
        return df
    except FileNotFoundError:
        print(" Fichier 'donnees_nettoyees.csv' introuvable.")
        print("   Lance d'abord Nettoyage.py !")
        return None


def analyser_donnees(df):
    """Effectue les analyses principales."""

    print("\n" + "="*50)
    print(" ANALYSE GÉNÉRALE")
    print("="*50)

    print(f"\n Chiffre d'affaires total : {df['ChiffreAffaires'].sum():,.2f} €")
    print(f" Nombre de commandes uniques : {df['InvoiceNo'].nunique()}")
    print(f" Nombre de clients uniques : {df['CustomerID'].nunique()}")
    print(f" Nombre de pays : {df['Country'].nunique()}")

    print("\n" + "="*50)
    print(" TOP 5 PRODUITS PAR CHIFFRE D'AFFAIRES")
    print("="*50)
    top_produits = (
        df.groupby('Description')['ChiffreAffaires']
        .sum()
        .sort_values(ascending=False)
        .head(5)
        .reset_index()
    )
    top_produits.columns = ['Produit', 'CA Total (€)']
    top_produits['CA Total (€)'] = top_produits['CA Total (€)'].round(2)
    print(top_produits.to_string(index=False))

    print("\n" + "="*50)
    print(" TOP 5 PAYS PAR CHIFFRE D'AFFAIRES")
    print("="*50)
    top_pays = (
        df.groupby('Country')['ChiffreAffaires']
        .sum()
        .sort_values(ascending=False)
        .head(5)
        .reset_index()
    )
    top_pays.columns = ['Pays', 'CA Total (€)']
    top_pays['CA Total (€)'] = top_pays['CA Total (€)'].round(2)
    print(top_pays.to_string(index=False))

    print("\n" + "="*50)
    print(" TOP 5 CLIENTS PAR CHIFFRE D'AFFAIRES")
    print("="*50)
    top_clients = (
        df.groupby('CustomerID')['ChiffreAffaires']
        .sum()
        .sort_values(ascending=False)
        .head(5)
        .reset_index()
    )
    top_clients.columns = ['CustomerID', 'CA Total (€)']
    top_clients['CA Total (€)'] = top_clients['CA Total (€)'].round(2)
    print(top_clients.to_string(index=False))

    print("\n" + "="*50)
    print(" TOP 5 PRODUITS LES PLUS VENDUS (quantité)")
    print("="*50)
    top_qte = (
        df.groupby('Description')['Quantity']
        .sum()
        .sort_values(ascending=False)
        .head(5)
        .reset_index()
    )
    top_qte.columns = ['Produit', 'Quantité totale']
    print(top_qte.to_string(index=False))

    return top_produits, top_pays, top_clients, top_qte


if __name__ == "__main__":
    df = charger_donnees_nettoyees()
    if df is not None:
        top_produits, top_pays, top_clients, top_qte = analyser_donnees(df)

        top_produits.to_csv("top_produits.csv", index=False)
        top_pays.to_csv("top_pays.csv",         index=False)
        top_clients.to_csv("top_clients.csv",   index=False)
        print("\n Résultats sauvegardés en CSV !")
