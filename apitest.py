from APIConnector import TaxiAPIConnector

a = TaxiAPIConnector()

mbs = a.searchAddress(1.2839, 103.8609)
flyer = a.searchAddress(1.2893, 103.8631)

print a.getTravelCost(mbs, flyer)['flatFare']
