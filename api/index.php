<pre>

Welcome to Restfull API All Staff pakpakbharatkab.go.id
-----------------------------------------------------------------------------------------------------

I.Get staff data by NIP
---------------------------
Required : NIP
base_url()/staf.php?NIP=[NIP]

Ex:
http://localhost/api_sibahanpe/staff.php?NIP=198309272011011009

Result:

{
"count": 1,
"FID": "1224",
"NIP": "198309272011011009",
"NAMA": "SALIH NIKMAT BERUTU",
"NPWP": "161609383128000",
"PANGKAT": "PENGATUR  MUDA TK.I",
"GOL": "II",
"JABATAN": "JFU. TEKNISI ALAT ELEKTRO DAN ALAT KOMUNIKASI",
"ID_OPD": "12",
"OPD": "DINAS KOMUNIKASI DAN INFORMATIKA",
"PASS": "198309272011011009"
}




II.Get all staff data 
------------------------------------------------------------------------------------

base_url()/all_staf.php

Ex:
http://localhost/api_sibahanpe/all_staff.php

Result:

[
{
"FID": "1001",
"NIP": "196205241984031006",
"NAMA": "Manurung Naiborhu, S.Pd, MM",
"NPWP": "770537009128000",
"PANGKAT": "PEMBINA UTAMA MUDA",
"GOL": "IV ",
"JABATAN": "Kepala Dinas",
"ID_OPD": "10",
"OPD": "DINAS PEMBERDAYAAN PEREMPUAN, PERLINDUNGAN ANAK DAN PEMERINTAHAN DESA"
},
{
"FID": "1117",
"NIP": "197805282006041015",
"NAMA": "Sapril Limbong, SST",
"NPWP": "579673542128000",
"PANGKAT": "PENATA MUDA ",
"GOL": "III",
"JABATAN": "Staf Bidang Sosial",
"ID_OPD": "11",
"OPD": "DINAS SOSIAL"
},
{
"FID": "1201",
"NIP": "197510252003121003",
"NAMA": "ARYANTO TINAMBUNAN, SP, MSi",
"NPWP": "5766336895128000",
"PANGKAT": "PEMBINA",
"GOL": "IV",
"JABATAN": "Plt. KEPALA DINAS",
"ID_OPD": "12",
"OPD": "DINAS KOMUNIKASI DAN INFORMATIKA"
},
.....
]



II.Get All OPD
----------------------------------------------------------------------------------------------------
base_url()/opd.php

Ex:
http://localhost/api_sibahanpe/opd.php

Result:

[
{
"ID_OPD": "10",
"OPD": "DINAS PEMBERDAYAAN PEREMPUAN, PERLINDUNGAN ANAK DAN PEMERINTAHAN DESA"
},
{
"ID_OPD": "11",
"OPD": "DINAS SOSIAL"
},
{
"ID_OPD": "12",
"OPD": "DINAS KOMUNIKASI DAN INFORMATIKA"
},
{
"ID_OPD": "13",
"OPD": "DINAS PARIWISATA"
},
....
]




















</pre>