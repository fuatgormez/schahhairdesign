/*
 * Copyright (C) 2012 PrimeBox
 *
 * This work is licensed under the Creative Commons
 * Attribution 3.0 Unported License. To view a copy
 * of this license, visit
 * http://creativecommons.org/licenses/by/3.0/.
 *
 * Documentation available at:
 * http://www.primebox.co.uk/projects/cookie-bar/
 *
 * When using this software you use it at your own risk. We hold
 * no responsibility for any damage caused by using this plugin
 * or the documentation provided.
 */
(function($){

	$.cookieBar = function(options,val){
		if(options=='cookies'){
			var doReturn = 'cookies';
		}else if(options=='set'){
			var doReturn = 'set';
		}else{
			var doReturn = false;
		}
		var defaults = {
			message: '<p>Cookies erleichtern die optimale Bereitstellung unserer Website. Mit der Nutzung unserer Website erklären Sie sich damit einverstanden, dass wir Cookies verwenden. Ihre Einstellungen können Sie mithilfe <a type="url" href="http://www.aboutcookies.org/Default.aspx?page=1" target="_blank" data-runtime-url="http://www.aboutcookies.org/Default.aspx?page=1">dieser Anweisungen</a> ändern.</p>', //Message displayed on bar
			acceptButton: true, //Set to true to show accept/enable button
			acceptText: 'Akzeptieren', //Text on accept/enable button
			acceptFunction: function(cookieValue){if(cookieValue!='enabled' && cookieValue!='accepted') window.location = window.location.href;}, //Function to run after accept
			declineButton: true, //Set to true to show decline/disable button
			declineText: 'Deaktiviere Cookies', //Text on decline/disable button
			declineFunction: function(cookieValue){if(cookieValue=='enabled' || cookieValue=='accepted') window.location = window.location.href;}, //Function to run after decline
			policyButton: false, //Set to true to show Privacy Policy button
			policyText: 'Privacy Policy', //Text on Privacy Policy button
			policyURL: '/privacy-policy/', //URL of Privacy Policy
			autoEnable: true, //Set to true for cookies to be accepted automatically. Banner still shows
			acceptOnContinue: false, //Set to true to accept cookies when visitor moves to another page
			acceptOnScroll: false, //Set to true to accept cookies when visitor scrolls X pixels up or down
			acceptAnyClick: false, //Set to true to accept cookies when visitor clicks anywhere on the page
			expireDays: 365, //Number of days for cookieBar cookie to be stored for
			renewOnVisit: false, //Renew the cookie upon revisit to website
			forceShow: false, //Force cookieBar to show regardless of user cookie preference
			effect: 'slide', //Options: slide, fade, hide
			element: 'body', //Element to append/prepend cookieBar to. Remember "." for class or "#" for id.
			append: false, //Set to true for cookieBar HTML to be placed at base of website. Actual position may change according to CSS
			fixed: false, //Set to true to add the class "fixed" to the cookie bar. Default CSS should fix the position
			bottom: true, //Force CSS when fixed, so bar appears at bottom of website
			zindex: '999999999', //Can be set in CSS, although some may prefer to set here
			domain: String(window.location.hostname), //Location of privacy policy
			referrer: String(document.referrer) //Where visitor has come from
		};
		var options = $.extend(defaults,options);

		//Sets expiration date for cookie
		var expireDate = new Date();
		expireDate.setTime(expireDate.getTime()+(options.expireDays*86400000));
		expireDate = expireDate.toGMTString();

		var cookieEntry = 'cb-enabled={value}; expires='+expireDate+'; path=/';

		//Retrieves current cookie preference
		var i,cookieValue='',aCookie,aCookies=document.cookie.split('; ');
		for (i=0;i<aCookies.length;i++){
			aCookie = aCookies[i].split('=');
			if(aCookie[0]=='cb-enabled'){
    			cookieValue = aCookie[1];
			}
		}
		//Sets up default cookie preference if not already set
		if(cookieValue=='' && doReturn!='cookies' && options.autoEnable){
			cookieValue = 'enabled';
			document.cookie = cookieEntry.replace('{value}','enabled');
		}else if((cookieValue=='accepted' || cookieValue=='declined') && doReturn!='cookies' && options.renewOnVisit){
			document.cookie = cookieEntry.replace('{value}',cookieValue);
		}
		if(options.acceptOnContinue){
			if(options.referrer.indexOf(options.domain)>=0 && String(window.location.href).indexOf(options.policyURL)==-1 && doReturn!='cookies' && doReturn!='set' && cookieValue!='accepted' && cookieValue!='declined'){
				doReturn = 'set';
				val = 'accepted';
			}
		}
		if(doReturn=='cookies'){
			//Returns true if cookies are enabled, false otherwise
			if(cookieValue=='enabled' || cookieValue=='accepted'){
				return true;
			}else{
				return false;
			}
		}else if(doReturn=='set' && (val=='accepted' || val=='declined')){
			//Sets value of cookie to 'accepted' or 'declined'
			document.cookie = cookieEntry.replace('{value}',val);
			if(val=='accepted'){
				return true;
			}else{
				return false;
			}
		}else{
			//Sets up enable/accept button if required
			var message = options.message.replace('{policy_url}',options.policyURL);

			if(options.acceptButton){
				var acceptButton = '<a href="" class="cb-enable">'+options.acceptText+'</a>';
			}else{
				var acceptButton = '';
			}
			//Sets up disable/decline button if required
			if(options.declineButton){
				var declineButton = '<a href="" class="cb-disable">'+options.declineText+'</a>';
			}else{
				var declineButton = '';
			}
			//Sets up privacy policy button if required
			if(options.policyButton){
				var policyButton = '<a href="'+options.policyURL+'" class="cb-policy">'+options.policyText+'</a>';
			}else{
				var policyButton = '';
			}

			//Whether to add "fixed" class to cookie bar
			if(options.fixed){
				if(options.bottom){
					var fixed = ' class="fixed bottom"';
				}else{
					var fixed = ' class="fixed"';
				}
			}else{
				var fixed = '';
			}
			if(options.zindex!=''){
				var zindex = ' style="z-index:'+options.zindex+';"';
			}else{
				var zindex = '';
			}

			//Displays the cookie bar if arguments met
			if(options.forceShow || cookieValue=='enabled' || cookieValue==''){
				if(options.append){
					$(options.element).append('<div id="cookie-bar"'+fixed+zindex+'><p>'+message+acceptButton+declineButton+policyButton+'<a class="cookieSetting cb-setting" href="#">Einstellungen</a></p></div>');
				}else{
					$(options.element).prepend('<div id="cookie-bar"'+fixed+zindex+'><p>'+message+acceptButton+declineButton+policyButton+'<a class="cookieSetting cb-setting" href="#">Einstellungen</a></p></div>');
				}
			}

			var removeBar = function(func){
				if(options.acceptOnScroll) $(document).off('scroll');
				if(typeof(func)==='function') func(cookieValue);
				if(options.effect=='slide'){
					$('#cookie-bar').slideUp(300,function(){$('#cookie-bar').remove();});
				}else if(options.effect=='fade'){
					$('#cookie-bar').fadeOut(300,function(){$('#cookie-bar').remove();});
				}else{
					$('#cookie-bar').hide(0,function(){$('#cookie-bar').remove();});
				}
				$(document).unbind('click',anyClick);
			};
			var cookieAccept = function(){
				document.cookie = cookieEntry.replace('{value}','accepted');
				removeBar(options.acceptFunction);

				$('#cookie_buttons').html('<div id="cookie-bar" style="all: unset"><a href="" class="btn-block cb-disable">Deaktiviere Cookies</a></div>');
			};
			var cookieDecline = function(){
				var deleteDate = new Date();
				deleteDate.setTime(deleteDate.getTime()-(864000000));
				deleteDate = deleteDate.toGMTString();
				aCookies=document.cookie.split('; ');
				for (i=0;i<aCookies.length;i++){
					aCookie = aCookies[i].split('=');
					if(aCookie[0].indexOf('_')>=0){
						document.cookie = aCookie[0]+'=0; expires='+deleteDate+'; domain='+options.domain.replace('www','')+'; path=/';
					}else{
						document.cookie = aCookie[0]+'=0; expires='+deleteDate+'; path=/';
					}
				}
				document.cookie = cookieEntry.replace('{value}','declined');
				removeBar(options.declineFunction);


				$('#cookie_buttons').html('<div id="cookie-bar" style="all:unset"><a href="" class="btn-block cb-enable">Akzeptieren</a></div>');

			};
			var anyClick = function(e){
				if(!$(e.target).hasClass('cb-policy')) cookieAccept();
			};

			$('#cookie-bar .cb-enable').click(function(){cookieAccept();return false;});
			$('#cookie-bar .cb-disable').click(function(){cookieDecline();return false;});
			if(options.acceptOnScroll){
				var scrollStart = $(document).scrollTop(),scrollNew,scrollDiff;
				$(document).on('scroll',function(){
					scrollNew = $(document).scrollTop();
					if(scrollNew>scrollStart){
						scrollDiff = scrollNew - scrollStart;
					}else{
						scrollDiff = scrollStart - scrollNew;
					}
					if(scrollDiff>=Math.round(options.acceptOnScroll)) cookieAccept();
				});
			}
			if(options.acceptAnyClick){
				$(document).bind('click',anyClick);
			}
		}
	};

})(jQuery);



