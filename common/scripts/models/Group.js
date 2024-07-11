/** Group model matching the MySQL table */
class Group {
  constructor(id, name, createdAt, imageURL) {
    this.id = id;
    this.name = name;
    this.createdAt = createdAt;
    this.imageURL = imageURL;
  }

  fromObject(obj) {
    return new Group(obj.id, obj.name, obj.createdAt, obj.imageURL);
  }
}
