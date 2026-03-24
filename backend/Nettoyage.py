import pandas as pd
from Connexion import get_connection


# Charge les données pour les nettoyer
# Supprime la ligne parasite, les doublons, les prix/quantités nuls
# et crée un chiffre d'affaires
def charger_donnees():
    conn = get_connection()
    if conn is None:
        return None

    query = "SELECT * FROM donnees;"
    df = pd.read_sql(query, conn)
    conn.close()

    print(f" Données chargées : {df.shape[0]} lignes, {df.shape[1]} colonnes")
    return df


def nettoyer_donnees(df):

    df = df[df['InvoiceNo'] != 'InvoiceNo']
    print(f" Ligne parasite (en-tête) supprimée")

    nb_doublons = df.duplicated().sum()
    df = df.drop_duplicates()
    print(f"  Doublons supprimés : {nb_doublons}")

    df = df.dropna(subset=['CustomerID', 'Description'])
    print(f"  Lignes avec CustomerID ou Description vides supprimées")

    df['Quantity']   = pd.to_numeric(df['Quantity'],   errors='coerce')
    df['UnitPrice']  = pd.to_numeric(df['UnitPrice'],  errors='coerce')
    df['CustomerID'] = pd.to_numeric(df['CustomerID'], errors='coerce').astype('Int64')

    df = df[df['Quantity']  > 0]
    df = df[df['UnitPrice'] > 0]
    print(f"  Lignes avec Quantity ou UnitPrice <= 0 supprimées")

    df['Description'] = df['Description'].str.strip()
    df['Country']     = df['Country'].str.strip()

    df['ChiffreAffaires'] = df['Quantity'] * df['UnitPrice']

    print(f"   Lignes restantes : {len(df)}")
    print(f"   Colonnes : {list(df.columns)}")

    return df


if __name__ == "__main__":
    df_brut = charger_donnees()
    if df_brut is not None:
        df_propre = nettoyer_donnees(df_brut)
        print("\n Aperçu des données nettoyées :")
        print(df_propre.head(10))
        df_propre.to_csv("donnees_nettoyees.csv", index=False)
        print("\n Données sauvegardées dans 'donnees_nettoyees.csv'")
