import os
import cv2
import json
import time
from alpr import alpr

def open(cameraServer, movement, queue = None):
	cap = cv2.VideoCapture(cameraServer)	
	while cap.isOpened():
		ret, frame = cap.read();

		# Checking provided stream ending
		if not ret:
			print("Stream finished")
			break

		frame = cv2.resize(frame, (640, 480))
		queue.queue.clear()
		queue.put({'frame': frame, 'movement':movement})
		cv2.imshow("Hello", frame)

		if cv2.waitKey(1) & 0xFF == ord('q'):
			break

	cap.release()
	cv2.destroyAllWindows()