import os
import cv2
import json
import time
# from alpr import alpr
entryCameraServer = "rtsp://192.168.11.250"
exitCameraServer = "rtsp://192.168.11.251"
video = "alpr/samples/rwv-1.mp4"
cap = cv2.VideoCapture(video)
while True:
	ret, frame = cap.read();

	if not ret:
		print("Stream ended")
		break

	cv2.imshow("Hello", frame)
	print("Frame captured\n")
	if cv2.waitKey(1) & 0xFF == ord('q'):
		break
	# time.sleep(1)q
cap.release()
cv2.destroyAllWindows()