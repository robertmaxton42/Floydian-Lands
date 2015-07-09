/*
Code derived from tutorial at
https://css-tricks.com/jquery-php-chat/
*/

var block = false;
var state;
var mes;
var file;

function Chat () {
    this.update = updateChat;
    this.send = sendChat;
    this.getState = getStateOfChat;
}

/*Gets the state of the chat.**Asks the server for the number of lines in the remote chat log.*/
function getStateOfChat() {
    if (!block) {
        block = true;
        $.ajax({
            type: "POST",
            url: "process.php",
            data: {  
                'function': 'getState', 
                'file': file
            },
            dataType: "json",
            
            success: function(data) {
                state = data.state; 
                block = false;
            },
        });
    }
}

/*Updates the chat.
**Gets all new data from the server and appends it to the local chat log.*/
function updateChat() {
    if (!block) {
        block = true;
        $.ajax({
            type: "POST",
            url: "process.php",
            data: {
                'function': 'update', 
                'state': state, 
                'file': file
            },
            dataType: "json",
            success: function(data) {
                if(data.text){
                    for (var i = 0; i < data.text.length; i++) {
                              $('#chat-area').append($("<p>"+ data.text[i] +"</p>")); //Workhorse: appends new lines with empty spaces between lines.
                    }
                }
                document.getElementById('chat-area').scrollTop = document.getElementById('chat-area').scrollHeight;
                block = false;
                state = data.state;
            },
        });
    }
    else {
        setTimeout(updateChat, 1500);// Run every 1.5s
    }
}

/*Sends messages.**POSTs the message to the server.*/
function sendChat(message, nickname) 
{
    updateChat();
    $.ajax({
        type: "POST",
        url: "process.php",
        data: {
            'function': 'send',
            'message': message, 
            'nickname': nickname, 
            'file': file
              },
        dataType: "json",
        success: function(data){
            updateChat();
        },
    });
}