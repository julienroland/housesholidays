<?php

class PageTraductionTableSeeder extends Seeder {

	public function run()
	{
		// Uncomment the below to wipe the table clean before populating
		
		$page = array(

			'titre'=>'',
			'texte'=>'<div class="perso"><h2 style="font-size:18px">Pourquoi  exposer sur Householidays.com?</h2><p><span style="font-size:14px">Diffusez votre annonce  sur un des sites <strong>les plus consult&eacute;s en Europe</strong><br />et sur nos <strong>nombreux sites  partenaires.</strong></span></p><p><span style="font-size:12px">Des experts de la location de vacances et du web vous aident &agrave; rentabiliser  votre bien.</span></p><br /><h3>Le service d\'annonces Housesholidays</h3><ol><li>Un calendrier des tarifs et planning  modifiable.</li><li>Une annonce modifiable &agrave; volont&eacute;, un formulaire de contact  prot&eacute;geant votre email, des statistiques de visualisation de votre annonce, un  lien  vers votre site web perso.</li><li>Une galerie de <strong>20 photos au grand format</strong>.</li><li>La <strong>localisation g&eacute;ographique</strong> de  votre bien sur une carte et une vue satellite.</li><li>Une annonce diffus&eacute;e <strong>dans 5 langues</strong></li><li>Vos coordonn&eacute;es pour  une prise de contact directe. <strong>Nous ne prenons pas de commission</strong>. Vous louez en  direct et conservez <strong>100%</strong> des revenus locatifs.</li><li>Un <strong>site web personnel</strong> pour  pr&eacute;senter votre bien (option)</li></ol><br /><h3>Des formules adapt&eacute;es au  particuliers et professionnels</h3><div class="pricing"><div class="pricing-table"><p class="title">START</p><p class="time">6 mois</p><p class="advert">1 annonce</p><p class="price">Offert</p><p class="price-out">(40&euro;)</p></div><div class="pricing-option"><p class="title">Options Web*</p><p class="web-price"><span class="web-title">Web</span> 15&euro;</p><p class="web-price last"><span class="web-title last">Web+</span> 65&euro; <span class="web-out">(70&euro;)</span></p><div class="bot"></div></div></div><div class="pricing"><div class="pricing-table"><p class="title">STANDARD</p><p class="time">12 mois</p><p class="advert">1 annonce</p><p class="price">Offert</p><p class="price-out">(70&euro;)</p></div><div class="pricing-option"><p class="title">Options Web*</p><p class="web-price"><span class="web-title">Web:</span> 15&euro; <span class="web-out">(25&euro;)</span></p><p class="web-price last"><span class="web-title last">Web+</span> 45&euro; <span class="web-out">(75&euro;)</span></p><div class="bot"></div></div></div><div class="pricing"><div class="pricing-table"><p class="title">PRO 15</p><p class="time">12 mois</p><p class="advert">15 annonces</p><p class="price">Offert</p><p class="price-out">(500&euro;)</p></div><div class="pricing-option"><p class="title">Options Web*</p><p class="web-price"><span class="web-title">Web</span> 15&euro; <span class="web-out">(40&euro;)</span></p><p class="web-price last"><span class="web-title">Web+</span> 45&euro; <span class="web-out">(90&euro;)</span></p><div class="bot"></div></div></div><div class="pricing"><div class="pricing-table"><p class="title">PRO 35</p><p class="time">12 mois</p><p class="advert">35 annonces</p><p class="price">Offert</p><p class="price-out">(900&euro;)</p></div><div class="pricing-option"><p class="title">Options Web*</p><p class="web-price"><span class="web-title">Web</span> 15&euro; <span class="web-out">(50&euro;)</span></p><p class="web-price last"><span class="web-title last">Web+</span> 45&euro; <span class="web-out">(100&euro;)</span></p><div class="bot"></div></div></div><p>(*)</p><p><strong>Web</strong>: vous disposez d\'un site web personnel pour pr&eacute;senter votre bien.</p><strong>Web+</strong>: vous disposez d\'un site web  personnel pour pr&eacute;senter  votre bien avec une adresse personnalis&eacute;e. Vous  choisissez le nom de domaine de  votre choix parmi les extensions  .com&nbsp;; .net&nbsp;; .org&nbsp;; .fr&nbsp;;  .it&nbsp;; .es&nbsp;; .be (autres extensions sur  demande)<p>&nbsp;</p></div>',
			'slug'=>'',
			'page_id'=>1,
			'langage_id'=>1,

			);

		// Uncomment the below to run the seeder
		DB::table('pages_traductions')->insert($page);
	}

}
