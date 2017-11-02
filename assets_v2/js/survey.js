String.prototype.isValidMail = function() {
  var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
  return re.test(this);
}

$(document).ready(
	function(){

		console.log('survey loading...');

		var submitted = false;
		var form = $('#gform-submit');
		form.on('click', function(e){
			var email = $('#gform-email').val()
			console.log(email);
			if (email.isValidMail()){
				console.log('submitting', email.isValidMail());
				$('#gform').submit();	
				setTimeout(function(){ 
					$('#close-modal').trigger('click');
				}, 2500);
			}
		});
		

		function loadSurvey(){
			$('#survey-modal').on('show');
		  $('#survey-modal').modal({show:true})
		}

		// if (localStorage.getItem("iswrpdivloaded2") === null) {
		// 		loadSurvey();
		// 		localStorage.setItem('iswrpdivloaded2', 1);
		// }

	}

);
