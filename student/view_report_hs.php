<?php
// view_report.php
session_start();
require_once 'includes/db_connction.php';
// Check if this file is being included by download_report.php
if (!isset($pdo)) {
    require_once 'includes/db_connction.php';
}

if (!isset($student_id) || !isset($term_id)) {
  // If not included by download_report.php, use GET parameters
  $student_id = $_GET['student_id'] ?? null;
  $term_id = $_GET['term_id'] ?? null;

  if (!$student_id || !$term_id) {
      die("Student ID and Term ID are required.");
  }
}

// Retrieve the previous URL
$previousUrl = isset($_GET['previous_url']) ? $_GET['previous_url'] : null;

// Check if student_id and term_id are provided
if (!isset($_GET['student_id']) || !isset($_GET['term_id'])) {
    die("Student ID and Term ID are required.");
}

$student_id = $_GET['student_id'];
$term_id = intval($_GET['term_id']);
// Check if student_id and term_id are provided
if (!isset($_GET['student_id']) || !isset($_GET['term_id'])) {
    die("Student ID and Term ID are required.");
}

$student_id = $_GET['student_id'];
$term_id = intval($_GET['term_id']);

// Fetch student information
$stmt = $pdo->prepare(" 
    SELECT s.*, c.class_name, sc.school_name FROM students s JOIN classes c ON s.class_id = c.class_id JOIN schools sc ON c.school_id = sc.id
    WHERE s.student_id = ? 
");
$stmt->execute([$student_id]);
$student = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$student) {
    die("Student not found.");
}

