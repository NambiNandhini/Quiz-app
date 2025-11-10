<?php
session_start();
require_once 'config.php';

// Check if results exist
if (!isset($_SESSION['quiz_results'])) {
    header('Location: index.php');
    exit;
}

$results = $_SESSION['quiz_results'];
$score = $results['score'];
$total_questions = $results['total_questions'];
$questions = $results['questions'];
$user_answers = $results['user_answers'];

$percentage = ($score / $total_questions) * 100;

// Determine performance message and icon
if ($percentage >= 80) {
    $performance_text = "Excellent! You're a quiz master! 🎉";
    $performance_color = "#4cc9f0";
    $performance_icon = "fas fa-trophy";
    $performance_class = "excellent";
} elseif ($percentage >= 60) {
    $performance_text = "Good job! You have solid knowledge. 👍";
    $performance_color = "#4361ee";
    $performance_icon = "fas fa-star";
    $performance_class = "good";
} elseif ($percentage >= 40) {
    $performance_text = "Not bad! Keep learning and try again. 💪";
    $performance_color = "#f8961e";
    $performance_icon = "fas fa-rocket";
    $performance_class = "average";
} else {
    $performance_text = "Keep studying! You'll do better next time. 📚";
    $performance_color = "#f72585";
    $performance_icon = "fas fa-seedling";
    $performance_class = "improve";
}

// Get category name for display
$pdo = getDBConnection();
$category_name = "All Categories";
if (isset($_SESSION['quiz_session']['category_id']) && $_SESSION['quiz_session']['category_id'] !== 'all') {
    $stmt = $pdo->prepare("SELECT name FROM categories WHERE id = ?");
    $stmt->execute([$_SESSION['quiz_session']['category_id']]);
    $category = $stmt->fetch(PDO::FETCH_ASSOC);
    $category_name = $category ? $category['name'] : "All Categories";
}

// Calculate performance metrics
$correct_answers = $score;
$incorrect_answers = $total_questions - $score;
$accuracy = $total_questions > 0 ? round(($score / $total_questions) * 100, 1) : 0;

