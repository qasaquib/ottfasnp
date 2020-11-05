let tot_mod=4;
let prev_tot=4;
let jsonObj;
let selectedObj;
let eventMatAdd = false;
let eventMatRem= false;
selectedObj={};
//window.alert(jQuery);
$(document).ready(function() {
   // alert("Helo");
    let chk = loadClientArray();
    $("#courseform").submit(function (event){
      /// Do some validation here
      if(1)
      {
        /// if validation true
        if(!$(".wk-select").hasAttribute("disabled"))
        {
        $(".wk-select").attr("disabled");
        $("#courseform").submit();
        event.preventDefault() 
        return false;
        }
        return true;
      }
      else
      {
        event.preventDefault();
        return false;
      }
    })
  });


function showWeekSlotsInit(x)
{
    var y = x;
    //window.alert("Printing Week Slots");
    while(y>0)
    {
    $("#course_assoc").after('<div class="form-group wk-div bg-primary p-1" id="wk'+y+'"><h5 id="wk'+y+'-div-h" onclick="expand_toggle(\'#wk'+y+'-div\')" class="bg-info p-1 text-no-select">Week&nbsp'+y+'<p id="wk'+y+'-div-p" class="disp-inline text-no-select">&nbsp+&nbsp</p> </h5><div id="wk'+y+'-div" class="disp-none"><label for="course_weeks" id="wk'+y+'selector-label">Select Video or Material</label><div class="form-group"><select name="wk'+y+'selector" id="wk'+y+'selector" class="form-control wk-select"></select></div><button class="btn btn-danger wk-select-btn" id="wk'+y+'-btn" type="button">Add To Week</button></div></div>');
    selectedObj["wk"+y+""]=[];
    y--;
    }
    popWkSelect();
    //alert("Hello");wda
    if(eventMatAdd == false)
    {
    eventMatAdd = false;
    $(".wk-select-btn").click( function (){
      //should alert id of select btn
      var x = $(this).attr("id");
      var buttonID=x;
      //alert(x);
      var y;
      var selid;
      x = x.slice(0,x.indexOf("-"));//gives week number now
      
      //y="#"+x+"-div-h";
      y="#"+x+"selector-label";
      selid="#"+x+"selector";
      var ptrValue=$("."+$(selid).val()).html();
      let ptr=$("."+$(selid).val());
      if(ptrValue === undefined)
      {
        window.alert("Selected Resource Added Previously");
      }
      else
      {
      var link="";
      let str;
      var subVal = $(selid).val();
      //var ptrOpt =$(selid).item($(selid).selectedIndex);
      //var subVal = ptrOpt.attributes.getNamedItem("value").value;
      if(subVal.indexOf("doc")>=0)
      {
        //alert("doc");
        //alert(subVal.indexOf("doc"));
        link="doc_viewer.php?doc_id=";
        str=subVal.slice(0,subVal.indexOf("doc"));
        link=link+str;
      }
      else if(subVal.indexOf("vod")>=0)
      {
        //alert("vod");
        str=subVal.slice(0,subVal.indexOf("vod"));
        for(i= 0; i < (Object.keys(jsonObj.vods).length) ; i++)
        {
          if(jsonObj.vods[i].id===str)
          {
            link=jsonObj.vods[i].vod_link;
          }
        }
      }
      else
      {
        //alert("else");
        link="#";
      }
     // alert(y);
      $(y).before('<div class="form-inline mb-1 mat-cont-'+x+'" id="'+subVal+'-div"><input type="text" name="'+x+'[]" id="'+subVal+'" class="disp-inline form-control" readonly value="'+subVal+'" hidden/><a class="p-link mr-1" href="'+link+'" target="_blank"><p class="p-2">'+ptrValue+'</p></a><button type="button" id="'+subVal+'up'+x+'" class="btn btn-sm btn-dark m-2"><i class="fas fa-arrow-up"></i></button><button type="button" id="'+subVal+'down'+x+'" class="btn btn-sm btn-dark m-2"><i class="fas fa-arrow-down"></i></button><button id="'+subVal+'close'+x+'" type="button" class="btn btn-sm btn-danger rem-mat disp-inline" >&times</button></div>');
      ptr.attr("disabled","");
      ptr.attr("hidden","");
      shiftOptions();
      let indx=""+x+"";
     selectedObj[indx].push(subVal);
     selectedObj[indx].forEach((z)=>{
     //alert(z);
    });
      $("#"+subVal+"close"+x).click(function(){
     // alert($(this).attr("id"));
      let delId=$(this).attr("id");
      let btnId="#"+delId;
      let matId=delId.slice(0,delId.lastIndexOf("close"));
      let wkno=delId.slice(delId.lastIndexOf("wk"));
     // alert(wkno);
      delId="#"+delId.slice(0,delId.lastIndexOf("close"))+"-div";
      $(delId).remove().off('click',btnId);
      let indx = selectedObj[wkno].indexOf(matId);
      let temp = selectedObj[wkno][indx];// temp stores the value removed from queue
      for (let j = indx ; j < (selectedObj[wkno].length-1) ; j++)
      {
       selectedObj[wkno][j]=selectedObj[wkno][j+1];
      }
      selectedObj[wkno].pop();// this value is not of that removed
      let ptr=$("."+temp);
      ptr.removeAttr("disabled").removeAttr("hidden");
      });
      // end of removal
      $('#'+subVal+"up"+x).click(function(){
        let workId = this.getAttribute("id");
        let btnId="#"+workId;
        let matId= workId.slice(0,workId.lastIndexOf("up"));
        let divId= matId+"-div";
        let wkno=workId.slice(workId.lastIndexOf("wk"));
        let wkId="#"+wkno;
        let indx = selectedObj[wkno].indexOf(matId);
        //alert(indx);
        if(indx===0)
        {
          //alert($(".mat-cont-"+wkno).length);
          $("#"+divId).insertAfter($(".mat-cont-"+wkno)[$(".mat-cont-"+wkno).length-1]);
          let temp = selectedObj[wkno][indx];
          for(let j = indx ; j<selectedObj[wkno].length-1 ; j++)
          {
            selectedObj[wkno][j]=selectedObj[wkno][j+1];
          }
          selectedObj[wkno][selectedObj[wkno].length-1]=temp;
        }
        else
        {
          $("#"+divId).prev().insertAfter("#"+divId);
          let temp = selectedObj[wkno][indx];
          selectedObj[wkno][indx]=selectedObj[wkno][indx-1];
          selectedObj[wkno][indx-1]=temp;
        }
      });
      //end of up
      $('#'+subVal+"down"+x).click(function()
      {
        let workId = this.getAttribute("id");
        let btnId="#"+workId;
        let matId= workId.slice(0,workId.lastIndexOf("down"));
        let divId= matId+"-div";
        let wkno=workId.slice(workId.lastIndexOf("wk"));
        let wkId="#"+wkno;
        let indx = selectedObj[wkno].indexOf(matId);
        //alert(indx);
        if(indx===($(".mat-cont-"+wkno).length-1))
        {
          //alert($(".mat-cont-"+wkno).length);
          let temp = selectedObj[wkno][indx];
          for(let j = indx ; j>=1 ; j--)
          {
            selectedObj[wkno][j]=selectedObj[wkno][j-1];
          }
          $("#"+divId).insertBefore($(".mat-cont-"+wkno)[0]);
          selectedObj[wkno][0]=temp;
        }
        else
        {
          if($("#"+divId).next().hasClass("mat-cont-"+wkno))
          {
          $("#"+divId).next().insertBefore("#"+divId);
          let temp = selectedObj[wkno][indx];
          selectedObj[wkno][indx]=selectedObj[wkno][indx+1];
          selectedObj[wkno][indx+1]=temp;
          }
        }
      });
      //end of down
    }//end of else
    });// Addition Event Handler
  }
}

