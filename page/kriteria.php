<?php
$update = (isset($_GET['action']) AND $_GET['action'] == 'update') ? true : false;
if ($update) {
	$sql = $connection->query("SELECT * FROM kriteria WHERE id_kriteria='$_GET[key]'");
	$row = $sql->fetch_assoc();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$validasi = false; $err = false;
	if ($update) {
		$sql = "UPDATE kriteria SET id_penyakit=$_POST[id_penyakit], nama='$_POST[nama]', sifat='$_POST[sifat]' WHERE id_kriteria='$_GET[key]'";
	} else {
		$sql = "INSERT INTO kriteria VALUES (NULL, $_POST[id_penyakit], '$_POST[nama]', '$_POST[sifat]')";
		$validasi = true;
	}

	if ($validasi) {
		$q = $connection->query("SELECT id_kriteria FROM kriteria WHERE id_penyakit=$_POST[id_penyakit] AND nama LIKE '%$_POST[nama]%'");
		if ($q->num_rows) {
			echo alert("Kriteria sudah ada!", "?page=kriteria");
			$err = true;
		}
	}

  if (!$err AND $connection->query($sql)) {
		echo alert("Berhasil!", "?page=kriteria");
	} else {
		echo alert("Gagal!", "?page=kriteria");
	}
}

if (isset($_GET['action']) AND $_GET['action'] == 'delete') {
  $connection->query("DELETE FROM kriteria WHERE id_kriteria='$_GET[key]'");
	echo alert("Berhasil!", "?page=kriteria");
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
										<select class="form-control" name="id_penyakit">
											<option>---</option>
											<?php $query = $connection->query("SELECT * FROM penyakit"); while ($data = $query->fetch_assoc()): ?>
												<option value="<?=$data["id_penyakit"]?>" <?= (!$update) ?: (($row["id_penyakit"] != $data["id_penyakit"]) ?: 'selected="on"') ?>><?=$data["nama"]?></option>
											<?php endwhile; ?>
										</select>
									</div>
	                <div class="form-group">
	                    <label for="nama">Kriteria</label>
	                    <input type="text" name="nama" class="form-control" <?= (!$update) ?: 'value="'.$row["nama"].'"' ?>>
	                </div>
									<div class="form-group">
	                  <label for="sifat">Sifat</label>
										<select class="form-control" name="sifat">
											<option>---</option>
											<option value="min" <?= (!$update) ?: (($row["sifat"] != "min") ?: 'selected="on"') ?>>Min</option>
											<option value="max" <?= (!$update) ?: (($row["sifat"] != "max") ?: 'selected="on"') ?>>Max</option>
										</select>
									</div>
	                <button type="submit" class="btn btn-<?= ($update) ? "warning" : "info" ?> btn-block">Simpan</button>
	                <?php if ($update): ?>
										<a href="?page=kriteria" class="btn btn-info btn-block">Batal</a>
									<?php endif; ?>
	            </form>
	        </div>
	    </div>
	</div>
	<div class="col-md-8">
	    <div class="panel panel-info">
	        <div class="panel-heading"><h3 class="text-center">DAFTAR KRITERIA</h3></div>
	        <div class="panel-body">
	            <table class="table table-condensed">
	                <thead>
	                    <tr>
	                        <th>No</th>
	                        <th>Penyakit</th>
	                        <th>Kriteria</th>
	                        <th>Sifat</th>
	                        <th></th>
	                    </tr>
	                </thead>
	                <tbody>
	                    <?php $no = 1; ?>
	                    <?php if ($query = $connection->query("SELECT a.nama AS kriteria, b.nama AS penyakit, a.id_kriteria, a.sifat FROM kriteria a JOIN penyakit b USING(id_penyakit)")): ?>
	                        <?php while($row = $query->fetch_assoc()): ?>
	                        <tr>
	                            <td><?=$no++?></td>
	                            <td><?=$row['penyakit']?></td>
	                            <td><?=$row['kriteria']?></td>
	                            <td><?=$row['sifat']?></td>
	                            <td>
	                                <div class="btn-group">
	                                    <a href="?page=kriteria&action=update&key=<?=$row['id_kriteria']?>" class="btn btn-warning btn-xs">Edit</a>
	                                    <a href="?page=kriteria&action=delete&key=<?=$row['id_kriteria']?>" class="btn btn-danger btn-xs">Hapus</a>
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
