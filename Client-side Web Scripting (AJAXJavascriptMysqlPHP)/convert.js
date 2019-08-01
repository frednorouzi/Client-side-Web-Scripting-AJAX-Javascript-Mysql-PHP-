window.onload = initall;

function initall()
{
  var f = parseInt(prompt('Please enter Fahrenheit Temperature ', ''));
  var c = Math.round((((f-32)/9)*5));


  if (isNaN(f))
     {
     window.location.reload()
     }
  else
     {
      alert(c + ' degrees Celsius');
      document.write('<a href="index.html">Home</a> <br><br>');
      document.write(f + ' degrees Fahrenheit converts to ' + c + ' degrees in Celsius <br>');
    }


}