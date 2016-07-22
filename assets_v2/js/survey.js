$(document).ready(
	
	function(){
		console.log("survey!");
		var frameSrc = "https://docs.google.com/forms/d/1zftZq4sUBgsI6bjgcx8dE7Rq-VOoso6eRzFBcWmTe9o/viewform";

		function loadSurvey(){
			$('#survey-modal').on('show', function () {
				$('iframe#gform').attr("src",frameSrc);
		  });
		  $('#survey-modal').modal({show:true})
		}
		if (localStorage.getItem("iswrpdivloaded2") === null) {
		  loadSurvey();
			localStorage.setItem('iswrpdivloaded2', 1);
		}

	}

);
