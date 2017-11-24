import requests
import json

class GoogleMaps:
	API_KEY = "AIzaSyAWAZVQWE9OpMFJkhtKXUTL01-bB2CG2FM"
	
	def getDistanceData(self, origin, destination):
		url = "https://maps.googleapis.com/maps/api/distancematrix/json?origins=" + origin + "&destinations=" + destination + "&key=" + self.API_KEY
		
		r = requests.get(url)
		
		return json.loads(r.text)
