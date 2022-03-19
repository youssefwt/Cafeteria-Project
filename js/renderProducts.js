let productsContainer = document.getElementById("productsContainer");
async function init() {
  let products = await fetch("./php/controllers/products.php");
  console.log(products);
  products = await products.json();
  console.log(products);
  renderProducts(products);
}

function renderProducts(products) {
  for (const prd of products) {
    productsContainer.innerHTML += `
        <div class="box">
            <img style="max-width:100px;max-height: 100px;min-width:100px;min-height: 100px" src="assets/images/products/${prd.image_url}" alt="${prd.name}" />
            <h3>${prd.name}</h3>
            <div class="price">${prd.Price} E£ </div>
            <a href="./html/user_make_order.html" class="btn">Make order</a>
        </div>
        `;
  }
}
init();
