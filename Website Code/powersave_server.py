import socket
import sys
import mysql.connector 
from mysql.connector import errorcode
import smtplib
import time
# Create a TCP/IP socket
sock = socket.socket(socket.AF_INET, socket.SOCK_STREAM)

# Bind the socket to the address given on the command line

server_address = ('', 9804)
print >>sys.stderr, 'starting up on %s port %s' % server_address
sock.bind(server_address)
sock.listen(1)

while True:
	try:
    		cnx=mysql.connector.connect(user= 'root',password= 'sheridan1',host= 'localhost',database= 'iot')
    	except mysql.connector.Error as e:
    		if e.errno == errorcode.ER_ACCESS_DENIED_ERROR:
                	print ("username/password error")
        	else:
        		print(e)
    	cur= cnx.cursor()
    	sql= "SELECT * from options where id= \"light\""
    	cur.execute(sql)
    	results= cur.fetchall()
    	for row in results:
		data= row[1]	
    	cur.close()
    	cnx.close()
	print >>sys.stderr, 'waiting for a connection'
    	connection, client_address = sock.accept()
        print >>sys.stderr, 'client connected:', client_address
        message = data
    	#print >>sys.stderr, 'sending "%s"' % message
    	connection.send(message)
	reply = connection.recv(16)
	if reply == "off":
		print  "receieved %s " %reply
   		try:
        		cnx=mysql.connector.connect(user= 'root',password= 'sheridan1',host= 'localhost',database= 'iot')
        	except mysql.connector.Error as e:
        		if e.errno == errorcode.ER_ACCESS_DENIED_ERROR:
                		print ("username/password error")
            		else:
                		print(e)
        	now = time.strftime('%Y-%m-%d %H:%M:%S')
        	cur= cnx.cursor()
        	cur.execute("UPDATE relay SET status = %s WHERE id= %s",(reply,1))
        	cnx.commit()
		cur.execute("UPDATE relay SET timestamp = %s WHERE id= %s",(now,1))
        	cnx.commit()
		cur.close()
        	cnx.close()
	connection.close()
