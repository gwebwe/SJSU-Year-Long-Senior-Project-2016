import SocketServer

class MyTCPHandler(SocketServer.BaseRequestHandler):
    def handle(self):
        self.data = self.request.recv(1024).strip()
        print self.client_address
        print self.data
        self.request.send(self.data.upper())

if __name__ == "__main__":
    HOST, PORT = "", 9800
    server = SocketServer.TCPServer((HOST, PORT), MyTCPHandler)
	

    server.serve_forever()