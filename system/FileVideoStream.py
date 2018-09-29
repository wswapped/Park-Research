import os
import cv2
from queue import Queue
from imutils.video import FPS
from threading import Thread
class FileVideoStream:
	def __init__(self, path, queueSize=128):
		# initialize the file video stream along with the boolean used to indicate if the thread should be stopped or not
		self.stream = cv2.VideoCapture(path)
		self.stopped = False
		self.path = path

		# initialize the queue used to store frames read from
		# the video file
		self.Q = Queue(maxsize=queueSize)

	def start(self):
		print("starting")
		# start a thread to read frames from the file video stream
		t = Thread(target=self.update, args=())
		# t.daemon = True
		t.start()
		return self

	def update(self):
		# keep looping infinitely
		while True:
			# if the thread indicator variable is set, stop the
			# thread
			if self.stopped:
				return
			# otherwise, ensure the queue has room in it
			if not self.Q.full():
				# read the next frame from the file
				(grabbed, frame) = self.stream.read()
 
				# if the `grabbed` boolean is `False`, then we have reached the end of the video file
				if not grabbed:
					print("Stream finished")
					self.stop()
					return
					
				# add the frame to the queue
				self.Q.put(frame)
			else:
				#just remove one frame and it wont be processed
				print('Full queue, droped from the beginning')
				self.Q.get()

	def read(self):
		# return next frame in the queue
		return self.Q.get()

	def more(self):
		# return True if there are still frames in the queue
		return self.Q.qsize() > 0

	def stop(self):
		# indicate that the thread should be stopped
		self.stopped = True

# # Testing system using video
# video = "alpr/samples/Ok_Large.mp4"

# # VideoReading thread
# videoFeed = FileVideoStream(video)
# videoFeed.start()