from GoogleMaps import GoogleMaps
import urllib2
import json

g = GoogleMaps()

response = urllib2.urlopen('http://devostrum.no-ip.info/lilo-backend/GetDestinations.php')
result = json.loads(response.read())

destinations = result['destinations']

prices = []

for line in open('bus-price-table.txt'):
	arr = line.split(' ')
	prices.append((float(arr[0]), float(arr[1]), float(arr[2][1:])))

matrix = [ [0]*len(destinations) for _ in xrange(len(destinations)) ]

for i in range(len(destinations)):
	for j in range(len(destinations)):
		if i == j:
			matrix[i][j] = (0, 0, 0)
			continue
		distance = g.getDistanceDataBus(str(destinations[i]['lat']) + "," + str(destinations[i]['lon']), str(destinations[j]['lat']) + "," + str(destinations[j]['lon']))['rows'][0]['elements'][0]
		distVal = distance['distance']['value'] / 1000.0
		cost = 0
		
		for p in prices:
			if distVal >= p[0] and distVal <= p[1]:
				cost = p[2]
				break
		
		matrix[i][j] = (cost, distance['distance']['value'], distance['duration']['value'])

f = open('bus.txt', 'w')

for i in range(len(destinations)):
	for j in range(len(destinations)):
		f.write(str(matrix[i][j]) + "\t")
	f.write('\n')
