<?php

/** User model as seen by another user (only the basic) */
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
    static $dateFormat = 'Y-m-d H:i:s';

    public $id;
    public $password;
    public $name;
    public $type;
    public $createdAt;

    public function __construct($id, $email, $password, $name, $imageURL, $type, $createdAt)
    {
        if (!is_numeric($id) || $id < 1) {
            throw new InvalidArgumentException("Invalid user ID: $id");
        }
        if (!is_numeric($type) || $type < 0) {
            throw new InvalidArgumentException("Invalid user type: $type");
        }
        $createdAtVerified = DateTime::createFromFormat(User::$dateFormat, $createdAt);
        if (!$createdAtVerified) {
            throw new InvalidArgumentException("Invalid user creation date format");
        }

        parent::__construct($email, $imageURL);
        $this->id = intval($id);
        $this->password = $password;
        $this->name = $name;
        $this->type = intval($type);
        $this->createdAt = $createdAtVerified->format(User::$dateFormat);

        if (!empty($imageURL) && !filter_var($imageURL, FILTER_VALIDATE_URL)) {
            throw new InvalidArgumentException("Invalid imageURL format: $imageURL");
        }

        // Construct correct imageURL for local uploads
        if (!empty($imageURL)) {
            $baseURL = getBaseURL();
            $this->imageURL = rtrim($baseURL, '/') . '/' . ltrim($imageURL, '/');
        } else {
            $this->imageURL = null; // or handle default image URL logic if needed
        }
    }

    static function fromObject($object)
    {
        return new User(
            $object['id'],
            $object['email'],
            $object['password'],
            $object['name'],
            $object['imageURL'],
            $object['type'],
            $object['createdAt']
        );
    }
}

// Helper function to get base URL
function getBaseURL()
{
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';
    $host = $_SERVER['HTTP_HOST'];
    return $protocol . $host;
}
