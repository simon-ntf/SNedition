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

/**
 * Formulaire de configuration SN Suite
 *
 * @plugin SN Abonnements
 **/
 
if (!defined("_ECRIRE_INC_VERSION")) return;

function formulaires_configurer_snedition_charger_dist(){
	include_spip('inc/sn_const');
	$sn_const_services_partage = sn_global_services_partage();
	$saisies_datas = $sn_const_services_partage;
	$config_datas = sn_conv_liste_array($GLOBALS['meta']['sn_partage_services']);
	foreach($sn_const_services_partage as $cle => $valeur){
		if(isset($config_datas[$cle])){
			$saisies_datas[$cle]['defaut'] = $config_datas[$cle];
		}
	}
	$contexte = [
      'liste_menu_types' => sn_const_options_trads('menu_type','S','snedition'),
      'liste_page_actus_affichages' => sn_const_options_trads('page_actus_affichage','S','snedition'),
      'liste_flux_articles_affichages' => sn_const_options_trads('flux_articles_affichage','S','snedition'),
      'sn_partage_services_datas' => $saisies_datas,
      'sn_articles_blocs_activer' => $GLOBALS['meta']['sn_articles_blocs_activer'],
      'sn_article_coord_activer' => $GLOBALS['meta']['sn_article_coord_activer'],
      'sn_auteurs_blocs_activer' => $GLOBALS['meta']['sn_auteurs_blocs_activer'],
      'sn_contact_activer' => $GLOBALS['meta']['sn_contact_activer'],
      'sn_contact_auteur' => $GLOBALS['meta']['sn_contact_auteur'],
      'sn_evt_activer' => $GLOBALS['meta']['sn_evt_activer'],
      'sn_evt_themes_groupe' => $GLOBALS['meta']['sn_evt_themes_groupe'],
      'sn_flux_articles_affichage' => $GLOBALS['meta']['sn_flux_articles_affichage'],
      'sn_geoloc_activer' => $GLOBALS['meta']['sn_geoloc_activer'],
      'sn_generateur_activer' => $GLOBALS['meta']['sn_generateur_activer'],
      'sn_icones_cle' => $GLOBALS['meta']['sn_icones_cle'],
      'sn_liens_forcer_onglet_activer' => $GLOBALS['meta']['sn_liens_forcer_onglet_activer'],
      'sn_menu_sec_activer' => $GLOBALS['meta']['sn_menu_sec_activer'],
      'sn_menu_ppl' => $GLOBALS['meta']['sn_menu_ppl'],
      'sn_menu_mega_actu' => $GLOBALS['meta']['sn_menu_mega_actu'],
      'sn_page_actus_activer' => $GLOBALS['meta']['sn_page_actus_activer'],
      'sn_page_actus_affichage' => $GLOBALS['meta']['sn_page_actus_affichage'],
      'sn_page_actus_themes_groupe' => $GLOBALS['meta']['sn_page_actus_themes_groupe'],
      'sn_page_legal_activer' => $GLOBALS['meta']['sn_page_legal_activer'],
      'sn_partage_activer' => $GLOBALS['meta']['sn_partage_activer'],
      'sn_recherche_images' => $GLOBALS['meta']['sn_recherche_images'],
      'sn_responsable_legal' => $GLOBALS['meta']['sn_responsable_legal'],
      'sn_tarteaucitron_activer' => $GLOBALS['meta']['sn_tarteaucitron_activer'],
      'sn_video_activer' => $GLOBALS['meta']['sn_video_activer'],
	];
	return $contexte;
}

