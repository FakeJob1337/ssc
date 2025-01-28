$("Form").on("submit", function (event) {
     let data = $(this).serializeArray();
     let login = data['0']['value']
     let password = data['1']['value']
     event.preventDefault();
     $.ajax({
		type:"POST",
		url:"php_scripts/get_user.php",
		data: {"login": login, "password": password},
		cache: false,
		success: function(response){ 
			alert(response);
		}
	})
});

// let form = document.querySelector("#AuthN")
// form.addEventListener("submit", () => {
//      alert(1)
// })