function removePrev()
{
  var y=1;
  while(y<=prev_tot)
  {
    let txt="#wk"+y;
    $(txt).remove();
    y++;
  }
}

function regenerateSlots()
{
  removePrev();
  showWeekSlotsInit(tot_mod);
  //alert(tot_mod+","+prev_tot);
}

function expand_toggle(x)
{
 if($(x).hasClass("disp-none"))
 {
   $(x).removeClass("disp-none");
   $(x+"-p").text(" - ");

 }
 else
 {
   $(x).addClass("disp-none");
   $(x+"-p").text(" + ");
 }
}

function loadClientArray()
{
  //alert("Hello");
  let jqxhr= $.post( "assets.php",{ json_course: "ini" }, function( data ) {
    //$( "#client-result" ).html( data );
   // alert(data);
    jsonObj = JSON.parse(data);
    //alert(Object.keys(jsonObj.docs).length);
   //alert(jsonObj.vods[3].name);
  }).done(function (){
    showWeekSlotsInit(tot_mod);
    $("#course_weeks").change(function()
    {
    prev_tot=tot_mod;
    tot_mod=this.value;
   // alert(tot_mod);
    if(prev_tot!=tot_mod)
    {
      regenerateSlots();
    }
    });
    return true;
  }).fail(function(){
    return false;
  })
   return jqxhr;
}

function popWkSelect()
{
    let type="[Video]";
    var i;
    for(i= 0; i < (Object.keys(jsonObj.vods).length) ; i++)
    {
      $(".wk-select").append("<option class=\""+jsonObj.vods[i].id+"vod\" value=\""+jsonObj.vods[i].id+"vod\" >"+jsonObj.vods[i].name+" "+type+"</option>");
    }
    type="[Document]";
    for(i= 0; i < (Object.keys(jsonObj.docs).length) ; i++)
    {
      $(".wk-select").append("<option class=\""+jsonObj.docs[i].id+"doc\" value=\""+jsonObj.docs[i].id+"doc\" >"+jsonObj.docs[i].name+" "+type+"</option>");
    }
   //alert("outside popwk")

}

function shiftOptions()
{
  //$(".wk-select").removeAttr("selected");
  //let selectVar=$(".wk-select");
  let selectVar= document.getElementsByClassName("wk-select")
  for (x in selectVar){
    if(Number(x) <= Number(selectVar.length)-1)
    {
    if((selectVar[x].options.selectedIndex)+1 < selectVar[x].options.length){
    selectVar[x].options.selectedIndex= (selectVar[x].options.selectedIndex+1);
    }
    else{
     selectVar[x].options.selectedIndex = -1;
    }
   }
  } 
  }
 