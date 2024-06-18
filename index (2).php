<?php
session_start();

// Initialize the task list if it doesn't exist
if (!isset($_SESSION['tasks'])) {
    $_SESSION['tasks'] = [];
}

// Handle form submissions for Create, Update, and Delete
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];

        if ($action === 'create') {
            $task = $_POST['task'];
            if (!empty($task)) {
                $_SESSION['tasks'][] = $task;
            }
        } elseif ($action === 'update') {
            $index = $_POST['index'];
            $task = $_POST['task'];
            if (isset($_SESSION['tasks'][$index])) {
                $_SESSION['tasks'][$index] = $task;
            }
        } elseif ($action === 'delete') {
            $index = $_POST['index'];
            if (isset($_SESSION['tasks'][$index])) {
                unset($_SESSION['tasks'][$index]);
                $_SESSION['tasks'] = array_values($_SESSION['tasks']); // Re-index the array
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Anime To-do App</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <div class="logo">Anime To-do</div>
        <nav>
            <ul>
                <li><a href="index.html">Home</a></li>
                <li><a href="index.php">App</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <h1>Anime To-do App</h1>

        <!-- Create Task Form -->
        <form action="index.php" method="post">
            <input type="hidden" name="action" value="create">
            <input type="text" name="task" placeholder="New Task">
            <button type="submit">Add Task</button>
        </form>

        <!-- Task List -->
        <ul>
            <?php foreach ($_SESSION['tasks'] as $index => $task): ?>
                <li>
                    <form action="index.php" method="post" style="display: inline;">
                        <input type="hidden" name="action" value="update">
                        <input type="hidden" name="index" value="<?php echo $index; ?>">
                        <input type="text" name="task" value="<?php echo htmlspecialchars($task); ?>">
                        <button type="submit">Update</button>
                    </form>
                    <form action="index.php" method="post" style="display: inline;">
                        <input type="hidden" name="action" value="delete">
                        <input type="hidden" name="index" value="<?php echo $index; ?>">
                        <button type="submit">Delete</button>
                    </form>
                </li>
            <?php endforeach; ?>
        </ul>
    </main>
<!-- Code injected by live-server -->
<script>
	// <![CDATA[  <-- For SVG support
	if ('WebSocket' in window) {
		(function () {
			function refreshCSS() {
				var sheets = [].slice.call(document.getElementsByTagName("link"));
				var head = document.getElementsByTagName("head")[0];
				for (var i = 0; i < sheets.length; ++i) {
					var elem = sheets[i];
					var parent = elem.parentElement || head;
					parent.removeChild(elem);
					var rel = elem.rel;
					if (elem.href && typeof rel != "string" || rel.length == 0 || rel.toLowerCase() == "stylesheet") {
						var url = elem.href.replace(/(&|\?)_cacheOverride=\d+/, '');
						elem.href = url + (url.indexOf('?') >= 0 ? '&' : '?') + '_cacheOverride=' + (new Date().valueOf());
					}
					parent.appendChild(elem);
				}
			}
			var protocol = window.location.protocol === 'http:' ? 'ws://' : 'wss://';
			var address = protocol + window.location.host + window.location.pathname + '/ws';
			var socket = new WebSocket(address);
			socket.onmessage = function (msg) {
				if (msg.data == 'reload') window.location.reload();
				else if (msg.data == 'refreshcss') refreshCSS();
			};
			if (sessionStorage && !sessionStorage.getItem('IsThisFirstTime_Log_From_LiveServer')) {
				console.log('Live reload enabled.');
				sessionStorage.setItem('IsThisFirstTime_Log_From_LiveServer', true);
			}
		})();
	}
	else {
		console.error('Upgrade your browser. This Browser is NOT supported WebSocket for Live-Reloading.');
	}
	// ]]>
</script>
</body>
</html>