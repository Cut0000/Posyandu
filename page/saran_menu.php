<div class="row">
	<div class="col-md-12">
	    <div class="panel panel-info">
	        <div class="panel-heading"><h3 class="text-center">SARAN MENU MAKANAN</h3></div>
	        <div class="panel-body">
	            <table class="table table-condensed">
	                <thead>
	                    <tr>
	                        <th>No</th>
	                        <th>Penyakit</th>
						    <th>Menu Makanan</th>
	                    </tr>
	                </thead>
	                <tbody>
	                    <?php $no = 1; ?>
	                    <?php if ($query = $connection->query("SELECT c.nama AS nama_penyakit, a.menu AS menu, a.id_penyakit FROM makanan a JOIN penyakit c ON a.id_penyakit=c.id_penyakit")): ?>
	                        <?php while($row = $query->fetch_assoc()): ?>
	                        <tr>
	                            <td><?=$no++?></td>
															
	                            <td><?=$row["nama_penyakit"]?></td>
	                          								  <td><?=$row['menu']?></td>
	                        </tr>
	                        <?php endwhile ?>
	                    <?php endif ?>
	                </tbody>
	            </table>
	        </div>
	    </div>
	</div>
</div>
