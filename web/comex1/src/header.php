<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Network Diagnostic Tool</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #0f0c29 0%, #302b63 50%, #24243e 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #e0e0e0;
            padding: 20px;
        }

        .container {
            width: 100%;
            max-width: 800px;
            background: rgba(30, 30, 46, 0.95);
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
            overflow: hidden;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 30px;
            text-align: center;
        }

        .header h1 {
            font-size: 28px;
            font-weight: 700;
            color: #ffffff;
            margin-bottom: 8px;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
        }

        .header p {
            font-size: 14px;
            color: rgba(255, 255, 255, 0.9);
            font-weight: 300;
        }

        .content {
            padding: 40px;
        }

        .form-group {
            margin-bottom: 25px;
        }

        label {
            display: block;
            margin-bottom: 10px;
            font-weight: 500;
            color: #b8b8d1;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        input[type="text"] {
            width: 100%;
            padding: 15px 20px;
            background: rgba(45, 45, 68, 0.8);
            border: 2px solid rgba(102, 126, 234, 0.3);
            border-radius: 12px;
            color: #ffffff;
            font-size: 16px;
            font-family: 'Inter', monospace;
            transition: all 0.3s ease;
        }

        input[type="text"]:focus {
            outline: none;
            border-color: #667eea;
            background: rgba(45, 45, 68, 1);
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
        }

        input[type="text"]::placeholder {
            color: rgba(184, 184, 209, 0.5);
        }

        button {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 12px;
            color: #ffffff;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        }

        button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.6);
        }

        button:active {
            transform: translateY(0);
        }

        .output-section {
            margin-top: 30px;
            padding: 25px;
            background: rgba(20, 20, 31, 0.6);
            border-radius: 12px;
            border: 1px solid rgba(102, 126, 234, 0.2);
        }

        .output-header {
            font-weight: 600;
            color: #667eea;
            margin-bottom: 15px;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .output-content {
            background: rgba(10, 10, 15, 0.8);
            padding: 20px;
            border-radius: 8px;
            font-family: 'Courier New', monospace;
            font-size: 13px;
            line-height: 1.6;
            color: #a0a0c0;
            white-space: pre-wrap;
            word-wrap: break-word;
            border-left: 3px solid #667eea;
            max-height: 400px;
            overflow-y: auto;
        }

        .output-content::-webkit-scrollbar {
            width: 8px;
        }

        .output-content::-webkit-scrollbar-track {
            background: rgba(20, 20, 31, 0.5);
            border-radius: 4px;
        }

        .output-content::-webkit-scrollbar-thumb {
            background: #667eea;
            border-radius: 4px;
        }

        .info-box {
            background: rgba(102, 126, 234, 0.1);
            border-left: 4px solid #667eea;
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 25px;
            font-size: 14px;
            color: #b8b8d1;
            line-height: 1.6;
        }

        .info-box strong {
            color: #667eea;
        }

        @media (max-width: 600px) {
            .content {
                padding: 25px;
            }

            .header h1 {
                font-size: 24px;
            }

            input[type="text"], button {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🌐 Network Diagnostic Tool</h1>
            <p>Professional ICMP Echo Request Utility</p>
        </div>
        <div class="content">
