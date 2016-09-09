<?php
require_once('classes/User.php');

$user = new User("data.json");
?>

<html>

	<head>
		<title><?= $user->complete_name() ?></title>
		<meta charset="utf-8">
		<link href="css/stylesheet.css" rel="stylesheet" type="text/css" media="screen" >
		<link href="css/print.css" rel="stylesheet" type="text/css"  media="print">
	</head>


	<body>

		<header><h1><?= $user->complete_name() ?></h1></header>


		<div id="contact">
			<a href="mailto:<?= $user->email ?>?subject=Votre%20CV"><img src="img/mai.png"></a>
			<a href="www.linkedin.fr"><img src="img/lkd.svg" alt="Linkedin"></a>
		</div>

		<!--  professional experience in POO-->
		<section>
			<?php foreach( $user->professionalExperiences as $professionalExp)://loop on all professionalExperiences ?>
				<h2><?= $professionalExp->title() ?></h2>
				<?php foreach( $professionalExp->jobs as $job )://loop on all jobs into this professional Experience?>
					<h3><?= $job->title ?></h3>
					<ul class="experience" >
						<?php foreach($job->activities as $activity){//loop on all activities into this activity
							echo $activity->to_html() ;
						} // next activity ?>
					</ul>
				<?php endforeach // next job ?>
			<?php endforeach // next professional Experience?>
		</section>
		

		<!--  personal experience in POO-->
		<section style="background-color:#bdc3c7" >
			<h2>Experience personnelle</h2>

			<?php foreach( $user->personalExperiences as $personalExp)://loop on all personalExperiences ?>
				<h3><?= $personalExp->title() ?></h3>
				<ul class="experience" >
					<?php foreach($personalExp->activities as $activity){//loop on all activities into this activity
						echo $activity->to_html() ;
					} // next activity ?>
				</ul>
			<?php endforeach // next activity?>
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
			<ul class="experience">
				<?php foreach( $user->langages as $langage){
					echo $langage->to_html();
				} ?>
			</ul>

		</section>


	<footer>
		<p><?= $user->birth_date ?> à <?= $user->town_birth ?></p>
		<p><adress><?= $user->adress ?></adress></p>
		<p><strong><?= $user->phone ?></strong></p>
		<p><a href="mailto:<?= $user->email ?>?subject=Votre%20CV"><?= $user->email ?></a></p>
	</footer>


</body></html>
