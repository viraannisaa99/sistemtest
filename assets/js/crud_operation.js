$(document).ready(function(){
	// save new employee record
	$('#saveEmpForm').submit('click',function(){
        var nama = $('#nama').val();
        var email = $('#email').val();
        var username = $('#username').val();
        var password = $('#password').val();
        var level = $('#level').val();

		$.ajax({
			type : "POST",
			url  : "dashboard/add",
			dataType : "JSON",
			data : {nama:nama, email:email, username:username, password:password, level:level},
			success: function(data){
				$('#nama').val("");
				$('#email').val("");
				$('#username').val("");
                $('#password').val("");
                $('#level').val("");
				$('#addEmpModal').modal('hide');
			}
		});
		return false;
	});
	
});
