function prodFilter(brand) {
    switch (brand) {
        case "sanwa":
            for (var x=0; x<document.getElementsByClassName("sw").length;x++) {
                document.getElementsByClassName("sw")[x].hidden=0;
            }
            for (var x=0; x<document.getElementsByClassName("sm").length;x++) {
                document.getElementsByClassName("sm")[x].hidden=1;
            }
            break;
        case "seimitsu":
            for (var x=0; x<document.getElementsByClassName("sw").length;x++) {
                document.getElementsByClassName("sw")[x].hidden=1;
            }
            for (var x=0; x<document.getElementsByClassName("sm").length;x++) {
                document.getElementsByClassName("sm")[x].hidden=0;
            }
            break;
        case "all":
            for (var x=0; x<document.getElementsByClassName("product").length;x++) {
                document.getElementsByClassName("product")[x].hidden=0;
            }
            break;
    }
}


