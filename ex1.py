#import openpyxl
from openpyxl import load_workbook, Workbook

wb = load_workbook('c:\\ex1.xlsx', True, True)

def hell():
    '''
    Go to Hell!
    '''
    print ('hell')
ppp='ghost'
hell()
print(type(hell), ppp, type(ppp))
