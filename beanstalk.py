import beanstalkc
import json
beanstalk = beanstalkc.Connection(host='192.168.11.201', port=11300) #check this port in beanstalk proccess
beanstalk.watch('alprd')

while 1:
  job = beanstalk.reserve()
  payLoad = json.loads(job.body)
  print payLoad['results'][0]['plate']#first plate found