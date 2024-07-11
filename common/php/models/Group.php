<?php
class Group
{
    public $id;
    public $name;
    public $createdAt;
    public $updatedAt;
    public $imageURL;

    public function __construct($id, $name, $createdAt, $updatedAt, $imageURL)
    {
        if (!is_numeric($id) || $id < 1) {
            throw new InvalidArgumentException("Invalid group ID: $id");
        }
        if (!Group::checkName($name)) {
            throw new InvalidArgumentException("Invalid group name: $name");
        }
        $dateFormat = "Y-m-d H:i:s";
        $createdAtVerified = DateTime::createFromFormat($dateFormat, $createdAt);
        if (!$createdAtVerified) {
            throw new InvalidArgumentException("Invalid group creation date format: $createdAt");
        }
        $updatedAtVerified = DateTime::createFromFormat($dateFormat, $updatedAt);
        if (!$updatedAtVerified) {
            throw new InvalidArgumentException("Invalid group update date format: $updatedAt");
        }
        // skip if not provided OR validate if provided
        if (isset($imageURL) && !Group::checkImageURL($imageURL)) {
            throw new InvalidArgumentException("Invalid group image URL: $imageURL");
        }

        $this->id = intval($id);
        $this->name = $name;
        $this->createdAt = $createdAtVerified->format($dateFormat);
        $this->updatedAt = $updatedAtVerified->format($dateFormat);
        $this->imageURL = $imageURL;
    }

    static function fromObject($object)
    {
        return new Group(
            $object['id'],
            $object['name'],
            $object['createdAt'],
            $object['updatedAt'],
            $object['imageURL'] ?? null
        );
    }

    public static $NAME_ALLOWED_SPECIAL_CHARS = "~!@#$%^&*()_+`-=";
    static function checkName($name)
    {
        return is_string($name) && preg_match("/^[\w+ ~!@#$%^&*()_+`\-=}]{1,64}$/", $name);
    }
    static function checkImageURL($imageURL)
    {
        return filter_var($imageURL, FILTER_VALIDATE_URL);
    }
}