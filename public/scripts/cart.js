function closeButtons() {
    var closebtns = document.getElementsByClassName("close");
    var i;

    for (i = 0; i < closebtns.length; i++) {
        closebtns[i].addEventListener("click", function() {
            this.parentElement.style.display = 'none';
            updateCartPrice();
        });
    }
}
function  recalculateCart(id){
    // alert (parseFloat("5€".replace("€",""))+6)

}

function modQuantCart() {
    var plusbtns = document.getElementsByClassName("+");
    var i;

    for (i = 0; i < plusbtns.length; i++) {
        plusbtns[i].addEventListener("click", function() {
            this.parentElement.parentElement.getElementsByClassName("qNum")[0].textContent++;
            updateCartPrice();
        });
    }
    var lessbtns = document.getElementsByClassName("-");
    var e;

    for (e = 0; e < lessbtns.length; e++) {
        lessbtns[e].addEventListener("click", function() {
            this.parentElement.parentElement.getElementsByClassName("qNum")[0].textContent--;
            if (parseFloat(this.parentElement.parentElement.getElementsByClassName("qNum")[0].textContent)==0){
                this.parentElement.parentElement.parentElement.parentElement.parentElement.style.display = 'none';
            }
            updateCartPrice();
        });
    }
}

function startupCart() {
    closeButtons();
    modQuantCart();
    updateCartPrice();
}

function updateCartPrice() {

    var products=document.getElementsByClassName("cartProduct");
    var price=0;
    for (i=0;i<products.length;i++){
            price=price+(parseFloat(products[i].getElementsByClassName("qNum")[0].textContent)*parseFloat(products[i].getElementsByClassName("pprice")[0].textContent.replace(" €","")));

        // alert(products[i].getElementsByClassName("pprice")[0]);
    }
    document.getElementById("cartPrice").textContent=price+" €";
}
function buyCart() {
    window.location.replace(window.location.origin +"/index.php");
}
// https://www.w3schools.com/howto/tryit.asp?filename=tryhow_js_close_list_items