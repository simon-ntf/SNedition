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

if (!defined('_ECRIRE_INC_VERSION')) { return; }

/* FONCTIONS EDITION
*******************/

/* Renvoie la liste des ID des rubriques rattachées au menu principal */
function sn_lister_id_secteurs1(){
	$retour = [];
	$req = sql_select('id_rubrique','spip_rubriques','id_parent='.sql_quote(0).' && sn_menu='.sql_quote('menuppl'));
    while($res = sql_fetch($req)){ $retour[] = $res['id_rubrique']; }
    return $retour;
}

function sn_lister_id_mots_themes(){
	$retour = [];
	if($GLOBALS['meta']['sn_page_actus_themes_groupe'] == ''){

	} else {
		$req = sql_select('id_mot','spip_mots','id_groupe='.sql_quote($GLOBALS['meta']['sn_page_actus_themes_groupe']));
    	while($res = sql_fetch($req)){ $retour[] = $res['id_mot']; }
	}
   return $retour;
}

/* FONCTIONS PARTAGE
*******************/

/* Renvoie les donnees des services de partage */
function sn_partage_services_datas(){
	include_spip('inc/sn_const');
	$sn_const_services_partage = sn_global_services_partage();
	$config_data = sn_conv_liste_array($GLOBALS['meta']['sn_partage_services']);
	$final_datas = $sn_const_services_partage;
	foreach($sn_const_services_partage as $cle => $valeur){
		$final_datas[$cle]['actif'] = $config_data[$cle];
	}
	return $final_datas;
}

/* FONCTIONS FILTRAGES SELECTIFS
*******************/

/* Listes dynamiques / filtrage : transformer les parametres GET en tableau de filtres */
function sn_filtrage_transtyper($filtre_str){
	include_spip('inc/sn_regexr');
	$retour = [];
	$filtre_str = trim(htmlspecialchars($filtre_str));
	if(preg_match(sn_regex_liste_numids_req(), $filtre_str, $matches)){
		$explosion = explode('i', $matches[0]);
		foreach($explosion as $cle => $valeur){
			if(strlen($valeur) > 0){
				array_push($retour,$valeur);
			}
		}
	}
	return $retour;
}
/* Listes dynamiques / filtrage : transformer le tableau de filtres en parametres GET */
function sn_filtrage_transtyper_array($filtre_array){
	$retour = 'i' . implode('i',$filtre_array);
    return $retour;
}
/* Listes dynamiques / filtrage : tester si un objet est est deja inclus dans la liste du filtre (pour cas de filtrage non exclusif) */
function sn_filtrage_tester($id_objet,$filtre_array){
	$retour = false;
    if(in_array($id_objet,$filtre_array)){
    	$retour = true;
    }
    return $retour;
}
/* Listes dynamiques / filtrage : en cas de filtrage non exclusif cree le parametre du lien (+ ou -) */
function sn_filtrage_param_url($id_objet,$filtre_array){
	$retour = '';
	$inclus = in_array($id_objet,$filtre_array);
	if($inclus == true){
		unset($filtre_array[array_search($id_objet,$filtre_array)]);
	} else{
		$filtre_array[] = $id_objet;
	}
	$retour = sn_filtrage_transtyper_array($filtre_array);
    return $retour;
}

/* FONCTIONS COOKIES
*******************/

/* Renvoie l'agrement du visiteur pour chaque service Tarteaucitron (recuperation du cookie Tarteaucitron sous forme d'array pour prise en compte dans les squelettes) */
if (!function_exists('sn_tarteaucitron_cookies_decode')){ function sn_tarteaucitron_cookies_decode() {
	$services_array = [];
	$explose_cookie = null;
	$explose_service = null;
	$cookie = htmlspecialchars($_COOKIE["tarteaucitron"]);
	if(strval($cookie) < 2500){
		$explose_cookie = explode('!',$cookie);
		foreach($explose_cookie as $cle => $valeur){
			if(strlen($valeur)>1){
				 $explose_service = explode('=',$valeur);
				 $services_array[$explose_service[0]] = $explose_service[1];
			}
		}
	}
	return $services_array;
}}

if (!function_exists('sn_lien_analyser')){ function sn_lien_analyser($url,$titre=''){
	$retour = [ 'url' => '#', 'externe' => 'non' ,'titre' => $titre ];
	$url_calculee = '';
	$url_data = [];
	if(preg_match('#^((art|article|aut|auteur|br|breve|brève|mot|rub|rubrique|site|doc|document|img|image)([0-9]{1,21}))([a-zA-Z0-9_\&\?\=\+\s]+)?$#is',$url, $matches)){
		if(isset($matches[1])) {
			$url_data = calculer_url($matches[1],$texte,'tout');
			if($retour['titre'] == ''){
				$retour['titre'] = $url_data['titre'];
			}
			$url_calculee = $url_data['url'];
		}
		if(isset($matches[4])) {
			$url_calculee .= $matches[4];
		}
		$retour['url'] = $url_calculee;
	} elseif(preg_match('#^(actualites|contact|legal)([a-zA-Z0-9_\&\?\=\+\s]+)?$#is',$url, $matches)){
		if(isset($matches[1])) {
			$retour['url'] = $matches[1];
		}
	} elseif(filter_var($url, FILTER_VALIDATE_URL)){
		$retour['externe'] = 'oui';
		if($retour['titre'] == ''){
			$retour['titre'] = $url;
		}
		$retour['url'] = $url;
	}
	return $retour;
}}
