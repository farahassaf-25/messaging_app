DELIMITER // CREATE PROCEDURE users_onDelete_action (this_user_id INT) BEGIN
DELETE FROM users_groups
where
  user_id = this_user_id;

END // DELIMITER;

-- trigger to call before_users_delete
DELIMITER // CREATE TRIGGER users_onDelete
BEFORE DELETE ON users FOR EACH ROW
BEGIN

CALL users_onDelete_action (OLD.id);

END // DELIMITER;