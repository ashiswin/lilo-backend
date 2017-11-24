import requests
import json

class TaxiAPIConnector:
	def __init__(self):
		self.sessionId = ""
		self.session = requests.Session()
	
	def searchAddress(self, lat, lon):
		url = "https://interapps-addr.cdgtaxi.com.sg/dcp-address/rest/v1/searchAddressByLatLng"
		
		headers = {'Content-Type': 'application/x-www-form-urlencoded'}
		
		data = "countrycode=65&lat=" + str(lat) + "&lng=" + str(lon)
		
		r = self.session.post(url, data=data, headers=headers, verify=False)
		
		return json.loads(r.text)
	
	def getTravelCost(self, start, end):
		url = "https://interapps-dispatch.cdgtaxi.com.sg/dcp-dispatch/rest/v1/getFare"
		
		headers = {'Content-Type': 'application/x-www-form-urlencoded'}
		
		data = "countrycode=65&startingAddressreference=" + str(start['address']['addressRef']) + "&startingLat=" + str(start['address']['addressLat']) + "&startingLong=" + str(start['address']['addressLng']) + "&endingAddressreference=" + str(end['address']['addressRef']) + "&endingLat=" + str(end['address']['addressLat']) + "&endingLong=" + str(end['address']['addressLng']) + "&taxitypeId=0&advancebooking=false&advancebookingdate=&deviceType=ANDROID"
		
		r = self.session.post(url, data=data, headers=headers, verify=False)
		
		return json.loads(r.text)
