import xlrd

f = open("cmp.html",'w')

rb1 = xlrd.open_workbook('u1.xls',formatting_info=True)
sheet1 = rb1.sheet_by_index(1)
for rownum in range(sheet1.nrows):
    row = sheet1.row_values(rownum)
for c_el in row:
    print(c_el)

f.write('<html><body>')
f.close()

#vals = [sheet1.row_values(rownum) for rownum in range(sheet1.nrows)]
#print(vals)
