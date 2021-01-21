-- Normalisasi
SELECT
	nilai.id_kriteria,
    kriteria.sifat,
    (SELECT bobot FROM model WHERE id_kriteria=kriteria.id_kriteria AND id_penyakit=penyakit.id_penyakit) AS bobot,
	ROUND(IF(kriteria.sifat='max', MAX(nilai.nilai), MIN(nilai.nilai)), 1) AS normalization
FROM nilai
JOIN kriteria USING(id_kriteria)
JOIN penyakit ON penyakit.id_penyakit=penyakit.id_penyakit
WHERE penyakit.id_penyakit=1
GROUP BY nilai.id_kriteria

-- Rangking
SELECT
	(SELECT nama FROM pasien WHERE id_pasien=pasien.id_pasien) AS nama,
	(SELECT id_pasien FROM pasien WHERE id_pasien=pasien.id_pasien) AS id_pasien,
	(SELECT bulan FROM pasien WHERE id_pasien=pasien.id_pasien) AS bulan,
	SUM(
		IF(
				c.sifat = 'max',
				nilai.nilai / c.normalization,
				c.normalization / nilai.nilai
		) * c.bobot
	) AS rangking
FROM
	nilai
	JOIN pasien pasien USING(id_pasien)
	JOIN (
		SELECT
			nilai.id_kriteria,
		    kriteria.sifat,
		    (SELECT bobot FROM model WHERE id_kriteria=kriteria.id_kriteria AND id_penyakit=penyakit.id_penyakit) AS bobot,
			ROUND(IF(kriteria.sifat='max', MAX(nilai.nilai), MIN(nilai.nilai)), 1) AS normalization
		FROM nilai
		JOIN kriteria USING(kd_kriteria)
		JOIN penyakit ON kriteria.id_penyakit=penyakit.id_penyakit
		WHERE penyakit.id_penyakit=1
		GROUP BY nilai.id_kriteria
	) c USING(id_kriteria)
WHERE id_penyakit=1
GROUP BY nilai.id_pasien
ORDER BY rangking DESC

-- Rangking dengan menampilkan nilai perkriteria
SELECT
	(SELECT nama FROM pasien WHERE id_pasien=pasien.id_pasien) AS nama,
	(SELECT id_pasien FROM pasien WHERE id_pasien=pasien.id_pasien) AS nim,
	(SELECT bulan FROM pasien WHERE id_pasien=pasien.id_pasien) AS bulan,
	SUM(
		IF(
			c.kd_kriteria=1,
			IF(c.sifat='max', nilai.nilai/c.normalization, c.normalization / nilai.nilai), 0
		)
	) AS C1,
	SUM(
		IF(
			c.kd_kriteria=2,
			IF(c.sifat='max', nilai.nilai/c.normalization, c.normalization / nilai.nilai), 0
		)
	) AS C2,
	SUM(
		IF(
			c.kd_kriteria=3,
			IF(c.sifat='max', nilai.nilai/c.normalization, c.normalization / nilai.nilai), 0
		)
	) AS C3,
	SUM(
		IF(
				c.sifat = 'max',
				nilai.nilai / c.normalization,
				c.normalization / nilai.nilai
		) * c.bobot
	) AS rangking
FROM
	nilai
	JOIN pasien pasien USING(id_pasien)
	JOIN (
		SELECT
			nilai.id_kriteria,
		    kriteria.sifat,
		    (SELECT bobot FROM model WHERE id_kriteria=kriteria.id_kriteria AND =penyakit.id_penyakit) AS bobot,
			ROUND(IF(kriteria.sifat='max', MAX(nilai.nilai), MIN(nilai.nilai)), 1) AS normalization
		FROM nilai
		JOIN kriteria USING(id_kriteria)
		JOIN penyakit ON kriteria.id_penyakit=penyakit.id_penyakit
		WHERE penyakit.id_penyakit=1
		GROUP BY nilai.id_kriteria
	) c USING(id_kriteria)
WHERE id_penyakit=1
GROUP BY nilai.id_pasien
ORDER BY rangking DESC
