let filesizelimit = 2097152;

window.onload = function(){
    //window.alert("See on timm");
    //console.log(filesizelimit);
    document.getElementById("newssubmit").disabled = true;
    document.getElementById("photoinput").addEventListener("change", checkSize);
}

function checkSize(){
    if(document.getElementById("photoinput").files[0].size <= filesizelimit){
        document.getElementById("newssubmit").disabled = false;
        document.getElementById("notice").innerHTML = "";
    } else {
        document.getElementById("newssubmit").disabled = true;
        document.getElementById("notice").innerHTML = "Valitud fail on liiga suur!";
    }
} 
