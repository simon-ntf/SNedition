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

if (!defined("_ECRIRE_INC_VERSION")) return;

function formulaires_generer_geoloc_charger_dist($affichage, $retour=''){
	//si modif quelconque dans les saisies penser a activer la ligne ci-dessous pour reset les valeurs en session !
    //session_set('sn_form_generer_geoloc_contexte',NULL);
	include_spip('inc/sn_const');
	include_spip('inc/snedition');
	$sn_const_geoloc_params = const_geoloc_params();
	$sn_const_geoloc_marqueur_styles = const_geoloc_marqueurs();

    $liste_geoloc_formats = sn_const_options_trads('geoloc_format','E','snedition');

    $liste_marqueurs_styles = [];
    foreach($sn_const_geoloc_marqueur_styles as $cle => $valeur){
        $liste_marqueurs_styles[$cle] = _T('snedition:opt_geoloc_marqueur_style_' . $cle);
    }

    $contexte = [
        'geoloc_lat'=>'',
        'geoloc_lon'=>'',
        'geoloc_format'=>'moyen',
        'geoloc_marqueur'=>'leaflet_defaut',
        'geoloc_texte'=>'',
        'geoloc_zoom'=>$sn_const_geoloc_params['zoom'],
        'liste_geoloc_formats' => $liste_geoloc_formats,
        'liste_geoloc_marqueurs_styles' => $liste_marqueurs_styles,
        'affichage' => $affichage
    ];
    if($session_data = session_get('sn_form_generer_geoloc_contexte')){
		if(is_array($session_data)){
			foreach($session_data as $cle => $val){
				$contexte[$cle] = $val;
			}
		}
	}
   return $contexte;
}

function formulaires_generer_geoloc_verifier_dist($affichage, $retour=''){
    include_spip('inc/sn_regexr');
    include_spip('inc/sn_const');
	include_spip('inc/snedition');
	$sn_const_geoloc_marqueur_styles = const_geoloc_marqueurs();
	$erreurs = [];
	$liste_geoloc_formats = sn_const_options_trads('geoloc_format','E','snedition');
    $liste_marqueurs_styles = [];
    foreach($sn_const_geoloc_marqueur_styles as $cle => $valeur){
        $liste_marqueurs_styles[$cle] = _T('snedition:opt_geoloc_marqueur_style_' . $cle);
    }
	if(!preg_match(sn_regex_geoloc_lat(),_request('geoloc_lat'))){
		$erreurs['geoloc_lat'] = _T('sncore:regex_lat');
	}
	if(!preg_match(sn_regex_geoloc_lon(),_request('geoloc_lon'))){
		$erreurs['geoloc_lon'] = _T('sncore:regex_lon');
	}
	if (_request('geoloc_format')){
		if(!isset($liste_geoloc_formats[_request('geoloc_format')])){
			$erreurs['geoloc_format'] = _T('sncore:regex_gen');
		}
	}
	if (_request('geoloc_marqueur')){
		if(!isset($liste_marqueurs_styles[_request('geoloc_marqueur')])){
			$erreurs['geoloc_marqueur'] = _T('sncore:regex_gen');
		}
	}
	if(!preg_match(sn_regex_txt(256,0),_request('geoloc_texte'))){
		$erreurs['geoloc_texte'] = _T('sncore:regex_txt_nb',['nb'=>'256']);
	}
	if(!preg_match(sn_regex_int(2),_request('geoloc_zoom'))){
		$erreurs['geoloc_zoom'] = _T('sncore:regex_int_nb',['nb'=>'2']);
	}
	return $erreurs;
}

function formulaires_generer_geoloc_traiter_dist($affichage, $retour=''){

	if ($retour) {
		refuser_traiter_formulaire_ajax();
	}
	include_spip('inc/sn_const');
	include_spip('inc/snedition');
	$sn_const_geoloc_params = const_geoloc_params();

	$geoloc_lat = '';
	if(_request('geoloc_lat')){
		$geoloc_lat = _request('geoloc_lat');
	}
	$geoloc_lon = '';
	if(_request('geoloc_lon')){
		$geoloc_lon = _request('geoloc_lon');
	}
	$geoloc_format = 'moyen';
	if(_request('geoloc_format')){
		$geoloc_format = _request('geoloc_format');
	}
	$geoloc_marqueur = 'leaflet_defaut';
	if(_request('geoloc_marqueur')){
		$geoloc_marqueur = _request('geoloc_marqueur');
	}
	$geoloc_texte = '';
	if(_request('geoloc_texte')){
		$geoloc_texte = _request('geoloc_texte');
	}
	$geoloc_zoom = $sn_const_geoloc_params['zoom'];
	if(_request('geoloc_zoom')){
		$geoloc_zoom = _request('geoloc_zoom');
	}
	$localisation = [
	   	'lat' => $geoloc_lat,
	   	'lon' => $geoloc_lon,
	   	'marqueur' => $geoloc_marqueur,
	   	'texte' => $geoloc_texte,
	];
	$geoloc_data = json_encode([$localisation]);
	$modele_contenu .= '|geoloc=' . $geoloc_data;
	$modele_contenu .= '|format=' . $geoloc_format;
	$modele_contenu .= '|zoom=' . $geoloc_zoom;
   
	$modele = '<sngeoloc1' . $modele_contenu . '>';
	
	$contexte = [
	   	'geoloc_lat' => $geoloc_lat,
	   	'geoloc_lon' => $geoloc_lon,
	   	'geoloc_format' => $geoloc_format,
		'geoloc_marqueur' => $geoloc_marqueur,
		'geoloc_texte' => $geoloc_texte,
		'geoloc_zoom' => $geoloc_zoom,
	];
	session_set('sn_form_generer_geoloc_contexte',$contexte);
	$retour = ['editable' => true, 'message_ok' => _T('snedition:generer_message_ok') . '<span class="sncolonne-code-genere">' . htmlspecialchars($modele) . '</span>'];
	return $retour;
}
