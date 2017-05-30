DROP TABLE 'likes','posts','users'

CREATE TABLE likes (
    User int NOT NULL,
    Post int NOT NULL,
    PRIMARY KEY(User, Post),
    CONSTRAINT FK_LikesUser FOREIGN KEY (User)
    REFERENCES users(ID),
    CONSTRAINT FK_LikesPost FOREIGN KEY (Post)
    REFERENCES posts(ID) ON DELETE CASCADE
)

CREATE TABLE posts (
	ID int NOT NULL,
	User int NOT NULL,
	Timestamp int(20) NOT NULL,
	Text text NOT NULL,
	PRIMARY KEY(ID),
	CONSTRAINT FK_PostsUser FOREIGN KEY (User)
	REFERENCES users(ID)
)

CREATE TABLE users (
	ID int NOT NULL,
	Username VARCHAR(50) NOT NULL,
	Password VARCHAR(150) NOT NULL,
	Mail VARCHAR(200) NOT NULL,
	Image VARCHAR(100) NOT NULL,
	PRIMARY KEY(ID)
)