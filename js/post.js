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
	
	if(text.value == "")
	{
		alert("Es wurde kein Text eingegeben!");
		text.style.borderColor = "red";
		return false;
	}	
	else
	{
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
}

function likeClick(id) {
	document.location.href = 'index.php?action=like&pid='+id;
}