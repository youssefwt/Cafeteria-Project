let user = { id: null, name: null, role: null };
async function fillUser() {
  try {
    user = await (await fetch("../php/controllers/logged_in.php")).json();
  } catch {
    user = { id: null, name: null, role: null };
  }
  return user;
}
// console.log(user);
// return user;
fillUser();

function getCurrentUser() {
  return user;
}
