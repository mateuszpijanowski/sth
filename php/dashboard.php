<?php

    session_start();

    // LOGIN SESSION TEST
    if (!isset($_SESSION['login_on']))
    {
        header('Location: /');
        exit();
    }

?>

<!DOCTYPE HTML>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<title>STH - Terminal</title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
	<link rel="Shortcut icon" href="/img/HaaCk_StH.png" />
    <link rel="stylesheet" href="terminal.css" type="text/css" />
    <script src="../js/jquery-1.7.1.min.js"></script>
    <script src="../js/jquery.terminal.min.js"></script>
  </head>
<body>

<div id="console"></div>
<div id="upload_div"><form method="post" ><input id="file" type="file" name="file_upload" ><button id="upload">Upload</button></form></div>

    <script type="text/javascript">

        // MAIN TERMINAL CONTENT SCRIPT
    	var Typer={
        // LIST OF TEXT
    	text: null,
    	text2: null,
    	accessCountimer:null,
    	index:0, // current cursor position
    	speed:4, // speed of the Typer
        // LIST OF FILES
    	file:"", //file, must be setted
    	file2:"", //file, must be setted
    	accessCount:0, //times alt is pressed for Access Granted
    	deniedCount:0, //times caps is pressed for Access Denied
    	init: function(){// inizialize Hacker Typer
            // TEXT1
    		accessCountimer=setInterval(function(){Typer.updLstChr();},500); // inizialize timer for blinking cursor
    		$.get(Typer.file,function(data){// get the text file
    			Typer.text=data;// save the textfile in Typer.text
    			Typer.text = Typer.text.slice(0, Typer.text.length-1);
    		});
            // TESXT2
            accessCountimer=setInterval(function(){Typer.updLstChr();},500); // inizialize timer for blinking cursor
            $.get(Typer.file2,function(data){// get the text file
                Typer.text2=data;// save the textfile in Typer.text
                Typer.text2 = Typer.text2.slice(0, Typer.text2.length-1);
            });
    	},

    	content:function(){
    		return $("#console").html();// get console content
    	},

    	write:function(str){// append to console content
    		$("#console").append(str);
    		return false;
    	},

    	addText:function(key)
    	{
    			var cont=Typer.content(); // get the console content
    			$("#console").html($("#console").html().substring(0,cont.length-1)); // remove it before adding the text
    			Typer.index+=Typer.speed;	// add to the index the speed
    			var text=Typer.text.substring(0,Typer.index)// parse the text for stripping html enities
    			var rtn= new RegExp("\n", "g"); // newline regex

    			$("#console").html(text.replace(rtn,"<br/>"));// replace newline chars with br, tabs with 4 space and blanks with an html blank
    			window.scrollBy(0,50); // scroll to make sure bottom is always visible
    	},

    	updLstChr:function(){ // blinking cursor
    		var cont=this.content(); // get console
    	}
    }

    Typer.speed=3;
    // FILES PATH
    Typer.file="bashrc.php";
    Typer.file2="userls.php";
    Typer.init();

    var timer = setInterval("t();", 30);
    function t() {
    	Typer.addText({"keyCode": 123748});
    }

    // TERMINAL SCRIPT
    jQuery(document).ready(function($) {
        var id = 1;
        // MAIN SHELL
        $('body').terminal(function(command, term) {

            // COMMAND - HELP
            if (command == 'help')
            {
                term.echo("[[b;lightgray;]Available commands are:]");
                term.echo("logout,");
                term.echo("pwd,");
                term.echo("url,");
                term.echo("ls,");
                term.echo("open [file_name],");
                term.echo("ping,");
                term.echo("userls,");
                term.echo("useradd [nick],");
                term.echo("userdel [nick],");
                term.echo("passwd [nick],");
                term.echo("rename [old_file_name],");
                term.echo("delete [file_name],");
                term.echo("read [file_name],");
                term.echo("touch [new_file_name],");
                term.echo("write [file_name],");
                term.echo("upload,");
                term.echo("reboot");
            }

            // COMMAND - LOGOUT
            else if (command == 'logout')
            {
                term.echo("Logout...");
                location.href="logout.php";
            }

            // COMMAND - PWD
            else if (command == "pwd")
            {
                term.echo('/files');
            }

            // COMMAND - URL
            else if (command == "url")
            {
                term.echo(location.href);
            }

            // COMMAND - LS
            else if (command == "ls")
            {
                <?php
                    $files = scandir('../files'); // CATALOG PATH
                    $echo_ls = "";
                    // LOOP OF CATALOG CONTENT
                    foreach($files as $ls)
                    {
                        $echo_ls = $echo_ls.'term.echo("'.$ls.' "); ';
                    }
                    // LS FILTER - REMOVED PHP SCRIPT
                    $filter1 = str_replace('term.echo("delete.php ");', "", $echo_ls);
                    $filter2 = str_replace('term.echo("read.php ");', "", $filter1);
                    $filter3 = str_replace('term.echo("rename.php ");', "", $filter2);
                    $filter4 = str_replace('term.echo("touch.php ");', "", $filter3);
                    $filter5 = str_replace('term.echo("upload.php ");', "", $filter4);
                    $filter6 = str_replace('term.echo("write.php ");', "", $filter5);
                    $filter7 = str_replace('term.echo(". ");', "", $filter6);
                    $filter8 = str_replace('term.echo(".. ");', "", $filter7);
                    $filter9 = str_replace('term.echo("index.php ");', "", $filter8);
                    $filter10 = str_replace('term.echo("upload.php ");', "", $filter9);

                    // LS OUTPUT
                    echo $filter9;
                ?>
            }

            // COMMAND - REBOOT/RESTART
            else if (command == "reboot")
            {
                term.echo("Reboot...");
                location.reload();
            }

            // COMMAND - OPEN
            else if (/open*/.test(command))
            {
                window.open("http://sthgroup.000webhostapp.com/files/"+command.substr(5)); // NEW WINDOW OPEN
                term.echo('[[b;lightblue;]File "'+command.substr(5)+'" was open in new window!]');
            }

            // COMMAND - PING
            else if (command == "ping")
            {
                // AJAX CONNECT TEST
                $.ajax({
                      url: '',
                      type: 'HEAD',
                      success: function(result){
                         term.echo('[[b;lightblue;]You have connect!]');
                      },
                      error: function(result){
                          term.echo('[[b;red;]timeout/error!]');
                      }
                   });
            }

            // COMMAND - USERADD
            else if (/useradd*/.test(command))
            {
                let user = command.substr(8); // USER NICK

                if (3<=user.length && user.length<=20 && /^[\w ]+$/.test(user)) // USER NICK TEST
                {
                    // USERADD SHELL
                    term.push(function(command, term) {
                        if (/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%\^&*_])/.test(command)) // USER PASS TEST
                        {
                            // XMLHTTP REQUEST
                            var xmlhttp = new XMLHttpRequest();
                            xmlhttp.open("POST", "useradd.php?user="+user+"&pass="+command, true);
                            xmlhttp.send();
                            term.echo('[[b;lightblue;]User "'+user+'" add!]');
                            location.reload();
                        }
                        else // BAD PASSWORD
                        {
                            term.echo('[[b;red;]ERROR, password must have large and small letter, number and special character!]');
                        }
                    }, {
                    prompt: '[[b;red;]Password: ]',
                    name: ''});
                }
                else // BAD USER NICK
                {
                    term.echo('[[b;red;]ERROR, login must have min 3 to max 20 word!]');
                }
            }

            // COMMAND - USERDEL
            else if (/userdel*/.test(command))
            {
                let nick = command.substr(8); // USER NICK
                // XMLHTTP REQUEST
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.open("POST", "userdel.php?nick="+nick, true);
                xmlhttp.send();
                term.echo('[[b;lightblue;]User "'+nick+'" has been removed!]');
            }

            // COMMAND - USERLS
            else if (command == "userls")
            {
                term.echo(Typer.text2);
            }

            // COMMAND - PASSWD
            else if (/passwd*/.test(command))
            {
                let nick = command.substr(7); // USER NICK
                // PASSWD FIRST SHELL
                term.push(function(command, term) {
                if (/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%\^&*_])/.test(command)) // USER NEW PASS TEST
                {
                    let pass1 = command; // USER NEW PASS
                    // SECEND PASSWD SHELL
                    term.push(function(command, term) {
                    if (pass1 == command) // PASS ARE SAME TEST
                    {
                        // XMLHTTP REQUEST
                        var xmlhttp = new XMLHttpRequest();
                        xmlhttp.open("POST", "passwd.php?nick="+nick+"&pass="+pass1, true);
                        xmlhttp.send();
                        term.echo('[[b;lightblue;]Password has been change!]');
                        location.reload();
                    }
                    else // PASS AREN'T THE SAME
                    {
                        term.echo("[[b;red;]ERROR, passwords aren't the same!]");
                    }
                    }, {
                        prompt: '[[b;red;]Repeat_Password: ]',
                        name: ''});
                }
                else // BAD PASS
                {
                    term.echo('[[b;red;]ERROR, password must have large and small letter, number and special character!]');
                }
            }, {
                prompt: '[[b;red;]New_Password: ]',
                name: ''});
            }

            // COMMAND - DELETE
            else if (/delete*/.test(command))
            {
                let file = command.substr(7); // FILE NAME
                // XMLHTTP REQUEST
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.open("POST", "/files/delete.php?file="+file, true);
                xmlhttp.send();
                term.echo('[[b;lightblue;]File "'+file+'" has been removed!]');
            }

            // COMMAND - RENAME
            else if (/rename*/.test(command))
            {
                let old_name = command.substr(7); // FILE NAME
                // RENAME SHELL
                term.push(function(command, term) {
                    if (3<=command.length && command.length<=20) // NEW FILE NAME TEST
                    {
                        // XMLHTTP REQUEST
                        var xmlhttp = new XMLHttpRequest();
                        xmlhttp.open("POST", "/files/rename.php?old_name="+old_name+"&new_name="+command, true);
                        xmlhttp.send();
                        term.echo('[[b;lightblue;]"'+old_name+'" rename!]');
                        location.reload();
                    }
                    else // BAD NEW FILE NAME
                    {
                        term.echo('[[b;red;]ERROR, file name must have min 3 to max 20 word!]');
                    }
                }, {
                prompt: '[[b;red;]New_name: ]',
                name: ''});
            }

            // COMMAND - DELETE
            else if (/delete*/.test(command))
            {
                let file = command.substr(7); // FILE NAME
                // XMLHTTP REQUEST
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.open("POST", "/files/delete.php?file="+file, true);
                xmlhttp.send();
                term.echo('[[b;lightblue;]File "'+file+'" has been removed!]');
            }

            // COMMAND - TOUCH
            else if (/touch*/.test(command))
            {
                let file_name = command.substr(6); // NEW FILE NAME
                // XMLHTTP REQUEST
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.open("POST", "/files/touch.php?file_name="+file_name, true);
                xmlhttp.send();
                term.echo('[[b;lightblue;]File "'+file_name+'" has been created!]');
            }

            // COMMAND - READ
            else if (/read*/.test(command))
            {
                let file_name = command.substr(5); // FILE NAME
                window.open("https://sthgroup.000webhostapp.com/files/read.php?file_name="+file_name); // SELECTED FILE OPEN
                term.echo('[[b;lightblue;]File "'+file_name+'" was open in new window!]');
            }

            //COMMAND - WRITE
            else if (/write*/.test(command))
            {
                let file_name = command.substr(6); // FILE NAME
                // WRITE SHELL
                term.push(function(command, term) {
                if (/^[\w ]+$/.test(command)) // NEW FILE CONTENT TEST
                {
                    // XMLHTTP REQUEST
                    var xmlhttp = new XMLHttpRequest();
                    xmlhttp.open("POST", "/files/write.php?file_name="+file_name+"&content="+command, true);
                    xmlhttp.send();
                    term.echo('[[b;lightblue;]File "'+file_name+'" has been edit!]');
                    location.reload();
                }
                else // BAD NEW CONTENT
                {
                    term.echo("[[b;red;]ERROR, content can't contain national characters!]");
                }
                }, {
                prompt: '[[b;red;]Content: ]',
                name: ''});
            }

            // COMMAND - UPLOAD
            else if (command == "upload")
            {
                $('#upload_div').css('display', 'block'); // DISPLAY UPLOAD FORM

                $('#upload').on('click', function() {
                    var file_data = $('#file').prop('files')[0];
                    var form_data = new FormData();
                    form_data.append('file', file_data);
                    $.ajax({
                        url: '/files/upload.php', // point to server-side PHP script
                        dataType: 'text',  // what to expect back from the PHP script, if anything
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: form_data,
                        type: 'post',
                     });
                });
            }

            // UNKNOWN COMMAND
            else
            {
                term.echo('Unknown command "'+command+'"');
            }
        }, {
            prompt: '[[b;lightgreen;]STH>] ',
            greetings: ""
        });
    });

</script>

<?php exit(); ?>

</body>
</html>
