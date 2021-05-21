/* Remove shipping address */
$(document).ready(function(){
    $(".remove_shipping").click(function() {rsa_send_form(this.id);});
});

async function rsa_send_form(id=null) {
    try {
        // document.getElementById("add_payment").disabled = true;
        var server_response_obj = document.getElementById("serverResponse");
        rsa_loading(server_response_obj);
        /* Error codes */
        // var form = document.forms["form"];
        var error_obj = {name: 'Error Handler', error_list: []};
        var data_obj = {json:null, response: null};
        error_obj.code_dict = {
            '0': 'Unknown error',

            '1': 'Success',

            '2': 'Missing field(s)',
            '2.11': 'Shipping address fields topic',
            '2.11.5': 'Shipping address id field is missing',

            '3': 'Requirements not achieved',
            '3.9': 'Shipping address fields topic',
            '3.9.7': 'Shipping address id does not meet the requirements',

            '5': 'Client-Server errors',
            '5.1': 'There was a unknown error sending the data, please, try again later, if this error is consistent please contact an administrator.',
            '5.2': 'Server under maintenance, please, try again bit later.'
        };

        error_obj.code_hint_dict = {
            '3.9.7': 'Shipping address id does not meet the requirements'
        };
        error_obj.json_response = null;

        if (rsa_check_fields(id, error_obj)) {
        data_obj.json=rsa_return_json_form(id);
        data_obj.response= await rsa_post(data_obj.json,error_obj,server_response_obj);
        console.log(data_obj.json);
        console.log(data_obj.response);
        rsa_server_alert(data_obj.response,server_response_obj);
        } else {rsa_alert_error(error_obj,server_response_obj);}
    }
    catch (e){
        console.log(e);
    } finally {
        // document.getElementById("add_payment").disabled = false;
    }
}

function rsa_return_json_form(id){
    json={
        sa_id: id
    }
    return(json);

}

