import RPi.GPIO as GPIO, time
GPIO.setmode(GPIO.BCM)


# Main program loop
while True:
    measurement = 0
    GPIO.setup(17, GPIO.OUT)
    GPIO.output(17, GPIO.LOW)
    GPIO.setup(4,GPIO.OUT)
    time.sleep(0.1)
    GPIO.setup(17, GPIO.IN)
    while (GPIO.input(17) == GPIO.LOW):
        measurement += 1
    print measurement
    if measurement > 1000:
        GPIO.output(4,True)
    else:
        GPIO.output(4,False)


  