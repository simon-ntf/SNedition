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

if (!function_exists('snedition_affichage_final')) { function snedition_affichage_final($flux) {

	if($GLOBALS['meta']['sn_geoloc_activer'] == 'on') {
		if(preg_match('#<div class="sn-geoloc#',$flux)){
			$ajouter = '<script type="text/javascript" src="'  . _DIR_PLUGIN_SNEDITION . 'lib/leaflet/leaflet.js"></script>';
			$ajouter .= '<link rel="stylesheet" type="text/css" media="all" href="' . _DIR_PLUGIN_SNEDITION . 'lib/leaflet/leaflet.css"/>';
			$flux = str_replace('<!--sn_insert_head-->','<!--sn_insert_head-->'.$ajouter, $flux);
		}
	}

	if(preg_match('#<div class="sn-swiper#',$flux)){
		$ajouter = '<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>';
		$ajouter .= '<link rel="stylesheet" type="text/css" media="all" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>';
		// Pour charger comme une librairie locale (dans un répertoire /lib) commenter ci-dessus et décommenter ci-dessous
		// $ajouter = '<script type="text/javascript" src="'  . _DIR_PLUGIN_SNEDITION . 'lib/swiper/swiper-bundle.min.js"></script>';
		// $ajouter .= '<link rel="stylesheet" type="text/css" media="all" href="'  . _DIR_PLUGIN_SNEDITION . 'lib/swiper/swiper-bundle.min.css"/>';
		$flux = str_replace('<!--sn_insert_head-->','<!--sn_insert_head-->'.$ajouter, $flux);
	}

	return $flux;

}}

if (!function_exists('snedition_affiche_gauche')) {function snedition_affiche_gauche($flux) {

	if($GLOBALS['meta']['sn_generateur_activer'] == 'on'){
		if ($e = trouver_objet_exec($flux['args']['exec']) AND $e['edition'] == true) {
			include_spip('inc/sn_const');
			$sn_liste_objets_e = sn_global_objet_editable();
			if(in_array($e['type'],$sn_liste_objets_e)){
				if(_request('sn_affichage_edit')){
					session_set('sn_affichage_edit',_request('sn_affichage_edit'));
				}
				$flux['data'] .= recuperer_fond('prive/squelettes/inclure/colonne-sneditable',$flux['args']);
			}
		}
	}

	return $flux;

}}

if (!function_exists('snedition_configurer_liste_metas')) { function snedition_configurer_liste_metas($metas){

	$metas['sn_article_coord_activer'] = 'on'; // off|on
	$metas['sn_contact_activer'] = ''; // off|on
	$metas['sn_contact_auteur'] = ''; // id auteur
	$metas['sn_evt_themes_groupe'] = ''; // id groupe mot
	$metas['sn_evt_activer'] = 'on'; // off|on
	$metas['sn_flux_articles_affichage'] = 'liste'; // liste|grille|diapo
	$metas['sn_generateur_activer'] = 'on'; // on|off
	$metas['sn_geoloc_activer'] = 'on'; // on|off
	$metas['sn_icones_cle'] = ''; // string
	$metas['sn_liens_forcer_onglet_activer'] = ''; // on|off
	$metas['sn_menu_sec_activer'] = 'on'; // on|off
	$metas['sn_menu_ppl'] = 'simple'; // simple|double|mega
	$metas['sn_menu_mega_actu'] = ''; // off|on
	$metas['sn_page_actus_activer'] = 'on'; // on|off
	$metas['sn_page_actus_themes_groupe'] = ''; // id groupe mot
	$metas['sn_page_actus_affichage'] = 'liste'; // liste|grille
	$metas['sn_page_legal_activer'] = 'on'; // on|off
	$metas['sn_partage_activer'] = 'on'; // on|off
	$metas['sn_partage_services'] = ''; // string
	$metas['sn_recherche_images'] = 'on'; // on|off
	$metas['sn_responsable_legal'] = ''; // string
	$metas['sn_tarteaucitron_activer'] = 'on'; // on|off
	$metas['sn_video_activer'] = 'on'; // on|off

	return $metas;

}}

