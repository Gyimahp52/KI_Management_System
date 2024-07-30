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

    public function getStudentsWithThemesAndScores($class_id) {
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
            WHERE s.class_id = ?
            ORDER BY s.student_id, st.id
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$class_id]);
        return $stmt->fetchAll(PDO::FETCH_GROUP);
    }

    public function getCurrentTermId() {
        $stmt = $this->pdo->query("SELECT id FROM terms WHERE start_date <= CURDATE() AND end_date >= CURDATE() ORDER BY start_date DESC LIMIT 1");
        return $stmt->fetchColumn();
    }

    public function getTotalStudents() {
      $stmt = $this->pdo->query("SELECT COUNT(*) FROM students");
      return $stmt->fetchColumn();
  }

    public function saveScores($scores, $current_term_id) {
        $this->pdo->beginTransaction();
        try {
            $update_stmt = $this->pdo->prepare("
                UPDATE student_scores 
                SET score = ?, date_assessed = ?
                WHERE student_id = ? AND theme_id = ? AND term_id = ?
            ");
            
            $insert_stmt = $this->pdo->prepare("
                INSERT INTO student_scores (student_id, theme_id, score, date_assessed, term_id)
                VALUES (?, ?, ?, ?, ?)
            ");
            
            $date_assessed = date('Y-m-d');
            
            foreach ($scores as $student_id => $theme_scores) {
                foreach ($theme_scores as $theme_id => $score) {
                    if ($score !== '' && ctype_digit($score) && $score >= 2 && $score <= 9) {
                        $update_stmt->execute([$score, $date_assessed, $student_id, $theme_id, $current_term_id]);
                        
                        if ($update_stmt->rowCount() == 0) {
                            $insert_stmt->execute([$student_id, $theme_id, $score, $date_assessed, $current_term_id]);
                        }
                    }
                }
            }

            $this->pdo->commit();
            return true;
        } catch (Exception $e) {
            $this->pdo->rollBack();
            throw $e;
        }
    }
}