function formulaires_configurer_snedition_verifier_dist(){

	include_spip('inc/sn_regexr');
	include_spip('inc/sn_const');

	$erreurs = [];

	$sn_const_services_partage = sn_global_services_partage();
	$liste_menu_types = sn_const_options_trads('menu_type','S','snedition');
	$liste_page_actus_affichage = sn_const_options_trads('page_actus_affichage','S','snedition');
	$liste_flux_articles_affichage = sn_const_options_trads('flux_articles_affichage','S','snedition');

	if(!isset($liste_menu_types[_request('sn_menu_ppl')])){
		$erreurs['sn_menu_ppl'] = _T('sncore:regex_gen');
	}
	if(!isset($liste_page_actus_affichage[_request('sn_page_actus_affichage')])){
		$erreurs['sn_page_actus_affichage'] = _T('sncore:regex_gen');
	}
	if(!isset($liste_flux_articles_affichage[_request('sn_flux_articles_affichage')])){
		$erreurs['sn_flux_articles_affichage'] = _T('sncore:regex_gen');
	}

	if(_request('sn_articles_blocs_activer')){
		if(!sn_verif_bool_on(_request('sn_articles_blocs_activer'))){
			$erreurs['sn_articles_blocs_activer'] = _T('sncore:regex_gen');
		}
	}
	if(_request('sn_article_coord_activer')){
		if(!sn_verif_bool_on(_request('sn_article_coord_activer'))){
			$erreurs['sn_article_coord_activer'] = _T('sncore:regex_gen');
		}
	}
	if(_request('sn_auteurs_blocs_activer')){
		if(!sn_verif_bool_on(_request('sn_auteurs_blocs_activer'))){
			$erreurs['sn_auteurs_blocs_activer'] = _T('sncore:regex_gen');
		}
	}
	if(_request('sn_contact_activer')){
		if(!sn_verif_bool_on(_request('sn_contact_activer'))){
			$erreurs['sn_contact_activer'] = _T('sncore:regex_gen');
		}
	}
	if(_request('sn_evt_activer')){
		if(!sn_verif_bool_on(_request('sn_evt_activer'))){
			$erreurs['sn_evt_activer'] = _T('sncore:regex_gen');
		}
	}
	if(_request('sn_geoloc_activer')){
		if(!sn_verif_bool_on(_request('sn_geoloc_activer'))){
			$erreurs['sn_geoloc_activer'] = _T('sncore:regex_gen');
		}
	}
	if(_request('sn_generateur_activer')){
		if(!sn_verif_bool_on(_request('sn_generateur_activer'))){
			$erreurs['sn_generateur_activer'] = _T('sncore:regex_gen');
		}
	}
	if(_request('sn_liens_forcer_onglet_activer')){
		if(!sn_verif_bool_on(_request('sn_liens_forcer_onglet_activer'))){
			$erreurs['sn_liens_forcer_onglet_activer'] = _T('sncore:regex_gen');
		}
	}
	if(_request('sn_menu_sec_activer')){
		if(!sn_verif_bool_on(_request('sn_menu_sec_activer'))){
			$erreurs['sn_menu_sec_activer'] = _T('sncore:regex_gen');
		}
	}
	if(_request('sn_menu_mega_actu')){
		if(!sn_verif_bool_on(_request('sn_menu_mega_actu'))){
			$erreurs['sn_menu_mega_actu'] = _T('sncore:regex_gen');
		}
	}
	if(_request('sn_page_actus_activer')){
		if(!sn_verif_bool_on(_request('sn_page_actus_activer'))){
			$erreurs['sn_page_actus_activer'] = _T('sncore:regex_gen');
		}
	}
	if(_request('sn_page_legal_activer')){
		if(!sn_verif_bool_on(_request('sn_page_legal_activer'))){
			$erreurs['sn_page_legal_activer'] = _T('sncore:regex_gen');
		}
	}
	if(_request('sn_partage_activer')){
		if(!sn_verif_bool_on(_request('sn_partage_activer'))){
			$erreurs['sn_partage_activer'] = _T('sncore:regex_gen');
		}
	}
	if(_request('sn_recherche_images')){
		if(!sn_verif_bool_on(_request('sn_recherche_images'))){
			$erreurs['sn_recherche_images'] = _T('sncore:regex_gen');
		}
	}
	if(_request('sn_tarteaucitron_activer')){
		if(!sn_verif_bool_on(_request('sn_tarteaucitron_activer'))){
			$erreurs['sn_tarteaucitron_activer'] = _T('sncore:regex_gen');
		}
	}
	if(_request('sn_video_activer')){
		if(!sn_verif_bool_on(_request('sn_video_activer'))){
			$erreurs['sn_video_activer'] = _T('sncore:regex_gen');
		}
	}

	if (_request('sn_contact_auteur')){
		if(!preg_match(sn_regex_numid(), _request('sn_contact_auteur'))){
			$erreurs['sn_contact_auteur'] = _T('sncore:regex_spip_id');
		}
	}
	if (_request('sn_evt_themes_groupe')){
		if(!preg_match(sn_regex_numid(), _request('sn_evt_themes_groupe'))){
			$erreurs['sn_evt_themes_groupe'] = _T('sncore:regex_spip_id');
		}
	}
	if (_request('sn_page_actus_themes_groupe')){
		if(!preg_match(sn_regex_numid(), _request('sn_page_actus_themes_groupe'))){
			$erreurs['sn_page_actus_themes_groupe'] = _T('sncore:regex_spip_id');
		}
	}
	if (_request('sn_icones_cle')){
		if(!preg_match(sn_regex_txt_brut(128,0,'-_'), _request('sn_icones_cle'))){
			$erreurs['sn_icones_cle'] = _T('sncore:regex_awesome_icons_cle');
		}
	}
	if (!_request('sn_responsable_legal')){
		$erreurs['sn_responsable_legal'] = _T('info_obligatoire');
	}
	if (_request('sn_responsable_legal')){
		if(!preg_match(sn_regex_txt(64,1), _request('sn_responsable_legal'))){
			$erreurs['sn_responsable_legal'] = _T('sncore:regex_txt_nb',['nb'=>'64']);
		}
	}

	foreach($sn_const_services_partage as $cle => $valeur){
		if(_request('sn_partage_services_'.$cle)){
			if(!sn_verif_bool_on(_request('sn_partage_services_'.$cle))){
				$erreurs['sn_partage_services_'.$cle] = _T('sncore:regex_gen');
			}
		}
	}
	
	return $erreurs;
}

function formulaires_configurer_snedition_traiter_dist(){
	include_spip('inc/config');
	include_spip('inc/sn_const');
	$sn_const_services_partage = sn_global_services_partage();
	$partage_saisies = [];
	foreach($sn_const_services_partage as $cle => $valeur){
		$partage_saisies[$cle] = _request('sn_partage_services_'.$cle);
	}
	$partage_str = sn_conv_array_liste($partage_saisies);
	set_request('sn_partage_services',$partage_str);
	appliquer_modifs_config();
	return ['message_ok'=>_T('config_info_enregistree')];
}
