/**data for testing */
// let orders = [1, 1];
// let item = ["nescafe", "tea", "sahlab", "lemon", "batee5"];
// let quantity = [1, 3, 1, 2, 1];

/**getting user orders */

/* turn input type text to date type */
let datePicker = document.querySelectorAll(".date-picker");
datePicker.forEach((element) => {
  element.addEventListener("focusin", function () {
    this.type = "date";
  });
}); /* end */

/* get chosen date range */
/*TODO don't forget !!!! */
/* end */

/* filter button */
let filterBtn = document.querySelector(".filterbtn");
filterBtn.addEventListener("click", function () {
  console.log(dateFrom);
}); /* end */

/* rendering order table */
async function renderOrders() {
  let userOrders = await getUserOrders();
  let orderTable = document.getElementById("orders-container");
  for (let order of userOrders) {
    orderTable.innerHTML += `<table class="table table-dark table-striped">
                            <thead class="fs-2">
                              <tr>
                                <th scope="col">
                                  order id ${
                                    order.id
                                  } &emsp; <i class="fas fa-plus" onclick="clickToExpand(${
      order.id
    },this)"></i>
                                </th>
                                <th scope="col" >status</th>
                                <th scope="col">amount</th>
                                <th scope="col">action</th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr>
                                <td>made on &ensp; ${order.datetime}</td>
                                <td>${order.status}</td>
                                <td>${order.total}</td>
                                <td>${
                                  order.status == "processing"
                                    ? '<button class="btn btn-warning fs-4">cancel</button>'
                                    : ""
                                }</td>
                              </tr>
                            </tbody>
                          </table>
                          <div class="order-items show" id="order${
                            order.id
                          }"></div>`;
  }
} /* end */

/**getting orders from DB */
async function getUserOrders() {
  console.log("in get user orders");
  let userOrders = await (
    await fetch("../php/controllers/getUserOrders.php?userId=" + 1)
  ).json();
  console.log(userOrders);
  return userOrders;
}

renderOrders();
/* end */

/* show or hide order items */
function clickToExpand(id, i) {
  /* switch + - icons */
  if (i.className == "fas fa-plus") i.className = "fas fa-minus";
  else i.className = "fas fa-plus";
  console.log("icon clicked");

  /* accessing order-items div */
  target = document.getElementById(`order${id}`);
  console.log(target);
  target.innerHTML = "";
  renderOrderItems(target, id);
  target.classList.toggle("show");
} /* end */

/* rendering order items */
async function renderOrderItems(target, id) {
  let orderItems = await getOrderItems(id);
  for (let item of orderItems) {
    target.innerHTML += `<div class="item">
                          <div class="img-container">
                            <img src="../assets/images/test-images/img1.jpeg" alt="" />
                            <div class="item-price"> ${item.Price} </div>
                          </div>
                          <p>${item.name}</p>
                          <p>x ${item.quantity}</p>
                        </div>`;
  }
} /* end */

/**getting orders items from db */
async function getOrderItems(id) {
  console.log("in get user orders");
  let orderItems = await (
    await fetch("../php/controllers/getOrderItems.php?orderId=" + id)
  ).json();
  console.log(orderItems);
  return orderItems;
}
