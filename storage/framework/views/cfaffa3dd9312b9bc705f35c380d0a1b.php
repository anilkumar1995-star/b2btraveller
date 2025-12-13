<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Failed</title>
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

        .error-icon {
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
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            position: relative;
            box-shadow: 0 10px 25px rgba(239, 68, 68, 0.3);
            animation: shake 0.5s ease-in-out 0.8s;
        }

        .cross {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 50px;
            height: 50px;
        }

        .cross-line {
            stroke: white;
            stroke-width: 4;
            stroke-linecap: round;
            fill: none;
            animation: drawCross 0.4s ease-out 0.5s forwards;
        }

        .cross-line:first-child {
            stroke-dasharray: 50;
            stroke-dashoffset: 50;
        }

        .cross-line:last-child {
            stroke-dasharray: 50;
            stroke-dashoffset: -50;
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

        .error-details {
            background: #fef2f2;
            border: 1px solid #fecaca;
            border-radius: 12px;
            padding: 15px 20px;
            margin: 25px 0;
            animation: fadeIn 0.6s ease-out 0.8s both;
        }

        .error-text {
            color: #991b1b;
            font-size: 14px;
            line-height: 1.5;
        }

        .button-group {
            display: flex;
            gap: 15px;
            justify-content: center;
            flex-wrap: wrap;
            animation: fadeIn 0.6s ease-out 0.9s both;
        }

        .button {
            display: inline-block;
            padding: 14px 32px;
            text-decoration: none;
            border-radius: 50px;
            font-size: 16px;
            font-weight: 600;
            transition: all 0.3s ease;
            cursor: pointer;
            border: none;
        }

        .button-primary {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: white;
            box-shadow: 0 10px 25px rgba(239, 68, 68, 0.3);
        }

        .button-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 35px rgba(239, 68, 68, 0.4);
        }

        .button-secondary {
            background: #f3f4f6;
            color: #4b5563;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .button-secondary:hover {
            background: #e5e7eb;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
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
            background: #ef4444;
            border-radius: 50%;
            animation: float 3s infinite ease-in-out;
            opacity: 0.6;
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

        @keyframes drawCross {
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

        @keyframes shake {
            0%, 100% {
                transform: translateX(0);
            }
            10%, 30%, 50%, 70%, 90% {
                transform: translateX(-5px);
            }
            20%, 40%, 60%, 80% {
                transform: translateX(5px);
            }
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0) translateX(0);
                opacity: 0;
            }
            10% {
                opacity: 0.6;
            }
            90% {
                opacity: 0.6;
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

            .button-group {
                flex-direction: column;
                width: 100%;
            }

            .button {
                width: 100%;
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
        
        <div class="error-icon">
            <div class="circle">
                <svg class="cross" viewBox="0 0 52 52">
                    <line class="cross-line" x1="16" y1="16" x2="36" y2="36"></line>
                    <line class="cross-line" x1="36" y1="16" x2="16" y2="36"></line>
                </svg>
            </div>
        </div>
        
        <h1>Payment Failed</h1>
        
        <p class="message">
            We couldn't process your payment. Please try again or use a different payment method.
        </p>

        <div class="error-details">
            <p class="error-text">
                <strong>Error:</strong> Transaction declined by your bank. Please check your card details or contact your bank.
            </p>
        </div>
        
        <div class="button-group">
            <button class="button button-primary" onclick="window.location.href='#'">Back to Home Page</button>
            <button class="button button-secondary" onclick="window.location.href='#'">Cancel</button>
        </div>
    </div>
</body>
</html><?php /**PATH /home/incognic/login.ismartpay.in/resources/views/unlimitfailed.blade.php ENDPATH**/ ?>