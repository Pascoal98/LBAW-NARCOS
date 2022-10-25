## A1: NARCOS - Not Another Reddit Clone - On Steroids

Knowledge is the most valuable and important currency in the world today.

NARCOS (Not Another Reddit Clone - On Steroids) comes from a need to revolutionize the way in which we share and read news, by having the users both create and curate the content in a decentralized manner. This tool can be used by people of every age group and the content is properly reviewed and supervised by administrators to assure that the right content is being delivered to you.

NARCOS allows all users to write and read every type of news and subsequently interact with those same news, liking, disliking, comenting or reporting them as fake or offensive news. Each user's news feed is based on their subscriptions across a great variety of topics.

The users are separated into two distinct groups, the registered ones who are allowed to share and read content and the visitors, that login, registrate and read public information. Besides these two groups there are the administrators, responsible for maintaining the website running properly, and assuring that users respect each other in the coments.

The platform's design will be convenient and adequate for finding news according to the interest of the users. It will also be adaptive so it can be used independently of the device you are operating in.


## A2: Actors and User Stories

This artifact contains the specification of the actors and their user stories, serving as agile documentation of the project's requirements.

### 1. Actors

![](https://i.imgur.com/N6YskGX.png)


| Identifier         | Description                                                  | 
| ------------------ | ------------------------------------------------------------ | 
| User               | Generic user that has access to public information, such as news feed |
| Visitor            | Unauthenticated User that can access the Login and Registration page and only read public information |
| Reader | Authenticated User that has logged in to the page beeing able to interact in all forms with the app (like, dislike, comment, classify as fake, and write a new) |
| Administrator    | User with complete access and modified priviliges that can manage users and news| 
| OAuth API | External OAuth API that can be used to register or authenticate into the system |

### 2. User Stories


User stories are organized by actor.
There is an identifier, a name, priority and description for each actor.



#### 2.1 User
| Identifier | Name                 | Priority | Description                                                  |
| ---------- | -------------------- | -------- | ------------------------------------------------------------ |
| US01       | View Top News Feed | high     | As a User, I want to be able to see the top news feed |
| US02       | View Recent News Feed | high     | As a User, I want to be able to see the most recent news feed |
| US03       | View News Item | high     | As a User, I want to be able to read a news item. |
| US04       | View News Item Comments | high     | As a User, I want to be able to see the comments of each news item |
| US05       | Search for News Items and Comments | high     | As a User, I want to be able to search for specific news items and comments |

#### 2.2 Visitor
| Identifier | Name                 | Priority | Description                                                  |
| ---------- | -------------------- | -------- | ------------------------------------------------------------ |
| US11       | Sign-in | high     |  As a Visitor, I want to have the option to authenticate into the website, so that I can access private information |
| US12       | Register | high     |  As a Visitor, I want to register myself into the website, so that I can then log-in into the system |

#### 2.3 Authenticated User

| Identifier | Name                 | Priority | Description                                                  |
| ---------- | -------------------- | -------- | ------------------------------------------------------------ |
| US21       | View User News Feed | high     |  As an Authenticated User, I want to be able to view a feed of the news I'm subscribed to|
| US22       | View News Item Details | high     |  As an Authenticated User, I want to be able to view a feed of the news I'm subscribed to|
| US23       | View Comment Details | high     |  As an Authenticated User, I want to be able to view the comments of the news that i am subscribe to |
| US24       | Create News Item | high     |  As an Authenticated User, I want to be able to create and post a news item |
| US25       | Vote on News Item | high     |  As an Authenticated User, I want to be able to like or dislike a news item |
| US26       | Vote on Comment | high     |  As an Authenticated User, I want to be able to like or dislike a comment |
| US27       | Comment on News Item | high     |  As an Authenticated User, I want to be able to comment on a news item |
| US28       | View Other Users' Profiles | high     |  As an Authenticated User, I want to be able to to view the profiles of other users |
| US29       | View Reputation of Other Users | high     |  As an Authenticated User, I want to be able to view the reputation of other users |
| US210       | View News Items Tags | high     |  As an Authenticated User, I want to be able to view the identifying tag of a news item |
| US211       | Follow Users | high     |  As an Authenticated User, I want to be able to follow another user |
| US212       | Unfollow Users | high     |  As an Authenticated User, I want to be able to unfollow another user |
| US213       | Follow Tags | high     |  As an Authenticated User, I want to be able to follow a news tag |
| US214       | Unfollow Tags | high     |  As an Authenticated User, I want to be able to unfollow a news tag |
| US215       | Edit Own News Item | high     |  As an Authenticated User, I want to be able to edit a news item that i have posted |
| US216       | Delete Own News Item | high     |  As an Authenticated User, I want to be able to delete a news item that i have posted |
| US217       | Edit Own Comment | high     |  As an Authenticated User, I want to be able to edit a comment that i have posted |
| US218       | Delete Own Comment | high     |  As an Authenticated User, I want to be able to delete a comment that i have posted |
| US219       | Get Notified When Someone Likes My Content | high     |  As an Authenticated User, I want to receive a notification when someone likes my content |
| US220       | Get Notified When Someone Comments My Content | high     |  As an Authenticated User, I want to receive a notification when someone comments my content |
| US221       | Propose New Topics | high     |  As an Authenticated User, I want to be able to propose a new topic for discussion |

#### 2. Administrator
| Identifier | Name                 | Priority | Description                                                  |
| ---------- | -------------------- | -------- | ------------------------------------------------------------ |
| US51       | Remove publications | high     |  As an Administrator, I want to be able to remove publications that contain innapropriate content |
| US52       | Remove comments | high     | As an Administrator, I want to be able to remove comments that contain innapropriate content |
| US53       | Accept user | high     | As an Admin, I want to accept the registration of a new user, so that the user has access to the site's content |
| US54       | Ban user | high     | As an Administrator, I want to be able to ban a user for inappropriate conduct, so that the user no longer has access to the site's content |
| US54       | Manage Topic Proposals | high     | As an Administrator, I want to be able to accept or deny a new topic proposal, so that the website can evolve with current user needs |
| US55       | View Reported Content | high     | As an Administrator, I want to be able to see a list of content that has been reported by users to be inappropriate |

### 3. Supplementary requirements

#### 3.1 Business Rules

| Identifier | Name                       | Description                                                  |
| ---------- | -------------------------- | ------------------------------------------------------------ |
| BR01       | Administration | Administrator accounts are independent of user accounts |
| BR02       | Account Deletion | When a user deletes their own account, the account becomes disabled and the content isn't deleted |
| BR03       | Reputation | User reputation is dependent on the likes and dislikes received on their posts or comments |
| BR04       | Deletion Limited | A post or comment cannot be deleted by its author if it has votes or comments |
| BR05       | like/comment its own new/comment | A user is able to comment to like and comment a new or a comment that has been posted by himself |



#### 3.2 Technical requirements
Technical requirements are concerned with the technical aspects that the system must have, such as performance-related issues, reliability issues and availability issues.


| Identifier | Name                       | Description                                                  |
| ---------- | -------------------------- | ------------------------------------------------------------ |
| TR01       | **Availability**               | The system must be available 99 percent of the time in each 24-hour period |
| TR02       | Accessibility              | The system must ensure that everyone can access the pages, regardless of whether they have any handicap or not, or the Web browser they use |
| TR03       | Usability                  | The system should be simple and easy to use                  |
| TR04       | Performance                | The system should have response times shorter than 2s to ensure the user's attention |
| TR05       | Web application            | The system should be implemented as a Web application with dynamic pages (HTML5, JavaScript, CSS3 and PHP) |
| TR06       | Portability                | The server-side system should work across multiple platforms (Linux, Mac OS, etc.) and different devices|
| TR07       | Database                   | The PostgreSQL database management system must be used, with an updated version       |
| TR08       | **Security**               | The system shall protect information from unauthorized access through the use of an authentication and verification system |
| TR09       | Robustness                 | The system must be prepared to handle and continue operating when runtime errors occur |
| TR10       | **Scalability**            | The system must be prepared to deal with the growth in the number of users and their actions |
| TR11       | Ethics                     | The system must respect the ethical principles in software development (for example, the password must be stored encrypted to ensure that only the owner knows it) |

Since we are working with live news, it's crucial that the web application is pretty much always available.

In the scope of a collaborative news project we need the system to deal with the growth of the number of news posted and active users.

When it comes to Security, it is extremely important to enssure that every user's data is protected.

The application will be extremely interactive between users, so it's important to assure an easy and simply way to maneuver through it.

#### 3.2 Restrictions
There is a restriciton on the designs of this project
| Identifier | Name                       | Description                                                  |
| ---------- | -------------------------- | ------------------------------------------------------------ |
| C01 | Deadline | The system should be fully functional and ready to be used before the Christmas holidays, by the 13th of december| 

## A3: Information Architecture

This artifact is a brief presentation about the system to be implemented. Our goals are identify and describe the design and functionalities of the system. This artifact includes two elements:

- One sitemap, that shows how the information is organized.
- Two wireframes, that shows the functionality of both pages. In this case, the homepage and the bidding item page.

### 1. Sitemap

The system is organized in different areas, the user edition pages, the news items pages, the pages with administration features and the authentication pages.

![](https://imgur.com/0Nbx3R5.jpg)

### 2. Wireframes

The two wireframes that we are going to present will be the news feed pages for both visitors and readers.

![](https://imgur.com/v4i49XK.jpg)

![](https://imgur.com/j7YZvis.jpg)

1. Direct access to the search functionality
2. Profile image and access to the user's profile
3. Logout of session
4. Direct access to the main page
5. A news item with access to its content
    - The tile of the new
    - A news item's related image
    - A short description of the news item
6. Topic selection for news items
7. News and writers sujestions
8. Website information
9. Login 
10. Sign in for unregistered users


GRUPO 131, 1/10/2022

- André Leonor, up201806860@edu.fe.up.pt
- Bruno Pascoal, up201705562@edu.fc.up.pt
- Fernando Barros, up201910223@edu.fc.up.pt
- Miguel Curval, up201105191@edu.fe.up.pt


ER editor André Leonor