//sayfa hazir oldugunda
$(document).ready(function(){

	if($.cookie('cb-enabled') == 'declined'){
		$('#cookie_buttons').html('<div id="cookie-bar" style="all: unset"><a href="" class="btn-block cb-enable">Akzeptieren</a></div>');
	}

	if($.cookie('cb-enabled') == 'accepted'){
		$("#cookieModal").css("z-index", "-1");
		$('#cookie_buttons').html('<div id="cookie-bar" style="all: unset"><a href="" class="btn-block cb-disable">Deaktiviere Cookies</a></div>');
	}

	if($.cookie("C_1")){
		$('#cookieSettingIsActiveTextC_1').html('Aktiv');
		$('#cookieSettingIsActiveImgC_1').attr('src', '//cdn.consentmanager.mgr.consensu.org/delivery/btns0/yes.svg');
		$('#cookieSettingIsActiveC_1').attr('data-isactive','2');
	}
	if($.cookie("C_2")){
		$('#cookieSettingIsActiveTextC_2').html('Aktiv');
		$('#cookieSettingIsActiveImgC_2').attr('src', '//cdn.consentmanager.mgr.consensu.org/delivery/btns0/yes.svg');
		$('#cookieSettingIsActiveC_2').attr('data-isactive','2');
	}
	if($.cookie("C_3")){
		$('#cookieSettingIsActiveTextC_3').html('Aktiv');
		$('#cookieSettingIsActiveImgC_3').attr('src', '//cdn.consentmanager.mgr.consensu.org/delivery/btns0/yes.svg');
		$('#cookieSettingIsActiveC_3').attr('data-isactive','2');
	}
	if($.cookie("C_4")){
		$('#cookieSettingIsActiveTextC_4').html('Aktiv');
		$('#cookieSettingIsActiveImgC_4').attr('src', '//cdn.consentmanager.mgr.consensu.org/delivery/btns0/yes.svg');
		$('#cookieSettingIsActiveC_4').attr('data-isactive','2');
	}
	if($.cookie("C_5")){
		$('#cookieSettingIsActiveTextC_5').html('Aktiv');
		$('#cookieSettingIsActiveImgC_5').attr('src', '//cdn.consentmanager.mgr.consensu.org/delivery/btns0/yes.svg');
		$('#cookieSettingIsActiveC_5').attr('data-isactive','2');
	}
	if($.cookie("C_A_1")){
		$('#cookieSettingIsActiveTextC_A_1').html('Aktiv');
		$('#cookieSettingIsActiveImgC_A_1').attr('src', '//cdn.consentmanager.mgr.consensu.org/delivery/btns0/yes.svg');
		$('#cookieSettingIsActiveC_A_1').attr('data-isactive','2');
		$('#google_maps').html('<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2429.581153921195!2d13.313643651310105!3d52.48671897970876!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47a8508d18a51501%3A0x1357effec8c8e9c2!2sBerliner+Stra%C3%9Fe+55%2C+10713+Berlin!5e0!3m2!1sde!2sde!4v1551394504925" width="100%" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>');
	}else{
		$('#google_maps').html('');
	}
	if($.cookie("C_A_2")){
		$('#cookieSettingIsActiveTextC_A_2').html('Aktiv');
		$('#cookieSettingIsActiveImgC_A_2').attr('src', '//cdn.consentmanager.mgr.consensu.org/delivery/btns0/yes.svg');
		$('#cookieSettingIsActiveC_A_2').attr('data-isactive','2');
		$('#youtube_videos').attr('style','display:show');
	}else{
		$('#youtube_videos').attr('style','display:none');
	}

	//cookie google



	var openModal = function(){
		$('#cookieModal').modal('show');
		$("#cookieModal").css("z-index", "99999");
		$('#cmpboxrecall').attr('style','display:none');
		$('.cookieSetting').attr('style','display:none');
	};

	$('.cmpboxrecalllink').hover(function(){
		$('.cmpboxrecalltxt').attr("style", "display:show");
	}, function(){
		$('.cmpboxrecalltxt').attr("style", "display:none");
	});

	$('.cmpboxrecalllink').on('click',(function (e){
		e.preventDefault();
		openModal();
	}));

	$(document).on('click', '.cookieSetting', function (e) {
		e.preventDefault();
		openModal();
	});

	$("#cookieModal").on("hidden.bs.modal", function () {
		$('#cmpboxrecall').attr('style','display:show');
		$('.cookieSetting').attr('style','display:show');

		$("#cookieModal").css("z-index", "-1");
	});


	$(document).on('click', '.cookieSettingIsActive', function (e) {
		e.preventDefault();

		var data_id = $(this).attr('data-id');
		var isActive = $(this).attr('data-isactive');

		var cookieSettingIsActiveText 	= '#cookieSettingIsActiveTextC_'+data_id;
		var cookieSettingIsActiveImg 	= '#cookieSettingIsActiveImgC_'+data_id;


		if(isActive == 1){

			$(this).attr('data-isactive', '2');
			$(cookieSettingIsActiveText).html('Aktiv');
			$(cookieSettingIsActiveImg).attr('src', '//cdn.consentmanager.mgr.consensu.org/delivery/btns0/yes.svg');
		}else{
			$(this).attr('data-isactive', '1');
			$(cookieSettingIsActiveText).html('Inaktiv');
			$(cookieSettingIsActiveImg).attr('src', '//cdn.consentmanager.mgr.consensu.org/delivery/btns0/no.svg');
		}

		if(data_id == 1){if(isActive == 1){$.cookie("C_1", 1, {expires: 360})}else{$.cookie("C_1", null, {expires: -1})}}
		if(data_id == 2){if(isActive == 1){$.cookie("C_2", 1, {expires: 360})}else{$.cookie("C_2", null, {expires: -1})}}
		if(data_id == 3){if(isActive == 1){$.cookie("C_3", 1, {expires: 360})}else{$.cookie("C_3", null, {expires: -1})}}
		if(data_id == 4){if(isActive == 1){$.cookie("C_4", 1, {expires: 360})}else{$.cookie("C_4", null, {expires: -1})}}
		if(data_id == 5){if(isActive == 1){$.cookie("C_5", 1, {expires: 360})}else{$.cookie("C_5", null, {expires: -1})}}

	});

	$(document).on('click', '.cookieSettingIsActiveC_A', function (e) {
		e.preventDefault();


		var data_id = $(this).attr('data-id');
		var isActive = $(this).attr('data-isactive');

		var cookieSettingIsActiveTextC_A 	= '#cookieSettingIsActiveTextC_A_'+data_id;
		var cookieSettingIsActiveImgC_A	= '#cookieSettingIsActiveImgC_A_'+data_id;


		if(isActive == 1){
			$(this).attr('data-isactive', '2');
			$(cookieSettingIsActiveTextC_A).html('Aktiv');
			$(cookieSettingIsActiveImgC_A).attr('src', '//cdn.consentmanager.mgr.consensu.org/delivery/btns0/yes.svg');

			//ext
			if(cookieSettingIsActiveTextC_A == '#cookieSettingIsActiveTextC_A_1'){
				$('#google_maps').html('<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2429.581153921195!2d13.313643651310105!3d52.48671897970876!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47a8508d18a51501%3A0x1357effec8c8e9c2!2sBerliner+Stra%C3%9Fe+55%2C+10713+Berlin!5e0!3m2!1sde!2sde!4v1551394504925" width="100%" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>');
			}
			if(cookieSettingIsActiveTextC_A == '#cookieSettingIsActiveTextC_A_2'){
				$('#youtube_videos').attr('style','display:show');
			}

		}else{
			$(this).attr('data-isactive', '1');
			$(cookieSettingIsActiveTextC_A).html('Inaktiv');
			$(cookieSettingIsActiveImgC_A).attr('src', '//cdn.consentmanager.mgr.consensu.org/delivery/btns0/no.svg');

			//ext
			if(cookieSettingIsActiveTextC_A == '#cookieSettingIsActiveTextC_A_1'){
				$('#google_maps').html('');
			}
			if(cookieSettingIsActiveTextC_A == '#cookieSettingIsActiveTextC_A_2'){
				$('#youtube_videos').attr('style','display:none');
			}

		}

		if(data_id == 1){if(isActive == 1){$.cookie("C_A_1", 1, {expires: 360})}else{$.cookie("C_A_1", null, {expires: -1})}}
		if(data_id == 2){if(isActive == 1){$.cookie("C_A_2", 1, {expires: 360})}else{$.cookie("C_A_2", null, {expires: -1})}}
	});

});//sayfa hazir oldugunda
