let usr = { id: null, name: null, role: null };
async function fillUser() {
  try {
    usr = await (await fetch("../php/controllers/logged_in.php")).json();
  } catch {
    usr = { id: null, name: null, role: null };
  }
  return usr;
}
// console.log(usr);
// return usr;
fillUser();

function getCurrentUser() {
  return usr;
}
