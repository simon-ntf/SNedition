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

function formulaires_generer_infobulle_charger_dist($affichage, $retour=''){
	//si modif quelconque dans les saisies penser a activer la ligne ci-dessous pour reset les valeurs en session !
    //session_set('sn_form_generer_infobulle_contexte',NULL);
    $contexte = [
        'infobulle_texte'=>'',
        'infobulle_legende' => '',
        'affichage' => $affichage
    ];
    if($session_data = session_get('sn_form_generer_infobulle_contexte')){
		if(is_array($session_data)){
			foreach($session_data as $cle => $val){
				$contexte[$cle] = $val;
			}
		}
	}
   return $contexte;
}

function formulaires_generer_infobulle_verifier_dist($affichage, $retour=''){
	include_spip('inc/sn_regexr');
	$erreurs = [];
	if(!preg_match(sn_regex_txt(128,0),_request('infobulle_texte'))){
		$erreurs['infobulle_texte'] = _T('sncore:regex_txt_nb',['nb'=>'128']);
	}
	if(!preg_match(sn_regex_txt(512,0),_request('infobulle_legende'))){
		$erreurs['infobulle_legende'] = _T('sncore:regex_txt_nb',['nb'=>'512']);
	}
	return $erreurs;
}

function formulaires_generer_infobulle_traiter_dist($affichage, $retour=''){
	if ($retour) {
		refuser_traiter_formulaire_ajax();
	}
	$contexte = [
        'infobulle_texte'=>_request('infobulle_texte'),
        'infobulle_legende' => _request('infobulle_legende'),
	];
	$modele_contenu = '';
	if($contexte['infobulle_texte']){
		$modele_contenu .= '|texte=' . $contexte['infobulle_texte'];
	}
	if($contexte['infobulle_legende']){
		$modele_contenu .= '|legende=' . $contexte['infobulle_legende'];
	}
	$modele = '<snbulle1' . $modele_contenu . '>';
	session_set('sn_form_generer_infobulle_contexte',$contexte);
	$retour = ['editable' => true, 'message_ok' => _T('snedition:generer_message_ok') . '<span class="sncolonne-code-genere">' . htmlspecialchars($modele) . '</span>'];
	return $retour;
}
