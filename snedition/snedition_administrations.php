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

function snedition_upgrade($nom_meta_base_version, $version_cible){
	$maj = [];
	$maj['create'] = [
		['sql_alter', "table spip_articles ADD evt_debut datetime DEFAULT '0000-00-00 00:00:00' NOT NULL"],
		['sql_alter', "table spip_articles ADD evt_fin datetime DEFAULT '0000-00-00 00:00:00' NOT NULL"],
		['sql_alter', "table spip_articles ADD evt_inscr datetime DEFAULT '0000-00-00 00:00:00' NOT NULL"],
		['sql_alter', "table spip_articles ADD evt_inscr_fin datetime DEFAULT '0000-00-00 00:00:00' NOT NULL"],
		['sql_alter', "table spip_articles ADD evt_inscr_texte varchar(510) NOT NULL"],
		['sql_alter', "table spip_articles ADD evt_lieu varchar(255) DEFAULT '' NOT NULL"],
		['sql_alter', "table spip_articles ADD meta_nocache varchar(32) DEFAULT '' NOT NULL"],
		['sql_alter', "table spip_articles ADD meta_redirection varchar(32) DEFAULT '' NOT NULL"],
		['sql_alter', "table spip_articles ADD meta_motsclefs varchar(32) DEFAULT '' NOT NULL"],
		['sql_alter', "table spip_rubriques ADD sn_menu varchar(8) DEFAULT 'horsmenu' NOT NULL"],
		['sql_alter', "table spip_rubriques ADD meta_nocache varchar(32) DEFAULT '' NOT NULL"],
		['sql_alter', "table spip_rubriques ADD meta_redirection varchar(32) DEFAULT '' NOT NULL"],
		['sql_alter', "table spip_rubriques ADD meta_motsclefs varchar(32) DEFAULT '' NOT NULL"],
	];
	include_spip('base/upgrade');
	maj_plugin($nom_meta_base_version, $version_cible, $maj);
}
function snedition_vider_tables($nom_meta_base_version) {
	sql_alter("table spip_articles DROP evt_debut");
	sql_alter("table spip_articles DROP evt_fin");
	sql_alter("table spip_articles DROP evt_inscr");
	sql_alter("table spip_articles DROP evt_inscr_fin");
	sql_alter("table spip_articles DROP evt_inscr_texte");
	sql_alter("table spip_articles DROP evt_lieu");
	sql_alter("table spip_articles DROP meta_nocache");
	sql_alter("table spip_articles DROP meta_redirection");
	sql_alter("table spip_articles DROP meta_motsclefs");
	sql_alter("table spip_rubriques DROP sn_menu");
	sql_alter("table spip_rubriques DROP meta_nocache");
	sql_alter("table spip_rubriques DROP meta_redirection");
	sql_alter("table spip_rubriques DROP meta_motsclefs");
	effacer_meta($nom_meta_base_version);
}
