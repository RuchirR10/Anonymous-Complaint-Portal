CREATE DATABASE complaint_box_pro;

USE complaint_box_pro;

CREATE TABLE complaints(
id INT AUTO_INCREMENT PRIMARY KEY,
tracking_id VARCHAR(20),
name VARCHAR(100),
complaint_type VARCHAR(20),
category VARCHAR(50),
message TEXT,
file VARCHAR(255),
status VARCHAR(20) DEFAULT 'Pending',
priority VARCHAR(10) DEFAULT 'Low',
remark TEXT NULL,
date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
