//window.alert('Hello');
//console.log($());
var requests = new Object();
var batch = new Object();
requests.selected=0;
requests.arr=[];
requests.acceptPress = function acceptPress(strng) {
	//window.alert("accepted"+strng+"");
	//var txt = strng;
	if(window.confirm("Are You Sure?"))
	{
		this.accFunc(strng);
	}
	else
	{
		window.alert("Request Not Accepted");
	}
}


requests.delFunc=function delFunc(txt)
{
		//alert("Deleting....");
		let mailID=$("#"+txt+"mail").html();
		let nameText=$("#"+txt+"name").html();
		let subjectText=$("#"+txt+"subject").html();
		$.post("assets.php",{off_req_id:txt,type:'del',mail:mailID,name:nameText,subject:subjectText},function(result){
		var x =result;
		//window.alert(x);
		if(result!="Unknown Error Has Occured")
		{
			$("tr#"+txt+"row").remove();
			location.reload();
		}
		});
}

requests.delFuncNoReload=function delFuncNoReload(txt)
{
		//alert("Deleting....");
		let mailID=$("#"+txt+"mail").html();
		let nameText=$("#"+txt+"name").html();
		let subjectText=$("#"+txt+"subject").html();
		$.post("assets.php",{off_req_id:txt,type:'del',mail:mailID,name:nameText,subject:subjectText},function(result){
		var x =result;
		//window.alert(x);
		if(result!="Unknown Error Has Occured")
		{
			$("tr#"+txt+"row").remove();
			//location.reload();
		}
		});
}



requests.accFunc=function accFunc(txt)
{
		//alert("Accepting....");
		let mailID=$("#"+txt+"mail").html();
		let nameText=$("#"+txt+"name").html();
		let subjectText=$("#"+txt+"subject").html();
		//alert(txt);
		//alert(mailID);
		$.post("assets.php",{off_req_id:txt,type:'acc',mail:mailID,name:nameText,subject:subjectText},function(result){
		var x =result;
		//window.alert(x);
		if(result!="Unknown Error Has Occured")
		{
			$("tr#"+txt+"row").remove();
		}
		});

}


requests.deletePress=function deletePress(strng) {
	//window.alert("deleted"+strng+"");
	//var txt = strng;
	if(window.confirm("Are You Sure?"))
	{
		this.delFunc(strng);
	}
	else
	{
		window.alert("Request Not Declined");
	}
}

requests.selectAll=function selectAll()
{
	var source = document.getElementById('checkSel');
	//alert(source);
	var x=$( "input[name='rowsel']");
	if(source.checked===true)
	{
		this.selected=0;
		for(var i=0,n=x.length;i<n;i++) 
		{
		this.selected++;
    	x[i].checked = source.checked;
 		}
 		//window.alert("Checked");
	}
	else
	{
		this.selected=0;
		for(var i=0,n=x.length;i<n;i++) {
    	x[i].checked = source.checked;
 		}
 		//window.alert("Unchecked"+source.checked);
	}
}


requests.selectDelete=function selectDelete()
{
	if(this.selected>0)
	{
		if(window.confirm("Are you sure? This cannot be undone."))
		{
			var x=$("input[name='rowsel']");
			for(var i=0,n=x.length;i<n;i++) 
			{
    	 		if(x[i].checked == true)
    	 		{
    	 		this.delFuncNoReload(x[i].value);
    	 		//window.alert(x[i].value);
    	 		}
			 }
			 location.reload();
 		}
 		else
 			{
 			//window.alert("Video Links not Deleted");
 			return;
 			}
 	}
 	else
 	{
 	return;
 	}
 }

requests.selectAccept=function selectAccept()
{
	if(this.selected>0)
	{
		if(window.confirm("Are you sure? This cannot be undone."))
		{
			var x=$("input[name='rowsel']");
			for(var i=0,n=x.length;i<n;i++) 
			{
    	 		if(x[i].checked == true)
    	 		{
				 this.accFunc(x[i].value);
    	 		//window.alert(x[i].value);
    	 		}
 			}
 		}
 		else
 			{
 			//window.alert("Video Links not Deleted");
 			return;
 			}
 	}
 	else
 	{
 	return;
 	}
 }



requests.setSelect=function setSelect(str)  
{
	var id=str+'rowsel';
	if(document.getElementById(id).checked)
	{
		this.selected=this.selected+1;
		//alert(selected);
	}
	else
	{
		if(this.selected>0)
		this.selected=this.selected-1;
	}
	//alert(selected+document.getElementById(id).value);
}

requests.nextpg = function nextpg(){
	let sorter=$("#req_sorter").val();
	let narrower=$("#req_narrower").val();
	let perpg=$("#req_perpg").val();
	let orderer=$("#req_orderer").val();
	$.post("assets.php",{"tabtype":"req","sorter":sorter,"narrower":narrower,"perpg":perpg,"orderer":orderer,"nextpg":1},function(result){
		var x =result;
		$( "#req-tab-cont" ).empty();
		$( "#req-tab-cont" ).append(x);
		//window.alert(x);
		});
}

requests.prevpg = function prevpg(){
	let sorter=$("#req_sorter").val();
	let narrower=$("#req_narrower").val();
	let perpg=$("#req_perpg").val();
	let orderer=$("#req_orderer").val();
	$.post("assets.php",{"tabtype":"req","sorter":sorter,"narrower":narrower,"perpg":perpg,"orderer":orderer,"prevpg":1},function(result){
		var x =result;
		$( "#req-tab-cont" ).empty();
		$( "#req-tab-cont" ).append(x);
		//window.alert(x);
		});
}

requests.pgbt = function pgbt(val){
	let sorter=$("#req_sorter").val();
	let narrower=$("#req_narrower").val();
	let perpg=$("#req_perpg").val();
	let orderer=$("#req_orderer").val();
	$.post("assets.php",{"tabtype":"req","sorter":sorter,"narrower":narrower,"perpg":perpg,"orderer":orderer,"pgbt[]":val},function(result){
		var x =result;
		$( "#req-tab-cont" ).empty();
		$( "#req-tab-cont" ).append(x);
		//window.alert(x);
		});
}

requests.subReq = function subReq(){
	let sorter=$("#req_sorter").val();
	let narrower=$("#req_narrower").val();
	let perpg=$("#req_perpg").val();
	let orderer=$("#req_orderer").val();
	$.post("assets.php",{"tabtype":"req","sorter":sorter,"narrower":narrower,"perpg":perpg,"orderer":orderer,"custom_sub_req":1},function(result){
		var x =result;
		$( "#req-tab-cont" ).empty();
		$( "#req-tab-cont" ).append(x);
		//window.alert(x);
		});
}

batch.deletePress=function deletePress(strng) {
	//window.alert("deleted"+strng+"");
	//var txt = strng;
	if(window.confirm("Are You Sure?"))
	{
		this.delFunc(strng);
	}
	else
	{
		window.alert("Student details not removed");
	}
}

batch.delFunc=function delFunc(txt)
{
		//alert("Deleting....");
		let mailID=$("#"+txt+"mail").html();
		let nameText=$("#"+txt+"name").html();
		let subjectText=$("#"+txt+"subject").html();
		$.post("assets.php",{off_req_id:txt,type:'del_curr',mail:mailID,name:nameText,subject:subjectText},function(result){
		var x =result;
		//window.alert(x);
		if(result!="Unknown Error Has Occured")
		{
			$("tr#"+txt+"row").remove();
			location.reload();
		}
		});
}



function nosubmit(event)
{
	event.preventDefault();
	//alert("Prevented")
	return false;
}