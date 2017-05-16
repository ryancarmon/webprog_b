/*	register.js
	Validierung der Anmeldedaten auf register.html
*/

function valid()
{
	var registerForm = document.forms['registerForm'];
	var validFlag = true;
	var errorString = "Folgende Fehleingaben:\n\n";

	var regExEmail = new RegExp("^([a-zA-Z0-9_.-])+@(([a-zA-Z0-9-])+.)+([a-zA-Z0-9]{2,4})+$");

	if(registerForm.user.value == "")
	{
		registerForm.user.style.borderColor = "red";
		errorString = errorString + " -Kein Benutzername\n";
		validFlag = false;
	}
	else
	{
		registerForm.user.style.borderColor = "#009AB2";
	}
	
	if(registerForm.mail.value == "")
	{
		registerForm.mail.style.borderColor = "red";
		errorString = errorString + " -Keine Email\n";
		validFlag = false;
	}
	else
	{
		if(!regExEmail.test(registerForm.mail.value))
		{
			registerForm.mail.style.borderColor = "red";
			alert("Ungültige Email");
			validFlag = false;
		}
		else
		{
			registerForm.mail.style.borderColor = "#009AB2";
		}
	}
	
	if(registerForm.pass.value == "" || registerForm.pass_confirm.value == "")
	{
		registerForm.pass.style.borderColor = "red";
		registerForm.pass_confirm.style.borderColor = "red";
		
		errorString = errorString + " -Kein Passwort oder Passwort nicht bestätigt\n";
		
		registerForm.pass.value = "";
		registerForm.pass_confirm.value = "";
		
		validFlag = false;
	}
	else
	{
		if(!(registerForm.pass.value == registerForm.pass_confirm.value))
		{
			registerForm.pass.style.borderColor = "red";
			registerForm.pass_confirm.style.borderColor = "red";
			
			errorString = errorString + " -Passwörter sind nicht gleich\n";
			
			registerForm.pass.value = "";
			registerForm.pass_confirm.value = "";
		
			validFlag = false;
		}
		else
		{	
			if(registerForm.pass.value.length < 8)
			{
				registerForm.pass.style.borderColor = "red";
				registerForm.pass_confirm.style.borderColor = "red";
				
				errorString = errorString + " -Passwort zu schwach\n"
				
				registerForm.pass.value = "";
				registerForm.pass_confirm.value = "";
		
				validFlag = false;
			}
			else
			{
				registerForm.pass.style.borderColor = "#009AB2";
				registerForm.pass_confirm.style.borderColor = "#009AB2";
			}
		}
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
