import openpyxl
from openpyxl.styles import Font, PatternFill, Border, Side, Alignment, numbers
from openpyxl.utils import get_column_letter
from openpyxl.worksheet.datavalidation import DataValidation
from copy import copy

wb = openpyxl.Workbook()

# ============================================================
# 共通スタイル定義
# ============================================================
thin_side = Side(style="thin", color="4472C4")
thin_gray = Side(style="thin", color="BFBFBF")
medium_side = Side(style="medium", color="2F5496")
border_all = Border(top=thin_side, bottom=thin_side, left=thin_side, right=thin_side)
border_gray = Border(top=thin_gray, bottom=thin_gray, left=thin_gray, right=thin_gray)
border_header = Border(top=medium_side, bottom=medium_side, left=thin_side, right=thin_side)

# カラーパレット
NAVY = "2F5496"
BLUE = "4472C4"
LIGHT_BLUE = "D6E4F0"
VERY_LIGHT_BLUE = "EDF2F9"
WHITE = "FFFFFF"
DARK_TEXT = "1F3864"
ACCENT_RED = "C00000"
ACCENT_GOLD = "BF8F00"
LIGHT_GOLD = "FFF2CC"
LIGHT_GREEN = "E2EFDA"
LIGHT_GRAY = "F2F2F2"

navy_fill = PatternFill(start_color=NAVY, end_color=NAVY, fill_type="solid")
blue_fill = PatternFill(start_color=BLUE, end_color=BLUE, fill_type="solid")
light_blue_fill = PatternFill(start_color=LIGHT_BLUE, end_color=LIGHT_BLUE, fill_type="solid")
very_light_blue_fill = PatternFill(start_color=VERY_LIGHT_BLUE, end_color=VERY_LIGHT_BLUE, fill_type="solid")
gold_fill = PatternFill(start_color=LIGHT_GOLD, end_color=LIGHT_GOLD, fill_type="solid")
green_fill = PatternFill(start_color=LIGHT_GREEN, end_color=LIGHT_GREEN, fill_type="solid")
gray_fill = PatternFill(start_color=LIGHT_GRAY, end_color=LIGHT_GRAY, fill_type="solid")
white_fill = PatternFill(start_color=WHITE, end_color=WHITE, fill_type="solid")

# フォント
title_font = Font(name="游ゴシック", size=18, bold=True, color=NAVY)
subtitle_font = Font(name="游ゴシック", size=11, color="595959")
header_font = Font(name="游ゴシック", size=10, bold=True, color=WHITE)
section_font = Font(name="游ゴシック", size=11, bold=True, color=NAVY)
normal_font = Font(name="游ゴシック", size=10)
normal_bold = Font(name="游ゴシック", size=10, bold=True)
small_font = Font(name="游ゴシック", size=9, color="595959")
accent_font = Font(name="游ゴシック", size=10, bold=True, color=ACCENT_RED)
link_font = Font(name="游ゴシック", size=9, color=BLUE, italic=True)

center_align = Alignment(horizontal="center", vertical="center", wrap_text=True)
left_align = Alignment(horizontal="left", vertical="center", wrap_text=True)
right_align = Alignment(horizontal="right", vertical="center", wrap_text=True)


def apply_style(cell, font=None, fill=None, border=None, alignment=None):
    if font: cell.font = font
    if fill: cell.fill = fill
    if border: cell.border = border
    if alignment: cell.alignment = alignment


def fill_row_border(ws, row, col_start, col_end, border):
    for c in range(col_start, col_end + 1):
        ws.cell(row=row, column=c).border = border


# ============================================================
# Sheet 1: 日程調整表
# ============================================================
ws1 = wb.active
ws1.title = "日程調整表"

# 列幅
widths = {1: 6, 2: 8, 3: 18, 4: 18, 5: 18, 6: 10, 7: 10, 8: 10, 9: 24}
for col, w in widths.items():
    ws1.column_dimensions[get_column_letter(col)].width = w

# --- タイトルブロック ---
ws1.merge_cells("A1:I1")
cell = ws1["A1"]
cell.value = "株式会社大晃産業　次世代リーダー研修"
apply_style(cell, font=title_font, alignment=Alignment(horizontal="center", vertical="center"))
ws1.row_dimensions[1].height = 45

