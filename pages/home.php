<div class="content-header">
	<h1>Beranda <small>Sistem Informasi Pemetaan UKM Provinsi NTT</small></h1>
</div>

<div class="content">
	<div class="row">

		<div class="col-lg-3">
			<div class="small-box bg-aqua">
				<div class="inner">
					<h3><?= count($db->get('pemilik_usaha')) ?></h3>
					<p>Pemilik Usaha</p>
				</div>
				<div class="icon">
					<i class="fas fa-users"></i>
				</div>
				<a href="index.php?page=pemilik-usaha" class="small-box-footer">Kunjungi <i class="fas fa-arrow-circle-right"></i></a>
			</div>
		</div>

		<div class="col-lg-3">
			<div class="small-box bg-green">
				<div class="inner">
					<h3><?= count($db->get('usaha')) ?></h3>
					<p>Usaha</p>
				</div>
				<div class="icon">
					<i class="fas fa-store"></i>
				</div>
				<a href="index.php?page=usaha" class="small-box-footer">Kunjungi <i class="fas fa-arrow-circle-right"></i></a>
			</div>
		</div>

		<div class="col-lg-3">
			<div class="small-box bg-orange">
				<div class="inner">
					<h3><?= count($db->get('jenis_usaha')) ?></h3>
					<p>Jenis Usaha</p>
				</div>
				<div class="icon">
					<i class="fab fa-accusoft"></i>
				</div>
				<a href="index.php?page=jenis-usaha" class="small-box-footer">Kunjungi <i class="fas fa-arrow-circle-right"></i></a>
			</div>
		</div>

		<div class="col-lg-3">
			<div class="small-box bg-red">
				<div class="inner">
					<h3><?= count($db->get('kecamatan')) ?></h3>
					<p>Kecamatan</p>
				</div>
				<div class="icon">
					<i class="fas fa-map"></i>
				</div>
				<a href="index.php?page=kecamatan" class="small-box-footer">Kunjungi <i class="fas fa-arrow-circle-right"></i></a>
			</div>
		</div>

	</div>
	<!-- end row -->
	<div class="row">
		<div class="col-lg-8">
			<div class="box box-primary">
				<div class="box-header with-border">
					<strong class="box-title">Grafik Menurut Jenis Usaha</strong>
				</div>
				<div class="box-body">
					<div style="width: 100%; height: 300px;">				
						<canvas id="chart1"></canvas>
					</div>
				</div>
			</div>
		</div>
		<div class="col-lg-4">
			<div class="box box-primary">
				<div class="box-header with-border">
					<strong class="box-title">Diagram Legalitas</strong>
				</div>
				<div class="box-body">
					<div style="width: 100%; height: 300px;">				
						<canvas id="chart2"></canvas>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end row -->
</div>


<script type="text/javascript">
	<?php 
	$labels = $db->rawQuery("SELECT nama_jenis FROM jenis_usaha");
	$data_label = [];
	foreach($labels as $label){
		$data_label[] = $label['nama_jenis'];
	}

	$data_count = [];
	foreach($db->get('jenis_usaha') as $jenis){
		$db->where('id_jenis', $jenis['id_jenis']);
		$count = count($db->get('usaha'));
		$data_count[] = $count;
	}

	$opacity = "0.5";
	$colors = [];
	for($i=0; $i<count($data_count);$i++){
		$colors[] = randomColor($opacity);
	}

	$borderColor = [];
	for($i=0; $i<count($colors);$i++){
		$borderColor[] = str_replace($opacity, '1', $colors[$i]);
	}
	?>

	function randomColor(){
		return "#" + Math.floor(Math.random()*16777215).toString(16);
	}

	var ctx = document.getElementById('chart1').getContext('2d');
	var chart = new Chart(ctx, {
		type: 'bar',
		data: {
			labels: <?= json_encode($data_label) ?>,
			datasets: [{
				label: 'Jenis Usaha',
				data: <?= json_encode($data_count) ?>,
				backgroundColor: <?= json_encode($colors) ?>, 
				borderColor: <?= json_encode($borderColor) ?>,
				borderWidth: 3,
				borderRadius: 3
			}]
		}, 
	});

	var ctx2 = document.getElementById('chart2').getContext('2d');
	var diagram = new Chart(ctx2, {
		type: 'pie',
		data: {
			labels: ['Legal', 'Tidak Legal'],
			datasets: [
				{
					label: 'Jumlah',
					data: [
						<?= count($db->where('legalitas', "1")->get('usaha')) ?>,
						<?= count($db->where('legalitas', "0")->get('usaha')) ?>,
					]
				}
			]
		}
	})
</script>