<?php
function createSELTheme($theme_name, $competency, $character_strength) {
    global $pdo;
    $sql = "INSERT INTO sel_themes (theme_name, competency, character_strength) VALUES (:theme_name, :competency, :character_strength)";
    $stmt = $pdo->prepare($sql);
    $result = $stmt->execute([
        ':theme_name' => $theme_name,
        ':competency' => $competency,
        ':character_strength' => $character_strength
    ]);
    
    if ($result) {
        $_SESSION['toast_message'] = 'SEL Theme created successfully.';
        $_SESSION['toast_type'] = 'success';
    } else {
        $_SESSION['toast_message'] = 'Error creating SEL Theme.';
        $_SESSION['toast_type'] = 'error';
    }
}

function getAllSELThemes() {
    global $pdo;
    $sql = "SELECT * FROM sel_themes";
    $stmt = $pdo->query($sql);
    return $stmt->fetchAll();
}

function deleteSELTheme($theme_id) {
    global $pdo;
    $sql = "DELETE FROM sel_themes WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    return $stmt->execute([':id' => $theme_id]);
}

// function startNewTerm($academic_year_id, $term_number, $start_date, $end_date) {
//     global $pdo;
    
//     try {
//         $pdo->beginTransaction();
        
//         $stmt = $pdo->prepare("INSERT INTO terms (academic_year_id, term_number, start_date, end_date) VALUES (?, ?, ?, ?)");
//         $stmt->execute([$academic_year_id, $term_number, $start_date, $end_date]);
//         $new_term_id = $pdo->lastInsertId();
        
//         $pdo->commit();
//         $_SESSION['toast_message'] = 'New term started successfully. Please assign themes to schools for the new term.';
//         $_SESSION['toast_type'] = 'success';
        
