// JavaScript Document

/***************************************************************************\
 *  SN Edition, Plugin pour SPIP / GNU-GPL													*
 *  Copyright (c) Simon N																*
\***************************************************************************/

/******************* SnEdition *******************/

var SN_JSACTIONS = {
	imprimer:{label:'imprimer',propagation:false},
	envoyer:{label:'envoyer',propagation:true}
};

(function($){
	
	$(window).on('load',function(){
        snMenusFlottants();
        snMenuMobile();
        snSuperAccordeons();
        snCitations();
        snGeolocs();
        snJsActions();
        if($('#nav .sn-nav-mega-items')){ snMenuMega(); }
        $('.sn-bulle').each(function(){ snBulleActiver($(this)); });
	});
	function snBulleActiver($ib) {
		$ib.on('click',function(e){ e.preventDefault(); e.stopPropagation(); snBulleAfficher($ib,e); });
		return true;
	}
	function snBulleAfficher($ib,e){
		$ib.children('.sn-bulle-bulle').css('left','-10px');
		$ib.toggleClass('sn-bulle-active');
		return true;
	}

	function snCitations(){
		$('.texte blockquote').each(function(){ snCitationIconiser($(this)); });
		function snCitationIconiser($cible){
			if(($cible).hasClass('sn-cit-en')){
				$('<span class="fas fa-quote-left"></span>').prependTo($cible);
				$('<span class="fas fa-quote-right"></span>').appendTo($cible);
			} else {
				$('<span class="fas fa-angle-double-left"></span>').prependTo($cible);
				$('<span class="fas fa-angle-double-right"></span>').appendTo($cible);
			}
		}
	}

	function snJsActions(){
		$('.sn-js-action').each(function () {
			if(SN_JSACTIONS[$(this).attr('name')]){
				$(this).on('click',function(e){
					snJsActionTraiter($(this).attr('name'),$(this),e);
					if(SN_JSACTIONS[$(this).attr('name')].propagation === true){} else {
						e.preventDefault();
						e.stopPropagation();
					}
				});
			}
		})
		function snJsActionTraiter(action,$bouton,e){
			if (action == 'envoyer') { snJsActionEnvoyerUrl($bouton,e); }
			else if (action == 'imprimer') { snJsActionImprimerPage($bouton,e); }
			else { return false; }
			return true;
		}
		function snJsActionEnvoyerUrl($bouton,e){
			return true;
		}
		function snJsActionImprimerPage($bouton,e){
			window.print();
			return true;
		}
	}
	function snGeolocs(){
		var MARQUEURS = JSON.parse(GEOLOC_MARQUEURS_STYLES);
		if($('.sn-geoloc').length > 0){
			var geoloc_index = 0;
			var geolocs = [];
			$('.sn-geoloc').each(function () {
				var geoloc_id = 'none'; if($(this).attr('id')){ geoloc_id = $(this).attr('id'); } else { geoloc_id = 'sngeoloc' + geoloc_index; $(this).attr('id',geoloc_id); }
				snGeolocCreer($(this),geoloc_id,geoloc_index);
				geolocs.push(geoloc_id);
				geoloc_index++;
			});
			$('.sn-geoloc').css('display','block');
		}
		function snGeolocCreer(geoloc,geoloc_id,geoloc_index){
			var ll_carte = null; var ll_fond = null; var ll_marqueur = null; var ll_icone = null;
			var geoloc_marqueur = null;
			var geoloc_data = {}; if(geoloc.data('geoloc')){ geoloc_data = JSON.parse(JSON.stringify(geoloc.data('geoloc')));}
			var geoloc_zoom = GEOLOC_FOND_ZOOM; if(geoloc.data('zoom')){ geoloc_zoom = parseInt(geoloc.data('zoom'));}
			var nb_marqueurs = geoloc_data.length;
			if (geoloc_data[0]) { if (geoloc_data[0].lat && geoloc_data[0].lon) {
				ll_carte = L.map(geoloc_id).setView([geoloc_data[0].lat,geoloc_data[0].lon],geoloc_zoom);
				ll_fond = L.tileLayer(GEOLOC_FOND_URL,{attribution:GEOLOC_FOND_CREDIT, minZoom:1, maxZoom:20}).addTo(ll_carte);
			}}
			if(ll_carte == null){} else {
				for (var i=0; i<nb_marqueurs; i++) {
					geoloc_marqueur = snGeolocMarqueurCreer(geoloc_data[i],geoloc_id);
					if (geoloc_marqueur == null) {} else {
						ll_icone = L.icon(geoloc_marqueur.icone);
						ll_marqueur = L.marker(geoloc_marqueur.coord,{icon:ll_icone}).addTo(ll_carte);
						if(geoloc_marqueur.texte){ ll_marqueur.bindPopup(geoloc_marqueur.texte); }
					}
				}
			}
		}
		function snGeolocMarqueurCreer(gldata,geoloc_id){
			var marqueur_data = {};
			marqueur_data.icone = MARQUEURS.leaflet_defaut;
			if (gldata.lat && gldata.lon) {
				marqueur_data.coord = [gldata.lat,gldata.lon];
				if (gldata.marqueur) {
					marqueur_data.icone = MARQUEURS[gldata.marqueur];
				}
				if (gldata.texte) { marqueur_data.texte = gldata.texte; }
				return marqueur_data;
			}
			return null;
		}
		return true;
	}

	function snSuperAccordeons(){
		$('.sn-acc').each(function(){
			if($(this).next().length > 0){
				$(this).next().addClass('sn-accc');
				if($(this).data('plie')){
					snSuperAccordeonChanger($(this),$(this).next());
				}
				snSuperAccordeonActiver($(this),$(this).next());
			}
		});
		function snSuperAccordeonActiver($bouton,$cible){
			$bouton.on('click',function(e){ e.preventDefault(); e.stopPropagation(); snSuperAccordeonChanger($bouton,$cible); });
		}
		function snSuperAccordeonChanger($bouton,$cible){
			$bouton.toggleClass('sn-acc-inactive');
			$cible.toggleClass('sn-accc-inactive');
		}
		return true;
	}
	
	function snMenuMobile(){
        var menu_mobile_visible = false;
        snMenuMobileCacher();
        $('.sn-nav-mobile-btn').on('click',function(e){
        	e.preventDefault(); e.stopPropagation();
            if(menu_mobile_visible == true){ snMenuMobileCacher(); } else { snMenuMobileMontrer(); }
        });
        function snMenuMobileMontrer(){
            $('.sn-nav-mobile').css('display','block');
            menu_mobile_visible = true;
        }
        function snMenuMobileCacher(){
            $('.sn-nav-mobile').css('display','none');
            menu_mobile_visible = false;
        }
		return true;
    }
    
    function snMenusFlottants(){
    	var menu_limite = 64; // une marge de 64px
      var menu_flottant = false;
    	var snmenus_mode = 'mobile';
    	var $menu_flottant;
    	var $menu_flottant_contenu;
    	if($('#sn-nav-mobile-section').css('display') == 'none'){
    		$menu_flottant = $('<nav class="nav sn-nav clearfix sn-section" id="nav-flottant" role="navigation"></nav>');
    		snmenus_mode = 'ecran';
    		if($('.header').length !== 0){
				menu_limite += $('.header').height();
			}
    		if($('#sn-nav-second').length !== 0){
    			menu_limite += $('#sn-nav-second').height();
    		}
    		if($('#nav .sn-brique').length !== 0){
    			$menu_flottant_contenu = $('#nav .sn-brique').clone();
				$menu_flottant.append($menu_flottant_contenu);
			}
		} else {
			$menu_flottant = $('<nav class="nav sn-nav clearfix sn-section" id="nav-mobile-flottant" role="navigation"></nav>');
			if( $('.header').length > 0 ){
				menu_limite += $('.header').height();
			}
			if( $('#sn-nav-mobile-section .sn-brique').length > 0 ){
				menu_limite += $('#sn-nav-mobile-section .sn-brique').height();
			}
			if($('#sn-nav-mobile-section .sn-nav-mobile').length > 0){
    			$menu_flottant_contenu = $('#sn-nav-mobile-section .sn-brique').clone();
				$menu_flottant.append($menu_flottant_contenu);
			}
		}
		$menu_flottant.insertBefore($('#nav'));
      $(window).on('scroll', function(e){
         var frame = $(window).scrollTop();
         snMenuFlottantManager(frame);
      });
      function snMenuFlottantManager(pFrame){
         if((menu_flottant === false) && (pFrame > menu_limite)){
      		$menu_flottant.css('display','block');
         	menu_flottant = true;
         } else if ((menu_flottant === true) && (pFrame <= menu_limite)){
      		$menu_flottant.css('display','none');
         	menu_flottant = false;
         }
      }
		return true;
    }
    
    function snMenuMega(){
        var item_actuel = '-1';
        var sous_menu_visible = false;
        $('#nav .sn-nav-mega-items > li').each(function(e){
            $('#nav .nav-item > a[name="' + $(this).attr('name') + '"]').on('click', function(e){
                e.preventDefault();
                e.stopPropagation();
                if(sous_menu_visible == false){
                    snMenuMegaAfficher($(this).attr('name'));
                } else if(parseInt($(this).attr('name')) == parseInt(item_actuel)){
                    snMenuMegaMasquer(); 
                } else{
                    snMenuMegaAfficher($(this).attr('name'));
                }
            });
        });
        $('#nav .sn-nav-mega-items').css({display:'block'});
        snMenuMegaMasquer();
        function snMenuMegaAfficher(num_item){
            $('#nav .sn-nav-mega-items > li').css({display:'none'});
            $('#nav .sn-nav-mega-items > li[name="'+num_item+'"]').css({display:'flex'});
            $('#nav .sn-nav-mega-items').css({display:'block'});
            item_actuel = num_item;
            sous_menu_visible = true;
            $('html').on('click', function(e){
	            if(sous_menu_visible == true){ snMenuMegaMasquer(e); }
	        });
        }
        function snMenuMegaMasquer(e){
        	if(e){ $('html').off(); }
            item_actuel = '-1';
            $('#nav .sn-nav-mega-items').css({display:'none'});
            $('#nav .sn-nav-mega-items > li').css({display:'none'});
            sous_menu_visible = false;
        }
		return true;
    }
    
})(jQuery)

/*** SN Edition|snedition.js : end ***/