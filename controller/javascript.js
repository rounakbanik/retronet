function O(i) { return typeof i == 'object' ? i : document.getElementById(i) }
	function S(i) { return O(i).style                                            }
	function C(i) { return document.getElementsByClassName(i)                    }

	function checkUser(username)
	{
		if(username.value == '')
		{
			O('info1') = '';
			return;
		}

		params  = "username=" + username.value
      	request = new ajaxRequest()
      	request.open("POST", "controller/checkuser.php", true)
      	request.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
      	request.setRequestHeader("Content-length", params.length)
      	request.setRequestHeader("Connection", "close")

      	request.onreadystatechange = function()
      	{
        	if (this.readyState == 4)
          	if (this.status == 200)
            	if (this.responseText != null)
              	O('info1').innerHTML = this.responseText
      	}
      	request.send(params)
	}

	function checkEmail(email)
	{
		if(email.value == '')
		{
			O('info2') = '';
			return;
		}

		params  = "email=" + email.value
      	request = new ajaxRequest()
      	request.open("POST", "controller/checkemail.php", true)
      	request.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
      	request.setRequestHeader("Content-length", params.length)
      	request.setRequestHeader("Connection", "close")

      	request.onreadystatechange = function()
      	{
        	if (this.readyState == 4)
          	if (this.status == 200)
            	if (this.responseText != null)
              	O('info2').innerHTML = this.responseText
      	}
      	request.send(params)
	}

	function ajaxRequest()
    {
      	try { var request = new XMLHttpRequest() }
      	catch(e1) {
        	try { request = new ActiveXObject("Msxml2.XMLHTTP") }
        	catch(e2) {
          	try { request = new ActiveXObject("Microsoft.XMLHTTP") }
          	catch(e3) {
            	request = false
      	} } }
      	return request
    }