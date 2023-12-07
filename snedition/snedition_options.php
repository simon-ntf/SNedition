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

define('_SN_MODE_COULEUR_ACTIF', true);
define('_SN_MODE_COULEUR_DEFAUT', 'lumineux');
define('_SN_MODE_TYPO_ACTIF', true);
define('_SN_MODE_TYPO_DEFAUT', 100);

/* Recuperer et diffuser le mode couleur */
function sn_mode_couleur_definir(){
	include_spip('inc/session');
	// si besoin de remettre à zéro le mode couleur décommenter ci-dessous
	// session_set('sn_mode_couleur','');
	$mode = '';
	if(_request('sn_mode_couleur')){
		$mode = _request('sn_mode_couleur');
		session_set('sn_mode_couleur',$mode);
	} elseif(session_get('sn_mode_couleur')){
		$mode = session_get('sn_mode_couleur');
	} else{
		$mode = strval(_SN_MODE_COULEUR_DEFAUT);
		session_set('sn_mode_couleur',$mode);
	}
	set_request('sn_mode_couleur',$mode);
	return true;
}

/* Recuperer et diffuser la taille de typo */
function sn_mode_typo_definir(){
	include_spip('inc/session');
	$mode = '';
	if(_request('sn_mode_typo')){
		$mode = _request('sn_mode_typo');
		session_set('sn_mode_typo',$mode);
	} elseif(session_get('sn_mode_typo')){
		$mode = session_get('sn_mode_typo');
	} else{
		$mode = strval(_SN_MODE_TYPO_DEFAUT);
		session_set('sn_mode_typo',$mode);
	}
	set_request('sn_mode_typo',$mode);
	return true;
}
if(_SN_MODE_COULEUR_ACTIF === true){
	$exe_mode_couleur_definir = sn_mode_couleur_definir();
}
if(_SN_MODE_TYPO_ACTIF === true){
	$exe_mode_typo_definir = sn_mode_typo_definir();
}
