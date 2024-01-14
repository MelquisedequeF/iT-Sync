

function get_element_info(op,arg1,arg2,arg3,element_)
 {
    if (op == "") {
        document.getElementById(element_).innerHTML = "";
        return;
    } else 
	{ 
        if (window.XMLHttpRequest) 
		{
            xmlhttp = new XMLHttpRequest();
        } else 
		{
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() 
		{
            if (this.readyState == 4 && this.status == 200) 
			{
                document.getElementById(element_).innerHTML = this.responseText;
				
            }
        };
        xmlhttp.open("GET","busca.php?op="+op+"&arg1="+arg1+"&arg2="+arg2+"&arg3="+arg3,true);
        xmlhttp.send();
    }
}
