# pip install xlutils

from xlutils.copy import copy
from xlrd import *
import xlrd
import re

#Fill parameters and use after using Excel macro to populate statuses
#Excel file must be an older version to work with xlutils(.xls)
filename = "E:\\Drive\\Fall 17\\CSc 191\\5.xls"
sheetName = "Open Reports"
rows = 201
statusCol = 3
triageCmtCol = 1
book = xlrd.open_workbook(filename, formatting_info=True)
sheet = book.sheet_by_name(sheetName)

#Loops through each row in excel
for row in range(1,rows):
    statusVal = sheet.cell(row, statusCol).value
    triageCmtVal = sheet.cell(row, triageCmtCol).value

    #If status is "Open" and Triage Comments are present, then status is "Contacted"
    if((statusVal == "Open") & (triageCmtVal != "")):
        print("Open --> Contacted @ row: {0}".format(row))
        # Change status to Contacted in file
        wb = copy(open_workbook(filename))
        ws = wb.get_sheet(sheetName)
        # ws.write(row, col, value)
        ws.write(row, statusCol, "Contacted")
        wb.save(filename)