// Debug: Check what's in the results
error_log("Score: " . $score . ", Total: " . $total_questions);
error_log("User answers: " . print_r($user_answers, true));
foreach ($questions as $index => $question) {
    error_log("Q" . ($index+1) . ": Correct=" . $question['correct_option'] . ", User=" . ($user_answers[$index] ?? 'null'));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Quiz Results - QuizMaster</title>
  
  <!-- Google Font -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

  <style>
    :root {
      --primary: #4361ee;
      --primary-light: #4895ef;
      --secondary: #3a0ca3;
      --success: #4cc9f0;
      --danger: #f72585;
      --warning: #f8961e;
      --info: #7209b7;
      --light: #f8f9fa;
      --dark: #212529;
      --muted: #6c757d;
      --dark-blue: #1d3557;
      --gradient: linear-gradient(135deg, #4361ee 0%, #3a0ca3 100%);
      --gradient-light: linear-gradient(135deg, #4895ef 0%, #4361ee 100%);
      --border-radius: 12px;
      --border-radius-lg: 20px;
      --box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
      --box-shadow-lg: 0 20px 50px rgba(0, 0, 0, 0.15);
      --transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: 'Inter', sans-serif;
    }

    html {
      scroll-behavior: smooth;
    }

    body {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      color: var(--dark);
      line-height: 1.7;
      min-height: 100vh;
      overflow-x: hidden;
    }

    .container {
      width: 100%;
      max-width: 1200px;
      margin: 0 auto;
      padding: 0 20px;
    }

    /* Navigation */
    .nav {
      background-color: rgba(255, 255, 255, 0.95);
      backdrop-filter: blur(10px);
      box-shadow: 0 2px 20px rgba(0, 0, 0, 0.08);
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      z-index: 1000;
      transition: var(--transition);
    }

    .nav.scrolled {
      padding: 0.5rem 0;
      box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
    }

    .nav-inner {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 1.2rem 0;
      transition: var(--transition);
    }

    .brand {
      font-weight: 800;
      font-size: 1.5rem;
      background: var(--gradient);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      text-decoration: none;
      display: flex;
      align-items: center;
      gap: 0.5rem;
    }

    .brand i {
      font-size: 1.3rem;
    }

    .nav-links {
      display: flex;
      gap: 2.5rem;
    }

    .nav-links a {
      color: var(--dark);
      text-decoration: none;
      font-weight: 600;
      font-size: 0.95rem;
      transition: var(--transition);
      position: relative;
    }

    .nav-links a:hover {
      color: var(--primary);
    }

    .nav-links a::after {
      content: '';
      position: absolute;
      bottom: -5px;
      left: 0;
      width: 0;
      height: 2px;
      background: var(--gradient);
      transition: var(--transition);
    }

    .nav-links a:hover::after {
      width: 100%;
    }

    /* Main Results Section */
    .results-section {
      padding: 8rem 0 4rem;
      min-height: 100vh;
      position: relative;
    }

    .results-section::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 1000" opacity="0.03"><polygon fill="white" points="0,1000 1000,0 1000,1000"/></svg>');
      background-size: cover;
    }

    .results-container {
      width: 100%;
      max-width: 1000px;
      margin: 0 auto;
      position: relative;
      z-index: 2;
    }

    .results-card {
      background: white;
      border-radius: var(--border-radius-lg);
      box-shadow: var(--box-shadow-lg);
      padding: 3rem;
      transition: var(--transition);
      border: 1px solid rgba(255, 255, 255, 0.2);
      backdrop-filter: blur(10px);
    }

    .results-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 25px 60px rgba(0, 0, 0, 0.2);
    }

    /* Results Header */
    .results-header {
      text-align: center;
      margin-bottom: 3rem;
      padding-bottom: 2rem;
      border-bottom: 2px solid #f1f3f9;
    }

    .results-header h2 {
      color: var(--primary);
      margin-bottom: 1rem;
      font-size: 2.5rem;
      font-weight: 800;
    }

    .results-header .muted {
      color: var(--muted);
      font-size: 1.2rem;
    }

    /* Score Display */
    .score-display {
      text-align: center;
      margin-bottom: 3rem;
      padding: 3rem 2rem;
      background: var(--gradient);
      border-radius: var(--border-radius-lg);
      color: white;
      position: relative;
      overflow: hidden;
    }

    .score-display::before {
      content: '';
      position: absolute;
      top: -50%;
      left: -50%;
      width: 200%;
      height: 200%;
      background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
      animation: pulse 4s infinite;
    }

    @keyframes pulse {
      0%, 100% { transform: scale(1); opacity: 0.5; }
      50% { transform: scale(1.1); opacity: 0.8; }
    }

    .score-main {
      font-size: 4.5rem;
      font-weight: 800;
      margin-bottom: 0.5rem;
      position: relative;
      z-index: 2;
    }

    .score-percentage {
      font-size: 1.5rem;
      opacity: 0.9;
      margin-bottom: 1.5rem;
      position: relative;
      z-index: 2;
    }

    .performance-badge {
      display: inline-flex;
      align-items: center;
      gap: 0.8rem;
      background: rgba(255, 255, 255, 0.2);
      padding: 1rem 2rem;
      border-radius: 50px;
      font-size: 1.2rem;
      font-weight: 700;
      position: relative;
      z-index: 2;
      backdrop-filter: blur(10px);
      border: 1px solid rgba(255, 255, 255, 0.3);
    }

    /* Performance Metrics */
    .performance-metrics {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
      gap: 1.5rem;
      margin-bottom: 3rem;
    }

    .metric-card {
      background: white;
      border-radius: var(--border-radius);
      box-shadow: var(--box-shadow);
      padding: 2rem 1.5rem;
      text-align: center;
      transition: var(--transition);
      border: 1px solid #f1f3f9;
    }

    .metric-card:hover {
      transform: translateY(-5px);
      box-shadow: var(--box-shadow-lg);
    }

    .metric-icon {
      width: 60px;
      height: 60px;
      background: var(--gradient-light);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto 1rem;
      font-size: 1.5rem;
      color: white;
    }

    .metric-value {
      font-size: 2rem;
      font-weight: 800;
      margin-bottom: 0.5rem;
      color: var(--primary);
    }

    .metric-label {
      color: var(--muted);
      font-weight: 600;
    }

    /* Quiz Info */
    .quiz-info {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 1.5rem;
      margin-bottom: 3rem;
    }

    .info-item {
      background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
      padding: 1.5rem;
      border-radius: var(--border-radius);
      text-align: center;
      border: 1px solid #f1f3f9;
    }

    .info-label {
      font-size: 0.9rem;
      color: var(--muted);
      margin-bottom: 0.7rem;
      font-weight: 600;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 0.5rem;
    }

    .info-value {
      font-weight: 700;
      color: var(--dark);
      font-size: 1.1rem;
    }

    /* Feedback Section */
    .feedback-section {
      margin-bottom: 3rem;
    }

    .feedback-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 2rem;
      padding: 1.5rem 2rem;
      background: white;
      border-radius: var(--border-radius);
      box-shadow: var(--box-shadow);
      border: 1px solid #f1f3f9;
    }

    .feedback-header h3 {
      color: var(--secondary);
      font-size: 1.5rem;
      font-weight: 700;
      display: flex;
      align-items: center;
      gap: 0.8rem;
    }

    .feedback-stats {
      display: flex;
      gap: 2rem;
    }

    .stat {
      display: flex;
      flex-direction: column;
      align-items: center;
    }

    .stat-value {
      font-size: 1.5rem;
      font-weight: 800;
      color: var(--primary);
    }

    .stat-label {
      font-size: 0.875rem;
      color: var(--muted);
      font-weight: 600;
    }

    .feedback-container {
      max-height: 600px;
      overflow-y: auto;
      border: 1px solid #f1f3f9;
      border-radius: var(--border-radius);
      background: white;
      box-shadow: var(--box-shadow);
    }

    .feedback-item {
      padding: 2rem;
      border-bottom: 1px solid #f1f3f9;
      transition: var(--transition);
      position: relative;
    }

    .feedback-item:last-child {
      border-bottom: none;
    }

    .feedback-item.correct {
      background: linear-gradient(135deg, #f8fff9 0%, #f0fff4 100%);
      border-left: 4px solid #28a745;
    }

    .feedback-item.incorrect {
      background: linear-gradient(135deg, #fff5f7 0%, #ffe6e6 100%);
      border-left: 4px solid var(--danger);
    }

    .question-number {
      position: absolute;
      top: 1rem;
      right: 1.5rem;
      background: rgba(0, 0, 0, 0.1);
      color: var(--dark);
      padding: 0.3rem 0.8rem;
      border-radius: 20px;
      font-size: 0.875rem;
      font-weight: 600;
    }

    .question-text {
      font-weight: 700;
      margin-bottom: 1.5rem;
      font-size: 1.1rem;
      line-height: 1.5;
      color: var(--dark);
    }

    .answer-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 1.5rem;
    }

    .answer-card {
      padding: 1.2rem;
      border-radius: var(--border-radius);
      border: 2px solid transparent;
    }

    .answer-card.user-answer.correct {
      background: rgba(40, 167, 69, 0.1);
      border-color: #28a745;
    }

    .answer-card.user-answer.incorrect {
      background: rgba(247, 37, 133, 0.1);
      border-color: var(--danger);
    }

    .answer-card.correct-answer {
      background: rgba(40, 167, 69, 0.05);
      border: 2px dashed #28a745;
    }

    .answer-label {
      font-weight: 600;
      margin-bottom: 0.5rem;
      display: flex;
      align-items: center;
      gap: 0.5rem;
    }

    .answer-text {
      font-weight: 500;
    }

    .answer-icon {
      margin-left: 0.5rem;
    }

    /* Action Buttons */
    .action-buttons {
      display: flex;
      justify-content: center;
      gap: 1.5rem;
      margin-top: 3rem;
    }

    /* Buttons */
    .btn {
      padding: 1.1rem 2.2rem;
      border-radius: var(--border-radius);
      font-weight: 600;
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      transition: var(--transition);
      border: none;
      font-size: 1rem;
      gap: 0.7rem;
      position: relative;
      overflow: hidden;
    }

    .btn::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
      transition: 0.5s;
    }

    .btn:hover::before {
      left: 100%;
    }

    .btn.primary {
      background: var(--gradient);
      color: white;
      box-shadow: 0 10px 30px rgba(67, 97, 238, 0.3);
    }

    .btn.primary:hover {
      transform: translateY(-5px);
      box-shadow: 0 15px 40px rgba(67, 97, 238, 0.4);
    }

    .btn.secondary {
      background: transparent;
      color: var(--primary);
      border: 2px solid var(--primary);
    }

    .btn.secondary:hover {
      background: rgba(67, 97, 238, 0.1);
      transform: translateY(-3px);
      box-shadow: 0 10px 25px rgba(67, 97, 238, 0.2);
    }

    /* Footer */
    .footer {
      background: var(--dark-blue);
      color: white;
      text-align: center;
      padding: 2.5rem 0;
      position: relative;
    }

    .footer-content {
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 1.2rem;
    }

    /* Floating Elements */
    .floating-element {
      position: absolute;
      background: rgba(255, 255, 255, 0.1);
      border-radius: 50%;
      animation: float 6s ease-in-out infinite;
    }

    @keyframes float {
      0%, 100% { transform: translateY(0px) rotate(0deg); }
      50% { transform: translateY(-20px) rotate(180deg); }
    }

    .floating-1 {
      width: 80px;
      height: 80px;
      top: 20%;
      left: 5%;
      animation-delay: 0s;
    }

    .floating-2 {
      width: 60px;
      height: 60px;
      top: 60%;
      right: 10%;
      animation-delay: 2s;
    }

    .floating-3 {
      width: 40px;
      height: 40px;
      bottom: 20%;
      left: 15%;
      animation-delay: 4s;
    }

    /* Responsive */
    @media (max-width: 968px) {
      .answer-grid {
        grid-template-columns: 1fr;
      }
      
      .feedback-header {
        flex-direction: column;
        gap: 1rem;
        text-align: center;
      }
      
      .feedback-stats {
        justify-content: center;
      }
    }

    @media (max-width: 768px) {
      .nav-inner {
        flex-direction: column;
        gap: 1.2rem;
      }
      
      .nav-links {
        gap: 1.5rem;
      }
      
      .performance-metrics,
      .quiz-info {
        grid-template-columns: 1fr;
      }
      
      .action-buttons {
        flex-direction: column;
      }
      
      .btn {
        width: 100%;
        justify-content: center;
      }
      
      .score-main {
        font-size: 3.5rem;
      }
      
      .results-card {
        padding: 2rem;
        margin: 1rem;
      }
      
      .results-section {
        padding: 7rem 0 2rem;
      }
    }

    /* Animations */
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

    .fade-in-up {
      animation: fadeInUp 0.8s ease-out;
    }
  </style>
