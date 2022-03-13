/* turn input type text to date type */
datePicker = document.querySelectorAll(".date-picker");
datePicker.forEach((element) => {
  element.addEventListener("focusin", function () {
    this.type = "date";
  });
}); /* end */
let dateFrom;
let dateTo;
/* filter button */
let filterBtn = document.querySelector(".filterbtn");
filterBtn.addEventListener("click", function () {
  dateFrom = document.getElementById("date-from").value;
  dateTo = document.getElementById("date-to").value;
  /**check if date from is less than date after !!!! */
  if (dateTo) {
    if (dateFrom > dateTo) {
      alert("date from must be less than date to");
      datePicker.forEach((el) => {
        el.value = "--/--/----";
      });
    }
  }
  console.log(dateFrom);
  console.log(dateTo);
}); /* end */

/* rendering order table */
async function renderOrders() {
  let userOrders = await getUserOrders();
  let orderTable = document.getElementById("orders-container");
  for (let order of userOrders) {
    orderTable.innerHTML += `<table class="table table-dark table-striped" id="table${order.id}">
                            <thead class="fs-2">
                              <tr>
                                <th scope="col">
                                  order id ${order.id} &emsp; <i class="fas fa-plus" onclick="clickToExpand(${order.id},this)"></i>
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
                                <td>${order.status == "processing" ? `<button class="btn btn-warning fs-4" onclick="cancelOrder(${order.id},this)">cancel</button>`: ""}</td>
                              </tr>
                            </tbody>
                          </table>
                          <div class="order-items hide" id="order${order.id}"></div>`;
  }
} /* end */

/**getting orders from DB */
async function getUserOrders() {
  let userOrders = await (
    await fetch("../php/controllers/getUserOrders.php?userId=" + 1)
  ).json();
  // console.log(userOrders);
  return userOrders;
}

renderOrders();
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
  // if (!dateFrom && !dateTo) {
  let orderItems1 = await getOrderItems(id);
  renderOrderItems(orderItems1, target);
  //   } else {
  //     /**call get order items with date */
  //     let orderItems2 = await getOrderItemsFilter(id);
  //     renderOrderItemsFilter(orderItems2, target);
  //   }
}
/* end */

/**render order items un filtered */
function renderOrderItems(orderItems1, target) {
  for (let item of orderItems1) {
    target.innerHTML += `<div class="item">
                        <div class="img-container">
                          <img src="../assets/images/test-images/img1.jpeg" alt="" />
                          <div class="item-price"> ${item.Price} </div>
                        </div>
                        <p>${item.name}</p>
                        <p>x ${item.quantity}</p>
                      </div>`;
  }
}

/**render order items filtered */
// function renderOrderItemsFilter(orderItems2, target) {
//   for (let item of orderItems2) {
//     target.innerHTML += `<div class="item">
//                         <div class="img-container">
//                           <img src="../assets/images/test-images/img1.jpeg" alt="" />
//                           <div class="item-price"> ${item.Price} </div>
//                         </div>
//                         <p>${item.name}</p>
//                         <p>x ${item.quantity}</p>
//                       </div>`;
//   }
// }

/**getting orders items from db */
async function getOrderItems(id) {
  let orderItems = await (await fetch("../php/controllers/getOrderItems.php?orderId=" + id)).json();
  // console.log(orderItems);
  return orderItems;
}

/**getting orders items from db */
// async function getOrderItemsFilter(id) {
//   let orderItems = await (
//     await fetch(
//       "../php/controllers/getOrderItemsFilter.php?orderId=" +
//         id +
//         "dateFrom=" +
//         dateFrom +
//         "dateTo=" +
//         dateTo
//     )
//   ).json();
//   // console.log(orderItems);
//   return orderItems;
// }



async function cancelOrder(id, button) {
  if(confirm("Are you sure you want to cancel this order")){
    let status = document.getElementById(`status${id}`);
    orderTable = document.getElementById(`table${id}`);
    orderDiv = document.getElementById(`order${id}`);
    
    status.innerText="canceling order ...";
    button.remove();
    
    // await
    let test = await deleteOrder(id);
    if(test)
    setTimeout(removeOrder,1200);
  }
}

function removeOrder(){
  orderTable.remove();
  orderDiv.remove();
}

async function deleteOrder(id){
  let test = await fetch("../php/controllers/cancelOrder.php?orderId=" + id);
  return test;
}
