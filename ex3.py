import xlrd,sys
from tkinter import Tk
from tkinter.filedialog import askopenfilename


#print(sys.argv)
if len(sys.argv) < 2:
    print('А какие листы-то сравнивать?')
    while(True):
        try:
            list_num = int(input('Введите № листа: '))
            break
        except ValueError:
            pass
else:
    try:
        list_num = int(sys.argv[1])
    except ValueError:
        list_num = 0
if list_num<=0:
    list_num = 0
else:
    list_num = list_num - 1
print("Лист: ", list_num)

Tk().withdraw()
filename1 = askopenfilename(initialdir = "c:/Apache2.2/htdocs/xls", title = "Первый файл", filetypes = (("Excel files","*.xls"),("all files","*.*")))

Tk().withdraw()
filename2 = askopenfilename(initialdir = "c:/Apache2.2/htdocs/xls", title = "Второй файл", filetypes = (("Excel files","*.xls"),("all files","*.*")))

if filename1 == "": filename1 = "u1.xls"
if filename2 == "": filename2 = "u2.xls"
print("Первый файл: " + filename1)
print("Второй файл: " + filename2)

'''
        if sheet1.cell_value(row, col) == '':
            print('BLANK')
        else:
            print(sheet1.cell_value(row, col))
'''
out_f = open("cmp.html",'w')
out_f1 = open("cmp1.txt",'w')
out_f2 = open("cmp2.txt",'w')

rb1 = xlrd.open_workbook(filename1,formatting_info=False, on_demand=True)
sheet1 = rb1.sheet_by_index(list_num)
rb2 = xlrd.open_workbook(filename2,formatting_info=False, on_demand=True)
sheet2 = rb2.sheet_by_index(list_num)
rb1.release_resources
rb2.release_resources
#print(sheet1.merged_cells)
cmp = []
for row in range(sheet1.nrows):
    for col in range(sheet1.ncols):
        #print(xlrd.cellname(row, col), '(', sheet1.cell_type(row, col), ') -', end=' ')
        if sheet1.cell_value(row, col) != sheet2.cell_value(row, col):
            #print(xlrd.cellname(row, col), '-------------NOT MATCH---------------')
            #t = (row, col)
            cmp.append((row, col))
            #print(row, col, str(sheet1.cell_value(row, col)))
    #row = sheet1.row_values(rownum)

out_f.write('<html><body>Список различий:<br>')
for c in cmp:
    row, col = c
    dsc1 = str(sheet1.cell_value(row, 0))
    dsc2 = sheet1.cell_value(row, 1)
    dsc3 = sheet1.cell_value(2, col)
    curr_cel1 = sheet1.cell_value(row, col)
    curr_cel2 = sheet2.cell_value(row, col)

    out_f.write('<B><font color=blue>' + dsc1 + ' (')
    out_f.write(dsc2)
    out_f.write(')</font> - <font color=green>')
    out_f.write(dsc3)
    out_f.write('</font></B><br><table border=1><tr><td>')

    out_f1.write(dsc1 + ' ')
    out_f1.write(dsc2)
    out_f1.write(' - ')
    out_f1.write(dsc3)
    out_f1.write('\n')
    out_f2.write(dsc1 + ' ')
    out_f2.write(dsc2)
    out_f2.write(' - ')
    out_f2.write(dsc3)
    out_f2.write('\n')

    if curr_cel1 == '':
        out_f.write('0')
        out_f1.write('0')
    else:
        out_f.write(str(curr_cel1))
        out_f1.write(str(curr_cel1))
    out_f.write("</td><td>")
    if curr_cel2 == '':
        out_f.write('0')
        out_f2.write('0')
    else:
        out_f.write(str(curr_cel2))
        out_f2.write(str(curr_cel2))
    out_f.write("</td></tr></table>")
    out_f1.write('\n')
    out_f2.write('\n')
rb1.unload_sheet(list_num)
rb2.unload_sheet(list_num)
out_f.write('</body></html>')
out_f.close()
out_f1.close()
out_f2.close()

