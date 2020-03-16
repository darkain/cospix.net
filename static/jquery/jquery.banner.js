// Simple JavaScript Rotating Banner Using jQuery
// www.mclelun.com

// Edit jqb_eff to change transition effect.
// 1 - FadeIn FadeOut
// 2 - Horizontal Scroll
// 3 - Vertical Scroll
// 4 - Infinity Horizontal Scroll
// 5 - Infinity Vertical Scroll
var jqb_eff = 1;

//Variables
var jqb_vCurrent = 0;
var jqb_vTotal = 0;
var jqb_vSpeed = 1000;
var jqb_vDuration = 4000;
var jqb_intInterval = 0;
var jqb_vGo = 1;
var jqb_vBusy = false;
var jqb_vIsPause = false;
var jqb_tmp = 20;
var jqb_imgW = 990;
var jqb_imgH = 300;

jQuery(document).ready(function() {
	var first = $('.jqb-slide').first();
	$('.jqb-info').html(first.find('.jqb-text').html());

	//load first image
	var img = first.find('img');
	if (!img.attr('src')) img.attr('src', img.attr('data-src'));

	//preload next image
	var img = first.next().find('img');
	if (!img.attr('src')) img.attr('src', img.attr('data-src'));

	$('.jqb-slide').find('.jqb-text').hide();

	jqb_vTotal = $('.jqb-slides').children().length -1;
	jqb_intInterval = setInterval(jqb_fnLoop, jqb_vDuration);

	if(jqb_eff == 1)//Fade In & Fade Out
	{
		$('#jqb-object').find('.jqb-slide').each(function(i) {
			if(i == 0){
				$(this).animate({ opacity: 'show'}, jqb_vSpeed, function() { jqb_vBusy = false; });
			} else {
				$(this).animate({ opacity: 'hide'}, jqb_vSpeed, function() { jqb_vBusy = false; });
			}
		});
	}
	else if(jqb_eff == 2 || jqb_eff == 4)//Horizontal Alignment
	{
		$('#jqb-object').find('.jqb-slide').each(function(i) {
			jqb_tmp = ((i - 1)*jqb_imgW) - ((jqb_vCurrent -1)*jqb_imgW);
			$(this).css({'left': jqb_tmp+'px'});
		});
	}
	else if(jqb_eff == 3 || jqb_eff == 5)//Vertical Alignment
	{
		$('#jqb-object').find('.jqb-slide').each(function(i) {
			jqb_tmp = ((i - 1)*jqb_imgH) - ((jqb_vCurrent -1)*jqb_imgH);
			$(this).css({'top': jqb_tmp+'px'});
		});
	}

	$('#btn-pauseplay').click(function() {
		if(jqb_vIsPause){
			jqb_vIsPause = false;
			jqb_fnLoop();
			$(this).removeClass('jqb-btn-play').addClass('jqb-btn-pause');
		} else {
			jqb_vIsPause = true;
			clearInterval(jqb_intInterval);
			$(this).removeClass('jqb-btn-pause').addClass('jqb-btn-play');
		}
	});

	$('#btn-prev').click(function() {
		jqb_vGo = -1;
		jqb_fnLoop();
	});

	$('#btn-next').click(function() {
		jqb_vGo = 1;
		jqb_fnLoop();
	});
});

function jqb_fnDone(){
	jqb_vBusy = false;

}

