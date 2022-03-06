let cards = document.getElementById("cards");
let cart = document.getElementById("cart");
let completeOrder = document.getElementById("complete_order");
completeOrder.addEventListener("click", function(){
    if(cart.children.length > 2){
        // let Some = {};
        let Some = [];
        let allDivs = cart.children;
        for (const div of allDivs) {
            if(div.dataset.value){
                // Some[div.children[0].innerHTML.split(":")[0]] = div.children[2].value;
                Some.push(div.children[0].innerHTML.split(":")[0]);
                Some.push(div.children[2].value);
            }
        }
        // Some["Total"] = parseInt(document.getElementById("Total").innerHTML.split(":")[1]);
        Some.push("Total")
        Some.push(parseInt(document.getElementById("Total").innerHTML.split(":")[1]));
        // let theQuery = JSON.stringify(Some);
        location.assign(`../php/order.php?order=${Some}`);
    }
})

async function get_products(){
    let products = await (await fetch("../php/controllers/products.php")).json();
    renderProducts(products);
}

function renderProducts(_products) {
    for (const product of _products) {
        cards.children[0].innerHTML += `
        <div class="col-3 my_card text-center p-4 m-2">
            <img class="my_card_image align-self-center" src="../items/${product.image_url}" alt="${product.name}" />
            <h3 class="my-2">${product.name}</h3>
            <div class="price fs-4 fs-1 my-1">${product.Price} EGP</div>
            <button class="p-3 button_of_adding">add to cart</button>
        </div>`;
    }
    registerButtons();
}

function registerButtons(){
    let buttons = document.getElementsByClassName("button_of_adding");
    for (let button of buttons) {
        button.addEventListener("click", addToCart);
        button.addEventListener("click", getTotal);
    }
}

function addToCart(e){
    let product_name= e.target.parentElement.children[1].innerHTML;
    for (const elementOrNullKey of cart.children) {
        if(elementOrNullKey.dataset.value == product_name){
            elementOrNullKey.children[2].value = 1 + parseInt(elementOrNullKey.children[2].value);
            elementOrNullKey.children[4].innerHTML = parseInt(elementOrNullKey.children[2].value) * parseInt(e.target.parentElement.children[2].innerHTML) + "  EGP";
            return;
        }
    }
    let theActualProduct = e.target;
    let theDiv = document.createElement("div");
    theDiv.classList.add("my-3");
    theDiv.classList.add("order");
    theDiv.classList.add("row");
    theDiv.dataset.value = product_name;
    let theLabel= document.createElement("label");
    theLabel.classList.add("col-3");
    theLabel.innerHTML = product_name+": ";
    theLabel.style.fontWeight = "Bold";
    let plus = document.createElement("button");
    plus.innerHTML = "+";
    plus.classList.add("plus_minus");
    plus.classList.add("col-1");
    plus.addEventListener("click", addOne)
    plus.addEventListener("click", function(e){
        e.target.parentElement.children[4].innerHTML = parseInt(e.target.nextSibling.value) *parseInt(theActualProduct.parentElement.children[2].innerHTML) + "  EGP";
    })
    plus.addEventListener("click", getTotal);
    let theInput = document.createElement("input");
    theInput.classList.add("text-center");
    theInput.value=1;
    theInput.disabled = true;
    theInput.type="number";
    let minus = document.createElement("button");
    minus.innerHTML = "-";
    minus.classList.add("plus_minus");
    minus.addEventListener("click", takeOne);
    minus.addEventListener("click",function(e){
        e.target.parentElement.children[4].innerHTML = parseInt(e.target.previousSibling.value) *parseInt(theActualProduct.parentElement.children[2].innerHTML) + "  EGP";
    })
    minus.addEventListener("click", getTotal);
    minus.classList.add("col-1");
    let price=document.createElement("label");
    price.innerHTML = parseInt(e.target.parentElement.children[2].innerHTML) + "  EGP";
    price.classList.add("price")
    price.classList.add("col-3")
    let _delete = document.createElement("button");
    _delete.innerHTML = "X";
    _delete.classList.add("col-1");
    _delete.addEventListener("click", function(e){
        cart.removeChild(e.target.parentElement);
    })
    _delete.addEventListener("click", getTotal);
    theDiv.append(theLabel, plus, theInput, minus, price, _delete);
    cart.append(theDiv);
}

function getTotal(){
    let sum = 0;
    let allDivs = cart.children;
    for (const div of allDivs) {
        if(div.dataset.value){
            sum += parseInt(div.children[4].innerHTML);
        }
    }
    document.getElementById("Total").innerHTML = "Total: "+ sum + "  EGP";
}

function addOne(e){
    e.target.nextSibling.value = 1 + parseInt(e.target.nextSibling.value);
}

function takeOne(e){
    if(e.target.previousSibling.value > 1)
        e.target.previousSibling.value = parseInt(e.target.previousSibling.value) - 1;
}

get_products();


