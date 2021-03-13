$(document).ready(function(){
    $("button").click(function() {register();});
});

async function register() {
    try {
        document.getElementById("send_form").disabled = true;
        var server_response_obj = document.getElementById('serverResponse');
        loading(server_response_obj);
        /* Error codes */
        var form = document.forms["form"];
        var error_obj = {name: 'Error Handler', error_list: []};
        var data_obj = {json:null, response: null};
        error_obj.code_dict = {
            '0': 'Unknown error',

            '1': 'Success',

            '2': 'Missing field(s)',
            '2.1': 'Username field is missing',
            '2.2': 'Password field is missing',

            '5': 'Client-Server errors',
            '5.1': 'There was a unknown error sending the data, please, try again later, if this error is consistent please contact an administrator.',
            '5.2': 'Server under maintenance, please, try again bit later.'
        };

        // error_obj.code_hint_dict = {null};
        error_obj.json_response = null;

        if (check_fields(form, error_obj)) {
            data_obj.json=return_json_form(form);
            data_obj.response= await post(data_obj.json,error_obj,server_response_obj);
            server_alert(data_obj.response,server_response_obj);
        } else {alert_error(error_obj,server_response_obj);}
    }
    catch (e){
        console.log(e);
    } finally {
        document.getElementById("send_form").disabled = false;
    }
}

function return_json_form(form){

    var uname=form['uname'].value;
    var pass=form['pass'].value;

    json={
        uname: uname,
        pass: pass
    }
    console.log(json);
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
    console.log(json);
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
    server_response_obj.innerHTML='<p id="success_form">Success!</p>';
}

function check_fields(form,error_obj){
    var obligatory_fields = {"uname":'2.1', "pass":'2.2'}; /* check specified*/
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

    if (error_obj.error_list.length>0){
        return false;
    }return true;


}

async function post(json,error_obj,server_response_obj) {
    let result;

    try {
        result = await $.ajax({
            url: '/forms/login/',
            type: 'POST',
            data: json
        });

        return json_response=JSON.parse(result);
    } catch (error) {
        console.error(error);
        error_obj.error_list.push('5.1');
        alert_error(error_obj,server_response_obj);

    }
}
function loading (server_response_obj) {
    server_response_obj.hidden=0;
    server_response_obj.innerHTML='<p id="loading"></p>';
}