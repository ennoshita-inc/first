import openpyxl
from openpyxl.styles import Font, PatternFill, Border, Side, Alignment
from openpyxl.utils import get_column_letter

wb = openpyxl.Workbook()
ws = wb.active
ws.title = "日程調整表"

# --- Style definitions ---
thin_side = Side(style="thin", color="000000")
border_all = Border(top=thin_side, bottom=thin_side, left=thin_side, right=thin_side)

header_fill = PatternFill(start_color="1F4E79", end_color="1F4E79", fill_type="solid")
header_font = Font(name="游ゴシック", size=11, bold=True, color="FFFFFF")
header_align = Alignment(horizontal="center", vertical="center", wrap_text=True)

title_font = Font(name="游ゴシック", size=16, bold=True)
subtitle_font = Font(name="游ゴシック", size=12, color="333333")
normal_font = Font(name="游ゴシック", size=11)
normal_center = Alignment(horizontal="center", vertical="center", wrap_text=True)
normal_left = Alignment(horizontal="left", vertical="center", wrap_text=True)
note_font = Font(name="游ゴシック", size=10, color="555555")
note_font_bold = Font(name="游ゴシック", size=10, bold=True, color="C00000")
footer_font = Font(name="游ゴシック", size=11, bold=True, color="1F4E79")

# Light blue fill for alternating rows
light_fill = PatternFill(start_color="EBF5FB", end_color="EBF5FB", fill_type="solid")
# Light yellow for the camp row
camp_fill = PatternFill(start_color="FFF9E6", end_color="FFF9E6", fill_type="solid")

# --- Column widths ---
col_widths = {1: 10, 2: 10, 3: 22, 4: 22, 5: 22, 6: 18, 7: 28}
for col, w in col_widths.items():
    ws.column_dimensions[get_column_letter(col)].width = w

# --- Title (row 1) ---
ws.merge_cells("A1:G1")
cell = ws["A1"]
cell.value = "株式会社大晃産業　次世代リーダー研修　日程調整表"
cell.font = title_font
cell.alignment = Alignment(horizontal="center", vertical="center")
ws.row_dimensions[1].height = 40

# --- Subtitle (row 2) ---
ws.merge_cells("A2:G2")
cell = ws["A2"]
cell.value = "ご希望の日程に○をご記入ください"
cell.font = subtitle_font
cell.alignment = Alignment(horizontal="center", vertical="center")
ws.row_dimensions[2].height = 28

# --- Period note (row 3) ---
ws.merge_cells("A3:G3")
cell = ws["A3"]
cell.value = "研修期間：2026年6月～2027年5月（全12回）　／　通常回 9:00～17:00"
cell.font = Font(name="游ゴシック", size=10, color="333333")
cell.alignment = Alignment(horizontal="center", vertical="center")
ws.row_dimensions[3].height = 24

# --- Blank row 4 ---
ws.row_dimensions[4].height = 8

# --- Header row (row 5) ---
headers = ["回", "実施月", "候補日A", "候補日B", "候補日C", "ご希望\n（○を記入）", "備考"]
header_row = 5
ws.row_dimensions[header_row].height = 36
for col_idx, h in enumerate(headers, 1):
    cell = ws.cell(row=header_row, column=col_idx, value=h)
    cell.font = header_font
    cell.fill = header_fill
    cell.alignment = header_align
    cell.border = border_all

# --- Data ---
data = [
    ("第1回",  "6月",  "6/11(木)",  "6/12(金)",  "-", "", ""),
    ("第2回",  "7月",  "7/9(木)",   "7/10(金)",  "-", "", ""),
    ("第3回",  "8月",  "8/6(木)",   "8/7(金)",   "-", "", ""),
    ("第4回",  "9月",  "9/17(木)",  "9/18(金)",  "-", "", ""),
    ("第5回",  "10月", "10/9(木)",  "10/23(金)", "-", "", ""),
    ("第6回",  "11月", "11/6(金)",  "11/10(火)", "-", "", ""),
    ("第7回",  "12月", "12/17(木)", "12/18(金)", "-", "", ""),
    ("第8回",  "1月",  "1/21(水)",  "1/22(木)",  "-", "", ""),
    ("第9回",  "2月",  "2/12(木)",  "2/25(水)",  "-", "", ""),
    ("第10回", "3月",  "3/18(木)",  "3/19(金)",  "-", "", ""),
    ("第11回", "4月",  "4/13(月)-14(火)", "4/20(月)-21(火)", "-", "", "★1泊2日合宿\n1日目 9:00～17:00\n2日目 8:30～15:00"),
    ("第12回", "5月",  "5/13(水)",  "5/14(木)",  "-", "", ""),
]

