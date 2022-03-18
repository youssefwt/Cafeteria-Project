async function logged_or_not(){
    let user = 0;
    if(await(await fetch('../php/controllers/logged_in.php')).text()){
        user = JSON.parse(await(await fetch('../php/controllers/logged_in.php')).text());
    }
    return user;
}

