import os
import _thread
import threading
import cv2
import pdb
import cProfile as cp
import camera
import plate
import queue
import time

entryCameraServer = "rtsp://192.168.11.250"
exitCameraServer = "rtsp://192.168.11.251"
video = "alpr/samples/rwv-1.mp4"
frameQueue = queue.Queue(maxsize=100)
frame = None
globalFrame = None

cameraThread = threading.Thread(target=camera.open, args=(entryCameraServer,), kwargs={'movement':'entry', 'queue':frameQueue})
cameraThread.start()

detectionThread = threading.Thread(target=plate.recognize, args=(), kwargs={'queue':frameQueue, 'frame':frame})
detectionThread.start()

frameQueue.join()