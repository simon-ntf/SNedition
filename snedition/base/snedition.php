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
 * Bases de données du plugin SN Edition
 *
 * @plugin snedition
 */

if (!defined('_ECRIRE_INC_VERSION')) {
	return;
}

function snedition_declarer_tables_objets_sql($tables) {
	$tables['spip_articles']['champs_editables'][] = "evt_debut";
	$tables['spip_articles']['champs_editables'][] = "evt_fin";
	$tables['spip_articles']['champs_editables'][] = "evt_inscr";
	$tables['spip_articles']['champs_editables'][] = "evt_inscr_fin";
	$tables['spip_articles']['champs_editables'][] = "evt_inscr_texte";
	$tables['spip_articles']['champs_editables'][] = "evt_lieu";
	$tables['spip_articles']['champs_versionnes'][] = "evt_debut";
	$tables['spip_articles']['champs_versionnes'][] = "evt_fin";
	$tables['spip_articles']['champs_versionnes'][] = "evt_inscr";
	$tables['spip_articles']['champs_versionnes'][] = "evt_inscr_fin";
	$tables['spip_articles']['champs_versionnes'][] = "evt_inscr_texte";
	$tables['spip_articles']['champs_versionnes'][] = "evt_lieu";
	$tables['spip_articles']['champs_versionnes'][] = "meta_nocache";
	$tables['spip_articles']['champs_versionnes'][] = "meta_redirection";
	$tables['spip_articles']['champs_versionnes'][] = "meta_motsclefs";
	$tables['spip_rubriques']['champs_editables'][] = "sn_menu";
	$tables['spip_rubriques']['champs_editables'][] = "meta_nocache";
	$tables['spip_rubriques']['champs_editables'][] = "meta_redirection";
	$tables['spip_rubriques']['champs_editables'][] = "meta_motsclefs";
	return $tables;
}
