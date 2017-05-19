/*	post.js
	Zum öffnen des Modal und validieren des Posttextes
*/

function showModal()
{
	var modal = document.getElementById("postModal");
	modal.style.display = "block";
}

function closeModal() 
{	
	var modal = document.getElementById("postModal");

	modal.style.display = "none";
}

function postValid()
{
	var text = document.getElementById("postText");
	
	if(text.value.length > 180)
	{
		alert("Text ist zu lang.")
		text.style.borderColor = "red";
		return false;
	}
	else
	{
		return true;
	}
}

function charCount() // Bisschen verändern
{
	var text = document.getElementById("postText");
	var charCounter = document.getElementById("charCounter");
	
	charCounter.value = text.value;
}