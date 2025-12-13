<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Successful</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            overflow: hidden;
        }

        .container {
            text-align: center;
            background: white;
            padding: 60px 40px;
            border-radius: 20px;
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.2);
            max-width: 450px;
            width: 90%;
            position: relative;
            animation: slideUp 0.6s ease-out;
        }

        .success-icon {
            width: 100px;
            height: 100px;
            margin: 0 auto 30px;
            position: relative;
            animation: scaleIn 0.5s ease-out 0.2s both;
        }

        .circle {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: linear-gradient(135deg, #4ade80 0%, #22c55e 100%);
            position: relative;
            box-shadow: 0 10px 25px rgba(34, 197, 94, 0.3);
            animation: pulse 2s infinite ease-in-out 1s;
        }

        .checkmark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 45px;
            height: 35px;
            stroke-width: 4;
            stroke: white;
            fill: none;
            stroke-linecap: round;
            stroke-linejoin: round;
            animation: drawCheck 0.6s ease-out 0.5s both;
        }

        .checkmark path {
            stroke-dasharray: 50;
            stroke-dashoffset: 50;
            animation: checkmarkPath 0.4s ease-out 0.5s forwards;
        }

        h1 {
            color: #1f2937;
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 15px;
            animation: fadeIn 0.6s ease-out 0.6s both;
        }

        .message {
            color: #6b7280;
            font-size: 18px;
            line-height: 1.6;
            margin-bottom: 30px;
            animation: fadeIn 0.6s ease-out 0.7s both;
        }

        .details {
            background: #f9fafb;
            border-radius: 12px;
            padding: 20px;
            margin: 30px 0;
            animation: fadeIn 0.6s ease-out 0.8s both;
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            margin: 10px 0;
            font-size: 15px;
        }

        .detail-label {
            color: #6b7280;
        }

        .detail-value {
            color: #1f2937;
            font-weight: 600;
        }

        .button {
            display: inline-block;
            padding: 14px 32px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-decoration: none;
            border-radius: 50px;
            font-size: 16px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
            animation: fadeIn 0.6s ease-out 0.9s both;
            cursor: pointer;
            border: none;
        }

        .button:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 35px rgba(102, 126, 234, 0.4);
        }

        .button:active {
            transform: translateY(0);
        }

        .particles {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            pointer-events: none;
            overflow: hidden;
            border-radius: 20px;
        }

        .particle {
            position: absolute;
            width: 5px;
            height: 5px;
            background: #4ade80;
            border-radius: 50%;
            animation: float 3s infinite ease-in-out;
        }

        .particle:nth-child(1) { left: 10%; animation-delay: 0s; top: 20%; }
        .particle:nth-child(2) { left: 20%; animation-delay: 0.5s; top: 80%; }
        .particle:nth-child(3) { left: 60%; animation-delay: 1s; top: 10%; }
        .particle:nth-child(4) { left: 80%; animation-delay: 1.5s; top: 70%; }
        .particle:nth-child(5) { left: 90%; animation-delay: 2s; top: 30%; }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes scaleIn {
            from {
                opacity: 0;
                transform: scale(0.5);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        @keyframes drawCheck {
            from {
                opacity: 0;
                transform: translate(-50%, -50%) scale(0.8);
            }
            to {
                opacity: 1;
                transform: translate(-50%, -50%) scale(1);
            }
        }

        @keyframes checkmarkPath {
            to {
                stroke-dashoffset: 0;
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes pulse {
            0%, 100% {
                transform: scale(1);
                box-shadow: 0 10px 25px rgba(34, 197, 94, 0.3);
            }
            50% {
                transform: scale(1.05);
                box-shadow: 0 15px 35px rgba(34, 197, 94, 0.4);
            }
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0) translateX(0);
                opacity: 0;
            }
            10% {
                opacity: 1;
            }
            90% {
                opacity: 1;
            }
            100% {
                transform: translateY(-100px) translateX(100px);
                opacity: 0;
            }
        }

        @media (max-width: 480px) {
            .container {
                padding: 40px 30px;
            }
            
            h1 {
                font-size: 28px;
            }
            
            .message {
                font-size: 16px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="particles">
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
        </div>
        
        <div class="success-icon">
            <div class="circle">
                <svg class="checkmark" viewBox="0 0 52 52">
                    <path d="M14 27 L22 35 L38 16"></path>
                </svg>
            </div>
        </div>
        
        <h1>Payment Successful!</h1>
        
        <p class="message">
            Your payment has been processed successfully. Thank you for your purchase!
        </p>
        
        <button class="button" onclick="window.location.href='#'">Continue Shopping</button>
    </div>
</body>
</html>