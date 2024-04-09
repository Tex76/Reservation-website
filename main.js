function ShowUser(val) {
    if (val == "") {
        document.getElementById("customerInfo").innerHTML = "Nothing selected";
        return;
    }
    const xhttp = new XMLHttpRequest();
    xhttp.onload = function () {
        document.getElementById("customerInfo").innerHTML = this.responseText;
    }
    xhttp.open("GET", "getUsers.php?id=" + val);
    xhttp.send();



}