ws1.merge_cells("A2:I2")
cell = ws1["A2"]
cell.value = "日 程 調 整 表"
apply_style(cell, font=Font(name="游ゴシック", size=14, bold=True, color=BLUE),
            alignment=Alignment(horizontal="center", vertical="center"))
ws1.row_dimensions[2].height = 32

# 区切り線
ws1.merge_cells("A3:I3")
for c in range(1, 10):
    ws1.cell(row=3, column=c).border = Border(bottom=Side(style="medium", color=NAVY))
ws1.row_dimensions[3].height = 6

# --- 基本情報 ---
row = 4
ws1.row_dimensions[row].height = 24
ws1.merge_cells(f"A{row}:B{row}")
apply_style(ws1.cell(row=row, column=1, value="研修期間"),
            font=normal_bold, fill=light_blue_fill, border=border_gray,
            alignment=Alignment(horizontal="center", vertical="center"))
ws1.cell(row=row, column=2).fill = light_blue_fill
ws1.cell(row=row, column=2).border = border_gray
ws1.merge_cells(f"C{row}:E{row}")
apply_style(ws1.cell(row=row, column=3, value="2026年6月 ～ 2027年5月（全12回）"),
            font=normal_font, border=border_gray, alignment=left_align)
ws1.cell(row=row, column=4).border = border_gray
ws1.cell(row=row, column=5).border = border_gray

ws1.merge_cells(f"F{row}:G{row}")
apply_style(ws1.cell(row=row, column=6, value="研修時間"),
            font=normal_bold, fill=light_blue_fill, border=border_gray,
            alignment=Alignment(horizontal="center", vertical="center"))
ws1.cell(row=row, column=7).fill = light_blue_fill
ws1.cell(row=row, column=7).border = border_gray
ws1.merge_cells(f"H{row}:I{row}")
apply_style(ws1.cell(row=row, column=8, value="9:00 ～ 17:00"),
            font=normal_font, border=border_gray, alignment=left_align)
ws1.cell(row=row, column=9).border = border_gray

row = 5
ws1.row_dimensions[row].height = 24
ws1.merge_cells(f"A{row}:B{row}")
apply_style(ws1.cell(row=row, column=1, value="回答期限"),
            font=normal_bold, fill=light_blue_fill, border=border_gray,
            alignment=Alignment(horizontal="center", vertical="center"))
ws1.cell(row=row, column=2).fill = light_blue_fill
ws1.cell(row=row, column=2).border = border_gray
ws1.merge_cells(f"C{row}:E{row}")
apply_style(ws1.cell(row=row, column=3, value="2026年3月20日（金）"),
            font=Font(name="游ゴシック", size=10, bold=True, color=ACCENT_RED),
            border=border_gray, alignment=left_align)
ws1.cell(row=row, column=4).border = border_gray
ws1.cell(row=row, column=5).border = border_gray

ws1.merge_cells(f"F{row}:G{row}")
apply_style(ws1.cell(row=row, column=6, value="返送先"),
            font=normal_bold, fill=light_blue_fill, border=border_gray,
            alignment=Alignment(horizontal="center", vertical="center"))
ws1.cell(row=row, column=7).fill = light_blue_fill
ws1.cell(row=row, column=7).border = border_gray
ws1.merge_cells(f"H{row}:I{row}")
apply_style(ws1.cell(row=row, column=8, value="桑田様（中銀HI）"),
            font=normal_font, border=border_gray, alignment=left_align)
ws1.cell(row=row, column=9).border = border_gray

# --- 記入方法の説明 ---
row = 7
ws1.merge_cells(f"A{row}:I{row}")
apply_style(ws1.cell(row=row, column=1, value="【ご記入方法】各候補日について、ご都合を下記の記号でご記入ください。"),
            font=section_font, alignment=left_align)
ws1.row_dimensions[row].height = 28

row = 8
ws1.row_dimensions[row].height = 22
legend_data = [
    (1, 2, "◎", "第一希望", green_fill),
    (3, 4, "○", "対応可能", very_light_blue_fill),
    (5, 6, "△", "調整すれば可能", PatternFill(start_color="FFF2CC", end_color="FFF2CC", fill_type="solid")),
    (7, 8, "×", "対応不可", PatternFill(start_color="FCE4EC", end_color="FCE4EC", fill_type="solid")),
]
for col_s, col_e, symbol, desc, fill in legend_data:
    apply_style(ws1.cell(row=row, column=col_s, value=symbol),
                font=Font(name="游ゴシック", size=11, bold=True), fill=fill,
                border=border_gray, alignment=center_align)
    apply_style(ws1.cell(row=row, column=col_e, value=desc),
                font=small_font, border=border_gray,
                alignment=Alignment(horizontal="left", vertical="center"))

