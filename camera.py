import os
import cv2
import json
import time
from alpr import alpr
entryCameraServer = "rtsp://192.168.11.250"
exitCameraServer = "rtsp://192.168.11.251"
p = os.path.sep.join(('alpr', 'samples', "rw-1.jpg"))

cap = cv2.VideoCapture(exitCameraServer)
while True:
	ret, frame = cap.read();
	cv2.imshow("Hello", frame)

	#saving currentimage for plate extraction
	p = os.path.sep.join(('alpr', 'samples', "current.jpg"))
	cv2.imwrite(p, frame)

	plateText = alpr.findPlates(p)
	# Parsing the plate text
	plates = json.loads(plateText)

	returnPlates = []

	# Looping through all plates
	for plateFound in plates['results']:
		returnPlates.append({'plate':plateFound['plate'], 'confidence':plateFound['confidence'], 'region':plateFound['coordinates']})
	print(alpr.get_high_confidence(returnPlates))

	if cv2.waitKey(1) & 0xFF == ord('q'):
		break

	time.sleep(.5)
cap.release()
cv2.destroyAllWindows()