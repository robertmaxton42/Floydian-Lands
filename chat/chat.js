/*
Code derived from tutorial at
https://css-tricks.com/jquery-php-chat/

*/

//Location of proccess.php
var processloc = "/robert/chat/process.php"; 

var TypeEnum = Object.freeze({CMD: 0, CHAT: 1});

var mes;
var file;

function Chat (type, logid) {
    this.update = updateChat;
    this.send = sendChat;
    this.chattype = type;
    this.logid = logid;
    this.state = 0;
    this.tout = false;
}

/*Updates the chat.
**Gets all new data from the server and appends it to the local chat log.*/
function updateChat(parent) {
    $.ajax({
        type: "POST",
        url: processloc,
        data: {
            'function': 'update', 
            'state': parent.state, 
            'type':  parent.chattype,
            'file': file
        },
        dataType: "json",
        success: function(data) {
            if(data.text){
                for (var i = 0; i < data.text.length; i++) {
                          $("#" + parent.logid).append($("<p class='chatlines'>"+ data.text[i] +"</p>")); //Workhorse: appends new lines.
                }
            }
            document.getElementById(parent.logid).scrollTop = document.getElementById(parent.logid).scrollHeight;
            parent.state = data.state;
        },
        timeout: 10000, // 10s timeout.
        error: function(jqXHR, textStatus, errorThrown) {
            if (textStatus == "timeout" && parent.tout == false) {
                $("#" + parent.logid).append($("<p class='chaterror'>Timeout.</p>")); //Timeout alert. Not yet tested.
            }
        }
    });
}

/*Sends messages.**POSTs the message to the server.*/
function sendChat(message, nickname) 
{
    obj = this;
    type = obj.chattype;
    id = obj.logid;
    updateChat(obj);
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
            updateChat(obj);
        },
    });
}