# --- 空行 ---
ws1.row_dimensions[9].height = 6

# --- ヘッダー行 ---
header_row = 10
headers = ["回", "月", "候補日 A", "候補日 B", "候補日 C", "A", "B", "C", "備考・ご要望"]
ws1.row_dimensions[header_row].height = 32

for col_idx, h in enumerate(headers, 1):
    cell = ws1.cell(row=header_row, column=col_idx, value=h)
    apply_style(cell, font=header_font, fill=navy_fill, border=border_header, alignment=center_align)

# サブヘッダー（ご希望欄の説明）
ws1.merge_cells(f"F{header_row-1}:H{header_row-1}")
apply_style(ws1.cell(row=header_row-1, column=6, value="← ご希望をご記入 →"),
            font=Font(name="游ゴシック", size=8, italic=True, color=BLUE),
            alignment=center_align)
ws1.row_dimensions[header_row-1].height = 16

# --- データ行 ---
schedule_data = [
    ("第1回",  "6月",  "6月11日（木）", "6月12日（金）", "6月18日（水）", "キックオフ・チームビルディング"),
    ("第2回",  "7月",  "7月 9日（木）", "7月10日（金）", "7月16日（水）", ""),
    ("第3回",  "8月",  "8月 6日（木）", "8月 7日（金）", "8月20日（水）", ""),
    ("第4回",  "9月",  "9月17日（木）", "9月18日（金）", "9月10日（水）", ""),
    ("第5回",  "10月", "10月 9日（木）", "10月23日（金）","10月15日（水）",""),
    ("第6回",  "11月", "11月 6日（木）", "11月13日（木）","11月19日（水）",""),
    ("第7回",  "12月", "12月17日（木）", "12月18日（金）","12月10日（水）",""),
    ("第8回",  "1月",  "1月21日（水）", "1月22日（木）", "1月15日（木）", ""),
    ("第9回",  "2月",  "2月12日（木）", "2月25日（水）", "2月18日（水）", ""),
    ("第10回", "3月",  "3月18日（木）", "3月19日（金）", "3月11日（水）", ""),
    ("第11回", "4月",  "4月13日（月）-14日（火）", "4月20日（月）-21日（火）", "4月27日（月）-28日（火）",
     "★ 1泊2日合宿\n1日目 9:00～17:00\n2日目 8:30～15:00"),
    ("第12回", "5月",  "5月13日（水）", "5月14日（木）", "5月21日（木）", "最終回"),
]

data_start = header_row + 1
for i, (kai, month, a, b, c, note) in enumerate(schedule_data):
    r = data_start + i
    is_camp = (i == 10)  # 第11回が合宿
    is_even = (i % 2 == 0)

    row_fill = gold_fill if is_camp else (very_light_blue_fill if is_even else white_fill)
    ws1.row_dimensions[r].height = 56 if is_camp else 32

    # 回
    apply_style(ws1.cell(row=r, column=1, value=kai),
                font=normal_bold if is_camp else normal_font,
                fill=row_fill, border=border_all, alignment=center_align)
    # 月
    apply_style(ws1.cell(row=r, column=2, value=month),
                font=normal_font, fill=row_fill, border=border_all, alignment=center_align)
    # 候補日A/B/C
    for col_idx, date_val in [(3, a), (4, b), (5, c)]:
        apply_style(ws1.cell(row=r, column=col_idx, value=date_val),
                    font=normal_font, fill=row_fill, border=border_all, alignment=center_align)
    # 回答欄A/B/C（空セル - クライアントが記入）
    for col_idx in [6, 7, 8]:
        cell = ws1.cell(row=r, column=col_idx, value="")
        apply_style(cell, font=Font(name="游ゴシック", size=14, bold=True),
                    fill=PatternFill(start_color="FFFFEF", end_color="FFFFEF", fill_type="solid"),
                    border=Border(top=thin_side, bottom=thin_side,
                                  left=Side(style="medium", color=ACCENT_GOLD),
                                  right=Side(style="medium", color=ACCENT_GOLD)),
                    alignment=center_align)
    # 備考
    apply_style(ws1.cell(row=r, column=9, value=note),
                font=accent_font if is_camp else small_font,
                fill=row_fill, border=border_all, alignment=left_align)

