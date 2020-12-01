import psycopg2
from database_credentials import *

DATABASE = "database1"

def create_table():
    """
    function creating table in database
    """
    connection = psycopg2.connect(
        dbname=DATABASE, user=USER, password=PASSWORD, host=HOST, port=PORT)
    cursor = connection.cursor()
    cursor.execute("""
    CREATE TABLE IF NOT EXISTS store (item TEXT, quantity INTEGER, price REAL)
    """)
    connection.commit()
    connection.close()

def insert(item, quantity, price):
    connection = psycopg2.connect(DATABASE)
    cursor = connection.cursor()
    cursor.execute("INSERT INTO store VALUES (?,?,?)", (item, quantity, price))
    connection.commit()
    connection.close()

def view():
    connection = psycopg2.connect(DATABASE)
    cursor = connection.cursor()
    cursor.execute("SELECT * FROM store")
    rows = cursor.fetchall()
    connection.close()
    return rows
    
def delete(item):
    connection = psycopg2.connect(DATABASE)
    cursor = connection.cursor()
    cursor.execute("DELETE FROM store WHERE item=?", (item,))
    connection.commit()
    connection.close()
    
def update(item, quantity, price):
    connection = psycopg2.connect(DATABASE)
    cursor = connection.cursor()
    cursor.execute("UPDATE store SET quantity=?, price=? WHERE item=?", (quantity, price,item))
    connection.commit()
    connection.close()

create_table()
#insert("Coffee Cup", 10, 5)
#insert('Wine Glass', 8, 10.5)
#delete("Coffee Cup")
#update("Wine Glass", 10, 15)
#print(view())
