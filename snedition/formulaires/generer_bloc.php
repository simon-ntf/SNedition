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

function formulaires_generer_bloc_charger_dist($affichage, $retour=''){
	//si modif dans les config des saisies activer la ligne ci-dessous pour reset les valeurs en session !
	//session_set('sn_form_generer_bloc_contexte',NULL);

	$liste_niveaux = sn_const_options_trads('titre_niveau','E','snedition');
	$liste_bloc_styles = sn_const_options_trads('bloc_style','E','snedition');
	$contexte = [
		'bloc_titre_texte' => '',
		'bloc_titre_niveau' => '',
		'bloc_classe' => '',
		'bloc_colonnes' => '',
		'bloc_style' => '',
		'bloc_acc' => '',
		'bloc_plie' => '',
		'liste_niveaux' => $liste_niveaux,
		'liste_bloc_styles' => $liste_bloc_styles,
		'liste_bloc_colonnes' => $liste_bloc_colonnes,
		'affichage' => $affichage,
	];
	if($session_data = session_get('sn_form_generer_bloc_contexte')){
		if(is_array($session_data)){
			foreach($session_data as $cle => $val){
				$contexte[$cle] = $val;
			}
		}
	}
	
	return $contexte;
	
}

function formulaires_generer_bloc_verifier_dist($affichage, $retour=''){

	include_spip('inc/sn_regexr');

	$erreurs = [];
	$liste_niveaux = sn_const_options_trads('titre_niveau','E','snedition');
	$liste_bloc_styles = sn_const_options_trads('bloc_style','E','snedition');
	if (!_request('bloc_titre_niveau')){
		$erreurs['bloc_titre_niveau'] = _T('info_obligatoire');
	}
	if (_request('bloc_titre_niveau')){
		if(!isset($liste_niveaux[_request('bloc_titre_niveau')])){
			$erreurs['bloc_titre_niveau'] = _T('sncore:regex_gen');
		}
	}
	if (_request('bloc_style')){
		if(!isset($liste_bloc_styles[_request('bloc_style')])){
			$erreurs['bloc_style'] = _T('sncore:regex_gen');
		}
	}
	if (_request('bloc_colonnes')){
		if(!preg_match(sn_regex_int(1), _request('bloc_colonnes'))){
			$erreurs['bloc_colonnes'] = _T('regex_int_nb',['nb'=>'1']);
		}
	}
	if (!_request('bloc_titre_texte')){
		$erreurs['bloc_titre_texte'] = _T('info_obligatoire');
	}
	if (_request('bloc_titre_texte')){
		if(!preg_match(sn_regex_txt(256,1), _request('bloc_titre_texte'))){
			$erreurs['bloc_titre_texte'] = _T('sncore:regex_txt_nb',['nb'=>'256']);
		}
	}
	if (_request('bloc_classe')){
		if(!preg_match(sn_regex_domclasses(), _request('bloc_classe'))){
			$erreurs['bloc_classe'] = _T('sncore:regex_dom_classes');
		}
	}
	if(_request('bloc_acc')){
		if(sn_verif_bool_on(_request('bloc_acc')) === true){
		} else {
			$erreurs['bloc_acc'] = _T('sncore:regex_gen');
		}
	}
	if(_request('bloc_plie')){
		if(sn_verif_bool_on(_request('bloc_plie')) === true){
		} else {
			$erreurs['bloc_plie'] = _T('sncore:regex_gen');
		}
	}

	return $erreurs;
}

function formulaires_generer_bloc_traiter_dist($affichage, $retour=''){

	if ($retour) {
		refuser_traiter_formulaire_ajax();
	}

	$ajout_contenu = '|contenu=' . _T('snedition:masque_remplacement_html');
	$modele_contenu = '';

	if(_request('bloc_acc')){
		if(_request('bloc_acc') == 'on'){
			$modele_contenu .= '|accordeon=oui';
		}
	}
	if(_request('bloc_classe')){
		$modele_contenu .= '|classe=' . _request('bloc_classe');
	}
	if(_request('bloc_colonnes')){
		$modele_contenu .= '|colonnes=' . _request('bloc_colonnes');
	}
	if(_request('bloc_plie')){
		if(_request('bloc_plie') == 'on'){
			$modele_contenu .= '|plie=oui';
		}
	}
	if(_request('bloc_style')){
		$modele_contenu .= '|style=' . _request('bloc_style');
	}
	if(_request('bloc_titre_niveau')){
		$modele_contenu .= '|niveau=' . _request('bloc_titre_niveau');
	}
	if(_request('bloc_titre_texte')){
		$modele_contenu .= '|titre=' . _request('bloc_titre_texte');
	}

	$modele = '<snbloc1' . $modele_contenu . $ajout_contenu . '>';

	$contexte = [
		'bloc_titre_texte' => _request('bloc_titre_texte'),
		'bloc_titre_niveau' => _request('bloc_titre_niveau'),
		'bloc_classe' => _request('bloc_classe'),
		'bloc_colonnes' => _request('bloc_colonnes'),
		'bloc_style' => _request('bloc_style'),
		'bloc_acc' => _request('bloc_acc'),
		'bloc_plie' => _request('bloc_plie')
	];
	session_set('sn_form_generer_bloc_contexte',$contexte);

	$retour = ['editable' => true, 'message_ok' => _T('snedition:generer_message_ok') . '<span class="sncolonne-code-genere">' . htmlspecialchars($modele) . '</span>'];
    
	return $retour;
}

?>