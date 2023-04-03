function otp() {
    var otp = document.getElementById('otpinput');
    otp.style.display="block";
    var email = document.getElementById('emailid').value;
    console.log(email);
    $.ajax({
        type: 'POST',
        url: 'otp.php',
        data: {emailid:email},
        dataType: "text",
        success: function(html) {
            $('#otpinput').html(html);
            console.log(email);
        }
    });
}