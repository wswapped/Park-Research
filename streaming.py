import os
import cv2
import json
import time
from alpr import alpr
entryCameraServer = "rtsp://192.168.11.250"
exitCameraServer = "rtsp://192.168.11.251"

cap = cv2.VideoCapture(exitCameraServer)
while True:
	ret, frame = cap.read();
	cv2.imshow("Hello", frame)

	if cv2.waitKey(1) & 0xFF == ord('q'):
		break
cap.release()
cv2.destroyAllWindows()