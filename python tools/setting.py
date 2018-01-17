# pip install xlutils

from xlutils.copy import copy
from xlrd import *
import xlrd

#Fill parameters
#Excel file must be an older version to work with xlutils(.xls)
filename = "E:\\Drive\\Fall 17\\CSc 191\\5.xls"
sheetName = "Open Reports"
rows = 199
settingCol = 22
addCmtCol = 23

book = xlrd.open_workbook(filename, formatting_info=True)
sheet = book.sheet_by_name(sheetName)

#Loops through each row in excel
for row in range(1,rows):
    settingVal = sheet.cell(row, settingCol).value
    addCmtVal = sheet.cell(row, addCmtCol).value
    #Append setting's details to end of additional comment column
    appendToAddCmt = addCmtVal+". "+settingVal

    #Write setting's details to end of additional comment column
    wb = copy(open_workbook(filename))
    ws = wb.get_sheet(sheetName)
    #ws.write(row, col, value)
    ws.write(row, addCmtCol, appendToAddCmt)

    #If setting is residential, commercial, or industrial then overwrite it in setting's column
    hasSetting = False
    if ("Residential" in settingVal) | ("residential" in settingVal):
        ws.write(row, settingCol, "Residential")
        hasSetting = True
    if ("Commercial" in settingVal) | ("commercial" in settingVal):
        ws.write(row, settingCol, "Commercial")
        hasSetting = True
    if ("Industrial" in settingVal) | ("industrial" in settingVal):
        ws.write(row, settingCol, "Industrial")
        hasSetting = True
    if ("Rural" in settingVal) | ("rural" in settingVal):
        ws.write(row, settingCol, "Rural")
        hasSetting = True

    #If settings column don't contain any of these keywords then overwrite to empty
    if(hasSetting == False):
        ws.write(row, settingCol, "")

    wb.save(filename)

