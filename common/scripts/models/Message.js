class Message {
  /** Model representing a message sent by a user
   * @param {number} id The ID of the message
   * @param {number} user_id The ID of the user who sent the message
   * @param {string} content The message content
   * @param {number} createdAt The message creation time (in milliseconds)
   */
  constructor(id, user_id, content, createdAt = Date.now()) {
    this.id = id;
    this.user_id = user_id;
    this.content = content;
    this.createdAt = createdAt;
  }
}
