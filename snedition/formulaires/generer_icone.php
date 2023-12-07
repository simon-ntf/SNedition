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

function formulaires_generer_icone_charger_dist($affichage, $retour=''){
	//si modif quelconque dans les saisies penser a activer la ligne ci-dessous pour reset les valeurs en session !
    //session_set('sn_form_generer_icone_contexte',NULL);

    $liste_fa_styles = sn_const_options_trads('fa_icones_style','E','snedition');
    $liste_fa_tailles = sn_const_options_liste('E','fa_icones_taille');
    $contexte = [
        'fa_ref'=>'',
        'fa_style'=>'',
        'fa_taille'=>'',
        'fa_classe'=>'',
        'fa_mode_bouton'=>'',
        'liste_fa_styles'=>$liste_fa_styles,
        'liste_fa_tailles'=>$liste_fa_tailles,
        'affichage' => $affichage
    ];
    if($session_data = session_get('sn_form_generer_icone_contexte')){
		if(is_array($session_data)){
			foreach($session_data as $cle => $val){
				$contexte[$cle] = $val;
			}
		}
	}
   return $contexte;
}

function formulaires_generer_icone_verifier_dist($affichage, $retour=''){
	include_spip('inc/sn_regexr');
	$erreurs = [];

    $liste_fa_styles = sn_const_options_trads('fa_icones_style','E','snedition');
    $liste_fa_tailles = sn_const_options_liste('E','fa_icones_taille');

	if(!preg_match(sn_regex_txt(128,0),_request('fa_ref'))){
		$erreurs['fa_ref'] = _T('sncore:regex_txt_nb',['nb'=>'128']);
	}
	if (!_request('fa_style')){
		$erreurs['fa_style'] = _T('info_obligatoire');
	} else{
		if(!isset($liste_fa_styles[_request('fa_style')])){
			$erreurs['fa_style'] = _T('sncore:regex_gen');
		}
	}
	if (_request('fa_taille')){
		if(!isset($liste_fa_tailles[_request('fa_taille')])){
			$erreurs['fa_taille'] = _T('sncore:regex_gen');
		}
	}
	if (_request('fa_classe')){
		if(!preg_match(sn_regex_domclasses(), _request('fa_classe'))){
			$erreurs['fa_classe'] = _T('sncore:regex_dom_classes');
		}
	}
	if(_request('fa_mode_bouton')){
		if(sn_verif_bool_on(_request('fa_mode_bouton')) === true){
		} else {
			$erreurs['fa_mode_bouton'] = _T('sncore:regex_gen');
		}
	}
	
	return $erreurs;
}

function formulaires_generer_icone_traiter_dist($affichage, $retour=''){
	if ($retour) {
		refuser_traiter_formulaire_ajax();
	}
	$liste_fa_tailles = sn_const_options_liste('E','fa_icones_taille');
	$contexte = [
        'fa_ref'=>_request('fa_ref'),
        'fa_style'=>_request('fa_style'),
        'fa_taille'=>_request('fa_taille'),
        'fa_classe'=>_request('fa_classe'),
        'fa_mode_bouton'=>_request('fa_mode_bouton'),
	];
	$modele_contenu = '';
	if($contexte['fa_ref']){
		$modele_contenu .= '|fa_ref=' . $contexte['fa_ref'];
	}
	if($contexte['fa_style']){
		$modele_contenu .= '|fa_style=' . $contexte['fa_style'];
	}
	if($contexte['fa_taille']){
		if(_request('fa_taille') == 'normal') {
		} else {
			$modele_contenu .= '|fa_taille=' . $liste_fa_tailles[$contexte['fa_taille']];
		}
	}
	if($contexte['fa_classe']){
		if(_request('fa_taille') == '') {
		} else {
			$modele_contenu .= '|fa_classe=' . $contexte['fa_classe'];
		}
	}
	if($contexte['fa_mode_bouton']){
		if(_request('fa_mode_bouton') == 'on') {
			$modele_contenu .= '|fa_mode_bouton=oui';
		}
	}
	$modele = '<snicone1' . $modele_contenu . '>';
	session_set('sn_form_generer_icone_contexte',$contexte);
	$retour = ['editable' => true, 'message_ok' => _T('snedition:generer_message_ok') . '<span class="sncolonne-code-genere">' . htmlspecialchars($modele) . '</span>'];
	return $retour;
}
