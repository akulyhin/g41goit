$(document).ready(function() {

	
	$('#sendRestorePass').click(function() {
		
		url = 'sendsms.php?sendRestorePass=1&svphone='+$('#phone').val()+'&t='+$.now();
		console.log(url);
		//return;
		$.ajax({
			url: url,
			dataType: 'json',
			success: function(data) {
				
				console.log('----data-----');
				console.log(data);				
				console.log(data['state']);				
				console.log(data['msg']);				

				if ( data['state']=='error' ) {
					console.log('===error===');
					$('.info-send').html(data.msg);
					$('.info-send').addClass('error-info');
					$('.info-send').show();
					
				} else {
					console.log('===ok===');
					$('.info-send').html(data.msg);
					$('.info-send').addClass('ok-info')
					$('#sendRestorePass').show();
					$('.restorepass').hide();
					$('.resendpass').show();
					$('.restore').show();
					$('#sendPhoneButton').hide();
					$('#sendPassButton').show();
					$('.info-send').show();
					$('.svsmspass').show();
					$('.zgoda').hide();
					$('.svphone').hide();
					
										
					
				}

				
			}
		});			
		
		
	});
		
	$('#sendPassButton').click(function() {
	
		url = 'sendsms.php?chk=1&svphone='+$('#phone').val()+'&smspass='+$('#smspass').val()+'&t='+$.now();;
		console.log(url);
		//return;
		$.ajax({
			url: url,
			dataType: 'json',
			success: function(data) {
				
				console.log('----data-----');
				console.log(data);				
				console.log(data['state']);				
				console.log(data['msg']);				
				
				if ( data['state']=='error' ) {
					$('.info-send').html(data.msg);
					$('.info-send').removeClass('ok-info');
					$('.info-send').addClass('error-info');
					$('.info-send').show();
					return;
				}

				if ( data['state']=='ok' ) {
					$('#svHiddenBlock').html(data['hiddenblock']);
					$('#svHiddenBlock').show();
					$('.info-send').addClass('ok-info');
					$('.info-send').html(data.msg);
					$('#smspass').show();
					$('#sendPassButton').show();
					$('#sendPhoneButton').hide();
					$('#sendRestorePass').show();
					$('.restorepass').show();
					$('.restore').show();
					$('.svsmspass').show();
					$('.info-send').show();
					$('.mlogin').hide();
					$('.zgoda').hide();
					$('.svphone').hide();

					
					return;
				}

				
			}
		});			
		
	
		
	});
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
		
		
	$('#sendPhoneButton').click(function() {
		
		console.log('sendPhoneButton click');
	
		$('.info-send').html('');
		$('.info-send').hide('slow');	
		$('.svsmspass').hide('slow');
		$('#sendPassButton').hide('slow');
		$('#sendPhoneButton').show();
		$('.zgoda').hide('slow');

		
		
		url = 'sendsms.php?sendsms=1&svphone='+$('#phone').val()+'&t='+$.now();;
		console.log(url);
		//return;
		$.ajax({
			url: url,
			dataType: 'json',
			success: function(data) {
				
				console.log('----data-----');
				console.log(data);				
				console.log(data['state']);				
				console.log(data['msg']);				
				
				if ( data['state']=='error' ) {
					$('.info-send').html(data.msg);
					$('.info-send').addClass('error-info');
					$('.info-send').show();
					return;
				}

				if ( data['state']=='ok' ) {
					$('.info-send').addClass('ok-info');
					$('.info-send').html(data.msg);
					$('#smspass').stop().fadeIn(600);
					$('#sendPassButton').stop().fadeIn(600);
					$('#sendPhoneButton').stop().fadeOut(600);
					$('.svsmspass').stop().fadeIn(600);
					$('.info-send').stop().fadeIn(600);
					$('.zgoda').stop().fadeOut(600);
					$('.svphone').stop().fadeOut(200);
					$('#sendRestorePass').stop().fadeIn(600);
					$('.restorepass').stop().fadeIn(600);
					$('.restore').stop().fadeIn(600);
		
				
					return;
				}


				//$('#txt_for_date').val(data);
				//$('#txt_for_date').show();
				
			}
		});	
		
	});
	
	

});


