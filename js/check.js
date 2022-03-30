let checksTableBody = document.getElementById("checksTableBody");
let startDateInput = document.getElementById("startDate");
let endDateInput = document.getElementById("endDate");

async function getUsersTotals() {
  let start = startDateInput.value;
  let end = endDateInput.value;

  let usersTotals = await (
    await fetch(
      `./php/controllers/getUsersTotal.php?start=${start}&end=${end}`
    )
  ).json();
  render(usersTotals);
}

function filter() {
  getUsersTotals();
}

function render(usersTotals) {
  checksTableBody.innerHTML = "";
  for (let data of usersTotals) {
    checksTableBody.innerHTML += `
        <!--  user -->
        <tr data-bs-toggle="collapse" data-bs-target="#orders${data.user_id}" class="text-light">
        <td class="text-light">
            <button onclick="renderOrders(${data.user_id})" class="btn text-light">
            <span>+</span>
            </button>
        </td>
        <td class="text-light">${data.finame}</td>
        <td class="text-light">$${data.total}</td>
        </tr>

        <!-- order details -->
        <tr>
            <td colspan="12" class="hiddenRow">
                <div id="orders${data.user_id}" class="collapse">
                loading ...
                </div>
            </td>
         </tr>
      `;
  }
}

async function renderOrders(userId) {
  let userOrders = await getUserOrders(userId);
  let ordersContainer = document.getElementById(`orders${userId}`);
  console.log(userOrders);
  let ordersHTML = `
  <table class="table table-dark table-striped">
  <thead>
    <tr>
      <th></th>
      <th>Order Date</th>
      <th>Amount</th>
    </tr>
  </thead>
  <tbody>

  `;

  for (let data of userOrders) {
    ordersHTML += `
    <tr
    data-bs-toggle="collapse"
    data-bs-target="#order${data.id}"
    >
      <td>
        <button onclick="renderOrderDetails(${data.id})" class="btn">
          <span class="text-light" >+</span>
        </button>
      </td>
      <td>${data.datetime}</td>
      <td>$${data.total}</td>
    </tr>

    <tr>
      <td colspan="12" class="hiddenRow">
        <div id="order${data.id}" class="collapse">
          order loading ...s
        </div>
      </td>
    </tr>
    `;
  }
  ordersHTML += `
    </tbody>
    </table>
    `;

  ordersContainer.innerHTML = ordersHTML;
}

async function getUserOrders(userId) {
  let start = startDateInput.value;
  let end = endDateInput.value;

  let userOrders = await (
    await fetch(
      `./php/controllers/getUserOrders.php?userId=${userId}&start=${start}&end=${end}`
    )
  ).json();
  return userOrders;
}
async function renderOrderDetails(OrderId){
  let orderItems = await getOrderItems(OrderId);
  let itemsContainer = document.getElementById(`order${OrderId}`);
  let innerhtml = `<div class="d-flex justify-content-around my-3">`
  // itemsContainer.innerHTML = "<div class=\"d-flex justify-content-around my-3\">";
  for (let data of orderItems){
    console.log(data);

  innerhtml += `
        <div
          style="border: 1px solid white"
          class="text-center p-2 border-1"
        >
          <img  style="max-width:100px;max-height: 100px;min-width:100px;min-height: 100px"
            src="assets/images/products/${data.image_url}"
            alt=""
          />
          <div>price: $<span>${data.Price}</span></div>
          <div>quantity: <span>${data.quantity}</span></div>
        </div>
  `;
  }
  innerhtml += `</div>`;
  itemsContainer.innerHTML = innerhtml;
}

async function getOrderItems(orderId) {
  let orderItems = await (await fetch("./php/controllers/getOrderItems.php?orderId=" + orderId)).json();
  console.log(orderItems);
  return orderItems;
}

getUsersTotals();
