jQuery(document).ready( function() {

	jQuery('#KeywordCatalogo a.advancedsearch').click( function() {
		jQuery('#FiltersCatalogo').slideDown();
		jQuery(this).css('opacity','0');
		jQuery('#KeywordCatalogo button.search-submit').fadeOut();
	});

	jQuery('#FiltersCatalogo a.highlight').click( function() {
		jQuery('#FiltersCatalogo').slideUp();
		jQuery('#KeywordCatalogo a.advancedsearch').css('opacity','1');
		jQuery('#KeywordCatalogo button.search-submit').fadeIn();
	});

	$('#infscroll-next .pagination .page-numbers.next').click(function(){
		$(this).fadeOut();
	});

	featurecatalogo();
	sidemenucollapse();

	// overlay per zoom immagine opera
	jQuery('.swiper-slide').click(function(i){
		jQuery('html,body').css('overflow','hidden');
		jQuery('#zoom-overlay').fadeIn();
		var pictozoom = $(this).children('a').attr('data-full-image');
		var imagenum = $('.swiper-pagination').text();
		$('.zoom-opera-title p').text(imagenum);
		$('#zoom-thumb').data('zoomImage',pictozoom)
		$("#zoom-thumb").elevateZoom({
				zoomWindowPosition: "zoom-box",
				zoomWindowHeight: $('#zoom-box').height(),
				zoomWindowWidth: $('#zoom-box').width(),
				borderSize: 1,
				borderColour: '#fff',
				lensBorderSize: 1,
				lensBorderColour: "#fff",
				easing:true,
				preloading: 1,
				loadingIcon: '/wp-content/themes/fondazionefaustomelotti/img/ajax-loader.gif',
				tint:true,
				tintColour:'#000',
				tintOpacity:0.35
			});
		//}
	});
	jQuery('button.close-zoom').click(function(){
		jQuery('#zoom-overlay').fadeOut();
		jQuery('.zoomContainer,.zoomWindowContainer').remove();
		jQuery('html,body').css('overflow','initial');
	})

	// DISATTIVATO PER DEBUG, POI RIATTIVARE!
	//
  // jQuery(document).on("contextmenu",function(e){
  //   if(e.target.nodeName != "INPUT" && e.target.nodeName != "TEXTAREA")
  //     e.preventDefault();
  //   	console.log(e.target.nodeName);
  // });

	// FIX RICERCA CODICE OPERA
	// se il termine ricercato contiene un numero allora è un codice opera, percui metto le virgolette per cercare esattamente opera con quel codice
	jQuery('#SearchCatalogo').submit(function(){
		var termine = jQuery(this).find("input[name=term]");
		var isnum = termine.val().match(/( *\d+)+/g);  // se c'è un numero nella ricerca è un codice
	  if (termine.val() && isnum) {
	    termine.val("\""+termine.val()+"\"");
	  }
	})

	// TAB DETTAGLIO OPERA
	jQuery('button.tab_btn').click(function(){
		var me = jQuery(this);
		jQuery('button.tab_btn').removeClass('active');
		me.addClass('active');
		//console.log(me.attr('data-tab')+' clicked');
		var Tab = me.attr('data-tab');
		jQuery('#operaDetails ul').removeClass('active');
		jQuery('#operaDetails ul.'+Tab).addClass('active');
	});

});


$(window).on('resize', function(){

	if (jQuery('#zoom-overlay').css('display') == 'block') {
		console.log('resizzo');
		$("#zoom-thumb").elevateZoom({
			zoomWindowPosition: "zoom-box",
			zoomWindowHeight: $('#zoom-box').height(),
			zoomWindowWidth: $('#zoom-box').width(),
			borderSize: 1,
			borderColour: '#ffffff',
			easing:true,
			loadingIcon: '/wp-content/themes/fondazionefaustomelotti/img/ajax-loader.gif',
			tint:true,
			tintColour:'#000',
			tintOpacity:0.35
		});
	}

});


var slideGently = function(target) {
	var headerh = $('#hederWrapper').height()+10;
	var totalScroll = jQuery(target).offset().top-headerh;
	jQuery('html, body').animate({
		scrollTop: totalScroll+'px',
	}, 1000);
}

var featurecatalogo = function() {
	jQuery('#ArchivioCatalogo .single-item-tipologia').hover( function() {
		jQuery(this).find('.more-details').fadeIn();
	},function() {
		jQuery(this).find('.more-details').fadeOut();
	});
	$('#infscroll-next .pagination .page-numbers.next').html('more results').fadeIn();

}

if (jQuery('.swiper-dettaglio-opera')[0]) {
	var swiper = new Swiper('.swiper-dettaglio-opera', {
		nextButton: '.swiper-button-next',
		prevButton: '.swiper-button-prev',
		spaceBetween: 30,
		pagination: '.swiper-pagination',
		paginationType: 'fraction',
		paginationFractionRender: function (swiper, currentClassName, totalClassName) {
	      return '<em>image <span class="' + currentClassName + '"></span>' +
	             ' / <span class="' + totalClassName + '"></span></em>';
	  }
	});

	swiper.on('slideChangeEnd', function () {
			var full = jQuery('.swiper-slide-active a').attr('data-full-image');
			var thumb = jQuery('.swiper-slide-active a').attr('data-image');
			console.log('slide change: '+full);
			$("#zoom-thumb").attr('src',thumb);
			$("#zoom-thumb").attr('data-zoom-image',full);
			$("#zoom-box").css('background','url('+full+') no-repeat center center');

	});
}

