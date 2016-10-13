import socket
import sys
import mysql.connector 
from mysql.connector import errorcode
import smtplib
import time
# Create a TCP/IP socket
sock = socket.socket(socket.AF_INET, socket.SOCK_STREAM)

# Bind the socket to the address given on the command line

server_address = ('', 9800)
print >>sys.stderr, 'starting up on %s port %s' % server_address
sock.bind(server_address)
sock.listen(1)

while True:
    print >>sys.stderr, 'waiting for a connection'
    connection, client_address = sock.accept()
    try:
        print >>sys.stderr, 'client connected:', client_address
        while True:
            data = connection.recv(16)
            print data
            #if data:
               # connection.sendall(data)
            #else:
            break
    finally:
        try:
        	cnx=mysql.connector.connect(user= 'root',password= 'sheridan1',host= 'localhost',database= 'iot')
        except mysql.connector.Error as e:
        	if e.errno == errorcode.ER_ACCESS_DENIED_ERROR:
                	print ("username/password error")
            	else:
                	print(e)
        now = time.strftime("%c")
        cur= cnx.cursor()
        cur.execute("UPDATE photocell SET status = %s WHERE id= %s",(data,1))
        cnx.commit()
	cur.execute("UPDATE photocell SET timestamp = %s WHERE id= %s",(now,1))
        cnx.commit()
	cur.close()
        cnx.close()
        connection.close()
