var preventSign = 0;

function sendEmail(){
    if(preventSign == 0){

        preventSign = 1
        $('#loading-id').removeClass('dis-none')
        var email = document.getElementById('email').value
        
        $.ajax({
            type: "POST",
            url: "../../included/function/exe/confirm-email.php",
            data: {"email": email},
  
            success: function (result) {
                $('#display-message').text(result);
                preventSign = 0;
                setTimeout(function() {
                    $('#loading-id').addClass('dis-none');
                }, 1000);
            },
                
            error: function(xhr, status, error) {
                $('#display-message').text("A apărut o eroare. Vă rugăm să încercați din nou mai târziu.");
                preventSign = 0;
                setTimeout(function() {
                    $('#loading-id').addClass('dis-none');
                }, 1000);
            }
        })
    }
}

function sendEmailCode(){
    if(preventSign == 0){

        preventSign = 1
        $('#loading-id').removeClass('dis-none')
        var emailCode = document.getElementById('cod-email').value
        var email = document.getElementById('email').value

        $.ajax({
            type: "POST",
            url: "../../included/function/exe/confirm-email.php",
            data: {
                "code-email": emailCode,
                "confirm-email": email
            },
  
            success: function (result) {
                result = result.trim()
                if(result === 'ok'){
                    location.reload()
                }
                $('#display-message').text(result);
                preventSign = 0;
                setTimeout(function() {
                    $('#loading-id').addClass('dis-none');
                }, 1000);
            },
                
            error: function(xhr, status, error) {
                $('#display-message').text("A apărut o eroare. Vă rugăm să încercați din nou mai târziu.");
                preventSign = 0;
                setTimeout(function() {
                    $('#loading-id').addClass('dis-none');
                }, 1000);
            }
        })
    }
}

$(document).ready(function () {
    $('#confirmare-email').submit(function (event) {
            event.preventDefault();
    })
    document.getElementById("cod-email").addEventListener("input", function (e) {

    this.value = this.value.replace(/\D/g, "");
});
})

