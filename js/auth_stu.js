let dv=false;
function checkStr(id1,id2) {
  str=document.getElementsByName(id1)[0].value;
  if (str.length == 0) {
    document.getElementById(id2).innerHTML = "";
    return;
  } 
  else 
  {
    query="email_stu="+str;
	if(!ValidateEmail(str))
	{
		document.getElementById(id2).innerHTML = "Email may be invalid!";
		dv=true;
	}
	else
	{
		dv=true;
	}
    var xmlhttp;
    if (window.XMLHttpRequest) {
   xmlhttp = new XMLHttpRequest();
   }
   else {
   xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
   }
   xmlhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
     document.getElementById(id2).innerHTML = this.responseText;
	  var x=this.responseText;
	  if (x.includes('taken'))
	  {
		  dv=false;
	  }
     //window.alert(dv);
     }
    };
    console.log(this.readyState);
    console.log(this.status);
    xmlhttp.open("POST", "validate.php");
    xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xmlhttp.send(query);
  }
} 

function valInputs()
{
	let err=0;
	var result;
	let fname=document.getElementsByName("fname")[0].value;
	let lname=document.getElementsByName("lname")[0].value;
	let gender=document.getElementsByName("gender")[0].value;
	let city=document.getElementsByName("city")[0].value;
	let email=document.getElementsByName("email")[0].value;
	let password_1=document.getElementsByName("password_1")[0].value;
	let password_2=document.getElementsByName("password_2")[0].value;
	var x=document.getElementsByClassName('cy')[5];
	if(password_1 != password_2)
	{
		x.innerHTML="Passwords do not match";
		err+=1;
	}
	else
	{
	x.innerHTML="";
	}
    if(password_1 == "" || password_2 == "")
	{
		x.innerHTML="Either password field is empty";
		err+=1;
	}
	else
	{
	x.innerHTML="";
	}
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
		result = patt.test(city);
		x=document.getElementsByClassName('cy')[3];
		if(!result)
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

function ValidateEmail(mail) 
{
 if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(mail))
  {
    return (true);
  }
    //alert("You have entered an invalid email address!")
    return (false);
}