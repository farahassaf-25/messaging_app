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
        // remove the URL validation here since it will be handled in the derived class
        $this->email = $email;
        $this->imageURL = $imageURL;
        $this->email = $email;
        $this->imageURL = filter_var($imageURL, FILTER_VALIDATE_URL) ? $imageURL : null;
    }

    static function fromObject($object)
    {
        return new UserSimple($object['email'], $object['imageURL']);
    }
}

/** User model matching the MySQL table */
class User extends UserSimple
{
    static $dateFormat = 'Y-m-d H:i:s';

    public $id;
    public $password;
    public $name;
    public $email;
    public $imageURL;
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

        // Construct correct imageURL for local uploads if it's not an absolute URL
        if (!empty($imageURL) && !filter_var($imageURL, FILTER_VALIDATE_URL)) {
            $baseURL = getBaseURL();
            $imageURL = rtrim($baseURL, '/') . '/' . ltrim($imageURL, '/');
        }

        parent::__construct($email, $imageURL);
        $this->id = intval($id);
        $this->password = $password;
        $this->name = $name;
        parent::__construct($email, $imageURL);
        $this->id = intval($id);
        $this->email = $email;
        $this->password = $password; // TODO: encrypt or use token
        $this->name = $name;
        $this->imageURL = $imageURL;
        $this->type = intval($type);
        $this->createdAt = $createdAtVerified->format(User::$dateFormat);
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
