# pip install geocoder
# pip install xlutils

import geocoder
from xlutils.copy import copy
from xlrd import *
import xlrd
import re

#Fill parameters
#Excel file must be an older version to work with xlutils(.xls)
filename = "E:\\Drive\\Fall 17\\CSc 191\\TestReport3.xls"
sheet = "Open Reports"
latCol = 31
lngCol = 32
streetCol = 10
cityCol = 11
zipCol = 13
rows = 44

wb2 = xlrd.open_workbook(filename)
sheet1 = wb2.sheet_by_name(sheet)

#Loops through each rows in excel
for x in range(0, rows):
    try:
        #Read address informations from file
        street = sheet1.cell(1+x,streetCol).value
        city = sheet1.cell(1+x,cityCol).value
        state = "CA"
        zip = str(int(sheet1.cell(1+x,zipCol).value))
        address = ", ".join((street,city,state,zip))
        print("Excel: {0}".format(address))

        #A number up to 5 digits long followed by any amount of alphanumeric values
        streetFormat = re.compile("^([0-9]{1,5})(\s+\w+)*")
        regexResult = streetFormat.match(street)

        #If street address follows format (ex. 123 street name)
        if(regexResult):
            #Geocode address and get json response
            g = geocoder.google(address)
            print("Google: {0}".format(g.address))
            status = g.status
            location_type = g.accuracy
            results_length = len(g)

            #If json response indicates that the address is exact match (cannot find 'partial_match' in python)
            if((status == 'OK') & (location_type == 'ROOFTOP') & (results_length == 1)):
                #Get latitude and longitude
                lat = g.lat
                lng = g.lng
                print("     Lat: {0}".format(lat))
                print("     Lng: {0}".format(lng))

                #Write lat and lng in file
                wb = copy(open_workbook(filename))
                ws = wb.get_sheet(sheet)
                #ws.write(row, col, value)
                ws.write(1+x, latCol, lat)
                ws.write(1+x, lngCol, lng)
                wb.save(filename)
            else:
                print("     Criterial not met. ")
                print("     Google status: {0}".format(status))
                print("     Google location type: {0}".format(location_type))
                print("     Google result length: {0}".format(results_length))

                #If geocode is over query limit, try the address again
                if (status == 'OVER_QUERY_LIMIT'):
                    x = x - 1
        else:
            print("     Bad street format. ")
    except ValueError:
        print("     Non-numeric data found in the excel file. ")
    print(" ")

