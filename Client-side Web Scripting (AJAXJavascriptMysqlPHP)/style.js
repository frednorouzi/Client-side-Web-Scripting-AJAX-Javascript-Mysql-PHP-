window.onload = initAll;

function initAll()
       {
        var num = Math.ceil(Math.random()*5);
        var mypic = "pic"+ num +".png";
	
	    if(num%2 == 0)
	      {
		  document.getElementById('mystyle').href = "style1.css";
	      }
	   else
	     {
		document.getElementById('mystyle').href = "style2.css";
	   	 }
	    document.getElementById('myimage').src = mypic;
      }
