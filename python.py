from openpyxl import Workbook
import random
from datetime import datetime, timedelta

wb = Workbook()
ws = wb.active

columns = [
    "qr_code","child_name","Ayah_name","Ibu_name","whatsapp_number",
    "birth_date","address","region","reference_source",
    "id_card_photo_path","is_distributed","distributed_at","created_at",
    "updated_at","registrasi","has_circumcision","has_received_gift",
    "has_photo_booth"
]

ws.append(columns)

names = ["Adit","Bima","Cici","Dina","Eka","Fajar","Gina","Hana"]
ayah = ["Andi","Budi","Candra","Dedi","Eko"]
ibu = ["Ani","Bella","Citra","Dewi","Eli"]
refs = ["RT","RW","Sekolah"]

regions = [
    "Klojen","Lowokwaru","Sukun","Blimbing","Kedungkandang",
    "Dinoyo","Sumbersari","Sawojajar","Tlogomas"
]

for i in range(1000):
    qr = f"QR{i+1:05d}"
    child = random.choice(names)
    ay = random.choice(ayah)
    ib = random.choice(ibu)
    wa = f"08{random.randint(100000000, 999999999)}"
    bdate = datetime(2010,1,1) + timedelta(days=random.randint(0, 4000))
    addr = f"Jl. Contoh No.{random.randint(1,200)}"
    region = random.choice(regions)
    ref = random.choice(refs)
    idpath = f"/photos/id_{i+1}.jpg"

    row = [
        qr, child, ay, ib, wa,
        bdate.strftime("%Y-%m-%d"), addr, region, ref,
        idpath, "", "", "", "",
        0, 0, 0, 0
    ]
    ws.append(row)

filepath = "C:\\laragon\\www\\sesama-v2\\recipient_1000_regions_final.xlsx"
wb.save(filepath)

filepath
