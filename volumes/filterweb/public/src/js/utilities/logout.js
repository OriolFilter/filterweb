$(document).ready(function(){
    $("#logout_button").click(function() {logout()});
});

async function logout() {
    try {
        // document.getElementById("send_form").disabled = true;
        /* No message */
        // var server_response_obj = document.getElementById('serverResponse');
        //        loading(server_response_obj);
        /* Error codes */
        var form = document.forms["form"];
        var error_obj = {name: 'Error Handler', error_list: []};
        var data_obj = {json:null, response: null};
        error_obj.code_dict = {
            '0': 'Unknown error',

            '1': 'Success',

            '5': 'Client-Server errors',
            '5.1': 'There was a unknown error sending the data, please, try again later, if this error is consistent please contact an administrator.',
            '5.2': 'Server under maintenance, please, try again bit later.'
        };

        // error_obj.code_hint_dict = {null};
        error_obj.json_response = null;
        // data_obj.response= await post(error_obj,server_response_obj);
        data_obj.response= await lpost(error_obj);
        lserver_alert(data_obj.response);
        // server_alert(data_obj.response,server_response_obj);
        return true;
    }
    catch (e){
        console.log(e);
        return false;
    } finally {
        // document.getElementById("send_form").disabled = false;
    }
}

// function lreturn_json_form(form){
//
//     var uname=form['uname'].value;
//     var pass=form['pass'].value;
//
//     json={
//         uname: uname,
//         pass: pass
//     }
//     console.log(json);
//     return(json);
//
// }

// function lalert_error(error_obj,server_response_obj){
//     var error_message='';
//     for (x in error_obj.error_list) {
//         error_message+='<p id="error_form">'+error_obj.code_dict[error_obj.error_list[x]]+'</p>';
//         if (error_obj.error_list[x] in error_obj.code_hint_dict) {
//             error_message+='<p id="hint_form">'+error_obj.code_hint_dict[error_obj.error_list[x]]+'</p>';
//         }
//     }
//     server_response_obj.hidden=0;
//     server_response_obj.innerHTML=error_message;
// }

function lserver_alert(json){
    console.log(json);
    if (json['status_code']=="1") {
        lsuccess();
    } else {
        console.log('Failed to log out')
        // var error_message='';
        // error_message+='<p id="error_form">'+json['error']["message"]+'</p>';
        // if (json['error']['hint']) {
        //     error_message+='<p id="hint_form">'+json['error']["hint"]+'</p>';}
        // server_response_obj.hidden=0;
        // server_response_obj.innerHTML=error_message;
    }

}
/* Log Out Success*/
function lsuccess(){
    location.reload();
    // window.location.replace("/");
    // window.location.href("/");
    // server_response_obj.hidden=0;
    // server_response_obj.innerHTML='<p id="success_form">Success!</p>';

}

async function lpost(error_obj) {
    let result;

    try {
        result = await $.ajax({
            url: '/forms/logout/',
            type: 'POST',
            data: true
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