data_end = data_start + len(schedule_data) - 1

# --- データ入力規則（プルダウン） ---
dv = DataValidation(type="list", formula1='"◎,○,△,×"', allow_blank=True)
dv.error = "◎○△× のいずれかを選択してください"
dv.errorTitle = "入力エラー"
dv.prompt = "ご都合を選択してください"
dv.promptTitle = "日程の希望"
dv.showInputMessage = True
dv.showErrorMessage = True
ws1.add_data_validation(dv)

for r in range(data_start, data_end + 1):
    for c in [6, 7, 8]:
        dv.add(ws1.cell(row=r, column=c))

# --- 留意事項 ---
note_row = data_end + 2
ws1.merge_cells(f"A{note_row}:I{note_row}")
apply_style(ws1.cell(row=note_row, column=1, value="【ご留意事項】"),
            font=section_font, alignment=left_align)
ws1.row_dimensions[note_row].height = 28

notes = [
    "・各回について、可能な限り複数の候補日にご回答いただけますと、調整がスムーズです。",
    "・同じ曜日で統一できると参加者の予定管理がしやすくなります。",
    "・第11回は1泊2日の合宿形式です。会場は別途ご相談させていただきます。",
    "・上記の候補日以外でご希望がある場合は、備考欄にご記入ください。",
]
for idx, note_text in enumerate(notes):
    r = note_row + 1 + idx
    ws1.merge_cells(f"A{r}:I{r}")
    apply_style(ws1.cell(row=r, column=1, value=note_text),
                font=small_font, alignment=left_align)
    ws1.row_dimensions[r].height = 20

# --- 合宿会場セクション ---
camp_row = note_row + len(notes) + 2
ws1.merge_cells(f"A{camp_row}:I{camp_row}")
apply_style(ws1.cell(row=camp_row, column=1, value="【合宿について】"),
            font=section_font, alignment=left_align)
ws1.row_dimensions[camp_row].height = 28

r = camp_row + 1
ws1.merge_cells(f"A{r}:I{r}")
apply_style(ws1.cell(row=r, column=1, value="合宿の実施は可能ですか？"),
            font=normal_font, alignment=left_align)
ws1.row_dimensions[r].height = 22

r += 1
ws1.row_dimensions[r].height = 26
for col_s, label, fill in [(2, "実施可能", green_fill), (4, "条件付きで可能", PatternFill(start_color="FFF2CC", end_color="FFF2CC", fill_type="solid")), (6, "実施困難", PatternFill(start_color="FCE4EC", end_color="FCE4EC", fill_type="solid"))]:
    apply_style(ws1.cell(row=r, column=col_s, value="　　"),
                font=normal_font, fill=fill, border=border_gray, alignment=center_align)
    apply_style(ws1.cell(row=r, column=col_s + 1, value=label),
                font=normal_font, alignment=left_align)

r += 2
ws1.merge_cells(f"A{r}:B{r}")
apply_style(ws1.cell(row=r, column=1, value="会場ご希望："),
            font=normal_bold, alignment=right_align)
ws1.merge_cells(f"C{r}:I{r}")
cell = ws1.cell(row=r, column=3, value="")
cell.border = Border(bottom=Side(style="thin", color="999999"))
for c in range(3, 10):
    ws1.cell(row=r, column=c).border = Border(bottom=Side(style="thin", color="999999"))
ws1.row_dimensions[r].height = 26

r += 1
ws1.merge_cells(f"A{r}:B{r}")
apply_style(ws1.cell(row=r, column=1, value="ご予算感："),
            font=normal_bold, alignment=right_align)
ws1.merge_cells(f"C{r}:I{r}")
cell = ws1.cell(row=r, column=3, value="")
for c in range(3, 10):
    ws1.cell(row=r, column=c).border = Border(bottom=Side(style="thin", color="999999"))
ws1.row_dimensions[r].height = 26

# --- ご連絡先 ---
r += 2
ws1.merge_cells(f"A{r}:I{r}")
apply_style(ws1.cell(row=r, column=1, value="【ご記入者情報】"),
            font=section_font, alignment=left_align)
