let query = window.location.search.substring(1).split("&");
console.log(query[0][0]);
console.log(query);
if(query.length == 2){
    let name = document.getElementById("name_label");
    name.innerHTML = "Enter username";
    let password = document.getElementById("password_label");
    password.innerHTML = "Enter password";
}else if(query[0][0] == "u"){
    let name = document.getElementById("name_label");
    name.innerHTML = "Enter username";
}else if(query[0][0] == "p"){
    let password = document.getElementById("password_label");
    password.innerHTML = "Enter password";
}