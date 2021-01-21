<?php
$update = (isset($_GET['action']) AND $_GET['action'] == 'update') ? true : false;
if ($update) {
	$sql = $connection->query("SELECT * FROM pasien WHERE id_pasien='$_GET[key]'");
	$row = $sql->fetch_assoc();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$validasi = false; $err = false;
	if ($update) {
		$sql = "UPDATE pasien SET id_pasien='$_POST[id_pasien]', nama='$_POST[nama]',tanggal_lahir='$_POST[tanggal_lahir]', jenis_kelamin='$_POST[jenis_kelamin]',usia='$_POST[usia]',alamat='$_POST[alamat]',riwayat_penyakit='$_POST[riwayat_penyakit]',olahraga='$_POST[olahraga]',keluhan='$_POST[keluhan]',berat_badan='$_POST[berat_badan]', tekanan_darah='$_POST[tekanan_darah]', bulan_periksa='".date("F")."' WHERE id_pasien='$_GET[key]'";
	} else {
		$sql = "INSERT INTO pasien VALUES ('$_POST[id_pasien]', '$_POST[nama]', '$_POST[tanggal_lahir]', '$_POST[jenis_kelamin]','$_POST[usia]','$_POST[alamat]','$_POST[riwayat_penyakit]','$_POST[olahraga]', '$_POST[keluhan]', '$_POST[berat_badan]', '$_POST[tekanan_darah]','".date("F")."')";
		$validasi = true;
	}

	if ($validasi) {
		$q = $connection->query("SELECT id_pasien FROM pasien WHERE id_pasien=$_POST[id_pasien]");
		if ($q->num_rows) {
			echo alert($_POST["id_pasien"]." sudah terdaftar!", "?page=pasien");
			$err = true;
		}
	}

  if (!$err AND $connection->query($sql)) {
    echo alert("Berhasil!", "?page=pasien");
  } else {
		echo alert("Gagal!", "?page=pasien");
  }
}

