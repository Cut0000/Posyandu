<div class="row">
	<div class="col-md-12">
	    <div class="panel panel-info">
	        <div class="panel-heading"><h3 class="text-center">DAFTAR PENDAFTARAN</h3></div>
	        <div class="panel-body">
	            <table class="table table-condensed">
	                <thead>
	                    <tr>
	                        <th>No</th>
	                        <th>ID</th>
						    <th>Nama</th>
						    <th>Tanggal Lahir</th>
				            <th>Jenis Kelamin</th>
				            <th>Usia</th>
				            <th>Alamat</th>
				            <th>Riwayat Penyakit</th>
				            <th>Olahraga</th>
				            <th>Keluhan</th>
				            <th>Berat Badan</th>
				            <th>Tekanan Darah</th>
	                        <th>Bulan Periksa</th>
	                    </tr>
	                </thead>
	                <tbody>
	                    <?php $no = 1; ?>
	                    <?php if ($query = $connection->query("SELECT * FROM pasien WHERE id_pasien IN(SELECT id_pasien FROM nilai)")): ?>
	                        <?php while($row = $query->fetch_assoc()): ?>
	                        <tr>
	                            <td><?=$no++?></td>
															<td><?=$row["id_pasien"]?></td>
	                            <td><?=$row["nama"]?></td>
	                            <td><?=$row['tanggal_lahir']?></td>
	                            <td><?=$row['jenis_kelamin']?></td>
	                            <td><?=$row['usia']?></td>
	                            <td><?=$row['alamat']?></td>
	                            <td><?=$row['riwayat_penyakit']?></td>
	                            <td><?=$row['olahraga']?></td>
	                            <td><?=$row['keluhan']?></td>
	                            <td><?=$row['berat_badan']?></td>
	                            <td><?=$row['tekanan_darah']?></td>
	                            <td><?=$row['bulan_periksa']?></td>
	                        </tr>
	                        <?php endwhile ?>
	                    <?php endif ?>
	                </tbody>
	            </table>
	        </div>
	    </div>
	</div>
</div>
