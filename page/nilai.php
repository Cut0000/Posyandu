<?php
$update = (isset($_GET['action']) AND $_GET['action'] == 'update') ? true : false;
if ($update) {
	$sql = $connection->query("SELECT * FROM nilai JOIN penilaian USING(id_kriteria) WHERE id_nilai='$_GET[key]'");
	$row = $sql->fetch_assoc();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" AND isset($_POST["save"])) {
	$validasi = false; $err = false;
	if ($update) {
		$sql = "UPDATE nilai SET id_kriteria='$_POST[id_kriteria]', id_pasien='$_POST[id_pasien]', nilai='$_POST[nilai]' WHERE id_nilai='$_GET[key]'";
	} else {
		$query = "INSERT INTO nilai VALUES ";
		foreach ($_POST["nilai"] as $id_kriteria => $nilai) {
			$query .= "(NULL, '$_POST[id_penyakit]', '$id_kriteria', '$_POST[id_pasien]', '$nilai'),";
		}
		$sql = rtrim($query, ',');
		$validasi = true;
	}

	if ($validasi) {
		foreach ($_POST["nilai"] as $id_kriteria => $nilai) {
			$q = $connection->query("SELECT id_nilai FROM nilai WHERE id_penyakit=$_POST[id_penyakit] AND id_kriteria=$id_kriteria AND id_pasien=$_POST[id_pasien] AND nilai LIKE '%$nilai%'");
			if ($q->num_rows) {
				echo alert("Nilai untuk ".$_POST["id_pasien"]." sudah ada!", "?page=nilai");
				$err = true;
			}
		}
	}

  if (!$err AND $connection->query($sql)) {
		echo alert("Berhasil!", "?page=nilai");
	} else {
		echo alert("Gagal!", "?page=nilai");
	}
}

