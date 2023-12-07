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

function formulaires_generer_lien_charger_dist($affichage, $retour=''){
	//si modif dans les config des saisies activer la ligne ci-dessous pour reset les valeurs en session !
	session_set('sn_form_generer_lien_contexte',NULL);

	$liste_objets = sn_const_options_trads('liens_objets','E','snedition');
	$contexte = [
		'lien_ancre' => '',
		'lien_btn' => '',
		'lien_classe' => '',
		'lien_id_objet' => '',
		'lien_objet' => '',
		'lien_titre_texte' => '',
		'lien_url' => '',
		'liste_objets' => $liste_objets,
		'affichage' => $affichage,
	];
	if($session_data = session_get('sn_form_generer_lien_contexte')){
		if(is_array($session_data)){
			foreach($session_data as $cle => $val){
				$contexte[$cle] = $val;
			}
		}
	}
	
	return $contexte;
	
}

function formulaires_generer_lien_verifier_dist($affichage, $retour=''){

	include_spip('inc/sn_regexr');

	$erreurs = [];
	$liste_objets = sn_const_options_trads('liens_objets','E','snedition');
	if (_request('lien_ancre')){
		if(!preg_match(sn_regex_domclasse(), _request('lien_ancre'))){
			$erreurs['lien_ancre'] = _T('sncore:regex_dom_classe');
		}
	}
	if(_request('lien_btn')){
		if(sn_verif_bool_on(_request('lien_btn')) === true){
		} else { $erreurs['lien_btn'] = _T('sncore:regex_gen'); }
	}
	if (_request('lien_classe')){
		if(!preg_match(sn_regex_domclasses(), _request('lien_classe'))){
			$erreurs['lien_classe'] = _T('sncore:regex_dom_classes');
		}
	}
	if (_request('lien_id_objet')){
		if (!preg_match(sn_regex_int(21),_request('lien_id_objet'))){
			$erreurs['lien_id_objet'] = _T('sncore:regex_id_objet');
		}
	}
	if (_request('lien_objet')){
		if(!isset($liste_objets[_request('lien_objet')])){
			$erreurs['lien_objet'] = _T('sncore:regex_gen');
		}
	}
	if (_request('lien_titre_texte')){
		if(!preg_match(sn_regex_txt(256,1), _request('lien_titre_texte'))){ $erreurs['lien_titre_texte'] = _T('sncore:regex_txt_nb',['nb'=>'256']); }
	}
	if(_request('lien_url')){
		$lien = filter_var(_request('lien_url'), FILTER_SANITIZE_URL);
		if(strlen($lien) > 256){
			$erreurs['lien_url'] = _T('sncore:regex_txt_longueur_nb',[nb=>256]);
		}
		else if(!filter_var(_request('lien_url'), FILTER_VALIDATE_URL)){
			$erreurs['lien_url'] = _T('sncore:regex_url');
		}
	}

	return $erreurs;
	
}

function formulaires_generer_lien_traiter_dist($affichage, $retour=''){

	if ($retour) {
		refuser_traiter_formulaire_ajax();
	}
	$modele_contenu = '';
	if(_request('lien_titre_texte')){
		$modele_contenu .= '|t=' . _request('lien_titre_texte');
	}
	if(_request('lien_url')){
		$modele_contenu .= '|l=' . _request('lien_url');
	}
	elseif(_request('lien_objet') && _request('lien_id_objet')) {
		$modele_contenu .= '|l=' . _request('lien_objet') . _request('lien_id_objet');
	}
	if(_request('lien_ancre')){
		$modele_contenu .= '|a=' . _request('lien_ancre');
	}
	if(_request('lien_btn')){
		if(_request('lien_btn') == 'on'){
			$modele_contenu .= '|b=oui';
		}
	}
	if(_request('lien_classe')){
		$modele_contenu .= '|c=' . _request('lien_classe');
	}
	$modele = '<snlien1' . $modele_contenu . '>';
	
	$contexte = [
		'lien_ancre' => _request('lien_ancre'),
		'lien_btn' => _request('lien_btn'),
		'lien_classe' => _request('lien_classe'),
		'lien_id_objet' => _request('lien_id_objet'),
		'lien_objet' => _request('lien_objet'),
		'lien_titre_texte' => _request('lien_titre_texte'),
		'lien_url' => _request('lien_url'),
	];
	session_set('sn_form_generer_lien_contexte',$contexte);
	$retour = ['editable' => true, 'message_ok' => _T('snedition:generer_message_ok') . '<span class="sncolonne-code-genere">' . htmlspecialchars($modele) . '</span>'];
	return $retour;
	
}
