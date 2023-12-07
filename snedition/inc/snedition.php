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

if (!function_exists('const_js_geoloc')){ function const_js_geoloc() {
	include_spip('inc/sn_const');
	$sn_const_geoloc_params = const_geoloc_params();
	$sn_const_geoloc_marqueur_styles = const_geoloc_marqueurs();
	$inner = "<script type='text/javascript'>
		var GEOLOC_MARQUEURS_STYLES = '" . json_encode($sn_const_geoloc_marqueur_styles) . "';
		var GEOLOC_FOND_URL = '" . $sn_const_geoloc_params['fond'] . "';
		var GEOLOC_FOND_CREDIT = '" . $sn_const_geoloc_params['credit'] . "';
		var GEOLOC_FOND_ZOOM = " . $sn_const_geoloc_params['zoom'] . ";
	</script>";
	return $inner;
}}

if (!function_exists('const_js_cookies')){ function const_js_cookies() {
	$inner = '';
	$js_services = '';
	$partages_services = sn_partage_services_datas();
	foreach($partages_services as $cle => $valeur){
		$js_services .= "var config_tarteaucitron_" . $cle . " = '" . $valeur['actif'] . "';";
	}
	if($GLOBALS['meta']['sn_video_activer'] == 'on'){
		$js_services .= " var config_tarteaucitron_youtube = 'on'"; // Youtube actif par defaut
	}
	$inner = "<script type='text/javascript'>" . $js_services. "</script>";
	if($GLOBALS['meta']['sn_tarteaucitron_activer'] === 'on'){
		$inner .= '<script type="text/javascript" src="'  . _DIR_PLUGIN_SNEDITION . 'lib/tarteaucitron/tarteaucitron.js"></script>';
		$inner .= '<script type="text/javascript" src="'  . _DIR_PLUGIN_SNEDITION . 'javascript/sntarteaucitron.js"></script>';
	}
	return $inner;
}}

if (!function_exists('const_js_icones')){ function const_js_icones() {
	$inner = '';
	if(strlen($GLOBALS['meta']['sn_icones_cle']) > 0){
		$inner .= '<script src="https://kit.fontawesome.com/' . $GLOBALS['meta']['sn_icones_cle'] . '.js" crossorigin="anonymous"></script>';
	}
	return $inner;
}}


