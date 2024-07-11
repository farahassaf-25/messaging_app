# Convo Connect

Chat application

<br/><br/>

---

### Class diagram

```mermaid
classDiagram

Client --o UserSimple : uses
UserSimple <|-- Subscriber : inherits
UserSimple <|-- User : inherits
User  <|-- Admin : inherits
User "1..1" -- "1..1" User : contacts
User "0..1" --o "0..n" Message : sends
User "2..n" --o "0..n" Group : joins
Group "1..1" --o "0..n" Message : contains
groups_users "1..1" ..* "0..n" User : linked (foreign key)
groups_users "1..1" ..* "0..n" Group : linked (foreign key)
User "1..n" --o "0..n" Feedback : gives
User "1..n" --o "0..n" Report : makes

class Client {
  represents client side
  not a real class
}
class UserSimple {
  + id: int
  + email: text
  + imageURL: text
  + name: text
}
class User {
  + unique_id: int
  + status: text
  + type: int
  + createdAt: datetime
  + lname: text
  + password: text
  + login(): void
  + logout(): void
  + register(email: text, password: text): void
  + changePassword(email: text, oldPassword: text, newPassword: text): void
  + updateProfile(name: text, imageURL: text): void
  + blockUser(userId: int): void
  + reportUser(userId: int, reason: text): void
  + giveFeedback(content: text): void
}
class Admin {
  + addAdmin(userId: int): void
  + updateUser(name: text, email: text): void
  + updateAdmin(name: text, email: text, imageUrl: text): void
  + deleteUser(userId: int): void
  + deleteReport(reportId: int): void
  + deleteFeedback(feedbackId: int): void
  + monitorUserActivity(): void
}
class Subscriber {
  + email: text
  + name: text
  + subscribe(): void
}
class Message {
  + id: int
  + content: text
  + imageURL: text
  + createdAt: datetime
  + deliveredAt: datetime
  + readAt: datetime
  + senderId: int
  + groupId: int
}
class Group {
  + id: int
  + name: text
  + createdAt: datetime
  + imageURL: text
  + addMessage(Message): void
  + addUser(userId: int): void
  + removeUser(userId: int): void
}
class groups_users {
  + userEmail: text
  + groupID: int
}
class Feedback {
  + id: int
  + userId: int
  + content: text
  + createdAt: datetime
}
class Report {
  + id: int
  + reporterId: int
  + reportedId: int
  + reason: text
  + createdAt: datetime
}
class Feedback {
  + feedback_id: int
  + userId: int
  + feedback: text
  + created_at: datetime
}
class Report {
  + id: int
  + reporter_id: int
  + reported_id: int
  + report: text
  + created_at: datetime
}

```
