<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://code.jquery.com/jquery-3.7.1.slim.min.js"
        integrity="sha256-kmHvs0B+OpCW5GVHUNjv9rOmY0IvSIRcf7zGUDTDQM8=" crossorigin="anonymous"></script>
</head>
<body>
    <div class="login">
        <div class="login-header">
            <img src="pcnm.png" />
        </div>
        <form class="login-form" name="loginbox" action="" method="post" onsubmit="return setAction()">
            <div class="wrapper">
                <button class="learn-more" type="button" onclick="setAction('repair')">
                    <span class="circle" aria-hidden="true">
                        <span class="icon arrow"></span>
                    </span>
                    <span class="push button-text">Repair Tracker</span>
                </button>
                <button class="learn-more" type="button" onclick="setAction('time')">
                    <span class="circle" aria-hidden="true">
                        <span class="icon arrow"></span>
                    </span>
                    <span class="button-text">Time Clock</span>
                </button>
            </div>
            <br />

            <!-- Hidden input fields for values -->
            <input type="hidden" name="button" id="buttonValue" value="">
            <input type="text" name="name" id="nameInput" placeholder="Username" /><br />
            <input type="password" name="password" id="passwordInput" placeholder="Password" />
            <br />
            <input type="hidden" name="RURI" value="<?php echo $ruri; ?>" />
            <input type="hidden" name="METHOD" value="<?php echo $method; ?>" /><br />
            <button class="learn-more" type="submit" id="submitButton">
                <span class="circle" aria-hidden="true">
                    <span class="icon arrow"></span>
                </span>
                <span class="button-text">Submit</span>
            </button>
        </form>

        <script>
            function setAction(option) {
                var form = document.forms['loginbox'];
                var buttonValueInput = form.querySelector('#buttonValue');
                var nameInput = form.querySelector('#nameInput');
                var passwordInput = form.querySelector('#passwordInput');
                
                // Get the selected option based on the button clicked
                var selectedOption = option;
                
                buttonValueInput.value = selectedOption;

                // You can access the input values here if needed
                var username = nameInput.value;
                var password = passwordInput.value;

                if (selectedOption === 'repair') {
                    form.action = 'rt14/repair/login.php';
                } else if (selectedOption === 'time') {
                    form.action = 'rt14/timeclock/login.php';
                }

                return true; // Allow the form to submit
            }
        </script>
    </div>
</body>
</html>

