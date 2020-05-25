function modQuantCart() {
    var plusbtns = document.getElementsByClassName("+");
    var i;

    for (i = 0; i < plusbtns.length; i++) {
        plusbtns[i].addEventListener("click", function() {
            this.parentElement.parentElement.getElementsByClassName("qNum")[0].textContent++;
        });
    }
    var lessbtns = document.getElementsByClassName("-");
    var e;

    for (e = 0; e < lessbtns.length; e++) {
        lessbtns[e].addEventListener("click", function() {
            if (parseFloat(this.parentElement.parentElement.getElementsByClassName("qNum")[0].textContent)>=0){
                this.parentElement.parentElement.getElementsByClassName("qNum")[0].textContent--;
            }
        });
    }
}

function startupCart() {
    modQuantCart();
}

function addToCart() {
    window.location.replace(window.location.origin +"/index.php");
}

// https://www.w3schools.com/howto/tryit.asp?filename=tryhow_js_close_list_items