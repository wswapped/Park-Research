import os
import cv2
import json
from alpr import alpr
import pdb
import cProfile as cp
from server import server

def recognize(queue=None, frame=None):
	# Start the profiler
	pr = cp.Profile()

	n = 0;
	while True:
		pr.enable()
		n = n+1
		# //saving frame as current
		frameFile = os.path.sep.join(('alpr', 'samples', "current.jpg"))
		queueData = queue.get()
		frameData = queueData['frame']
		movementType = queueData['movement']
		
		if len(frameData)>0:
			cv2.imwrite(frameFile, frameData)
			# queSize = queue.qsize();
			# pr.disable()
			# pr.print_stats(sort='time')
			# continue

			plateText = alpr.findPlates(frameFile)
			# Parsing the plate text
			plates = json.loads(plateText)

			returnPlates = []

			cv2.imshow("Image in process", frameData)

			pKey = cv2.waitKey(1)
			if pKey & 0xFF == ord('x'):
				break
			elif pKey & 0xFF == ord('p'):
				print("snapshot")
				# Capture snapshot
				snapFile = os.path.sep.join(('alpr', 'samples', "snapshot.jpg"))
				cv2.imwrite(snapFile, frameData)


			# Looping through all plates
			for plateFound in plates['results']:
				returnPlates.append({'plate':plateFound['plate'], 'confidence':plateFound['confidence'], 'region':plateFound['coordinates']})
			print("Candidates: "+str(returnPlates)+"\n")
			detectedPlate = alpr.get_high_confidence(returnPlates)
			print('True Plate: '+str(detectedPlate))

			if detectedPlate:
				print("movement"+movementType)
				serverInst = server('http://localhost', 'smartpark/api/index.php')

				if(movementType == 'entry'):
					data = serverInst.enterCar(detectedPlate['plate'], 1, 1)
				elif(movementType == 'exit'):
					data = serverInst.exitCar(detectedPlate['plate'], 1, 1)
				print(data)

		else:
			print("No frame found")
	cv2.destroyAllWindows()