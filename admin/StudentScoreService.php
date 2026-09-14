<?php

// StudentScoreService.php
class StudentScoreService {
    private $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function getSchools() {
        $stmt = $this->pdo->query("SELECT * FROM schools");
        return $stmt->fetchAll();
    }

    public function getClasses($school_id) {
        $stmt = $this->pdo->prepare("SELECT * FROM classes WHERE school_id = ?");
        $stmt->execute([$school_id]);
        return $stmt->fetchAll();
    }

    public function getStudentsWithThemesAndScores($class_id, $searchQuery = '') {
        $sql = "
            SELECT s.student_id, s.name, 
                   st.id AS theme_id, st.theme_name,
                   ss.score, ss.date_assessed
            FROM students s
            JOIN classes c ON s.class_id = c.class_id
            JOIN school_themes sct ON c.school_id = sct.school_id
            JOIN sel_themes st ON sct.theme_id = st.id
            LEFT JOIN (
                SELECT student_id, theme_id, score, date_assessed,
                       ROW_NUMBER() OVER (PARTITION BY student_id, theme_id ORDER BY date_assessed DESC) as rn
                FROM student_scores
            ) ss ON s.student_id = ss.student_id AND st.id = ss.theme_id AND ss.rn = 1
            WHERE s.class_id = ? AND (s.student_id LIKE ? OR s.name LIKE ?)
            ORDER BY s.student_id, st.id
        ";
        $stmt = $this->pdo->prepare($sql);
        $searchParam = '%' . $searchQuery . '%';
        $stmt->execute([$class_id, $searchParam, $searchParam]);
        return $stmt->fetchAll(PDO::FETCH_GROUP);
    }

    public function getCurrentTermId(): ?int {
        // Try to get the current active term first
        $stmt = $this->pdo->query("
            SELECT id FROM terms 
            WHERE start_date <= CURDATE() 
            AND end_date >= CURDATE() 
            ORDER BY start_date DESC 
            LIMIT 1
        ");
        $current_term_id = $stmt->fetchColumn();
    
        // If no active term, get the most recent past term
        if (!$current_term_id) {
            $stmt = $this->pdo->query("
                SELECT id FROM terms 
                WHERE end_date < CURDATE() 
                ORDER BY end_date DESC 
                LIMIT 1
            ");
            $current_term_id = $stmt->fetchColumn();
        }
    
        return $current_term_id ?: null;
    }
    
    
    public function getTotalStudents() {
      $stmt = $this->pdo->query("SELECT COUNT(*) FROM students");
      return $stmt->fetchColumn();
  }



    public function saveScores($scores, $current_term_id) {
        $this->pdo->beginTransaction();
        $feedback = [];
        try {
            $check_stmt = $this->pdo->prepare("
                SELECT id, score FROM student_scores 
                WHERE student_id = ? AND theme_id = ? AND term_id = ?
            ");
            
            $update_stmt = $this->pdo->prepare("
                UPDATE student_scores 
                SET score = ?, date_assessed = ?
                WHERE id = ?
            ");
            
            $insert_stmt = $this->pdo->prepare("
                INSERT INTO student_scores (student_id, theme_id, score, date_assessed, term_id)
                VALUES (?, ?, ?, ?, ?)
            ");
            
            $delete_stmt = $this->pdo->prepare("
                DELETE FROM student_scores
                WHERE id = ?
            ");
            
            $date_assessed = date('Y-m-d');
            
            foreach ($scores as $student_id => $theme_scores) {
                foreach ($theme_scores as $theme_id => $score) {
                    $check_stmt->execute([$student_id, $theme_id, $current_term_id]);
                    $existing_score = $check_stmt->fetch(PDO::FETCH_ASSOC);
                    
                    if ($score === '') {
                        if ($existing_score) {
                            $delete_stmt->execute([$existing_score['id']]);
                        }
                    } elseif (is_numeric($score)) {
                        $score = (int)$score;
                        if ($score >= 1 && $score <= 10) {
                            if ($existing_score) {
                                if ($existing_score['score'] != $score) {
                                    $update_stmt->execute([$score, $date_assessed, $existing_score['id']]);
                                }
                            } else {
                                $insert_stmt->execute([$student_id, $theme_id, $score, $date_assessed, $current_term_id]);
                            }
                        } else {
                            $feedback[] = "Invalid score for Student ID: $student_id, Theme ID: $theme_id. Score must be between 1 and 10.";
                        }
                    } else {
                        $feedback[] = "Invalid input for Student ID: $student_id, Theme ID: $theme_id. Please enter a number or leave blank.";
                    }
                }
            }
    
            $this->pdo->commit();
            return ['success' => true, 'feedback' => $feedback];
        } catch (Exception $e) {
            $this->pdo->rollBack();
            return ['success' => false, 'error' => $e->getMessage(), 'feedback' => $feedback];
        }
    }

    public function getTerms($academic_year_id) {
        $sql = "SELECT * FROM terms WHERE academic_year_id = ? ORDER BY start_date";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$academic_year_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
      public function checkPdfExists($student_id, $term_id) {
    $stmt = $this->pdo->prepare("SELECT 1 FROM pdf_files WHERE student_id = ? AND term_id = ? LIMIT 1");
    $stmt->execute([$student_id, $term_id]);
    return $stmt->fetchColumn() !== false;
}


public function checkSendStatus($student_id) {
    // Prepare a query to select the most recent status based on send_date
    $stmt = $this->pdo->prepare("
        SELECT status 
        FROM send_status 
        WHERE student_id = ? 
        ORDER BY send_date DESC 
        LIMIT 1
    ");
    $stmt->execute([$student_id]);
    
    // Fetch the most recent status
    $status = $stmt->fetchColumn();
    
    // If no record found, return null
    return $status !== false ? $status : null;
}
}