<?php
// Get the requested day and file from URL
$day = isset($_GET['day']) ? (int)$_GET['day'] : null;
$file = isset($_GET['file']) ? $_GET['file'] : null;

// Map days to their folder names
$dayFolders = [
    1 => '01-hello-world',
    2 => '02-variables-datatypes',
    3 => '03-operators-conditionals',
    4 => '04-loops',
    5 => '05-arrays',
    6 => '06-functions',
    7 => '07-builtin-functions',
    8 => '08-forms',
    9 => '09-form-validation',
    10 => '10-form-project',
    11 => '11-file-handling',
    12 => '12-file-upload',
    13 => '13-sessions-cookies',
    14 => '14-password-hashing',
    15 => '15-login-system',
    16 => '16-database-basics',
    17 => '17-sql-crud',
    18 => '18-php-mysql',
    19 => '19-insert-data',
    20 => '20-fetch-data',
];

// If a day is requested, include that day's content
if ($day && isset($dayFolders[$day])) {
    $folder = $dayFolders[$day];
    $dayPath = __DIR__ . "/{$folder}";

    // If a specific file is requested
    if ($file) {
        // Sanitize filename - only allow alphanumeric, underscore, hyphen, and .php extension
        $file = basename($file);
        if (preg_match('/^[a-zA-Z0-9_\-]+\.php$/', $file)) {
            $filePath = "{$dayPath}/{$file}";
            if (file_exists($filePath)) {
                include $filePath;
                exit;
            }
        }
    }

    // Check for index.php or index.html
    if (file_exists("{$dayPath}/index.php")) {
        include "{$dayPath}/index.php";
        exit;
    } elseif (file_exists("{$dayPath}/index.html")) {
        readfile("{$dayPath}/index.html");
        exit;
    } else {
        // Show available files in the folder
        $files = glob("{$dayPath}/*.php");
        if (!empty($files)) {
            // Include the first PHP file found
            include $files[0];
            exit;
        }
    }
}

// Check which days are available
function isDayAvailable($dayNum, $dayFolders) {
    if (!isset($dayFolders[$dayNum])) return false;
    $folder = $dayFolders[$dayNum];
    $path = __DIR__ . "/{$folder}";
    return is_dir($path);
}

