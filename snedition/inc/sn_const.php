<?php
/***************************************************************************\
 *  SN Suite, suite de plugins pour SPIP                                   *
 *  Copyright © depuis 2014                                                *
 *  Simon N                                                            *
 *                                                                         *
 *  Ce programme est un logiciel libre distribué sous licence GNU/GPL.     *
 *  Pour plus de détails voir l'aide en ligne.                             *
 *  https://www.snsuite.net                                                *
\**************************************************************************/

if (!defined('_ECRIRE_INC_VERSION')) {
	return;
}

/* SN core */
function sn_global_objet_editable(){
	return [ 'article','auteur','mot','rubrique', ];
}
function sn_global_objet_positionnable(){
	return [ 'article','auteur','groupemot','mot','rubrique', ];
}
function sn_global_options(){
	return [
		'A' => [

		],
		'E' => [
			'sn_position' => [ 'tete','cold','colg','corps' ],
			// ajouts
			'bloc_style' => ['sn-style-astuce','sn-style-avertissement','sn-style-code','sn-style-cool','sn-style-journal','sn-style-roman'],
			'diapo_effet' => ['glisse', 'cartes', 'cube', 'diapositive', 'fondu', 'retourne'],
			'diapo_direction' => ['horizontal', 'vertical'],
			'diapo_pagination' => ['non', 'points', 'progression', 'numerotation', 'pointnum'],
			'fa_icones_style' => ['solid', 'regular', 'light', 'duotone', 'thin', 'brand'],
			'fa_icones_taille' => ['normal','2xs','xs', 'sm', 'lg', 'xl', '2xl'],
			'geoloc_format' => ['moyen','grand','petit','vignette'],
			'liens_objets' => ['article','auteur','breve','mot','rubrique','site'],
			'mode_couleur' => ['sombre','lumineux'],
			'titre_niveau' => ['2','3','4','5','6','strong'],
		],
		'S' => [
			// ajouts
			'flux_articles_affichage' => ['liste','grille','diapo'],
			'menu_type' => ['simple','double','mega'],
			'notification' => ['deconnexion'],
			'page_actus_affichage' => ['liste','grille'],
			'rubrique_menu' => ['horsmenu','menuppl','menusec','invis'],
		],
	];
}

/* SN images */
function sn_global_objet_snimageable(){
	return [ 'article','auteur','groupe_mot','mot','rubrique', ];
}
function sn_global_objet_snimageable_champs(){
	return [
		'article' => ['texte'],
		'auteur' => ['bio'],
		'groupe_mot' => ['texte'],
		'mot' => ['texte'],
		'rubrique' => ['texte'],
	];
}
function sn_global_dir_snimages(){
	return 'snimages';
}
function sn_global_snimages_extensions(){
	return [ 'jpg','png','gif' ];
}
function sn_global_snimages_formats(){
	return [
		'img' => [
	        'bd' => [
	            'largeur_max' => 1400,
	            'hauteur_max' => 1400,
	            'largeur_min' => 0,
	            'hauteur_min' => 0,
	            'poids_max' => 1024,
	            'necessaire' => 'non',
	            'active' => 'non',
	        ],
	        'hd' => [
	            'largeur_max' => 4400,
	            'hauteur_max' => 4400,
	            'largeur_min' => 0,
	            'hauteur_min' => 0,
	            'poids_max' => 2048,
	            'necessaire' => 'non',
	            'active' => 'oui',
	        ],
	    ],
		 'car' => [
	        'bd' => [
	            'largeur_max' => 577,
	            'hauteur_max' => 577,
	            'largeur_min' => 575,
	            'hauteur_min' => 575,
	            'largeur_pref' => 576,
	            'hauteur_pref' => 576,
	            'poids_max' => 256,
	            'necessaire' => 'oui',
	            'active' => 'oui',
	        ],
	        'hd' => [
	            'largeur_max' => 1153,
	            'hauteur_max' => 1153,
	            'largeur_min' => 1151,
	            'hauteur_min' => 1151,
	            'largeur_pref' => 1152,
	            'hauteur_pref' => 1152,
	            'poids_max' => 512,
	            'necessaire' => 'non',
	            'active' => 'oui',
	        ],
	    ],
		 'cov' => [
	        'bd' => [
	            'largeur_max' => 577,
	            'hauteur_max' => 769,
	            'largeur_min' => 575,
	            'hauteur_min' => 767,
	            'largeur_pref' => 576,
	            'hauteur_pref' => 768,
	            'poids_max' => 512,
	            'necessaire' => 'non',
	            'active' => 'oui',
	        ],
	        'hd' => [
	            'largeur_max' => 1153,
	            'hauteur_max' => 1537,
	            'largeur_min' => 1151,
	            'hauteur_min' => 1535,
	            'largeur_pref' => 1152,
	            'hauteur_pref' => 1536,
	            'poids_max' => 1024,
	            'necessaire' => 'oui',
	            'active' => 'oui',
	        ],
	    ],
	];
}
function sn_global_snimages_galerie_limite(){
	return 300;
}
function sn_global_snimage_habillages(){
	return [ 'sans'=>'sans', 'droite'=>'droite', 'gauche'=>'gauche', ];
}

/* SN edition */
// Pour ajouter des services redéfinir cette fonction dans mes_fonctions en ajoutant par exemple
/*'linkedin' => ['titre'=>_T('snedition:partage_service_linkedin'),'icone_nom'=>'linkedin','icone_classe'=>'fab fa-linkedin'],
'twitter' => ['titre'=>_T('snedition:partage_service_twitter'),'icone_nom'=>'twitter','icone_classe'=>'fab fa-twitter'],
'google' => ['titre'=>_T('snedition:partage_service_google'),'icone_nom'=>'gplus','icone_classe'=>'fab fa-google'],
'facebook' => ['titre'=>_T('snedition:partage_service_facebook'),'icone_nom'=>'facebook','icone_classe'=>'fab fa-facebook'],
'instagram' => ['titre'=>_T('snedition:partage_service_instagram'),'icone_nom'=>'instagram','icone_classe'=>'fab fa-instagram-square'],
'pinterest' => ['titre'=>_T('snedition:partage_service_pinterest'),'icone_nom'=>'pinterest','icone_classe'=>'fab fa-pinterest'],*/
function sn_global_services_partage(){
	return [
		'envoyer' => ['titre'=>_T('snedition:partage_service_envoyer'),'icone_nom'=>'envelope','icone_classe'=>'fas fa-envelope'],
		'imprimer' => ['titre'=>_T('snedition:partage_service_imprimer'),'icone_nom'=>'print','icone_classe'=>'fas fa-print'],
	];
}

/* Renvoie une liste d options ou si ref est vide toute une categorie de listes d options ou si cat est vide toutes les listes d options */
function sn_const_options_liste($cat=null,$ref=null){
	$d = sn_global_options();
	if($cat != null){
		if(isset($d[$cat])){
			if($ref != null){
				if(isset($d[$cat][$ref])){
					return $d[$cat][$ref];
				}
				return null;
			}
			return $d[$cat];
		}
		return null;
	} else {
		return $d;
	}
	return null;
}
