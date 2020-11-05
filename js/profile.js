$(document).ready(function()
{
    // Get the modal
    var modal = document.getElementById("myModal");
    // Get the button that opens the modal
    var btn = document.getElementById("sub-btn");

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close-btn")[0];

    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
        modal.style.display = "none";
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal) {
        modal.style.display = "none";
    }
    }   
    $("#sub-btn").click(function(){
        //window.alert(window.location.href);
        if($("#sub-btn").html()==="Subscribe")
        {
        let jqxhr= $.post( "subteach.php",{ sub : "ini" }, function( data ) {
            let result=data;
            if(data==="An error has occured!")
            {
                alert(data+" please try again!");
            }
            else if(data==="Success")
            {
                $("#sub-btn").html("Subscribed");
            }
            else
            {
                modal.style.display = "block";
            }
        });
        }
    });
    $("#offline-btn").click(function(){
        //window.alert(window.location.href);
        if($("#offline-btn").html()==="Request To Study Offline")
        {
        let subjectName=$("#subject").val();
        let jqxhr= $.post( "subteach.php",{ offline : "ini" , subject : subjectName }, function( data ) {
            let result=data;
            if(data==="An error has occured!")
            {
                alert(data+" please try again!");
            }
            else if(data==="Success")
            {
                $("#offline-btn").html("Requested Offline Study");
            }
            else
            {
                //alert(data);
                modal.style.display = "block";
            }
        });
        }
    });

});