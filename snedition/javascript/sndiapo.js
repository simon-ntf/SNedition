// JavaScript Document

/***************************************************************************\
 *  SN Edition, Plugin pour SPIP / GNU-GPL													*
 *  Copyright (c) Simon N																*
\***************************************************************************/

/***************************************************************************\

parametre		defaut		effet : fondu
autoflex		non			auto ajustement avec flex : oui | non
autopause		oui			mettre en pause le defilement automatique quand la souris est au dessus
boucler			oui			boucler (cube le desactive automatiquement car ne marche pas avec) : oui | non
css_mode		non			Mode CSS seulement (la plupart des effets ne marchent pas dans ce mode)
delai			5000		delai du defilement automatique en ms : n(int)
direction		horizontal	sens du diaporama : horizontal | vertical
effet			glisse		type animation : glisse | cartes | cube | diapositive | fondu | retourne
hauteur			0			hauteur CSS : valeur css ou "autodef" pour automatiser en fonction de la taille des slides
interstice		30			espace entre les slides en pixels
largeur			0			largeur CSS : valeur css ou "autodef" pour automatiser en fonction de la taille des slides
navigation		oui			placer des boutons de navigation avant et apres : oui | non
nb_visibles		auto		nombre de slides visibles : n(int) | auto
pagination		points		type de pagination : points | progression (barre de progression sans scroll) | numerotation (numerotation) | point-num (numerotation + points) | non (desactive)
parallaxe		non			active les effets de parallaxe (mettre a tout element un attribut data-swiper-parallax avec une valeur negative pour parametrer le decalage en pixels)
scrolleur		non			placer un scrolleur : oui | non (pour desactiver)
vitesse			400			vitesse de l anim du changement de slide en ms : n(int) | 0 (pour desactiver)

\***************************************************************************/

var swiper_effects = {
	'cartes':'cards',
	'cube':'cube',
	'diapo':'coverflow',
	'fondu':'fade',
	'glisse':null,
	'retourne':'flip',
};

