let islogged = [];
logged_or_not().then((result)=>{
    if(!result){
        islogged = [false, null];
    }
    else if(result.role=="admin"){
        islogged = [true, 'admin']
    }
    else{
        islogged = [true, 'user']
    }
})

let header = document.getElementById('header');

let nav = document.getElementById('nav');
header.innerHTML = `
    <a href="./" class="logo">
       <img src="assets/images/landing-page/logo.png" alt="" />
    </a>

    <nav class="navbar" id="nav">
        <a href="#home">home</a>
        <a href="#menu">menu</a>
        <a href="./html/user_make_order.html">make order</a>
    </nav>

    <div class="icons d-flex align-items-baseline">
        <div class="fas fa-bars" id="menu-btn"></div>
        <button onclick="${islogged[0] == true ? "signout" : "location.assign('./html/sign_in.html')"}" class="btn btn-alert">${islogged[0] == true ? "Sign out" : "Sign in"}</button>
    </div>
`;

console.log()
