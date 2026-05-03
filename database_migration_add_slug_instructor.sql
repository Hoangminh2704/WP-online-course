-- Chạy file này NẾU bạn đã tạo DB cũ (chưa có slug / instructor / InnoDB).
-- Backup trước khi chạy.

USE online_course_platform;

-- Đổi engine InnoDB (FK ổn định)
ALTER TABLE categories ENGINE=InnoDB;
ALTER TABLE locations ENGINE=InnoDB;
ALTER TABLE users ENGINE=InnoDB;
ALTER TABLE enrollments ENGINE=InnoDB;

-- Thêm cột khóa học (thứ tự phụ thuộc MySQL — nếu lỗi, chạy từng ALTER)
ALTER TABLE courses
  ADD COLUMN slug VARCHAR(220) NULL AFTER title,
  ADD COLUMN instructor VARCHAR(150) NOT NULL DEFAULT '' AFTER slug;

UPDATE courses SET slug = CONCAT('course-', course_id) WHERE slug IS NULL OR slug = '';
ALTER TABLE courses MODIFY slug VARCHAR(220) NOT NULL;
ALTER TABLE courses ADD UNIQUE KEY uq_courses_slug (slug);

ALTER TABLE courses MODIFY image_url VARCHAR(512) NULL;
ALTER TABLE courses ENGINE=InnoDB;
