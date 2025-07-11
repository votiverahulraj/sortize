<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="utf-8">
   <title>Email</title>
   <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">
   <style>
      .button {
         /* padding: 55px 0 0; */
         padding: 5px !important;
      }

      .parag {
         margin: 0 0 8px 0;
         color: #FF00EE;
         text-align: center;
      }
   </style>
</head>
<body style="font-family: 'open Sans';font-size: 14px; line-height:20px;">
   <div style="max-width: 700px;margin: 0 auto;">
    <!-- Animated Button & Enhanced Layout -->
     <div style="max-width:700px;width:100%;padding:10px;margin:0 auto 30px;font-family:Arial, sans-serif;">
      <div style="background:#ffffff;padding: 20px 25px;border-radius:8px;box-shadow:0 0 10px rgba(0,0,0,0.05);border: solid 1px #FF00EE;">
        <div style="text-align:center">
         <a href="{{ url('/') }}" class="logo" style="display:inline-block;margin-bottom: 20px;">
            <img src="https://sortize.votivereact.in/public/admin_assets/images/Sortiz.png" alt="Sortiz Logo" style="width: 120px;">
         </a>
      </div>
      <div style="margin:0 auto 15px;max-width:400px;text-align:center;color:#FF00EE;">
         <h4 style="margin:0;font-size:19px;font-weight:600;">Hello, {{ucwords($first_name)}} {{ucwords($last_name)}}</h4>
      </div>
      <div style="text-align:center; color:#333;">
         <p style="font-size:16px;line-height:1.5;">Thank you for registering on <strong>Sortiz</strong>.</p>
         <p style="font-size:16px;line-height:1.5;">Please confirm your email address to activate your account.</p>
         <div style="margin: 20px 0;">
            <a href="{{ url('/api/changeStatus') }}?user_id={{ $user_id }}&full_url={{ $full_url }}" target="_blank"
               style="background-color:#FF00EE;border-radius:5px;color:#ffffff;display:inline-block;
                      font-size:16px;line-height:45px;text-align:center;text-decoration:none;
                      width:200px;transition: all 0.3s ease;box-shadow:0 4px 6px rgba(0,0,0,0.1);">
               Activate My Account
            </a>
         </div>
         <p style="font-size:14px;color:#126c62;margin-bottom: 0px;">
            <a href="{{ url('/') }}" style="color:#222;text-decoration:none;font-weight: 500;">If you didn’t create an account, you can ignore this email.</a>
         </p>
      </div>
   </div>
</div>

   </div>
</body>
</html>