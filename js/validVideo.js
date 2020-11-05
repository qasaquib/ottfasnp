//window.alert('Hello');
//console.log($());
var selected=0;
var arr=[];
function editPress(strng) {
	//window.alert("edited"+strng);
	var txt = strng;
	var ch = arr.indexOf(strng);
	if(ch === -1)
	{
	//window.alert(arr)
	//if(edit===0)
	//{
	$("td#"+strng+"name").html("<input id='"+strng+"nametext' type='text' value='"+$("td#"+strng+"name").html()+"'>");
	$("td#"+strng+"subject").html("<input id='"+strng+"subjecttext' type='text' value='"+$("td#"+strng+"subject").html()+"'>");
	//$("td#"+strng+"link").html("<input id='"+strng+"linktext' type='text' value='"+$("td#"+strng+"link").html()+"'>");
	$("button#"+strng+"").html("Done").addClass("btn-success").removeClass("btn-warning");
	//edit=1;
	arr.push(strng);	
    }
	else
	{
	var name = $("input#"+strng+"nametext").val();
	var subject = $("input#"+strng+"subjecttext").val();
	$("td#"+strng+"name").html($("input#"+strng+"nametext").val());
	$("td#"+strng+"subject").html($("input#"+strng+"subjecttext").val());
	//$("td#"+strng+"link").html($("input#"+strng+"linktext").val());
	$("button#"+strng+"").html("Edit").addClass("btn-warning").removeClass("btn-success");
	var pos =arr.indexOf(strng);
	//window.alert(name+subject);
	arr.splice(pos,1);
	$.post("assets.php",{vod_id:txt,vod_name:name,vod_subject:subject,type:'edit'},function(result){
	//var x =result;
	//window.alert(x);
	});
	//edit=0;		
	}
}


function delFunc(txt)
{
		//alert("Deleting....");
		$.post("assets.php",{vod_id:txt,type:'del'},function(result){
		var x =result;
		//window.alert(x);
		}).done(function(){
			if(x!="Unknown Error Has Occured")
			{
				$("tr#"+txt+"row").remove();
			}
			else
			{
				alert("Video Link Cannot Be Deleted, As it may be in use in one or more courses");
			}
		});
}



function deletePress(strng) {
	//window.alert("deleted"+strng+"");
	//var txt = strng;
	if(window.confirm("Are You Sure?"))
	{
		delFunc(strng);
	}
	else
	{
		window.alert("Video Link not Deleted");
	}
}

function selectAll()
{
	var source = document.getElementById('checkSel');
	//alert(source);
	var x=$( "input[name='rowsel']");
	if(source.checked===true)
	{
		selected=0;
		for(var i=0,n=x.length;i<n;i++) 
		{
		selected++;
    	x[i].checked = source.checked;
 		}
 		//window.alert("Checked");
	}
	else
	{
		selected=0;
		for(var i=0,n=x.length;i<n;i++) {
    	x[i].checked = source.checked;
 		}
 		//window.alert("Unchecked"+source.checked);
	}
}


function selectDelete()
{
	if(selected>0)
	{
		if(window.confirm("Are you sure? This cannot be undone."))
		{
			var x=$("input[name='rowsel']");
			for(var i=0,n=x.length;i<n;i++) 
			{
    	 		if(x[i].checked == true)
    	 		{
    	 		delFunc(x[i].value);
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

function setSelect(str)  
{
	var id=str+'rowsel';
	if(document.getElementById(id).checked)
	{
		selected=selected+1;
		//alert(selected);
	}
	else
	{
		if(selected>0)
		selected=selected-1;
	}
	//alert(selected+document.getElementById(id).value);
}

function nextpg(){
	let sorter=$("#vod_sorter").val();
	let narrower=$("#vod_narrower").val();
	let perpg=$("#vod_perpg").val();
	let orderer=$("#vod_orderer").val();
	$.post("assets.php",{"tabtype":"vod","sorter":sorter,"narrower":narrower,"perpg":perpg,"orderer":orderer,"nextpg":1},function(result){
		var x =result;
		$( "#vod-tab-cont" ).empty();
		$( "#vod-tab-cont" ).append(x);
		//window.alert(x);
		});
}

function prevpg(){
	let sorter=$("#vod_sorter").val();
	let narrower=$("#vod_narrower").val();
	let perpg=$("#vod_perpg").val();
	let orderer=$("#vod_orderer").val();
	$.post("assets.php",{"tabtype":"vod","sorter":sorter,"narrower":narrower,"perpg":perpg,"orderer":orderer,"prevpg":1},function(result){
		var x =result;
		$( "#vod-tab-cont" ).empty();
		$( "#vod-tab-cont" ).append(x);
		//window.alert(x);
		});
}

function pgbt(val){
	let sorter=$("#vod_sorter").val();
	let narrower=$("#vod_narrower").val();
	let perpg=$("#vod_perpg").val();
	let orderer=$("#vod_orderer").val();
	$.post("assets.php",{"tabtype":"vod","sorter":sorter,"narrower":narrower,"perpg":perpg,"orderer":orderer,"pgbt[]":val},function(result){
		var x =result;
		$( "#vod-tab-cont" ).empty();
		$( "#vod-tab-cont" ).append(x);
		//window.alert(x);
		});
}

function subVod(){
	let sorter=$("#vod_sorter").val();
	let narrower=$("#vod_narrower").val();
	let perpg=$("#vod_perpg").val();
	let orderer=$("#vod_orderer").val();
	$.post("assets.php",{"tabtype":"vod","sorter":sorter,"narrower":narrower,"perpg":perpg,"orderer":orderer,"custom_sub_vod":1},function(result){
		var x =result;
		$( "#vod-tab-cont" ).empty();
		$( "#vod-tab-cont" ).append(x);
		//window.alert(x);
		});
}

function nosubmit(event)
{
	event.preventDefault();
	//alert("Prevented")
	return false;
}
