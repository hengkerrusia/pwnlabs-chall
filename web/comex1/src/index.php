<?php
if (!isset($_GET["ip"])) {
    header("Location: /?ip=127.0.0.1");
    die();
}

require("header.php");
?>

<div class="info-box">
    <strong>ℹ️ About:</strong> This tool performs network connectivity tests using ICMP echo requests. Enter an IP address below to check network reachability and latency.
</div>

<form method="GET" action="/">
    <div class="form-group">
        <label for="ip">Target IP Address</label>
        <input type="text" id="ip" name="ip" value="<?php echo $_GET['ip']; ?>" placeholder="e.g., 8.8.8.8" required>
    </div>
    <button type="submit">Run Diagnostic</button>
</form>

<?php if (isset($_GET['ip'])): ?>
<div class="output-section">
    <div class="output-header">📊 Diagnostic Results</div>
    <div class="output-content"><?php
    system("ping -c 2 " . $_GET['ip']);
    ?></div>
</div>
<?php endif; ?>

        </div>
    </div>
</body>
</html>
