function clearErrors(){

    errors = document.getElementsByClassName('formerror');
    for(let item of errors)
    {
        item.innerHTML = "";
    }
}

function seterror(id, error){
    //sets error inside tag of id 
    element = document.getElementById(id);
    element.getElementsByClassName('formerror')[0].innerHTML = error;
}

function validateForm(){
    var returnval = true;
    clearErrors();

    //perform validation and if validation fails, set the value of returnval to false
    var fname = document.forms['myForm']["firstname"].value;
    if (fname.length<5){
        seterror("firstname", "*Length of name is too short");
        returnval = false;
    }

    if (fname.length == 0){
        seterror("firstname", "*Please fill this field");
        returnval = false;
    }

    var lname = document.forms['myForm']["lastname"].value;
    if (lname.length<5){
        seterror("lastname", "*Length of name is too short");
        returnval = false;
    }
    if (lname.length == 0){
        seterror("lastname", "*Please fill this field");
        returnval = false;
    }

    var email = document.forms['myForm']["email"].value;
    if (email.length>15){
        seterror("email", "*Email length is too long");
        returnval = false;
    }
    
    var password = document.forms['myForm']["pswd"].value;
    if (password.length < 8){
        seterror("pswd", "*Password should be atleast 8 characters long!");
        returnval = false;
    }

    var cpassword = document.forms['myForm']["repswd"].value;
    if (cpassword != password){
        seterror("repswd", "*Password and Confirm password should match!");
        returnval = false;
    }
    return returnval;
}
function validNameSyntax(value) {
    var regex = /^([a-zA-Z])+$/;
    return regex.test(value);
}

function validEmailSyntax(email) {
    var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    return regex.test(email);
}
