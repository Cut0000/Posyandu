<?php
$update = (isset($_GET['action']) AND $_GET['action'] == 'update') ? true : false;
if ($update) {
	$sql = $connection->query("SELECT * FROM penilaian WHERE id_penilaian='$_GET[key]'");
	$row = $sql->fetch_assoc();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$validasi = false; $err = false;
	if ($update) {
		$sql = "UPDATE penilaian SET id_kriteria='$_POST[id_kriteria]', keterangan='$_POST[keterangan]', bobot='$_POST[bobot]' WHERE id_penilaian='$_GET[key]'";
	} else {
		$sql = "INSERT INTO penilaian VALUES (NULL, '$_POST[id_penyakit]', '$_POST[id_kriteria]', '$_POST[keterangan]', '$_POST[bobot]')";
		$validasi = true;
	}

	if ($validasi) {
		$q = $connection->query("SELECT id_penilaian FROM penilaian WHERE id_penyakit=$_POST[id_penyakit] AND id_kriteria=$_POST[id_kriteria] AND keterangan LIKE '%$_POST[keterangan]%' AND bobot=$_POST[bobot]");
		if ($q->num_rows) {
			echo alert("Penilaian sudah ada!", "?page=penilaian");
			$err = true;
		}
	}

  if (!$err AND $connection->query($sql)) {
    echo alert("Berhasil!", "?page=penilaian");
  } else {
		echo alert("Gagal!", "?page=penilaian");
  }
}

if (isset($_GET['action']) AND $_GET['action'] == 'delete') {
  $connection->query("DELETE FROM penilaian WHERE id_penilaian='$_GET[key]'");
	echo alert("Berhasil!", "?page=penilaian");
}
?>
<div class="row">
	<div class="col-md-4">
	    <div class="panel panel-<?= ($update) ? "warning" : "info" ?>">
	        <div class="panel-heading"><h3 class="text-center"><?= ($update) ? "EDIT" : "TAMBAH" ?></h3></div>
	        <div class="panel-body">
	            <form action="<?=$_SERVER['REQUEST_URI']?>" method="POST">
									<div class="form-group">
	                  <label for="id_penyakit">Penyakit</label>
										<select class="form-control" name="id_penyakit" id="penyakit">
											<option>---</option>
											<?php $sql = $connection->query("SELECT * FROM penyakit") ?>
											<?php while ($data = $sql->fetch_assoc()): ?>
												<option value="<?=$data["id_penyakit"]?>" <?= (!$update) ?: (($row["id_penyakit"] != $data["id_penyakit"]) ?: 'selected="selected"') ?>><?=$data["nama"]?></option>
											<?php endwhile; ?>
										</select>
									</div>
									<div class="form-group">
	                  <label for="id_kriteria">Kriteria</label>
										<select class="form-control" name="id_kriteria" id="kriteria">
											<option>---</option>
											<?php $sql = $connection->query("SELECT * FROM kriteria") ?>
											<?php while ($data = $sql->fetch_assoc()): ?>
												<option value="<?=$data["id_kriteria"]?>" class="<?=$data["id_penyakit"]?>" <?= (!$update) ?: (($row["id_kriteria"] != $data["id_kriteria"]) ?: 'selected="selected"') ?>><?=$data["nama"]?></option>
											<?php endwhile; ?>
										</select>
									</div>
	                <div class="form-group">
	                    <label for="keterangan">Keterangan</label>
	                    <input type="text" name="keterangan" class="form-control" <?= (!$update) ?: 'value="'.$row["keterangan"].'"' ?>>
	                </div>
	                <div class="form-group">
	                    <label for="bobot">Bobot</label>
	                    <input type="text" name="bobot" class="form-control" <?= (!$update) ?: 'value="'.$row["bobot"].'"' ?>>
	                </div>
	                <button type="submit" class="btn btn-<?= ($update) ? "warning" : "info" ?> btn-block">Simpan</button>
	                <?php if ($update): ?>
										<a href="?page=penilaian" class="btn btn-info btn-block">Batal</a>
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
	                        <th>Penyakit</th>
	                        <th>Kriteria</th>
	                        <th>Keterangan</th>
	                        <th>Bobot</th>
	                        <th></th>
	                    </tr>
	                </thead>
	                <tbody>
	                    <?php $no = 1; ?>
	                    <?php if ($query = $connection->query("SELECT a.id_penilaian, c.nama AS nama_penyakit, b.nama AS nama_kriteria, a.keterangan, a.bobot FROM penilaian a JOIN kriteria b ON a.id_kriteria=b.id_kriteria JOIN penyakit c ON a.id_penyakit=c.id_penyakit")): ?>
	                        <?php while($row = $query->fetch_assoc()): ?>
	                        <tr>
	                            <td><?=$no++?></td>
	                            <td><?=$row['nama_penyakit']?></td>
	                            <td><?=$row['nama_kriteria']?></td>
	                            <td><?=$row['keterangan']?></td>
	                            <td><?=$row['bobot']?></td>
	                            <td>
	                                <div class="btn-group">
	                                    <a href="?page=penilaian&action=update&key=<?=$row['id_penilaian']?>" class="btn btn-warning btn-xs">Edit</a>
	                                    <a href="?page=penilaian&action=delete&key=<?=$row['id_penilaian']?>" class="btn btn-danger btn-xs">Hapus</a>
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
</script>