// collapsible side menu
var ajTerms=[];
var ajTermsIds=[];
var sidemenucollapse = function() {
	jQuery('ul.sidelist li.collapsible > a').each(function(){
		var itemlink = jQuery(this).attr('href');
		jQuery(this).parent().find('ul.sub-menu').append('<li id="menu-item-appended" class="menu-item"><a href="'+itemlink+'">All Items</a></li>');
		jQuery(this).removeAttr('href');
	});

	jQuery('ul.sidelist li.collapsible > a').click(function(){
		jQuery(this).parent().children('ul.sub-menu').slideToggle();
		jQuery(this).parent().toggleClass('opened');
		jQuery(this).parent().children('ul.sub-menu').find('li').each(function(i){
			ajTerms[i]=jQuery(this).find('a').text();
			ajTermsIds[i]=jQuery(this).attr('id');
			ajTermsIds[i]=ajTermsIds[i].replace("menu-item-", "");
		});
		if (jQuery(this).parent().hasClass('opened')) {
			pre_load_posts(jQuery(this).text());
		}
	});
}
var pre_load_posts = function(ajTerm){
	var numsubcats = (ajTerms.length)-1;
		container.empty();
		jQuery("#ArchivioCatalogo h1").html('ARTWORKS: <strong>'+ajTerm+'</strong>')
		container.append('<h2 class="text-right">'+numsubcats+' subcategories found</h2><a class="backlink dotted" href="//'+thehost+'/en/catalogue-raisonne/" title="To the Catalogue"><span class="glyphicon glyphicon-menu-left"></span> To the Catalogue</a>')
		container.append('<div id="ajLoading"><img alt="Loading..." src="'+ajPath+'/img/ajax-loader-circle.gif" /></div>');
		container.append('<ul class="items-tipologia-noinfscroll row"></ul>');
		container.children('ul').hide();
		load_posts('tipo_opera',ajTerms,ajTermsIds);
};

// ajax load artworks in category
var loading = true;

var thehost = window.location.hostname;
var stage = "imeuro.io";
if (thehost.search(stage) !== -1) { thehost = "nas.imeuro.io/fondazionefaustomelotti" ;}

var ajPath = '//'+thehost+'/wp-content/themes/fondazionefaustomelotti';
var container = jQuery("#ArchivioCatalogo .ajContent");
var innercontainer = container.children('ul');
var load_posts = function(ajTax,ajTerm,ajTermId){

		var current = ajTerms.shift();
		var currentId = ajTermsIds.shift();
	  jQuery.ajax({
	    type       : "GET",
			//data       : {ajTax : ajTax, ajTerm : ajTerms[i]},
			data       : {ajTax : ajTax, ajTerm : current, ajTermId : currentId},
	    dataType   : "html",
	    url        : ajPath+'/ajaxloophandler.php',
	    beforeSend : function(){
	    },
	    success    : function(data){
	      //console.log(data);
				console.log('ajTerms.length='+ajTerms.length);
				container.children('ul').append(data);
				if (ajTerms.length > 1) {
					load_posts(ajTax,current,currentId);
				} else {
					jQuery("#ajLoading").remove();
					featurecatalogo();
					container.children('ul').fadeIn();
				}


	    },
	    error     : function(jqXHR, textStatus, errorThrown) {
	      console.debug(jqXHR + " :: " + textStatus + " :: " + errorThrown);
	    }
	  });

}

var BackLink = function(){
	var theplaceholder = jQuery('a.backlink.placeholder');
	var theancestor = jQuery('ul#sidelist-tipologia').find('.current-menu-parent > a');

	this.init = function() {
		if (theplaceholder.length > 0) {
			if (theancestor.length > 0) { //siamo in sottocategoria: cerco padre
				theplaceholder.append(' To '+theancestor.text()).attr('href','javascript:;');
				theplaceholder.click(function(){
					theancestor.click();
				});
				return theancestor;
			} else { // siamo in primo livello quindi link a HP catalogo
				theplaceholder.append(' To the Catalogue').attr('href','//'+thehost+'/en/catalogue-raisonne/');
			}
		} else {
			return false;
		}
	}

}
var BackLink = new BackLink();
BackLink.init();


var paraQ = function(){
	var thedisclaimer = "<strong>Please note:</strong> this is a beta version of the CATALOGUE RAISONNÈ which is still undergoing final testing before its official release."
	var hasbodyclass = $('body').hasClass('catalogue-raisonne');

	this.init = function() {
		if (hasbodyclass === true) {
			jQuery('head').append('<style> #FFM_disclaimer {position: fixed; bottom: 0; left: 0; width: 100%; text-align: center; background: rgba(168, 135, 59, 0.8); color: #fff; padding: 10px; border-top: 1px solid #cea548;}</style>');
			jQuery('body').append('<div id="FFM_disclaimer">'+thedisclaimer+'</div>');
		}
	}
}

var FFM_disclaimer = new paraQ();
FFM_disclaimer.init();
