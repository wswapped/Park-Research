import os
import cv2
import json
from alpr import alpr
entryCameraServer = "rtsp://192.168.11.250"
exitCameraServer = "rtsp://192.168.11.251"
p = os.path.sep.join(('alpr', 'samples', "rw-1.jpg"))

plateText = alpr.findPlates(p)
# Parsing the plate text
plates = json.loads(plateText)

returnPlates = []

# Looping through all plates
for plateFound in plates['results']:
	returnPlates.append({'plate':plateFound['plate'], 'confidence':plateFound['confidence'], 'region':plateFound['coordinates']})
print(alpr.get_high_confidence(returnPlates))