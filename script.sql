-- DROP DATABASE IF EXISTS socialmediaapp ;
-- CREATE DATABASE socialmediaapp ;
-- USE socialmediaapp ;


CREATE TABLE users2 (
  users2_id int(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,  
  name varchar(191) NOT NULL,
  phone varchar(20) NOT NULL,
  email varchar(100) NOT NULL,
  password varchar(100) NOT NULL,
  is_ban tinytext NOT NULL COMMENT '0=unban,1=ban',
  role varchar(100) NOT NULL COMMENT 'admin,user',
  created_at timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


CREATE TABLE posts (
  post_id int(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,  
  user_id int(11) UNSIGNED NOT NULL,  
  image_path varchar(255) NOT NULL,
  tag varchar(50) DEFAULT NULL,
  is_on_fire TINYINT(1) DEFAULT 0,
  description text DEFAULT NULL,
  created_at timestamp NOT NULL DEFAULT current_timestamp(),
  CONSTRAINT FK_posts_user FOREIGN KEY (user_id) REFERENCES users2 (users2_id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



CREATE TABLE comments (
  comment_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,  
  post_id int(11) UNSIGNED NOT NULL,  
  user_id int(11) UNSIGNED NOT NULL,  
  comment_text text NOT NULL,  
  created_at timestamp NOT NULL DEFAULT current_timestamp(),  
  comment_image_path varchar(255) DEFAULT NULL,  
  
  
  CONSTRAINT FK_comments_post FOREIGN KEY (post_id) REFERENCES posts (post_id) ON DELETE CASCADE,  
  CONSTRAINT FK_comments_user FOREIGN KEY (user_id) REFERENCES users2 (users2_id) ON DELETE CASCADE  
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


CREATE TABLE likes (
  like_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,  
  user_id int(11) UNSIGNED NOT NULL, 
  post_id int(11) UNSIGNED NOT NULL,  
  created_at timestamp NOT NULL DEFAULT current_timestamp(),  
  
  
  UNIQUE KEY unique_post_user (post_id, user_id),
  
 
  CONSTRAINT FK_likes_post FOREIGN KEY (post_id) REFERENCES posts (post_id) ON DELETE CASCADE,  
  CONSTRAINT FK_likes_user FOREIGN KEY (user_id) REFERENCES users2 (users2_id) ON DELETE CASCADE  
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



CREATE TABLE created_posts_log (
  log_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,  
  post_id int(11) UNSIGNED NOT NULL,  
  user_id int(11) UNSIGNED NOT NULL,  
  created_at datetime NOT NULL,  
  log_timestamp timestamp NOT NULL DEFAULT current_timestamp(),  
  

  CONSTRAINT FK_created_posts_log_post FOREIGN KEY (post_id) REFERENCES posts (post_id) ON DELETE CASCADE,  
  CONSTRAINT FK_created_posts_log_user FOREIGN KEY (user_id) REFERENCES users2 (users2_id) ON DELETE CASCADE  
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


CREATE TABLE deleted_posts_log (
  log_id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,  
  post_id int(11) UNSIGNED NOT NULL, 
  user_id int(11) UNSIGNED NOT NULL,  
  deleted_at timestamp NOT NULL DEFAULT current_timestamp(),  
  
 
  CONSTRAINT FK_deleted_posts_log_post FOREIGN KEY (post_id) REFERENCES posts (post_id) ON DELETE CASCADE,  -- Foreign key to posts
  CONSTRAINT FK_deleted_posts_log_user FOREIGN KEY (user_id) REFERENCES users2 (users2_id) ON DELETE CASCADE  -- Foreign key to users2
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


CREATE TABLE about (
  id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,  
  content text NOT NULL  
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


CREATE TABLE contact (
  id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,  
  content text NOT NULL  
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


CREATE TABLE rules (
  id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,  
  content text NOT NULL 
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


DELIMITER $$

CREATE TRIGGER after_post_create
AFTER INSERT ON posts
FOR EACH ROW
BEGIN
    INSERT INTO created_posts_log (post_id, user_id, created_at)
    VALUES (NEW.post_id, NEW.user_id, NEW.created_at);
END $$

DELIMITER ;


DELIMITER $$

CREATE TRIGGER after_post_delete
AFTER DELETE ON posts
FOR EACH ROW
BEGIN
    INSERT INTO deleted_posts_log (post_id, user_id, deleted_at)
    VALUES (OLD.post_id, OLD.user_id, NOW());
END $$

DELIMITER ;


CREATE VIEW active_user_posts AS
SELECT 
    u.users2_id AS user_id,
    u.name,
    COUNT(p.post_id) AS posts_count,
    MAX(p.created_at) AS last_post_date
FROM users2 u
LEFT JOIN posts p ON u.users2_id = p.user_id
WHERE p.created_at >= CURDATE() - INTERVAL 30 DAY
GROUP BY u.users2_id;



CREATE VIEW admin_users AS
SELECT users2_id, name, role
FROM users2
WHERE role = 'admin';


INSERT INTO users2 (name, phone, email, password, is_ban, role)
VALUES 
('John Doe', '1234567890', 'john.doe@example.com', 'password123', '0', 'user'),
('Jane Smith', '2345678901', 'jane.smith@example.com', 'password456', '0', 'user');


INSERT INTO posts (user_id, image_path, tag, is_on_fire, description)
VALUES 
(1, 'images/post1.jpg', 'vacation', 0, 'Had a great time in the mountains!'),
(2, 'images/post2.jpg', 'food', 0, 'Delicious homemade pizza!');
