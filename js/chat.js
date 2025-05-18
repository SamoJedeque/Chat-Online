const form = document.querySelector(".typing-area"),
inputField = form.querySelector(".input-field"),
chatBox = document.querySelector(".chat-box"),
sendBtn = form.querySelector("button");

form.onsubmit = (e) =>{
	e.preventDefault(); 
}

sendBtn.onclick = ()=>{
    //let's start Ajax
	let xhr = new XMLHttpRequest(); //criando um objecto XML
	xhr.open("POST", "php/insert-chat.php", true);
	xhr.onload = ()=>{
		if(xhr.readyState === XMLHttpRequest.DONE){
			if(xhr.status === 200){
                inputField.value = ""; //depois que inserir os dados na DB limpar o campo
			}
		}
	}
	//temos que enviar esses dados pelo ajax para php
	let formData = new FormData(form); //criando objecto formdata
	xhr.send(formData); // enviando esse objecto para o php
}

setInterval(()=>{
    //iniciando o Ajax
        let xhr = new XMLHttpRequest(); //creating a XML object
        xhr.open("POST", "php/get-chat.php", true);
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
        //temos que enviar esses dados pelo ajax para php
	    let formData = new FormData(form); 
	    xhr.send(formData); 
}, 500); // 500ms

function scrolToBottom(){
    chatBox.scrollTop = chatBox.scrollHeight;
}