function jqb_fnLoop(){
	clearInterval(jqb_intInterval);

	if(!jqb_vBusy){

		jqb_vBusy = true;
		if(jqb_vGo == 1){
			jqb_vCurrent == jqb_vTotal ? jqb_vCurrent = 0 : jqb_vCurrent++;
		} else {
			jqb_vCurrent == 0 ? jqb_vCurrent = jqb_vTotal : jqb_vCurrent--;
		}

		$('#jqb-object').find('.jqb-slide').each(function(i) {
			if (jqb_vCurrent == i){
				var jqb_title = $(this).find('.jqb-text').html();
				$('.jqb-info').animate({ opacity: 'hide', 'left': '-50px'}, 250,function(){
					$('.jqb-info').html(jqb_title).animate({ opacity: 'show', 'left': '0px'}, 500);
				});

				var img = $(this).find('img');
				if (!img.attr('src')) img.attr('src', img.attr('data-src'));

				//preload next image
				var img = $(this).next().find('img');
				if (!img.attr('src')) img.attr('src', img.attr('data-src'));
			}


			if(jqb_eff == 2)//Horizontal Scrolling
			{
				jqb_tmp = ((i - 1)*jqb_imgW) - ((jqb_vCurrent -1)*jqb_imgW);
				$(this).animate({'left': jqb_tmp+'px'}, jqb_vSpeed, function() { jqb_fnDone(); });
			}
			else if(jqb_eff == 3)//Vertical Scrolling
			{
				jqb_tmp = ((i - 1)*jqb_imgH) - ((jqb_vCurrent -1)*jqb_imgH);
				$(this).animate({'top': jqb_tmp+'px'}, jqb_vSpeed, function() { jqb_fnDone(); });
			}
			else if(jqb_eff == 4)//Infinity Horizontal Scrolling
			{
				if(jqb_vTotal == 1) //IF 2 SLIDE ONLY, FIX
				{
					if(jqb_vGo == 1){
						if(($(this).position().left) < 0 )
						{
							$(this).css({'left': jqb_imgW+'px'});
						}
					} else {
						if(($(this).position().left) > (jqb_imgW * (jqb_vTotal - 1)))
						{
							$(this).css({'left': (-1 * jqb_imgW)+'px'});
						}
					}
				}
				else
				{
					if(($(this).position().left) < -jqb_imgW )
					{
						$(this).css({'left': (jqb_imgW * (jqb_vTotal - 1))+'px'});
					}
					else if(($(this).position().left) > (jqb_imgW * (jqb_vTotal - 1)))
					{
						$(this).css({'left': (-1 * jqb_imgW)+'px'});
					}
				}

				jqb_tmp = $(this).position().left - (jqb_imgW * jqb_vGo);
				$(this).animate({'left': jqb_tmp+'px'}, jqb_vSpeed, function() { jqb_fnDone();  });
			}
			else if(jqb_eff == 5)//Infinity Vertical Scrolling
			{
				if(jqb_vTotal == 1) //IF 2 SLIDE ONLY, FIX
				{
					if(jqb_vGo == 1){
						if(($(this).position().top) < 0 )
						{
							$(this).css({'top': jqb_imgH+'px'});
						}
					} else {
						if(($(this).position().top) > (jqb_imgH * (jqb_vTotal - 1)))
						{
							$(this).css({'top': (-1 * jqb_imgH)+'px'});
						}
					}
				}
				else
				{
					if(($(this).position().top) < -jqb_imgH )
					{
						$(this).css({'top': (jqb_imgH * (jqb_vTotal - 1))+'px'});
					}
					else if(($(this).position().top) > (jqb_imgH * (jqb_vTotal - 1)))
					{
						$(this).css({'top': (-1 * jqb_imgH)+'px'});
					}
				}

				jqb_tmp = $(this).position().top - (jqb_imgH * jqb_vGo);
				 $(this).animate({'top': jqb_tmp+'px'}, jqb_vSpeed, function() { jqb_fnDone();  });
			}
			else //if(jqb_eff == 1)//Fade In & Fade Out
			{
				if(i == jqb_vCurrent){
					$(this).animate({ opacity: 'show'}, jqb_vSpeed, function() { jqb_fnDone(); });
				} else {
					$(this).animate({ opacity: 'hide'}, jqb_vSpeed, function() { jqb_fnDone(); });
				}
			}
		});


		setTimeout(function() {
		if(!jqb_vIsPause){
				if (jqb_intInterval) clearInterval(jqb_intInterval);
				jqb_intInterval = setInterval(jqb_fnLoop, jqb_vDuration);
			}
		}, jqb_vSpeed);

	}
}
