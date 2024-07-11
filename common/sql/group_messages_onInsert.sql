DELIMITER //

CREATE TRIGGER BeforeInsertGroupMessage
BEFORE INSERT ON group_messages
FOR EACH ROW
BEGIN
    
    DECLARE total_messages INT;

    -- total messages count
    SELECT COUNT(*) INTO total_messages FROM group_messages;

    -- If there are more than 50 messages, delete the oldest one
    IF total_messages >= 50 THEN
        DELETE FROM group_messages 
            ORDER BY createdAt LIMIT 1;
    END IF;
    
END //

DELIMITER ;