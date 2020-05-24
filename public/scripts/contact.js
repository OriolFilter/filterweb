function formSend() {
    var nameForm = document.getElementById("contactName").value;
    var emailForm = document.getElementById("contactEmail").value;
    var msgForm = document.getElementById("contactMsg").value;

    if (nameForm == '' || emailForm == '' || msgForm == '') {
        alert("Care! Seems like you missed to fill an element");
    } else {
        alert("Your message was sent correctly");
    }
}