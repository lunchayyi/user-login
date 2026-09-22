<?php
session_start();
$usershow = isset($_SESSION['userdashboard']) ? $_SESSION['userdashboard'] : 'Guest';;
?>

<?php
// BacII Grade Criteria Configuration
$tracks = [
    'science' => [
        'name' => 'Science Class',
        'subjects' => [
            'Khmer'     => 75,
            'Math'      => 125,
            'Biology'   => 75,
            'History'   => 50,
            'Chemistry' => 75,
            'Physics'   => 75,
            'English'   => 50,
        ],
        'grades' => [
            'A' => 428,
            'B' => 380,
            'C' => 333,
            'D' => 285,
            'E' => 237.5,
        ]
    ],
    'social' => [
        'name' => 'Social Science Class',
        'subjects' => [
            'Khmer'                 => 125,
            'Math'                  => 75,
            'Environmental Science' => 50,
            'History'               => 75,
            'Geography'             => 75,
            'Moral Civics'          => 75,
            'English'               => 50,
        ],
        'grades' => [
            'A' => 427.5,
            'B' => 380,
            'C' => 332.5,
            'D' => 285,
            'E' => 237.5,
        ]
    ]
];

// Determine active track and calculate total/grade if form submitted
$selectedTrackKey = $_POST['track'] ?? 'science';
$selectedTrack = $tracks[$selectedTrackKey];
$totalScore = 0;
$maxPossible = array_sum($selectedTrack['subjects']);
$grade = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['scores'])) {
    foreach ($selectedTrack['subjects'] as $subject => $max) {
        $score = min($max, max(0, floatval($_POST['scores'][$subject] ?? 0)));
        $totalScore += $score;
    }

    // Determine Final Grade
    $grade = 'F';
    foreach ($selectedTrack['grades'] as $letter => $threshold) {
        if ($totalScore >= $threshold) {
            $grade = $letter;
            break;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>BacII Grade Finder</title>
    <style>
        body { font-family: system-ui, sans-serif; background: #f8fafc; padding: 2rem; color: #1e293b; }
        .card { max-width: 550px; margin: 0 auto; background: white; padding: 2rem; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); }
        h1 { margin-top: 0; color: #312e81; font-size: 1.5rem; }
        .form-group { margin-bottom: 1rem; display: flex; justify-content: space-between; align-items: center; }
        label { font-weight: 500; }
        input[type="number"], select { padding: 6px 10px; border: 1px solid #cbd5e1; border-radius: 6px; width: 100px; }
        select { width: auto; }
        button { width: 100%; padding: 10px; background: #4f46e5; color: white; border: none; border-radius: 6px; font-weight: bold; cursor: pointer; margin-top: 1rem; }
        button:hover { background: #4338ca; }
        .result { margin-top: 1.5rem; padding: 1rem; border-radius: 8px; text-align: center; background: #e0e7ff; color: #312e81; }
        .grade { font-size: 2.5rem; font-weight: bold; margin: 0.5rem 0; }
    </style>
</head>
<body>

<div class="card">
    <h1>BacII Grade Finder</h1>

    <form method="POST">
        <div class="form-group">
            <label for="track">Select Class Track:</label>
            <select name="track" id="track" onchange="this.form.submit()">
                <option value="science" <?= $selectedTrackKey === 'science' ? 'selected' : '' ?>>Science Class</option>
                <option value="social" <?= $selectedTrackKey === 'social' ? 'selected' : '' ?>>Social Science Class</option>
            </select>
        </div>

        <hr style="border: 0; border-top: 1px solid #e2e8f0; margin: 1.5rem 0;">

        <?php foreach ($selectedTrack['subjects'] as $subject => $maxScore): ?>
            <div class="form-group">
                <label><?= $subject ?> (Max <?= $maxScore ?>):</label>
                <input type="number" 
                       name="scores[<?= $subject ?>]" 
                       min="0" 
                       max="<?= $maxScore ?>" 
                       step="0.5" 
                       value="<?= htmlspecialchars($_POST['scores'][$subject] ?? 0) ?>" 
                       required>
            </div>
        <?php endforeach; ?>

        <button type="submit">Calculate Grade</button>
    </form>

    <?php if ($grade !== null): ?>
        <div class="result">
            Total Score: <strong><?= $totalScore ?> / <?= $maxPossible ?></strong>
            <div class="grade">Grade: <?= $grade ?></div>
        </div>
    <?php endif; ?>
</div>

</body>
</html>