// Fetch assigned SEL themes and historical scores
$stmt = $pdo->prepare("
    SELECT DISTINCT st.theme_name, st.competency, st.character_strength, hss.score
    FROM sel_themes st
    JOIN historical_student_scores hss ON st.id = hss.theme_id
    JOIN historical_school_themes hst ON hss.theme_id = hst.theme_id AND hss.term_id = hst.term_id
    WHERE hss.student_id = ? AND hss.term_id = ? AND hst.school_id = (
        SELECT c.school_id
        FROM students s
        JOIN classes c ON s.class_id = c.class_id
        WHERE s.student_id = ?
    )
    ORDER BY hss.theme_id
");
$stmt->execute([$student_id, $term_id, $student_id]);
$sel_themes = $stmt->fetchAll(PDO::FETCH_ASSOC);



// Check if we have at least 12 scores
$showReport = count($sel_themes) >= 12;

$calcAge = $student['dob'];
$dob = new DateTime($calcAge);;
$today = new DateTime('now');  
if($dob->format('Y-m-d\TH:i:s.v') < 0 || $dob->format('Y-m-d\TH:i:s.v') == null){
    $age = null;
  
}else{
    $age = $today->diff($dob)->y; 
}



function createSVGElement($name, $attributes = []) {
    $attr_string = '';
    foreach ($attributes as $key => $value) {
        $attr_string .= " $key=\"$value\"";
    }
    return "<$name$attr_string />";
}

function generateKEQBarChart($studentData, $studentName) {
  $margin = ['top' => 40, 'right' => 30, 'bottom' => 120, 'left' => 80];
  $width = 700; // Base width
  $height = 400; // Base height
  $chartWidth = $width - $margin['left'] - $margin['right'];
  $chartHeight = $height - $margin['top'] - $margin['bottom'];

  // Mapping function for labels
  function mapWordsel($abbreviation) {
      $map = [
          'Flexi' => 'Flexibility',
          'Deter' => 'Determination',
          'Adapt' => 'Adaptability',
          'Grit' => 'Grit',
          'Endu' => 'Endurance',
          'Teamwk.' => 'Teamwork',
          'Posit' => 'Positivity',
          'Collab' => 'Collaboration',
          'Prob Solv' => 'Problem-Solving',
          'Self Cont' => 'Self-Control',
          'Comm' => 'Communication',
          'Self Conf' => 'Self-Confidence',
          'Opti' => 'Optimism',
          'Curi' => 'Curiosity',
          'Empat' => 'Empathy',
          'Grat' => 'Gratitude',
          'Proacti' => 'Proactivity',
          'Deci Maki' => 'Decision Making',
          'Kind' => 'Kindness',
          'Hone' => 'Honesty',
          'Grow Mind' => 'Growth Mindset',
          'Purp.' => 'Purpose',
          'No Fail' => 'No Failure',
          'Expe' => 'Experience',
          'RDM' => 'Responsible Decision Making',
          'SM' => 'Self-Management',
          'SOA' => 'Social-Awareness',
          'SEA' => 'Self Awareness',
          'RS' => 'Relationship Skills'
      ];
      return isset($map[$abbreviation]) ? $map[$abbreviation] : $abbreviation;
  }

  $labels = array_map(function($theme) {
      return mapWordsel($theme['theme_name']);
  }, $studentData);
  $baseData = array_fill(0, count($labels), 50);
  $improvementData = array_map(function($theme) {
      return $theme['score'];
  }, $studentData);
  $targetData = array_map(function($theme) {
      return 100 - $theme['score'] - 50;
  }, $studentData);

  // Calculate scales
  $xScale = $chartWidth / count($labels);
  $yScale = ($chartHeight - 50) / 100;

  $svg = "<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 $width $height\" preserveAspectRatio=\"xMidYMid meet\">";

  // Background
  $svg .= "<rect width=\"$width\" height=\"$height\" fill=\"#333333\" />";

  // Title
  $svg .= "<text x=\"" . ($width / 2) . "\" y=\"35\" text-anchor=\"middle\" font-weight=\"bold\" font-size=\"16\" fill=\"#ffffff\">Kinesthetic Emotional Intelligence Quotient (KEQ) for $studentName</text>";

  // Draw bars
  for ($i = 0; $i < count($labels); $i++) {
      $x = $margin['left'] + ($i * $xScale);
      $baseHeight = $baseData[$i] * $yScale;
      $improvementHeight = $improvementData[$i] * $yScale;
      $targetHeight = $targetData[$i] * $yScale;

      // Base bar (green)
      $svg .= createSVGElement('rect', [
          'x' => $x + $xScale * 0.1,
          'y' => $height - $margin['bottom'] - $baseHeight,
          'width' => $xScale * 0.6,
          'height' => $baseHeight,
          'fill' => '#4CAF50'
      ]);

      // Base Value label (centered)
      $svg .= "<text x=\"" . ($x + ($xScale * 0.4)) . "\" y=\"" . ($height - $margin['bottom'] - $baseHeight / 2) . "\" text-anchor=\"middle\" font-size=\"10\" fill=\"#000000\">" . $baseData[$i] . "</text>";

      // Improvement bar (blue)
      $svg .= createSVGElement('rect', [
          'x' => $x + $xScale * 0.1,
          'y' => $height - $margin['bottom'] - $baseHeight - $improvementHeight,
          'width' => $xScale * 0.6,
          'height' => $improvementHeight * 1.5,
          'fill' => '#2196F3'
      ]);

      // Improvement Value label (aligned to bottom)
      $svg .= "<text x=\"" . ($x + ($xScale * 0.4)) . "\" y=\"" . ($height - $margin['bottom'] - $baseHeight + 2) . "\" text-anchor=\"middle\" font-size=\"10\" fill=\"#ffffff\">" . $improvementData[$i] . "</text>";

      // Target bar (yellow)
      $svg .= createSVGElement('rect', [
          'x' => $x + $xScale * 0.1,
          'y' => $height - $margin['bottom'] - $baseHeight - $improvementHeight - $targetHeight,
          'width' => $xScale * 0.6,
          'height' => $targetHeight,
          'fill' => '#FFEB3B'
      ]);

      // Target Value label (centered)
      $svg .= "<text x=\"" . ($x + ($xScale * 0.4)) . "\" y=\"" . ($height - $margin['bottom'] - $baseHeight - $improvementHeight - $targetHeight / 2) . "\" text-anchor=\"middle\" font-size=\"10\" fill=\"#000000\">" . (50 - $improvementData[$i]) . "</text>";

      // Tilted Label
      $svg .= "<text x=\"" . ($x + ($xScale * 0.4)) . "\" y=\"" . ($height - $margin['bottom'] + 20) . "\" text-anchor=\"end\" font-size=\"12\" fill=\"#ffffff\" transform=\"rotate(-45 " . ($x + ($xScale * 0.4)) . "," . ($height - $margin['bottom'] + 20) . ")\">" . mapWordsel($labels[$i]) . "</text>";
  }

  // Y-axis labels
  for ($i = 0; $i <= 100; $i += 10) {
      $y = $height - $margin['bottom'] - ($i * $yScale);
      $svg .= "<text x=\"" . ($margin['left'] - 10) . "\" y=\"$y\" text-anchor=\"end\" font-size=\"10\" fill=\"#ffffff\">" . $i . "%</text>";
  }

  // Horizontal Legend with space adjustment
  $legendItems = [
      ['color' => '#4CAF50', 'label' => 'Base'],
      ['color' => '#2196F3', 'label' => 'Improvement'],
      ['color' => '#FFEB3B', 'label' => 'Target']
  ];
  $legendX = ($width - $margin['right']) / 2 - 150;
  $legendY = $height - 30;
  $legendSpacing = 120;

  foreach ($legendItems as $index => $item) {
      $svg .= createSVGElement('rect', [
          'x' => $legendX + ($index * $legendSpacing),
          'y' => $legendY,
          'width' => 15,
          'height'  => 15,
          'fill' => $item['color']
      ]);
      $svg .= "<text x=\"" . ($legendX + 20 + ($index * $legendSpacing)) . "\" y=\"" . ($legendY + 12) . "\" font-size=\"12\" fill=\"#ffffff\">" . $item['label'] . "</text>";
  }

  $svg .= "</svg>";
  return $svg;
}



function generateSELPieChart($studentData, $studentName) {
  // Base dimensions
  $baseWidth = 800;
  $baseHeight = 400;
  $centerX = $baseWidth / 2;
  $centerY = $baseHeight / 2;
  $radius = min($centerX, $centerY) - 100;

  // Extract unique competencies
  $selLabels = array_unique(array_column($studentData, 'competency'));



  // Calculate data for each competency
  $selData = array_map(function($competency) use ($studentData) {
      $scores = array_column(
          array_filter($studentData, function($theme) use ($competency) {
              return $theme['competency'] === $competency;
          }),
          'score'
      );
      rsort($scores);
      return array_sum(array_slice($scores, 0, 2));
  }, $selLabels);

  $total = array_sum($selData);
  $colors = ['#F27A29', '#3A6BC4', '#FBC30A', '#A0A0A0', '#4E93D2', '#3B3EAC', '#4E93D2', '#4E93D2'];

  // Define the viewBox for responsive scaling
  $svg = "<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 $baseWidth $baseHeight\" preserveAspectRatio=\"xMidYMid meet\">";

  // Background
  $svg .= "<rect width=\"$baseWidth\" height=\"$baseHeight\" fill=\"#1a1a1a\" />";

  // Title
  $svg .= "<text x=\"$centerX\" y=\"40\" text-anchor=\"middle\" font-weight=\"bold\" font-size=\"16\" fill=\"white\">Social Emotional Learning Competencies for $studentName</text>";

  $startAngle = 0;
  foreach ($selLabels as $index => $label) {
      $value = $selData[$index];
      $percentage = ($value / $total) * 100;
      $endAngle = $startAngle + ($percentage / 100) * 360;

      $x1 = $centerX + $radius * cos(deg2rad($startAngle));
      $y1 = $centerY + $radius * sin(deg2rad($startAngle));
      $x2 = $centerX + $radius * cos(deg2rad($endAngle));
      $y2 = $centerY + $radius * sin(deg2rad($endAngle));

      $largeArcFlag = $endAngle - $startAngle <= 180 ? 0 : 1;

      $svg .= "<path d=\"M $centerX $centerY L $x1 $y1 A $radius $radius 0 $largeArcFlag 1 $x2 $y2 Z\" fill=\"{$colors[$index]}\" />";

      // Add label inside the slice with sum number and percentage
      $labelAngle = $startAngle + ($endAngle - $startAngle) / 2;
      $labelRadius = $radius * 0.7;
      $labelX = $centerX + $labelRadius * cos(deg2rad($labelAngle));
      $labelY = $centerY + $labelRadius * sin(deg2rad($labelAngle));
      $svg .= "<text x=\"$labelX\" y=\"$labelY\" text-anchor=\"middle\" font-size=\"10\" fill=\"black\">" . $value . " (" . number_format($percentage, 0) . "%)</text>";

      $startAngle = $endAngle;
  }

  // Legend - Flexed Horizontally with multiple rows
  $legendY = $baseHeight - 80; // Move to the bottom and up a bit
  $legendXStart = 50; // Start from the left with some padding
  $legendLineHeight = 25; // Space between legend items vertically
  $legendColumnWidth = 280; // Width of each legend column

  foreach ($selLabels as $index => $label) {
      $fullLabel = mapWordsel($label);
      $legendX = $legendXStart + (($index % 3) * $legendColumnWidth); // 3 columns
      $legendYOffset = floor($index / 3) * $legendLineHeight; // New row every 3 items
      $svg .= "<rect x=\"$legendX\" y=\"" . ($legendY + $legendYOffset) . "\" width=\"15\" height=\"15\" fill=\"{$colors[$index]}\" />";
      $svg .= "<text x=\"" . ($legendX + 20) . "\" y=\"" . ($legendY + 12 + $legendYOffset) . "\" font-size=\"10\" fill=\"white\">" . $fullLabel . " (" . $label . ")</text>";
  }

  $svg .= "</svg>";
  return $svg;
}



// Function to map competency abbreviations to full names
function csMap($abbreviation) {
  $map = [
      'SW' => 'Strength of Will',
      'SH' => 'Strength of Heart',
      'SM' => 'Strength of Mind'
  ];
  return isset($map[$abbreviation]) ? $map[$abbreviation] : $abbreviation;
}

function generateCharacterStrengthsBarChart($studentData, $studentName) {
  // Base dimensions
  $baseWidth = 800;
  $baseHeight = 400;
  $margin = ['top' => 40, 'right' => 20, 'bottom' => 150, 'left' => 80]; // Margins

  // Calculate chart dimensions
  $chartWidth = $baseWidth - $margin['left'] - $margin['right'];
  $chartHeight = $baseHeight - $margin['top'] - $margin['bottom'];

  $months = ['First Month', 'Second Month', 'Third Month'];

  // Divide the studentData into 3 groups, each containing 4 scores (representing data for three months)
  $monthlyData = [];
  for ($i = 0; $i < count($studentData); $i += 4) {
      $monthlyData[] = array_slice($studentData, $i, 4);
  }

  // Extract unique character strengths
  $csLabels = array_values(array_unique(array_column($studentData, 'character_strength')));

  // Map data to months and character strengths
  $csData = array_map(function($label) use ($monthlyData) {
      return array_map(function($monthData) use ($label) {
          $item = current(array_filter($monthData, function($theme) use ($label) {
              return $theme['character_strength'] === $label;
          }));
          return $item ? $item['score'] : 0; // If not found, default to 0
      }, $monthlyData);
  }, $csLabels);

  // Colors as defined in the JS code
  $colors = ['#A7A7A7',  '#3D6FC9', '#F67C2B', '#296BBF'];

  // Define the viewBox for responsive scaling
  $svg = "<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 $baseWidth $baseHeight\" preserveAspectRatio=\"xMidYMid meet\">";

  // Background
  $svg .= "<rect width=\"$baseWidth\" height=\"$baseHeight\" fill=\"#2F2F2F\" />";

  // Title
  $svg .= "<text x=\"" . ($baseWidth / 2) . "\" y=\"30\" text-anchor=\"middle\" font-weight=\"bold\" font-size=\"16\" fill=\"white\">Character Strengths by Month for $studentName</text>";

  // Calculate scales
  $xScale = ($chartWidth - 40) / (count($months) * 1.5); // Subtract 40 to add space on the left
  $yScale = $chartHeight / 9;  // Max value is 9

  // Draw axes
  $svg .= "<line x1=\"" . $margin['left'] . "\" y1=\"" . ($baseHeight - $margin['bottom']) . "\" x2=\"" . ($baseWidth - $margin['right']) . "\" y2=\"" . ($baseHeight - $margin['bottom']) . "\" stroke=\"white\" stroke-width=\"2\" />";
  $svg .= "<line x1=\"" . $margin['left'] . "\" y1=\"" . $margin['top'] . "\" x2=\"" . $margin['left'] . "\" y2=\"" . ($baseHeight - $margin['bottom']) . "\" stroke=\"white\" stroke-width=\"2\" />";

  // Draw bars
  foreach ($csData as $index => $data) {
      foreach ($data as $monthIndex => $value) {
          $x = $margin['left'] + 40 + ($monthIndex * $xScale * 1.5) + ($index * ($xScale / count($csLabels))); // Add 40 to x
          $barWidth = ($xScale / count($csLabels)) * 0.8;
          $barHeight = $value * $yScale;

          $svg .= "<rect x=\"$x\" y=\"" . ($baseHeight - $margin['bottom'] - $barHeight) . "\" width=\"$barWidth\" height=\"$barHeight\" fill=\"{$colors[$index % count($colors)]}\" />";

          // Value label
          $svg .= "<text x=\"" . ($x + $barWidth/2) . "\" y=\"" . ($baseHeight - $margin['bottom'] - $barHeight - 5) . "\" text-anchor=\"middle\" font-size=\"12\" fill=\"white\">" . $value . "</text>";
      }
  }

  // X-axis labels (months)
  foreach ($months as $index => $month) {
      $x = $margin['left'] + -4 + ($index * $xScale * 1.5) + ($xScale * 0.75); // Add 40 to x
      $svg .= "<text x=\"$x\" y=\"" . ($baseHeight - $margin['bottom'] + 20) . "\" text-anchor=\"middle\" font-size=\"12\" fill=\"white\">" . $month . "</text>";
  }

  // Y-axis labels
  for ($i = 0; $i <= 9; $i++) {
      $y = $baseHeight - $margin['bottom'] - ($i * $yScale);
      $svg .= "<text x=\"" . ($margin['left'] - 10) . "\" y=\"$y\" text-anchor=\"end\" font-size=\"12\" fill=\"white\">" . $i . "</text>";
  }

  // Centered Legend
  $legendX = ($baseWidth - (count($csLabels) * 150)) / 2; // Dynamically calculate legend position
  $legendY = $baseHeight - 70; // Adjust this value to move the legend up or down
  foreach ($csLabels as $index => $label) {
      $fullLabel = csMap($label);
      $svg .= "<rect x=\"" . ($legendX + $index * 150) . "\" y=\"$legendY\" width=\"15\" height=\"15\" fill=\"{$colors[$index % count($colors)]}\" />";
      $svg .= "<text x=\"" . ($legendX + $index * 150 + 20) . "\" y=\"" . ($legendY + 12) . "\" font-size=\"12\" fill=\"white\">" . $fullLabel . "</text>";
  }

  $svg .= "</svg>";
  return $svg;
}



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title><?php echo htmlspecialchars($student['name']); ?>'s Progress Report</title>
    <!-- <link rel="stylesheet" href="assets/css/report.css"> -->
    <!-- <link rel="stylesheet" href="assets/css/adminDashboard.css"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script> -->



    <style>
    body {
        display: block;
    }

    ul {
        padding: 0;
        margin: 0;
        line-height: 1.5em;
    }

    li {
        padding: 0.2em;
        margin: 10px;
    }

    /* report.css */
    body {
        font-family: "Montserrat", sans-serif;
        background-color: #f5f5f5;
        margin: 0;
        padding: 0;
        overflow-x: hidden;
    }

    #keqBarChart,
    #selPieChart,
    #csBarChart {
        width: 100%;
        height: 400px;
    }

    .main-container {
        width: 100%;
        padding: 1rem;
        background-color: #fff;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        height: max-content;
        position: sticky;
    }

    .intro {
        text-align: justify;
        text-justify: inter-word;
    }

    header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: -10px;
    }

    header h1 {
        font-family: "Wedges", sans-serif;
        color: #2a9d8f;
        margin-bottom: -10px;
    }

    .summary {
        display: flex;
        justify-content: space-between;
        margin: 20px 0;
    }

    .card {
        flex: 1;
        padding: 20px;
        background-color: #e9ecef;
        border-radius: 5px;
        text-align: center;
        margin: 0 10px;
        font-size: 18px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
    }

    table,
    th,
    td {
        border: 1px solid #ddd;
        padding: 5px;
        text-align: center;
    }

    th,
    td {
        padding: 10px;
        text-align: left;
    }

    th {
        background-color: #2a9d8f;
        color: #fff;
    }



    /* Additional CSS for report view */
    .modal {
        display: flex;
        /* position: fixed; */
        top: 0;
        left: 0;
        /* width: 100%;
  height: 100%; */
        /* background-color: rgba(0, 0, 0, 0.5); */
        justify-content: center;
        align-items: center;
        z-index: 1000;
        overflow: auto;
    }

    .modal .report-container {
        /* margin-top: 10%; */
        max-width: 1000px;
        width: 100%;
        /* padding: 20px; */
        background-color: #ffffff;
        border: 1px solid #ccc;
        box-shadow: 0 0 10px rgba(43, 41, 41, 0.1);
        align-self: center;
        position: relative;
    }

    #report-view {
        /* display: flex; */
    }

    .modal .close-btn {
        position: absolute;
        top: 10px;
        left: 20px;
        background: none;
        border: none;
        font-size: 2em;
        cursor: pointer;
        color: #f70303;
    }

    /*  */

    h1 {
        text-align: center;
        margin-top: 60px;
    }

    h2,
    h3 {
        text-align: left;
    }

    .container {
        display: flex;
        justify-content: space-between;
    }

    .left-side {
        flex: 1;
        margin: 20px;
    }

    .right-side {
        flex: 1;
        margin: 20px;
        margin-top: 9%;
    }

    .left-side p,
    .right-side p {
        margin: 10px 0;
    }

    canvas {
        max-height: 35%;
        display: block;
        margin: 10 auto 20px;
        max-width: 100%;
        background-color: rgb(45, 44, 44);
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin: 10px 0;
    }

    table,
    th,
    td {
        border: 1px solid #ccc;
    }

    th,
    td {
        padding: 5px;
        text-align: center;
    }

    footer {
        background-color: #fff;
        color: #040404;
        padding: 10px;
    }

    footer p {
        margin: 0;
    }

    .contact-info {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 20px;
    }

    .link {
        text-decoration: underline;
        color: #add8e6;
        /* light blue */
        cursor: pointer;
    }

    .link:hover {
        color: #87ceeb;
        /* darker blue */
    }

    .ki_number {
        margin: 0 auto;
    }

    .ki_link {
        text-decoration: underline;
        color: #add8e6;
        /* light blue */
        cursor: pointer;
    }

    .ki_link:hover {
        color: #87ceeb;
        /* darker blue */
    }



    @media print {
        @page {
            size: A4;
            /* Set page size to A4 */
            margin: 10mm;
            /* Adjust margins as needed */
        }

        body {
            color: black;
            /* Ensure text is black (color can be managed in print settings) */
        }

        /* Add any additional print-specific styles here */
    }



    @keyframes fadeInOut {

        0%,
        100% {
            opacity: 0;
        }

        50% {
            opacity: 1;
        }
    }

    .invalid {
        border: 2px solid red;
    }

    @media screen and (max-width: 483px) {


        body {
            font-size: 10px;
        }

        .container {
            flex-direction: row;
        }

        .left-side,
        .right-side {
            margin: 5px 0;
        }

        table {
            font-size: 8px;
            width: 100%;
            overflow-x: auto;
            display: block;
        }

        table th {
            font-size: 6px;
        }

        table td,
        table th {
            /* padding: 3px; */
            /* word-break: break-word; */
        }

        h1 {
            font-size: 16px;
        }

        h2 {
            font-size: 14px;
        }

        h3 {
            font-size: 12px;
        }

        .report-container {
            padding: 10px;
            width: 100%;
            box-sizing: border-box;
        }

        .summary {
            flex-direction: column;
        }

        .card {
            margin: 5px 0;
        }

        footer {
            font-size: 10px;
        }

        .contact-info {
            flex-direction: column;
            align-items: flex-start;
        }

        /* Ensure SVG charts are responsive */
        #keqBarChart,
        #selPieChart,
        #csBarChart {
            width: 100%;
            height: auto;
        }

        /* Ensure text doesn't overflow */
        p,
        li {
            word-wrap: break-word;
            overflow-wrap: break-word;
        }
    }

    /* Additional global styles for better mobile readability */
    * {
        box-sizing: border-box;
    }

    body {
        max-width: 100%;
        overflow-x: hidden;
    }

    .report-container {
        width: 100%;
        /* padding: 10px; */
    }

    /* Tablet Styles (768px to 1024px) */
    @media screen and (min-width: 483px) and (max-width: 1024px) {
        body {
            font-size: 14px;
        }

        .container {
            flex-direction: row;
        }

        .left-side,
        .right-side {
            margin: 15px 0;
            width: 100%;
        }

        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            /* Smooth scrolling on iOS */
        }

        .table-responsive table {
            min-width: 600px;
            /* Ensures horizontal scrolling on smaller screens */
        }

        table {
            font-size: 12px;
            width: 100%;
            overflow-x: auto;
            /* display: block; */
            table-layout: auto;
        }

        table td,
        table th {
            padding: 5px;
            /* word-break: break-word; */
        }

        h1 {
            font-size: 22px;
        }

        h2 {
            font-size: 20px;
        }

        h3 {
            font-size: 18px;
        }

        .report-container {
            padding: 15px;
            width: 100%;
            box-sizing: border-box;
        }

        .summary {
            flex-direction: column;
        }

        .card {
            margin: 10px 0;
        }

        footer {
            font-size: 12px;
        }

        .contact-info {
            flex-direction: row;
            justify-content: space-between;
        }

        /* Ensure SVG charts are responsive */
        #keqBarChart,
        #selPieChart,
        #csBarChart {
            width: 100%;
            height: auto;
        }

        /* Ensure text doesn't overflow */
        p,
        li {
            word-wrap: break-word;
            overflow-wrap: break-word;
        }
    }
    </style>
