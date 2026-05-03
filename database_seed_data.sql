-- Dữ liệu mẫu đầy đủ — chạy SAU database.sql (schema đã có slug + instructor)
USE online_course_platform;

-- Xóa dữ liệu cũ (giữ cấu trúc bảng). Bỏ comment nếu muốn làm sạch trước khi nạp lại.
SET FOREIGN_KEY_CHECKS = 0;
TRUNCATE TABLE enrollments;
TRUNCATE TABLE courses;
TRUNCATE TABLE users;
TRUNCATE TABLE locations;
TRUNCATE TABLE categories;
SET FOREIGN_KEY_CHECKS = 1;

-- --- Categories ---
INSERT INTO categories (category_name, description) VALUES
('Programming', 'Software engineering, languages, and frameworks.'),
('Business', 'Leadership, strategy, and professional skills.'),
('Design', 'UX/UI, visual design, and creative tools.');

-- --- Locations (Google Maps) ---
INSERT INTO locations (location_name, address, map_link) VALUES
('New York Innovation Center', '120 Broadway, Manhattan, NY 10271', 'https://www.google.com/maps/search/?api=1&query=120+Broadway+Manhattan+NY+10271'),
('London Global Campus', '20-22 Wenlock Rd, Hoxton, London N1 7GU', 'https://www.google.com/maps/search/?api=1&query=20-22+Wenlock+Rd+London+N1+7GU'),
('Singapore Tech Hub', '71 Ayer Rajah Crescent, Singapore 139951', 'https://www.google.com/maps/search/?api=1&query=71+Ayer+Rajah+Crescent+Singapore+139951');

-- --- Users (mật khẩu bcrypt — PHP password_verify) ---
-- student@edustream.test  → Student123!
-- admin@edustream.test    → Admin123!
INSERT INTO users (full_name, email, password_hash, role) VALUES
('Demo Student', 'student@edustream.test', '$2b$12$Af.9WVw3PscukTppgA74ne1VgYeAiJDyIONBL3faxUqtiWJpRvzk2', 'student'),
('Jane Learner', 'jane@edustream.test', '$2b$12$Af.9WVw3PscukTppgA74ne1VgYeAiJDyIONBL3faxUqtiWJpRvzk2', 'student'),
('Admin EduStream', 'admin@edustream.test', '$2b$12$SfpYwABBBdTWv4gT.w2dxO6Vp5A47QPMcBACBlI348eKP8YT0s/pC', 'admin');

