<div class="row">
	<div class="col-md-12">
	<?php if (isset($_GET["penyakit"])) {
		$sqlKriteria = "";
		$namaKriteria = [];
		$queryKriteria = $connection->query("SELECT a.id_kriteria, a.nama FROM kriteria a JOIN model b USING(id_kriteria) WHERE b.id_penyakit=$_GET[penyakit]");
		while ($kr = $queryKriteria->fetch_assoc()) {
			$sqlKriteria .= "SUM(
				IF(
					c.id_kriteria=".$kr["id_kriteria"].",
					IF(c.sifat='max', nilai.nilai/c.normalization, c.normalization/nilai.nilai), 0
				)
			) AS ".strtolower(str_replace(" ", "_", $kr["nama"])).",";
			$namaKriteria[] = strtolower(str_replace(" ", "_", $kr["nama"]));
		}
		$sql = "SELECT
			(SELECT nama FROM pasien WHERE id_pasien=ps.id_pasien) AS nama,
			(SELECT id_pasien FROM pasien WHERE id_pasien=ps.id_pasien) AS id_pasien,
			(SELECT bulan_periksa FROM pasien WHERE id_pasien=ps.id_pasien) AS bulan,
			$sqlKriteria
			SUM(
				IF(
						c.sifat = 'max',
						nilai.nilai / c.normalization,
						c.normalization / nilai.nilai
				) * c.bobot
			) AS rangking
		FROM
			nilai
			JOIN pasien ps USING(id_pasien)
			JOIN (
				SELECT
						nilai.id_kriteria AS id_kriteria,
						kriteria.sifat AS sifat,
						(
							SELECT bobot FROM model WHERE id_kriteria=kriteria.id_kriteria AND id_penyakit=penyakit.id_penyakit
						) AS bobot,
						ROUND(
							IF(kriteria.sifat='max', MAX(nilai.nilai), MIN(nilai.nilai)), 1
						) AS normalization
					FROM nilai
					JOIN kriteria USING(id_kriteria)
					JOIN penyakit ON kriteria.id_penyakit=penyakit.id_penyakit
					WHERE penyakit.id_penyakit=$_GET[penyakit]
				GROUP BY nilai.id_kriteria
			) c USING(id_kriteria)
		WHERE id_penyakit=$_GET[penyakit]
		GROUP BY nilai.id_pasien
		ORDER BY rangking DESC"; ?>
	  <div class="panel panel-info">
	      <div class="panel-heading"><h3 class="text-center"><h2 class="text-center"><?php $query = $connection->query("SELECT * FROM penyakit WHERE id_penyakit=$_GET[penyakit]"); echo $query->fetch_assoc()["nama"]; ?></h2></h3></div>
	      <div class="panel-body">
	          <table class="table table-condensed table-hover">
	              <thead>
	                  <tr>
							<th>Id</th>
							<th>Nama</th>
							<?php //$query = $connection->query("SELECT nama FROM kriteria WHERE kd_beasiswa=$_GET[beasiswa]"); while($row = $query->fetch_assoc()): ?>
								<!-- <th><?//=$row["nama"]?></th> -->
							<?php //endwhile ?>
							<th>Nilai</th>
	                  </tr>
	              </thead>
	              <tbody>
					<?php $query = $connection->query($sql); while($row = $query->fetch_assoc()): ?>
					<?php
					$rangking = number_format((float) $row["rangking"], 8, '.', '');
					$q = $connection->query("SELECT id_pasien FROM hasil WHERE id_pasien='$row[id_pasien]' AND id_penyakit='$_GET[penyakit]' AND bulan='$row[bulan]'");
					if (!$q->num_rows) {
					$connection->query("INSERT INTO hasil VALUES(NULL, '$_GET[penyakit]', '$row[id_pasien]', '".$rangking."', '$row[bulan]')");
					}
					?>
					<tr>
						<td><?=$row["id_pasien"]?></td>
						<td><?=$row["nama"]?></td>
						<?php for($i=0; $i<count($namaKriteria); $i++): ?>
						<!-- <th><?//=number_format((float) $row[$namaKriteria[$i]], 8, '.', '');?></th> -->
						<?php endfor ?>
						<td><?=$rangking?></td>
					</tr>
					<?php endwhile;?>
	              </tbody>
	          </table>
	      </div>
	  </div>
	<?php } else { ?>
		<h1>Penyakit belum dipilih...</h1>
	<?php } ?>
	</div>
</div>
