<div class="row">
	<div class="col-md-12">
	    <div class="panel panel-info">
	        <div class="panel-heading"><h3 class="text-center">Laporan Nilai Per Pasien</h3></div>
	        <div class="panel-body">
							<form class="form-inline" action="<?=$_SERVER["REQUEST_URI"]?>" method="post">
								<label for="pasien">Pasien :</label>
								<select class="form-control" name="mhs">
									<option> --- </option>
									<?php $q = $connection->query("SELECT * FROM pasien WHERE id_pasien IN(SELECT id_pasien FROM hasil)"); while ($r = $q->fetch_assoc()): ?>
										<option value="<?=$r["id_pasien"]?>"><?=$r["id_pasien"]?> | <?=$r["nama"]?></option>
									<?php endwhile; ?>
								</select>
								<button type="submit" class="btn btn-primary">Tampilkan</button>
							</form>
	            <?php if ($_SERVER["REQUEST_METHOD"] == "POST"): ?>
								<?php
								$q = $connection->query("SELECT b.id_penyakit, b.nama, h.nilai, (SELECT MAX(nilai) FROM hasil WHERE id_pasien=h.id_pasien) AS nilai_max FROM pasien m JOIN hasil h ON m.id_pasien=h.id_pasien JOIN penyakit b ON b.id_penyakit=h.id_penyakit WHERE m.id_pasien=$_POST[mhs]");
								$penyakit = []; $data = [];
								while ($r = $q->fetch_assoc()) {
									$penyakit[$r["id_penyakit"]] = $r["nama"];
									$data[$r["id_penyakit"]][] = $r["nilai"];
									$max = $r["nilai_max"];
								}
								?>
								<hr>
								<table class="table table-condensed">
									<tbody>
										<?php $query = $connection->query("SELECT DISTINCT(p.id_penyakit), k.nama, n.nilai FROM nilai n JOIN penilaian p USING(id_kriteria) JOIN kriteria k USING(id_kriteria) WHERE n.id_pasien=$_POST[mhs] AND n.id_penyakit=1"); while ($r = $query->fetch_assoc()): ?>
											<tr>
												<th><?=$r["nama"]?></th>
												<td>: <?=number_format($r["nilai"], 8)?></td>
											</tr>
										<?php endwhile; ?>
									</tbody>
								</table>
								<hr>
								<table class="table table-condensed">
		                <thead>
		                    <tr>
													<?php foreach ($penyakit as $key => $val): ?>
			                        <th><?=$val?></th>
													<?php endforeach; ?>
													<th>Nilai Maksimal</th>
		                    </tr>
		                </thead>
		                <tbody>
											<tr>
                        <?php foreach($penyakit as $key => $val): ?>
	                        <?php foreach($data[$key] as $v): ?>
															<td><?=number_format($v, 8)?></td>
													<?php endforeach ?>
												<?php endforeach ?>
												<td><?=number_format($max, 8)?></td>
											</tr>
		                </tbody>
		            </table>
	            <?php endif; ?>
	        </div>
	    </div>
	</div>
</div>
