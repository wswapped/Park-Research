import os
import cv2
import json
from alpr import alpr
import pdb
import cProfile as cp
import imutils
from imutils.video import FPS
from threading import Thread
from queue import Queue
import time
from server import server
from FileVideoStream import FileVideoStream

# Testing system using video
video = "alpr/samples/Ok_Large.mp4"

# VideoReading thread
videoFeed = FileVideoStream(video, 10)
videoFeed.start()
time.sleep(1.0)
# print(videoFeed)

# start the FPS timer
fps = FPS().start()

# cap = cv2.FileVideoStream(video)
n = 0
foundPlates = []
while videoFeed.more():
	print("Looping")
	n = n+1
	frame = videoFeed.read()

	if frame is not None:
		print("Frame "+str(n))
		#Saving frame as current
		frameFile = os.path.sep.join(('alpr', 'samples', "video-current.jpg"))
		frameData = frame

		# resize and rotate
		frameData = cv2.resize(frameData, (640, 480))
		height, width = frameData.shape[:2];

		cv2.imwrite(frameFile, frameData)

		plateText = alpr.findPlates(frameFile)

		# Parsing the plate text
		plates = json.loads(plateText)		
		returnPlates = []
		cv2.imshow("Image in process", frameData)

		# Looping through all plates
		for plateFound in plates['results']:
			returnPlates.append({'plate':plateFound['plate'], 'confidence':plateFound['confidence'], 'region':plateFound['coordinates']})
		print("Candidates: "+str(returnPlates)+"\n")

		if returnPlates is not None and returnPlates != []:
			print("here "+str(n))
			foundPlates.append(alpr.get_high_confidence(returnPlates))



		pKey = cv2.waitKey(1)
		if pKey & 0xFF == ord('x'):
			break
		elif pKey & 0xFF == ord('p'):
			print("snapshot")
			# Capture snapshot
			snapFile = os.path.sep.join(('alpr', 'samples', "snapshot.jpg"))
			cv2.imwrite(snapFile, frameData)


		
	else:
		break
		print("No frame found")

print("Found plates:\n")
print(foundPlates)

print("\n\nBest match to screen")
foundPlate = alpr.get_high_confidence(foundPlates)
serverInst = server('http://localhost', 'smartpark/api/index.php')
data = serverInst.enterCar(foundPlate['plate'], 1, 1)

# stop the timer and display FPS information
fps.stop()
print("[INFO] elasped time: {:.2f}".format(fps.elapsed()))
# print("[INFO] approx. FPS: {:.2f}".format(fps.fps()))

# print(alpr.get_high_confidence(plateFound))
cv2.destroyAllWindows()
videoFeed.stop()