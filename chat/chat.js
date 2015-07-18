/*
Code derived from tutorial at
https://css-tricks.com/jquery-php-chat/
*/

//Location of proccess.php
var processloc = "/robert/chat/process.php"; 

var TypeEnum = Object.freeze({CMD: 0, CHAT: 1});

var block = false;
var state;
var mes;
var file;

function Chat (type, logid) {
    this.update = updateChat;
    this.send = sendChat;
    this.getState = getStateOfChat;
    this.chattype = type;
    this.logid = logid;
}

/*Gets the state of the chat.**Asks the server for the number of lines in the remote chat log.*/
function getStateOfChat() {
    if (!block) {
        block = true;
        $.ajax({
            type: "POST",
            url: processloc,
            data: {  
                'function': 'getState', 
                'type': this.chattype,
                'file': file
            },
            dataType: "json",
            
            success: function(data) {
                state = data.state; 
                block = false;
            },
        });
    }
    //else alert("Blocking getState"); //Debug code
}

/*Updates the chat.
**Gets all new data from the server and appends it to the local chat log.*/
function updateChat(type) {
    id = this.logid;
    if (!block) {
        block = true;
        $.ajax({
            type: "POST",
            url: processloc,
            data: {
                'function': 'update', 
                'state': state, 
                'type': type,
                'file': file
            },
            dataType: "json",
            success: function(data) {
                if(data.text){
                    for (var i = 0; i < data.text.length; i++) {
                              $("#" + id).append($("<p class='chatlines'>"+ data.text[i] +"</p>")); //Workhorse: appends new lines.
                    }
                }
                document.getElementById(id).scrollTop = document.getElementById(id).scrollHeight;
                block = false;
                state = data.state;
            },
        });
    }
    else {
    //    alert("Blocking Update"); //Debug code
        setTimeout(updateChat(type), 1500);//If busy, run again in 1.5s   
    }
}

/*Sends messages.**POSTs the message to the server.*/
function sendChat(message, nickname) 
{
    type = this.chattype;
    updateChat(type);
    $.ajax({
        type: "POST",
        url: processloc,
        data: {
            'function': 'send',
            'message': message, 
            'nickname': nickname,
            'type': this.chattype,
            'file': file
              },
        dataType: "json",
        success: function(data){
            updateChat(type);
        },
    });
}