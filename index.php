
<?php
session_start();
require_once 'config.php';

// Get categories for dropdown
$pdo = getDBConnection();
$categories = $pdo->query("SELECT * FROM categories")->fetchAll(PDO::FETCH_ASSOC);

// Handle form submission to start quiz
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['start_quiz'])) {
    $category_id = $_POST['category'];
    $difficulty = $_POST['difficulty'];
    
    // Generate session ID
    $session_id = generateSessionId();
    
    // Get questions based on selection
    $query = "SELECT * FROM questions WHERE 1=1";
    $params = [];
    
    if ($category_id !== 'all') {
        $query .= " AND category_id = ?";
        $params[] = $category_id;
    }
    
    if ($difficulty !== 'all') {
        $query .= " AND difficulty = ?";
        $params[] = $difficulty;
    }
    
    $stmt = $pdo->prepare($query);
    $stmt->execute($params);
    $questions = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if (count($questions) === 0) {
        $error = "No questions available for the selected category and difficulty.";
    } else {
        // Shuffle questions
        shuffle($questions);
        
        // Limit to 10 questions
        $questions = array_slice($questions, 0, 10);
        
        // Store quiz data in session
        $_SESSION['quiz_session'] = [
            'session_id' => $session_id,
            'category_id' => $category_id,
            'difficulty' => $difficulty,
            'questions' => $questions,
            'current_question' => 0,
            'user_answers' => [],
            'started_at' => date('Y-m-d H:i:s')
        ];
        
        // Redirect to quiz page
        header('Location: quiz.php');
        exit;
    }
}

