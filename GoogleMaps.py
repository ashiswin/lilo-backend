import requests
import json

class GoogleMaps:
	API_KEY = " AIzaSyCfos9ggFaKrNSlqzFcK0j5D_hqIwu1Isw "
	
	def getDistanceData(self, origin, destination):
		url = "https://maps.googleapis.com/maps/api/distancematrix/json?origins=" + origin + "&destinations=" + destination + "&key=" + self.API_KEY
		
		r = requests.get(url)
		
		return json.loads(r.text)
	
	def getDistanceDataBus(self, origin, destination):
		url = "https://maps.googleapis.com/maps/api/distancematrix/json?mode=transit&origins=" + origin + "&destinations=" + destination + "&key=" + self.API_KEY
		
		r = requests.get(url)
		
		return json.loads(r.text)
	
	def getDistanceDataWalk(self, origin, destination):
		url = "https://maps.googleapis.com/maps/api/distancematrix/json?mode=walking&origins=" + origin + "&destinations=" + destination + "&key=" + self.API_KEY
		
		r = requests.get(url)
		
		return json.loads(r.text)
