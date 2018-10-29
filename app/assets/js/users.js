//User addiotion form handling
$("#addUserForm").on('submit', function(e){
	e.preventDefault()
	var name = $("#nameInput").val();
	var email = $("#InputEmail").val();
	var role = $("#selectRole").val();
	var parking = $("#selectParking").val();
	var phone = $("#InputPhone").val();
	var gender = $("input[name='gender']:checked").val();
	var password = $("#InputPassword").val();

	//checking if all fields are set
	if(Boolean(name) && Boolean(gender) && Boolean(password) && Boolean(role) && Boolean(parking) && (Boolean(email) || Boolean(name)) ){
		//here we can submit
		$.post(apiLink, {action:'addUser', name:name, email:email, role:role, parking:parking, phone:phone, gender:gender, password:password}, function(ret){
				if(ret.status){
					location.reload();
				}else{
					$('#feedBack').append("<p class='text-danger'>"+ret.msg+"</p>");
				}
		})
	}else{
		$('#feedBack').append("<p class='text-danger'>Please fill in all required fields</p>");
	}
})