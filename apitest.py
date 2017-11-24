from APIConnector import TaxiAPIConnector
from GoogleMaps import GoogleMaps
import urllib2
import json

a = TaxiAPIConnector()
g = GoogleMaps()

response = urllib2.urlopen('http://devostrum.no-ip.info/lilo-backend/GetDestinations.php')
result = json.loads(response.read())

destinations = []

for d in result['destinations']:
	destinations.append((d['id'], a.searchAddress(d['lat'], d['lon'])))

matrix =  [ [0]*len(destinations) for _ in xrange(len(destinations)) ]

for i in range(len(destinations)):
	for j in range(len(destinations)):
		if i == j:
			matrix[i][j] = (0, 0, 0)
			continue
		distance = g.getDistanceData(str(destinations[i][1]['address']['addressLat']) + "," + str(destinations[i][1]['address']['addressLng']), str(destinations[j][1]['address']['addressLat']) + "," + str(destinations[j][1]['address']['addressLng']))['rows'][0]['elements'][0]
		matrix[i][j] = (a.getTravelCost(destinations[i][1], destinations[j][1])['flatFare'], distance['distance']['value'], distance['duration']['value'])

f = open('taxi.txt', 'w')

for i in range(len(destinations)):
	for j in range(len(destinations)):
		f.write(str(matrix[i][j]) + "\t")
	f.write('\n')
