DELIMITER //

CREATE FUNCTION HITUNG_SKS_TOTAL_MAHASISWA(input_nim VARCHAR(10))
RETURNS INT
DETERMINISTIC
BEGIN
    DECLARE total_sks INT;
    SELECT SUM(mk.sks) INTO total_sks
    FROM KRSMahasiswa krs
    JOIN JadwalMengajar jm ON krs.kd_mk = jm.kd_mk AND krs.kd_ds = jm.kd_ds
    JOIN MataKuliah mk ON jm.kd_mk = mk.kd_mk
    WHERE krs.nim = input_nim;

    IF total_sks IS NULL THEN
        SET total_sks = 0;
    END IF;

    RETURN total_sks;
END //

DELIMITER ;