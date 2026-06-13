<?php
/**
 * Template Name: Cloud-1 Starting Page
 * Description: File-driven home screen for Project Cloud-1.
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cloud-1 | Welcome</title>
    <style>
        :root {
            --bg-color: #0b0f19;
            --card-bg: #131c2e;
            --accent-color: #38bdf8;
            --text-main: #f8fafc;
            --text-muted: #64748b;
            --border-color: rgba(56, 189, 248, 0.15);
        }

        body {
            margin: 0;
            padding: 0;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            background-color: var(--bg-color);
            color: var(--text-main);
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }

        .container {
            max-width: 650px;
            width: 100%;
            padding: 24px;
            text-align: center;
        }

        .badge {
            display: inline-block;
            background-color: rgba(56, 189, 248, 0.08);
            color: var(--accent-color);
            padding: 6px 14px;
            border-radius: 9999px;
            font-size: 0.8rem;
            font-weight: 700;
            letter-spacing: 0.05em;
            margin-bottom: 20px;
            border: 1px solid var(--border-color);
        }

        h1 {
            font-size: 2.75rem;
            font-weight: 800;
            margin: 0 0 16px 0;
            letter-spacing: -0.03em;
            background: linear-gradient(to right, #fff, #94a3b8);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        p.subtitle {
            font-size: 1.15rem;
            color: #94a3b8;
            line-height: 1.6;
            margin: 0 0 48px 0;
        }

        .creators-card {
            background-color: var(--card-bg);
            border-radius: 16px;
            padding: 28px;
            border: 1px solid rgba(255, 255, 255, 0.03);
            box-shadow: 0 20px 40px -15px rgba(0, 0, 0, 0.5);
        }

        .creators-card h2 {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.12em;
            color: var(--text-muted);
            margin: 0 0 20px 0;
            font-weight: 700;
        }

        .grid {
            display: flex;
            justify-content: space-around;
            align-items: center;
            gap: 16px;
        }

        .profile {
            flex: 1;
        }

        .name {
            font-size: 1.35rem;
            font-weight: 600;
            color: var(--text-main);
        }

        .role {
            font-size: 0.85rem;
            color: var(--accent-color);
            margin-top: 4px;
            font-weight: 500;
        }

        .vertical-line {
            width: 1px;
            height: 45px;
            background-color: rgba(255, 255, 255, 0.08);
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="badge">42 ADVANCED PROJECT</div>
        
        <h1>Cloud-1</h1>
        <p class="subtitle">
            Inception in the cloud with ansible
        </p>

        <div class="creators-card">
            <h2>The team:</h2>
            <div class="grid">
                <div class="profile">
                    <div class="name">Andor</div>
                </div>
                
                <div class="vertical-line"></div>
                
                <div class="profile">
                    <div class="name">Maurice</div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>