

SELECT a.*,STR_TO_DATE(DateTime,'%d/%m/%Y %H:%i:%s') AS formated, 
CASE
    WHEN In_out = 'masuk' 
    THEN FLOOR(GREATEST((TIME_TO_SEC(TIMEDIFF(a.Jam_Log,a.sift_masuk))/60),0))
	WHEN In_out = 'pulang' 
	THEN FLOOR(GREATEST((TIME_TO_SEC(TIMEDIFF(a.sift_keluar,a.Jam_Log))/60),0))
END AS telat
FROM `ta_log` a 
WHERE STR_TO_DATE(DateTime,'%d/%m/%Y')='$tanggal' AND In_out='pulang' AND nip='$nip'
ORDER BY (
CASE
    WHEN In_out = 'masuk' 
    THEN FLOOR(GREATEST((TIME_TO_SEC(TIMEDIFF(a.Jam_Log,a.sift_masuk))/60),0))
	WHEN In_out = 'pulang' 
	THEN FLOOR(GREATEST((TIME_TO_SEC(TIMEDIFF(a.sift_keluar,a.Jam_Log))/60),0))
END
) ASC LIMIT 1