// Get all PHP files in a day's folder
function getDayFiles($dayNum, $dayFolders) {
    if (!isset($dayFolders[$dayNum])) return [];
    $folder = $dayFolders[$dayNum];
    $path = __DIR__ . "/{$folder}";

    if (!is_dir($path)) return [];

    $files = glob("{$path}/*.php");
    $fileList = [];

    foreach ($files as $file) {
        $filename = basename($file);
        // Skip config files
        if (strpos($filename, 'config') !== false) continue;

        // Create a readable name from filename
        $name = str_replace(['_', '-', '.php'], [' ', ' ', ''], $filename);
        $name = ucwords($name);

        // Mark index files specially
        $isIndex = ($filename === 'index.php');

        $fileList[] = [
            'filename' => $filename,
            'name' => $name,
            'isIndex' => $isIndex
        ];
    }

    // Sort: index.php first, then alphabetically
    usort($fileList, function($a, $b) {
        if ($a['isIndex']) return -1;
        if ($b['isIndex']) return 1;
        return strcmp($a['filename'], $b['filename']);
    });

    return $fileList;
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>45-Day PHP Learning Plan</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;600&family=Outfit:wght@300;400;600;700&display=swap"
      rel="stylesheet"
    />
    <style>
      :root {
        --bg-dark: #0d1117;
        --bg-card: #161b22;
        --bg-card-hover: #1f262e;
        --php-purple: #8892be;
        --php-purple-bright: #a5b4fc;
        --accent-green: #3fb950;
        --accent-orange: #f59e0b;
        --accent-pink: #f472b6;
        --accent-blue: #58a6ff;
        --text-primary: #f0f6fc;
        --text-secondary: #8b949e;
        --border-color: #30363d;
      }

      * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
      }

      body {
        font-family: 'Outfit', sans-serif;
        background: var(--bg-dark);
        color: var(--text-primary);
        line-height: 1.6;
        min-height: 100vh;
      }

      body::before {
        content: '';
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-image: linear-gradient(
            rgba(136, 146, 190, 0.03) 1px,
            transparent 1px
          ),
          linear-gradient(90deg, rgba(136, 146, 190, 0.03) 1px, transparent 1px);
        background-size: 50px 50px;
        pointer-events: none;
        z-index: 0;
      }

      .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 2rem;
        position: relative;
        z-index: 1;
      }

      .hero {
        text-align: center;
        padding: 4rem 2rem;
        margin-bottom: 3rem;
        position: relative;
      }

      .hero::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 200px;
        height: 2px;
        background: linear-gradient(
          90deg,
          transparent,
          var(--php-purple),
          transparent
        );
      }

      .hero-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: rgba(136, 146, 190, 0.1);
        border: 1px solid var(--php-purple);
        padding: 0.5rem 1rem;
        border-radius: 50px;
        font-size: 0.85rem;
        color: var(--php-purple-bright);
        margin-bottom: 1.5rem;
        font-family: 'JetBrains Mono', monospace;
      }

      .hero h1 {
        font-size: clamp(2.5rem, 6vw, 4rem);
        font-weight: 700;
        margin-bottom: 1rem;
        background: linear-gradient(
          135deg,
          var(--text-primary) 0%,
          var(--php-purple-bright) 100%
        );
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
      }

      .hero-subtitle {
        font-size: 1.25rem;
        color: var(--text-secondary);
        max-width: 600px;
        margin: 0 auto 2rem;
      }

      .hero-stats {
        display: flex;
        justify-content: center;
        gap: 3rem;
        flex-wrap: wrap;
      }

      .stat {
        text-align: center;
      }

      .stat-value {
        font-size: 2.5rem;
        font-weight: 700;
        color: var(--php-purple-bright);
        font-family: 'JetBrains Mono', monospace;
      }

      .stat-label {
        font-size: 0.9rem;
        color: var(--text-secondary);
        text-transform: uppercase;
        letter-spacing: 1px;
      }

      .phase {
        margin-bottom: 4rem;
        animation: fadeInUp 0.6s ease forwards;
        opacity: 0;
      }

      @keyframes fadeInUp {
        from {
          opacity: 0;
          transform: translateY(30px);
        }
        to {
          opacity: 1;
          transform: translateY(0);
        }
      }

      .phase:nth-child(1) { animation-delay: 0.1s; }
      .phase:nth-child(2) { animation-delay: 0.2s; }
      .phase:nth-child(3) { animation-delay: 0.3s; }
      .phase:nth-child(4) { animation-delay: 0.4s; }
      .phase:nth-child(5) { animation-delay: 0.5s; }

      .phase-header {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid var(--border-color);
      }

      .phase-icon {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
      }

      .phase-1 .phase-icon { background: linear-gradient(135deg, #8892be33, #8892be11); }
      .phase-2 .phase-icon { background: linear-gradient(135deg, #3fb95033, #3fb95011); }
      .phase-3 .phase-icon { background: linear-gradient(135deg, #f59e0b33, #f59e0b11); }
      .phase-4 .phase-icon { background: linear-gradient(135deg, #f472b633, #f472b611); }
      .phase-5 .phase-icon { background: linear-gradient(135deg, #58a6ff33, #58a6ff11); }

      .phase-title { flex: 1; }

      .phase-title h2 {
        font-size: 1.5rem;
        font-weight: 600;
        margin-bottom: 0.25rem;
      }

      .phase-1 .phase-title h2 { color: var(--php-purple-bright); }
      .phase-2 .phase-title h2 { color: var(--accent-green); }
      .phase-3 .phase-title h2 { color: var(--accent-orange); }
      .phase-4 .phase-title h2 { color: var(--accent-pink); }
      .phase-5 .phase-title h2 { color: var(--accent-blue); }

      .phase-days {
        font-size: 0.9rem;
        color: var(--text-secondary);
        font-family: 'JetBrains Mono', monospace;
      }

      .days-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 1rem;
      }

      .day-card {
        background: var(--bg-card);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 1.25rem;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
        color: inherit;
        display: block;
      }

      .day-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        opacity: 0;
        transition: opacity 0.3s ease;
      }

      .phase-1 .day-card::before { background: var(--php-purple); }
      .phase-2 .day-card::before { background: var(--accent-green); }
      .phase-3 .day-card::before { background: var(--accent-orange); }
      .phase-4 .day-card::before { background: var(--accent-pink); }
      .phase-5 .day-card::before { background: var(--accent-blue); }

      .day-card:hover {
        background: var(--bg-card-hover);
      }

      .day-card:hover::before { opacity: 1; }

      .day-card.unavailable {
        opacity: 0.5;
        cursor: not-allowed;
        pointer-events: none;
      }

      .day-card .card-link {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-top: 1rem;
        padding-top: 0.75rem;
        border-top: 1px solid var(--border-color);
        font-size: 0.85rem;
        color: var(--php-purple);
        opacity: 0;
        transition: opacity 0.3s ease;
      }

      .day-card:hover .card-link { opacity: 1; }

      .card-link-arrow { transition: transform 0.3s ease; }

      .day-card:hover .card-link-arrow { transform: translateX(5px); }

      .day-number {
        font-family: 'JetBrains Mono', monospace;
        font-size: 0.8rem;
        font-weight: 600;
        color: var(--text-secondary);
        margin-bottom: 0.75rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
      }

      .day-number::before {
        content: '';
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: currentColor;
      }

      .phase-1 .day-number::before { background: var(--php-purple); }
      .phase-2 .day-number::before { background: var(--accent-green); }
      .phase-3 .day-number::before { background: var(--accent-orange); }
      .phase-4 .day-number::before { background: var(--accent-pink); }
      .phase-5 .day-number::before { background: var(--accent-blue); }

      .day-card ul { list-style: none; }

      .day-card li {
        position: relative;
        padding-left: 1.25rem;
        margin-bottom: 0.5rem;
        font-size: 0.95rem;
        color: var(--text-secondary);
      }

      .day-card li::before {
        content: '›';
        position: absolute;
        left: 0;
        color: var(--php-purple);
        font-weight: bold;
      }

      .day-card code {
        font-family: 'JetBrains Mono', monospace;
        background: rgba(136, 146, 190, 0.15);
        padding: 0.15rem 0.4rem;
        border-radius: 4px;
        font-size: 0.85rem;
        color: var(--php-purple-bright);
      }

      .mini-task {
        background: linear-gradient(
          135deg,
          rgba(136, 146, 190, 0.1),
          rgba(136, 146, 190, 0.05)
        );
        border: 1px dashed var(--php-purple);
      }

      .mini-task .day-number { color: var(--php-purple-bright); }

      .file-links {
        display: flex;
        flex-wrap: wrap;
        gap: 0.75rem;
        margin-top: 1rem;
        padding-top: 0.75rem;
        border-top: 1px solid var(--border-color);
      }

      .file-link {
        background: rgba(136, 146, 190, 0.1);
        border: 1px solid var(--border-color);
        padding: 0.4rem 0.85rem;
        border-radius: 6px;
        font-size: 0.8rem;
        font-family: 'JetBrains Mono', monospace;
        color: var(--php-purple-bright);
        text-decoration: none;
        transition: all 0.2s ease;
      }

      .file-link:hover {
        background: rgba(136, 146, 190, 0.2);
        border-color: var(--php-purple);
        color: var(--php-purple-bright);
        transform: translateY(-1px);
      }

      .phase-2 .file-link:hover { border-color: var(--accent-green); color: var(--accent-green); }
      .phase-3 .file-link:hover { border-color: var(--accent-orange); color: var(--accent-orange); }
      .phase-4 .file-link:hover { border-color: var(--accent-pink); color: var(--accent-pink); }
      .phase-5 .file-link:hover { border-color: var(--accent-blue); color: var(--accent-blue); }

      .project-card {
        background: linear-gradient(
          135deg,
          var(--bg-card),
          rgba(244, 114, 182, 0.05)
        );
        border: 1px solid var(--accent-pink);
        border-radius: 16px;
        padding: 2rem;
        margin-bottom: 2rem;
      }

      .project-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--accent-pink);
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
      }

      .project-features {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        gap: 0.75rem;
      }

      .feature-tag {
        background: rgba(244, 114, 182, 0.1);
        border: 1px solid rgba(244, 114, 182, 0.3);
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-size: 0.9rem;
        color: var(--text-secondary);
        display: flex;
        align-items: center;
        gap: 0.5rem;
      }

      .feature-tag::before {
        content: '✓';
        color: var(--accent-pink);
        font-weight: bold;
      }

      .info-section {
        background: var(--bg-card);
        border: 1px solid var(--border-color);
        border-radius: 16px;
        padding: 2rem;
        margin-top: 3rem;
      }

      .info-section h3 {
        font-size: 1.25rem;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
      }

      .tools-grid {
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
      }

      .tool-badge {
        background: var(--bg-dark);
        border: 1px solid var(--border-color);
        padding: 0.75rem 1.25rem;
        border-radius: 8px;
        font-family: 'JetBrains Mono', monospace;
        font-size: 0.9rem;
        transition: all 0.3s ease;
      }

      .tool-badge:hover {
        border-color: var(--php-purple);
        transform: translateY(-2px);
      }

      .outcomes-list {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 1rem;
      }

      .outcome-item {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 1rem;
        background: var(--bg-dark);
        border-radius: 8px;
      }

      .outcome-icon {
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, var(--accent-green), #22c55e);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        flex-shrink: 0;
      }

      .footer {
        text-align: center;
        padding: 3rem 2rem;
        margin-top: 4rem;
        border-top: 1px solid var(--border-color);
      }

      .footer-text {
        color: var(--text-secondary);
        margin-bottom: 1.5rem;
      }

      .cta-buttons {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 1rem;
      }

      .cta-btn {
        background: transparent;
        border: 1px solid var(--border-color);
        color: var(--text-primary);
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        font-family: 'Outfit', sans-serif;
        font-size: 0.95rem;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        text-decoration: none;
      }

      .cta-btn:hover {
        border-color: var(--php-purple);
        background: rgba(136, 146, 190, 0.1);
      }

      .cta-btn.primary {
        background: var(--php-purple);
        border-color: var(--php-purple);
        color: var(--bg-dark);
        font-weight: 600;
      }

      .cta-btn.primary:hover { background: var(--php-purple-bright); }

      .progress-bar {
        position: fixed;
        top: 0;
        left: 0;
        height: 3px;
        background: linear-gradient(
          90deg,
          var(--php-purple),
          var(--accent-pink)
        );
        z-index: 1000;
        width: 0%;
        transition: width 0.1s;
      }

      @media (max-width: 768px) {
        .container { padding: 1rem; }
        .hero { padding: 2rem 1rem; }
        .hero-stats { gap: 1.5rem; }
        .phase-header { flex-direction: column; align-items: flex-start; }
        .days-grid { grid-template-columns: 1fr; }
      }
    </style>
  </head>
  <body>
    <div class="progress-bar" id="progressBar"></div>

    <div class="container">
      <header class="hero">
        <div class="hero-badge">
          <span>&lt;?php</span> Learning Path <span>?&gt;</span>
        </div>
        <h1>45-Day PHP Learning Plan</h1>
        <p class="hero-subtitle">
          A complete, beginner-friendly roadmap to mastering PHP & MySQL with
          hands-on projects. Just 50 minutes per day.
        </p>
        <div class="hero-stats">
          <div class="stat">
            <div class="stat-value">45</div>
            <div class="stat-label">Days</div>
          </div>
          <div class="stat">
            <div class="stat-value">50</div>
            <div class="stat-label">Min/Day</div>
          </div>
          <div class="stat">
            <div class="stat-value">3</div>
            <div class="stat-label">Phases</div>
          </div>
          <div class="stat">
            <div class="stat-value">1</div>
            <div class="stat-label">CRUD Project</div>
          </div>
        </div>
      </header>

      <!-- Phase 1 -->
      <section class="phase phase-1">
        <div class="phase-header">
          <div class="phase-icon">🚀</div>
          <div class="phase-title">
            <h2>Phase 1: PHP Fundamentals</h2>
            <span class="phase-days">Day 1 – 10</span>
          </div>
        </div>
        <div class="days-grid">
          <?php
          $phase1 = [
              1 => ['title' => 'Day 1', 'topics' => ['What is PHP? How PHP works (client vs server)', 'Install PHP, Apache, MySQL (XAMPP/MAMP)', 'Run first <code>echo "Hello World";</code>']],
              2 => ['title' => 'Day 2', 'topics' => ['PHP syntax', 'Variables, constants', 'Data types']],
              3 => ['title' => 'Day 3', 'topics' => ['Operators (arithmetic, comparison, logical)', 'Conditional statements (<code>if</code>, <code>else</code>, <code>switch</code>)']],
              4 => ['title' => 'Day 4', 'topics' => ['Loops (<code>for</code>, <code>while</code>, <code>foreach</code>)', '<code>break</code>, <code>continue</code>']],
              5 => ['title' => 'Day 5', 'topics' => ['Arrays (indexed, associative, multidimensional)', 'Array functions']],
              6 => ['title' => 'Day 6', 'topics' => ['PHP functions', 'Function parameters & return values']],
              7 => ['title' => 'Day 7', 'topics' => ['Built-in PHP functions (string, math, date)', '<code>include</code> vs <code>require</code>']],
              8 => ['title' => 'Day 8', 'topics' => ['Forms in PHP', '<code>$_GET</code> and <code>$_POST</code>']],
              9 => ['title' => 'Day 9', 'topics' => ['Form validation (required fields, email, length)', 'Sanitization basics']],
              10 => ['title' => 'Day 10 – Mini Task', 'topics' => ['Create a form → display submitted data safely'], 'mini' => true],
          ];

          foreach ($phase1 as $dayNum => $dayData):
              $available = isDayAvailable($dayNum, $dayFolders);
              $files = $available ? getDayFiles($dayNum, $dayFolders) : [];
              $class = $dayData['mini'] ?? false ? 'day-card mini-task' : 'day-card';
              $class .= $available ? '' : ' unavailable';
          ?>
          <div class="<?= $class ?>">
            <div class="day-number"><?= $dayData['title'] ?></div>
            <ul>
              <?php foreach ($dayData['topics'] as $topic): ?>
              <li><?= $topic ?></li>
              <?php endforeach; ?>
            </ul>
            <?php if ($available && !empty($files)): ?>
            <div class="file-links">
              <?php foreach ($files as $fileInfo): ?>
              <a href="?day=<?= $dayNum ?>&file=<?= urlencode($fileInfo['filename']) ?>" class="file-link">
                <?= htmlspecialchars($fileInfo['name']) ?>
              </a>
              <?php endforeach; ?>
            </div>
            <?php endif; ?>
          </div>
          <?php endforeach; ?>
        </div>
      </section>

      <!-- Phase 2 -->
      <section class="phase phase-2">
        <div class="phase-header">
          <div class="phase-icon">📁</div>
          <div class="phase-title">
            <h2>Phase 2: Working with Files & Sessions</h2>
            <span class="phase-days">Day 11 – 15</span>
          </div>
        </div>
        <div class="days-grid">
          <?php
          $phase2 = [
              11 => ['title' => 'Day 11', 'topics' => ['File handling (<code>fopen</code>, <code>fwrite</code>, <code>fread</code>)']],
              12 => ['title' => 'Day 12', 'topics' => ['Upload files (images)', 'Validate file size & type']],
              13 => ['title' => 'Day 13', 'topics' => ['Sessions & cookies', 'Login concept (without DB)']],
              14 => ['title' => 'Day 14', 'topics' => ['Password hashing (<code>password_hash</code>, <code>password_verify</code>)']],
              15 => ['title' => 'Day 15 – Mini Task', 'topics' => ['Simple login system using sessions (no database)'], 'mini' => true],
          ];

          foreach ($phase2 as $dayNum => $dayData):
              $available = isDayAvailable($dayNum, $dayFolders);
              $files = $available ? getDayFiles($dayNum, $dayFolders) : [];
              $class = $dayData['mini'] ?? false ? 'day-card mini-task' : 'day-card';
              $class .= $available ? '' : ' unavailable';
          ?>
          <div class="<?= $class ?>">
            <div class="day-number"><?= $dayData['title'] ?></div>
            <ul>
              <?php foreach ($dayData['topics'] as $topic): ?>
              <li><?= $topic ?></li>
              <?php endforeach; ?>
            </ul>
            <?php if ($available && !empty($files)): ?>
            <div class="file-links">
              <?php foreach ($files as $fileInfo): ?>
              <a href="?day=<?= $dayNum ?>&file=<?= urlencode($fileInfo['filename']) ?>" class="file-link">
                <?= htmlspecialchars($fileInfo['name']) ?>
              </a>
              <?php endforeach; ?>
            </div>
            <?php endif; ?>
          </div>
          <?php endforeach; ?>
        </div>
      </section>

      <!-- Phase 3 -->
      <section class="phase phase-3">
        <div class="phase-header">
          <div class="phase-icon">🗄️</div>
          <div class="phase-title">
            <h2>Phase 3: MySQL + PHP</h2>
            <span class="phase-days">Day 16 – 25</span>
          </div>
        </div>
        <div class="days-grid">
          <?php
          $phase3 = [
              16 => ['title' => 'Day 16', 'topics' => ['What is a database?', 'MySQL basics (tables, rows, columns)']],
              17 => ['title' => 'Day 17', 'topics' => ['SQL basics: <code>SELECT</code>, <code>INSERT</code>, <code>UPDATE</code>, <code>DELETE</code>']],
              18 => ['title' => 'Day 18', 'topics' => ['Connect PHP to MySQL using mysqli / PDO']],
              19 => ['title' => 'Day 19', 'topics' => ['Insert data into database from PHP form']],
              20 => ['title' => 'Day 20', 'topics' => ['Fetch & display data (<code>SELECT</code>)']],
          ];

          foreach ($phase3 as $dayNum => $dayData):
              $available = isDayAvailable($dayNum, $dayFolders);
              $files = $available ? getDayFiles($dayNum, $dayFolders) : [];
              $class = $dayData['mini'] ?? false ? 'day-card mini-task' : 'day-card';
              $class .= $available ? '' : ' unavailable';
          ?>
          <div class="<?= $class ?>">
            <div class="day-number"><?= $dayData['title'] ?></div>
            <ul>
              <?php foreach ($dayData['topics'] as $topic): ?>
              <li><?= $topic ?></li>
              <?php endforeach; ?>
            </ul>
            <?php if ($available && !empty($files)): ?>
            <div class="file-links">
              <?php foreach ($files as $fileInfo): ?>
              <a href="?day=<?= $dayNum ?>&file=<?= urlencode($fileInfo['filename']) ?>" class="file-link">
                <?= htmlspecialchars($fileInfo['name']) ?>
              </a>
              <?php endforeach; ?>
            </div>
            <?php endif; ?>
          </div>
          <?php endforeach; ?>
        </div>
      </section>

      <!-- Tools Section -->
      <div class="info-section">
        <h3>🛠️ Tools You'll Use</h3>
        <div class="tools-grid">
          <div class="tool-badge">PHP</div>
          <div class="tool-badge">MySQL</div>
          <div class="tool-badge">SQLite</div>
          <div class="tool-badge">PDO</div>
          <div class="tool-badge">XAMPP / MAMP</div>
          <div class="tool-badge">HTML / CSS</div>
          <div class="tool-badge">Basic SQL</div>
        </div>
      </div>

      <!-- Outcome Section -->
      <div class="info-section">
        <h3>🎯 Outcome After 45 Days</h3>
        <div class="outcomes-list">
          <div class="outcome-item">
            <div class="outcome-icon">✓</div>
            <span>Build PHP web apps confidently</span>
          </div>
          <div class="outcome-item">
            <div class="outcome-icon">✓</div>
            <span>Create secure CRUD applications</span>
          </div>
          <div class="outcome-item">
            <div class="outcome-icon">✓</div>
            <span>Understand backend fundamentals</span>
          </div>
          <div class="outcome-item">
            <div class="outcome-icon">✓</div>
            <span>Apply for Junior PHP / Backend roles</span>
          </div>
        </div>
      </div>

      <!-- Footer -->
      <footer class="footer">
        <p class="footer-text">
          Want more resources to accelerate your learning?
        </p>
        <div class="cta-buttons">
          <a href="database_setup.html" class="cta-btn">📚 Database Setup Guide</a>
          <a href="setup_all_databases.sql" class="cta-btn">🗄️ Database Schema</a>
        </div>
      </footer>
    </div>

    <script>
      window.addEventListener('scroll', () => {
        const scrollTop = window.scrollY
        const docHeight = document.documentElement.scrollHeight - window.innerHeight
        const scrollPercent = (scrollTop / docHeight) * 100
        document.getElementById('progressBar').style.width = scrollPercent + '%'
      })

      const observer = new IntersectionObserver(
        (entries) => {
          entries.forEach((entry) => {
            if (entry.isIntersecting) {
              entry.target.style.animationPlayState = 'running'
            }
          })
        },
        { threshold: 0.1 }
      )

      document.querySelectorAll('.phase').forEach((phase) => {
        phase.style.animationPlayState = 'paused'
        observer.observe(phase)
      })
    </script>
  </body>
</html>
