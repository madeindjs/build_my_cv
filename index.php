<?php
require_once('classes/User.php');

$user = new User("data.json");
?>
<!DOCTYPE html>
<html>

	<head>
		<title><?= $user->complete_name() ?></title>
		<meta charset="utf-8">
		<link href="css/stylesheet.css" rel="stylesheet" type="text/css" media="all" >
		<link href="css/timeline_responsive.css" rel="stylesheet" type="text/css"  media="all">
		<link href="css/print.css" rel="stylesheet" type="text/css"  media="print">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.3.0/Chart.bundle.min.js"></script>
	</head>


	<body>


		<header>
		<?= $user->image() ?>
			<h1><?= $user->complete_name() ?></h1>
			<p>Développeur passionné auto-didacte</p>
		</header>

		<div id="contact">
			<?= $user->print_links() ?>
		</div>
		


		<section>
			<h2>Timeline</h2>
			<ul class="timeline">

				<?php $left = true ;
				foreach ($user->activities() as $activty): ?>
					<li <?= $left ? '' : 'class="timeline-inverted"' ?> >
						<div class="timeline-badge"><?= $activty->picture() ?></div>
						<div class="timeline-panel">
							<div class="timeline-heading">
								<h4 class="timeline-title"><?= $activty->title() ?></h4>
								<p><small class="text-muted"><i class="glyphicon glyphicon-time"></i> <?= $activty->date() ?></small></p>
							</div>
							<div class="timeline-body"> <p><?= $activty->description() ?></p></div>
						</div>
					</li>
				<?php $left = !$left ;
				endforeach ?>
			</ul>
		</section>



		<section>
			<h2>Compétences</h2>
			<canvas id="competencies" height="200"></canvas>
		</section>



		<section>
			<h2>Etudes et formations</h2>

			<h3>Etudes</h3>
			<ul>
				<?php foreach($user->diplomas as $diploma): ?>
					<li><?= $diploma->title() ?></li>
				<?php endforeach ?>
			</ul>

			<h3>Formations</h3>
			<ul>
				<?php foreach($user->trainings as $training ): ?>
					<li><?= $training->title() ?></li>
				<?php endforeach ?>
			</ul>
		</section>

		<section>
			<h2>Langues</h2>
			<?php foreach( $user->langages as $langage){echo $langage->to_html(); } ?>
		</section>


	<footer>
		
		<p><i class="glyphicon glyphicon-user"></i> <?= $user->birth_date->format('d/m/Y') ?> à <?= $user->town_birth ?></p>
		<p><i class="glyphicon glyphicon-home"></i> <adress><?= $user->adress ?></adress></p>
		<p><i class="glyphicon glyphicon-earphone"></i> <strong><?= $user->phone ?></strong></p>
		<p><i class="glyphicon glyphicon-envelope"></i> <a href="mailto:<?= $user->email ?>?subject=Votre%20CV"><?= $user->email ?></a></p>
		<hr/>
		<small>Icons made by <a href="http://www.flaticon.com/authors/freepik" title="Freepik">Freepik</a> from <a href="http://www.flaticon.com" title="Flaticon">www.flaticon.com</a> is licensed by <a href="http://creativecommons.org/licenses/by/3.0/" title="Creative Commons BY 3.0" target="_blank">CC 3.0 BY</a></small>
	</footer>


	<script>
		var ctx = document.getElementById("competencies").getContext('2d');
		var data = <?= $user->compentencies_to_json()?>;
		var option = { maintainAspectRatio: false };
		var myRadarChart = new Chart(ctx , {  type: 'polarArea' , data: data , options: option });
	</script>

</body></html>
