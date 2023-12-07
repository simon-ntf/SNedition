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

function formulaires_generer_diapo_charger_dist($affichage){

	//si modif quelconque dans les saisies penser à activer la ligne ci-dessous pour mettre à zéro les valeurs en session
    //session_set('sn_form_generer_diapo_contexte',NULL);

	$liste_effets = sn_const_options_trads('diapo_effet','E','snedition');
	$liste_directions = sn_const_options_trads('diapo_direction','E','snedition');
	$liste_paginations = sn_const_options_trads('diapo_pagination','E','snedition');

    $contexte = [
    	'diapo_autoflex' => '',
    	'diapo_autopause' => 'on',
    	'diapo_boucler' => 'on',
    	'diapo_delai' => 5000,
        'diapo_effet' => 'glisse',
        'diapo_direction' => 'horizontal',
        'diapo_hauteur' => 'autodef',
        'diapo_interstice' => 30,
        'diapo_largeur' => '100%',
        'diapo_navigation' => 'on',
        'diapo_pagination' => 'points',
        'diapo_parallaxe' => '',
        'diapo_scrolleur' => '',
        'diapo_vitesse' => 400,
        'liste_effets' => $liste_effets,
        'liste_directions' => $liste_directions,
        'liste_paginations' => $liste_paginations,
        'affichage' => $affichage
    ];
    
    if($session_data = session_get('sn_form_generer_diapo_contexte')){
		if(is_array($session_data)){
			foreach($session_data as $cle => $val){
				$contexte[$cle] = $val;
			}
		}
	}

	return $contexte;
}

function formulaires_generer_diapo_verifier_dist($affichage, $retour=''){

	include_spip('inc/sn_regexr');
	$erreurs = [];
	$liste_effets = sn_const_options_trads('diapo_effet','E','snedition');
	$liste_directions = sn_const_options_trads('diapo_direction','E','snedition');
	$liste_paginations = sn_const_options_trads('diapo_pagination','E','snedition');

	if (_request('diapo_effet')){
		if(!isset($liste_effets[_request('diapo_effet')])){
			$erreurs['diapo_effet'] = _T('sncore:regex_gen');
		}
	}
	if (_request('diapo_direction')){
		if(!isset($liste_directions[_request('diapo_direction')])){
			$erreurs['diapo_direction'] = _T('sncore:regex_gen');
		}
	}
	if (_request('diapo_pagination')){
		if(!isset($liste_paginations[_request('diapo_pagination')])){
			$erreurs['diapo_pagination'] = _T('sncore:regex_gen');
		}
	}
	if(!preg_match(sn_regex_txt(9),_request('diapo_hauteur'))){
		$erreurs['diapo_hauteur'] = _T('sncore:regex_txt',['nb'=>'9']);
	}
	if(!preg_match(sn_regex_txt(9),_request('diapo_largeur'))){
		$erreurs['diapo_largeur'] = _T('sncore:regex_txt',['nb'=>'9']);
	}
	if(!preg_match(sn_regex_int(9),_request('diapo_delai'))){
		$erreurs['diapo_delai'] = _T('sncore:regex_int_nb',['nb'=>'9']);
	}
	if(!preg_match(sn_regex_int(9),_request('diapo_interstice'))){
		$erreurs['diapo_interstice'] = _T('sncore:regex_int_nb',['nb'=>'9']);
	}
	if(!preg_match(sn_regex_int(9),_request('diapo_vitesse'))){
		$erreurs['diapo_vitesse'] = _T('sncore:regex_int_nb',['nb'=>'9']);
	}
	if(_request('diapo_autoflex')){
		if(sn_verif_bool_on(_request('diapo_autoflex')) === true){
		} else {
			$erreurs['diapo_autoflex'] = _T('sncore:regex_gen');
		}
	}
	if(_request('diapo_autopause')){
		if(sn_verif_bool_on(_request('diapo_autopause')) === true){
		} else {
			$erreurs['diapo_autopause'] = _T('sncore:regex_gen');
		}
	}
	if(_request('diapo_boucler')){
		if(sn_verif_bool_on(_request('diapo_boucler')) === true){
		} else {
			$erreurs['diapo_boucler'] = _T('sncore:regex_gen');
		}
	}
	if(_request('diapo_navigation')){
		if(sn_verif_bool_on(_request('diapo_navigation')) === true){
		} else {
			$erreurs['diapo_navigation'] = _T('sncore:regex_gen');
		}
	}
	if(_request('diapo_parallaxe')){
		if(sn_verif_bool_on(_request('diapo_parallaxe')) === true){
		} else {
			$erreurs['diapo_parallaxe'] = _T('sncore:regex_gen');
		}
	}
	if(_request('diapo_scrolleur')){
		if(sn_verif_bool_on(_request('diapo_scrolleur')) === true){
		} else {
			$erreurs['diapo_scrolleur'] = _T('sncore:regex_gen');
		}
	}
	
	return $erreurs;
}

