$(document).ready(function(){
    $("button").click(function() {register();});
});

async function register() {
    /* Error codes */
    var form = document.forms["signInForm"];
    var error_obj = {name: 'Error Handler', error_list: []};
    var data_obj = {json:null, response: null};
    error_obj.code_dict = {
        '0': 'Unknown error',

        '1': 'Success',

        '2': 'Missing field(s)',
        '2.1': 'Username field is missing',
        '2.2': 'Password field is missing',
        '2.3': 'Email field is missing',
        '2.4': 'Repeat password field is missing',
        '2.5': 'Repeat email field is missing',

        '3': 'Requirements not achieved',
        '3.1': 'Username does not meet the requirements',
        '3.2': 'Password does not meet the requirements',
        '3.3': 'Email does not meet the requirements',

        '4': 'Field matching',
        '4.1': 'Passwords don\'t match',
        '4.2': 'Emails don\'t match',

        '5': 'Client-Server errors',
        '5.1': 'There was a unknown error sending the data, please, try again later, if this error is consistent please contact an administrator.',
        '5.2': 'Server under maintenance, please, try again bit later.'
    };

    error_obj.code_hint_dict = {
        '3.1': 'The username needs to be from 6 to 20 characters and contain only the following allowed characters:\nLetters from a to z (upper and lower case)\nNumbers from 0 to 9\nSpecial characters "_-+."',
        '3.2': 'The password needs to be from 6 to 20 characters and contain only the following allowed characters:\nLetters from a to z (upper and lower case)\nNumbers from 0 to 9\nSpecial characters "$%.,?!@+_=-"',
        '3.3': 'The given email seems to be invalid',
    };
    error_obj.json_response = null;

    if (check_fields(form, error_obj)) {
        data_obj.json=return_json_form(form);
        data_obj.response= await post(data_obj.json,error_obj);
        server_alert(data_obj.response);
    } else {alert_error(error_obj);}
}

function return_json_form(form){

    var uname=form['uname'].value;
    var pass=form['pass'].value;
    var email=form['email'].value;

    json={
        uname: uname,
            pass: pass,
        email: email
    }
    return(json);

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

function server_alert(json){
    console.log(json);
    if (json['status_code']=="1") {
        success();
    } else {
        var error_message='';
        error_message+='<p id="error_form">'+json['error']["message"]+'</p>';
        if (json['error']['hint']) {
            error_message+='<p id="hint_form">'+json['error']["hint"]+'</p>';}
        document.getElementById("signInResponse").hidden=0;
        document.getElementById("signInResponse").innerHTML=error_message;
    }

}
function success(){
    document.getElementById("signInResponse").hidden=0;
    document.getElementById("signInResponse").innerHTML='<p id="success_form">Success! An activation link been sent the provided email!</p>';
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
    if (!(/^[a-zA-Z0-9_.-.+]{6,20}$/g.test(form['uname'].value))){
        error_obj.error_list.push('3.1');
     }
    if (!(/^[a-zA-Z0-9$%.,?!@+_=-]{6,20}$/g.test(form['pass'].value))){
        error_obj.error_list.push('3.2');
     }
    if (!(/^[a-zA-Z0-9.!#$%&'*+=?^_`{|}~-]+@[a-zA-Z10-9-]+\.[a-zA-Z0-9-]+$/.test(form['email'].value))){
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

async function post(json,error_obj) {
    let result;

    try {
        result = await $.ajax({
            url: '/forms/registration.php',
            type: 'POST',
            data: json
        });

        return json_response=JSON.parse(result);
    } catch (error) {
        console.error(error);
        error_obj.error_list.push('5.1');
        alert_error(error_obj);

    }
}