data_start = header_row + 1
for i, row_data in enumerate(data):
    row_num = data_start + i
    is_camp = (i == 10)  # 第11回
    is_even = (i % 2 == 1)

    ws.row_dimensions[row_num].height = 40 if is_camp else 30

    for col_idx, val in enumerate(row_data, 1):
        cell = ws.cell(row=row_num, column=col_idx, value=val)
        cell.font = normal_font
        cell.border = border_all

        if col_idx in (1, 2, 3, 4, 5, 6):
            cell.alignment = normal_center
        else:
            cell.alignment = normal_left

        # Background
        if is_camp:
            cell.fill = camp_fill
        elif is_even:
            cell.fill = light_fill

    # Bold the camp note
    if is_camp:
        camp_cell = ws.cell(row=row_num, column=7)
        camp_cell.font = Font(name="游ゴシック", size=10, bold=True, color="C00000")
        camp_cell.alignment = Alignment(horizontal="left", vertical="center", wrap_text=True)
        ws.row_dimensions[row_num].height = 54

data_end = data_start + len(data) - 1

# --- Notes section below data ---
note_start = data_end + 2

ws.merge_cells(f"A{note_start}:G{note_start}")
cell = ws.cell(row=note_start, column=1, value="【ご留意事項】")
cell.font = Font(name="游ゴシック", size=11, bold=True, color="1F4E79")
cell.alignment = Alignment(horizontal="left", vertical="center")
ws.row_dimensions[note_start].height = 26

r = note_start + 1
ws.merge_cells(f"A{r}:G{r}")
cell = ws.cell(row=r, column=1, value="・可能な限り同じ曜日で統一することが望ましいため、各回のご希望日をご検討ください。")
cell.font = note_font
cell.alignment = Alignment(horizontal="left", vertical="center", wrap_text=True)
ws.row_dimensions[r].height = 24

r += 1
ws.merge_cells(f"A{r}:G{r}")
cell = ws.cell(row=r, column=1, value="・第11回は1泊2日の合宿形式です。1日目 9:00～17:00、2日目 8:30～15:00 の予定です。")
cell.font = note_font
cell.alignment = Alignment(horizontal="left", vertical="center", wrap_text=True)
ws.row_dimensions[r].height = 24

r += 1
ws.merge_cells(f"A{r}:G{r}")
cell = ws.cell(row=r, column=1, value="・通常回の研修時間は 9:00～17:00 です。")
cell.font = note_font
cell.alignment = Alignment(horizontal="left", vertical="center", wrap_text=True)
ws.row_dimensions[r].height = 24

# --- Camp venue section ---
r += 2
ws.merge_cells(f"A{r}:G{r}")
cell = ws.cell(row=r, column=1, value="【合宿会場候補】")
cell.font = Font(name="游ゴシック", size=11, bold=True, color="1F4E79")
cell.alignment = Alignment(horizontal="left", vertical="center")
ws.row_dimensions[r].height = 26

r += 1
for line_i in range(3):
    row_n = r + line_i
    ws.merge_cells(f"B{row_n}:G{row_n}")
    label_cell = ws.cell(row=row_n, column=1, value=f"候補{line_i+1}：")
    label_cell.font = normal_font
    label_cell.alignment = Alignment(horizontal="right", vertical="center")
    input_cell = ws.cell(row=row_n, column=2, value="")
    input_cell.border = Border(bottom=Side(style="thin", color="999999"))
    # Apply bottom border across merged range
    for c in range(2, 8):
        ws.cell(row=row_n, column=c).border = Border(bottom=Side(style="thin", color="999999"))
    ws.row_dimensions[row_n].height = 26

# --- Footer ---
r = r + 3 + 1
ws.merge_cells(f"A{r}:G{r}")
cell = ws.cell(row=r, column=1, value="ご記入後、中銀ヒューマンイノベーションズ　桑田様までご返送ください。")
cell.font = footer_font
cell.alignment = Alignment(horizontal="center", vertical="center")
ws.row_dimensions[r].height = 32

# --- Print settings ---
ws.sheet_properties.pageSetUpPr = openpyxl.worksheet.properties.PageSetupProperties(fitToPage=True)
ws.page_setup.fitToWidth = 1
ws.page_setup.fitToHeight = 1
ws.page_setup.orientation = "portrait"
ws.print_area = f"A1:G{r}"

# --- Save ---
wb.save("/home/user/first/schedule-adjustment.xlsx")
print("Done: /home/user/first/schedule-adjustment.xlsx")
