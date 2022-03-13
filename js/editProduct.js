let productId=document.getElementById("productId");
let inputProd = document.getElementById("inputProduct");
let inputPic=document.getElementById("inputPicture");

let inputCategory=document.getElementById("inputCategory");
let inputPric=document.getElementById("inputPrice");

let query=new URLSearchParams(window.location.search);
console.log(query.get("id"));
async  function initFunction(){
    let product = await (await fetch("../php/controllers/getProduct.php?productId="+query.get("id"))).json();
    console.log(product);
    renderForm(product[0]);
   
}
function renderForm(product){
    productId.value=product.id;
    inputProd.value=product.name;
    inputCategory.value=product.status;
    inputPric.value=product.Price;
    
}
initFunction();


