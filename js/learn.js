//alert("Hello");
var rtype="";
var apiSet=0;

// 3. This function creates an <iframe> (and YouTube player)
 //    after the API code downloads.
var player;
function onYouTubeIframeAPIReady() {
//alert("API LOADED");
player = new YT.Player('pv-frame', {
    events: {
      'onReady': onPlayerReady
    }
  });
}
// 4. The API will call this function when the video player is ready.
function onPlayerReady(event) {
 event.target.playVideo();
 //window.alert('Player Ready');
}   
// 5. The API calls this function when the player's state changes.
//    The function indicates that when playing a video (state=1),
//    the player should play for six seconds and then stop.

$(document).ready( function()
{
                // 2. This code loads the IFrame Player API code asynchronously.
    $(".bres-link").click(function(){
        let id=$(this).attr("id");
        //alert(id);
        if($("."+id+"-clink").attr("hidden"))
        {
            $("."+id+"-clink").removeAttr("hidden");
        }
        else
        {
            $("."+id+"-clink").attr('hidden',"");
            //alert("Hello");
        }
    })

    $(".res-link").click(function(){
        if($(this).hasClass("vod"))
        {
            let srcData=$(this).attr("href");
            $("#pv-frame").attr("src",srcData);
            rtype="vod";
            if($("#pv-frame").hasClass("vframe-doc"))
            {
                $("#pv-frame").removeClass("vframe-doc");
                $("#pv-frame").addClass("vframe-vod");
            }
            else{
                if(!$("#pv-frame").hasClass("vframe-vod"))
                {
                    $("#pv-frame").addClass("vframe-vod");
                }
            }
        }
        else if($(this).hasClass("doc"))
        {
            rtype="doc";
            if($("#pv-frame").hasClass("vframe-vod"))
            {
                $("#pv-frame").removeClass("vframe-vod");
                $("#pv-frame").addClass("vframe-doc");
            }
            else{
                if(!$("#pv-frame").hasClass("vframe-doc"))
                {
                    $("#pv-frame").addClass("vframe-doc");
                }
            }
        }
    })
    $("#pv-frame").on('load',function()
    {
        $(".cinfo").css({"display":"none"});
        //alert("IFRAME LOADED");
        if(rtype=="vod")
        {
            if(apiSet==0)
            {
                var tag = document.createElement('script');
                tag.src = "https://www.youtube.com/iframe_api";
                var firstScriptTag = document.getElementsByTagName('script')[0];
                firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
                apiSet=1;
            }
            else
            {
            onYouTubeIframeAPIReady();
            }
        }
        
    });
 
}
)