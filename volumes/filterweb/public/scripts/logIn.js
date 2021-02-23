function login() {
    //0 Success
    //1 Missing field
    //2 Error on login, might be wrong username or password
    // alert("!");
    var response =parseInt(checkLogin());
    if (response == '0'){

    }
    else if (response == '1')
    {
        document.getElementById("logInResponse").hidden=0;
        document.getElementById("logInResponse").innerHTML="Error: Wrong password or username!\n";
    }
    else if (response == '2')
        {
            document.getElementById("logInResponse").hidden=0;
            document.getElementById("logInResponse").innerHTML="Error: Missing field!\n";
        }

    else {
        //    Unknown error
        document.getElementById("logInResponse").hidden=0;
        document.getElementById("logInResponse").innerHTML="Unknown error!\n";
    }
}


function post(path, form, method='post') {
    var fields= ['uname','passwd'];
    alert(form[fields[0]].value);
    alert(form[fields[1]].value);
    // alert(form);
    xhttp.open("POST", path, true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("fname=&lname=");
}
// function post(path, params, method='post') {
//
//     // The rest of this code assumes you are not using a library.
//     alert(0);
//     // It can be made less wordy if you use one.
//     const form = document.createElement('form');
//     form.method = method;
//     form.action = path;
//
//     for (const key in params) {
//         if (params.hasOwnProperty(key)) {
//             alert(params);
//             alert(key);
//             const hiddenField = document.createElement('input');
//             hiddenField.type = 'hidden';
//             hiddenField.name = key;
//             hiddenField.value = params[key];
//
//             form.appendChild(hiddenField);
//         }
//     }
//
//     document.body.appendChild(form);
//     form.submit();
// }

function checkLogin() {
    var post_path= "/forms/login_form.php";

    // Check values
    var fields = ["uname", "passwd"];
    // alert(fields[1]);
    var l = fields.length;
    var fieldname;
    for (i = 0; i < l; i++) {
        fieldname = fields[i];
        if (document.forms["logInForm"][fieldname].value === "") {
            return 2;
        }
    }
    // alert(0);
    post(post_path,document.forms["logInForm"],"post");
    // $.ajax({
    //     type: "POST",
    //     url: url,
    //     data: data,
    //     success: success,
    //     dataType: dataType
    // });



    // if (namePLog==""||passLog=="") {
    //     document.getElementById("logInResponse").hidden=0;
    //     document.getElementById("logInResponse").innerHTML="Error: You missed to fill an element!\n";
    // } else {
    //     if (namePLog=="test" && passLog=="test"){
    //     //    Log In with test/test
    //         window.location.replace(window.location.origin +"/cart.php");
    //     } else {
    //         return 1;
    //     }
    // }

    // post('/contact/', {name: 'Johnny Bravo'});
    // alert(1);
    // post(post_path,{'uname': document.forms["logInForm"][field[0]].value});
    // alert(2);
}