function rsa_alert_error(error_obj,server_response_obj){
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

function rsa_server_alert(json,server_response_obj){
    console.error(server_response_obj);
    if (json['status_code']=="1") {
        rsa_success(server_response_obj);
    } else {
        var error_message='';
        error_message+='<p id="error_form">'+json['error']["message"]+'</p>';
        if (json['error']['hint']) {
            error_message+='<p id="hint_form">'+json['error']["hint"]+'</p>';}
        server_response_obj.hidden=0;
        server_response_obj.innerHTML=error_message;
    }

}
function rsa_success(server_response_obj){
    server_response_obj.hidden=0;
    server_response_obj.innerHTML='<p id="success_form">Success!</p>';
    location.reload();
}

function rsa_check_fields(id,error_obj){
    if (id == "" || id == null ) {
        error_obj.error_list.push('2.11');
    }
    if (error_obj.error_list.length>0){
        return false;
    }
    /* Check regex */
    if (!(/^[0-9]+$/.test(id))){
        error_obj.error_list.push('3.9.7');
    }
    if (error_obj.error_list.length>0){
        return false;
    }
    return true;


}

async function rsa_post(json,error_obj,server_response_obj) {
    let result;

    try {
        result = await $.ajax({
            url: '/forms/account_management/delete_shipping_address/',
            type: 'POST',
            data: json
        });
        return json_response=JSON.parse(result);
    } catch (error) {
        error_obj.error_list.push('5.1');
        rsa_alert_error(error_obj,server_response_obj);

    }
}
function rsa_loading (server_response_obj) {
    server_response_obj.hidden=0;
    server_response_obj.innerHTML='<p id="loading"></p>';
}























/* Add shipping address */
$(document).ready(function(){
    $("#add_address").click(function() {asa_send_form();});
});

async function asa_send_form() {
    try {
        /* Add Payment method */
        document.getElementById("add_address").disabled = true;
        var server_response_obj = document.getElementById("serverResponse");
        asa_loading(server_response_obj);
        /* Error codes */
        var form = document.forms["send_form"];
        var error_obj = {name: 'Error Handler', error_list: []};
        var data_obj = {json:null, response: null};
        error_obj.code_dict = {
            '0': 'Unknown error',

            '1': 'Success',

            '2': 'Missing field(s)',
            '2.11': 'Shipping address fields topic',
            '2.11.1': 'Shipping address country field is missing',
            '2.11.2': 'Shipping address city field is missing',
            '2.11.3': 'Shipping address postal code field is missing',
            '2.11.4': 'Shipping address line 1 field is missing',

            '3': 'Requirements not achieved',
            '3.9.1': 'Shipping address country field does not meet the requirements',
            '3.9.2': 'Shipping address city field does not meet the requirements',
            '3.9.3': 'Shipping address postal code field does not meet the requirements',
            '3.9.4': 'Shipping address line 1 field does not meet the requirements',
            '3.9.5': 'Shipping address line 2 field does not meet the requirements',
            '3.9.6': 'Shipping address line 3 field does not meet the requirements',

            '5': 'Client-Server errors',
            '5.1': 'There was a unknown error sending the data, please, try again later, if this error is consistent please contact an administrator.',
            '5.2': 'Server under maintenance, please, try again bit later.'
        };

        error_obj.code_hint_dict = {
            '3.9.1': 'Shipping address country needs to be 2 characters that represent the country following the standard ISO 3166-2',
            '3.9.4': 'Shipping address line 1 needs to be from 5 to 200 characters',
            '3.9.7': 'Shipping address id must be a integer'
        };
        error_obj.json_response = null;

        if (asa_check_fields(form, error_obj)) {
            data_obj.json=asa_return_json_form(form);
            data_obj.response= await asa_post(data_obj.json,error_obj,server_response_obj);
            asa_server_alert(data_obj.response,server_response_obj);
        } else {asa_alert_error(error_obj,server_response_obj);}
    }
    catch (e){
            console.log(e);
        } finally {
            document.getElementById("add_address").disabled = false;
    }
}

function asa_return_json_form(form){

    var country=form['sa_country'].value;
    var city=form['sa_city'].value;
    var pcode=form['sa_pcode'].value;
    var l1=form['sa_add1'].value;
    var l2=form['sa_add2'].value;
    var l3=form['sa_add3'].value;
    json={
        sa_country: country,
        sa_city: city,
        sa_pcode: pcode,
        sa_add1: l1,
        sa_add2: l2,
        sa_add3: l3,
    }
    return(json);

}

function asa_alert_error(error_obj,server_response_obj){
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

function asa_server_alert(json,server_response_obj){
    console.error(server_response_obj);
    if (json['status_code']=="1") {
        asa_success(server_response_obj);
    } else {
        var error_message='';
        error_message+='<p id="error_form">'+json['error']["message"]+'</p>';
        if (json['error']['hint']) {
            error_message+='<p id="hint_form">'+json['error']["hint"]+'</p>';}
        server_response_obj.hidden=0;
        server_response_obj.innerHTML=error_message;
    }

}
function asa_success(server_response_obj){
    server_response_obj.hidden=0;
    server_response_obj.innerHTML='<p id="success_form">Success!</p>';
    location.reload();
}

function asa_check_fields(form,error_obj){
    var obligatory_fields = {'sa_country':'2.11.1','sa_city':'2.11.2','sa_pcode':'2.11.3','sa_add1':'2.11.4'}; /* check specified*/
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
    if (!(/^[a-zA-Z]{2}$/.test(form['sa_country'].value))){
        error_obj.error_list.push('3.9.1');
    }
    if (!(/^[\w\W]+$/.test(form['sa_city'].value))){
        error_obj.error_list.push('3.9.2');
    }
    if (!(/^[\w\W]+$/.test(form['sa_pcode'].value))){
        error_obj.error_list.push('3.9.3');
    }
    if (!(/^[\w\W]{5,200}$/.test(form['sa_add1'].value))){
        error_obj.error_list.push('3.9.4');
    }
    if (!(/^[\w\W]{0,}$/.test(form['sa_add2'].value))){
        error_obj.error_list.push('3.9.5');
    }
    if (!(/^[\w\W]{0,}$/.test(form['sa_add3'].value))){
        error_obj.error_list.push('3.9.6');
    }

    if (error_obj.error_list.length>0){
        return false;
    }

    return true;


}

async function asa_post(json,error_obj,server_response_obj) {
    let result;

    try {
        result = await $.ajax({
            url: '/forms/account_management/add_shipping_address/',
            type: 'POST',
            data: json
        });
        return json_response=JSON.parse(result);
    } catch (error) {
        error_obj.error_list.push('5.1');
        asa_alert_error(error_obj,server_response_obj);

    }
}
    function asa_loading (server_response_obj) {
        server_response_obj.hidden=0;
        server_response_obj.innerHTML='<p id="loading"></p>';
    }