if (isset($_GET['action']) AND $_GET['action'] == 'delete') {
  $connection->query("DELETE FROM pasien WHERE id_pasien=$_GET[key]");
	echo alert("Berhasil!", "?page=pasien");
}
?>
<div class="row">
	<div class="col-md-4">
	    <div class="panel panel-<?= ($update) ? "warning" : "info" ?>">
	        <div class="panel-heading"><h3 class="text-center"><?= ($update) ? "EDIT" : "TAMBAH" ?></h3></div>
	        <div class="panel-body">
	            <form action="<?=$_SERVER['REQUEST_URI']?>" method="POST">
	                <div class="form-group">
	                    <label for="id_pasien">ID</label>
	                    <input type="text" name="id_pasien" class="form-control" <?= (!$update) ?: 'value="'.$row["id_pasien"].'"' ?>>
	                </div>
	                <div class="form-group">
	                    <label for="nama">Nama Lengkap</label>
	                    <input type="text" name="nama" class="form-control" <?= (!$update) ?: 'value="'.$row["nama"].'"' ?>>
	                </div>
	                <div class="form-group">
	                    <label for="tanggal_lahir">Tanggal Lahir</label>
	                    <input type="date" name="tanggal_lahir" class="form-control" <?= (!$update) ?: 'value="'.$row["tanggal_lahir"].'"' ?>>
	                </div>
	                			<div class="form-group">
	                  <label for="jenis_kelamin">Jenis Kelamin</label>
										<select class="form-control" name="jenis_kelamin">
											<option>---</option>
											<option value="Laki-laki" <?= (!$update) ?: (($row["jenis_kelamin"] != "Laki-laki") ?: 'selected="on"') ?>>Laki-laki</option>
											<option value="Perempuan" <?= (!$update) ?: (($row["jenis_kelamin"] != "Perempuan") ?: 'selected="on"') ?>>Perempuan</option>
										</select>
									</div>
				    <div class="form-group">
	                    <label for="usia">Usia</label>
	                    <input type="number" name="usia" class="form-control" <?= (!$update) ?: 'value="'.$row["usia"].'"' ?>>
	                </div>
	                <div class="form-group">
	                    <label for="alamat">Alamat</label>
	                    <input type="text" name="alamat" class="form-control" <?= (!$update) ?: 'value="'.$row["alamat"].'"' ?>>
	                </div>
						<div class="form-group">
	                    <label for="riwayat_penyakit">Riwayat Penyakit</label>
	                    <input type="text" name="riwayat_penyakit" class="form-control" <?= (!$update) ?: 'value="'.$row["riwayat_penyakit"].'"' ?>>
	                </div>
	                <div class="form-group">
	                    <label for="olahraga">Olahraga</label>
	                    <input type="text" name="olahraga" class="form-control" <?= (!$update) ?: 'value="'.$row["olahraga"].'"' ?>>
	                </div>
	                <div class="form-group">
	                    <label for="keluhan">Keluhan</label>
	                    <input type="text" name="keluhan" class="form-control" <?= (!$update) ?: 'value="'.$row["keluhan"].'"' ?>>
	                </div>
	                <div class="form-group">
	                    <label for="berat_badan">Berat Badan</label>
	                    <input type="text" name="berat_badan" class="form-control" <?= (!$update) ?: 'value="'.$row["berat_badan"].'"' ?>>
	                </div>
	                <div class="form-group">
	                    <label for="tekanan_darah">Tekanan Darah</label>
	                    <input type="text" name="tekanan_darah" class="form-control" <?= (!$update) ?: 'value="'.$row["tekanan_darah"].'"' ?>>
	                </div>
	                <button type="submit" class="btn btn-<?= ($update) ? "warning" : "info" ?> btn-block">Simpan</button>
	                <?php if ($update): ?>
										<a href="?page=pasien" class="btn btn-info btn-block">Batal</a>
									<?php endif; ?>
	            </form>
	        </div>
	    </div>
	</div>
	<div class="col-md-8">
	    <div class="panel panel-info">
	        <div class="panel-heading"><h3 class="text-center">DAFTAR PASIEN</h3></div>
	        <div class="panel-body">
	            <table class="table table-condensed">
	                <thead>
	                    <tr>
	                        <th>No</th>
	                        <th>ID</th>
	                        <th>Nama</th>
	                        <th>Jenis Kelamin</th>
	                        <td>Usia</td>
	                        <th>Alamat</th>
	                        <th>Riwayat</th>
	                        <th>Olahraga</th>
	                        <th>Keluhan</th>
	                        <th>BB</th>
	                        <th>TD</th>
	                        <th>Bulan Periksa</th>
	                        <th></th>
	                    </tr>
	                </thead>
	                <tbody>
	                    <?php $no = 1; ?>
	                    <?php if ($query = $connection->query("SELECT * FROM pasien")): ?>
	                        <?php while($row = $query->fetch_assoc()): ?>
	                        <tr>
	                            <td><?=$no++?></td>
	                            <td><?=$row['id_pasien']?></td>
	                            <td><?=$row['nama']?></td>
	                            <td><?=$row['jenis_kelamin']?></td>
	                            <td><?=$row['usia']?></td>
	                            <td><?=$row['alamat']?></td>
	                            <td><?=$row['riwayat_penyakit']?></td>
	                            <td><?=$row['olahraga']?></td>
	                            <td><?=$row['keluhan']?></td>
	                            <td><?=$row['berat_badan']?></td>
	                            <td><?=$row['tekanan_darah']?></td>
	                            <td><?=$row['bulan_periksa']?></td>
	                            <td>
	                                <div class="btn-group">
	                                    <a href="?page=pasien&action=update&key=<?=$row['id_pasien']?>" class="btn btn-warning btn-xs">Edit</a>
	                                    <a href="?page=pasien&action=delete&key=<?=$row['id_pasien']?>" class="btn btn-danger btn-xs">Hapus</a>
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
