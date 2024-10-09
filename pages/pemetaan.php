<div class="content-header">
  <h1>Pemetaan <small>Lihat Peta Lokasi UKM</small></h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fas fa-home"></i> Home</a></li>
    <li class="active">Pemetaan</li>
  </ol>
</div>

<div class="content">
	<div style="">		
		<div class="box box-primary">
			<div class="box-header">
				<strong class="box-title">Peta Lokasi</strong>
			</div>
			<div class="box-body">
				<div class="canvas-container">
					<div class="canvas-nav">
						<div style="margin-bottom: .5em;">
							<label>Jenis Usaha</label>
							<select class="form-control" id="jenis">
								<option value="">Semua Jenis Usaha</option>
								<?php  
								foreach($db->get('jenis_usaha') as $ju){
									echo "<option value='$ju[id_jenis]'>$ju[nama_jenis]</option>";
								}
								?>
							</select>
						</div>
						<div style="margin-bottom: .5em;">
							<label>Legalitas</label>
							<select class="form-control" id="legalitas">
								<option value="">Semua</option>
								<option value="0">Tidak Legal</option>
								<option value="1">Legal</option>
							</select>
						</div>
						<div style="display: flex; flex-direction: column;">
							<input type="text" class="form-control mr-1" id="query" placeholder="Cari Usaha" style="margin-bottom: 5px;">
							<button class="btn btn-primary" style="margin-bottom: .5em;" onclick="getList()">Cari</button>
							<button class="btn btn-default" style="margin-bottom: .5em;" onclick="resetFilter()">Reset</button>
						</div>
						<div class="list-container">
							<div id="listings"></div>
						</div>
					</div>
					<div class="canvas-map" style="flex-grow: 1;">
						<div id="map" style="width: 100%; height: 500px;"></div>
					</div>
					<div class="canvas-details collapsed">
						<div class="details-content">
							<a href="#" class="details-close" onclick="event.preventDefault(); hideDetails()">x</a>
							<img src="" class="details-image" style="width: 100%;">
							<div class="details-content-inner" style="padding: 5px 10px 10px;">
								<h4 class="details-title" style="margin: 0px;"></h4>
								<div class="details-section">
									<strong>Alamat</strong>
									<span class="details-address"></span>
								</div>
								<div class="details-section">
									<strong>Pemilik</strong>
									<span class="details-owner"></span>
								</div>
								<div class="details-section">
									<strong>Tanggal Operasi</strong>
									<span class="details-date"></span>
								</div>
								<div class="details-section">
									<strong>Legalitas</strong>
									<span class="details-legal"></span>
								</div>
								<div class="details-section">
									<strong>Aset</strong>
									<span class="details-aset"></span>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	mapboxgl.accessToken = '<?= MAPBOX_TOKEN ?>';
	var markers = [];
	const map = new mapboxgl.Map({
		container: 'map', // container ID
		center: [123.58057, -10.18096], // starting position [lng, lat]. Note that lat must be set between -90 and 90 
		zoom: 11, // starting zoom
		style: 'mapbox://styles/mapbox/streets-v12'
	});

	function resetFilter(){
		$('#jenis').val('').trigger('change');
		$('#legalitas').val('').trigger('change');
		$('#query').val('');

		getList();
	}

	function getList(){
		var uri = new URL('<?= base_url() ?>proses/pemetaan.php');
		var query = $('#query').val();
		var jenis = $('#jenis').val();
		var legalitas = $('#legalitas').val();

		if(query !== '')
			uri.searchParams.append('q', query);
		if(jenis !== '')
			uri.searchParams.append('j', jenis);
		if(legalitas !== '')
			uri.searchParams.append('l', legalitas);

		axios.get(uri)
			.then(function(response){
				buildLocation(response.data);
				addMarkers(response.data);
			})
	}

	function addMarkers(stores){
		clearMarker();
		for(const marker of stores.features){
			const el = document.createElement('div');
			el.id = `marker-${marker.properties.id}`;
			el.className = 'marker';
			el.setAttribute("style", `border: none;cursor: pointer;height: 24px;width: 24px; background-image: url(${marker.properties.ikon});background-size: 24px 24px;`);

			var mk = new mapboxgl.Marker(el, {offset: [0, -23]})
				.setLngLat(marker.geometry.coordinates)
				.addTo(map);

			el.addEventListener('click', (e) => {
				showDetails(marker);
				flyToStore(marker);

				const activeItem = document.getElementsByClassName('active');
				e.stopPropagation();
				if (activeItem[0]) {
					activeItem[0].classList.remove('active');
				}
				const listing = document.getElementById(`listing-${marker.properties.id}`);
				listing.classList.add('active');
			});

			markers.push(mk);
		}
	}

	function buildLocation(stores){ 
		$('#listings').html('');
		for(const store of stores.features){
			const listings = document.getElementById('listings');
			const link = listings.appendChild(document.createElement('a'));
			link.id = `link-${store.properties.id}`;
			link.className = 'list-item';
			link.innerHTML = `${store.properties.nama_usaha}`;

			link.addEventListener('click', function(){
				const activeItem = document.getElementsByClassName('active');
				if(activeItem[0])
					activeItem[0].classList.remove('active');
				for(const feature of stores.features){
					if(this.id === `link-${feature.properties.id}`){
						this.classList.add('active');
						showDetails(feature);
						flyToStore(feature);
					}
				}
			})
		}
	}

	function clearMarker(){
		if (markers!==null) {
		    for (var i = markers.length - 1; i >= 0; i--) {
		      markers[i].remove();
		    }
		}
	}

	function flyToStore(currentFeature){
		map.flyTo({
			center: currentFeature.geometry.coordinates,
			zoom: 15
		});
	}


	function showDetails(feature){
		$('.details-image').attr('src', feature.properties.foto);
		$('.details-title').text(feature.properties.nama_usaha);
		$('.details-address').text(feature.properties.alamat);
		$('.details-owner').text(feature.properties.pemilik);
		$('.details-date').text(feature.properties.tgl_operasi);
		$('.details-legal').text(feature.properties.legalitas);
		$('.details-aset').text(feature.properties.aset);
		$('.canvas-details').removeClass('collapsed');
		map.easeTo({
			padding: {right: 300},
			duration: 1000
		});
	}

	function hideDetails(){
		$('.canvas-details').addClass('collapsed');
		map.easeTo({
			padding: {right: 0},
			duration: 1000
		});
	}

	getList(); 
</script>