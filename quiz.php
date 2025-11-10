
<?php
session_start();
require_once 'config.php';

// Check if quiz session exists
if (!isset($_SESSION['quiz_session'])) {
    header('Location: index.php');
    exit;
}

$quiz_session = $_SESSION['quiz_session'];
$current_question_index = $quiz_session['current_question'];
$questions = $quiz_session['questions'];
$user_answers = $quiz_session['user_answers'];

// Handle answer submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['answer']) && $_POST['answer'] !== '') {
        $user_answer = (int)$_POST['answer'];
        $user_answers[$current_question_index] = $user_answer;
        
        // Update session
        $_SESSION['quiz_session']['user_answers'] = $user_answers;
        
        // Move to next question or finish quiz
        if ($current_question_index < count($questions) - 1) {
            $_SESSION['quiz_session']['current_question']++;
            header('Location: quiz.php');
            exit;
        } else {
            // Calculate score and save to database
            $score = 0;
            $pdo = getDBConnection();
            
            // Calculate score first
            foreach ($questions as $index => $question) {
                $user_answer = $user_answers[$index] ?? null;
                // Debug: Check if answers are being compared correctly
                error_log("Question ID: " . $question['id'] . ", Correct: " . $question['correct_option'] . ", User: " . $user_answer);
                
                if ($user_answer !== null && $user_answer == $question['correct_option']) {
                    $score++;
                }
            }
            
            // Save quiz session
            $stmt = $pdo->prepare("INSERT INTO quiz_sessions (session_id, category_id, difficulty, total_questions, score, completed) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([
                $quiz_session['session_id'],
                $quiz_session['category_id'] === 'all' ? null : $quiz_session['category_id'],
                $quiz_session['difficulty'],
                count($questions),
                $score,
                true
            ]);
            
            // Save user answers
            foreach ($questions as $index => $question) {
                $user_answer = $user_answers[$index] ?? null;
                $is_correct = ($user_answer !== null && $user_answer == $question['correct_option']);
                
                $stmt = $pdo->prepare("INSERT INTO user_answers (session_id, question_id, user_answer, is_correct) VALUES (?, ?, ?, ?)");
                $stmt->execute([
                    $quiz_session['session_id'],
                    $question['id'],
                    $user_answer,
                    $is_correct ? 1 : 0
                ]);
            }
            
            // Store results in session for results page
            $_SESSION['quiz_results'] = [
                'score' => $score,
                'total_questions' => count($questions),
                'questions' => $questions,
                'user_answers' => $user_answers,
                'session_id' => $quiz_session['session_id']
            ];
            
            // Redirect to results page
            header('Location: results.php');
            exit;
        }
    } else {
        // No answer selected, show error
        $error = "Please select an answer before proceeding.";
    }
    
    // Handle navigation
    if (isset($_POST['prev_question']) && $current_question_index > 0) {
        $_SESSION['quiz_session']['current_question']--;
        header('Location: quiz.php');
        exit;
    }
}

$current_question = $questions[$current_question_index];
$progress = (($current_question_index + 1) / count($questions)) * 100;

