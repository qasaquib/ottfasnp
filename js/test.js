function validateSubmit()
{
	if(true)
	{
		return true;
	}
	else
	{
		return false;
	}
}

function valInputs
{
	let err=0;
	var result;
	let fname=document.getElementsByName[0]("fname").value;
	let lname=document.getElementsByName[0]("lname").value;
	let gender=document.getElementsByName[0]("gender").value;
	let city=document.getElementsByName[0]("city").value;
	let email=document.getElementsByName[0]("email").value;
	let password_1=document.getElementsByName[0]("password_1").value;
	let password_2=document.getElementsByName[0]("password_2").value;
	var x=document.getElementsByClassName[5]('cy');
	if(password_1 != password_2)
	{
		x.innerHTML="Passwords do not match";
		err+=1;
	}
		var patt = /[a-zA-Z\.\'\-]/;
        result = patt.test(fname);
		if(!result)
		{
			x=document.getElementsByClassName[0]('cy');
			x.innerHTML="Invalid First Name";
			err+=1;
		}
		result = patt.test(lname);
		if(!result)
		{
			x=document.getElementsByClassName[1]('cy');
			x.innerHTML="Invalid Last Name";
			err+=1;
		}

}