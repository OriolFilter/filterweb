$(document).ready(function(){
    $("button").click(function() {send_form();});
});

async function send_form() {
    /* Error codes */
    var form = document.forms["form"];
    var server_response_obj = document.getElementById("serverResponse");
    var error_obj = {name: 'Error Handler', error_list: []};
    var data_obj = {json:null, response: null};
    error_obj.code_dict = {
        '0': 'Unknown error',

        '1': 'Success',

        '2': 'Missing field(s)',
        '2.3': 'Email field is missing',
        '2.6': 'Name field is missing',
        '2.7': 'Text field is missing',

        '3': 'Requirements not achieved',
        '3.3': 'Email does not meet the requirements',
        '3.4': 'Name does not meet the requirements',
        '3.5': 'Text does not meet the requirements',

        '5': 'Client-Server errors',
        '5.1': 'There was a unknown error sending the data, please, try again later, if this error is consistent please contact an administrator.',
        '5.2': 'Server under maintenance, please, try again bit later.'
    };

    error_obj.code_hint_dict = {
        '3.3': 'The given email is invalid',
        '3.4': 'Name must be from 4 to 40 characters from the english alphabet or numbers, (spaces allowed)',
        '3.5': 'Text message must be from 20 to 400 characters'
    };
    error_obj.json_response = null;

    if (check_fields(form, error_obj)) {
        data_obj.json=return_json_form(form);
        data_obj.response= await post(data_obj.json,error_obj,server_response_obj);
        server_alert(data_obj.response,server_response_obj);
    } else {alert_error(error_obj,server_response_obj);}
}

function return_json_form(form){

    var name=form['contact-name'].value;
    var email=form['contact-email'].value;
    var text=form['contact-text'].value;

    json={
        name: name,
            email: email,
        text: text
    }
    return(json);

}

function alert_error(error_obj,server_response_obj){
    var error_message='';
    for (x in error_obj.error_list) {
        error_message+='<p id="error_form">'+error_obj.code_dict[error_obj.error_list[x]]+'</p>';
        if (error_obj.error_list[x] in error_obj.code_hint_dict) {
            error_message+='<p id="hint_form">'+error_obj.code_hint_dict[error_obj.error_list[x]]+'</p>';
        }
    }
    server_response_obj.hidden=0;
    server_response_obj.innerHTML=error_message;
}

function server_alert(json,server_response_obj){
    if (json['status_code']=="1") {
        success(server_response_obj);
    } else {
        var error_message='';
        error_message+='<p id="error_form">'+json['error']["message"]+'</p>';
        if (json['error']['hint']) {
            error_message+='<p id="hint_form">'+json['error']["hint"]+'</p>';}
        server_response_obj.hidden=0;
        server_response_obj.innerHTML=error_message;
    }

}
function success(server_response_obj){
    server_response_obj.hidden=0;
    server_response_obj.innerHTML='<p id="success_form">Success! The form been send correctly!</p>';
}

function check_fields(form,error_obj){
    var obligatory_fields = {'contact-name':'2.6', 'contact-email':"2.3",'contact-text':'2.7'}; /* check specified*/
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
    if (!(/^[\w0-9 ]{4,40}$/.test(form['contact-name'].value))){
        error_obj.error_list.push('3.4');
     }
    if (!(/^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z10-9-]+\.+[a-zA-Z0-9-]+$/.test(form['contact-email'].value))){
        error_obj.error_list.push('3.3');
     }
    if (!(/^[\w\W]{20,255}$/.test(form['contact-text'].value))){
        error_obj.error_list.push('3.5');
     }

    if (error_obj.error_list.length>0){
        return false;
    }

    return true;


}

async function post(json,error_obj,server_response_obj) {
    let result;

    try {
        result = await $.ajax({
            url: '/forms/contact_form/',
            type: 'POST',
            data: json
        });
        return json_response=JSON.parse(result);
    } catch (error) {
        error_obj.error_list.push('5.1');
        alert_error(error_obj,server_response_obj);

    }
}