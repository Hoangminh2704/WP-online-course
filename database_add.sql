

USE online_course_platform;

ALTER TABLE categories ENGINE=InnoDB;
ALTER TABLE locations ENGINE=InnoDB;
ALTER TABLE users ENGINE=InnoDB;
ALTER TABLE enrollments ENGINE=InnoDB;

ALTER TABLE courses
  ADD COLUMN slug VARCHAR(220) NULL AFTER title,
  ADD COLUMN instructor VARCHAR(150) NOT NULL DEFAULT '' AFTER slug;

UPDATE courses SET slug = CONCAT('course-', course_id) WHERE slug IS NULL OR slug = '';
ALTER TABLE courses MODIFY slug VARCHAR(220) NOT NULL;
ALTER TABLE courses ADD UNIQUE KEY uq_courses_slug (slug);

ALTER TABLE courses MODIFY image_url VARCHAR(512) NULL;
ALTER TABLE courses ENGINE=InnoDB;
