/* turn input type text to date type */
datePicker = document.querySelectorAll(".date-picker");
datePicker.forEach((element) => {
  element.addEventListener("focusin", function () {
    this.type = "date";
  });
}); /* end */

let dateFrom = `1970-01-01`;
let dateTo = `2099-12-30`;
let mydate = /^[0-9]{4}-[0-9]{2}-[0-9]{2}?/;

/* filter button */
let filterBtn = document.querySelector(".filterbtn");
filterBtn.addEventListener("click", function () {
  inputFrom = document.getElementById("date-from").value;
  inputTo = document.getElementById("date-to").value;
  if (mydate.test(inputFrom)) dateFrom = inputFrom;
  if (mydate.test(inputTo)) dateTo = inputTo;
  /**check if date from is less than date after !!!! */
  if (dateTo) {
    if (dateFrom > dateTo) {
      alert("date from must be less than date to");
      datePicker.forEach((el) => {
        el.value = "";
        dateFrom = `1970-01-01`;
        dateTo = `2099-30-12`;
      });
    }
  }
  let orderTable = document.getElementById("orders-container");
  orderTable.innerHTML = "";
  renderOrders();
  console.log(dateFrom);
  console.log(dateTo);
}); /* end */

/** reset button */
let resetBtn = document.getElementById("resetbtn");
resetBtn.addEventListener("click", function () {
  datePicker.forEach((el) => {
    el.type = "text";
  });
  datePicker[0].value = "date from";
  datePicker[1].value = "date To";
});
/**end */

/* rendering order table */
async function renderOrders(user) {
  let userOrders = await getUserOrders(user);
  let orderTable = document.getElementById("orders-container");
  for (let order of userOrders) {
    orderTable.innerHTML += `<table class="table table-dark table-striped" id="table${
      order.id
    }">
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
                                <td  id="status${order.id}">${order.status}</td>
                                <td>${order.total}</td>
                                <td>${
                                  order.status == "processing"
                                    ? `<button class="btn btn-warning fs-4" onclick="cancelOrder(${order.id},this)">cancel</button>`
                                    : ""
                                }</td>
                              </tr>
                            </tbody>
                          </table>
                          <div class="order-items hide" id="order${
                            order.id
                          }"></div>`;
  }
} /* end */

/**getting orders from DB */
async function getUserOrders(user) {
  let userOrders = await (
    await fetch(
      `../php/controllers/getUserOrders.php?userId=${user.id}&start=${dateFrom}&end=${dateTo}`
    )
  ).json();
  // console.log(userOrders);
  return userOrders;
}

let user2 = { id: null, name: null, role: null };
async function fillUser2() {
  try {
    user2 = await (await fetch("../php/controllers/logged_in.php")).json();
  } catch {
    user2 = { id: null, name: null, role: null };
  }
  return user2;
}
// console.log(user);
// return user;

function getCurrentUser2() {
  return user2;
}

fillUser2().then((user) => {
  if (user.role == "user") {
    renderOrders(user);
  } else if (user.role == "admin") {
    location.assign("../php/admin_orders.php");
  } else {
    location.assign("../");
  }
});

/* end */

/* show or hide order items */
function clickToExpand(id, i) {
  /* switch + - icons */
  if (i.className == "fas fa-plus") i.className = "fas fa-minus";
  else i.className = "fas fa-plus";
  // console.log("icon clicked");

  /* accessing order-items div */
  target = document.getElementById(`order${id}`);
  // console.log(target);
  target.innerHTML = "";
  connectDataBase(target, id);
  target.classList.toggle("hide");
} /* end */

/* getting items from data base */
async function connectDataBase(target, id) {
  let orderItems1 = await getOrderItems(id);
  renderOrderItems(orderItems1, target);
}
/* end */

/**render order items un filtered */
function renderOrderItems(orderItems1, target) {
  for (let item of orderItems1) {
    target.innerHTML += `<div class="item">
                        <div class="img-container">
                          <img style="max-width:100px;max-height: 100px;min-width:100px;min-height: 100px"  src="../assets/images/products/${item.image_url}" alt="" />
                          <div class="item-price"> ${item.Price} E£</div>
                        </div>
                        <p>${item.name}</p>
                        <p>x ${item.quantity}</p>
                      </div>`;
  }
}

/**getting orders items from db */
async function getOrderItems(id) {
  let orderItems = await (
    await fetch("../php/controllers/getOrderItems.php?orderId=" + id)
  ).json();
  // console.log(orderItems);
  return orderItems;
}

async function cancelOrder(id, button) {
  if (confirm("Are you sure you want to cancel this order")) {
    let status = document.getElementById(`status${id}`);
    orderTable = document.getElementById(`table${id}`);
    orderDiv = document.getElementById(`order${id}`);

    status.innerText = "canceling order ...";
    button.remove();

    // await
    let test = await deleteOrder(id);
    if (test) setTimeout(removeOrder, 1200);
  }
}

function removeOrder() {
  orderTable.remove();
  orderDiv.remove();
}

async function deleteOrder(id) {
  await fetch("../php/controllers/cancelOrder.php?orderId=" + id);
  return true;
}
