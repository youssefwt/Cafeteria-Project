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
       <tr> 
         <td>${product.name}</td>
         <td>${product.Price}</td>
         <td><img src="../assets/images/test-images/${product.image_url}" alt="${product.name}" /></td>
         <td><a href='editProduct.html?id=${product.id}'>Edit</a></td></td>
         <td><a href='deleteProduct.html?id=${product.id}'>Delete</a></td></td>


       </tr>
         
           
        
      
        `;
        
    }

}

initFunction();
