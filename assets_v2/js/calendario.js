
// IE 8 compatibility
if (!Array.prototype.indexOf) {
	Array.prototype.indexOf = function(obj, start) {
	     for (var i = (start || 0), j = this.length; i < j; i++) {
	         if (this[i] === obj) { return i; }
	     }
	     return -1;
	}
}

$(document).ready(function() {

	$(".cal_item").each(function(index) {

		// Expande el evento a lo largo de la semana la cantidad de dias que dure
		var colcount = parseFloat($(this).attr('data-col'));
		var rowcount = parseFloat($(this).attr('data-row'));
		var bgcol = $(this).parent().attr('bgcol');

		var calendario_cal_day_width = parseFloat($(".calendario_cal_day").css('width'));
		var calendario_cal_day_padding = parseFloat($(".calendario_cal_day").css('padding-right'));
		var item_padding = parseFloat($(this).css('padding-right'));
		var width_block = (calendario_cal_day_width + 2*calendario_cal_day_padding);
		var width = (width_block * colcount) - (2*item_padding) + colcount - 1;

		var height_val = parseFloat($(this).css('height'));
		var height_padding = parseFloat($(this).css('padding-right'));
		var baseday_div = $(this).parent().parent();
		var baseday_row = [];
		var margin_count = -1;
		if (typeof baseday_div.attr('baserow') !== 'undefined' && baseday_div.attr('baserow') !== false)
			baseday_row = baseday_div.attr('baserow').split(',');
		
		// Revisa cual es la posicion (row) de la barra
		for(var i=0; i < 3; i++) // donde 4 (1-based) es la posicion maxima donde puede estar el evento
			if(baseday_row.indexOf(i.toString()) == -1 )
			{
				margin_count = i;
				break;
			}
		// No tiene espacio para dibujarse en el dia - Despliega msg para ver todos los eventos del dia
		// Mas adelante se intenta dibujar en los siguientes dias si es que corresponde
		if(margin_count == -1) {
			$(this).css('display', 'none');
			baseday_div.children('.ver-todos').css('display', 'block');
		}
		else {
			var margin_top = (height_val + 2*height_padding + 2) * (margin_count);
			baseday_div.children('span').addClass('cal_day_evento');
			$(this).css('width', width);
			$(this).css('margin-top', margin_top );
			$(this).css('background-color', bgcol);
		}

		// aumenta el margin-top para el resto de los dias de la semana segun lo que dure el evento
		var base_div = baseday_div.parent();
		var base_index = base_div.children('.calendario_cal_day').index(baseday_div);
		for(var i = base_index; i < base_index + colcount; i++)
		{
			var cur_day = base_div.children('.calendario_cal_day:nth-child('+(i+1)+')'); // nth-child: 1-based index
			cur_day.children('span').addClass('cal_day_evento');

			var cur_rows = [];
			if (typeof cur_day.attr('baserow') !== 'undefined' && cur_day.attr('baserow') !== false)
				cur_rows = cur_day.attr('baserow').split(',');
			
			if(margin_count !== -1 && cur_rows.indexOf(margin_count.toString()) == -1)
			{
				cur_rows.push(margin_count);
				cur_day.attr('baserow', cur_rows.join(','));
			}

			// Se intenta mostrar la barra en los dias posteriores para que no quede escondido en el "Ver más"
			if(margin_count == -1)
				for(var c=0; c < 3; c++)
					if(cur_rows.indexOf(c.toString()) == -1 )
					{
						cur_rows.push(c);
						cur_day.attr('baserow', cur_rows.join(','));
						margin_count = c;

						var desp = i - base_index;
						width = (width_block * (colcount-desp)) - (2*item_padding) + (colcount - desp - 1);
						var margin_left = (width_block * desp) + 1;
						var margin_top = (height_val + 2*height_padding + 2) * (margin_count);

						$(this).css('display', 'block');
						$(this).css('width', width);
						$(this).css('margin-top', margin_top );
						$(this).css('margin-left', margin_left );
						$(this).css('background-color', bgcol);
						break;
					}

			// Agrega detalle de eventos en todos los dias que se expande
			var content_div = cur_day.children("[id^=todos-]");
			var target = '#' + ($(this).parent().attr('data-popbox'));
			content_div.html( content_div.html() + $(target).html().replace(/<h2>(.*?)<\/h2>/i, "<h3 style=\"line-height: normal;\"><a href=\"" + $(this).parent().attr('href') + "\" target=\"_blank\" >$1</a></h3>") );
			if(margin_count == -1)
				cur_day.children('.ver-todos').css('display', 'block');
		}
	});


    $('a.popper').hover(
    	function(e) {
	        var target = '#' + ($(this).attr('data-popbox'));
	        $(this).children('.cal_item').css('background-color', '#2B4C95');
	        $(target).show();
    	}, function() {
	        var target = '#' + ($(this).attr('data-popbox'));
	        $(this).children('.cal_item').css('background-color', $(this).attr('bgcol'));
	        $(target).hide();
	    }
	);
    $('a.popper').mousemove(function(e) { 
        var target = '#' + ($(this).attr('data-popbox'));
        var dx = e.pageX-400;
        var dy = e.pageY-180;
        $(target).css('top', dy).css('left', dx);
    });
});