if (!function_exists('const_geoloc_marqueurs')){ function const_geoloc_marqueurs(){
	return [
		'leaflet_defaut' => [
			'iconUrl' => $GLOBALS['meta']['adresse_site'] . '/' . _DIR_PLUGIN_SNEDITION . 'lib/leaflet/images/marker-icon.png',
			'shadowUrl' => $GLOBALS['meta']['adresse_site'] . '/' . _DIR_PLUGIN_SNEDITION . 'lib/leaflet/images/marker-icon.png',
			'iconRetinaUrl' => $GLOBALS['meta']['adresse_site'] . '/' . _DIR_PLUGIN_SNEDITION . 'lib/leaflet/images/marker-icon-2x.png',
		],
		'lieu_gris' => [
			'iconUrl' => $GLOBALS['meta']['adresse_site'] . '/' . _DIR_PLUGIN_SNEDITION . 'css/img/sn-geoloc/fa-location-gris.svg',
			'shadowUrl' => $GLOBALS['meta']['adresse_site'] . '/' . _DIR_PLUGIN_SNEDITION . 'css/img/sn-geoloc/sn-marqueur-bulle-ombre.png',
			'iconSize' => [64,64],
			'iconAnchor' => [32,64],
			'popupAnchor' => [-3,-76],
		],
		'lieu_bleu' => [
			'iconUrl' => $GLOBALS['meta']['adresse_site'] . '/' . _DIR_PLUGIN_SNEDITION . 'css/img/sn-geoloc/fa-location-bleu.png',
			'shadowUrl' => $GLOBALS['meta']['adresse_site'] . '/' . _DIR_PLUGIN_SNEDITION . 'css/img/sn-geoloc/sn-marqueur-bulle-ombre.png',
			'iconSize' => [64,64],
			'iconAnchor' => [32,64],
			'popupAnchor' => [-3,-76],
		],
		'lieu_blanc' => [
			'iconUrl' => $GLOBALS['meta']['adresse_site'] . '/' . _DIR_PLUGIN_SNEDITION . 'css/img/sn-geoloc/fa-location-blanc.png',
			'shadowUrl' => $GLOBALS['meta']['adresse_site'] . '/' . _DIR_PLUGIN_SNEDITION . 'css/img/sn-geoloc/sn-marqueur-bulle-ombre.png',
			'iconSize' => [64,64],
			'iconAnchor' => [32,64],
			'popupAnchor' => [-3,-76],
		],
		'lieu_jaune' => [
			'iconUrl' => $GLOBALS['meta']['adresse_site'] . '/' . _DIR_PLUGIN_SNEDITION . 'css/img/sn-geoloc/fa-location-blanc.png',
			'shadowUrl' => $GLOBALS['meta']['adresse_site'] . '/' . _DIR_PLUGIN_SNEDITION . 'css/img/sn-geoloc/sn-marqueur-bulle-ombre.png',
			'iconSize' => [64,64],
			'iconAnchor' => [32,64],
			'popupAnchor' => [-3,-76],
		],
		'lieu_rouge' => [
			'iconUrl' => $GLOBALS['meta']['adresse_site'] . '/' . _DIR_PLUGIN_SNEDITION . 'css/img/sn-geoloc/fa-location-rouge.png',
			'shadowUrl' => $GLOBALS['meta']['adresse_site'] . '/' . _DIR_PLUGIN_SNEDITION . 'css/img/sn-geoloc/sn-marqueur-bulle-ombre.png',
			'iconSize' => [64,64],
			'iconAnchor' => [32,64],
			'popupAnchor' => [-3,-76],
		],
		'lieurond_gris' => [
			'iconUrl' => $GLOBALS['meta']['adresse_site'] . '/' . _DIR_PLUGIN_SNEDITION . 'css/img/sn-geoloc/fa-location-gris.png',
			'shadowUrl' => $GLOBALS['meta']['adresse_site'] . '/' . _DIR_PLUGIN_SNEDITION . 'css/img/sn-geoloc/sn-marqueur-bulle-ombre.png',
			'iconSize' => [64,64],
			'iconAnchor' => [32,64],
			'popupAnchor' => [-3,-76],
		],
		'lieurond_bleu' => [
			'iconUrl' => $GLOBALS['meta']['adresse_site'] . '/' . _DIR_PLUGIN_SNEDITION . 'css/img/sn-geoloc/fa-location-bleu.png',
			'shadowUrl' => $GLOBALS['meta']['adresse_site'] . '/' . _DIR_PLUGIN_SNEDITION . 'css/img/sn-geoloc/sn-marqueur-bulle-ombre.png',
			'iconSize' => [64,64],
			'iconAnchor' => [32,64],
			'popupAnchor' => [-3,-76],
		],
		'lieurond_blanc' => [
			'iconUrl' => $GLOBALS['meta']['adresse_site'] . '/' . _DIR_PLUGIN_SNEDITION . 'css/img/sn-geoloc/fa-location-blanc.png',
			'shadowUrl' => $GLOBALS['meta']['adresse_site'] . '/' . _DIR_PLUGIN_SNEDITION . 'css/img/sn-geoloc/sn-marqueur-bulle-ombre.png',
			'iconSize' => [64,64],
			'iconAnchor' => [32,64],
			'popupAnchor' => [-3,-76],
		],
		'lieurond_jaune' => [
			'iconUrl' => $GLOBALS['meta']['adresse_site'] . '/' . _DIR_PLUGIN_SNEDITION . 'css/img/sn-geoloc/fa-location-jaune.png',
			'shadowUrl' => $GLOBALS['meta']['adresse_site'] . '/' . _DIR_PLUGIN_SNEDITION . 'css/img/sn-geoloc/sn-marqueur-bulle-ombre.png',
			'iconSize' => [64,64],
			'iconAnchor' => [32,64],
			'popupAnchor' => [-3,-76],
		],
		'lieurond_rouge' => [
			'iconUrl' => $GLOBALS['meta']['adresse_site'] . '/' . _DIR_PLUGIN_SNEDITION . 'css/img/sn-geoloc/fa-location-rouge.png',
			'shadowUrl' => $GLOBALS['meta']['adresse_site'] . '/' . _DIR_PLUGIN_SNEDITION . 'css/img/sn-geoloc/sn-marqueur-bulle-ombre.png',
			'iconSize' => [64,64],
			'iconAnchor' => [32,64],
			'popupAnchor' => [-3,-76],
		],
		'punaise_gris' => [
			'iconUrl' => $GLOBALS['meta']['adresse_site'] . '/' . _DIR_PLUGIN_SNEDITION . 'css/img/sn-geoloc/fa-map-pin-gris.png',
			'shadowUrl' => $GLOBALS['meta']['adresse_site'] . '/' . _DIR_PLUGIN_SNEDITION . 'css/img/sn-geoloc/sn-marqueur-bulle-ombre.png',
			'iconSize' => [64,64],
			'iconAnchor' => [32,64],
			'popupAnchor' => [-3,-76],
		],
		'punaise_bleu' => [
			'iconUrl' => $GLOBALS['meta']['adresse_site'] . '/' . _DIR_PLUGIN_SNEDITION . 'css/img/sn-geoloc/fa-map-pin-bleu.png',
			'shadowUrl' => $GLOBALS['meta']['adresse_site'] . '/' . _DIR_PLUGIN_SNEDITION . 'css/img/sn-geoloc/sn-marqueur-bulle-ombre.png',
			'iconSize' => [64,64],
			'iconAnchor' => [32,64],
			'popupAnchor' => [-3,-76],
		],
		'punaise_blanc' => [
			'iconUrl' => $GLOBALS['meta']['adresse_site'] . '/' . _DIR_PLUGIN_SNEDITION . 'css/img/sn-geoloc/fa-map-pin-blanc.png',
			'shadowUrl' => $GLOBALS['meta']['adresse_site'] . '/' . _DIR_PLUGIN_SNEDITION . 'css/img/sn-geoloc/sn-marqueur-bulle-ombre.png',
			'iconSize' => [64,64],
			'iconAnchor' => [32,64],
			'popupAnchor' => [-3,-76],
		],
		'punaise_jaune' => [
			'iconUrl' => $GLOBALS['meta']['adresse_site'] . '/' . _DIR_PLUGIN_SNEDITION . 'css/img/sn-geoloc/fa-map-pin-jaune.png',
			'shadowUrl' => $GLOBALS['meta']['adresse_site'] . '/' . _DIR_PLUGIN_SNEDITION . 'css/img/sn-geoloc/sn-marqueur-bulle-ombre.png',
			'iconSize' => [64,64],
			'iconAnchor' => [32,64],
			'popupAnchor' => [-3,-76],
		],
		'punaise_rouge' => [
			'iconUrl' => $GLOBALS['meta']['adresse_site'] . '/' . _DIR_PLUGIN_SNEDITION . 'css/img/sn-geoloc/fa-map-pin-rouge.png',
			'shadowUrl' => $GLOBALS['meta']['adresse_site'] . '/' . _DIR_PLUGIN_SNEDITION . 'css/img/sn-geoloc/sn-marqueur-bulle-ombre.png',
			'iconSize' => [64,64],
			'iconAnchor' => [32,64],
			'popupAnchor' => [-3,-76],
		],
	];
}}

if (!function_exists('const_geoloc_params')){ function const_geoloc_params(){
	return [
		'credit' => '© contributeurs <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>',
		'fond' => 'https://{s}.tile.openstreetmap.fr/osmfr/{z}/{x}/{y}.png',
		'zoom' => 12,
	];
}}
