DELIMITER //


CREATE FUNCTION FORMAT_NAMA_DOSEN(nama_dosen VARCHAR(255))
RETURNS VARCHAR(260)
DETERMINISTIC
BEGIN
    -- Karena tabel dosen Anda tidak memiliki kolom jenis_kelamin, kita gunakan awalan generik
    RETURN CONCAT('Bpk./Ibu. ', nama_dosen);
END //

DELIMITER ;