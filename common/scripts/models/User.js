/** This is a stripped down user model used on client side */
class User {
  email;
  imageURL;
  constructor(email, imageURL) {
    this.email = email;
    this.imageURL = imageURL;
  }
}

// /** User model matching the MySQL table */
// class User extends User {
//   id;
//   type;
//   createdAt;
//   constructor(id, type, createdAt, email, imageURL) {
//     super(email, imageURL);
//     this.id = id;
//     this.type = type;
//     this.createdAt = createdAt;
//   }

//   fromObject(obj) {
//     return new User(obj.id, obj.type, obj.createdAt, obj.email, obj.imageURL);
//   }
// }
