let current_user = getCurrentUser().id;


async function signout(){
    // document.cookie = "PHPSESSID=; expires=Thu, 01 Jan 1970 00:00:00 UTC;";
    await fetch('./php/controllers/logout.php');
    location.reload();
}

fillUser().then((user)=>{
    let header = document.getElementById('header');

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
        <button onclick="${user.id ? "signout()" : "location.assign('./html/sign_in.html')"}" class="btn btn-alert">${user.id ? "Sign out" : "Sign in"}</button>
    </div>
`;
    let nav = document.getElementById('nav');
    if(user.role=='admin'){
        nav.innerHTML+= `
            <a href="./HTML/fillUsersTable.html">Users</a>
            <a href="./HTML/product_table.html">Products</a>
            <a href="./checks.html">Checks</a>
            <a href="./php/admin-orders.php">All Orders</a> <!-- GAZAR Y3DLHA NOOOW -->
        `;
    }else if(user.role=='user'){
        nav.innerHTML += `
        <a href="./HTML/users-orders.html">My orders</a>
`
    }

});

