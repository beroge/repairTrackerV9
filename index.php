<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Document</title>
  <link rel="stylesheet" href="style.css" />
  <script src="https://code.jquery.com/jquery-3.7.1.slim.min.js" integrity="sha256-kmHvs0B+OpCW5GVHUNjv9rOmY0IvSIRcf7zGUDTDQM8=" crossorigin="anonymous"></script>
  <script src="script.js"></script>
</head>

<body>
  <div class="login">
    <div class="login-header">
      <img src="pcnm.png" />
    </div>
    <form class="login-form" name="loginbox" action="" method="post">
      <div class="wrapper">
        <button class="learn-more" name="repair">
          <span class="circle" aria-hidden="true">
            <span class="icon arrow"></span>
          </span>
          <span class="push button-text">Repair Tracker</span>
        </button>
        <button class="learn-more" name="time">
          <span class="circle" aria-hidden="true">
            <span class="icon arrow"></span>
          </span>
          <span class="button-text">Time Clock</span>
        </button>
      </div>
      <br />

      <input type="text" name="name" placeholder="Username" /><br />
      <input type="password" name="password" placeholder="Password" />
      <br />
      <input type="hidden" name="RURI" value="<?php echo $ruri; ?>" />
      <input type="hidden" name="METHOD" value="<?php echo $method; ?>" /><br />
      <button class="learn-more">
        <span class="circle" aria-hidden="true">
          <span class="icon arrow"></span>
        </span>
        <span class="button-text">Submit</span>
      </button>
    </form>
  </div>
</body>

</html>
