<?php
$string = file_get_contents("data.json");
$data = json_decode($string, true);

function total_name()
{
	global $data ;
	return $data["user"]["lastname"]." ".$data["user"]["firstname"] ;
}

?>

<html>

	<head>
		<title><?= total_name() ?></title>
		<meta charset="utf-8">
		<link href="css/stylesheet.css" rel="stylesheet" type="text/css" media="screen" >
		<link href="css/print.css" rel="stylesheet" type="text/css"  media="print">
	</head>


	<body>

		<header><h1><?= total_name() ?></h1></header>

		<pre><?= var_dump($data) ?></pre>


		<div id="contact">
			<a href="mailto:<?= $data["user"]["email"] ?>?subject=Votre%20CV"><img src="img/mai.png"></a>
			<a href="www.linkedin.fr"><img src="img/lkd.svg" alt="Linkedin"></a>
		</div>


		<!--  professional experience -->
		<section>
			<?php foreach($data["professional experience"] as $entreprise => $details): ?>

				<h2><?= $entreprise ?> depuis <?= $details["begin"] ?></h2>

				<?php foreach($details["functions"] as $name => $function): ?>

					<h3><?= $name ?></h3>

					<ul class="experience" >
						<?php foreach($function as $picture => $activity): ?>
							<li><img src="img/<?= $picture ?>"><?= $activity ?></li>
						<?php endforeach // next activities ?>
					</ul>

					
				<?php endforeach // next categories ?>
			<?php endforeach // next entreprise?>
		</section>
		

		<section style="background-color:#bdc3c7" >

			<h2>Experience personnelle</h2>

			<?php foreach($data["personal experience"] as $category => $details): ?>

				<h3><?= $category ?> depuis <?= $details["begin"] ?></h3>

				<ul class="experience" >
					<?php foreach($details["activities"] as $picture => $activity): ?>
						<li><img src="img/<?= $picture ?>"><?= $activity ?></li>
					<?php endforeach // next categories ?>
				</ul>

			<?php endforeach // next entreprise?>

		</section>



		<section>
			<h2>Etudes et formations</h2>

			<h3>Parcours scolaire</h3>
			<ul class="experience">
				<?php foreach($data["studies"]["qualifications"] as $diplomas => $details): ?>
					<li><?= $diplomas ?></li>
				<?php endforeach ?>
			</ul>

			<h3>Formation et aptitudes</h3>
			<ul class="experience">
				<?php foreach($data["trainings"] as $training => $details): ?>
					<li><?= $training ?></li>
				<?php endforeach ?>
			</ul>

			<h3>Langues</h3>
			<ul class="experience">
				<?php foreach($data["langages"] as $langage => $details): ?>
					<li><?= $langage ?><ul>
						<?php foreach($details["notes"] as $media => $note): ?>
							<li><?= $media ?>
								<progress value="<?= $note?>" max="5"><?= $note?>/5</progress>
							</li>
						<?php endforeach ?>
					</ul></li>
				<?php endforeach ?>
			</ul>

		</section>


	<footer>
		<p><?= $data["user"]["birth date"] ?> à <?= $data["user"]["town birth"] ?></p>
		<p><adress><?= $data["user"]["adress"] ?></adress></p>
		<p><strong><?= $data["user"]["phone"] ?></strong></p>
		<p><a href="mailto:<?= $data["user"]["email"] ?>?subject=Votre%20CV"><?= $data["user"]["email"] ?></a></p>
	</footer>


</body></html>
