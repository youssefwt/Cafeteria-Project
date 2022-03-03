let checksTableBody = document.getElementById("checksTableBody");

async function getUsersTotals() {
  let usersTotals = await (
    await fetch("../php/controllers/getUsersTotal.php")
  ).json();
  render(usersTotals);
}

function render(usersTotals) {
  for (let data of usersTotals) {
    checksTableBody.innerHTML += `
        <!--  user -->
        <tr data-bs-toggle="collapse" data-bs-target="#orders${data.user_id}">
        <td>
            <button onclick="renderOrders(${data.user_id})" class="btn">
            <span>+</span>
            </button>
        </td>
        <td>${data.finame}</td>
        <td>$${data.total}</td>
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
  let userOrders = await (
    await fetch("../php/controllers/getUserOrders.php?userId=" + userId)
  ).json();
  return userOrders;
}

async function renderOrderDetails(orderId) {
  console.log(orderId);
}

getUsersTotals();
