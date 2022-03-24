let inputProduct = document.getElementById("inputProduct");
let labelProduct=document.getElementById("labelProduct");
let submit=document.getElementById("submit");
let isValidName=false;
let isValidImg=false;
inputProduct.addEventListener("keyup",validatName )
function validatName(){
    let ProductTestName =  inputProduct.value.search(/^[A-Za-z]+$/);
    if (ProductTestName == -1|| inputProduct == ""){
    labelProduct.innerHTML="Please enter only letters in this field.";
  
    isValidName=false;
    }
    else{
        labelProduct.innerHTML="";
        isValidName=true;
    }

}
let inputPicture=document.getElementById("inputPicture");
let labelImg=document.getElementById("labelImg");
inputPicture.addEventListener("change",validatImg)
function validatImg(){
    let isValid= (/\.(gif|jpe?g|tiff?|png|webp|bmp)$/i).test(inputPicture.value)
     if(!isValid){
         labelImg.innerHTML="only jpg or png or gif files allowed!";
         isValidImg=false;
     }
     else{
         labelImg.innerHTML="";
         isValidImg=true;
     }}

 async function getCategories(){
     let Categories=await(await fetch("../php/controllers/getCategory.php")).json();
     let inputCategory=document.getElementById('inputCategory');
   
     for( category of Categories){
        inputCategory.innerHTML+=`
           <option value="${category.name}">${category.name}</option>
`
     }
 
}
getCategories();
submit.addEventListener("click",function(e){
    if(!(isValidImg || isValidName)){
     e.preventDefault();
     validatImg();
     validatName();

    }
})


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
            <a href="../HTML/fillUsersTable.html">Users</a>
            <a href="../HTML/product_table.html">Products</a>
            <a href="../checks.html">Checks</a>
            <a href="../php/admin-orders.php">All Orders</a> <!-- GAZAR Y3DLHA NOOOW -->
        `;
    }else{
        location.assign('../')
    }
});

