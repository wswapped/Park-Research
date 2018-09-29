import os
import cv2
import json
from alpr import alpr
import pdb
import cProfile as cp
import requests

# Communication to the server
class server:
	def __init__(self, serverAdress, apiURI):
		self.serverAdress = serverAdress
		self.apiURI = apiURI
		self.apiAddress = serverAdress+"/"+apiURI

	def enterCar(self, plateNumber, parking, camera):
		# Communicates with the database for car's entry
		response = requests.post(self.apiAddress, data = {'action':'carEntry', 'carPlate':plateNumber, 'parkId':parking, 'cameraId':camera})
		return response
	def exitCar(self, plateNumber, parking, camera):
		# Communicates with the database for car's exit
		response = requests.post(self.apiAddress, data = {'action':'carExit', 'carPlate':plateNumber, 'parkId':parking, 'cameraId':camera})

		print(response.json());

# serverInst = server('http://localhost', 'smartpark/api/index.php')
# data = serverInst.enterCar('RAD324B', 1, 1)