//         $stmt = $pdo->prepare("SELECT t.id, t.term_number, ay.year_name 
//                                FROM terms t 
//                                JOIN academic_years ay ON t.academic_year_id = ay.id 
//                                WHERE t.id = ?");
//         $stmt->execute([$new_term_id]);
//         return $stmt->fetch(PDO::FETCH_ASSOC);
//     } catch (Exception $e) {
//         $pdo->rollBack();
//         error_log("Error starting new term: " . $e->getMessage());
//         $_SESSION['toast_message'] = 'Error starting new term. Please check the error log for more details.';
//         $_SESSION['toast_type'] = 'error';
//         return false;
//     }
// }
function startNewTerm($academic_year_id, $term_number, $start_date, $end_date) {
  global $pdo;
  
  try {
      // Check if a term with the same academic year and term number already exists
      $stmt = $pdo->prepare("SELECT id FROM terms WHERE academic_year_id = ? AND term_number = ?");
      $stmt->execute([$academic_year_id, $term_number]);
      $existing_term_id = $stmt->fetchColumn();
      
      if ($existing_term_id) {
          $_SESSION['toast_message'] = "A term with number $term_number already exists for this academic year. Please enter a new term number.";
          $_SESSION['toast_type'] = 'error';
          return false;
      }
      
      $pdo->beginTransaction();
      
      // Insert the new term
      $stmt = $pdo->prepare("INSERT INTO terms (academic_year_id, term_number, start_date, end_date) VALUES (?, ?, ?, ?)");
      if (!$stmt->execute([$academic_year_id, $term_number, $start_date, $end_date])) {
          throw new Exception("Failed to insert new term.");
      }
      $new_term_id = $pdo->lastInsertId();
      
      // Get the previous term ID
      $stmt = $pdo->prepare("SELECT id FROM terms WHERE id != ? ORDER BY start_date DESC LIMIT 1");
      $stmt->execute([$new_term_id]);
      $previous_term_id = $stmt->fetchColumn();
      
      // Move student scores to historical records
      $stmt = $pdo->prepare("
          INSERT INTO historical_student_scores (student_id, theme_id, score, date_assessed, term_id, academic_year_id)
          SELECT ss.student_id, ss.theme_id, ss.score, ss.date_assessed, ss.term_id, ?
          FROM student_scores ss
          WHERE ss.term_id = ?
      ");
      if (!$stmt->execute([$academic_year_id, $previous_term_id])) {
          throw new Exception("Failed to move student scores to historical records.");
      }
      
      // Clear current student scores
      $stmt = $pdo->prepare("DELETE FROM student_scores WHERE term_id = ?");
      if (!$stmt->execute([$previous_term_id])) {
          throw new Exception("Failed to clear current student scores.");
      }
      
      // Move theme assignments to historical records
      $stmt = $pdo->prepare("
          INSERT INTO historical_school_themes (school_id, theme_id, term_id, academic_year_id)
          SELECT st.school_id, st.theme_id, st.term_id, ?
          FROM school_themes st
          WHERE st.term_id = ?
      ");
      if (!$stmt->execute([$academic_year_id, $previous_term_id])) {
          throw new Exception("Failed to move theme assignments to historical records.");
      }
      
      // Clear current theme assignments
      $stmt = $pdo->prepare("DELETE FROM school_themes WHERE term_id = ?");
      if (!$stmt->execute([$previous_term_id])) {
          throw new Exception("Failed to clear current theme assignments.");
      }
      
      $pdo->commit();
      $_SESSION['toast_message'] = 'New term started successfully. Please assign themes to schools for the new term.';
      $_SESSION['toast_type'] = 'success';
      
      // Retrieve and return new term details
      $stmt = $pdo->prepare("SELECT t.id, t.term_number, ay.year_name 
                             FROM terms t 
                             JOIN academic_years ay ON t.academic_year_id = ay.id 
                             WHERE t.id = ?");
      $stmt->execute([$new_term_id]);
      return $stmt->fetch(PDO::FETCH_ASSOC);
      
  } catch (Exception $e) {
      $pdo->rollBack();
      error_log("Error starting new term: " . $e->getMessage());
      $_SESSION['toast_message'] = 'Error starting new term. Please check the error log for more details.';
      $_SESSION['toast_type'] = 'error';
      return false;
  }
}

function assignThemesToSchool($school_id, $theme_ids) {
    global $pdo;
    
    try {
        $pdo->beginTransaction();

        $stmt = $pdo->query("SELECT id FROM terms ORDER BY start_date DESC LIMIT 1");
        $current_term_id = $stmt->fetchColumn();

        $stmt = $pdo->prepare("SELECT COUNT(*) FROM school_themes WHERE school_id = ? AND term_id = ?");
        $stmt->execute([$school_id, $current_term_id]);
        $existing_assignments = $stmt->fetchColumn();

        if ($existing_assignments > 0) {
          $_SESSION['toast_message'] = 'Themes have already been assigned to this school for the current term.';
          $_SESSION['toast_type'] = 'error';
            $pdo->rollBack();
            return false;
        }

        $insert_sql = "INSERT INTO school_themes (school_id, theme_id, term_id) VALUES (:school_id, :theme_id, :term_id)";
        $insert_stmt = $pdo->prepare($insert_sql);
        
        foreach ($theme_ids as $theme_id) {
            $insert_stmt->execute([
                ':school_id' => $school_id,
                ':theme_id' => $theme_id,
                ':term_id' => $current_term_id
            ]);
        }

        $pdo->commit();
        $_SESSION['toast_message'] = 'Themes assigned successfully to the school.';
        $_SESSION['toast_type'] = 'success';
        return true;
    } catch (Exception $e) {
        $pdo->rollBack();
        error_log($e->getMessage());
        $_SESSION['toast_message'] = 'Error assigning themes to the school.';
        $_SESSION['toast_type'] = 'error';
        return false;
    }
}

function assignThemesToAllSchools($theme_ids) {
    global $pdo;
    
    try {
      $pdo->beginTransaction();

      $stmt = $pdo->query("SELECT id FROM terms ORDER BY start_date DESC LIMIT 1");
      $current_term_id = $stmt->fetchColumn();

      $stmt = $pdo->query("SELECT id FROM schools");
      $schools = $stmt->fetchAll(PDO::FETCH_COLUMN);

      foreach ($schools as $school_id) {
          $stmt = $pdo->prepare("SELECT COUNT(*) FROM school_themes WHERE school_id = ? AND term_id = ?");
          $stmt->execute([$school_id, $current_term_id]);
          $existing_assignments = $stmt->fetchColumn();

          if ($existing_assignments > 0) {
              continue; // Skip schools that already have assignments
          }

          $insert_sql = "INSERT INTO school_themes (school_id, theme_id, term_id) VALUES (:school_id, :theme_id, :term_id)";
          $insert_stmt = $pdo->prepare($insert_sql);

          foreach ($theme_ids as $theme_id) {
              $insert_stmt->execute([
                  ':school_id' => $school_id,
                  ':theme_id' => $theme_id,
                  ':term_id' => $current_term_id
              ]);
          }
      }

        $pdo->commit();
        $_SESSION['toast_message'] = 'Themes assigned successfully to all schools.';
        $_SESSION['toast_type'] = 'success';
        return true;
    } catch (Exception $e) {
        $pdo->rollBack();
        error_log($e->getMessage());
        $_SESSION['toast_message'] = 'Error assigning themes to all schools.';
        $_SESSION['toast_type'] = 'error';
        return false;
    }
}

function getSchools() {
    global $pdo;
    $sql = "SELECT * FROM schools";
    $stmt = $pdo->query($sql);
    return $stmt->fetchAll();
}

function getAssignedThemes() {
    global $pdo;
    $sql = "SELECT ay.year_name, sc.school_name, t.term_number, s.school_id, t.id as term_id, GROUP_CONCAT(st.theme_name SEPARATOR ', ') AS themes
            FROM school_themes s
            JOIN sel_themes st ON s.theme_id = st.id
            JOIN terms t ON s.term_id = t.id
            JOIN academic_years ay ON t.academic_year_id = ay.id
            JOIN schools sc ON s.school_id = sc.id
            GROUP BY ay.year_name, sc.school_name, t.term_number, s.school_id, t.id";
    $stmt = $pdo->query($sql);
    return $stmt->fetchAll();
}

function deleteAssignedThemes($school_id, $term_id) {
    global $pdo;
    $sql = "DELETE FROM school_themes WHERE school_id = :school_id AND term_id = :term_id";
    $stmt = $pdo->prepare($sql);
    $result = $stmt->execute([':school_id' => $school_id, ':term_id' => $term_id]);
    
    if ($result) {
        $_SESSION['toast_message'] = 'Assigned themes deleted successfully.';
        $_SESSION['toast_type'] = 'success';
    } else {
        $_SESSION['toast_message'] = 'Error deleting assigned themes.';
        $_SESSION['toast_type'] = 'error';
    }
    return $result;
}

function getCurrentTermInfo() {
    global $pdo;
    $stmt = $pdo->query("SELECT t.term_number, ay.year_name FROM terms t JOIN academic_years ay ON t.academic_year_id = ay.id ORDER BY t.start_date DESC LIMIT 1");
    return $stmt->fetch(PDO::FETCH_ASSOC);
}