ws1.row_dimensions[r].height = 28

info_fields = ["貴社名：", "ご担当者名：", "お電話番号：", "メールアドレス："]
for idx, label in enumerate(info_fields):
    rr = r + 1 + idx
    ws1.merge_cells(f"A{rr}:B{rr}")
    apply_style(ws1.cell(row=rr, column=1, value=label),
                font=normal_bold, alignment=right_align)
    ws1.merge_cells(f"C{rr}:I{rr}")
    for c in range(3, 10):
        ws1.cell(row=rr, column=c).border = Border(bottom=Side(style="thin", color="BFBFBF"))
    ws1.row_dimensions[rr].height = 24

# --- フッター ---
footer_row = r + len(info_fields) + 2
ws1.merge_cells(f"A{footer_row}:I{footer_row}")
apply_style(ws1.cell(row=footer_row, column=1,
                     value="ご記入後、中銀ヒューマンイノベーションズ 桑田様 までご返送ください。"),
            font=Font(name="游ゴシック", size=11, bold=True, color=NAVY),
            alignment=center_align)
ws1.row_dimensions[footer_row].height = 36

footer_row += 1
ws1.merge_cells(f"A{footer_row}:I{footer_row}")
apply_style(ws1.cell(row=footer_row, column=1,
                     value="ご不明な点がございましたら、お気軽にお問い合わせください。"),
            font=Font(name="游ゴシック", size=9, color="808080"),
            alignment=center_align)
ws1.row_dimensions[footer_row].height = 22

# --- 印刷設定 ---
ws1.sheet_properties.pageSetUpPr = openpyxl.worksheet.properties.PageSetupProperties(fitToPage=True)
ws1.page_setup.fitToWidth = 1
ws1.page_setup.fitToHeight = 1
ws1.page_setup.orientation = "portrait"
ws1.page_setup.paperSize = ws1.PAPERSIZE_A4
ws1.print_area = f"A1:I{footer_row}"
ws1.page_margins.left = 0.5
ws1.page_margins.right = 0.5
ws1.page_margins.top = 0.5
ws1.page_margins.bottom = 0.5


# ============================================================
# Sheet 2: 研修プログラム概要
# ============================================================
ws2 = wb.create_sheet("研修プログラム概要")

widths2 = {1: 8, 2: 8, 3: 30, 4: 35, 5: 20}
for col, w in widths2.items():
    ws2.column_dimensions[get_column_letter(col)].width = w

# タイトル
ws2.merge_cells("A1:E1")
apply_style(ws2["A1"], font=Font(name="游ゴシック", size=14, bold=True, color=NAVY),
            alignment=center_align)
ws2["A1"].value = "次世代リーダー研修　プログラム概要（全12回）"
ws2.row_dimensions[1].height = 40

ws2.merge_cells("A2:E2")
apply_style(ws2["A2"], font=Font(name="游ゴシック", size=10, color="808080"),
            alignment=center_align)
ws2["A2"].value = "※内容は訪問打ち合わせ後に確定いたします。下記は現時点の想定です。"
ws2.row_dimensions[2].height = 24

# ヘッダー
headers2 = ["回", "月", "テーマ（予定）", "内容（予定）", "課題図書"]
for col_idx, h in enumerate(headers2, 1):
    cell = ws2.cell(row=4, column=col_idx, value=h)
    apply_style(cell, font=header_font, fill=navy_fill, border=border_header, alignment=center_align)
ws2.row_dimensions[4].height = 30

# プログラムデータ
program_data = [
    ("第1回",  "6月",  "キックオフ", "研修の目的共有・チームビルディング\n自己紹介・期待値の共有", ""),
    ("第2回",  "7月",  "リーダーシップ基礎", "リーダーシップの型を学ぶ\n自身のリーダーシップスタイル分析", "対象書籍①"),
    ("第3回",  "8月",  "問題解決力", "ロジカルシンキング\n問題の構造化と解決策立案", ""),
    ("第4回",  "9月",  "コミュニケーション", "部下育成のコミュニケーション\nフィードバックの技術", "対象書籍②"),
    ("第5回",  "10月", "チームマネジメント", "チーム目標の設定と管理\n動機づけとエンゲージメント", ""),
    ("第6回",  "11月", "戦略思考", "経営戦略の基礎\n自社の強み・弱みの分析", "対象書籍③"),
    ("第7回",  "12月", "中間振り返り", "前半の学びの振り返り\n実践状況の共有・課題の整理", ""),
    ("第8回",  "1月",  "財務・数字力", "管理職に必要な財務知識\n数字で語る力", ""),
    ("第9回",  "2月",  "変革推進", "変革のマネジメント\n組織変革の進め方", "対象書籍④"),
    ("第10回", "3月",  "プレゼンテーション", "経営提案のプレゼン技術\n中間発表の準備", ""),
    ("第11回", "4月",  "総括・最終発表【合宿】", "1泊2日合宿\n最終プレゼンテーション\n今後のアクションプラン策定", ""),
    ("第12回", "5月",  "フォローアップ", "実践状況の振り返り\n今後の継続的成長に向けて", ""),
]

