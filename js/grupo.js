const form = document.querySelector(".typing-area"),
inputField = form.querySelector(".input-field"),
chatBox = document.querySelector(".chat-box"),
sendBtn = form.querySelector("button");

form.onsubmit = (e) =>{
	e.preventDefault(); 
}

sendBtn.onclick = ()=>{
    //let's start Ajax
	let xhr = new XMLHttpRequest(); 
	xhr.open("POST", "php/insert_grupo.php", true);
	xhr.onload = ()=>{
		if(xhr.readyState === XMLHttpRequest.DONE){
			if(xhr.status === 200){
                inputField.value = ""; 
			}
		}
	}
	
	let formData = new FormData(form); 
	xhr.send(formData); 
}

setInterval(()=>{
    //let's start Ajax
        let xhr = new XMLHttpRequest(); 
        xhr.open("POST", "php/get-grupo.php", true);
        xhr.onload = ()=>{
            if(xhr.readyState === XMLHttpRequest.DONE){
                if(xhr.status === 200){
                    let data = xhr.response;
                    //console.log(data);
                    chatBox.innerHTML = data;
                    scrolToBottom();

                }
            }
        }
       
	    let formData = new FormData(form);
	    xhr.send(formData); 
}, 500); 

function scrolToBottom(){
    chatBox.scrollTop = chatBox.scrollHeight;
}
