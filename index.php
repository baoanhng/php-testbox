<head>
	<meta charset="utf-8">
    <title>My Testbox</title>
	<style>
		body {
			background-color: rgb(229, 229, 229);
			font: 14px Arial;
		}

		textarea {
			border-radius: 4px;
			font: 14px Consolas;
		}

		textarea#rawphp {
		    width: 1000px;
		    height: 355px;
		}

		textarea#evalresult {
		    width: 600px;
		    height: 200px;
		}

		.container {
		    height: 390px;
		}

		.showlinesnumber {
		    display: inline-block;
		    background-color: #AAAAAA;
		    vertical-align: top;
		    width: 20px;
		    height: 350px;
		    overflow: hidden;
		    text-align: left;
		    line-height: 1.2;
		    font: 14px Consolas;
		    margin-top: 3px;
		}

		.formgroup {
		    display: inline-block;
		}

		.showlinesnumber #line {

		}
	</style>
</head>

<?php

$php = !empty($_POST['php']) ? $_POST['php'] : '';

?>

<input type="hidden" id="linecount">

&lt;?php<br>
<div class="container">
    <div class="showlinesnumber" id="linesnum">
        <div id="extendlines">
            <div id="line">1</div>
        </div>
    </div>

    <div class="formgroup">
        <form method="post">
            <textarea name="php" id="rawphp"><?php echo $php ?></textarea><br>
            <input type="submit" value="Submit" />
            <input type="button" value="Export" name="export" />
        </form>
    </div>
</div>

<script>
    var textarea = document.getElementById("rawphp");
    var extendlines = document.getElementById("extendlines");
    var linecount = document.getElementById("linecount");
    var html_line = "";

    /*console.log(textarea.scrollHeight);
    console.log("Offset: " + textarea.offsetHeight);
    textarea.addEventListener("scroll", function() {
        console.log(textarea.scrollHeight);
        console.log(textarea.scrollTop);
    });*/

    processLines();

    textarea.addEventListener("input", processLines);

    textarea.addEventListener("scroll", onScrollLines);

    function onScrollLines() {
        margin = textarea.scrollTop;

        extendlines.style.marginTop = "-" + margin + "px";
    }

    function processLines() {
        code = textarea.value;
        line = code.split(/\r|\r\n|\n/);
        //console.log(line.length);
        
        if (line.length == linecount.value)
        {
            return;
        }

        for (i = 1; i <= line.length; i++)
        {
            html_line = html_line + '<div id="line">' + i + '</div>';
        }
        //console.log(html_line);

        extendlines.innerHTML = html_line;
        linecount.value = line.length;
        html_line = "";
    }

	function enableTab(id) {
        var el = document.getElementById(id);
        el.onkeydown = function(e) {
            if (e.keyCode === 9) { // tab was pressed

                // get caret position/selection
                var val = this.value,
                    start = this.selectionStart,
                    end = this.selectionEnd;

                // set textarea value to: text before caret + tab + text after caret
                this.value = val.substring(0, start) + '\t' + val.substring(end);

                // put caret at right position again
                this.selectionStart = this.selectionEnd = start + 1;

                // prevent the focus lose
                return false;
            }
        };
    }

    // Enable the tab character onkeypress (onkeydown) inside textarea...
    // ... for a textarea that has an `id="my-textarea"`
    enableTab('rawphp');
</script>

Result<br>
<textarea name="result" id="evalresult"><?php eval($php) ?></textarea>