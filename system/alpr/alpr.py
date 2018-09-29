import os
import subprocess
import json

def findPlates(imagePath):
	#interacts with openalpr command line utility

	if(os.path.isfile(imagePath)):
		p1 = subprocess.Popen(["alpr/alpr", imagePath, '-c rw', '-j'], cwd= os.getcwd(), stdout=subprocess.PIPE)
		# Run the command
		output = p1.communicate()[0]
		return output;
	else:
		print("Error: image file can not be found")
		return False


def get_high_confidence(a_list):
	final = None
	lis = []
	lis = list(lis)
	for i in a_list:
	    i = dict(i)
	    lis.append(i['confidence'])
	
	lis= sorted(lis, reverse=True)
	
	for i in a_list:
	    if i['confidence'] == lis[0]:
	        final = i
	        break;
	    
	return final