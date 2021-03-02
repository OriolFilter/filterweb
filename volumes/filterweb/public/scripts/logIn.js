function login() {
    //vars
    var obligatory_fields = ["uname", "pass"];
    var fields = obligatory_fields;
    var form=document.forms["logInForm"];

    //hide_message
    // document.getElementById("logInResponse").hidden=1;

    // var check_f=parseInt(!check_form(form,obligatory_fields));
    var response=check_form(form,obligatory_fields);

    //0 -> nice!

    if (response==1){
        post(form,fields,window.location.host);
    } else {
        response_response(response);
    }

}

function response_response(response_code){
    // 0 Unknown
    // 1 Success
    // 2 Error on login, might be wrong username or password
    // 3 Missing field
    // Can be done with switch? yes, but if it's faster unless there be a long list, and yet, if just will be faster for the last entries.
    // Error too much attempts wait a little?
    var code=parseInt(response_code);
    if (code == 1){
        document.getElementById("logInResponse").hidden=0;
        document.getElementById("logInResponse").innerHTML="Login Success!\n";
        //redirect to index?
        //.php can have a redirect page
    }
    else if (code == 2)
    {
        document.getElementById("logInResponse").hidden=0;
        document.getElementById("logInResponse").innerHTML="Error: Wrong password or username!\n";
    }
    else if (code == 3)
    {
        document.getElementById("logInResponse").hidden=0;
        document.getElementById("logInResponse").innerHTML="Error: Missing field!\n";
    }
    else {
        //    Unknown error
        document.getElementById("logInResponse").hidden=0;
        document.getElementById("logInResponse").innerHTML="Unknown error, if this error is persistent contact with the administrator!\n";
    }
}


function post(form,fields,root_url) {

    var url='https://'+root_url+'/login_form/';
    var query='?';

    //start manual concat
    var l = fields.length;
    var fieldname;
    for (i = 0; i < l; i++) {
        if (query != '?') {
            query+='&';
        }
        fieldname=fields[i];
        var normalized_input=normalize_string(document.forms['logInForm'][fieldname].value);
        query+=fieldname+'='+normalized_input;
    }

    //end manual concat
    var objXMLHttpRequest = new XMLHttpRequest();
    objXMLHttpRequest.onreadystatechange = function() {
        if(objXMLHttpRequest.readyState === 4) {
            if(objXMLHttpRequest.status === 200) {
                response_response(objXMLHttpRequest.responseText);
                // response_response(0);

            } else {
                // alert('Error Code: ' +  objXMLHttpRequest.status);
                // alert('Error Message: ' + objXMLHttpRequest.statusText);
                response_response(0);
            }

        }
    }
    objXMLHttpRequest.open('GET', url+query,true);
    objXMLHttpRequest.send();
}

function normalize_string(string){
    return string;
}

function check_form(form,fields_to_check){
    var l = fields_to_check.length;
    var fieldname;
    for (i = 0; i < l; i++) {
        fieldname = fields_to_check[i];
        // (fieldname);
        // if (document.forms["logInForm"][fieldname].value === "") {
        if (form[fieldname].value === "") {
            return 3;
        }
    } //Check no empty fields

    // Further (manual) checking

    // All gucci
    return 1;
}