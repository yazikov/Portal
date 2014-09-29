$().ready(function() {
    var id = null;
    $.ajax({
        url: "php/advice.php?id="+id
    }).done(function(json){
        var data = $.parseJSON(json);
        id = data.textid;
        $('#advice').html(data.text);
    });

    $('#btnAdviceNext').click(function() {
        $.ajax({
            url: "php/advice.php?id="+id
        }).done(function(json){
            var data = $.parseJSON(json);
            id = data.textid;
            $('#advice').html(data.text);
        }).fail(function() {
            alert( "error" );
        });
    });

    $('#btnSaveUser').click(function() {
        var login = $('#inputLogin').val();
        var password = $('#inputPassword').val();
        var fio = $('#inputFIO').val();
        var birthday = $('#inputBirthday').val();
        var sex = $('#inputSex').val();
        var email = $('#inputEmail').val();
        var work = $('#inputWork').val();
        var about = $('#inputAbout').val();
        $.post("php/registration.php", {login : login, password : password, fio : fio, birthday : birthday, sex : sex, email : email, work : work, about : about}, function(data) {
            if(data && data !== "") {
                alert(data);
            } else {
                location.reload();
            }
        }).fail(function() {
            alert( "error" );
        });
    });


});