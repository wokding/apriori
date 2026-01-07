-- Add Database Cleanup menu to Admin submenu
-- Run this query to add the cleanup feature to your menu

INSERT INTO `user_sub_menu` (`menu_id`, `title`, `url`, `icon`, `is_active`) 
VALUES (1, 'Database Cleanup', 'admin/cleanup', 'fas fa-fw fa-broom', 1);
