import mysql.connector
from mysql.connector import Error

def get_connection():
    """Retourne une connexion à la base de données."""
    try:
        conn = mysql.connector.connect(
            host="localhost",
            user="root",
            password="",
            database="e-commerce data"
        )
        if conn.is_connected():
            print(" Connexion réussie à la base de données !")
            return conn
    except Error as e:
        print(f" Erreur de connexion : {e}")
        return None


if __name__ == "__main__":
    conn = get_connection()
    if conn:
        cursor = conn.cursor()
        cursor.execute("SELECT COUNT(*) FROM donnees;")
        total = cursor.fetchone()[0]
        print(f"Nombre total de lignes dans la table : {total}")
