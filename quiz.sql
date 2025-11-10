CREATE DATABASE quiz_db;
USE quiz_db;

-- Categories table
CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT
);

-- Questions table
CREATE TABLE questions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT,
    question TEXT NOT NULL,
    option1 TEXT NOT NULL,
    option2 TEXT NOT NULL,
    option3 TEXT NOT NULL,
    option4 TEXT NOT NULL,
    correct_option INT NOT NULL,
    difficulty ENUM('easy', 'medium', 'hard') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id)
);

-- Quiz sessions table
CREATE TABLE quiz_sessions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    session_id VARCHAR(100) UNIQUE NOT NULL,
    category_id INT,
    difficulty VARCHAR(20),
    total_questions INT,
    score INT,
    completed BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id)
);

-- User answers table
CREATE TABLE user_answers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    session_id VARCHAR(100),
    question_id INT,
    user_answer INT,
    is_correct BOOLEAN,
    answered_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (session_id) REFERENCES quiz_sessions(session_id),
    FOREIGN KEY (question_id) REFERENCES questions(id)
);

-- Insert sample categories
INSERT INTO categories (name, description) VALUES
('Web Development', 'Questions about web technologies and programming'),
('Mathematics', 'Mathematical concepts and problems'),
('General Knowledge', 'General knowledge questions'),
('Science', 'Scientific concepts and facts');

-- Insert sample questions
INSERT INTO questions (category_id, question, option1, option2, option3, option4, correct_option, difficulty) VALUES
(1, 'What does HTML stand for?', 'Hyper Text Markup Language', 'High Tech Modern Language', 'Hyper Transfer Markup Language', 'Home Tool Markup Language', 1, 'easy'),
(1, 'Which of the following is NOT a JavaScript framework?', 'React', 'Angular', 'Vue', 'Laravel', 4, 'easy'),
(1, 'What is the purpose of CSS?', 'To structure web content', 'To add interactivity to web pages', 'To style web pages', 'To manage databases', 3, 'easy'),
(1, 'What does API stand for?', 'Application Programming Interface', 'Advanced Programming Interface', 'Automated Programming Interface', 'Application Protocol Interface', 1, 'medium'),
(1, 'Which method is used to add an element to the end of an array in JavaScript?', 'push()', 'pop()', 'shift()', 'unshift()', 1, 'medium'),
(1, 'What is the virtual DOM in React?', 'A direct representation of the real DOM', 'A concept where UI is kept in memory and synced with the real DOM', 'A DOM that exists only during development', 'A DOM that is not accessible to JavaScript', 2, 'hard'),
(1, 'What is the time complexity of binary search?', 'O(1)', 'O(n)', 'O(log n)', 'O(n log n)', 3, 'hard'),
(2, 'What is the value of π (pi) approximately?', '3.14', '2.71', '1.62', '1.41', 1, 'easy'),
(2, 'What is the derivative of x²?', 'x', '2x', '2', 'x²', 2, 'medium'),
(2, 'What is the integral of 1/x?', 'ln|x| + C', 'x²/2 + C', '1/x² + C', 'x + C', 1, 'hard'),
(3, 'Which planet is known as the Red Planet?', 'Venus', 'Mars', 'Jupiter', 'Saturn', 2, 'easy'),
(3, 'Who wrote "Romeo and Juliet"?', 'Charles Dickens', 'William Shakespeare', 'Jane Austen', 'Mark Twain', 2, 'easy'),
(3, 'What is the capital of Japan?', 'Seoul', 'Beijing', 'Tokyo', 'Bangkok', 3, 'easy'),
(3, 'Which element has the chemical symbol "Au"?', 'Silver', 'Gold', 'Aluminum', 'Argon', 2, 'medium'),
(4, 'What is the chemical formula for water?', 'H2O', 'CO2', 'NaCl', 'O2', 1, 'easy'),
(4, 'Which gas do plants absorb from the atmosphere?', 'Oxygen', 'Nitrogen', 'Carbon Dioxide', 'Hydrogen', 3, 'easy'),
(4, 'What is the speed of light in vacuum?', '299,792,458 m/s', '300,000,000 m/s', '150,000,000 m/s', '1,080,000,000 km/h', 1, 'hard');