// Get some stats for the dashboard
$total_questions = $pdo->query("SELECT COUNT(*) as count FROM questions")->fetch()['count'];
$total_categories = $pdo->query("SELECT COUNT(*) as count FROM categories")->fetch()['count'];
$total_quizzes = $pdo->query("SELECT COUNT(*) as count FROM quiz_sessions")->fetch()['count'];
?>
<?php include 'header.php'; ?>
  <main>
    <!-- Hero -->
    <section id="hero" class="hero">
      <div class="container hero-grid">
        <div class="hero-left fade-in-up">
          <h1>Quiz Application</h1>
          <p class="muted">
           A quiz application built using PHP, MySQL, and JavaScript with a responsive and user-friendly interface.
          </p>
          <div class="cta-row">
            <a href="#quiz" class="btn primary">
              <i class="fas fa-play-circle"></i>
              Try Live Demo
            </a>
            <a href="#contact" class="btn secondary">
              <i class="fas fa-envelope"></i>
              Contact Me
            </a>
          </div>
          
          <div class="stats">
            <div class="stat-card fade-in-up delay-1">
              <div class="stat-number"><?php echo $total_questions; ?></div>
              <div class="stat-label">Questions</div>
            </div>
            <div class="stat-card fade-in-up delay-2">
              <div class="stat-number"><?php echo $total_categories; ?></div>
              <div class="stat-label">Categories</div>
            </div>
            <div class="stat-card fade-in-up delay-3">
              <div class="stat-number"><?php echo $total_quizzes; ?>+</div>
              <div class="stat-label">Quizzes Taken</div>
            </div>
          </div>
        </div>

        <div class="hero-right fade-in-up delay-1">
          <div class="card">
            <h3>Featured Project</h3>
            <p>Interactive quiz platform with real-time scoring, multiple categories, and difficulty levels. Built as a full-stack web application.</p>
            <div class="project-stats">
              <div><strong>PHP</strong><span><i class="fas fa-check"></i></span></div>
              <div><strong>MySQL</strong><span><i class="fas fa-check"></i></span></div>
              <div><strong>JavaScript</strong><span><i class="fas fa-check"></i></span></div>
            </div>
            <a href="#quiz" class="btn small primary">
              <i class="fas fa-rocket"></i>
              Launch Demo
            </a>
          </div>
        </div>
      </div>
    </section>

    <!-- About -->
    <section id="about" class="section section-light">
      <div class="container">
        <div class="section-header fade-in-up">
          <h2>About This Project</h2>
          <p class="muted">A comprehensive full-stack web application demonstrating modern development practices and clean code architecture.</p>
        </div>
        
        <div class="features-grid">
          <div class="feature-card fade-in-up">
            <div class="feature-icon">
              <i class="fas fa-code"></i>
            </div>
            <h3>Clean Architecture</h3>
            <p>Built with separation of concerns, MVC patterns, and organized code structure for maintainability and scalability.</p>
          </div>
          
          <div class="feature-card fade-in-up delay-1">
            <div class="feature-icon">
              <i class="fas fa-database"></i>
            </div>
            <h3>Database Design</h3>
            <p>Efficient MySQL database design with proper relationships, indexes, and optimized queries for performance.</p>
          </div>
          
          <div class="feature-card fade-in-up delay-2">
            <div class="feature-icon">
              <i class="fas fa-mobile-alt"></i>
            </div>
            <h3>Responsive Design</h3>
            <p>Fully responsive interface that works seamlessly across all devices from mobile to desktop.</p>
          </div>
        </div>
      </div>
    </section>

    <!-- Features -->
    <section id="features" class="section">
      <div class="container">
        <div class="section-header fade-in-up">
          <h2>Application Features</h2>
          <p class="muted">Comprehensive functionality showcasing full-stack development capabilities</p>
        </div>
        
        <div class="features-grid">
          <div class="feature-card fade-in-up">
            <div class="feature-icon">
              <i class="fas fa-layer-group"></i>
            </div>
            <h3>Multiple Categories</h3>
            <p>Diverse question categories including Web Development, Mathematics, Science, Programming, and General Knowledge.</p>
          </div>
          
          <div class="feature-card fade-in-up delay-1">
            <div class="feature-icon">
              <i class="fas fa-sliders-h"></i>
            </div>
            <h3>Adjustable Difficulty</h3>
            <p>Three difficulty levels (Easy, Medium, Hard) to accommodate users with different knowledge levels.</p>
          </div>
          
          <div class="feature-card fade-in-up delay-2">
            <div class="feature-icon">
              <i class="fas fa-chart-line"></i>
            </div>
            <h3>Progress Tracking</h3>
            <p>Real-time scoring, performance analytics, and detailed results with question-by-question feedback.</p>
          </div>
        </div>
      </div>
    </section>

    <!-- Technology Stack -->
    <section id="tech" class="section section-dark">
      <div class="container">
        <div class="section-header fade-in-up">
          <h2>Technology Stack</h2>
          <p class="muted">Modern technologies and tools used in building this application</p>
        </div>
        
        <div class="tech-stack">
          <div class="tech-item fade-in-up">
            <div class="tech-icon">
              <i class="fab fa-php"></i>
            </div>
            <div class="tech-name">PHP</div>
          </div>
          
          <div class="tech-item fade-in-up delay-1">
            <div class="tech-icon">
              <i class="fas fa-database"></i>
            </div>
            <div class="tech-name">MySQL</div>
          </div>
          
          <div class="tech-item fade-in-up delay-2">
            <div class="tech-icon">
              <i class="fab fa-js-square"></i>
            </div>
            <div class="tech-name">JavaScript</div>
          </div>
          
          <div class="tech-item fade-in-up delay-3">
            <div class="tech-icon">
              <i class="fab fa-html5"></i>
            </div>
            <div class="tech-name">HTML5</div>
          </div>
          
          <div class="tech-item fade-in-up">
            <div class="tech-icon">
              <i class="fab fa-css3-alt"></i>
            </div>
            <div class="tech-name">CSS3</div>
          </div>
        </div>
      </div>
    </section>

    <!-- Quiz App -->
    <section id="quiz" class="section section-light">
      <div class="container">
        <div class="section-header fade-in-up">
          <h2>Live Demo</h2>
          <p class="muted">Experience the application firsthand. Select your preferences and start the quiz!</p>
        </div>

        <div class="quiz-app">
          <div class="quiz-card fade-in-up">
            <div class="quiz-header">
              <h3><i class="fas fa-rocket"></i> QuizMaster Challenge</h3>
              <p>Test your knowledge with our interactive quiz platform</p>
            </div>
            
            <?php if (isset($error)): ?>
              <div class="error"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
            
            <form method="POST" action="">
              <div class="options-container">
                <div class="option-group">
                  <label for="category">
                    <i class="fas fa-folder-open"></i> Select Category:
                  </label>
                  <select id="category" name="category" required>
                    <option value="all">All Categories</option>
                    <?php foreach ($categories as $category): ?>
                      <option value="<?php echo $category['id']; ?>">
                        <?php echo htmlspecialchars($category['name']); ?>
                      </option>
                    <?php endforeach; ?>
                  </select>
                </div>
                
                <div class="option-group">
                  <label for="difficulty">
                    <i class="fas fa-sliders-h"></i> Select Difficulty:
                  </label>
                  <select id="difficulty" name="difficulty" required>
                    <option value="all">All Levels</option>
                    <option value="easy">Easy</option>
                    <option value="medium">Medium</option>
                    <option value="hard">Hard</option>
                  </select>
                </div>
              </div>
              
              <button type="submit" name="start_quiz" class="btn primary">
                <i class="fas fa-play"></i>
                Start Quiz Now
              </button>
            </form>
          </div>
        </div>
      </div>
    </section>

    <!-- Contact -->
    <section id="contact" class="section">
      <div class="container">
        <div class="section-header fade-in-up">
          <h2>Let's Connect</h2>
          <p class="muted">Interested in my work? Feel free to reach out for opportunities or collaboration</p>
        </div>
        
        <div class="contact-grid">
          <div class="contact-info fade-in-up">
            <div class="contact-item">
              <div class="contact-icon">
                <i class="fas fa-envelope"></i>
              </div>
              <div class="contact-details">
                <h4>Email</h4>
                <p>nambinandhini001@gmail.com</p>
              </div>
            </div>
            
            <div class="contact-item">
              <div class="contact-icon">
                <i class="fas fa-phone"></i>
              </div>
              <div class="contact-details">
                <h4>Phone</h4>
                <p>+91 9025772487</p>
              </div>
            </div>
            
            <div class="contact-item">
              <div class="contact-icon">
                <i class="fab fa-github"></i>
              </div>
              <div class="contact-details">
                <h4>GitHub</h4>
                <p>https://github.com/NambiNandhini/Quiz-app</p>
              </div>
            </div>
            
            <div class="contact-item">
              <div class="contact-icon">
                <i class="fab fa-linkedin"></i>
              </div>
              <div class="contact-details">
                <h4>LinkedIn</h4>
                <p>https://www.linkedin.com/in/nambi-nandhini</p>
              </div>
            </div>
          </div>
          
          <div class="card fade-in-up delay-1">
            <h3>About the Developer</h3>
            <p>Passionate full-stack developer with expertise in modern web technologies. This QuizMaster application demonstrates proficiency in:</p>
            <ul style="margin: 1rem 0; padding-left: 1.5rem; color: var(--muted);">
              <li>Backend development with PHP and MySQL</li>
              <li>Frontend development with JavaScript, HTML5, and CSS3</li>
              <li>Database design and optimization</li>
              <li>Responsive UI/UX design</li>
              <li>Session management and user experience</li>
            </ul>
          </div>
        </div>
      </div>
    </section>
  </main>

 <?php include 'footer.php'; ?>

  <script>
 
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
  </script>
</body>

</html>