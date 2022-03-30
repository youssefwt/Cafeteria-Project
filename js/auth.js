async function signout() {
    await fetch("../php/controllers/logout.php");
    location.assign("../");
  }

async function logged_or_not(){
    let user = 0;
    if(await(await fetch('../php/controllers/logged_in.php')).text()){
        user = JSON.parse(await(await fetch('../php/controllers/logged_in.php')).text());
    }
    return user;
}

logged_or_not().then((user)=>{
    if(!user){
        location.assign("../html/sign_in.html");
    }else if(user.role != "admin"){
        location.assign("../html/user_make_order.html");
    }
});