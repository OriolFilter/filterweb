function checkLogin() {
    var namePLog = document.getElementById("logName").value;
    var passLog = document.getElementById("logPass").value;

    if (namePLog==""||passLog=="") {
        document.getElementById("logInResponse").hidden=0;
        document.getElementById("logInResponse").innerHTML="Error: You missed to fill an element!\n";
    } else {
        if (namePLog=="test" && passLog=="test"){
        //    Log In with test/test
            window.location.replace(window.location.origin +"/cart.php");
        } else {
            document.getElementById("logInResponse").hidden=0;
            document.getElementById("logInResponse").innerHTML="Error: Wrong password or username!\n";
        }
    }
}