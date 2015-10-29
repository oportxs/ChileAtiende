(function($){
	var evento = {
		init : function(){
			evento.formulario = $(".ajaxForm");
			evento.formEvento = $("div.cont:last-of-type").clone(true);
			//Asigna eventos
			evento.bindEvents();
			return this;
		},

		bindEvents:function(){

			evento.formulario.on('click', '.region_sel', function(e){
				if(parseInt($(this).val()))
					$(this).parent().children('.region-select').attr('style','display:none');
				else
					$(this).parent().children('.region-select').attr('style','display:block');
			});

			evento.formulario.on('click', '.permanente_sel', function(e){
				$(this).parent().parent().parent().children('#fecha').attr('style','display:table-row');
				if(parseInt($(this).val()))
					$(this).parent().parent().parent().children('#fecha').attr('style','display:none');
			});

			evento.formulario.on('keyup', '.datepicker', function(e){
				$(this).attr('value', '');
			});	

			evento.formulario.on('click', 'input[name^=tipo]', function(e){
				if($(this).attr('id') !== 'empresas')
					$('#evento_tipo_msg').show();
				else
					$('#evento_tipo_msg').hide();
			});

		},
		
	}

    function isValidDate(date)
    // Format: DD-MM-YYYY
    // Returns: YYYY-MM-DD or false
    {
        var matches = /^(\d{2})[-\/](\d{2})[-\/](\d{4})$/.exec(date);
        if (matches == null) return false;
        var d = matches[1];
        var m = matches[2] - 1;
        var y = matches[3];
        var composedDate = new Date(y, m, d);
        var valid = composedDate.getDate() == d &&
                composedDate.getMonth() == m &&
                composedDate.getFullYear() == y;
        if(valid)
            return y+'/'+(m+1)+'/'+d;
        else
            return false;
    }

    function check_form_blocked()
    {
        var guardarButton   = $('button[type="submit"]');
        if($('.error_date:visible').length > 0)
        {
            guardarButton.addClass('cancelar');
            guardarButton.prop('disabled', true);
        }
        else
        {
            guardarButton.removeClass('cancelar');
            guardarButton.prop('disabled', false);
        }
    }

    function validate_date(_date_str, _dp_inst, _inputElem) {
        var inputElem       = $("#"+_inputElem.getAttribute('id'));
        var is_start_date   = inputElem.hasClass('postulacion_start');
        var search_class    = is_start_date ? '.postulacion_end' : '.postulacion_start';
        var errorDiv        = inputElem.parent().children('.error_date');
        var otherInputElem  = inputElem.parent().children(search_class);
        var otherInputValue = otherInputElem.attr('value');

        var start_date_str  = is_start_date ? _date_str : otherInputValue;
        var end_date_str    = is_start_date ? otherInputValue : _date_str;
        start_date_str = isValidDate(start_date_str);
        end_date_str = isValidDate(end_date_str);

        if(
            otherInputValue == "" || 
            otherInputValue == null ||
            ( isValidDate(_date_str) && new Date(start_date_str) <= new Date(end_date_str) )
          )
        // OK dates
            errorDiv.css('display','none');
        else
            errorDiv.css('display','block');

        check_form_blocked();
    }

	
	$(function(){
        $( ".postulacion_start" ).datepicker({ 
            minDate: null, 
            numberOfMonths: 1,
            firstDay: 1, 
            dateFormat: "dd-mm-yy", 
            dayNames: [ "Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado" ], 
            dayNamesMin: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"], 
            monthNames: [ "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre" ],
            onSelect: function(datestr, dp_inst) { validate_date(datestr, dp_inst, this); }
            
        });

        $( ".postulacion_end" ).datepicker({ 
            minDate: 0, 
            numberOfMonths: 1, 
            firstDay: 1,
            dateFormat: "dd-mm-yy", 
            dayNames: [ "Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado" ], 
            dayNamesMin: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"], 
            monthNames: [ "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre" ],
            onSelect: function(datestr, dp_inst) { validate_date(datestr, dp_inst, this); }
            
        });

        $(".ajaxForm").on('keyup', '.hasDatepicker', function(e){
            $(this).attr('value', '');
        });

		window.evento = evento.init();
	});

})(jQuery);