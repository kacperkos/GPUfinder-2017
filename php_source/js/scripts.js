function validateAddNewCardForm() {
    if(document.forms["addNewCard"]["card_name"].value == "" || document.forms["addNewCard"]["card_power"].value == "") {
        alert("Information: All fields are required");
        return false;
    } else if(document.forms["addNewCard"]["card_power"].value <= 0) {
        alert("Information: GPU Power must be bigger than 0");
        return false;
    }
    return true;
}
function validateAddNewOfferForm() {
    if(document.forms["addNewOffer"]["offer_price"].value == "" || document.forms["addNewOffer"]["offer_source"].value == "" || document.forms["addNewOffer"]["offer_id"].value == "") {
        alert("Information: All fields are required");
        return false;
    }
    if(document.forms["addNewOffer"]["offer_id"].value <= 0) {
        alert("Information: Offer ID must be bigger than 0");
        return false;
    }
    if(document.forms["addNewOffer"]["offer_price"].value <= 0) {
        alert("Information: Price must be bigger than 0");
        return false;
    }
    return true;
}
function validateAddNewCryptoForm() {
    if(document.forms["addNewCrypto"]["crypto_name"].value == "" || document.forms["addNewCrypto"]["crypto_symbol"].value == "" || document.forms["addNewCrypto"]["crypto_price"].value == "" || document.forms["addNewCrypto"]["crypto_efficiency"].value == "") {
        alert("Information: All fields are required");
        return false;
    }
    if(document.forms["addNewCrypto"]["crypto_efficiency"].value <= 0) {
        alert("Information: Extraction must be bigger than 0");
        return false;
    }
    if(document.forms["addNewCrypto"]["crypto_price"].value <= 0) {
        alert("Information: Price must be bigger than 0");
        return false;
    }
    return true;
}
function validateAddNewHashrateForm() {
    if(document.forms["addNewHashrate"]["hashrate_crypto"].value == "" || document.forms["addNewHashrate"]["hashrate_hashrate"].value == "") {
        alert("Information: All fields are required");
        return false;
    }
    if(document.forms["addNewHashrate"]["hashrate_hashrate"].value <= 0) {
        alert("Information: Hashrate must be bigger than 0");
        return false;
    }
    return true;
}
function hideMessage() {
    document.getElementById("messageTxt").style.display = "none";
    document.cookie = "message=hidden";
}
function checkMessageCookie() {
    var message = getCookie("message");
    if(message === "hidden") {
        document.getElementById("messageTxt").style.display = "none";
    }
}
function getCookie(name) {
    var cookies = document.cookie.split(';');
    for(var i = 0; i < cookies.length; i++) {
        var cookie = cookies[i];
        while (cookie.charAt(0) == ' ') {
            cookie = cookie.substring(1);
        }
        if (cookie.indexOf(name + '=') == 0) {
            return cookie.substring(name.length + 1, cookie.length);
        }
    }
  return null;
}