if (isset($_GET['action']) AND $_GET['action'] == 'delete') {
  $connection->query("DELETE FROM nilai WHERE id_nilai='$_GET[key]'");
	echo alert("Berhasil!", "?page=nilai");
}
?>
<div class="row">
	<div class="col-md-4">
	    <div class="panel panel-<?= ($update) ? "warning" : "info" ?>">
	        <div class="panel-heading"><h3 class="text-center"><?= ($update) ? "EDIT" : "TAMBAH" ?></h3></div>
	        <div class="panel-body">
	            <form action="<?=$_SERVER["REQUEST_URI"]?>" method="post">
									<div class="form-group">
										<label for="id_pasien">Pasien</label>
										<?php if ($_POST): ?>
											<input type="text" name="id_pasien" value="<?=$_POST["id_pasien"]?>" class="form-control" readonly="on">
										<?php else: ?>
											<select class="form-control" name="id_pasien">
												<option>---</option>
												<?php $sql = $connection->query("SELECT * FROM pasien"); while ($data = $sql->fetch_assoc()): ?>
													<option value="<?=$data["id_pasien"]?>" <?= (!$update) ? "" : (($row["id_pasien"] != $data["id_pasien"]) ? "" : 'selected="selected"') ?>><?=$data["id_pasien"]?> | <?=$data["nama"]?></option>
												<?php endwhile; ?>
											</select>
										<?php endif; ?>
									</div>
									<div class="form-group">
	                  <label for="id_penyakit">Penyakit</label>
										<?php if ($_POST): ?>
											<?php $q = $connection->query("SELECT nama FROM penyakit WHERE id_penyakit=$_POST[id_penyakit]"); ?>
											<input type="text"value="<?=$q->fetch_assoc()["nama"]?>" class="form-control" readonly="on">
											<input type="hidden" name="id_penyakit" value="<?=$_POST["id_penyakit"]?>">
										<?php else: ?>
											<select class="form-control" name="id_penyakit" id="penyakit">
												<option>---</option>
												<?php $sql = $connection->query("SELECT * FROM penyakit"); while ($data = $sql->fetch_assoc()): ?>
													<option value="<?=$data["id_penyakit"]?>"<?= (!$update) ? "" : (($row["id_penyakit"] != $data["id_penyakit"]) ? "" : 'selected="selected"') ?>><?=$data["nama"]?></option>
												<?php endwhile; ?>
											</select>
										<?php endif; ?>
									</div>
									<?php if ($_POST): ?>
										<?php $q = $connection->query("SELECT * FROM kriteria WHERE id_penyakit=$_POST[id_penyakit]"); while ($r = $q->fetch_assoc()): ?>
				                <div class="form-group">
					                  <label for="nilai"><?=ucfirst($r["nama"])?></label>
														<select class="form-control" name="nilai[<?=$r["id_kriteria"]?>]" id="nilai">
															<option>---</option>
															<?php $sql = $connection->query("SELECT * FROM penilaian WHERE id_kriteria=$r[id_kriteria]"); while ($data = $sql->fetch_assoc()): ?>
																<option value="<?=$data["bobot"]?>" class="<?=$data["id_kriteria"]?>"<?= (!$update) ? "" : (($row["id_penilaian"] != $data["id_penilaian"]) ? "" : ' selected="selected"') ?>><?=$data["keterangan"]?></option>
															<?php endwhile; ?>
														</select>
				                </div>
										<?php endwhile; ?>
										<input type="hidden" name="save" value="true">
									<?php endif; ?>
	                <button type="submit" id="simpan" class="btn btn-<?= ($update) ? "warning" : "info" ?> btn-block"><?=($_POST) ? "Simpan" : "Tampilkan"?></button>
	                <?php if ($update): ?>
										<a href="?page=nilai" class="btn btn-info btn-block">Batal</a>
									<?php endif; ?>
	            </form>
	        </div>
	    </div>
	</div>
	<div class="col-md-8">
	    <div class="panel panel-info">
	        <div class="panel-heading"><h3 class="text-center">DAFTAR</h3></div>
	        <div class="panel-body">
	            <table class="table table-condensed">
	                <thead>
	                    <tr>
	                        <th>No</th>
													<th>ID</th>
													<th>Nama</th>
	                        <th>Penyakit</th>
	                        <th>Kriteria</th>
	                        <th>Nilai</th>
	                        <th></th>
	                    </tr>
	                </thead>
	                <tbody>
	                    <?php $no = 1; ?>
	                    <?php if ($query = $connection->query("SELECT a.id_nilai, c.nama AS nama_penyakit, b.nama AS nama_kriteria, d.id_pasien, d.nama AS nama_pasien, a.nilai FROM nilai a JOIN kriteria b ON a.id_kriteria=b.id_kriteria JOIN penyakit c ON a.id_penyakit=c.id_penyakit JOIN pasien d ON d.id_pasien=a.id_pasien")): ?>
	                        <?php while($row = $query->fetch_assoc()): ?>
	                        <tr>
	                            <td><?=$no++?></td>
															<td><?=$row['id_pasien']?></td>
															<td><?=$row['nama_pasien']?></td>
	                            <td><?=$row['nama_penyakit']?></td>
	                            <td><?=$row['nama_kriteria']?></td>
	                            <td><?=$row['nilai']?></td>
	                            <td>
	                                <div class="btn-group">
	                                    <a href="?page=nilai&action=update&key=<?=$row['id_nilai']?>" class="btn btn-warning btn-xs">Edit</a>
	                                    <a href="?page=nilai&action=delete&key=<?=$row['id_nilai']?>" class="btn btn-danger btn-xs">Hapus</a>
	                                </div>
	                            </td>
	                        </tr>
	                        <?php endwhile ?>
	                    <?php endif ?>
	                </tbody>
	            </table>
	        </div>
	    </div>
	</div>
</div>
<script type="text/javascript">
$("#kriteria").chained("#penyakit");
$("#nilai").chained("#kriteria");
</script>