</head>
<>
  <!-- Floating Background Elements -->
  <div class="floating-element floating-1"></div>
  <div class="floating-element floating-2"></div>
  <div class="floating-element floating-3"></div>

  <header class="nav" id="navbar">
    <div class="container nav-inner">
      <a class="brand" href="index.php">
        <i class="fas fa-brain"></i>
        QuizMaster
      </a>
      <nav class="nav-links">
        <a href="index.php#about">About</a>
        <a href="index.php#features">Features</a>
        <a href="index.php#quiz">New Quiz</a>
        <a href="index.php#contact">Contact</a>
      </nav>
    </div>
  </header>

  <main>
    <section class="results-section">
      <div class="container">
        <div class="results-container">
          <div class="results-card fade-in-up">
            <div class="results-header">
              <h2><i class="fas fa-trophy"></i> Quiz Completed!</h2>
              <p class="muted">Detailed analysis of your performance</p>
            </div>
            
            <div class="score-display">
              <div class="score-main"><?php echo $score; ?>/<?php echo $total_questions; ?></div>
              <div class="score-percentage"><?php echo round($percentage, 1); ?>% Accuracy</div>
              <div class="performance-badge">
                <i class="<?php echo $performance_icon; ?>"></i>
                <?php echo $performance_text; ?>
              </div>
            </div>
            
            <!-- Performance Metrics -->
            <div class="performance-metrics">
              <div class="metric-card fade-in-up">
                <div class="metric-icon">
                  <i class="fas fa-check-circle"></i>
                </div>
                <div class="metric-value"><?php echo $correct_answers; ?></div>
                <div class="metric-label">Correct Answers</div>
              </div>
              
              <div class="metric-card fade-in-up delay-1">
                <div class="metric-icon">
                  <i class="fas fa-times-circle"></i>
                </div>
                <div class="metric-value"><?php echo $incorrect_answers; ?></div>
                <div class="metric-label">Incorrect Answers</div>
              </div>
              
              <div class="metric-card fade-in-up delay-2">
                <div class="metric-icon">
                  <i class="fas fa-chart-line"></i>
                </div>
                <div class="metric-value"><?php echo $accuracy; ?>%</div>
                <div class="metric-label">Overall Accuracy</div>
              </div>
            </div>
            
            <!-- Quiz Information -->
            <div class="quiz-info">
              <div class="info-item fade-in-up">
                <div class="info-label">
                  <i class="fas fa-folder"></i>
                  Category
                </div>
                <div class="info-value"><?php echo htmlspecialchars($category_name); ?></div>
              </div>
              <!-- <div class="info-item fade-in-up delay-1">
                <div class="info-label">
                  <i class="fas fa-sliders-h"></i>
                  Difficulty
                </div>
                <div class="info-value"><?php echo isset($_SESSION['quiz_session']['difficulty']) ? ucfirst($_SESSION['quiz_session']['difficulty']) : 'Mixed'; ?></div>
              </div> -->
              <div class="info-item fade-in-up delay-2">
                <div class="info-label">
                   <i class="fas fa-sliders-h"></i>
                   Difficulty
                </div>
                <div class="info-value"><?php echo isset($_SESSION['quiz_session']['difficulty']) ? ucfirst($_SESSION['quiz_session']['difficulty']) : 'Mixed'; ?></div>
              </div>
            </div>
            
            <!-- Question Review -->
            <div class="feedback-section">
              <div class="feedback-header fade-in-up">
                <h3><i class="fas fa-clipboard-list"></i> Question Review</h3>
                <div class="feedback-stats">
                  <div class="stat">
                    <div class="stat-value"><?php echo $correct_answers; ?></div>
                    <div class="stat-label">Correct</div>
                  </div>
                  <div class="stat">
                    <div class="stat-value"><?php echo $incorrect_answers; ?></div>
                    <div class="stat-label">Incorrect</div>
                  </div>
                  <div class="stat">
                    <div class="stat-value"><?php echo $total_questions; ?></div>
                    <div class="stat-label">Total</div>
                  </div>
                </div>
              </div>
              
              <div class="feedback-container">
                <?php foreach ($questions as $index => $question): ?>
                  <?php 
                  $user_answer_index = $user_answers[$index] ?? null;
                  $is_correct = ($user_answer_index !== null && $user_answer_index == $question['correct_option']);
                  ?>
                  <div class="feedback-item <?php echo $is_correct ? 'correct' : 'incorrect'; ?> fade-in-up">
                    <div class="question-number">Q<?php echo $index + 1; ?></div>
                    <div class="question-text">
                      <?php echo htmlspecialchars($question['question']); ?>
                    </div>
                    
                    <div class="answer-grid">
                      <div class="answer-card user-answer <?php echo $is_correct ? 'correct' : 'incorrect'; ?>">
                        <div class="answer-label">
                          <i class="fas fa-user"></i>
                          Your Answer:
                          <span class="answer-icon"><?php echo $is_correct ? '✓' : '✗'; ?></span>
                        </div>
                        <div class="answer-text">
                          <?php 
                          if ($user_answer_index !== null) {
                            echo htmlspecialchars($question['option' . $user_answer_index]);
                          } else {
                            echo '<span style="color: var(--muted);">Not answered</span>';
                          }
                          ?>
                        </div>
                      </div>
                      
                      <?php if (!$is_correct): ?>
                        <div class="answer-card correct-answer">
                          <div class="answer-label">
                            <i class="fas fa-check"></i>
                            Correct Answer:
                            <span class="answer-icon">✓</span>
                          </div>
                          <div class="answer-text">
                            <?php echo htmlspecialchars($question['option' . $question['correct_option']]); ?>
                          </div>
                        </div>
                      <?php endif; ?>
                    </div>
                  </div>
                <?php endforeach; ?>
              </div>
            </div>
            
            <div class="action-buttons">
              <a href="index.php" class="btn primary">
                <i class="fas fa-redo"></i>
                Take Another Quiz
              </a>
              <a href="index.php#quiz" class="btn secondary">
                <i class="fas fa-home"></i>
                Back to Home
              </a>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>

<?php include 'footer.php'; ?>

  <script>
    // Set current year in footer
    document.getElementById('year').textContent = new Date().getFullYear();
    
    // Navbar scroll effect
    window.addEventListener('scroll', function() {
      const navbar = document.getElementById('navbar');
      if (window.scrollY > 50) {
        navbar.classList.add('scrolled');
      } else {
        navbar.classList.remove('scrolled');
      }
    });
    
    // Animation on scroll
    const observerOptions = {
      threshold: 0.1,
      rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.style.opacity = "1";
          entry.target.style.transform = "translateY(0)";
        }
      });
    }, observerOptions);
    
    // Observe all fade-in-up elements
    document.querySelectorAll('.fade-in-up').forEach(el => {
      el.style.opacity = "0";
      el.style.transform = "translateY(30px)";
      el.style.transition = "opacity 0.8s ease, transform 0.8s ease";
      observer.observe(el);
    });
    
    // Add delays for staggered animations
    document.querySelectorAll('.delay-1').forEach(el => {
      el.style.transitionDelay = "0.2s";
    });
    
    document.querySelectorAll('.delay-2').forEach(el => {
      el.style.transitionDelay = "0.4s";
    });
  </script>
</body>
</html>