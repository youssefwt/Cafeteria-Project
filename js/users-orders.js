let orders = [1, 1];
let item = ["nescafe", "tea", "sahlab", "lemon", "batee5"];
let quantity = [1, 3, 1, 2, 1];

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
});
/* end */

/* rendering order table */
let orderTable = document.getElementById("orders-container");
for (let i = 0; i < orders.length; i++) {
  orderTable.innerHTML += `<table class="table table-dark table-striped">
                            <thead class="fs-2">
                              <tr>
                                <th scope="col">
                                  order id 17 &emsp; <i class="fas fa-plus"></i>
                                </th>
                                <th scope="col" class="status">status</th>
                                <th scope="col">amount</th>
                                <th scope="col">action</th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr>
                                <td>made on &ensp; 2019/2/2 10:30 AM</td>
                                <td>out for delivery</td>
                                <td>55 egp</td>
                                <td> </td>
                              </tr>
                            </tbody>
                          </table>
                          <div class="order-items show"></div>`;
} /* end */

/* show or hide order items */
let toggleBtn = document.querySelectorAll("i");
toggleBtn.forEach((element) => {
  /* switch + - icons */
  element.addEventListener("click", function () {
    if (this.className == "fas fa-plus") this.className = "fas fa-minus";
    else this.className = "fas fa-plus";

    /* accessing order-items div */
    let target =
      this.parentElement.parentElement.parentElement.parentElement
        .nextElementSibling;
    console.log(target);
    target.innerHTML = "";
    renderOrderItems(target);
    target.classList.toggle("show");
  });
}); /* end */

/* rendering order items */
function renderOrderItems(target) {
  for (let i = 0; i < item.length; i++) {
    target.innerHTML += `<div class="item">
                          <div class="img-container">
                            <img src="../assets/images/test-images/img1.jpeg" alt="" />
                            <div class="item-price"> 20 LE </div>
                          </div>
                          <p>${item[i]}</p>
                          <p>x ${quantity[i]}</p>
                        </div>`;
  }
  target.innerHTML += `<div class="total"
                        <p>total</p>
                        <p>150 egp </p>
                      </div>`;
} /* end */

/* action button based on status */
let orderStatus = document.querySelectorAll(".order-status");
orderStatus.forEach((el) => {
  if (el.innerText == "Processing")
    el.nextElementSibling.nextElementSibling.innerHTML = `<button class="btn btn-warning fs-4">cancel</button>`;
}); /* end */
