// let Product_Container=document.getElementById("Product_Container");
let tBody=document.getElementById("tBody");
console.log(tBody);

async  function initFunction(){
    let products = await (await fetch("../php/controllers/products.php")).json();
    console.log(products);
    // Product_table("products","name", "Price");
   Product_table(products);
}

//  function Product_table($table_name, ...$args){
     function Product_table(products){
       
    for (const product of products) {
        
        tBody.innerHTML+=`
       <tr class='text-center'> 
         <td class='fs-5'>${product.name}</td>
         <td class='fs-5'>${product.Price}</td>
         <td class='fs-5'><img src="../assets/images/products/${product.image_url}" style='width:100px; height:100px ;border-radius:50%' alt="${product.name}" /></td>
        <td class='fs-5'>${product.status}<td>
        <td class='fs-5'><a  class='btn btn-warning' href='editProduct.html?id=${product.id}'>Edit</a></td></td>
        <td class='fs-5'><a class='btn btn-danger' id='delet' href='../php/deleteProduct.php?id=${product.id}' onclick="return confirm('Are you sure?');">Delete</a></td></td>
       </tr>
        `;
    }
}

initFunction();

async function signout(){
    await fetch('../php/controllers/logout.php');
    location.reload();
}

let user = {id:null, name:null, role:null};

async function fillUser(){
    try {
        user = await (await fetch('../php/controllers/logged_in.php')).json();
    }catch {
        user = {id:null, name:null, role:null};
    }
    return user;
}

fillUser().then((user)=>{
    let header = document.getElementById('header');

    header.innerHTML = `
    <a href="../" class="logo">
        <img src="../assets/images/landing-page/logo.png" alt="" />
    </a>

    <nav class="navbar" id="nav">
        <a href="../">Home</a>
        <a href="../#menu">Menu</a>
    </nav>
    <div class="icons d-flex align-items-baseline">
        <div class="fas fa-bars" id="menu-btn"></div>
        <button onclick="${user.id ? "signout()" : "location.assign('../html/sign_in.html')"}" class="buttonSignout btn btn-alert">${user.id ? "Sign out" : "Sign in"}</button>
    </div>
`;
    let nav = document.getElementById('nav');
    if(user.role=='admin'){
        nav.innerHTML+= `
            <a href="../html/fillUsersTable.html">Users</a>
            <a href="../html/product_table.html">Products</a>
            <a href="../checks.html">Checks</a>
            <a href="../php/admin_orders.php">All Orders</a> <!-- GAZAR Y3DLHA NOOOW: GAZZAR 3ADLHA 2OLLTTTT -->
        `;
    }else{
        location.assign('../')
    }
});