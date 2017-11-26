from GoogleMaps import GoogleMaps
import urllib2
import json

g = GoogleMaps()

response = urllib2.urlopen('http://devostrum.no-ip.info/lilo-backend/GetDestinations.php')
result = json.loads(response.read())

destinations = result['destinations']

matrix = [ [0]*len(destinations) for _ in xrange(len(destinations)) ]

for i in range(len(destinations)):
	for j in range(len(destinations)):
		if i == j:
			matrix[i][j] = (0, 0, 0)
			continue
		distance = g.getDistanceDataWalk(str(destinations[i]['lat']) + "," + str(destinations[i]['lon']), str(destinations[j]['lat']) + "," + str(destinations[j]['lon']))['rows'][0]['elements'][0]
		
		matrix[i][j] = (distance['distance']['value'], distance['duration']['value'])

f = open('walk.txt', 'w')

for i in range(len(destinations)):
	for j in range(len(destinations)):
		f.write(str(matrix[i][j]) + "\t")
	f.write('\n')