(function($){
	$(window).on('load',function(){
		var sn_swipers = [];
		var sn_swipers_index = 0;
		var this_sn_swiper;
		$(".sn-swiper").each(function(index, element) {
			if($(this).css('display') == 'none'){} else {
			 this_sn_swiper = snSwiper($(this),sn_swipers_index);
			 sn_swipers.push(this_sn_swiper);
			 sn_swipers_index++;
			}
		});
	});
	function snSwiper($snswiper,snswiper_index){
		if($snswiper.attr('id')){} else { $snswiper.attr('id','snswiper' + snswiper_index); }
		var snswiper_id = $snswiper.attr('id');

		// Si un wrapper existant est donne en data on ne reconstruit pas la structure
		var snswiper_structurer = true;
		if($snswiper.data('id_wrapper') != null){
			if($('#' + $snswiper.data('id_wrapper')) != null){
				snswiper_structurer = false;
			}
		}

		// Parametrage par defaut
		var swiper_datas = {
			'autoplay': {
				'delay': 5000,
				'pauseOnMouseEnter': true,
			},
			'direction': 'horizontal',
			'slidesPerView':'auto',
			'spaceBetween': 30,
			'loop': true,
			'speed': 400,
		};
		swiper_datas.navigation = {
			'nextEl': '.swiper-button-next-' + snswiper_id,
			'prevEl': '.swiper-button-prev-' + snswiper_id,
		};
		swiper_datas.pagination = {
			'el': '.swiper-pagination-' + snswiper_id,
			'clickable': true,
		};
		swiper_datas.scrollbar = {
			'el': '.swiper-scrollbar-' + snswiper_id,
			'draggable': true,
		};

		// Parametrages personnalises
		if($snswiper.data('autoflex') != null){
			if($snswiper.data('autoflex') == "oui"){
				$snswiper.addClass('sn-swiper-flex');
			}
		}
		if($snswiper.data('boucler') != null){
			if($snswiper.data('boucler') == "oui"){
				swiper_datas.loop = true;
			} else {
				swiper_datas.loop = false;
			}
		}
		if($snswiper.data('mode_css') != null){
			if($snswiper.data('mode_css') == "oui"){
				swiper_datas.css_mode = true;
			}
		}
		if($snswiper.data('delai') != null){
			swiper_datas.autoplay = {
				'delay': parseInt($snswiper.data('delai')),
			};
			if($snswiper.data('autopause') != null){
				if($snswiper.data('autopause') == "non"){
					$snswiper.delay.pauseOnMouseEnter = false;
				}
			}
			if($snswiper.data('delai') == 0){
				$snswiper.delay = null
			}
		}
		if($snswiper.data('direction') != null){
			swiper_datas.direction = $snswiper.data('direction');
		}
		if($snswiper.data('effet') != null){
			if(swiper_effects[$snswiper.data('effet')] != null){
				swiper_datas.effect = swiper_effects[$snswiper.data('effet')];
				if(swiper_datas.effect == 'coverflow'){
					swiper_datas.coverflowEffect = {
						'rotate': 30,
						'slideShadows': false,
					}
				} else if(swiper_datas.effect == 'cube'){
					swiper_datas.cubeEffect = {
						'shadow': true,
						'slideShadows': true,
						'shadowOffset': 20,
						'shadowScale': 0.94,
					};
					swiper_datas.cssMode = false,
					swiper_datas.loop = false;
				} else if(swiper_datas.effect == 'fade'){
					swiper_datas.fadeEffect = {
						'crossFade': true,
					}
				}
			}
		}
		if($snswiper.data('interstice') != null){
			swiper_datas.spaceBetween = $snswiper.data('interstice');
		}
		if($snswiper.data('navigation') != null){
			if($snswiper.data('navigation') == "non"){
				swiper_datas.navigation = false;
			}
		}
		if($snswiper.data('nb_visibles') != null){
			if($snswiper.data('nb_visibles') !== "auto"){
				swiper_datas.slidesPerView = $snswiper.data('nb_visibles');
			}
		}
		if($snswiper.data('pagination') != null){
			if($snswiper.data('pagination') == "non"){
				swiper_datas.pagination = false;
			} else {
				if($snswiper.data('pagination') == "progression"){
					swiper_datas.pagination.type = 'progressbar';
				} else if($snswiper.data('pagination') == "numerotation"){
					swiper_datas.pagination.type = 'fraction';
				} else if ($snswiper.data('pagination') == "point-num") {
					swiper_datas.pagination.clickable = true;
					swiper_datas.pagination.bulletClass = 'swiper-pagination-bullet sn-swiper-pagination-bullet-pointnum';
					swiper_datas.pagination.renderBullet = function (index, className) {
						return '<span class="' + className + '">' + (index + 1) + "</span>";
					};
				}
			}
		}
		if($snswiper.data('parallaxe') != null){
			if($snswiper.data('parallaxe') == 'oui'){
				swiper_datas.parallax = true;
			}
		}
		if($snswiper.data('scrolleur') == null){
			swiper_datas.scrollbar = false;
		} else if($snswiper.data('scrolleur') == 'non'){
			swiper_datas.scrollbar = false;
		}
		if($snswiper.data('vitesse') != null){
			swiper_datas.speed = parseInt($snswiper.data('vitesse'));
		}

		// Si necessaire construire la structure a la volee
		if(snswiper_structurer === true){
			$snswiper.addClass('swiper');

			$snswiper_wrapper = $('<div id="' + snswiper_id + '-wrapper" class="swiper-wrapper swiper-wrapper-' + snswiper_id + '"></div>');

			$snswiper.children('li,div').addClass('swiper-slide');
			$snswiper.children('li,div').appendTo($snswiper_wrapper);

			$snswiper_wrapper.appendTo($snswiper);

			if(swiper_datas.navigation !== false){
				$snswiper_btn_prev = $('<div id="' + snswiper_id + '-btn-prev" class="swiper-button-prev swiper-button-prev-' + snswiper_id + '"></div>');
				$snswiper_btn_next = $('<div id="' + snswiper_id + '-btn-next" class="swiper-button-next swiper-button-next-' + snswiper_id + '"></div>');
				$snswiper_btn_prev.appendTo($snswiper);
				$snswiper_btn_next.appendTo($snswiper);
			}

			if(swiper_datas.scrollbar == true){
				$snswiper_scrollbar = $('<div id="' + snswiper_id + '-scrollbar" class="swiper-scrollbar swiper-scrollbar-' + snswiper_id + '"></div>');
				$snswiper_scrollbar.appendTo($snswiper);
			}

			if(swiper_datas.pagination !== false){
				$snswiper_pagination = $('<div id="' + snswiper_id + '-pagination" class="swiper-pagination swiper-pagination-' + snswiper_id + '"></div>');
				$snswiper_pagination.appendTo($snswiper);
			}
		}

		if($snswiper.data('largeur') != null){
			var snswiper_largeur = 0;
			if($snswiper.data('largeur') == 'autodef'){
				var largeur_vue_max = 0;
				$snswiper_wrapper.children('.swiper-slide').each(function(){
			    	if($(this).outerWidth() > largeur_vue_max){
			    		largeur_vue_max = $(this).outerWidth();
			    	}
				});
				largeur_vue_max += 20;
				snswiper_largeur = largeur_vue_max + 'px';
			} else {
				snswiper_largeur = $snswiper.data('largeur');
			}
			$snswiper.css('width', snswiper_largeur);
		}

		if($snswiper.data('hauteur') != null){
			var snswiper_hauteur = 0;
			if($snswiper.data('hauteur') == 'autodef'){
				var hauteur_vue_max = 0;
				$snswiper_wrapper.children('.swiper-slide').each(function(){
			    	if($(this).outerHeight() > hauteur_vue_max){
			    		hauteur_vue_max = $(this).outerHeight();
			    	}
				});
				hauteur_vue_max += 20;
				snswiper_hauteur = hauteur_vue_max + 'px';
			} else {
				snswiper_hauteur = $snswiper.data('hauteur');
			}
			$snswiper.css('height', snswiper_hauteur);
		}

		// Creation du swiper
		return new Swiper('#' + snswiper_id, swiper_datas);

	}
})(jQuery)

/*** SN Edition|snimages.js : end ***/
