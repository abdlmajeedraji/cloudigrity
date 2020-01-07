function validate()
{
var email = document.forms["login"]["email"].value;
var password = document.forms["login"]["password"].value;
var text;
var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
//--------------- EMAIL VALIDATION----------------------
login-form
if(email=="")
{
	text="field is empty"
	document.getElementById("txt6").innerHTML = text;
	event.preventDefault();
}
else if(!mailformat.test(email) )
{
	text="enter a valid email"
	document.getElementById("txt6").innerHTML = text;
    event.preventDefault();
}
else{
	document.getElementById("txt6").innerHTML ="";
}
//----------------PASSWORD VALIDATION----------------------
if(password=="")
{
 text="field is empty"
 document.getElementById("txt7").innerHTML = text;
 event.preventDefault(); 
}
else if(password.length<5)
{
	text="enter a valid password"
	document.getElementById("txt7").innerHTML = text;
    event.preventDefault();
}
else{
	document.getElementById("txt7").innerHTML = "";
}
}

