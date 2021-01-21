<?php
session_start();
require_once "config.php";
if (empty($_SESSION)) {
  header('location: login.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Penyakit</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <style>
        body {
            margin-top: 40px;
        }
    </style>
</head>
<body>
    <div class="container">
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a class="navbar-brand" href="#">Posyandu Sehat Jaya</a>
                </div>
            </div><!-- /.container-fluid -->
        </nav>
        <div class="row">
            <div class="col-md-12">
							<div class="row">
								<div class="col-md-12">
									<table class="table table-condensed">
			                <thead>
			                    <tr>
			                        <th>No</th>
			                        <th>Id Pasien</th>
            									<th>Nama</th>
            									<th>Penyakit</th>
			                        <th>Nilai</th>
			                        <th>Bulan</th>
			                        <th></th>
			                    </tr>
			                </thead>
			                <tbody>
			                    <?php $no = 1; ?>
			                    <?php if ($query = $connection->query("SELECT b.nama AS penyakit, a.id_pasien, a.nilai, a.bulan, c.nama FROM hasil a JOIN penyakit b USING(id_penyakit) JOIN pasien c ON a.id_pasien=c.id_pasien")): ?>
			                        <?php while($row = $query->fetch_assoc()): ?>
			                        <tr>
			                            <td><?=$no++?></td>
              										<td><?=$row["id_pasien"]?></td>
              										<td><?=$row["nama"]?></td>
			                            <td><?=$row["penyakit"]?></td>
			                            <td><?=number_format((float) $row["nilai"], 8, '.', '')?></td>
			                            <td><?=$row['bulan']?></td>
			                        </tr>
			                        <?php endwhile ?>
			                    <?php endif ?>
			                </tbody>
			            </table>
								</div>
							</div>
            </div>
        </div>
    </div>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
</body>
</html>
