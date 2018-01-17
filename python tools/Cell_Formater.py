'''
Created on Jan 15, 2018

@author: Charles Tishler
@SpecialThanks: Alice Mooc
'''
# Simple Column and Row filter
# This flags incorrect values with the NULL tag.
# pip install geocoder (might not be needed)
# pip install xlutils
# pip word2number

from xlutils.copy import copy
from xlrd import open_workbook
from word2number import w2n
import xlrd
import sys
import re

#Declare file paths
filename = "C:\Users\White Box\Desktop\Python\TestReport3.xls"
sheet = "Open Reports"

#Declare Variables
totalSearched = 0
totalCorrections = 0
totalAppends = 0
totalErrors = 0
#Currently Hardcoded with comment number location.
def savetoWorkbook(workbook, sheet, row, col, valuetosave, newComment):
    wb = copy(open_workbook(workbook))
    ws = wb.get_sheet(sheet)
    ws.write(row, col, valuetosave)
    ws.write(row, 23, newComment)
    wb.save(filename)
    
#Open Files and Select sheet
try:
    activeWorkBook = xlrd.open_workbook(filename)
except Exception:
    print"Failed to open workbook!"
    sys.exit(1)
try:
    activeSheet = activeWorkBook.sheet_by_name(sheet)
except Exception:
    print"Failed to open sheet!"
    sys.exit(1)
#Perform Filtering upon successful opening
for x in range(1, 44):
        try:
            example = activeSheet.cell(x, 15).value
            totalSearched += 1
            #See if it is a acceptable number. e.g. 5
            if type(example) == float:
                #Is it outside the acceptable range?
                if 0 > example or example > 100:
                    print x + 1, " | Fail: Out of Range, appending to comments"
                    newComment = "<FLAG> No. Cats: (Out of Bounds) " + activeSheet.cell(x, 23).value
                    savetoWorkbook(filename, sheet, x, 15, example, newComment)
            #See if the cell is empty
            elif not any(activeSheet.cell(x, 15).value):
                print x + 1, " | Corrected. Empty Field, Appended Null to Comments"
                totalAppends += 1
                totalCorrections += 1
                newComment = "<FLAG> No. Cats: (Null) " + example + "  " + activeSheet.cell(x, 23).value
                savetoWorkbook(filename, sheet, x, 15, None, newComment)
            #See if it is a string of some kind
            elif isinstance(example, basestring):
                try: 
                    #Attempt to make it into a number and check range. E.g. five to 5 or fifteen to 15
                    example = w2n.word_to_num(str(example))
                    if 0 < example and example < 100:
                        totalCorrections += 1
                        print x + 1, " | Corrected"
                        wb = copy(open_workbook(filename))
                        ws = wb.get_sheet(sheet)
                        ws.write(x, 15, example)
                        wb.save(filename)
                        savetoWorkbook(filename, sheet, x, 15, int(example), activeSheet.cell(x, 23).value)
                    else:
                        print x + 1, " | Appending to comments"
                        totalAppends += 1
                        newComment = "<FLAG> No. Cats: " + example + "  " + activeSheet.cell(x, 23).value
                        savetoWorkbook(filename, sheet, x, 15, int(example), newComment)
                except ValueError:
                    #This must be some combination of letters and numbers. E.g. 3 + 5
                    #Extract Digits, note, they are unicode.
                    digits = re.findall(r'\d+', example)
                    if len(digits) == 0:
                    #Plain String Found, no digits. E.g. Unknown, Don't Know
                        print x + 1, " |  No digits found. Appending and Correcting."
                        totalAppends += 1
                        totalCorrections += 1
                        newComment = "<FLAG> No. Cats: " + example + "  " + activeSheet.cell(x, 23).value
                        savetoWorkbook(filename, sheet, x, 15, None, newComment)
                    elif len(digits) == 1:
                        totalCorrections += 1
                        print x + 1, " | Corrected"
                        savetoWorkbook(filename, sheet, x, 15, int(digits[0]), activeSheet.cell(x, 23).value)
                    #Two Digits found
                    elif len(digits) == 2:
                        #Range Detected, average between the two and append to comment.
                        if any(re.findall(r'\-|to', example)):
                            print x + 1, " | ", digits, " Two Numbers Found with: -, to. Might be range. Averaging and appending"
                            average = int(digits[0]) + int(digits[1])
                            average /= 2
                            totalAppends += 1
                            totalCorrections += 1
                            newComment = "<FLAG> No. Cats: " + digits[0] + " - " + digits[1] + "   "  + "  " + activeSheet.cell(x, 23).value
                            savetoWorkbook(filename, sheet, x, 15, average, newComment)
                        elif any(re.findall(r'\+|and|plus|includ', example)):
                            if any(re.findall(r'kitten|cub', example)):
                                print x + 1, " | ", digits, " Two Numbers Found with: +, and, includes, including, kitten, kittens. Might be range. Averaging and appending"
                                average = int(digits[0]) + int(digits[1])
                                totalAppends += 1
                                totalCorrections += 1
                                newComment = "<FLAG> Kittens! No. Cats: " + digits[0] + " - " + digits[1] + "   "  + "  " + activeSheet.cell(x, 23).value
                                savetoWorkbook(filename, sheet, x, 15, average, newComment)
                            else:
                                print x + 1, " | ", digits, " Two Numbers Found with: +, and, includes, including. Might be range. Averaging and appending"
                                average = int(digits[0]) + int(digits[1])
                                totalAppends += 1
                                totalCorrections += 1
                                newComment = "<FLAG>No. Cats: " + digits[0] + " + " + digits[1] + "   "  + "  " + activeSheet.cell(x, 23).value
                                savetoWorkbook(filename, sheet, x, 15, average, newComment)
                    else:
                        print x + 1, " | ", digits, " Multiple digits found. Manual Inspection Required."
                        totalErrors += 1;
                        totalAppends += 1
                        totalCorrections += 1
                        newComment = "<FLAG> No. Cats: Multiple Digits Found Inspection Required   " + activeSheet.cell(x, 23).value
                        wb = copy(open_workbook(filename))
                        ws = wb.get_sheet(sheet)
                        ws.write(x, 15, digits)
                        ws.write(x, 23, newComment)
                        wb.save(filename)
        except Exception:
            #This gets thrown if there are ANY thrown exceptions regarding loading, saving, and performing operations with cells.
            print x + 1, " | (!!) Exception thrown, requires manual inspection. Corrections might not have saved."
            totalErrors += 1;
print "\n\nFiltering Complete!"
print "Search for <FLAG> to see each comment that was altered during the run of this script."
print "Total Records searched: ", totalSearched
print "Total Corrections Made: ", totalCorrections       
print "Total Comment Appends:  ", totalAppends
print "Total Entries Untouched (Requires Manual Inspection): "   , totalErrors

    






