<?php
$update = (isset($_GET['action']) AND $_GET['action'] == 'update') ? true : false;
if ($update) {
	$sql = $connection->query("SELECT * FROM penyakit WHERE id_penyakit='$_GET[key]'");
	$row = $sql->fetch_assoc();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$validasi = false; $err = false;
	if ($update) {
		$sql = "UPDATE penyakit SET nama='$_POST[nama]' WHERE id_penyakit='$_GET[key]'";
	} else {
		$sql = "INSERT INTO penyakit VALUES (NULL, '$_POST[nama]')";
		$validasi = true;
	}

	if ($validasi) {
		$q = $connection->query("SELECT id_penyakit FROM penyakit WHERE nama LIKE '%$_POST[nama]%'");
		if ($q->num_rows) {
			echo alert("Penyakit sudah ada!", "?page=penyakit");
			$err = true;
		}
	}

  if (!$err AND $connection->query($sql)) {
    echo alert("Berhasil!", "?page=penyakit");
  } else {
		echo alert("Gagal!", "?page=penyakit");
  }
}

if (isset($_GET['action']) AND $_GET['action'] == 'delete') {
  $connection->query("DELETE FROM penyakit WHERE id_penyakit='$_GET[key]'");
	echo alert("Berhasil!", "?page=penyakit
		");
}
?>
<div class="row">
	<div class="col-md-4">
	    <div class="panel panel-<?= ($update) ? "warning" : "info" ?>">
	        <div class="panel-heading"><h3 class="text-center"><?= ($update) ? "EDIT" : "TAMBAH" ?></h3></div>
	        <div class="panel-body">
	            <form action="<?=$_SERVER['REQUEST_URI']?>" method="POST">
	                <div class="form-group">
	                    <label for="nama">Nama Penyakit</label>
	                    <input type="text" name="nama" class="form-control" <?= (!$update) ?: 'value="'.$row["nama"].'"' ?>>
	                </div>
	                <button type="submit" class="btn btn-<?= ($update) ? "warning" : "info" ?> btn-block">Simpan</button>
	                <?php if ($update): ?>
										<a href="?page=penyakit" class="btn btn-info btn-block">Batal</a>
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
	                        <th>Nama Penyakit</th>
	                        <th></th>
	                    </tr>
	                </thead>
	                <tbody>
	                    <?php $no = 1; ?>
	                    <?php if ($query = $connection->query("SELECT * FROM penyakit")): ?>
	                        <?php while($row = $query->fetch_assoc()): ?>
	                        <tr>
	                            <td><?=$no++?></td>
	                            <td><?=$row['nama']?></td>
	                            <td>
	                                <div class="btn-group">
	                                    <a href="?page=penyakit&action=update&key=<?=$row['id_penyakit']?>" class="btn btn-warning btn-xs">Edit</a>
	                                    <a href="?page=penyakit&action=delete&key=<?=$row['id_penyakit']?>" class="btn btn-danger btn-xs">Hapus</a>
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
