$("#adding_new_cust").submit(function(event){
	event.preventDefault();
	var datatopost = $(this).serializeArray();
	console.log(datatopost);
	$.ajax({
		url:"add_customer.php",
		type:"POST",
		data: datatopost,
		success: function(data){
			if(data){
				$(".fetched").html(data);
			}
		},
		error: function(data){
			if(data){
				$(".fetched").html(data);
			}
		}
	});
});
