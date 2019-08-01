window.onload = initAll;
function initAll()
  {
  document.getElementById('mylink').onclick = changeName;
  }
  function changeName() 
  {
  
var firstName = new Array("Sam", "Tomas", "Kevin", "Mary", "David", "eli");
var lastName = new Array("Jones", "Bronze", "Davidson", "li", "Brown");

var random1 = Math.floor((Math.random() * firstName.length));
var random2 = Math.floor((Math.random() * lastName.length));

document.getElementById('fname').value = firstName[random1];
document.getElementById('lname').value = lastName[random1];
   }