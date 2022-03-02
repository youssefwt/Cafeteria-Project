let productsContainer = document.getElementById("productsContainer");
let products = [
  {
    id: 1,
    name: "Tasty And Healty",
    price: 15.12,
    image: "menu-1.png",
  },
  {
    id: 1,
    name: "Tasty And Healty",
    price: 15.12,
    image: "menu-1.png",
  },
  {
    id: 1,
    name: "Tasty And Healty",
    price: 15.12,
    image: "menu-1.png",
  },
  {
    id: 1,
    name: "Tasty And Healty",
    price: 15.12,
    image: "menu-1.png",
  },
];

async function init() {
  let products = await (await fetch("../php/controllers/products.php")).json();
  console.log(products);
  renderProducts(products);
}

function renderProducts(products) {
  for (const prd of products) {
    productsContainer.innerHTML += `
        <div class="box">
            <img src="assets/images/landing-page/${prd.image_url}" alt="${prd.name}" />
            <h3>${prd.name}</h3>
            <div class="price">${prd.Price} E£ </div>
            <a href="#" class="btn">add to cart</a>
        </div>
        `;
  }
}
init();
