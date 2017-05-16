/*	login.js
	Validierung der Anmeldedaten auf index.html und login.html
*/

function valid()
{
	var loginForm = document.forms['loginForm'];
	var validFlag = true;
	var errorString = "Folgende Felder sind nicht ausgefüllt:\n\n";
	
	if(loginForm.user.value == "")
	{
		loginForm.user.style.borderColor = "red";
		errorString = errorString + "Benutzername\n";
		validFlag = false;
	}
	else
	{
		loginForm.user.style.borderColor ="#009AB2";
	}
	
	if(loginForm.pass.value == "")
	{
		loginForm.pass.style.borderColor = "red";
		errorString = errorString + "Passwort\n";
		validFlag = false;
	}
	else
	{
		loginForm.pass.style.borderColor ="#009AB2";
	}
	
	if(validFlag)
	{
		return true;	
	}
	else
	{	
		alert(errorString);
		return false;
	}
}
