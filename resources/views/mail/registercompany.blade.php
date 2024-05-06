<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Welcome to Brainvire Info Tech!</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f4f4f4;
      margin: 0;
      padding: 0;
    }
    .container {
      max-width: 600px;
      margin: 0 auto;
      padding: 20px;
      background-color: #ffffff;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    .header {
      text-align: center;
      margin-bottom: 20px;
    }
    .content {
      text-align: center;
      margin-bottom: 20px;
    }
    .button {
      display: inline-block;
      padding: 10px 20px;
      background-color: #007bff;
      color: #ffffff;
      text-decoration: none;
      border-radius: 5px;
    }
    .social-icons {
      text-align: center;
      margin-top: 20px;
    }
    .social-icons a {
      display: inline-block;
      margin: 0 10px;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="header">
      <h1>Welcome to Brainvire Info Tech!</h1>
    </div>
    <div class="content">
      <p>Dear {{$maildata['name']}},</p>
      <p>We are delighted to welcome you as a new company registrant in our admin panel.</p>
      <p>Please proceed to your account:</p>
      <a href="#" class="button">Login to Admin Panel</a>
    </div>
    <div class="social-icons">
      <a href="https://facebook.com/" title="Facebook"><img src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/51/Facebook_f_logo_%282019%29.svg/1280px-Facebook_f_logo_%282019%29.svg.png" alt="Facebook" width="32"></a>
      <a href="https://linkedin.com/" title="LinkedIn"><img src="https://upload.wikimedia.org/wikipedia/commons/thumb/c/ca/LinkedIn_logo_initials.png/768px-LinkedIn_logo_initials.png" alt="LinkedIn" width="32"></a>
      <a href="https://instagram.com/" title="Instagram"><img src="https://upload.wikimedia.org/wikipedia/commons/thumb/a/a5/Instagram_icon.png/2048px-Instagram_icon.png" alt="Instagram" width="32"></a>
    </div>
  </div>
</body>
</html>
