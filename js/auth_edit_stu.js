let dv=true;
function valInputs()
{
	let err=0;
	var result;
	let fname=document.getElementsByName("fname")[0].value;
	let lname=document.getElementsByName("lname")[0].value;
	let gender=document.getElementsByName("gender")[0].value;
	let city=document.getElementsByName("city")[0].value;
		var patt = /[a-zA-Z\.\'\-]/;
        result = patt.test(fname);
		x=document.getElementsByClassName('cy')[0];
		if(!result)
		{
			x.innerHTML="Invalid First Name";
			err+=1;
		}
		else
		{
			x.innerHTML="";
		}
		result = patt.test(lname);
		x=document.getElementsByClassName('cy')[1];
		if(!result)
		{
			x.innerHTML="Invalid Last Name";
			err+=1;
		}
		else
		{
			x.innerHTML="";
		}
		result = city.trim();
		x=document.getElementsByClassName('cy')[3];
		if(result=="")
		{
			x.innerHTML="Invalid City Name";
			err+=1;
		}
		else
		{
			x.innerHTML="";
		}
		x=document.getElementsByClassName('cy')[2];
	if(!(gender == "Male" || gender == "Female" || gender == "Others"))
	{
		x.innerHTML="Please make a selection";
		err+=1;
	}
	else
	{
	x.innerHTML="";
	}
		//window.alert(err);
		if(err>0 || dv == false)
			return false;
		else
			return true;
}
