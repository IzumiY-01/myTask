require('./bootstrap');
$(function(){
    console.log("Hello Javascript!!");
});

function patternChange()
{
    
    var radio = document.getElementsByName('due_pattern')
    フォーム
    if(radio[0].checked) 
    {
        document.getElementById('due_pattern01').style.display = "";
        document.getElementById('due_pattern02').style.display = "none";
        document.getElementById('due_pattern03').style.display = "none";
        document.getElementById('due_pattern04').style.display = "none";
    }else if (radio[1].checked) 
    {   document.getElementById('due_pattern01').style.display = "none";
        document.getElementById('due_pattern02').style.display = "";
        document.getElementById('due_pattern03').style.display = "none";
        document.getElementById('due_pattern04').style.display = "none";
        
    }else if(radio[2].checked)
    {
        document.getElementById('due_pattern01').style.display = "none";
        document.getElementById('due_pattern02').style.display = "none";
        document.getElementById('due_pattern03').style.display = "";
        document.getElementById('due_pattern04').style.display = "none"; 
    }else if(radio[3].checked)
    {   document.getElementById('due_pattern01').style.display = "none";
        document.getElementById('due_pattern02').style.display = "none";
        document.getElementById('due_pattern03').style.display = "none";
        document.getElementById('due_pattern04').style.display = "";
        
    }
    
    window.addEventListener("load",patternChange());
