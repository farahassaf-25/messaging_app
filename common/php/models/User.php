<?php

class UserSimple
{
    public $email;
    public $imageURL;

    public function __construct($email, $imageURL)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException("Invalid email address: $email");
        }
        $this->email = $email;
        $this->imageURL = filter_var($imageURL, FILTER_VALIDATE_URL) ? $imageURL : null;
    }

    static function fromObject($object)
    {
        return new UserSimple($object['email'], $object['imageURL']);
    }
}

class User extends UserSimple
{
    public $id;
    public $name;
    public $type;
    public $createdAt;

    public function __construct($id, $name, $email, $type, $createdAt, $imageURL)
    {
        if (!is_numeric($id) || $id < 1) {
            throw new InvalidArgumentException('Invalid user ID');
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException("Invalid email address: $email");
        }
        if (!in_array($type, [0, 1])) {
            throw new InvalidArgumentException('Invalid user type');
        }

        $dateFormat = "Y-m-d H:i:s";
        $createdAtVerified = DateTime::createFromFormat($dateFormat, $createdAt);
        if (!$createdAtVerified) {
            throw new InvalidArgumentException("Invalid user creation date format");
        }

        parent::__construct($email, $imageURL);

        $this->id = intval($id);
        $this->name = $name;
        $this->type = intval($type);
        $this->createdAt = $createdAtVerified->format($dateFormat);
    }

    static function fromObject($object)
    {
        // Ensure type is set and valid
        if (!isset($object['type']) || !in_array($object['type'], [0, 1])) {
            throw new InvalidArgumentException('Invalid or missing user type');
        }
        return new User($object['id'], $object['name'], $object['email'], intval($object['type']), $object['createdAt'], $object['imageURL']);
    }
}
