let params = new URLSearchParams(window.location.search);

async function logged_or_not(){
    let user = 0;
    if(await(await fetch('../php/controllers/logged_in.php')).text()){
        user = JSON.parse(await(await fetch('../php/controllers/logged_in.php')).text());
    }
    return user;
}

logged_or_not().then((result)=>{
        if(result){
            location.assign("../index.html")
        }
}).catch(console.log("do login you idiot"));

if(params.has('email')){
    let email = document.getElementById("email_label");
    email.innerHTML = "Enter email";
}

if(params.has('password')){
    let password = document.getElementById("password_label");
    password.innerHTML = "Enter password";
}

if(params.has('wrong_info')){
    let password = document.getElementById("wronginfo");
    password.innerHTML = "Wrong email and password combination.";
}

document.getElementById("home").addEventListener("click", function(){
    location.assign("../")
})