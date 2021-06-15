<?php 
require_once 'vendor/autoload.php';
require_once("app/metereologia.php"); 
?>
<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Proyecto Ejemplo</title>
		<link rel="preconnect" href="https://fonts.gstatic.com">
		<link href="https://fonts.googleapis.com/css2?family=Lobster&display=swap" rel="stylesheet">
		<link rel="shortcut icon" href="https://getbootstrap.com/docs/5.0/assets/brand/bootstrap-logo.svg">
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
		<link rel="stylesheet" type="text/css" href="./public/css/app.css">
	</head>
	<body>
		<main>
			<div class="container">
				<h1 class="display-6 text-muted pb-2 mb-5 border-bottom"><?='Metereología: '.$current_date?></h1>
				<div class="row row-cols-1 row-cols-md-3 mb-4 text-center">
					<?php foreach ($last_report as $key => $info): ?>
						<div class="col">
							<div class="card mb-4 border border-white rounded-3 shadow">
								<div class="card-body bg-card">
									<h4 class="mb-3 text-white display-6"><?=$info->country.' - '.$info->name?></h4>
									<?=''//'http://openweathermap.org/img/wn/'.$info->icon.'@2x.png'?>
									<img src="<?='./public/icons/'.$info->icon.'@2x.png'?>" width="100px" height="100px"/>
									<p class="lead"><?=number_format($info->temp, 0, '.', '').'°C - '.ucfirst($info->description)?></p>
									<ul class="list-unstyled mt-3 mb-4">
										<li><?='Min: '.number_format($info->temp_min, 0, '.', '').'°C / Max: '.number_format($info->temp_max, 0, '.', '').'°C'?></li>
										<li><?='Humedad: '.number_format($info->humidity, 0, '.', '').'%'?></li>
									</ul>
									<!--<button type="button" class="btn btn-sm btn-outline-primary">Ver datos</button>-->
								</div>
							</div>
						</div>
					<?php endforeach; ?>
				</div>

				<div class="card bg-white shadow">
					<h5 class="card-header">Información meteorológica</h5>
					<div class="card-body p-2">
					
						<div class="table-responsive" style="max-height: 30rem;">
							<table class="table table-bordered table-hover bg-transp">
								<thead>
									<tr>
										<th scope="col">Fecha</th>
										<th scope="col">Ciudad</th>
										<th scope="col">Clima</th>
										<th scope="col">Temperatura</th>
										<th scope="col">Mínima</th>
										<th scope="col">Máxima</th>
										<th scope="col">Humedad</th>
									</tr>
								</thead>
								<tbody>
									<?php 
									foreach ($historical as $key => $row): 
										$info = (object)$row;
										?>
										<tr>
											<td><?=$info->created_at?></td>
											<th scope="row"><?=$info->country.' - '.$info->name?></th>
											<td><?=ucfirst($info->description)?></td>
											<td><?=number_format($info->temp, 0, '.', '').'°C'?></td>
											<td><?=number_format($info->temp_min, 0, '.', '').'°C'?></td>
											<td><?=number_format($info->temp_max, 0, '.', '').'°C'?></td>
											<td><?=number_format($info->humidity, 0, '.', '').'%'?></td>
										</tr>
									<?php endforeach; ?>
								</tbody>
							</table>
						</div>

					</div>
				</div>

			</div>
		</main>

		<footer class="mb-5 pt-5 text-muted text-center text-small">
			<div class="container">
				<p class="mb-1">
					<a href="https://github.com/alfonsochb" target="_blank"><img src="./public/icons/github.png" width="24px"/></a>
					<a href="https://www.linkedin.com/in/alfonsochb/" target="_blank"><img src="./public/icons/linkedin.png" width="24px"/></a>
				</p>
				<p class="mb-1"><?='&copy; '.date("Y").' – Ing. Alfonso Chávez Baquero'?></p>
			</div>
		</footer>

	    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.6.0/dist/umd/popper.min.js" integrity="sha384-KsvD1yqQ1/1+IA7gi3P0tyJcT3vR+NdBTt13hSJ2lnve8agRGXTTyNaBYmCR/Nwi" crossorigin="anonymous"></script>
	    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.min.js" integrity="sha384-nsg8ua9HAw1y0W1btsyWgBklPnCUAFLuTMS2G72MMONqmOymq585AcH49TLBQObG" crossorigin="anonymous"></script>
  </body>
</html>