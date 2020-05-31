function getCookie(name) {
	var cookie = " " + document.cookie;
	var search = " " + name + "=";
	var setStr = null;
	var offset = 0;
	var end = 0;
	if (cookie.length > 0) {
		offset = cookie.indexOf(search);
		if (offset != -1) {
			offset += search.length;
			end = cookie.indexOf(";", offset)
			if (end == -1) {
				end = cookie.length;
			}
			setStr = unescape(cookie.substring(offset, end));
		}
	}
	return(setStr);
}	
	
	$(document).ready(function(){
	
	
		var svphone = getCookie('svphone');
		var svphone2 = getCookie('svphone2');
		console.log('----------svphone------------');
		console.log(svphone);
		
		if ( svphone!=null ) {
			
			
		url = 'sendsms.php?gethiddenblock=1&svphone='+svphone;
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

				if ( data['state']=='ok' ) {
					$('#svHiddenBlock').html(data['hiddenblock']);
					$('#svHiddenBlock').show();
					$('.info-send').html(data.msg);
					$('#smspass').show();
					$('#sendPassButton').show();
					$('#sendPhoneButton').hide();
					$('.mlogin').hide();
					$('.svsmspass').show();
					$('.info-send').show();					
					return;
				}

				//$('#txt_for_date').val(data);
				//$('#txt_for_date').show();
				
			}
		});						
			
			
		}