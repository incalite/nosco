$(document).ready(function(){
	$('#editBox').hide();
	$('#openBox').on('click', function(){
		$('#editBox').slideToggle();
	})


	$(".skillClass, .eduClass, .expClass, .achClass, .titlesClass, .recClass").on('click', function() {
		var subject = $(this).text();
		var url = "https://en.wikipedia.org/w/api.php?action=opensearch&search="+subject+"&format=json&callback=?";
		$.ajax({
			url: url,
			type: 'GET',
			contentType: "application/json; charset=utf-8",
			async: false,
			dataType: "json",
			success: function(data, status, jqXHR) {
				$('#output').html('');
				for (var i = 1; i < data.length; i++){
					if (data[1][i] != undefined || data[2][i] != undefined || data[3][i] != undefined){
						$('#output').append("<div class='col'><div class='alert alert-warning' style='width:100%;'><h3 class='info-title'><i class='fa fa-cube'></i> " + data[1][i]+ "</h3>" +"<p class='info-content'>" + data[2][i] + "</p><a href='" + data[3][i] +"' target='_blank' class='btn btn-outline-dark info-link'>Open in Wiki</a></div></div>");
					} else {
						$('#output').append("<div class='col'><div class='alert alert-danger' style='width:100%;'>Unable to find anything related to <b>" + subject + "</b></div></div>");
						break;
					}
				}
			}
		});			      
	});

});

		

