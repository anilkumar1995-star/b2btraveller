<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Verification Code</title>
    <style type="text/css">
        @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;700&display=swap');
        
        body {
            font-family: 'Outfit', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background-color: #f8fafc;
            margin: 0;
            padding: 0;
            -webkit-font-smoothing: antialiased;
            width: 100% !important;
        }
        
        .wrapper {
            width: 100%;
            table-layout: fixed;
            background-color: #f8fafc;
            padding: 40px 0;
        }
        
        .container {
            max-width: 550px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(0,0,0,0.04);
        }
        
        .header {
            background-color: #059669;
            background: linear-gradient(135deg, #059669 0%, #0d9488 100%);
            padding: 50px 40px;
            text-align: center;
        }
        
        .logo {
            margin-bottom: 20px;
            font-size: 24px;
            font-weight: 800;
            color: #ffffff;
            letter-spacing: -0.5px;
            text-transform: uppercase;
        }
        
        .header h1 {
            color: #ffffff;
            margin: 0;
            font-size: 28px;
            font-weight: 700;
            letter-spacing: -0.5px;
        }
        
        .content {
            padding: 50px 40px;
            color: #1e293b;
            line-height: 1.7;
        }
        
        .greeting {
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 16px;
            color: #0f172a;
        }
        
        .text {
            font-size: 16px;
            color: #475569;
            margin-bottom: 30px;
        }
        
        .otp-wrapper {
            background-color: #f0fdf4;
            border: 2px solid #dcfce7;
            border-radius: 20px;
            padding: 35px;
            text-align: center;
            margin: 40px 0;
        }
        
        .otp-label {
            font-size: 13px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: #059669;
            margin-bottom: 16px;
        }
        
        .otp-code {
            font-size: 48px;
            font-weight: 800;
            color: #064e3b;
            letter-spacing: 10px;
            margin: 0;
        }
        
        .security-note {
            background-color: #fff7ed;
            border-left: 4px solid #f97316;
            padding: 16px 20px;
            border-radius: 8px;
            margin-top: 40px;
            font-size: 14px;
            color: #9a3412;
        }
        
        .footer {
            padding: 40px;
            background-color: #f8fafc;
            text-align: center;
            font-size: 14px;
            color: #94a3b8;
            border-top: 1px solid #f1f5f9;
        }
        
        .footer p {
            margin: 8px 0;
        }
        
        .company-name {
            font-weight: 700;
            color: #64748b;
        }

        @media only screen and (max-width: 600px) {
            .container {
                width: 95% !important;
                border-radius: 16px !important;
            }
            .content {
                padding: 40px 24px !important;
            }
            .otp-code {
                font-size: 36px !important;
                letter-spacing: 6px !important;
            }
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container">
            <div class="header">
                <div class="logo">
                    {{ $mydata['company']->companyname ?? 'B2B Traveller' }}
                </div>
                <h1>{{ $subhead ?? 'Verification Code' }}</h1>
            </div>
            
            <div class="content">
                <div class="greeting">Hello {{ $name ?? 'Partner' }},</div>
                <div class="text">
                    For your security, please use the following one-time password (OTP) to complete your authentication process.
                </div>
                
                <div class="otp-wrapper">
                    <div class="otp-code">{{ $otp }}</div>
                </div>
                
                <div class="security-note">
                    <strong>Security Notice:</strong> Please do not share this OTP with anyone.
                </div>


            </div>

            <div class="footer">
                <p>&copy; {{ date('Y') }} <span class="company-name">{{ $mydata['company']->companyname ?? 'B2B Traveller' }}</span>. All rights reserved.</p>
               
            </div>
        </div>
    </div>
</body>
</html>