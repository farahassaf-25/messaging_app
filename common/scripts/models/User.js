/** This is a stripped down user model used on client side */
class User {
  constructor(email, imageURL) {
    this.email = email;
    this.imageURL = imageURL;
  }

  fromObject(obj) {
    return new User(obj.email, obj.imageURL);
  }
}