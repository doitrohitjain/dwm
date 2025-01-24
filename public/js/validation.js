$(document).ready(function() {
    $('#staffRegistration').on('submit', function(e) {
        e.preventDefault();
		if($("#ajaxRequest").val() == "1"){
			$.ajax({
				url: staffValidateUrl,
				type: "POST",
				data: $(this).serialize(),
				success: function(response) {
					if(response.status && response.status == 'error'){
						// Prepare the errors with numbers
						var errorMessages = '';
						var counter = 1;
						$.each(response.errors, function(key, value) {
							$.each(value, function(index, message) {
								errorMessages += counter + '. ' + message + '<br>'; // Displaying error number with <br> for new lines
								counter++;
							});
						}); 
						Swal.fire({
							icon: 'error',
							title: response.message,
							html: '<div style="text-align: left;">' + errorMessages + '</div>', // Left-align the errors
						});
						return false;
					}else{
						 
						$("#ajaxRequest").val("0");
						$('#staffRegistration')[0].submit(); // Submit the form using native submission
					}
					
				},
				error: function(xhr, status, error) {
					alert("Error: " + xhr.responseJSON.message || "Something went wrong!");
				}
			});
		}else{
			$('#staffRegistration')[0].submit(); // Submit the form using native submission
		}
    });
	
	
	 $('#staffUpdateRegistration').on('submit', function(e) {
        e.preventDefault();
		if($("#ajaxRequest").val() == "1"){
			$.ajax({
				url: staffUpdateValidateUrl,
				type: "POST",
				data: $(this).serialize(),
				success: function(response) {
					if(response.status && response.status == 'error'){
						// Prepare the errors with numbers
						var errorMessages = '';
						var counter = 1;
						$.each(response.errors, function(key, value) {
							$.each(value, function(index, message) {
								errorMessages += counter + '. ' + message + '<br>'; // Displaying error number with <br> for new lines
								counter++;
							});
						}); 
						Swal.fire({
							icon: 'error',
							title: response.message,
							html: '<div style="text-align: left;">' + errorMessages + '</div>', // Left-align the errors
						});
						return false;
					}else{
						 
						$("#ajaxRequest").val("0");
						$('#staffUpdateRegistration')[0].submit(); // Submit the form using native submission
					}
					
				},
				error: function(xhr, status, error) {
					alert("Error: " + xhr.responseJSON.message || "Something went wrong!");
				}
			});
		}else{
			$('#staffUpdateRegistration')[0].submit(); // Submit the form using native submission
		}
    });
	
});


