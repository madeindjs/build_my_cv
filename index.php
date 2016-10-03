<?php
require_once('classes/User.php');

$user = new User("data.json");
?>
<!DOCTYPE html>
<html>

	<head>
		<title><?= $user->complete_name() ?></title>
		<meta charset="utf-8">
		<link href="css/stylesheet.css" rel="stylesheet" type="text/css" media="screen" >
		<link href="css/print.css" rel="stylesheet" type="text/css"  media="print">
		<link href="css/timeline_responsive.css" rel="stylesheet" type="text/css"  media="screen">
		<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.3.0/Chart.bundle.min.js"></script>
	</head>


	<body>


		<header>
			<img src="img/php.svg"/>
			<h1><?= $user->complete_name() ?></h1>
			<p>Développeur passionné auto-didacte</p>
		</header>

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

        


		<div id="contact" style="display:none">
			<p>Rousseau Alexandre</p>
			<div id="contact_icons">
				<a href="mailto:<?= $data["user"]["email"] ?>?subject=Votre%20CV"><img src="img/mai.png"></a>
				<?= $user->print_links() ?>
			</div>
		</div>




		<section>
			<h2>Compétences</h2>
			<div id="competencies_container"><canvas id="competencies" height="150"></></canvas></div>
		</section>



		<section>
			<h2>Etudes et formations</h2>

			<h3>Parcours scolaire</h3>
			<ul>
				<?php foreach($user->diplomas as $diploma): ?>
					<li><?= $diploma->title() ?></li>
				<?php endforeach ?>
			</ul>

			<h3>Formation et aptitudes</h3>
			<ul>
				<?php foreach($user->trainings as $training ): ?>
					<li><?= $training->title() ?></li>
				<?php endforeach ?>
			</ul>

			<h3>Langues</h3>
			<?php foreach( $user->langages as $langage){echo $langage->to_html(); } ?>

		</section>


	<footer>
		<p><?= $user->birth_date->format('Y-m-d') ?> à <?= $user->town_birth ?></p>
		<p><adress><?= $user->adress ?></adress></p>
		<p><strong><?= $user->phone ?></strong></p>
		<p><a href="mailto:<?= $user->email ?>?subject=Votre%20CV"><?= $user->email ?></a></p>
		<hr/>
		<div>Icons made by <a href="http://www.flaticon.com/authors/freepik" title="Freepik">Freepik</a> from <a href="http://www.flaticon.com" title="Flaticon">www.flaticon.com</a> is licensed by <a href="http://creativecommons.org/licenses/by/3.0/" title="Creative Commons BY 3.0" target="_blank">CC 3.0 BY</a></div>
	</footer>

	<script type="text/javascript" src="js/ribbon.js"></script>


	<script>
		var ctx = document.getElementById("competencies").getContext('2d');
		var data = <?= $user->compentencies_to_json()?>;
		var option = { maintainAspectRatio: false };
		var myRadarChart = new Chart(ctx , {  type: 'bar' , data: data , options: option });
	</script>

</body></html>
