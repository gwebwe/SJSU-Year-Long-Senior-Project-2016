import socket
import sys
import mysql.connector 
from mysql.connector import errorcode
import smtplib
from email.mime.multipart import MIMEMultipart
from email.mime.text import MIMEText
import time

# Create a TCP/IP socket
sock = socket.socket(socket.AF_INET, socket.SOCK_STREAM)

# Bind the socket to the address given on the command line

server_address = ('', 9805)
print >>sys.stderr, 'starting up on %s port %s' % server_address
sock.bind(server_address)
sock.listen(1)
while True:
	print >>sys.stderr, 'waiting for a connection'
	connection, client_address = sock.accept()
        print >>sys.stderr, 'client connected:', client_address
        recieve = connection.recv(16)
	a=open
	try:
    		cnx=mysql.connector.connect(user= 'root',password= '******',host= 'localhost',database= 'iot')
    	except mysql.connector.Error as e:
    		if e.errno == errorcode.ER_ACCESS_DENIED_ERROR:
                	print ("username/password error")
        	else:
        		print(e)
    	cur= cnx.cursor()
    	sql= "SELECT * from options where id= \"door\""
    	cur.execute(sql)
    	results= cur.fetchall()
    	for row in results:
		data= row[1]	
    	cur.close()
    	cnx.close()
        print data
	print recieve
	now = time.strftime("%c")
	if recieve=='open' and data == 'on':
		username = "iottoimprovemoderndaylife"
		fromaddr = "iottoimprovemoderndaylife@gmail.com"
		password = "011235813213455"
		toaddr = "himynameisphi@gmail.com"
		msg = MIMEMultipart()
		msg['From'] = fromaddr
		msg['To'] = toaddr
		msg['Subject'] = "Door Alert" 
		body = "Door opened at " + now
		msg.attach(MIMEText(body, 'plain')) 
		server = smtplib.SMTP('smtp.gmail.com', 587)
		server.starttls()
		server.login(fromaddr, password)
		text = msg.as_string()
		server.sendmail(username, toaddr, text)
		print 'mail sent'
		server.quit()
        try:
        	cnx=mysql.connector.connect(user= 'root',password= '*****',host= 'localhost',database= 'iot')
        except mysql.connector.Error as e:
        	if e.errno == errorcode.ER_ACCESS_DENIED_ERROR:
                	print ("username/password error")
            	else:
                	print(e)
        cur= cnx.cursor()
        cur.execute("UPDATE cs SET status = %s WHERE id= %s",(recieve,1))
        cnx.commit()
	cur.execute("UPDATE cs SET timestamp = %s WHERE id= %s",(now,1))
        cnx.commit()
	cur.close()
        cnx.close()
	
		
        connection.close()