function formulaires_generer_diapo_traiter_dist($affichage, $retour=''){

	if ($retour) {
		refuser_traiter_formulaire_ajax();
	}

	$data_diapo = [];
	$data_saisie = [];
	if(_request('diapo_effet')){
		$data_diapo['effet'] = _request('diapo_effet');
		$data_saisie['diapo_effet'] = _request('diapo_effet');
	}
	if(_request('diapo_direction')){
		$data_diapo['direction'] = _request('diapo_direction');
		$data_saisie['diapo_direction'] = _request('diapo_direction');
	}
	if(_request('diapo_hauteur')){
		$data_diapo['hauteur'] = _request('diapo_hauteur');
		$data_saisie['diapo_hauteur'] = _request('diapo_hauteur');
	}
	if(_request('diapo_largeur')){
		$data_diapo['largeur'] = _request('diapo_largeur');
		$data_saisie['diapo_largeur'] = _request('diapo_largeur');
	}
	if(_request('diapo_delai')){
		if(intval(_request('diapo_delai')) !== 5000){
			$data_diapo['delai'] = intval(_request('diapo_delai'));
		}
		$data_saisie['diapo_delai'] = _request('diapo_delai');
	}
	if(_request('diapo_vitesse')){
		if(intval(_request('diapo_vitesse')) !== 400){
			$data_diapo['vitesse'] = intval(_request('diapo_vitesse'));
		}
		$data_saisie['diapo_vitesse'] = _request('diapo_vitesse');
	}
	$data_saisie['diapo_boucler'] = _request('diapo_boucler');
	if(!_request('diapo_boucler')){
		$data_diapo['boucler'] = 'non';
		$data_saisie['diapo_boucler'] = '';
	}
	if(_request('diapo_pagination')){
		$data_diapo['pagination'] = _request('diapo_pagination');
		$data_saisie['diapo_pagination'] = _request('diapo_pagination');
	}
	if(_request('diapo_navigation')){
		if(_request('diapo_navigation') !== 'on') {
			$data_diapo['navigation'] = 'non';
		}
		$data_saisie['diapo_navigation'] = _request('diapo_navigation');
	}
	if(_request('diapo_scrolleur')){
		if(_request('diapo_scrolleur') == 'on') {
			$data_diapo['scrolleur'] = 'oui';
		}
		$data_saisie['diapo_scrolleur'] = _request('diapo_scrolleur');
	}
	if(_request('diapo_autoflex')){
		if(_request('diapo_autoflex') == 'on') {
			$data_diapo['autoflex'] = 'oui';
		}
		$data_saisie['diapo_autoflex'] = _request('diapo_autoflex');
	}
	if(_request('diapo_autopause')){
		if(_request('diapo_autopause') == 'on') {
			$data_diapo['autopause'] = 'oui';
		}
		$data_saisie['diapo_autopause'] = _request('diapo_autopause');
	}
	if(_request('diapo_parallaxe')){
		if(_request('diapo_parallaxe') == 'on') {
			$data_diapo['parallaxe'] = 'oui';
		}
		$data_saisie['diapo_parallaxe'] = _request('diapo_parallaxe');
	}
	if(_request('diapo_interstice')){
		if(intval(_request('diapo_interstice')) !== 30){
			$data_diapo['interstice'] = intval(_request('diapo_interstice'));
		}
	}

	$modele = '<div class="sn-swiper"';
	foreach($data_diapo as $c => $v){
		$modele .= ' data-' . $c . '="' . $v . '"';
	}
	$modele .= '><div>Mon slide 1</div><div>Mon slide 2</div><div>Mon slide 3</div></div>';
	
    session_set('sn_form_generer_diapo_contexte',$data_saisie, $retour='');
    $retour = ['editable' => true, 'message_ok' => _T('snedition:generer_message_ok') . '<span class="sncolonne-code-genere">' . htmlspecialchars($modele) . '</span>'];
    
	return $retour;
}
