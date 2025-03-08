$(document).ready(function(){
    // Check Admin Password is correct or not
    $("#current_password").keyup(function(){
        var current_password = $("#current_password").val();
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'post',
            url: "/admin/check-admin-password",

            data: {current_password:current_password},
            success: function(resp){
                console.log(resp); // Voir la réponse dans la console du navigateur
                if(resp == "false"){
                    $("#check_password").html("<font color='red'>Current Password is Incorrect!</font>");
                } else if(resp == "true"){
                    $("#check_password").html("<font color='green'>Current Password is Correct!</font>");
                }
            },error: function(xhr, status, error){
                console.log(xhr.responseText); // Affiche l'erreur exacte dans la console
                alert('Error');
            }
        });
    })
}); 