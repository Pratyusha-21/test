function otp() {
    var otp = document.getElementById('otpinput');
    otp.style.display="block";
    var email = document.getElementById('emailid').value;
    console.log(email);
    $.ajax({
        type: 'POST',
        url: '/sendOtp',
        data: {emailid:email},
        dataType: "text",
        success: function(data) {
            console.log(data);
        },
        error: function(event,xhr,error) {
            console.log(xhr);
        }
    });
}

function post() {
    var post = $("#notes").val();
    var title = $("#title").val();
    var userName = $("#userid").text();
    $.ajax({
        type: 'POST',
        url: '/addPost',
        data: 
        {
            post:post,
            title:title,
            username:userName
        },
        dataType: "text",
        success: function(data) {
            $("#notes").val('');            
        },
        error: function(event,xhr,error) {
            console.log(xhr);
        }
    });
}

function deletePost(id) {
    var index = id.indexOf("-");
    var id = id.substring(++index);
    $.ajax({
        type: 'POST',
        url: '/delete',
        data: 
        {
            id:id
        },
        dataType: "text",
        success: function(data) {
            console.log(data);
            $('#post-'+id).remove();
        },
        error: function(event,xhr,error) {
            console.log(xhr);
        }
    });
}

function showPopup(id) {
    var index = id.indexOf("-");
    var postid = id.substring(++index);
    $("#posttext-"+postid).css("display", "none");
    $("#editpost-"+postid).slideDown();
}

function editNotes(id) {
    var id = $('#'+id).parent().attr('id');
    var index = id.indexOf("-");
    var notesid = id.substring(++index);
    var notes = $("#editpost-"+postid).children("textarea").val();
    var userName = $("#userid").text();
    $.ajax({
        type: 'POST',
        url: '/notesEdit',
        data: 
        {
            id: notesid,
            notes: notes,
            username: userName
        },
        dataType: "text",
        success: function(data) {
            console.log(data);
            $("#editpost-"+postid).children("textarea").val(post);
            $("#posttext-"+postid).text(post);
            $("#posttext-"+postid).css("display","block");
            $("#editpost-"+postid).css("display","none");
        },
        error: function(event,xhr,error) {
            console.log(xhr);
        }
    });
}

function logout() {
    var userName = $("#userid").text();
    console.log(userName);
    $.ajax({
        type: 'POST',
        url: '/logout',
        data:
        {
            username:userName
        },
        dataType: "text",
        success: function(data) {
            console.log(data);
            window.location.href = "/login";
        },
        error: function(event,xhr,error) {
            console.log(xhr);
        }
    });
}
