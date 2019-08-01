window.onload = initAll;
function initAll()
  {
  document.getElementById('gen').onclick = generatedata;
  }
  function generatedata()
{
/* FINISH THE ARRAYS. Note: you want these two arrays to match in number of elements so if have 10 first names, 
you will also have 10 last names */
var firstnames = new Array("Jack", "Luke", "John", "Charlie", "Homer", "Darth");

var lastnames = new Array ("Samuel", "Right", "Jones", "Chen", "Jackson", "Ray");

/*generate a random number based on the number of items you have in the firstnames/lastnames array. Incidentally
if the first name array and the last name array don't have the same number of names in them, you need 2 random numbers. */

var namenum = Math.floor(Math.random() * firstnames.length);

/* set the fname and lname value to one of the choices in the arrays using the array name and the namenum you generated*/

document.getElementById('fname').value = firstnames[namenum];
document.getElementById('lname').value = lastnames[namenum];





/* generate a random number based on the 12 options you have in the month drop down menu*/
var monthnum = Math.floor(Math.random() * 12);


/* set the selectedIndex in the month field to the monthnum you generated*/
document.getElementById('month').selectedIndex = monthnum;








/* create an array of all the background color input tag elements using the class name. You can use a LOOP like 
we've been doing in class or you can use getElementsByName or getElementByClassName function.  */

var bklist = document.getElementsByClassName('bkcolor');

/* Now use the array bklist you just created and generate a random number based on the number of radio buttons in the background color field*/

var bknum = Math.floor(Math.random()*bklist.length);



/*set the bklist array to checked = true based on the random number you generated for it*/
bklist[bknum].checked = true;
}