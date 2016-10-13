# SJSU-Year-Long-Senior-Project-2016
Created a home system that allowed users to monitor and control their home devices through the use of a cloud server (AWS), website, and local controller.


Website:
LAMP stack was used to launch the website. Linux (Ubuntu), Apache, MySQL, PHP, and AWS (EC2). Allowed a user to turn on or off three different home devices, turn on or off door notification system that would send an email to the user if doors were opened if door notification was on, and allowed the viewing of past and present status of home devices.


Local Controller:
A Raspberry Pi 2 was used for the local controller and was connected with different sensors to control and monitor different home appliances. A photocell was used to monitor the light intensity in the environment, a controller was used to send radio waves to sensors to turn on or off devices, and a RF base station was used to receive data from the door sensor that determined if the door was open or not. All information on the sensors were viewable on the website.
