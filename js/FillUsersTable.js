let UsersTableBody = document.getElementById("UsersTableBody");
let usersData;
// console.log("Hello");
(async function getUsersTotals() {
  let usersInfo = await fetch("../php/controllers/getUsers.php");
  usersData = await usersInfo.json();
  renderUsersTable(usersData);
  console.log(usersData);
})();
function renderUsersTable(usersData) {
  for (let userData of usersData) {
    UsersTableBody.innerHTML += `<tr>
        <td class='fs-5'> ${userData["finame"]} ${userData["lname"]}</td>
        <td class='fs-5'>${userData["email"]}</td>
        <td class='fs-5'><img src='${userData["image_url"]}' alt='' class='img-thumbnail img-fluid' style='display:block; width:70px; height:70px; margin: auto;'></td>
        <td class='fs-5'><a class='btn btn-warning' href='../php/EditUser.php?id=${userData["id"]}'> Update</a></td>
        <td class='fs-5'><a class='btn btn-danger' href='../php/DeleteUser.php?id=${userData["id"]}'> Delete</a></td></tr>`;
  }
}
let user = { id: null, name: null, role: null };
async function fillUser() {
  try {
    user = await (await fetch("../php/controllers/logged_in.php")).json();
  } catch {
    user = { id: null, name: null, role: null };
  }
  //   return user;
  console.log(user);
  if (user.role != "admin") {
    location.assign("http://localhost/Cafeteria-Project/index.html");
  }
}
// return user;
fillUser();

//  function getCurrentUser(){
//      return user;
//  }
// console.log( getCurrentUser() ) ;