for i, (kai, month, theme, content, book) in enumerate(program_data):
    r = 5 + i
    is_camp = (i == 10)  # 第11回が合宿
    is_even = (i % 2 == 0)
    row_fill = gold_fill if is_camp else (very_light_blue_fill if is_even else white_fill)
    ws2.row_dimensions[r].height = 50 if is_camp else 38

    apply_style(ws2.cell(row=r, column=1, value=kai),
                font=normal_bold if is_camp else normal_font,
                fill=row_fill, border=border_all, alignment=center_align)
    apply_style(ws2.cell(row=r, column=2, value=month),
                font=normal_font, fill=row_fill, border=border_all, alignment=center_align)
    apply_style(ws2.cell(row=r, column=3, value=theme),
                font=normal_bold, fill=row_fill, border=border_all, alignment=left_align)
    apply_style(ws2.cell(row=r, column=4, value=content),
                font=small_font, fill=row_fill, border=border_all, alignment=left_align)
    apply_style(ws2.cell(row=r, column=5, value=book),
                font=small_font, fill=row_fill, border=border_all, alignment=center_align)

# 役割構成
r = 5 + len(program_data) + 1
ws2.merge_cells(f"A{r}:E{r}")
apply_style(ws2.cell(row=r, column=1, value="【参加者の役割構成（ご提案）】"),
            font=section_font, alignment=left_align)
ws2.row_dimensions[r].height = 30

roles = [
    ("塾生", "部長候補（次世代リーダー）", "最大12名（推奨）", "全回参加・必須"),
    ("コーディネーター", "現職部長クラス", "3名程度", "各グループの支援・伴走"),
    ("塾長（副塾長）", "役員・経営層", "1～2名", "オブザーブ参加"),
]

role_headers = ["役割", "対象者", "人数", "参加形態"]
r += 1
for col_idx, h in enumerate(role_headers, 1):
    cell = ws2.cell(row=r, column=col_idx, value=h)
    apply_style(cell, font=Font(name="游ゴシック", size=9, bold=True, color=WHITE),
                fill=blue_fill, border=border_all, alignment=center_align)
ws2.row_dimensions[r].height = 24

for idx, (role, target, count, style) in enumerate(roles):
    rr = r + 1 + idx
    row_fill = very_light_blue_fill if idx % 2 == 0 else white_fill
    apply_style(ws2.cell(row=rr, column=1, value=role),
                font=normal_bold, fill=row_fill, border=border_all, alignment=center_align)
    apply_style(ws2.cell(row=rr, column=2, value=target),
                font=normal_font, fill=row_fill, border=border_all, alignment=center_align)
    apply_style(ws2.cell(row=rr, column=3, value=count),
                font=normal_font, fill=row_fill, border=border_all, alignment=center_align)
    apply_style(ws2.cell(row=rr, column=4, value=style),
                font=normal_font, fill=row_fill, border=border_all, alignment=center_align)
    ws2.row_dimensions[rr].height = 26

# 印刷設定
ws2.sheet_properties.pageSetUpPr = openpyxl.worksheet.properties.PageSetupProperties(fitToPage=True)
ws2.page_setup.fitToWidth = 1
ws2.page_setup.fitToHeight = 1
ws2.page_setup.orientation = "portrait"
ws2.page_setup.paperSize = ws2.PAPERSIZE_A4

# ============================================================
# 保存
# ============================================================
output_path = "/home/user/first/clients/大晃産業/03_日程調整/日程調整表_大晃産業_v2.xlsx"
wb.save(output_path)
print(f"Done: {output_path}")
