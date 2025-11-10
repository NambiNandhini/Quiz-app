<?php
// footer.php
?>


  <footer class="footer">
    <div class="container">
      <div class="footer-content">
        <div class="brand" style="background: none; -webkit-text-fill-color: white;">
          <i class="fas fa-brain"></i>
          QuizMaster
        </div>
        <div class="footer-links">
          <a href="index.php#about">About</a>
          <a href="index.php#features">Features</a>
          <a href="index.php#quiz">Demo</a>
          <a href="index.php#contact">Contact</a>
        </div>
   <p>© <span id="year"></span> QuizMaster — Designed & Developed with Modern Web Technologies</p>

      </div>
    </div>
  </footer>

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
    
    // Smooth scrolling for navigation links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
      anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
          target.scrollIntoView({
            behavior: 'smooth',
            block: 'start'
          });
        }
      });
    });
  </script>
</body>
</html>