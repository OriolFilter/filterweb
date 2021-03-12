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
            '2.2': 'Password field is missing',
            '2.4': 'Repeat password field is missing',

            '3': 'Requirements not achieved',
            '3.2': 'Password does not meet the requirements',

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
            '3.3': 'The given email is invalid',
        };
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

    var token=t.k;
    var pass=form['pass'].value;

    json={
        token: token,
        pass: pass,
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
    server_response_obj.innerHTML='<p id="success_form">Success! Password updated correctly!</p>';
}

function check_fields(form,error_obj){
    var obligatory_fields = {"pass":'2.2',"pass2":"2.4"}; /* check specified*/
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
    if (!(/^[a-zA-Z0-9$%.,?!@+_=-]{6,20}$/g.test(form['pass'].value))){
        error_obj.error_list.push('3.2');
     }

    if (error_obj.error_list.length>0){
        return false;
    }

    /* Check fieldsmatch */
    if (form['pass'].value!=form['pass2'].value){
        error_obj.error_list.push('4.1');
    };

    if (error_obj.error_list.length>0){
        return false;
    }
    return true;


}

async function post(json,error_obj,server_response_obj) {
    let result;

    try {
        result = await $.ajax({
            url: '/forms/change_password/',
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