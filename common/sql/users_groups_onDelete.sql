DROP TRIGGER IF EXISTS users_groups_beforeDelete;
DROP TRIGGER IF EXISTS users_groups_beforeUpdate;

DELIMITER // 
CREATE TRIGGER users_groups_beforeDelete
BEFORE DELETE ON users_groups FOR EACH ROW
BEGIN
    DECLARE member_count INT;
    DECLARE admin_count INT;

    -- Check the number of members in the group
    SELECT COUNT(*) INTO member_count FROM users_groups
        WHERE group_id = OLD.group_id;

    -- If the group has only one member (the one being deleted), delete the group
    IF member_count = 1 THEN
        DELETE FROM groups WHERE id = OLD.group_id;
    ELSE
        -- Check the number of admins in the group
        SELECT COUNT(*) INTO admin_count FROM users_groups
            WHERE group_id = OLD.group_id AND isGroupAdmin = 1;

        -- If there are no other admins after deletion, promote another member to admin
        IF admin_count = 1 AND OLD.isGroupAdmin = 1 THEN
            UPDATE users_groups SET isGroupAdmin = 1
                WHERE user_id = (
                    SELECT user_id FROM users_groups
                        WHERE group_id = OLD.group_id AND user_id != OLD.user_id
                        LIMIT 1
                );
        END IF;
    END IF;
END // 
DELIMITER ;

 

 -- trigger to call before_users_delete
DELIMITER // 
CREATE TRIGGER users_groups_beforeUpdate
BEFORE UPDATE ON users_groups FOR EACH ROW
BEGIN
    DECLARE admin_count INT;

    -- Check the number of admins in the group excluding the current user
    SELECT COUNT(*) INTO admin_count 
    FROM users_groups 
    WHERE group_id = OLD.group_id AND isGroupAdmin = 1 AND user_id != OLD.user_id;

    -- If the current user is an admin and is being demoted
    IF OLD.isGroupAdmin = 1 AND NEW.isGroupAdmin = 0 THEN
        -- If there are no other admins
        IF admin_count = 0 THEN
            -- Promote another member to admin (choose one arbitrarily)
            UPDATE users_groups 
            SET isGroupAdmin = 1 
            WHERE user_id = (
                SELECT user_id 
                FROM users_groups 
                WHERE group_id = OLD.group_id AND user_id != OLD.user_id 
                LIMIT 1
            );
        END IF;
    END IF;
END // 
DELIMITER ;
