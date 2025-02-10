$("Form").on("submit", function (event) {
    let data = $(this).serializeArray();
    let login = data['0']['value']
    let password = data['1']['value']
    let permissions = data['2']['value']
    event.preventDefault();
    $.ajax({
       type:"POST",
       url:"php_scripts/create_user.php",
       data: {"login": login, "password": password, "permissions": permissions},
       cache: false,
       success: function(response){ 
           alert(response);
       }
   })
});