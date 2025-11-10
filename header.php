
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
   <title>QuizMaster - Professional Quiz Platform</title>
  <meta name="description" content="Interactive quiz platform built with PHP, MySQL, and JavaScript. Showcasing full-stack web development skills.">
  
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
      background-color: #f8fafc;
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

    /* Hero Section */
    .hero {
      padding: 10rem 0 6rem;
      background: var(--gradient);
      color: white;
      position: relative;
      overflow: hidden;
    }

    .hero::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 1000" opacity="0.05"><polygon fill="white" points="0,1000 1000,0 1000,1000"/></svg>');
      background-size: cover;
    }

    .hero-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 4rem;
      align-items: center;
      position: relative;
      z-index: 2;
    }

    .hero h1 {
      font-size: 3.5rem;
      margin-bottom: 1.5rem;
      line-height: 1.1;
      font-weight: 800;
    }

    .hero .muted {
      color: rgba(255, 255, 255, 0.85);
      margin-bottom: 2rem;
      font-size: 1.2rem;
      font-weight: 400;
    }

    .cta-row {
      display: flex;
      gap: 1.2rem;
      margin-top: 2.5rem;
    }

    /* Stats */
    .stats {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 1.5rem;
      margin-top: 3rem;
    }

    .stat-card {
      background: rgba(255, 255, 255, 0.1);
      backdrop-filter: blur(10px);
      border-radius: var(--border-radius);
      padding: 1.5rem;
      text-align: center;
      border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .stat-number {
      font-size: 2.5rem;
      font-weight: 800;
      margin-bottom: 0.5rem;
    }

    .stat-label {
      font-size: 0.9rem;
      opacity: 0.9;
    }

    /* Buttons */
    .btn {
      padding: 1rem 2rem;
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
      background-color: white;
      color: var(--primary);
      box-shadow: 0 10px 30px rgba(255, 255, 255, 0.2);
    }

    .btn.primary:hover {
      transform: translateY(-5px);
      box-shadow: 0 15px 40px rgba(255, 255, 255, 0.3);
    }

    .btn.secondary {
      background: rgba(255, 255, 255, 0.15);
      backdrop-filter: blur(10px);
      color: white;
      border: 1px solid rgba(255, 255, 255, 0.3);
    }

    .btn.secondary:hover {
      background: rgba(255, 255, 255, 0.25);
      transform: translateY(-5px);
    }

    /* Card */
    .card {
      background-color: white;
      border-radius: var(--border-radius-lg);
      box-shadow: var(--box-shadow);
      padding: 2.5rem;
      color: var(--dark);
      transition: var(--transition);
      border: 1px solid rgba(0, 0, 0, 0.05);
      height: 100%;
    }

    .card:hover {
      transform: translateY(-10px);
      box-shadow: var(--box-shadow-lg);
    }

    .card h3 {
      margin-bottom: 1rem;
      color: var(--primary);
      font-size: 1.4rem;
    }

    .card p {
      margin-bottom: 1.5rem;
      color: var(--muted);
      line-height: 1.7;
    }

    .project-stats {
      display: flex;
      gap: 1.5rem;
      margin-bottom: 1.5rem;
    }

    .project-stats div {
      display: flex;
      align-items: center;
      gap: 0.5rem;
      font-weight: 600;
    }

    .project-stats span {
      color: var(--success);
    }

    .btn.small {
      padding: 0.8rem 1.5rem;
      font-size: 0.9rem;
    }

    /* Sections */
    .section {
      padding: 6rem 0;
    }

    .section-header {
      text-align: center;
      margin-bottom: 4rem;
    }

    .section-header h2 {
      font-size: 2.5rem;
      margin-bottom: 1rem;
      color: var(--dark);
      font-weight: 800;
    }

    .section-header .muted {
      color: var(--muted);
      font-size: 1.2rem;
      max-width: 600px;
      margin: 0 auto;
    }

    .section-light {
      background-color: white;
    }

    .section-dark {
      background: var(--dark-blue);
      color: white;
    }

    .section-dark .section-header h2 {
      color: white;
    }

    .section-dark .section-header .muted {
      color: rgba(255, 255, 255, 0.8);
    }

    /* Features Grid */
    .features-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
      gap: 2.5rem;
    }

    .feature-card {
      background: white;
      border-radius: var(--border-radius-lg);
      box-shadow: var(--box-shadow);
      padding: 2.5rem 2rem;
      text-align: center;
      transition: var(--transition);
      border: 1px solid rgba(0, 0, 0, 0.05);
    }

    .feature-card:hover {
      transform: translateY(-10px);
      box-shadow: var(--box-shadow-lg);
    }

    .feature-icon {
      width: 70px;
      height: 70px;
      background: var(--gradient-light);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto 1.5rem;
      font-size: 1.8rem;
      color: white;
    }

    .feature-card h3 {
      color: var(--dark);
      margin-bottom: 1rem;
      font-size: 1.3rem;
    }

    .feature-card p {
      color: var(--muted);
      line-height: 1.7;
    }

    /* Tech Stack */
    .tech-stack {
      display: flex;
      justify-content: center;
      flex-wrap: wrap;
      gap: 2rem;
      margin-top: 3rem;
    }

    .tech-item {
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 0.8rem;
    }

    .tech-icon {
      width: 80px;
      height: 80px;
      background: white;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 2rem;
      color: var(--primary);
      box-shadow: var(--box-shadow);
    }

    .tech-name {
      font-weight: 600;
      color: white;
    }

    /* Quiz Section */
    .quiz-app {
      max-width: 700px;
      margin: 0 auto;
    }

    .quiz-card {
      background: white;
      border-radius: var(--border-radius-lg);
      box-shadow: var(--box-shadow-lg);
      padding: 3rem;
      text-align: center;
    }

    .quiz-header {
      margin-bottom: 2rem;
    }

    .quiz-header h3 {
      font-size: 1.8rem;
      color: var(--primary);
      margin-bottom: 0.5rem;
    }

    .quiz-header p {
      color: var(--muted);
    }

    .error {
      background-color: #ffe6e6;
      color: var(--danger);
      padding: 1rem;
      border-radius: var(--border-radius);
      margin-bottom: 1.5rem;
      text-align: center;
      border-left: 4px solid var(--danger);
    }

    .options-container {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 1.5rem;
      margin-bottom: 2.5rem;
    }

    .option-group {
      text-align: left;
    }

    .option-group label {
      display: block;
      margin-bottom: 0.8rem;
      font-weight: 600;
      color: var(--dark);
    }

    select {
      width: 100%;
      padding: 1rem 1.2rem;
      border: 1px solid #e2e8f0;
      border-radius: var(--border-radius);
      font-size: 1rem;
      background-color: white;
      color: var(--dark);
      transition: var(--transition);
      appearance: none;
      background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
      background-repeat: no-repeat;
      background-position: right 1rem center;
      background-size: 1em;
    }

    select:focus {
      outline: none;
      border-color: var(--primary);
      box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.1);
    }

    /* Contact Section */
    .contact-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 4rem;
      align-items: start;
    }

    .contact-info {
      display: flex;
      flex-direction: column;
      gap: 1.5rem;
    }

    .contact-item {
      display: flex;
      align-items: center;
      gap: 1rem;
    }

    .contact-icon {
      width: 50px;
      height: 50px;
      background: var(--gradient);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      font-size: 1.2rem;
    }

    .contact-details h4 {
      margin-bottom: 0.3rem;
      color: var(--dark);
    }

    .contact-details p {
      color: var(--muted);
    }

    /* Footer */
    .footer {
      background: var(--dark-blue);
      color: white;
      text-align: center;
      padding: 3rem 0;
    }

    .footer-content {
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 1.5rem;
    }

    .footer-links {
      display: flex;
      gap: 2rem;
    }

    .footer-links a {
      color: rgba(255, 255, 255, 0.7);
      text-decoration: none;
      transition: var(--transition);
    }

    .footer-links a:hover {
      color: white;
    }

    /* Responsive */
    @media (max-width: 968px) {
      .hero-grid {
        grid-template-columns: 1fr;
        text-align: center;
        gap: 3rem;
      }
      
      .hero h1 {
        font-size: 2.8rem;
      }
      
      .contact-grid {
        grid-template-columns: 1fr;
        gap: 3rem;
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
      
      .options-container {
        grid-template-columns: 1fr;
      }
      
      .cta-row {
        flex-direction: column;
        align-items: center;
      }
      
      .stats {
        grid-template-columns: 1fr;
      }
      
      .features-grid {
        grid-template-columns: 1fr;
      }
      
      .section-header h2 {
        font-size: 2rem;
      }
      
      .hero {
        padding: 8rem 0 4rem;
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

    .delay-1 {
      animation-delay: 0.2s;
    }

    .delay-2 {
      animation-delay: 0.4s;
    }

    .delay-3 {
      animation-delay: 0.6s;
    }
  </style>
</head>
<body>
  <header class="nav" id="navbar">
    <div class="container nav-inner">
      <a class="brand" href="#">
        <i class="fas fa-brain"></i>
        QuizMaster
      </a>
      <nav class="nav-links">
        <a href="#about">About</a>
        <a href="#features">Features</a>
        <a href="#tech">Technology</a>
        <a href="#quiz">Demo</a>
        <a href="#contact">Contact</a>
      </nav>
    </div>
  </header>

=======
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>QuizMaster - Interactive Quiz Platform | Web Developer Portfolio</title>
  <meta name="description" content="Professional quiz application built with PHP, MySQL, and JavaScript. Showcasing full-stack web development skills with modern UI/UX design.">
  
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
      background-color: #f8fafc;
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

    /* Hero Section */
    .hero {
      padding: 10rem 0 6rem;
      background: var(--gradient);
      color: white;
      position: relative;
      overflow: hidden;
    }

    .hero::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 1000" opacity="0.05"><polygon fill="white" points="0,1000 1000,0 1000,1000"/></svg>');
      background-size: cover;
    }

    .hero-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 4rem;
      align-items: center;
      position: relative;
      z-index: 2;
    }

    .hero h1 {
      font-size: 3.5rem;
      margin-bottom: 1.5rem;
      line-height: 1.1;
      font-weight: 800;
    }

    .hero .muted {
      color: rgba(255, 255, 255, 0.85);
      margin-bottom: 2rem;
      font-size: 1.2rem;
      font-weight: 400;
    }

    .cta-row {
      display: flex;
      gap: 1.2rem;
      margin-top: 2.5rem;
    }

    /* Stats */
    .stats {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 1.5rem;
      margin-top: 3rem;
    }

    .stat-card {
      background: rgba(255, 255, 255, 0.1);
      backdrop-filter: blur(10px);
      border-radius: var(--border-radius);
      padding: 1.5rem;
      text-align: center;
      border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .stat-number {
      font-size: 2.5rem;
      font-weight: 800;
      margin-bottom: 0.5rem;
    }

    .stat-label {
      font-size: 0.9rem;
      opacity: 0.9;
    }

    /* Buttons */
    .btn {
      padding: 1rem 2rem;
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
      background-color: white;
      color: var(--primary);
      box-shadow: 0 10px 30px rgba(255, 255, 255, 0.2);
    }

    .btn.primary:hover {
      transform: translateY(-5px);
      box-shadow: 0 15px 40px rgba(255, 255, 255, 0.3);
    }

    .btn.secondary {
      background: rgba(255, 255, 255, 0.15);
      backdrop-filter: blur(10px);
      color: white;
      border: 1px solid rgba(255, 255, 255, 0.3);
    }

    .btn.secondary:hover {
      background: rgba(255, 255, 255, 0.25);
      transform: translateY(-5px);
    }

    /* Card */
    .card {
      background-color: white;
      border-radius: var(--border-radius-lg);
      box-shadow: var(--box-shadow);
      padding: 2.5rem;
      color: var(--dark);
      transition: var(--transition);
      border: 1px solid rgba(0, 0, 0, 0.05);
      height: 100%;
    }

    .card:hover {
      transform: translateY(-10px);
      box-shadow: var(--box-shadow-lg);
    }

    .card h3 {
      margin-bottom: 1rem;
      color: var(--primary);
      font-size: 1.4rem;
    }

    .card p {
      margin-bottom: 1.5rem;
      color: var(--muted);
      line-height: 1.7;
    }

    .project-stats {
      display: flex;
      gap: 1.5rem;
      margin-bottom: 1.5rem;
    }

    .project-stats div {
      display: flex;
      align-items: center;
      gap: 0.5rem;
      font-weight: 600;
    }

    .project-stats span {
      color: var(--success);
    }

    .btn.small {
      padding: 0.8rem 1.5rem;
      font-size: 0.9rem;
    }

    /* Sections */
    .section {
      padding: 6rem 0;
    }

    .section-header {
      text-align: center;
      margin-bottom: 4rem;
    }

    .section-header h2 {
      font-size: 2.5rem;
      margin-bottom: 1rem;
      color: var(--dark);
      font-weight: 800;
    }

    .section-header .muted {
      color: var(--muted);
      font-size: 1.2rem;
      max-width: 600px;
      margin: 0 auto;
    }

    .section-light {
      background-color: white;
    }

    .section-dark {
      background: var(--dark-blue);
      color: white;
    }

    .section-dark .section-header h2 {
      color: white;
    }

    .section-dark .section-header .muted {
      color: rgba(255, 255, 255, 0.8);
    }

    /* Features Grid */
    .features-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
      gap: 2.5rem;
    }

    .feature-card {
      background: white;
      border-radius: var(--border-radius-lg);
      box-shadow: var(--box-shadow);
      padding: 2.5rem 2rem;
      text-align: center;
      transition: var(--transition);
      border: 1px solid rgba(0, 0, 0, 0.05);
    }

    .feature-card:hover {
      transform: translateY(-10px);
      box-shadow: var(--box-shadow-lg);
    }

    .feature-icon {
      width: 70px;
      height: 70px;
      background: var(--gradient-light);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto 1.5rem;
      font-size: 1.8rem;
      color: white;
    }

    .feature-card h3 {
      color: var(--dark);
      margin-bottom: 1rem;
      font-size: 1.3rem;
    }

    .feature-card p {
      color: var(--muted);
      line-height: 1.7;
    }

    /* Tech Stack */
    .tech-stack {
      display: flex;
      justify-content: center;
      flex-wrap: wrap;
      gap: 2rem;
      margin-top: 3rem;
    }

    .tech-item {
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 0.8rem;
    }

    .tech-icon {
      width: 80px;
      height: 80px;
      background: white;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 2rem;
      color: var(--primary);
      box-shadow: var(--box-shadow);
    }

    .tech-name {
      font-weight: 600;
      color: white;
    }

    /* Quiz Section */
    .quiz-app {
      max-width: 700px;
      margin: 0 auto;
    }

    .quiz-card {
      background: white;
      border-radius: var(--border-radius-lg);
      box-shadow: var(--box-shadow-lg);
      padding: 3rem;
      text-align: center;
    }

    .quiz-header {
      margin-bottom: 2rem;
    }

    .quiz-header h3 {
      font-size: 1.8rem;
      color: var(--primary);
      margin-bottom: 0.5rem;
    }

    .quiz-header p {
      color: var(--muted);
    }

    .error {
      background-color: #ffe6e6;
      color: var(--danger);
      padding: 1rem;
      border-radius: var(--border-radius);
      margin-bottom: 1.5rem;
      text-align: center;
      border-left: 4px solid var(--danger);
    }

    .options-container {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 1.5rem;
      margin-bottom: 2.5rem;
    }

    .option-group {
      text-align: left;
    }

    .option-group label {
      display: block;
      margin-bottom: 0.8rem;
      font-weight: 600;
      color: var(--dark);
    }

    select {
      width: 100%;
      padding: 1rem 1.2rem;
      border: 1px solid #e2e8f0;
      border-radius: var(--border-radius);
      font-size: 1rem;
      background-color: white;
      color: var(--dark);
      transition: var(--transition);
      appearance: none;
      background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
      background-repeat: no-repeat;
      background-position: right 1rem center;
      background-size: 1em;
    }

    select:focus {
      outline: none;
      border-color: var(--primary);
      box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.1);
    }

    /* Contact Section */
    .contact-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 4rem;
      align-items: start;
    }

    .contact-info {
      display: flex;
      flex-direction: column;
      gap: 1.5rem;
    }

    .contact-item {
      display: flex;
      align-items: center;
      gap: 1rem;
    }

    .contact-icon {
      width: 50px;
      height: 50px;
      background: var(--gradient);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      font-size: 1.2rem;
    }

    .contact-details h4 {
      margin-bottom: 0.3rem;
      color: var(--dark);
    }

    .contact-details p {
      color: var(--muted);
    }

    /* Footer */
    .footer {
      background: var(--dark-blue);
      color: white;
      text-align: center;
      padding: 3rem 0;
    }

    .footer-content {
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 1.5rem;
    }

    .footer-links {
      display: flex;
      gap: 2rem;
    }

    .footer-links a {
      color: rgba(255, 255, 255, 0.7);
      text-decoration: none;
      transition: var(--transition);
    }

    .footer-links a:hover {
      color: white;
    }

    /* Responsive */
    @media (max-width: 968px) {
      .hero-grid {
        grid-template-columns: 1fr;
        text-align: center;
        gap: 3rem;
      }
      
      .hero h1 {
        font-size: 2.8rem;
      }
      
      .contact-grid {
        grid-template-columns: 1fr;
        gap: 3rem;
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
      
      .options-container {
        grid-template-columns: 1fr;
      }
      
      .cta-row {
        flex-direction: column;
        align-items: center;
      }
      
      .stats {
        grid-template-columns: 1fr;
      }
      
      .features-grid {
        grid-template-columns: 1fr;
      }
      
      .section-header h2 {
        font-size: 2rem;
      }
      
      .hero {
        padding: 8rem 0 4rem;
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

    .delay-1 {
      animation-delay: 0.2s;
    }

    .delay-2 {
      animation-delay: 0.4s;
    }

    .delay-3 {
      animation-delay: 0.6s;
    }
  </style>
</head>
<body>
  <header class="nav" id="navbar">
    <div class="container nav-inner">
      <a class="brand" href="#">
        <i class="fas fa-brain"></i>
        QuizMaster
      </a>
      <nav class="nav-links">
        <a href="#about">About</a>
        <a href="#features">Features</a>
        <a href="#tech">Technology</a>
        <a href="#quiz">Demo</a>
        <a href="#contact">Contact</a>
      </nav>
    </div>
  </header>


