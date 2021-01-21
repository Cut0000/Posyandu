<div class="row">
	<div class="col-md-12">
	    <div class="panel panel-info">
	        <div class="panel-heading"><h3 class="text-center">Laporan Nilai Seluruh Pasien</h3></div>
	        <div class="panel-body">
				<form class="form-inline" action="<?=$_SERVER["REQUEST_URI"]?>" method="post">
					<label for="bulan">Bulan :</label>
					<select class="form-control" name="bulan">
						<option>---</option>
						<option value="maret">Maret</option>
					</select>
					<button type="submit" class="btn btn-primary">Tampilkan</button>
				</form>
	            <?php if ($_SERVER["REQUEST_METHOD"] == "POST"): ?>
				<?php
				$q = $connection->query("SELECT b.id_penyakit, b.nama, h.nilai, m.nama AS pasien, m.id_pasien, (SELECT MAX(nilai) FROM hasil WHERE id_pasien=h.id_pasien) AS nilai_max FROM pasien m JOIN hasil h ON m.id_pasien=h.id_pasien JOIN penyakit b ON b.id_penyakit=h.id_penyakit WHERE m.bulan_periksa='$_POST[bulan]'");
				$penyakit = []; $data = []; $d = [];
				while ($r = $q->fetch_assoc()) {
					$penyakit[$r["id_penyakit"]] = $r["nama"];
					$s = $connection->query("SELECT b.nama, a.nilai FROM hasil a JOIN penyakit b USING(id_penyakit) WHERE a.id_pasien=$r[id_pasien] AND a.bulan='$_POST[bulan]'");
					while ($rr = $s->fetch_assoc()){
						$d[$rr['nama']] = $rr['nilai'];
					}
					$m = max($d);
					$k = array_search($m, $d);
					$data[$r["id_pasien"]."-".$r["pasien"]."-".$r["nilai_max"]."-".$k][$r["id_penyakit"]] = $r["nilai"];
				}
				?>
				<hr>
				<table class="table table-condensed">
	                <thead>
	                    <tr>
							<th>ID</th>
							<th>Nama</th>
							<?php foreach ($penyakit as $val): ?>
		                        <th><?=$val?></th>
							<?php endforeach; ?>
							<th>Nilai Maksimal</th>
							<th>Penyakit</th>
	                    </tr>
	                </thead>
					<tbody>
					<?php foreach($data as $key => $val): ?>
						<tr>
							<?php $x = explode("-", $key); ?>
							<td><?=$x[0]?></td>
							<td><?=$x[1]?></td>
							<?php foreach ($val as $v): ?>
								<td><?=number_format($v, 8)?></td>
							<?php endforeach; ?>
							<td><?=number_format($x[2], 8)?></td>
							<td><?=$x[3]?></td>
						</tr>
					<?php endforeach ?>
					</tbody>
		            </table>
	            <?php endif; ?>
	        </div>
	    </div>
	</div>
</div>
