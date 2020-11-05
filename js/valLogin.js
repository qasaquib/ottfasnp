//alert("Hello");
function valField()
{
	
	var email=document.getElementsByName('email')[0].value;
	var pass=document.getElementsByName('password')[0].value;
	email=email.trim();
	if(email === "" || pass === "")
	{
		if(email === "")
			document.getElementsByClassName('cy')[0].innerHTML = "Email is a required field";
		else
			document.getElementsByClassName('cy')[1].innerHTML = "Password is a required field";
		return false;
	}
return true;
}