if (!function_exists('snedition_editer_contenu_objet')) { function snedition_editer_contenu_objet($flux) { //print_r($flux['args']['contexte']);

	// Extensions formulaires edition
	$contenu = '';
	if($flux['args']['type'] === 'article') {
		$contenu .= recuperer_fond('prive/inclure/editer/sn_article',$flux['args']['contexte']);
		$flux['data'] = str_replace('<div class="editer editer_texte', $contenu . '<div class="editer editer_texte', $flux['data']);
	}
	if($flux['args']['type'] === 'rubrique') {
		$contenu .= recuperer_fond('prive/inclure/editer/sn_rubrique',$flux['args']['contexte']);
		$flux['data'] = str_replace('<div class="editer editer_texte', $contenu . '<div class="editer editer_texte', $flux['data']);
	}

	return $flux;

}}

if (!function_exists('snedition_formulaire_verifier')) { function snedition_formulaire_verifier($flux) {

	$form = $flux['args']['form'];

	include_spip('inc/sn_regexr');

	// Controler formulaires edition
	if($form === 'editer_article') {
		if (!_request('evt_debut')) {
		} else if(!preg_match(sn_regex_date_spip(),_request('evt_debut'))){
			$erreurs['evt_debut'] = _T('sncore:regex_date_spip');
		}
		if (!_request('evt_fin')) {
		} else if(!preg_match(sn_regex_date_spip(),_request('evt_fin'))){
			$erreurs['evt_fin'] = _T('sncore:regex_date_spip');
		}
		if (!_request('evt_inscr_debut')) {
		} else if(!preg_match(sn_regex_date_spip(),_request('evt_inscr_debut'))){
			$erreurs['evt_inscr_debut'] = _T('sncore:regex_date_spip');
		}
		if (!_request('evt_inscr_fin')) {
		} else if(!preg_match(sn_regex_date_spip(),_request('evt_inscr_fin'))){
			$erreurs['evt_inscr_fin'] = _T('sncore:regex_date_spip');
		}
		if (_request('evt_lieu')) {
			if(!preg_match(sn_regex_txt_etendu(244,0),_request('evt_lieu'))){
				$erreurs['evt_lieu'] = _T('sncore:regex_txt_etendu_nb',array('nb'=>'244'));
			}
		}
		if (_request('evt_texte')) {
			if(!preg_match(sn_regex_txt_etendu(1024,0),_request('evt_texte'))){
				$erreurs['evt_texte'] = _T('sncore:regex_txt_etendu_nb',array('nb'=>'1024'));
			}
		}
	}
	if($form === 'editer_rubrique') {
		$liste_rubrique_menu = sn_const_options_trads('rubrique_menu','S','snedition');
		if (_request('sn_menu')){
			if(!isset($liste_rubrique_menu[_request('sn_menu')])){
				$erreurs['sn_menu'] = _T('sncore:regex_gen');
			}
		}
	}
	if( ($form === 'editer_article') || ($form === 'editer_rubrique') ){
		if(_request('meta_nocache')){
			if(sn_verif_bool_on(_request('meta_nocache')) === true){
			} else {
				$erreurs['meta_nocache'] = _T('sncore:regex_gen');
			}
		}
		if (_request('meta_redirection')){
			$lien = filter_var(_request('meta_redirection'), FILTER_SANITIZE_URL);
			if(strlen(_request('meta_redirection')) > 244){
				$erreurs['meta_redirection'] = _T('sncore:regex_txt_longueur_nb',[nb=>244]);
			} elseif (!filter_var(_request('meta_redirection'), FILTER_VALIDATE_URL)){
				$erreurs['meta_redirection'] = _T('sncore:regex_url');
			}
		}
		if(_request('meta_motsclefs')){
			if(!preg_match(sn_regex_liste_virgules(_request('meta_motsclefs')))){
			} else {
				$erreurs['meta_motsclefs'] = _T('sncore:regex_liste_virgules');
			}
		}
	}

	return $flux;

}}

