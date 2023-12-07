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

function formulaires_generer_video_charger_dist($affichage, $retour=''){
	//si modif quelconque dans les saisies penser a activer la ligne ci-dessous pour reset les valeurs en session !
	//session_set('sn_form_generer_video_contexte',NULL);
	$contexte = [
		'video_source'=>'',
		'video_largeur'=>'',
		'video_hauteur'=>'',
		'affichage' => $affichage
	];
	if($session_data = session_get('sn_form_generer_video_contexte')){
		if(is_array($session_data)){
			foreach($session_data as $cle => $val){
				$contexte[$cle] = $val;
			}
		}
	}
	return $contexte;
}

function formulaires_generer_video_verifier_dist($affichage, $retour=''){
	include_spip('inc/sn_regexr');
	$erreurs = [];
	if(!preg_match(sn_regex_int(4),_request('video_largeur'))){
		$erreurs['video_largeur'] = _T('sncore:regex_int_nb',['nb'=>'4']);
	}
	if(!preg_match(sn_regex_int(4),_request('video_hauteur'))){
		$erreurs['video_hauteur'] = _T('sncore:regex_int_nb',['nb'=>'4']);
	}
	return $erreurs;
}

function formulaires_generer_video_traiter_dist($affichage, $retour=''){

	if ($retour) {
		refuser_traiter_formulaire_ajax();
	}

	$video_source = '';
	if(_request('video_source')){
		$video_source = _request('video_source');
	}
	$video_largeur = '';
	if(_request('video_largeur')){
		$video_largeur = _request('video_largeur');
	}
	$video_hauteur = '';
	if(_request('video_hauteur')){
		$video_hauteur = _request('video_hauteur');
	}
	
	$modele_contenu = '';
	if($video_source){
		$modele_contenu .= '|source=' . $video_source;
	}
	if($video_largeur){
		$modele_contenu .= '|largeur=' . $video_largeur;
	}
	if($video_hauteur){
		$modele_contenu .= '|hauteur=' . $video_hauteur;
	}
	$modele = '<snvideo1' . $modele_contenu . '>';
	
	$contexte = [
       'video_source' => $video_source,
       'video_largeur' => $video_largeur,
       'video_hauteur' => $video_hauteur
	];
	session_set('sn_form_generer_video_contexte',$contexte);

	$retour = ['editable' => true, 'message_ok' => _T('snedition:generer_message_ok') . '<span class="sncolonne-code-genere">' . htmlspecialchars($modele) . '</span>'];
    
	return $retour;
}