-- --- Courses ---
INSERT INTO courses (title, slug, instructor, description, price, rating, category_id, location_id, image_url) VALUES
(
  'Advanced React & Redux Masterclass',
  'advanced-react-redux-masterclass',
  'Dr. Sarah Jenkins',
  'Production-grade React architecture, Redux Toolkit, performance tuning.',
  89.99, 4.8, 1, 1,
  'https://lh3.googleusercontent.com/aida-public/AB6AXuD66J9SdQxlTZmW3AIK8omKEe8ZjcDHQEz3d9kB4_hTCWHxNG22pG8S3ATbPp4lIfsCi1hZc1OjysE6yvjCfMveSM1saRqwsgibTCVU64hcXkdX1GxDtIQrEIIxGBJD6tLQgHcp7HEApIG93a_SAOc3W5RpS2vrM0ATv9IrMicygH_ooldCIwq55EOu0b83_zlLTkyFr-Kx9udvby0o_GmZy8qYPtmTqsWjeNfaLdMCBtAbJ4IHItNaAnWGeIzJmAky6D9iBehkpWPL'
),
(
  'Python for Data Science 2024',
  'python-data-science-2024',
  'Mark Thompson',
  'Pandas, visualization, and ML pipelines with Python.',
  64.99, 4.6, 1, 2,
  'https://lh3.googleusercontent.com/aida-public/AB6AXuC4tP1_R-MvWwv12ceLUsTt5JjQDutJKxyFyojmPbhVgkXWZ_5HvbIgZ05Gbu3hpTM0vTHi95WWT41yKA_CK98fRMgHiY4m3OyIrXeJq8yPqg76Fdne1H_4DxHKH_koUU1mxb14drK1eV3BUFQd-2Gu_ezY-ocxWlO5EtDlR7XVi110BJPAszemSfPZGhb9zQROjy__f0s2IALILXNFPXNzKvl7oYlAfPf-rpjxgo6JGr4ve7ndR8gZN7K6SvI064UyBh_a-yMuYxWR'
),
(
  'Microservices Architecture with Go',
  'microservices-go',
  'Alex Rivest',
  'Distributed systems, gRPC, containers with Go.',
  129.99, 4.9, 1, 3,
  'https://lh3.googleusercontent.com/aida-public/AB6AXuDomdMCNOxU8a4j8T98N0F1CFCI3UFvI33YHZnT94Rb8VnHPWvNkpznqm2uNXTKkkrJWlD-ZhFa4LmZdg7xb34NY3ZD_3pF4YQ0pQiFC0gDQMUjpGXgynfc7a1TdnBQ7TapFbz9pHXHD9JhELW0yH-1keCoNuIBsz4lgrnNBfwPweWXU3KPRgOZH9X39dA9l-n6kyOkswwDKx2B8Xg2FqHzHACPl8VJuLPeQCqoQyD_LsohlYlLZtNDxb30ZzUtG4NGXpw6BC_vnKJj'
),
(
  'Full-Stack Web Development',
  'full-stack-web-development',
  'Jordan Lee',
  'HTML/CSS/JS, backend APIs, databases, deployment.',
  94.99, 4.7, 1, 1,
  'https://lh3.googleusercontent.com/aida-public/AB6AXuArOQITebmcsjUCRiMCmQa0qimEV-UDnYYQhQU8V70rn0Hf5ELK0KAInFS_SyhOumBF962o0_ol1c8sNahvtNzsD8zNV_6XBwwW00K0R08JS-Ss0b5fn0VtJlJC4JtFAvHy6T4XhGLk-7mtU7oH9oBc0bz0O01PlAju7lr6MwPWyyVXHnye84j953PMei6eiM_3g-WJjdlzh-ulvP0SqVe1z1QWTEXUl_0LUirPk8GNy00hifJJ1uKj5Gg1qaXFmvjslyvb16IirXE7'
),
(
  'Cybersecurity Essentials',
  'cybersecurity-essentials',
  'Robert Chen',
  'Threat modeling, secure coding, and defensive basics.',
  79.99, 4.5, 1, 2,
  'https://lh3.googleusercontent.com/aida-public/AB6AXuDsKo3YevpYyQ1QbJ677iUNvcQKca9LvHJYewPpFcSulMT4YqIy9cWV95ImqEDFrabGg9yb9GCYvqMrciSZM2ws-JYM5r1WyGJSbJSdALX5B9BL7GbPNwsFk3l0ANOJkqnx6VpqrrGvnzuERqUFoKGwIL6EIiexqmtErUr4J0kJsQNiZArPdQkcmrRfauSH77n7qeTaDFXKWqlq_mtN81vs_4LPHLRHQCuva0epuu5_zkZuV-ipGhMRyFiYddJINHZqXDXt3jIM-y5o'
),
(
  'Machine Learning Foundations',
  'machine-learning-foundations',
  'Prof. Elena Moretti',
  'Supervised learning, evaluation, and ethical ML.',
  149.99, 5.0, 1, 3,
  'https://lh3.googleusercontent.com/aida-public/AB6AXuDUt0NvPxHTot_Hy-zCgKskB9r2mDv1MKtwEMzwdlqBp9fcl_1GGe9h8EPTRlYrMtFGzhyHj223GkTKn1CRHDfQy1JJdQuZjNWltxbpBsO2l5wiQPDO_gOCUXDr2ppe-SCszYFPZETyM3pqzHrT2joZQSaY1UclRkNf3qc290DDxngwLvtMLoL-mjlgnMHLdY2q6FEMbzQnSwY4UJ9Zdp0cMeZ5lgJ3I8UH8K6Nll8oCoJ01_IHEWK9a-G5wnwv3begWQKcnx3TdaBs'
),
(
  'Product Strategy for Leaders',
  'product-strategy-leaders',
  'Chris Nguyen',
  'Roadmaps, prioritization, and stakeholder alignment.',
  59.99, 4.4, 2, 1,
  NULL
),
(
  'UX Design Systems Workshop',
  'ux-design-systems',
  'Priya Shah',
  'Tokens, components, and accessibility in design systems.',
  72.50, 4.7, 3, 2,
  NULL
);

-- --- Enrollments (user_id 1 = Demo Student, 2 = Jane) ---
INSERT INTO enrollments (user_id, course_id) VALUES
(1, 1),
(1, 3),
(2, 2),
(2, 6),
(2, 8);
