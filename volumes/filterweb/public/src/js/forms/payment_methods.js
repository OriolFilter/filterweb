/* Remove payment method */
$(document).ready(function(){
    $(".remove_payment").click(function() {rpm_send_form(this.id);});
    // $(".remove_payment").click(function() {console.log(this.id);});
});

/* Mirar com pillar l'id */
async function rpm_send_form(id=null) {
    try {
        /* Remove payment method */
        // document.getElementById("add_payment").disabled = true;
        var server_response_obj = document.getElementById("serverResponse");
        rpm_loading(server_response_obj);
        /* Error codes */
        // var form = document.forms["form"];
        var error_obj = {name: 'Error Handler', error_list: []};
        var data_obj = {json:null, response: null};
        error_obj.code_dict = {
            '0': 'Unknown error',

            '1': 'Success',

            '2': 'Missing field(s)',
            '2.10': 'Payment method id field is missing',

            '3': 'Requirements not achieved',
            '3.8': 'Payment method id does not meet the requirements',

            '5': 'Client-Server errors',
            '5.1': 'There was a unknown error sending the data, please, try again later, if this error is consistent please contact an administrator.',
            '5.2': 'Server under maintenance, please, try again bit later.'
        };

        error_obj.code_hint_dict = {
            '3.8': 'Payment method info must be a integer'
        };
        error_obj.json_response = null;

        if (rpm_check_fields(id, error_obj)) {
        data_obj.json=rpm_return_json_form(id);
        console.log(data_obj.json);
        data_obj.response= await rpm_post(data_obj.json,error_obj,server_response_obj);
        rpm_server_alert(data_obj.response,server_response_obj);
        } else {rpm_alert_error(error_obj,server_response_obj);}
    }
    catch (e){
        console.log(e);
    } finally {
        document.getElementById("add_payment").disabled = false;
    }
}

function rpm_return_json_form(id){
    json={
        pmid: id
    }
    console.log(json);
    return(json);

}

function rpm_alert_error(error_obj,server_response_obj){
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

function rpm_server_alert(json,server_response_obj){
    if (json['status_code']=="1") {
        rpm_success(server_response_obj);
    } else {
        var error_message='';
        error_message+='<p id="error_form">'+json['error']["message"]+'</p>';
        if (json['error']['hint']) {
            error_message+='<p id="hint_form">'+json['error']["hint"]+'</p>';}
        server_response_obj.hidden=0;
        server_response_obj.innerHTML=error_message;
    }

}
function rpm_success(server_response_obj){
    server_response_obj.hidden=0;
    server_response_obj.innerHTML='<p id="success_form">Success!</p>';
    location.reload();
}

function rpm_check_fields(id,error_obj){
    if (id == "" || id == null ) {
        error_obj.error_list.push('2.10');
    }
    if (error_obj.error_list.length>0){
        return false;
    }
    /* Check regex */
    if (!(/^[0-9]+$/.test(id))){
        error_obj.error_list.push('3.6');
    }
    console.log(error_obj.error_list);
    console.log(id);
    if (error_obj.error_list.length>0){
        return false;
    }

    return true;


}

async function rpm_post(json,error_obj,server_response_obj) {
    let result;

    try {
        result = await $.ajax({
            url: '/forms/account_management/delete_payment_method/',
            type: 'POST',
            data: json
        });
        return json_response=JSON.parse(result);
    } catch (error) {
        error_obj.error_list.push('5.1');
        rpm_alert_error(error_obj,server_response_obj);

    }
}
function rpm_loading (server_response_obj) {
    server_response_obj.hidden=0;
    server_response_obj.innerHTML='<p id="loading"></p>';
}























/* Add payment method*/
$(document).ready(function(){
    $("#add_payment").click(function() {apm_send_form();});
});

async function apm_send_form() {
    try {
        /* Add Payment method */
        document.getElementById("add_payment").disabled = true;
        var server_response_obj = document.getElementById("serverResponse");
        apm_loading(server_response_obj);
        /* Error codes */
        var form = document.forms["form"];
        var error_obj = {name: 'Error Handler', error_list: []};
        var data_obj = {json:null, response: null};
        error_obj.code_dict = {
            '0': 'Unknown error',

            '1': 'Success',

            '2': 'Missing field(s)',
            '2.8': 'Payment method name field is missing',
            '2.9': 'Payment method info field is missing',
            '2.10': 'Payment method id field is missing',

            '3': 'Requirements not achieved',
            '3.6': 'Payment method name does not meet the requirements',
            '3.7': 'Payment method info does not meet the requirements',
            '3.8': 'Payment method id does not meet the requirements',

            '5': 'Client-Server errors',
            '5.1': 'There was a unknown error sending the data, please, try again later, if this error is consistent please contact an administrator.',
            '5.2': 'Server under maintenance, please, try again bit later.'
        };

        error_obj.code_hint_dict = {
            '3.6': 'Payment method name needs to be from 6 to 20 characters and contain only the following allowed characters:\nLetters from a to z (upper and lower case)\nNumbers from 0 to 9 and/or spaces or _',
            '3.7': 'Payment method info must needs to be from 6 to 20 characters and contain only the following allowed characters:\nLetters from a to z (upper and lower case)\nNumbers from 0 to 9', /* Unused*/
            '3.8': 'Payment method info must be a integer'
        };
        error_obj.json_response = null;

        if (apm_check_fields(form, error_obj)) {
            data_obj.json=apm_return_json_form(form);
            data_obj.response= await apm_post(data_obj.json,error_obj,server_response_obj);
            apm_server_alert(data_obj.response,server_response_obj);
        } else {apm_alert_error(error_obj,server_response_obj);}
    }
    catch (e){
            console.log(e);
        } finally {
            document.getElementById("add_payment").disabled = false;
    }
}

function apm_return_json_form(form){

    var pmname=form['fpmname'].value;
    json={
        pmname: pmname
    }
    return(json);

}

function apm_alert_error(error_obj,server_response_obj){
    console.error(error_obj.error_list);
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

function apm_server_alert(json,server_response_obj){
    if (json['status_code']=="1") {
        apm_success(server_response_obj);
    } else {
        var error_message='';
        error_message+='<p id="error_form">'+json['error']["message"]+'</p>';
        if (json['error']['hint']) {
            error_message+='<p id="hint_form">'+json['error']["hint"]+'</p>';}
        server_response_obj.hidden=0;
        server_response_obj.innerHTML=error_message;
    }

}
function apm_success(server_response_obj){
    server_response_obj.hidden=0;
    server_response_obj.innerHTML='<p id="success_form">Success!</p>';
    location.reload();
}

function apm_check_fields(form,error_obj){
    var obligatory_fields = {'fpmname':'2.9'}; /* check specified*/
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
    if (!(/^[a-zA-Z0-9_ ]{6,20}$/.test(form['fpmname'].value))){
        error_obj.error_list.push('3.6');
     }

    if (error_obj.error_list.length>0){
        return false;
    }

    return true;


}

async function apm_post(json,error_obj,server_response_obj) {
    let result;

    try {
        result = await $.ajax({
            url: '/forms/account_management/add_payment_method/',
            type: 'POST',
            data: json
        });
        return json_response=JSON.parse(result);
    } catch (error) {
        error_obj.error_list.push('5.1');
        apm_alert_error(error_obj,server_response_obj);

    }
}
    function apm_loading (server_response_obj) {
        server_response_obj.hidden=0;
        server_response_obj.innerHTML='<p id="loading"></p>';
    }