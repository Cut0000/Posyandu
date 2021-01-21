<?php
$update = (isset($_GET['action']) AND $_GET['action'] == 'update') ? true : false;
if ($update) {
	$sql = $connection->query("SELECT * FROM makanan WHERE id_makanan='$_GET[key]'");
	$row = $sql->fetch_assoc();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$validasi = false; $err = false;
	if ($update) {
		$sql = "UPDATE makanan SET id_penyakit='$_POST[id_penyakit]', menu='$_POST[menu]' WHERE id_makanan='$_GET[key]'";
	} else {
		$sql = "INSERT INTO makanan VALUES (NULL, '$_POST[id_penyakit]', '$_POST[menu]')";
		$validasi = true;
	}

	if ($validasi) {
		$q = $connection->query("SELECT id_makanan FROM makanan WHERE id_penyakit=$_POST[id_penyakit]'");
		if ($q->num_rows) {
			echo alert("Menu Makanan sudah ada!", "?page=data_menu");
			$err = true;
		}
	}

  if (!$err AND $connection->query($sql)) {
		echo alert("Berhasil!", "?page=data_menu");
	} else {
		echo alert("Gagal!", "?page=data_menu");
	}
}

if (isset($_GET['action']) AND $_GET['action'] == 'delete') {
  $connection->query("DELETE FROM makanan WHERE id_makanan='$_GET[key]'");
	echo alert("Berhasil!", "?page=data_menu");
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
												<option value="<?=$data["id_penyakit"]?>"<?= (!$update) ?: (($row["id_penyakit"] != $data["id_penyakit"]) ?: ' selected="on"') ?>><?=$data["nama"]?></option>
											<?php endwhile; ?>
										</select>
									</div>
									<div class="form-group">
	                                <label for="menu">Menu Makanan</label>
	                                <input type="textarea" name="menu" class="form-control" <?= (!$update) ?: 'value="'.$row["menu"].'"' ?>>
	                                      </div>
					
	                <button type="submit" class="btn btn-<?= ($update) ? "warning" : "info" ?> btn-block">Simpan</button>
	                <?php if ($update): ?>
										<a href="?page=model" class="btn btn-info btn-block">Batal</a>
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
	                        <th>Saran Menu Makanan</th>
	                           <th></th>
	                    </tr>
	                </thead>
	                <tbody>
	                    <?php $no = 1; ?>
	                    <?php if ($query = $connection->query("SELECT c.nama AS nama_penyakit, a.menu AS menu, a.id_makanan, a.id_penyakit FROM makanan a JOIN penyakit c ON a.id_penyakit=c.id_penyakit")): ?>
	                        <?php while($row = $query->fetch_assoc()): ?>
	                        <tr>
	                            <td><?=$no++?></td>
								<td><?=$row['nama_penyakit']?></td>
	                            <td><?=$row['menu']?></td>
	                            <td>
	                                <div class="btn-group">
	                                    <a href="?page=data_menu&action=update&key=<?=$row['id_makanan']?>" class="btn btn-warning btn-xs">Edit</a>
	                                    <a href="?page=data_menu&action=delete&key=<?=$row['id_makanan']?>" class="btn btn-danger btn-xs">Hapus</a>
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
$("#penyakit").chained("#data_menu");
</script>
