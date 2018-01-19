# pip install xlutils

from xlutils.copy import copy
from xlrd import *
import xlrd

#Fill parameters
#Excel file must be an older version to work with xlutils(.xls)
filename = "E:\\Drive\\Fall 17\\CSc 191\\TestReport4.xls"
sheetName = "Open Reports"
rows = 45
addressCol = 10
addCmtCol = 23

book = xlrd.open_workbook(filename, formatting_info=True)
sheet = book.sheet_by_name(sheetName)

#Loops through each row in excel
for row in range(1,rows):
    addressVal = sheet.cell(row, addressCol).value
    addCmtVal = sheet.cell(row, addCmtCol).value

    # If address is too long to be an address then move it to additional comments
    if(len(addressVal) > 30):
        # Append address to end of additional comment column and empty address column
        appendToAddCmt = addCmtVal+". "+addressVal
        wb = copy(open_workbook(filename))
        ws = wb.get_sheet(sheetName)

        # ws.write(row, col, value)
        ws.write(row, addCmtCol, appendToAddCmt)
        ws.write(row, addressCol, "")
        print("Moved: "+addressVal+"\n")

        wb.save(filename)