// Get category name
$pdo = getDBConnection();
$category_name = "All Categories";
if ($quiz_session['category_id'] !== 'all') {
    $stmt = $pdo->prepare("SELECT name FROM categories WHERE id = ?");
    $stmt->execute([$quiz_session['category_id']]);
    $category = $stmt->fetch(PDO::FETCH_ASSOC);
    $category_name = $category ? $category['name'] : "All Categories";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Quiz Challenge - QuizMaster</title>
  
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

    /* Main Quiz Section */
    .quiz-section {
      padding: 8rem 0 4rem;
      min-height: 100vh;
      display: flex;
      align-items: center;
      position: relative;
    }

    .quiz-section::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 1000" opacity="0.03"><polygon fill="white" points="0,1000 1000,0 1000,1000"/></svg>');
      background-size: cover;
    }

    .quiz-container {
      width: 100%;
      max-width: 900px;
      margin: 0 auto;
      position: relative;
      z-index: 2;
    }

    .quiz-card {
      background: white;
      border-radius: var(--border-radius-lg);
      box-shadow: var(--box-shadow-lg);
      padding: 3rem;
      transition: var(--transition);
      border: 1px solid rgba(255, 255, 255, 0.2);
      backdrop-filter: blur(10px);
    }

    .quiz-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 25px 60px rgba(0, 0, 0, 0.2);
    }

    /* Quiz Header */
    .quiz-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 2rem;
      padding-bottom: 1.5rem;
      border-bottom: 2px solid #f1f3f9;
    }

    .quiz-info {
      display: flex;
      gap: 3rem;
    }

    .quiz-info-item {
      display: flex;
      flex-direction: column;
    }

    .quiz-info-label {
      font-size: 0.875rem;
      color: var(--muted);
      margin-bottom: 0.5rem;
      font-weight: 500;
      display: flex;
      align-items: center;
      gap: 0.5rem;
    }

    .quiz-info-value {
      font-weight: 700;
      color: var(--dark);
      font-size: 1.1rem;
    }

    /* Progress Bar */
    .progress-container {
      margin-bottom: 2.5rem;
      background: white;
      padding: 1.5rem;
      border-radius: var(--border-radius);
      box-shadow: var(--box-shadow);
      border: 1px solid #f1f3f9;
    }

    .progress-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 1rem;
    }

    .progress-label {
      font-size: 0.9rem;
      color: var(--muted);
      font-weight: 600;
    }

    .progress-count {
      font-weight: 700;
      color: var(--primary);
      font-size: 1rem;
    }

    .progress-bar-container {
      width: 100%;
      height: 12px;
      background: linear-gradient(135deg, #f1f3f9 0%, #e9ecef 100%);
      border-radius: 10px;
      overflow: hidden;
      position: relative;
    }

    .progress-bar {
      height: 100%;
      background: var(--gradient);
      border-radius: 10px;
      transition: width 0.8s cubic-bezier(0.22, 0.61, 0.36, 1);
      position: relative;
      box-shadow: 0 2px 10px rgba(67, 97, 238, 0.3);
    }

    .progress-bar::after {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
      animation: shimmer 2s infinite;
    }

    @keyframes shimmer {
      0% { transform: translateX(-100%); }
      100% { transform: translateX(100%); }
    }

    /* Question Section */
    .question-container {
      margin-bottom: 2.5rem;
    }

    .question-number {
      color: var(--primary);
      font-weight: 700;
      margin-bottom: 1rem;
      font-size: 1rem;
      display: flex;
      align-items: center;
      gap: 0.5rem;
      background: rgba(67, 97, 238, 0.1);
      padding: 0.5rem 1rem;
      border-radius: var(--border-radius);
      display: inline-block;
    }

    .question-text {
      font-size: 1.4rem;
      font-weight: 700;
      margin-bottom: 2rem;
      line-height: 1.4;
      color: var(--dark);
      background: white;
      padding: 1.5rem;
      border-radius: var(--border-radius);
      border-left: 4px solid var(--primary);
      box-shadow: var(--box-shadow);
    }

    /* Options */
    .options-list {
      list-style: none;
      display: grid;
      gap: 1rem;
    }

    .option {
      background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
      padding: 1.5rem 1.5rem;
      border-radius: var(--border-radius);
      cursor: pointer;
      transition: var(--transition);
      border: 2px solid transparent;
      display: flex;
      align-items: center;
      position: relative;
      overflow: hidden;
    }

    .option::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(67, 97, 238, 0.1), transparent);
      transition: 0.5s;
    }

    .option:hover::before {
      left: 100%;
    }

    .option:hover {
      background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
      border-color: var(--primary);
      transform: translateY(-3px);
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }

    .option.selected {
      background: var(--gradient);
      color: white;
      border-color: var(--secondary);
      transform: translateY(-2px);
      box-shadow: 0 15px 30px rgba(67, 97, 238, 0.3);
    }

    .option-label {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      width: 40px;
      height: 40px;
      background: rgba(255, 255, 255, 0.2);
      border-radius: 50%;
      margin-right: 1.5rem;
      font-weight: 700;
      font-size: 1.1rem;
      border: 2px solid rgba(255, 255, 255, 0.3);
      flex-shrink: 0;
    }

    .option.selected .option-label {
      background: rgba(255, 255, 255, 0.3);
      border-color: rgba(255, 255, 255, 0.5);
    }

    .option-text {
      font-weight: 500;
      font-size: 1.05rem;
    }

    /* Quiz Footer */
    .quiz-footer {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-top: 3rem;
      padding-top: 2rem;
      border-top: 2px solid #f1f3f9;
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

    .btn.ghost {
      background: transparent;
      color: var(--primary);
      border: 2px solid var(--primary);
    }

    .btn.ghost:hover {
      background: rgba(67, 97, 238, 0.1);
      transform: translateY(-3px);
      box-shadow: 0 10px 25px rgba(67, 97, 238, 0.2);
    }

    .btn:disabled {
      background: #e9ecef;
      color: #adb5bd;
      cursor: not-allowed;
      transform: none;
      box-shadow: none;
      border-color: #e9ecef;
    }

    .btn:disabled:hover {
      transform: none;
      box-shadow: none;
    }

    .btn:disabled::before {
      display: none;
    }

    .btn-finish {
      background: linear-gradient(135deg, var(--success), #3a9fb6);
      box-shadow: 0 10px 30px rgba(76, 201, 240, 0.3);
    }

    .btn-finish:hover {
      background: linear-gradient(135deg, #3a9fb6, var(--success));
      box-shadow: 0 15px 40px rgba(76, 201, 240, 0.4);
    }

    /* Error Message */
    .error {
      background: linear-gradient(135deg, #ffe6e6, #ffcccc);
      color: var(--danger);
      padding: 1.2rem 1.5rem;
      border-radius: var(--border-radius);
      margin-bottom: 2rem;
      text-align: center;
      border-left: 4px solid var(--danger);
      box-shadow: var(--box-shadow);
      font-weight: 600;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 0.7rem;
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

    /* Timer */
    .timer-container {
      background: white;
      padding: 1rem 1.5rem;
      border-radius: var(--border-radius);
      box-shadow: var(--box-shadow);
      display: inline-flex;
      align-items: center;
      gap: 0.7rem;
      margin-bottom: 1.5rem;
      border: 2px solid #f1f3f9;
    }

    .timer-label {
      font-weight: 600;
      color: var(--muted);
    }

    .timer-value {
      font-weight: 700;
      color: var(--primary);
      font-size: 1.1rem;
    }

    /* Responsive */
    @media (max-width: 968px) {
      .quiz-header {
        flex-direction: column;
        gap: 1.5rem;
        align-items: flex-start;
      }
      
      .quiz-info {
        flex-direction: column;
        gap: 1rem;
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
      
      .quiz-footer {
        flex-direction: column;
        gap: 1.2rem;
      }
      
      .btn {
        width: 100%;
        justify-content: center;
      }
      
      .question-text {
        font-size: 1.2rem;
      }
      
      .option {
        padding: 1.2rem 1.2rem;
      }
      
      .quiz-card {
        padding: 2rem;
        margin: 1rem;
      }
      
      .quiz-section {
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
  </style>
</head>
<body>
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
    <section class="quiz-section">
      <div class="container">
        <div class="quiz-container">
          <div class="quiz-card fade-in-up">
            <?php if (isset($error)): ?>
              <div class="error">
                <i class="fas fa-exclamation-circle"></i>
                <?php echo htmlspecialchars($error); ?>
              </div>
            <?php endif; ?>
            
            <!-- Timer -->
            <div class="timer-container">
              <i class="fas fa-clock timer-label"></i>
              <span class="timer-label">Time Elapsed:</span>
              <span class="timer-value" id="quiz-timer">00:00</span>
            </div>
            
            <div class="quiz-header">
              <div class="quiz-info">
                <div class="quiz-info-item">
                  <span class="quiz-info-label">
                    <i class="fas fa-folder"></i>
                    Category
                  </span>
                  <span class="quiz-info-value"><?php echo htmlspecialchars($category_name); ?></span>
                </div>
                <!-- <div class="quiz-info-item">
                  <span class="quiz-info-label">
                    <i class="fas fa-sliders-h"></i>
                    Difficulty
                  </span>
                  <span class="quiz-info-value"><?php echo ucfirst($quiz_session['difficulty']); ?></span>
                </div> -->
              </div>
              <div class="quiz-info-item">
                <span class="quiz-info-label">
                   <i class="fas fa-sliders-h"></i>
                    Difficulty
                  </span>
                <span class="quiz-info-value"><?php echo ucfirst($quiz_session['difficulty']); ?></span>
              </div>
            </div>
            
            <div class="progress-container">
              <div class="progress-header">
                <span class="progress-label">
                  <i class="fas fa-chart-line"></i>
                  Quiz Progress
                </span>
                <span class="progress-count"><?php echo $current_question_index + 1; ?> of <?php echo count($questions); ?></span>
              </div>
              <div class="progress-bar-container">
                <div class="progress-bar" style="width: <?php echo $progress; ?>%"></div>
              </div>
            </div>
            
            <form method="POST" action="" id="quiz-form">
              <div class="question-container">
                <div class="question-number">
                  <i class="fas fa-question-circle"></i>
                  Question <?php echo $current_question_index + 1; ?>
                </div>
                <div class="question-text">
                  <?php echo htmlspecialchars($current_question['question']); ?>
                </div>
                
                <ul class="options-list">
                  <?php for ($i = 1; $i <= 4; $i++): ?>
                    <li class="option <?php echo (isset($user_answers[$current_question_index]) && $user_answers[$current_question_index] == $i) ? 'selected' : ''; ?>"
                        onclick="selectOption(<?php echo $i; ?>)">
                      <span class="option-label"><?php echo chr(64 + $i); ?></span>
                      <span class="option-text"><?php echo htmlspecialchars($current_question['option' . $i]); ?></span>
                    </li>
                  <?php endfor; ?>
                </ul>
                
                <input type="hidden" name="answer" id="selected-answer" value="<?php echo isset($user_answers[$current_question_index]) ? $user_answers[$current_question_index] : ''; ?>">
              </div>
              
              <div class="quiz-footer">
                <button type="submit" name="prev_question" class="btn ghost" <?php echo $current_question_index === 0 ? 'disabled' : ''; ?>>
                  <i class="fas fa-arrow-left"></i>
                  Previous Question
                </button>
                <button type="submit" class="btn primary <?php echo $current_question_index === count($questions) - 1 ? 'btn-finish' : ''; ?>">
                  <?php if ($current_question_index === count($questions) - 1): ?>
                    <i class="fas fa-flag-checkered"></i>
                    Finish Quiz
                  <?php else: ?>
                    <i class="fas fa-arrow-right"></i>
                    Next Question
                  <?php endif; ?>
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </section>
  </main>

<?php include 'footer.php'; ?>

  <script>
    function selectOption(optionIndex) {
      // Remove selected class from all options
      const options = document.querySelectorAll('.option');
      options.forEach(option => option.classList.remove('selected'));
      
      // Add selected class to clicked option
      event.currentTarget.classList.add('selected');
      
      // Update hidden input
      document.getElementById('selected-answer').value = optionIndex;
      
      // Enable the submit button if it was disabled
      const submitButton = document.querySelector('button[type="submit"]:not([name="prev_question"])');
      if (submitButton.disabled) {
        submitButton.disabled = false;
      }
    }
    
    // Timer functionality
    let startTime = Date.now();
    const timerElement = document.getElementById('quiz-timer');
    
    function updateTimer() {
      const elapsed = Date.now() - startTime;
      const minutes = Math.floor(elapsed / 60000);
      const seconds = Math.floor((elapsed % 60000) / 1000);
      timerElement.textContent = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
    }
    
    // Initialize selection and timer on page load
    document.addEventListener('DOMContentLoaded', function() {
      const selectedValue = document.getElementById('selected-answer').value;
      if (selectedValue) {
        const options = document.querySelectorAll('.option');
        options.forEach(option => {
          if (option.getAttribute('onclick').includes(selectedValue)) {
            option.classList.add('selected');
          }
        });
      }
      
      // Set current year in footer
      document.getElementById('year').textContent = new Date().getFullYear();
      
      // Start timer
      setInterval(updateTimer, 1000);
    });
    
    // Navbar scroll effect
    window.addEventListener('scroll', function() {
      const navbar = document.getElementById('navbar');
      if (window.scrollY > 50) {
        navbar.classList.add('scrolled');
      } else {
        navbar.classList.remove('scrolled');
      }
    });
  </script>
</body>
</html>