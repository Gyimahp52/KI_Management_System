<?php 
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
  $colors = ['#F27A29', '#3A6BC4', '#FBC30A', '#A0A0A0', '#4E93D2', '#3B3EAC', '#4E93D2'];

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

      $svg .= "<path d=\"M $centerX $centerY L $x1 $y1 A $radius $radius 0 $largeArcFlag 1 $x2 $y2 Z\" fill=\"{$colors[$index % count($colors)]}\" />";

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
      $svg .= "<rect x=\"$legendX\" y=\"" . ($legendY + $legendYOffset) . "\" width=\"15\" height=\"15\" fill=\"{$colors[$index % count($colors)]}\" />";
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
  $margin = ['top' => 70, 'right' => 20, 'bottom' => 150, 'left' => 80]; // Margins

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


  $colors = ['#A7A7A7',  '#3D6FC9', '#F67C2B', '#296BBF'];

  // Define the viewBox for responsive scaling
  $svg = "<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 $baseWidth $baseHeight\" preserveAspectRatio=\"xMidYMid meet\">";

  // Background
  $svg .= "<rect width=\"$baseWidth\" height=\"$baseHeight\" fill=\"#2F2F2F\" />";

  // Title
  $svg .= "<text x=\"" . ($baseWidth / 2) . "\" y=\"40\" text-anchor=\"middle\" font-weight=\"bold\" font-size=\"16\" fill=\"white\">Character Strengths by Month for $studentName</text>";

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

