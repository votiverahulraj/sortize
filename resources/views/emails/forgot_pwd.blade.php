<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="utf-8">
   <title>Forgot Password</title>
   <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">
   <style>
      .button {
         padding: 5px !important;
      }

      .parag {
         margin: 0 0 8px 0;
         color: #FF00EE;
         text-align: center;
      }
   </style>
</head>
<body style="font-family: 'Open Sans', sans-serif; font-size: 14px; line-height: 20px;">
   <div style="max-width: 700px; margin: 0 auto;">
      <div style="max-width: 700px; width: 100%; padding: 10px; margin: 0 auto 30px; font-family: Arial, sans-serif;">
         <div style="background: #ffffff; padding: 20px 25px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.05); border: solid 1px #FF00EE;">
            <div style="text-align: center;">
               <a href="{{ url('/') }}" class="logo" style="display: inline-block; margin-bottom: 20px;">
                  <img src="https://sortize.votivereact.in/public/admin_assets/images/Sortiz.png" alt="Sortiz Logo" style="width: 120px;">
               </a>
            </div>

            <div style="margin: 0 auto 15px; max-width: 400px; text-align: center; color: #FF00EE;">
               <h4 style="margin: 0; font-size: 19px; font-weight: 600;">Hello, {{ ucwords($first_name) }} {{ ucwords($last_name) }}</h4>
            </div>

            <div style="text-align: center; color: #333;">
               <p style="font-size: 16px; line-height: 1.5;">We received a request to reset your password for your <strong>Sortiz</strong> account.</p>
               <p style="font-size: 16px; line-height: 1.5;">Please use the following OTP to reset your password:</p>
               
               <div style="margin: 20px 0;">
                  <span style="display: inline-block; background-color: #FF00EE; color: #fff; padding: 12px 25px; font-size: 22px; letter-spacing: 4px; font-weight: bold; border-radius: 5px;">
                     {{ $otp }}
                  </span>
               </div>

               <!-- <p style="font-size: 14px; color: #666;">This OTP is valid for the next 10 minutes. Do not share it with anyone.</p> -->

               <p style="font-size: 14px; color: #FF00EE; margin-top: 30px;">
                  <a href="{{ url('/') }}" style="color: #222; text-decoration: none; font-weight: 500;">Didn’t request this? You can safely ignore this email.</a>
               </p>
            </div>
         </div>
      </div>
   </div>
</body>
</html>
