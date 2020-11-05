$(document).ready( function()
    {
        //alert('vote');
        $(".vote-up").click(
            function()
            {
                let id=$(this).attr("id");
                id=id.slice(0,id.indexOf("-up"));
                voteup(id);
                //alert(response);
            }
        );
        $(".vote-down").click(
            function()
            {
                let id=$(this).attr("id");
                id=id.slice(0,id.indexOf("-down"));
                votedown(id);
                //alert(response);
            }
        );

        $(".vote-best").click(
            function()
            {
                let id=$(this).attr("id");
                id=id.slice(0,id.indexOf("-best"));
                votebest(id);
                //alert(response);
            }
        );
    }
);
function voteup(id)
{
	var xmlhttp;
    if (window.XMLHttpRequest) {
	xmlhttp = new XMLHttpRequest();
	}
	else {
	xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
     //document.getElementById(id2).innerHTML = this.responseText;
       var response=this.responseText;
       //alert(response);
       if(response=="Success")
       {
       // alert(id);
        //alert($("#"+id+"-votes").html());
       // alert(document.getElementById(id+"-votes").innerHTML)
        $("#"+id+"-votes").html(String(Number($("#"+id+"-votes").html())+1));
       }
     }
    };
    //console.log(this.readyState);
    //console.log(this.status);
    xmlhttp.open("POST", "vote.php");
    xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xmlhttp.send("voteDif=1&id="+id);
}

function votedown(id)
{
	var xmlhttp;
    if (window.XMLHttpRequest) {
	xmlhttp = new XMLHttpRequest();
	}
	else {
	xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
     //document.getElementById(id2).innerHTML = this.responseText;
      var response=this.responseText;
      //alert(response);
      if(response=="Success")
      {
        //alert(id);
        //alert($("#"+id+"-votes").html());
        //alert(document.getElementById(id+"-votes").innerHTML)
        $("#"+id+"-votes").html(String(Number($("#"+id+"-votes").html())-1));
      }
     }
    };
    //console.log(this.readyState);
    //console.log(this.status);
    xmlhttp.open("POST", "vote.php");
    xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xmlhttp.send("voteDif=-1&id="+id);	
}

function votebest(id)
{
    let loc=window.location.href;
    loc=loc.substr(loc.indexOf("did=")+4);
	var xmlhttp;
    if (window.XMLHttpRequest) {
	xmlhttp = new XMLHttpRequest();
	}
	else {
	xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
     //document.getElementById(id2).innerHTML = this.responseText;
       var response=this.responseText;
       //alert(response);
       //alert(response);
       if(response=="Success")
       {
            $(".vote-best").removeClass("bg-dark");
            $(".vote-best").removeClass("bg-warning");
            $(".vote-best").addClass("bg-dark");
            $("#"+id+"-best").removeClass("bg-dark").removeClass("text-light");
            $("#"+id+"-best").addClass("bg-warning").addClass("text-dark");
        }
        else if(response=="Removed")
        {
            $("#"+id+"-best").removeClass("bg-warning").removeClass("text-dark");
            $("#"+id+"-best").addClass("bg-dark").addClass("text-light");
        }
        else
        {
            alert("An Error has occured, please contact support");
        }
    
        //alert($("#"+id+"-votes").html());
       // alert(document.getElementById(id+"-votes").innerHTML)
        //$("#"+id+"-votes").html(String(Number($("#"+id+"-votes").html())+1));
       }
    };
    //console.log(this.readyState);
    //console.log(this.status);
    xmlhttp.open("POST", "vote.php");
    xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xmlhttp.send("vote=best&id="+id+"&did="+loc);
}





function nextpg(){
	let sorter=$("#for_sorter").val();
	let narrower=$("#for_narrower").val();
	let perpg=$("#for_perpg").val();
	let orderer=$("#for_orderer").val();
	$.post("assets.php",{"tabtype":"for","sorter":sorter,"narrower":narrower,"perpg":perpg,"orderer":orderer,"nextpg":1},function(result){
		var x =result;
		$( "#for-tab-cont" ).empty();
		$( "#for-tab-cont" ).append(x);
		//window.alert(x);
		});
}

function prevpg(){
	let sorter=$("#for_sorter").val();
	let narrower=$("#for_narrower").val();
	let perpg=$("#for_perpg").val();
	let orderer=$("#for_orderer").val();
	$.post("assets.php",{"tabtype":"for","sorter":sorter,"narrower":narrower,"perpg":perpg,"orderer":orderer,"prevpg":1},function(result){
		var x =result;
		$( "#for-tab-cont" ).empty();
		$( "#for-tab-cont" ).append(x);
		//window.alert(x);
		});
}

function pgbt(val){
	let sorter=$("#for_sorter").val();
	let narrower=$("#for_narrower").val();
	let perpg=$("#for_perpg").val();
	let orderer=$("#for_orderer").val();
	$.post("assets.php",{"tabtype":"for","sorter":sorter,"narrower":narrower,"perpg":perpg,"orderer":orderer,"pgbt[]":val},function(result){
		var x =result;
		$( "#for-tab-cont" ).empty();
		$( "#for-tab-cont" ).append(x);
		//window.alert(x);
		});
}

function subFor(){
	let sorter=$("#for_sorter").val();
	let narrower=$("#for_narrower").val();
	let perpg=$("#for_perpg").val();
    let orderer=$("#for_orderer").val();
	$.post("assets.php",{"tabtype":"for","sorter":sorter,"narrower":narrower,"perpg":perpg,"orderer":orderer,"custom_sub_for":1},function(result){
		var x =result;
		$( "#for-tab-cont" ).empty();
		$( "#for-tab-cont" ).append(x);
		//window.alert(x);
		});
}

function nosubmit(event)
{
	event.preventDefault();
	alert("Prevented")
	return false;
}
