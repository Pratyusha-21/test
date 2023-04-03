function post() {
    var notes = $("#post").val();
    var userName = $("#userid").text();
    $.ajax({
        type: 'POST',
        url: 'notes.php',
        data: 
        {
            notes:notes,
            username:userName
        },
        dataType: "text",
        success: function(data) {
            $("#post").val('');            
        },
        error: function(event,xhr,error) {
            console.log(xhr);
        }
    });
}

function title() {
    var title = $("#title").val();
    var userName = $("#userid").text();
    $.ajax({
        type: 'POST',
        url: 'title.php',
        data: 
        {
            notes:notes,
            username:userName
        },
        dataType: "text",
        success: function(data) {
            $("#post").val('');            
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
    $("#posttext-"+id).css("display", "none");
    $("#editpost-"+id).slideDown();
}

function editPost(id) {
    var post = $("#editpost-"+id).children("textarea").val();
    var userName = $("#userid").text();
    $.ajax({
        type: 'POST',
        url: '/editPost',
        data: 
        {
            id: postid,
            post: post,
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
            window.location.href = "loginh.php";
        },
        error: function(event,xhr,error) {
            console.log(xhr);
        }
    });
}