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
