function validateForm() {
    var name = document.forms["form1"]["txtInterName"].value;
    var password = document.forms["form1"]["password"].value;
    if (name == "" || password == "") {
        alert("Please enter both name and password.");
        return false;
    }
}