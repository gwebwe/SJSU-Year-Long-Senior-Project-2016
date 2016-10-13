import mysql.connector 
from mysql.connector import errorcode
try:
        cnx=mysql.connector.connect(user= 'root',password= 'sheridan1',host= 'localhost',database= 'iot')
except mysql.connector.Error as e:
	if e.errno == errorcode.ER_ACCESS_DENIED_ERROR:
		print ("username/password error")
	else:
		print(e)
cur= cnx.cursor()
sql= "SELECT * from relay where id= 1"
cur.execute(sql)
results= cur.fetchall()
for row in results:
	data= row[1]	
cur.close()
cnx.close()
print data