</head>

<body>
    <?php if($showReport): ?>
    <div id="report-view" class="modal">
        <div class="report-container">
            <!-- <button class="close-btn" onclick="closeReport()"><strong>X</strong></button> -->
            <div id="report-content">
                <div class="faded-text"><strong>KI EDUCATION</strong></div>

                <!-- Page 1 -->
                <div id="report-page-1" class="page-1">
                    <h1><u>KIE STUDENT PROGRESS REPORT</u></h1>
                    <p class="intro">Kinesthetic Intelligence Education personal progress report for <strong><span
                                id="student-name"><?php echo htmlspecialchars($student['name']); ?></span></strong> at
                        <strong><span
                                id="student-school"><?php echo htmlspecialchars($student['school_name']); ?>.</span></strong>
                        The
                        Kinesthetic Intelligence Education (KIE) student personal progress report provides a
                        comprehensive assessment of each student’s development over the 12-week program, which focused
                        on one Social Emotional Learning (SEL) theme per week. These themes were designed to enhance
                        students’ overall Emotional Intelligence. The report evaluates each student’s marginal
                        improvements in mastering these skills, offering valuable insights into their growth and areas
                        for further development. This progress assessment aims to encourage continuous learning and
                        promote personal growth in alignment with Open Mind Africa’s mission to develop well-rounded,
                        emotionally intelligent individuals.
                    </p>

                    <h2>Personal Information</h2>
                    <div class="container">
                        <div class="left-side">
                            <p><strong>Name:</strong> <span
                                    id="student-name-info"><?php echo htmlspecialchars($student['name']); ?></span></p>
                            <p><strong>Age:</strong> <?php echo htmlspecialchars($age ?? 'N/A'); ?> YEARS</p>
                            <p><strong>School:</strong> <span
                                    id="student-school-info"><?php echo htmlspecialchars($student['school_name']); ?></span>
                            </p>
                            <p><strong>Class:</strong> <span
                                    id="student-class-info"><?php echo htmlspecialchars($student['class_name']); ?></span>
                            </p>
                            <p><strong>Height:</strong> <?php echo htmlspecialchars($student['height'] ?? 'N/A'); ?> cm
                            </p>
                            <p><strong>Weight:</strong> <?php echo htmlspecialchars($student['weight'] ?? 'N/A'); ?> kg
                            </p>
                        </div>

                        <div class="right-side">
                            <p><strong>Foot:</strong> <?php echo htmlspecialchars($student['foot'] ?? 'N/A'); ?> </p>
                            <p><strong>Hand:</strong> <?php echo htmlspecialchars($student['hand'] ?? 'N/A'); ?></p>
                            <p><strong>Eyesight:</strong>
                                <?php echo htmlspecialchars($student['eye_sight'] ?? 'N/A'); ?></p>
                            <p><strong>Heart Rate:</strong>
                                <?php echo htmlspecialchars($student['heart_rate'] ?? 'N/A'); ?></p>
                            <p><strong>Medical Condition:</strong>
                                <?php echo htmlspecialchars($student['medical_condition'] ?? 'N/A'); ?></p>
                        </div>
                    </div>
                    <section class="data-tables">
                        <h2>1. Student KEQ Field Data</h2>
                        <div class="table-responsive">
                            <table>
                                <tr>
                                    <th>Metrics</th>
                                    <?php foreach ($sel_themes as $theme): ?>
                                    <th><?php echo htmlspecialchars($theme['theme_name'] ?? 'N/A'); ?></th>
                                    <?php endforeach; ?>
                                </tr>
                                <tr>
                                    <td>KEQ</td>
                                    <?php foreach ($sel_themes as $theme): ?>
                                    <td><?php echo htmlspecialchars($theme['score']); ?></td>
                                    <?php endforeach; ?>
                                </tr>
                            </table>
                        </div>
                    </section>
                    <div class="graph-description">
                        <h3>GRAPH DESCRIPTION</h3>
                        <ul>
                            <li>Each student starts from the green base line of 50% and work their way up.</li>
                            <li>The blue area represents the marginal percentage improvement this term.</li>
                            <li>The yellow area represents the target they are working towards over a period.</li>
                            <li>Students are expected to have a termly marginal improvement over a period.</li>
                        </ul>
                    </div>
                    <br>
                    <!-- Placeholder for KEQ Bar Chart -->

                    <?php echo generateKEQBarChart($sel_themes, $student['name']); ?>

                </div>

                <!-- Page 2 -->
                <div id="report-page-2" class="page-2">
                    <h3>RESULTS ANALYSIS</h3>
                    <ul>
                        <li><strong>Strength Recognition:</strong> Keep an eye on 8% - 10% marginal improvement. This is
                            one of your ward's strengths. Be aware of this skill especially in challenging situations at
                            home. We will keep working on it.</li>
                        <li><strong>Skill Development:</strong> Next keep an eye on 5% - 7% marginal improvement. Your
                            ward has some ability in this skill but with more practice we could get better.</li>
                        <li><strong>Developmental Focus:</strong> Now look at 2% - 4% marginal improvement. This skill
                            will take your ward more time to develop and strengthen. The K.I coach will focus more
                            attention to help your ward to develop this skill.</li>
                    </ul>

                    <h2>Social Emotional Learning Competencies (SEL)</h2>
                    <div class="table-responsive">
                        <table>
                            <tr>
                                <th>Metrics</th>
                                <?php foreach ($sel_themes as $theme): ?>
                                <th><?php echo htmlspecialchars($theme['theme_name'] ?? 'N/A'); ?></th>
                                <?php endforeach; ?>
                            </tr>
                            <tr>
                                <td>KEQ</td>
                                <?php foreach ($sel_themes as $theme): ?>
                                <td><?php echo htmlspecialchars($theme['score']); ?></td>
                                <?php endforeach; ?>
                            </tr>
                            <tr>
                                <td>SEL</td>
                                <?php foreach ($sel_themes as $theme): ?>
                                <td><?php echo htmlspecialchars($theme['competency']); ?></td>
                                <?php endforeach; ?>
                            </tr>

                        </table>
                    </div>
                    <!-- Placeholder for SEL Pie Chart -->
                    <?php echo generateSELPieChart($sel_themes, $student['name']); ?>

                    <h3>RESULTS ANALYSIS</h3>
                    <ul>
                        <li><strong>Thematic Exposure:</strong> Each term students explore a minimum of two character
                            development themes related to the five SEL competencies.</li>
                        <li><strong>Metric Evaluation:</strong> Internal metrics assess their performance on each
                            competency with a maximum achievable score of 20% for each totaling 100%.</li>
                        <li><strong>Focus on Improvement:</strong> The emphasis is on fostering continuous marginal
                            improvement each term rather than solely achieving high scores.</li>
                        <li><strong>Understanding Scores:</strong> An SEL score above 15 indicates robust emotional
                            intelligence while a score below 10 signals opportunities for ongoing improvement.</li>
                    </ul>
                </div>

                <!-- Page 3 -->
                <div id="report-page-3">
                    <h2>Character Strengths (CS)</h2>
                    <div class="table-responsive">
                        <table>
                            <tr>
                                <th>Metrics</th>
                                <?php foreach ($sel_themes as $theme): ?>
                                <th><?php echo htmlspecialchars($theme['theme_name'] ?? 'N/A'); ?></th>
                                <?php endforeach; ?>
                            </tr>
                            <tr>
                                <td>KEQ</td>
                                <?php foreach ($sel_themes as $theme): ?>
                                <td><?php echo htmlspecialchars($theme['score']); ?></td>
                                <?php endforeach; ?>
                            </tr>
                            <tr>
                                <td>SEL</td>
                                <?php foreach ($sel_themes as $theme): ?>
                                <td><?php echo htmlspecialchars($theme['character_strength']); ?></td>
                                <?php endforeach; ?>
                            </tr>
                        </table>
                    </div>
                    <!-- Placeholder for CS Bar Chart -->
                    <?php echo generateCharacterStrengthsBarChart($sel_themes, $student['name']); ?>


                    <h3>RESULTS ANALYSIS</h3>
                    <ul>
                        <li>Your child is actively developing their character strengths of Will Heart and Mind aiming
                            for a maximum score of 10 points in each category over time.</li>
                        <li>Achieving a score between 8 - 10 signifies high strength in the respective area. Encourage
                            your child to keep honing these strengths as they play a vital role in academic success and
                            overall personal development.</li>
                        <li>Scores falling within 5 - 7 indicate a medium level of strength. Your child possesses some
                            ability in these areas and with consistent effort and practice they can further enhance
                            their capabilities.</li>
                        <li>A score of 2 – 4 is positive feedback. The K.I coach will provide additional attention to
                            support your child in developing these character strengths more fully. Your engagement and
                            encouragement are crucial during this developmental process.</li>
                    </ul>

                    <footer>
                        <p><strong>Joseph A. Adams</strong> <br><strong>Founder, K.I. Education LLC</strong></p>
                        <div class="contact-info">
                            <p class="link"><strong>hi@kiedu.net</strong></p>
                            <p class="ki_number">054 396 1150</p>
                            <p class="ki_link"><strong>www.kiedu.net</strong></p>
                        </div>
                    </footer>
                </div>
            </div>
        </div>
    </div>
    <script>
    // JavaScript code to trigger print dialog 

    // window.addEventListener('load', function() {
    //     setTimeout(function() {
    //       window.print(); // Trigger print dialog after delay
    //     }, 1000); // Delay in milliseconds (e.g., 2000 ms = 2 seconds)
    //   });

    // window.onafterprint = function() {
    //             var previousUrl = '<?php echo $previousUrl; ?>'; // Get the previous URL from PHP

    //             if (previousUrl) {
    //               // setTimeout(function() {
    //                 window.location.href = previousUrl; // Trigger redirect after delay
    //     // }, 2000);
    //                  // Redirect to the previous page
    //             } else {
    //                 // Handle the case where previousUrl is not available
    //                 alert('ERROR : 404 ');
    //             }
    //         };
    </script>
    <?php else: ?>
    <div class="message-container">
        <h2>Report Not Available</h2>
        <p>Your scores will be available at the end of the term.</p>
        <p>Please check back later when all assessments have been completed.</p>
    </div>
    <?php endif; ?>
</body>

</html>