if (!function_exists('snedition_header_prive')){ function snedition_header_prive($flux) {
	$flux .= '<link rel="stylesheet" type="text/css" href="'._DIR_PLUGIN_SNEDITION.'prive/themes/spip/style.css"/>';
	return $flux;

}}

if (!function_exists('snedition_insert_head')){ function snedition_insert_head($flux) {

	include_spip('inc/snedition');
	$partage_services_datas = sn_partage_services_datas();
	$flux .= const_js_geoloc();
	$flux .= const_js_cookies();
	$flux .= const_js_icones();
	$flux .= '<!--sn_insert_head--><script type="text/javascript" src="'  . _DIR_PLUGIN_SNEDITION . 'javascript/snedition.js"></script>';
	$flux .= '<script type="text/javascript" src="'  . _DIR_PLUGIN_SNEDITION . 'javascript/sndiapo.js"></script>';
	if($GLOBALS['meta']['sn_liens_forcer_onglet_activer'] === 'on'){
		$flux .= '<script type="text/javascript" src="'  . _DIR_PLUGIN_SNEDITION . 'javascript/sn-liens-externes.js"></script>';
	}
	return $flux;

}}

if (!function_exists('snedition_insert_head_css')) { function snedition_insert_head_css($flux) {

	include_spip('inc/session');

	$flux .= '<link rel="stylesheet" type="text/css" media="all" href="' . _DIR_PLUGIN_SNEDITION . 'css/snedition.css"/>';

	$mode_couleur = 'lumineux';
	if(_request('sn_mode_couleur')){
		$mode_couleur = _request('sn_mode_couleur');
	} elseif(session_get('sn_mode_couleur')){
		$mode_couleur = session_get('sn_mode_couleur');
	}
	$chemin_css = find_in_path('css/palette_' . $mode_couleur . '.css');
	if($chemin_css){
		$flux .= '<link rel="stylesheet" type="text/css" media="all" href="' . $chemin_css . '"/>';
	}
	
	return $flux;

}}

if (!function_exists('snedition_pre_edition')) { function snedition_pre_edition($flux) {

	// Conversions de dates
	if ( $flux['args']['type'] === 'article' ) {
		$sql_origine = '0000-00-00 00:00:00';

		$dated = _request('evt_debut');
		$dated_sql = set_request('evt_debut',$sql_origine);
		if( is_array($dated) ){
			$dated_sql = sn_conv_dateheure_saisie_sql($dated);
		}
		set_request('evt_debut',$dated_sql);

		$datef = _request('evt_fin');
		$datef_sql = set_request('evt_fin',$sql_origine);
		if( is_array($datef) ){
			$datef_sql = sn_conv_dateheure_saisie_sql($datef);
		}
		set_request('evt_fin',$datef_sql);

		$inscr = _request('evt_inscr');
		$dated_sql = set_request('evt_inscr',$sql_origine);
		if( is_array($inscr) ){
			$dated_sql = sn_conv_dateheure_saisie_sql($inscr);
		}
		set_request('evt_inscr',$dated_sql);

		$inscrf = _request('evt_inscr_fin');
		$inscrf_sql = $sql_origine;
		if( is_array($inscrf) ){
			$inscrf_sql = sn_conv_dateheure_saisie_sql($inscrf);
		}
		set_request('evt_inscr_fin',$inscrf_sql);
	}

	// Traduction des champs oui/non
	if ( ($flux['args']['type'] === 'article' ) || ($flux['args']['type'] === 'rubrique' ) ) {
		$meta_cache = _request('meta_nocache');
		if( $meta_cache === 'on'){
			set_request('meta_nocache','oui');
		}
	}
	
	return $flux;
	
}}
