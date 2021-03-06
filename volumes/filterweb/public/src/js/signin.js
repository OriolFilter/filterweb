$("button").click(register());

function register() {
    var error_obj={name:'Error Handler',error_list:[]};
    error_obj.code_dict ={
        '0':'Unknown error',

        '1':'Success',

        '2':'Missing field(s)',
        '2.1':'Username field is missing',
        '2.2':'Password field is missing',
        '2.3':'Email field is missing',
        '2.4':'Repeat password field is missing',
        '2.5':'Repeat email field is missing',

        '3':'Requirements not achieved',
        '3.1':'Username does not meet the requirements',
        '3.2':'Password does not meet the requirements',
        '3.3':'Email does not meet the requirements',

        '4':'Field matching',
        '4.1':'Passwords don\'t match',
        '4.2':'Emails don\'t match'
    };

    error_obj.code_hint_dict = {
        '3.1': 'The username needs to be from 6 to 20 characters and contain only the following allowed characters:\nLetters from a to z (upper and lower case)\nNumbers from 0 to 9\nSpecial characters "_-+."',
        '3.2': 'The password needs to be from 6 to 20 characters and contain only the following allowed characters:\nLetters from a to z (upper and lower case)\nNumbers from 0 to 9\nSpecial characters "$%/.,?!+_=-"',
        '3.3': 'The given email seems to have wrong syntax',

    };

    var form=document.forms["signInForm"];
    if (check_fields(form,error_obj)){
        /* post */
        post(form);
    } else {
        alert_error(error_obj);
    }
    // var fields = obligatory_fields;
    // var form=document.forms["signInForm"];
    //
    // //hide_message
    // // document.getElementById("logInResponse").hidden=1;
    //
    // // var check_f=parseInt(!check_form(form,obligatory_fields));
    // var response=check_form(form,obligatory_fields);
    //
    // //0 -> nice!
    //
    // if (response==1){
    //     post(form,fields,window.location.host);
    // } else {
    //     response_response(response);
    // }

}

function alert_error(error_obj){
    var error_message='';
    for (x in error_obj.error_list) {
        error_message+='<p id="error_form">'+error_obj.code_dict[error_obj.error_list[x]]+'</p>';
        if (error_obj.error_list[x] in error_obj.code_hint_dict) {
            error_message+='<p id="hint_form">'+error_obj.code_hint_dict[error_obj.error_list[x]]+'</p>';
        }
    }
    document.getElementById("signInResponse").hidden=0;
    document.getElementById("signInResponse").innerHTML=error_message;
}

function check_fields(form,error_obj){
    var obligatory_fields = {"uname":'2.1', "pass":'2.2',"email":"2.3","pass2":"2.4","email2":"2.5"}; /* check specified*/
    var keys=Object.keys(obligatory_fields);
    var l = keys.length;
    var fieldname;
    for (i = 0; i < l; i++) {
        fieldname = keys[i];
        if (form[fieldname].value == "") {
            error_obj.error_list.push(obligatory_fields[fieldname]);
        }
    }
    if (error_obj.error_list.length>0){
        return false;
    }
    /* Check regex */
    if (!/d^[a-zA-Z0-9._.-.+.]{6,20}$/g.test(form['uname'].value)){
        error_obj.error_list.push('3.1');
     }
    if (!/^[a-zA-Z0-9$%/.,?!+_=-]{6,20}$/g.test(form['pass'].value)){
        error_obj.error_list.push('3.2');
     }
    if (!/^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z10-9-]+\.+[a-zA-Z0-9-]+$/g.test(form['email'].value)){
        error_obj.error_list.push('3.3');
     }

    if (error_obj.error_list.length>0){
        return false;
    }

    /* Check fieldsmatch */
    if (form['pass'].value!=form['pass2'].value){
        error_obj.error_list.push('4.1');
    };
    if (form['email'].value!=form['email2'].value){
        error_obj.error_list.push('4.2');
    };
    if (error_obj.error_list.length>0){
        return false;
    } else {return true};


}

function post(form){
    var uname=form['uname'].value;
    var pass=form['pass'].value;
    var email=form['email'].value;
    $.post("/",
        {
            uname: uname,
            pass: pass,
            email: email
        },
        function(data,status){
            alert("Data: " + data + "\nStatus: " + status);
        });
};


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


function post2(form,fields,root_url) {
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
        query+=fieldname+'='+document.forms['logInForm'][fieldname].value;
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
