let productId=document.getElementById("productId");
let query=new URLSearchParams(window.location.search);
console.log(query.get("id"));
async  function initFunction(){
    let product = await (await fetch("../php/controllers/getProduct.php?productId="+query.get("id"))).json();
    console.log(product);
    renderForm(product[0]);
   
}
initFunction();