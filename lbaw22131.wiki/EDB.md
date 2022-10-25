# EDB : Database Specification Component

## A4: Conceptual Data Model

![](https://git.fe.up.pt/lbaw/lbaw2223/lbaw22131/-/raw/main/resources/img/edb_2.png)

## A5: Relational Schema, Validation and Schema Refinement

### 1. Relational Schema

| Identifier | Relation Compact Notation                                                                                                                                                                                                                              |
| ---------- | :----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| R01        | Authenticated User(<u>id</u>, username UK NN, email UK VALID_EMAIL, password NN, bio, date_of_birth NN CK date_of_birth < NOW, img, is_banned NN DF False, is_admin NN DF False, reputation NN DF 0)                                                   |
| R02        | Suspension(<u>id</u>, reason NN, start DF NOW, end NN CK MIN_BAN, admin_id -> authenticated_user NN, user_id -> authenticated_user NN)                                                                                                                 |
| R03        | Report(<u>id</u>, reason NN, reported_at DF NOW CK reported_at <= NOW, is_closed DF false, reported_id -> authenticated_user NN, reporter_id -> authenticated_user CK reported_id != reporter_id)                                                      |
| R04        | Post(<u>id</u>, text NN, published_date DF NOW, is_edited DF false, likes DF 0 CK likes >= 0, dislikes DF 0 CK dislikes >= 0, author_id -> authenticated_user)                                                                                         |
| R05        | Notification(<u>id</u>, date NN DF NOW CK date <= NOW, is_read DF false, receiver_id -> authenticated_user NN, msg -> message, fb_giver -> authenticated_user, rated_content -> content, new_comment -> comment, type NN CK type in NOTIFICATION_TYPE) |
| R06        | Comment(<u>post_id</u> -> post, article_id -> article NN, parent_comment_id -> comment)                                                                                                                                                                |
| R07        | Article(<u>post_id</u> -> post, title NN, thumbnail)                                                                                                                                                                                                   |
| R08        | Follow(<u>follower_id</u> -> authenticated_user, <u>followed_id</u> -> authenticated_user CK followed_id != follower_id)                                                                                                                               |
| R09        | Feedback(<u>id</u>, user_id -> authenticated_user, post_id -> post NN, is_like NN)                                                                                                                                                                     |
| R010       | Topic(<u>id</u>, name NN UK, proposed_at DF NOW CK proposed_at <= NOW, state NN DF Pending CK state in PROPOSED_TAG_STATES, proposer_id -> authenticated_user)                                                                                         |
| R011       | Topic_follow(<u>id</u>, user_id -> authenticated_user, topic_id -> topic NN, is_follower NN)                                                                                                                                                           |
| R012       | article_tag(<u>article_id</u> -> article, <u>tag_id</u> -> tag)                                                                                                                                                                                        |
| R013       | Favorite_post(<u>user_id</u> -> authenticated_user, <u>topic_id</u> -> topic)                                                                                                                                                                          |

- UK = UNIQUE KEY
- NN = NOT NULL
- DF = DEFAULT
- CK = CHECK
- NOW = CURRENT_TIMESTAMP

### 2. Domains

Specification of additional domains:
| Domain Name | Domain Specification |
|-------------|----------------------|
|VALID_EMAIL|TEXT CHECK(VALUE LIKE '%@%.\_\_%')|
|NOTIFICATION_TYPE|ENUM('FEEDBACK', 'COMMENT')|
|PROPOSED_TOPIC_STATES| ENUM ('Pending', 'Accepted', 'Rejected')|

### 3. Schema validation

| Table R01 (Authenticated User) |                                                                                             |
| ------------------------------ | ------------------------------------------------------------------------------------------- |
| **Keys**                       | {id}, {email}                                                                               |
| **Functional Dependencies**    |                                                                                             |
| FD0101                         | {id} -> {username ,email, password, date_of_birth, bio, is_banned, is_admin, reputation}    |
| FD0102                         | {email} -> {username ,email, password, date_of_birth, bio, is_banned, is_admin, reputation} |
| **Normal Form**                | BCNF                                                                                        |

| Table R02 (Suspension)      |                                                 |
| --------------------------- | ----------------------------------------------- |
| **Keys**                    | {id}                                            |
| **Functional Dependencies** |                                                 |
| FD0201                      | {id} -> {reason, start, end, admin_id, user_id} |
| **Normal Form**             | BCNF                                            |

| Table R03 (Post)            |                                                                       |
| --------------------------- | --------------------------------------------------------------------- |
| **Keys**                    | {id}                                                                  |
| **Functional Dependencies** |                                                                       |
| FD0301                      | {id} -> {text, published_date, is_edited, likes, dislikes, author_id} |
| **Normal Form**             | BCNF                                                                  |

| Table R04 (Report)          |                                                                    |
| --------------------------- | ------------------------------------------------------------------ |
| **Keys**                    | {id}                                                               |
| **Functional Dependencies** |                                                                    |
| FD0401                      | {id} -> {reason, reported_at, is_closed, reported_id, reporter_id} |
| **Normal Form**             | BCNF                                                               |

| Table R05 (Notification)    |                                                                                       |
| --------------------------- | ------------------------------------------------------------------------------------- |
| **Keys**                    | {id}                                                                                  |
| **Functional Dependencies** |                                                                                       |
| FD0501                      | {id} -> {date, is_read, receiver_id, msg, fb_giver, rated_content, new_comment, type} |
| **Normal Form**             | BCNF                                                                                  |

| Table R06 (Comment)         |                                              |
| --------------------------- | -------------------------------------------- |
| **Keys**                    | {post_id}                                    |
| **Functional Dependencies** |                                              |
| FD0601                      | {post_id} -> {article_id, parent_comment_id} |
| **Normal Form**             | BCNF                                         |

| Table R07 (Article)         |                                 |
| --------------------------- | ------------------------------- |
| **Keys**                    | {post_id}                       |
| **Functional Dependencies** |                                 |
| FD0701                      | {post_id} -> {title, thumbnail} |
| **Normal Form**             | BCNF                            |

| Table R08 (Follow)          |                            |
| --------------------------- | -------------------------- |
| **Keys**                    | {follower_id, followed_id} |
| **Functional Dependencies** | none                       |
| **Normal Form**             | BCNF                       |

| Table R09 (Feedback)        |                                        |
| --------------------------- | -------------------------------------- |
| **Keys**                    | {id}                                   |
| **Functional Dependencies** |                                        |
| FD0901                      | {id} -> {is_like, user_id, content_id} |
| **Normal Form**             | BCNF                                   |

| Table R10 (Topic)           |                                    |
| --------------------------- | ---------------------------------- |
| **Keys**                    | {id}                               |
| **Functional Dependencies** |                                    |
| FD1001                      | {id} -> {proposer_id, proposed_at} |
| **Normal Form**             | BCNF                               |

| Table R11 (Topic_follow)    |                                          |
| --------------------------- | ---------------------------------------- |
| **Keys**                    | {id}                                     |
| **Functional Dependencies** |                                          |
| FD1101                      | {id} -> {user_id, topic_id, is_follower} |
| **Normal Form**             | BCNF                                     |

| Table R12 (Article_tag)     |                      |
| --------------------------- | -------------------- |
| **Keys**                    | {article_id, tag_id} |
| **Functional Dependencies** | none                 |
| **Normal Form**             | BCNF                 |

Since all relations are in the Boyce–Codd Normal Form (BCNF), the relational schema is also in the BCNF and so there is no need to further normalise it.

## A6: Indexes, triggers, transactions and database population

### 1. Database workload

| Relation | Relation name      | Order of magnitude    | Estimated growth |
| -------- | ------------------ | --------------------- | ---------------- |
| R01      | authenticated_user | tens of thousands     | dozens/day       |
| R02      | suspension         | hundreds              | dozens/month     |
| R03      | report             | hundreds              | dozens/week      |
| R04      | topic              | hundreds              | dozens/week      |
| R05      | follow             | tens of thousands     | dozens/day       |
| R06      | post               | tens of thousands     | hundreds/day     |
| R07      | article            | thousands             | dozens/day       |
| R08      | comment            | tens of thousands     | hundreds/day     |
| R09      | feedback           | hundreds of thousands | hundreds/day     |
| R010     | notification       | hundreds of thousands | hundreds/day     |
| R011     | article_topic      | thousands             | dozens/day       |

### 2. Proposed indexes

#### 2.1 Performance Indices

| Index         | IDX01                                                                                                                                                                                                                                            |
| ------------- | ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------ |
| Relation      | post                                                                                                                                                                                                                                             |
| Attribute     | author_id                                                                                                                                                                                                                                        |
| Type          | hash                                                                                                                                                                                                                                             |
| Cardinallity  | medium                                                                                                                                                                                                                                           |
| Clustering    | no                                                                                                                                                                                                                                               |
| Justification | Since the table will be very large and used quite frequently, by using hash index, we can search for a match much faster and effecient. The table is updated very often and the cardinality is medium, therefore we opted to not use clustering. |
| SQL code      | CREATE INDEX content_author ON post USING hash (author_id)                                                                                                                                                                                       |

```sql
CREATE INDEX post_author ON post USING hash (author_id);
```

| Index         | IDX02                                                                                                                                                                                                                                                                                                                                                                                                                                |
| ------------- | ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------ |
| Relation      | notification                                                                                                                                                                                                                                                                                                                                                                                                                         |
| Attribute     | receiver_id                                                                                                                                                                                                                                                                                                                                                                                                                          |
| Type          | hash                                                                                                                                                                                                                                                                                                                                                                                                                                 |
| Cardinallity  | medium                                                                                                                                                                                                                                                                                                                                                                                                                               |
| Clustering    | no                                                                                                                                                                                                                                                                                                                                                                                                                                   |
| Justification | One of the most frequent queries in the application will be fetching notifications of a user. As such, there's the need to have a hash index to perform exact search of notifications that a user received, considering the notifications' workload has a high order of magnitude. Finally, thanks to the high estimated growth of this relation and the medium cardinality, we determined that this index shouldn't use clustering. |
| SQL code      | CREATE INDEX notification_receiver ON notification USING hash (receiver_id);                                                                                                                                                                                                                                                                                                                                                         |

```sql
CREATE INDEX notification_receiver ON notification USING hash (receiver_id);
```

#### 2.2 Full-text search Indices

| Index         | IDX11                                                                                                                                                                                                                                                                    |
| ------------- | ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------ |
| Relation      | article                                                                                                                                                                                                                                                                  |
| Attribute     | (title, body)                                                                                                                                                                                                                                                            |
| Type          | GIST                                                                                                                                                                                                                                                                     |
| Clustering    | no                                                                                                                                                                                                                                                                       |
| Justification | Users will frequently search for articles with a given title or body. As such, we need a full-text search index to efficiently fetch the results of the search. For this, we chose GIST, since it's faster to build and update, as users may create/edit articles often. |

```sql
ALTER TABLE article ADD COLUMN tsvectors TSVECTOR;

CREATE FUNCTION article_search_update() RETURNS TRIGGER AS $$
DECLARE new_body text = (select body from content where id = NEW.content_id);
DECLARE old_body text = (select body from content where id = OLD.content_id);
BEGIN
  IF TG_OP = 'INSERT' THEN
    NEW.tsvectors = (
      setweight(to_tsvector('english', NEW.title), 'A') ||
      setweight(to_tsvector('english', new_body), 'B')
    );
  END IF;

  IF TG_OP = 'UPDATE' THEN
      IF (NEW.title <> OLD.title OR new_body <> old_body) THEN
        NEW.tsvectors = (
          setweight(to_tsvector('english', NEW.title), 'A') ||
          setweight(to_tsvector('english', new_body), 'B')
        );
      END IF;
  END IF;

  RETURN NEW;
END $$
LANGUAGE plpgsql;

CREATE TRIGGER article_search_update
  BEFORE INSERT OR UPDATE ON article
  FOR EACH ROW
  EXECUTE PROCEDURE article_search_update();

CREATE INDEX article_search ON article USING GIST (tsvectors);

```

| Index         | IDX12                                                                                                                                                                                                                    |
| ------------- | ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------ |
| Relation      | authenticate_user                                                                                                                                                                                                        |
| Attribute     | (username, email)                                                                                                                                                                                                        |
| Type          | GIST                                                                                                                                                                                                                     |
| Clustering    | no                                                                                                                                                                                                                       |
| Justification | For it to be possible to search for users by their name or email efficiently, a GIST index is used, since it is faster to build and update, as we are dealing with dynamic data (users can change their name and email). |

**SQL code:**

```sql
ALTER TABLE authenticated_user ADD COLUMN tsvectors TSVECTOR;

CREATE FUNCTION user_search_update() RETURNS TRIGGER AS $$
BEGIN
  IF TG_OP = 'INSERT' THEN
    NEW.tsvectors = (
      setweight(to_tsvector('english', NEW.username), 'A') ||
      setweight(to_tsvector('english', NEW.email), 'B')
    );
  END IF;

  IF TG_OP = 'UPDATE' THEN
      IF (NEW.username <> OLD.username OR NEW.email <> OLD.email) THEN
        NEW.tsvectors = (
          setweight(to_tsvector('english', NEW.username), 'A') ||
          setweight(to_tsvector('english', NEW.email), 'B')
        );
      END IF;
  END IF;

  RETURN NEW;
END $$
LANGUAGE plpgsql;

CREATE TRIGGER user_search_update
  BEFORE INSERT OR UPDATE ON authenticated_user
  FOR EACH ROW
  EXECUTE PROCEDURE user_search_update();

CREATE INDEX user_search ON authenticated_user USING GIST (tsvectors);
```

### 3. Triggers

| Trigger     | Trigger01                                                                                                                                  |
| ----------- | ------------------------------------------------------------------------------------------------------------------------------------------ |
| Description | Trigger to update likes/dislikes of a content when feedback is given, creates a notification on that feedback and updates user reputation. |

**SQL code:**

```sql
CREATE FUNCTION feedback_post() RETURNS TRIGGER AS
$BODY$
DECLARE author_id authenticated_user.id%type = (
  SELECT author_id FROM post INNER JOIN authenticated_user ON (post.author_id = authenticated_user.id)
  WHERE post.id = NEW.post_id
);
DECLARE feedback_value INTEGER = 1;
BEGIN
    IF (NOT NEW.is_like)
        THEN feedback_value = -1;
    END IF;

    IF (NEW.is_like) THEN
        UPDATE post SET likes = likes + 1 WHERE id = NEW.post_id;
    ELSE
        UPDATE post SET dislikes = dislikes + 1 WHERE id = NEW.post_id;
    END IF;

    UPDATE authenticated_user SET reputation = reputation + feedback_value
    WHERE id = author_id;

    INSERT INTO notification(receiver_id, is_read, msg, fb_giver, rated_post, new_comment, type)
    VALUES (author_id, FALSE, NULL, NEW.user_id, NEW.post_id, NULL, 'FEEDBACK');

    RETURN NULL;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER feedback_post
    AFTER INSERT ON feedback
    FOR EACH ROW
    EXECUTE PROCEDURE feedback_post();
```

| Trigger     | Trigger02                                                                                                           |
| ----------- | ------------------------------------------------------------------------------------------------------------------- |
| Description | Trigger to remove like/dislike of a post when feedback on it is removed and to update authenticated user reputation |

**SQL code:**

```sql
CREATE FUNCTION remove_feedback() RETURNS TRIGGER AS
$BODY$
DECLARE author_id authenticated_user.id%type = (SELECT author_id FROM post INNER JOIN authenticated_user ON (post.author_id = authenticated_user.id) WHERE post.id = OLD.post_id);
DECLARE feedback_value INTEGER = -1;
BEGIN
    IF (NOT OLD.is_like)
        THEN feedback_value = 1;
    END IF;

    IF (OLD.is_like) THEN
        UPDATE post SET likes = likes - 1 WHERE id = OLD.post_id;
    ELSE
        UPDATE post SET dislikes = dislikes - 1 WHERE id = OLD.post_id;
    END IF;

    UPDATE authenticated_user SET reputation = reputation + feedback_value
    WHERE id = author_id;

    RETURN NULL;
END
$BODY$

LANGUAGE plpgsql;

CREATE TRIGGER remove_feedback
    AFTER DELETE ON feedback
    FOR EACH ROW
    EXECUTE PROCEDURE remove_feedback();
```

| Trigger     | Trigger03                                                                                 |
| ----------- | ----------------------------------------------------------------------------------------- |
| Description | Trigger to prevent users from liking or disliking his\her own post (articles or comments) |

**SQL code:**

```sql
CREATE FUNCTION check_feedback() RETURNS TRIGGER AS
$BODY$
BEGIN
    IF (NEW.user_id in (
        SELECT post.author_id
        FROM post
        WHERE post.id = NEW.post_id)) THEN
            RAISE EXCEPTION 'You cannot give feedback on your own post';
    END IF;
    RETURN NEW;
END;
$BODY$

LANGUAGE plpgsql;

CREATE TRIGGER check_feedback
    BEFORE INSERT ON feedback
    FOR EACH ROW
    EXECUTE PROCEDURE check_feedback();
```

| Trigger     | Trigger04                                                                                                                                                                                                                  |
| ----------- | -------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| Description | Trigger to delete all the information about an article that was deleted it just needs to delete the post represented by that article since its that deletion is cascaded to the comments and other elements of the article |

**SQL code:**

```sql
CREATE FUNCTION delete_article() RETURNS TRIGGER AS
$BODY$
BEGIN
    DELETE FROM post WHERE post.id = OLD.post_id;
    RETURN OLD;
END
$BODY$

LANGUAGE plpgsql;

CREATE TRIGGER delete_article
    AFTER DELETE ON article
    FOR EACH ROW
    EXECUTE PROCEDURE delete_article();
```

| Trigger     | Trigger05                                                                    |
| ----------- | ---------------------------------------------------------------------------- |
| Description | Trigger to delete the respective post of a comment when a comment is deleted |

**SQL code:**

```sql
CREATE FUNCTION delete_comment() RETURNS TRIGGER AS
$BODY$
BEGIN
    DELETE FROM post WHERE post.id = OLD.post_id;
    RETURN OLD;
END
$BODY$

LANGUAGE plpgsql;


CREATE TRIGGER delete_comment
    AFTER DELETE ON comment
    FOR EACH ROW
    EXECUTE PROCEDURE delete_comment();
```

| Trigger     | Trigger06                                                                           |
| ----------- | ----------------------------------------------------------------------------------- |
| Description | Trigger to prevent an article from having an unaccepted topic or more than 3 topics |

**SQL code:**

```sql
CREATE FUNCTION add_article_topic_check() RETURNS TRIGGER AS
$BODY$
BEGIN
    IF ((SELECT state FROM topic WHERE NEW.topic_id = topic.id) <> 'ACCEPTED')
    THEN
        RAISE EXCEPTION 'You cannot associate an article to an Unaccepted topic';
    END IF;

    IF ((SELECT COUNT(*) FROM article_topic  WHERE article_id = NEW.article_id)) >= 3
    THEN
        RAISE EXCEPTION 'You cannot associate anymore topics to this article';
    END IF;
    RETURN NEW;
END
$BODY$

LANGUAGE plpgsql;

CREATE TRIGGER add_article_topic_check
    BEFORE INSERT ON article_topic
    FOR EACH ROW
    EXECUTE PROCEDURE add_article_topic_check();
```

| Trigger     | Trigger07                                                                                   |
| ----------- | ------------------------------------------------------------------------------------------- |
| Description | Triggers to update the _is_edited_ flag when a post's body or an article's title is updated |

**SQL code:**

```sql
CREATE FUNCTION set_post_is_edited() RETURNS TRIGGER AS
$BODY$
BEGIN
    UPDATE post SET is_edited = TRUE
    WHERE id = NEW.id;
	RETURN NULL;
END
$BODY$

LANGUAGE plpgsql;

CREATE TRIGGER set_post_is_edited
    AFTER UPDATE ON post
    FOR EACH ROW
    WHEN (OLD.body IS DISTINCT FROM NEW.body)
    EXECUTE PROCEDURE set_post_is_edited();
```

| Trigger     | Trigger08                                                             |
| ----------- | --------------------------------------------------------------------- |
| Description | Trigger to mark the post as edited when an article's title is changed |

**SQL code:**

```sql
CREATE FUNCTION set_article_is_edited() RETURNS TRIGGER AS
$BODY$
BEGIN
    UPDATE post SET is_edited = TRUE
    WHERE id = NEW.post_id;
	RETURN NULL;
END
$BODY$

LANGUAGE plpgsql;

CREATE TRIGGER set_article_is_edited
    AFTER UPDATE ON article
    FOR EACH ROW
    WHEN (OLD.title IS DISTINCT FROM NEW.title)
    EXECUTE PROCEDURE set_article_is_edited();
```

| Trigger     | Trigger09                                                                        |
| ----------- | -------------------------------------------------------------------------------- |
| Description | Trigger to put authenticated_user flag to true if a suspension on him is created |

**SQL code:**

```sql
CREATE FUNCTION is_suspended_flag_true() RETURNS TRIGGER AS
$BODY$
BEGIN
    UPDATE authenticated_user SET is_suspended = true
    WHERE id = NEW.user_id;
	RETURN NEW;
END
$BODY$

LANGUAGE plpgsql;

CREATE TRIGGER is_suspended_flag_true
    AFTER INSERT ON suspension
    FOR EACH ROW
    EXECUTE PROCEDURE is_suspended_flag_true();
```

| Trigger     | Trigger10                                                  |
| ----------- | ---------------------------------------------------------- |
| Description | Trigger to create a notification when a comment is created |

**SQL code:**

```sql
CREATE FUNCTION create_comment_notification() RETURNS TRIGGER AS
$BODY$
DECLARE article_author INTEGER = (
  SELECT author_id FROM post WHERE id = NEW.article_id
);
DECLARE parent_author INTEGER = (
  SELECT author_id FROM post WHERE id = NEW.parent_comment_id
);
BEGIN
  IF parent_author IS NULL THEN
    INSERT INTO notification(receiver_id, is_read, msg, fb_giver, rated_post, new_comment, type)
        VALUES (article_author, FALSE, NULL, NULL, NULL, NEW.post_id, 'COMMENT');
  ELSE
    INSERT INTO notification(receiver_id, is_read, msg, fb_giver, rated_post, new_comment, type)
        VALUES (parent_author, FALSE, NULL, NULL, NULL, NEW.post_id, 'COMMENT');
  END IF;
  RETURN NULL;
END
$BODY$

LANGUAGE plpgsql;
CREATE TRIGGER create_comment_notification
    AFTER INSERT ON comment
    FOR EACH ROW
    EXECUTE PROCEDURE create_comment_notification();
```

### 4. Transactions

| Transaction     | TRAN01                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           |
| --------------- | ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------ |
| Description     | Insert a new article or comment                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  |
| Justfication    | In order to maintain consistency, it's necessary to ensure that all this code executes without errors, when inserting a comment or an article. If an error occurs, a ROLLBACK is done without effectively changing the tables. The isolation level is Repeatable Read because an update on the sequence post_id_seq, caused by an insert in the table post by a concurrent transaction, would cause an article or comment to be associated to a wrong post. This also happens when inserting entries in the article_tag table, like shown below. |
| Isolation level | REPEATABLE READ                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                  |

**SQL code:**

```sql
BEGIN TRANSACTION;

SET TRANSACTION ISOLATION LEVEL REPEATABLE READ;

INSERT INTO "post" (body, published_date, is_edited, likes, dislikes, author_id)
  VALUES ($body, $published_date, $is_edited, $likes, $dislikes, $author_id);

INSERT INTO "article" (post_id, title, thumbnail)
  VALUES (currval('post_id_seq'), $title, $thumbnail);

INSERT INTO "article_topic"(article_id, topic_id)
  VALUES (currval('article_id_seq'), $topic_id);

COMMIT;

BEGIN TRANSACTION;

SET TRANSACTION ISOLATION LEVEL REPEATABLE READ;

INSERT INTO "post" (body, published_date, is_edited, likes, dislikes, author_id)
  VALUES ($body, $published_date, $is_edited, $likes, $dislikes, $author_id);

INSERT INTO "comment" (post_id, article_id, parent_comment_id)
  VALUES (currval('post_id_seq'), $article_id, $parent_comment_id);

COMMIT;
```

| Transaction     | TRAN02                                                                                                                                                                                                                                                                                                                                                                                                                                                           |
| --------------- | ---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| Description     | Fetch updated information about an article, including the author data, as well as the comments of that article                                                                                                                                                                                                                                                                                                                                                   |
| Justfication    | In order to always show reliable information about an article, it’s necessary to ensure that all this code fetches committed information about it. This includes the user information, such as its reputation, the user's comments and their respective feedback. The isolation level is READ COMMITED, because we desire to fetch stable information, but there's no need to limit new concurrent feedback. Finally, it's READ ONLY since it only uses Selects. |
| Isolation level | READ COMMITED READ ONLY                                                                                                                                                                                                                                                                                                                                                                                                                                          |

**SQL code:**

```sql
BEGIN TRANSACTION;

SET TRANSACTION ISOLATION LEVEL READ COMMITTED READ ONLY;

SELECT username, avatar, reputation FROM authenticated_user
WHERE id=$author_id;

SELECT parent_comment_id, body, published_at, is_edited, likes, dislikes, name, avatar
FROM comment INNER JOIN post ON (comment.post_id=post.id)
    INNER JOIN authenticated_user ON (post.author_id=authenticated_user.id)
WHERE article_id=$article_id;

COMMIT;
```

## Annex A.SQL Code

### A.1 Database schema

```sql
DROP SCHEMA IF EXISTS lbaw22131 CASCADE;
CREATE SCHEMA lbaw22131;

SET search_path TO lbaw22131;

-----------------------------------------
-- DOMAINS
-----------------------------------------

CREATE DOMAIN VALID_EMAIL AS TEXT CHECK(VALUE LIKE '_%@_%.__%');

-----------------------------------------
-- TYPES
-----------------------------------------

CREATE TYPE PROPOSED_TOPIC_STATUS AS ENUM ('PENDING', 'ACCEPTED', 'REJECTED');
CREATE TYPE NOTIFICATION_TYPE AS ENUM ('FEEDBACK', 'COMMENT');

-----------------------------------------
-- TABLES
-----------------------------------------

CREATE TABLE authenticated_user(
  id SERIAL PRIMARY KEY,
  username TEXT NOT NULL,
  email VALID_EMAIL UNIQUE,
  date_of_birth TIMESTAMP NOT NULL CHECK (CURRENT_TIMESTAMP >= date_of_birth),
  is_admin BOOLEAN DEFAULT false,
  password TEXT NOT NULL,
  avatar TEXT,
  is_suspended BOOLEAN NOT NULL DEFAULT FALSE,
  reputation INTEGER NOT NULL DEFAULT 0
);

-----------------------------------------

CREATE TABLE suspension(
  id SERIAL PRIMARY KEY,
  reason TEXT NOT NULL,
  start_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  end_time TIMESTAMP NOT NULL CHECK (end_time >= start_time),
  admin_id INTEGER REFERENCES authenticated_user(id) ON DELETE SET NULL ON UPDATE CASCADE,
  user_id INTEGER NOT NULL REFERENCES authenticated_user(id) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT diff_entities CHECK (admin_id != user_id)
);

-----------------------------------------

CREATE TABLE report(
  id SERIAL PRIMARY KEY,
  reason TEXT NOT NULL,
  reported_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  is_closed BOOLEAN DEFAULT false,
  reported_id INTEGER NOT NULL REFERENCES authenticated_user(id) ON DELETE CASCADE ON UPDATE CASCADE,
  reporter_id INTEGER REFERENCES authenticated_user(id) ON UPDATE CASCADE ON DELETE SET NULL,
  CONSTRAINT different_ids CHECK (reporter_id != reported_id)
);

-----------------------------------------

CREATE TABLE topic(
  id SERIAL PRIMARY KEY,
  subject TEXT NOT NULL UNIQUE,
  topic_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  status PROPOSED_TOPIC_STATUS NOT NULL DEFAULT 'PENDING',
  user_id INTEGER REFERENCES authenticated_user(id) ON DELETE SET NULL ON UPDATE CASCADE
);

-----------------------------------------

CREATE TABLE follow(
  follower_id INTEGER REFERENCES authenticated_user(id) ON DELETE CASCADE ON UPDATE CASCADE,
  followed_id INTEGER REFERENCES authenticated_user(id) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT own_follows CHECK (follower_id != followed_id),
  PRIMARY KEY(follower_id, followed_id)
);

-----------------------------------------

CREATE TABLE post(
  id SERIAL PRIMARY KEY,
  body TEXT NOT NULL,
  published_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  is_edited BOOLEAN DEFAULT false,
  likes INTEGER DEFAULT 0 CHECK (likes >= 0),
  dislikes INTEGER DEFAULT 0 CHECK (dislikes >= 0),
  author_id INTEGER REFERENCES authenticated_user(id) ON DELETE SET NULL ON UPDATE CASCADE
);

-----------------------------------------

CREATE TABLE article(
  post_id INTEGER PRIMARY KEY REFERENCES post(id) ON DELETE CASCADE ON UPDATE CASCADE,
  title TEXT NOT NULL,
  thumbnail TEXT
);

-----------------------------------------

CREATE TABLE comment(
  post_id INTEGER PRIMARY KEY REFERENCES post(id) ON DELETE CASCADE ON UPDATE CASCADE,
  article_id INTEGER NOT NULL REFERENCES article(post_id) ON DELETE CASCADE ON UPDATE CASCADE,
  parent_comment_id INTEGER REFERENCES comment(post_id) ON DELETE CASCADE ON UPDATE CASCADE
);

-----------------------------------------

CREATE TABLE feedback(
  id SERIAL PRIMARY KEY,
  user_id INTEGER REFERENCES authenticated_user(id) ON DELETE SET NULL ON UPDATE CASCADE,
  post_id INTEGER NOT NULL REFERENCES post(id) ON DELETE CASCADE ON UPDATE CASCADE,
  is_like BOOLEAN NOT NULL
);

-----------------------------------------

CREATE TABLE article_topic(
  article_id INTEGER REFERENCES article(post_id) ON DELETE CASCADE ON UPDATE CASCADE,
  topic_id INTEGER REFERENCES topic(id) ON DELETE CASCADE ON UPDATE CASCADE,
  PRIMARY KEY(article_id, topic_id)
);


-----------------------------------------

CREATE TABLE notification(
  id SERIAL PRIMARY KEY,
  receiver_id INTEGER NOT NULL REFERENCES authenticated_user(id) ON DELETE CASCADE ON UPDATE CASCADE,
  date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  is_read BOOLEAN DEFAULT false,
  msg TEXT NOT NULL,
  fb_giver INTEGER REFERENCES authenticated_user(id) ON DELETE CASCADE ON UPDATE CASCADE,
  rated_post INTEGER REFERENCES post(id) ON DELETE CASCADE ON UPDATE CASCADE,
  new_comment INTEGER REFERENCES comment(post_id) ON DELETE CASCADE ON UPDATE CASCADE,
  type NOTIFICATION_TYPE NOT NULL
);

-----------------------------------------
-- PERFORMANCE INDICES
-----------------------------------------

CREATE INDEX post_author ON post USING hash (author_id);

CREATE INDEX notification_receiver ON notification USING hash (receiver_id);

-----------------------------------------
-- FULL-TEXT SEARCH INDICES
-----------------------------------------

ALTER TABLE article ADD COLUMN tsvectors TSVECTOR;

CREATE FUNCTION article_search_update() RETURNS TRIGGER AS $$
DECLARE new_body text = (select body from post where id = NEW.post_id);
DECLARE old_body text = (select body from post where id = OLD.post_id);
BEGIN
  IF TG_OP = 'INSERT' THEN
    NEW.tsvectors = (
      setweight(to_tsvector('english', NEW.title), 'A') ||
      setweight(to_tsvector('english', new_body), 'B')
    );
  END IF;

  IF TG_OP = 'UPDATE' THEN
      IF (NEW.title <> OLD.title OR new_body <> old_body) THEN
        NEW.tsvectors = (
          setweight(to_tsvector('english', NEW.title), 'A') ||
          setweight(to_tsvector('english', new_body), 'B')
        );
      END IF;
  END IF;

  RETURN NEW;
END $$
LANGUAGE plpgsql;

CREATE TRIGGER article_search_update
  BEFORE INSERT OR UPDATE ON article
  FOR EACH ROW
  EXECUTE PROCEDURE article_search_update();

CREATE INDEX article_search ON article USING GIST (tsvectors);

-----------------------------------------

ALTER TABLE authenticated_user ADD COLUMN tsvectors TSVECTOR;

CREATE FUNCTION user_search_update() RETURNS TRIGGER AS $$
BEGIN
  IF TG_OP = 'INSERT' THEN
    NEW.tsvectors = (
      setweight(to_tsvector('english', NEW.username), 'A') ||
      setweight(to_tsvector('english', NEW.email), 'B')
    );
  END IF;

  IF TG_OP = 'UPDATE' THEN
      IF (NEW.username <> OLD.username OR NEW.email <> OLD.email) THEN
        NEW.tsvectors = (
          setweight(to_tsvector('english', NEW.username), 'A') ||
          setweight(to_tsvector('english', NEW.email), 'B')
        );
      END IF;
  END IF;

  RETURN NEW;
END $$
LANGUAGE plpgsql;

CREATE TRIGGER user_search_update
  BEFORE INSERT OR UPDATE ON authenticated_user
  FOR EACH ROW
  EXECUTE PROCEDURE user_search_update();

CREATE INDEX user_search ON authenticated_user USING GIST (tsvectors);

-----------------------------------------
-- TRIGGERS
-----------------------------------------

/*
Trigger to update likes/dislikes of a post when feedback is given,
creates a notification on that feedback and updates user reputation.
*/
CREATE FUNCTION feedback_post() RETURNS TRIGGER AS
$BODY$
DECLARE author_id authenticated_user.id%type = (
  SELECT author_id FROM post INNER JOIN authenticated_user ON (post.author_id = authenticated_user.id)
  WHERE post.id = NEW.post_id
);
DECLARE feedback_value INTEGER = 1;
BEGIN
    IF (NOT NEW.is_like)
        THEN feedback_value = -1;
    END IF;

    IF (NEW.is_like) THEN
        UPDATE post SET likes = likes + 1 WHERE id = NEW.post_id;
    ELSE
        UPDATE post SET dislikes = dislikes + 1 WHERE id = NEW.post_id;
    END IF;

    UPDATE authenticated_user SET reputation = reputation + feedback_value
    WHERE id = author_id;

    INSERT INTO notification(receiver_id, is_read, msg, fb_giver, rated_post, new_comment, type)
    VALUES (author_id, FALSE, NULL, NEW.user_id, NEW.post_id, NULL, 'FEEDBACK');

    RETURN NULL;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER feedback_post
    AFTER INSERT ON feedback
    FOR EACH ROW
    EXECUTE PROCEDURE feedback_post();

-----------------------------------------

-- Trigger to remove like/dislike of a post when feedback on it is removed and to update authenticated user reputation.
CREATE FUNCTION remove_feedback() RETURNS TRIGGER AS
$BODY$
DECLARE author_id authenticated_user.id%type = (SELECT author_id FROM post INNER JOIN authenticated_user ON (post.author_id = authenticated_user.id) WHERE post.id = OLD.post_id);
DECLARE feedback_value INTEGER = -1;
BEGIN
    IF (NOT OLD.is_like)
        THEN feedback_value = 1;
    END IF;

    IF (OLD.is_like) THEN
        UPDATE post SET likes = likes - 1 WHERE id = OLD.post_id;
    ELSE
        UPDATE post SET dislikes = dislikes - 1 WHERE id = OLD.post_id;
    END IF;

    UPDATE authenticated_user SET reputation = reputation + feedback_value
    WHERE id = author_id;

    RETURN NULL;
END
$BODY$

LANGUAGE plpgsql;

CREATE TRIGGER remove_feedback
    AFTER DELETE ON feedback
    FOR EACH ROW
    EXECUTE PROCEDURE remove_feedback();

-----------------------------------------

-- Trigger to prevent users from liking or disliking his\her own post (articles or comments)
CREATE FUNCTION check_feedback() RETURNS TRIGGER AS
$BODY$
BEGIN
    IF (NEW.user_id in (
        SELECT post.author_id
        FROM post
        WHERE post.id = NEW.post_id)) THEN
            RAISE EXCEPTION 'You cannot give feedback on your own post';
    END IF;
    RETURN NEW;
END;
$BODY$

LANGUAGE plpgsql;

CREATE TRIGGER check_feedback
    BEFORE INSERT ON feedback
    FOR EACH ROW
    EXECUTE PROCEDURE check_feedback();

-----------------------------------------

/*
Trigger to delete all the information about an article that was deleted
it just needs to delete the post represented by that article
since its that deletion is cascaded to the comments and other elements of the article
*/
CREATE FUNCTION delete_article() RETURNS TRIGGER AS
$BODY$
BEGIN
    DELETE FROM post WHERE post.id = OLD.post_id;
    RETURN OLD;
END
$BODY$

LANGUAGE plpgsql;

CREATE TRIGGER delete_article
    AFTER DELETE ON article
    FOR EACH ROW
    EXECUTE PROCEDURE delete_article();


-----------------------------------------

/*
Trigger to delete the respective post of a comment when a comment
is deleted. */
CREATE FUNCTION delete_comment() RETURNS TRIGGER AS
$BODY$
BEGIN
    DELETE FROM post WHERE post.id = OLD.post_id;
    RETURN OLD;
END
$BODY$

LANGUAGE plpgsql;


CREATE TRIGGER delete_comment
    AFTER DELETE ON comment
    FOR EACH ROW
    EXECUTE PROCEDURE delete_comment();

-----------------------------------------

-- Trigger to prevent an article from having an unaccepted topic or more than 3 topics
CREATE FUNCTION add_article_topic_check() RETURNS TRIGGER AS
$BODY$
BEGIN
    IF ((SELECT state FROM topic WHERE NEW.topic_id = topic.id) <> 'ACCEPTED')
    THEN
        RAISE EXCEPTION 'You cannot associate an article to an Unaccepted topic';
    END IF;

    IF ((SELECT COUNT(*) FROM article_topic  WHERE article_id = NEW.article_id)) >= 3
    THEN
        RAISE EXCEPTION 'You cannot associate anymore topics to this article';
    END IF;
    RETURN NEW;
END
$BODY$

LANGUAGE plpgsql;

CREATE TRIGGER add_article_topic_check
    BEFORE INSERT ON article_topic
    FOR EACH ROW
    EXECUTE PROCEDURE add_article_topic_check();

-----------------------------------------

-- Triggers to update the *is_edited* flag when a post's body or an article's title is updated
CREATE FUNCTION set_post_is_edited() RETURNS TRIGGER AS
$BODY$
BEGIN
    UPDATE post SET is_edited = TRUE
    WHERE id = NEW.id;
	RETURN NULL;
END
$BODY$

LANGUAGE plpgsql;

CREATE TRIGGER set_post_is_edited
    AFTER UPDATE ON post
    FOR EACH ROW
    WHEN (OLD.body IS DISTINCT FROM NEW.body)
    EXECUTE PROCEDURE set_post_is_edited();

-----------------------------------------

-- Trigger to mark the post as edited when an article's title is changed
CREATE FUNCTION set_article_is_edited() RETURNS TRIGGER AS
$BODY$
BEGIN
    UPDATE post SET is_edited = TRUE
    WHERE id = NEW.post_id;
	RETURN NULL;
END
$BODY$

LANGUAGE plpgsql;

CREATE TRIGGER set_article_is_edited
    AFTER UPDATE ON article
    FOR EACH ROW
    WHEN (OLD.title IS DISTINCT FROM NEW.title)
    EXECUTE PROCEDURE set_article_is_edited();

-----------------------------------------

-- Trigger to put authenticated_user flag to true if a suspension on him is created
CREATE FUNCTION is_suspended_flag_true() RETURNS TRIGGER AS
$BODY$
BEGIN
    UPDATE authenticated_user SET is_suspended = true
    WHERE id = NEW.user_id;
	RETURN NEW;
END
$BODY$

LANGUAGE plpgsql;

CREATE TRIGGER is_suspended_flag_true
    AFTER INSERT ON suspension
    FOR EACH ROW
    EXECUTE PROCEDURE is_suspended_flag_true();


-----------------------------------------

-- Trigger to create a notification when a comment is created

CREATE FUNCTION create_comment_notification() RETURNS TRIGGER AS
$BODY$
DECLARE article_author INTEGER = (
  SELECT author_id FROM post WHERE id = NEW.article_id
);
DECLARE parent_author INTEGER = (
  SELECT author_id FROM post WHERE id = NEW.parent_comment_id
);
BEGIN
  IF parent_author IS NULL THEN
    INSERT INTO notification(receiver_id, is_read, msg, fb_giver, rated_post, new_comment, type)
        VALUES (article_author, FALSE, NULL, NULL, NULL, NEW.post_id, 'COMMENT');
  ELSE
    INSERT INTO notification(receiver_id, is_read, msg, fb_giver, rated_post, new_comment, type)
        VALUES (parent_author, FALSE, NULL, NULL, NULL, NEW.post_id, 'COMMENT');
  END IF;
  RETURN NULL;
END
$BODY$

LANGUAGE plpgsql;
CREATE TRIGGER create_comment_notification
    AFTER INSERT ON comment
    FOR EACH ROW
    EXECUTE PROCEDURE create_comment_notification();
```

### A.3 Database population

```sql
SET search_path TO lbaw22131;

INSERT INTO authenticated_user (username, email, date_of_birth, is_admin, password, avatar, is_suspended, reputation)
VALUES
    ('wilsonedgar', 'angelawarren@gmail.com', TO_TIMESTAMP('1941-01-20', 'YYYY-MM-DD'), True, '9bd8fc89d6aa8b6cc5a412af2e9b98f4', 'https://imgur.com/KEdjFB.jpg', False, 516),
    ('aliciagiles', 'gonzalezjose@hotmail.com', TO_TIMESTAMP('1961-12-17', 'YYYY-MM-DD'), True, '4a2ae0b1f2167355b2528711b156982b', 'https://imgur.com/DPbexm.jpg', False, 631),
    ('youngthomas', 'cynthia64@hotmail.com', TO_TIMESTAMP('1967-07-18', 'YYYY-MM-DD'), False, 'f997b0f751f8bf4008536c6a5870efd1', 'https://imgur.com/qrPvja.jpg', False, 826),
    ('collinstanya', 'prestonhuff@hotmail.com', TO_TIMESTAMP('1944-06-09', 'YYYY-MM-DD'), False, '847d913369818e9da39e5783a89c2f53', 'https://imgur.com/fkrSjs.jpg', False, 715),
    ('mccallbrian', 'anthonyross@gmail.com', TO_TIMESTAMP('1912-05-18', 'YYYY-MM-DD'), True, '6566d27d344f200a5c554f0632ebbacf', 'https://imgur.com/bKlnAm.jpg', False, 26),
    ('gwhite', 'mhaney@hotmail.com', TO_TIMESTAMP('1955-10-19', 'YYYY-MM-DD'), False, '469c6b97a601ccbee7981e3a0f63ead2', 'https://imgur.com/AqficW.jpg', True, -99),
    ('rodriguezjoseph', 'michaelschultz@hotmail.com', TO_TIMESTAMP('1973-05-01', 'YYYY-MM-DD'), False, 'b317367df06f75fc70de2a441750d92a', 'https://imgur.com/ReyJZG.jpg', False, 420),
    ('rosesamuel', 'mwilliamson@gmail.com', TO_TIMESTAMP('1956-05-10', 'YYYY-MM-DD'), False, 'f5a21f5ba9e4769e5bb65300a871efec', 'https://imgur.com/Vpyjrg.jpg', False, 678),
    ('derrick06', 'mrivera@hotmail.com', TO_TIMESTAMP('2005-02-23', 'YYYY-MM-DD'), False, '42593cdba1ea4ae98fd28ce7c09eba75', 'https://imgur.com/QTpDyv.jpg', False, 859),
    ('cassandracalderon', 'bondkristen@yahoo.com', TO_TIMESTAMP('1972-12-27', 'YYYY-MM-DD'), False, 'c5f195a014d9a382bfac4fa35b0cabfd', 'https://imgur.com/UcnRYF.jpg', False, 136),
    ('igiles', 'samuel05@gmail.com', TO_TIMESTAMP('1958-12-31', 'YYYY-MM-DD'), False, '619962a6eda46825878e5b77272e86a7', 'https://imgur.com/AxHvGB.jpg', True, 347),
    ('anthonykim', 'hlee@gmail.com', TO_TIMESTAMP('1996-04-25', 'YYYY-MM-DD'), False, 'f6f9d833e471f5bfe3f9a5d4f5da4fec', 'https://imgur.com/WCfJfY.jpg', False, 319),
    ('johnwaters', 'jamesbarron@yahoo.com', TO_TIMESTAMP('1921-08-23', 'YYYY-MM-DD'), False, '33391a9226ddc34cc7c9ecf4dc6a5b46', 'https://imgur.com/WLpgIB.jpg', True, -54),
    ('danielle24', 'qfoster@gmail.com', TO_TIMESTAMP('1950-07-10', 'YYYY-MM-DD'), False, '932cc9fc81b3a678a09100e150cd94dd', 'https://imgur.com/gJfvRo.jpg', True, 202),
    ('ideleon', 'amandawilliams@gmail.com', TO_TIMESTAMP('1955-11-24', 'YYYY-MM-DD'), False, 'e711eaba7e42d052f123c1b9b0609a51', 'https://imgur.com/EsUaUw.jpg', False, 782);

INSERT INTO suspension (reason, start_time, end_time, admin_id, user_id)
VALUES
    ('nsfw profile pic and comments', TO_TIMESTAMP('2022-03-23', 'YYYY-MM-DD'), TO_TIMESTAMP('2025-10-19', 'YYYY-MM-DD'), 1,6),
    ('Threatening another user', TO_TIMESTAMP('2023-03-23', 'YYYY-MM-DD'), TO_TIMESTAMP('2025-08-07', 'YYYY-MM-DD'),5,11),
    ('Threatening another user', TO_TIMESTAMP('2022-02-09', 'YYYY-MM-DD'), TO_TIMESTAMP('2025-01-18', 'YYYY-MM-DD'),1,13),
    ('Hate speech', TO_TIMESTAMP('2022-10-11', 'YYYY-MM-DD'), TO_TIMESTAMP('2025-01-23', 'YYYY-MM-DD'),2,14);

INSERT INTO report (reason, reported_at, is_closed, reported_id, reporter_id)
VALUES
    ('Toxic person', TO_TIMESTAMP('2021-04-21', 'YYYY-MM-DD'), True, 4,3),
    ('Disrespectful towards my culture', TO_TIMESTAMP('2021-08-11', 'YYYY-MM-DD'), True, 13,8),
    ('Promoting another website', TO_TIMESTAMP('2022-09-11', 'YYYY-MM-DD'), True, 8,10),
    ('Offensive profile picture', TO_TIMESTAMP('2021-12-26', 'YYYY-MM-DD'), True, 6,3),
    ('Hate attitude on comment section', TO_TIMESTAMP('2020-10-30', 'YYYY-MM-DD'), True, 14,4),
    ('He told me he would find me and kill me', TO_TIMESTAMP('2021-10-19', 'YYYY-MM-DD'), True, 11,12),
    ('NSFW profile picture and comments', TO_TIMESTAMP('2021-08-19', 'YYYY-MM-DD'), True, 6,12),
    ('I dont like this person', TO_TIMESTAMP('2021-07-19', 'YYYY-MM-DD'), True, 15,8),
    ('Kick her out of this website please', TO_TIMESTAMP('2021-11-30', 'YYYY-MM-DD'), False, 3,4),
    ('Told me to oof myself', TO_TIMESTAMP('2021-01-24', 'YYYY-MM-DD'), True, 13,4);

INSERT INTO topic (subject, proposed_at, status, proposer_id)
VALUES
    ('Sports', TO_TIMESTAMP('2021-10-03', 'YYYY-MM-DD'), 'Accepted',1),
    ('Movies', TO_TIMESTAMP('2022-07-01', 'YYYY-MM-DD'), 'Accepted',2),
    ('Anime', TO_TIMESTAMP('2021-01-20', 'YYYY-MM-DD'), 'Accepted',3),
    ('Crime', TO_TIMESTAMP('2020-12-31', 'YYYY-MM-DD'), 'Rejected',4),
    ('Health', TO_TIMESTAMP('2022-04-09', 'YYYY-MM-DD'), 'Accepted',5),
    ('Science', TO_TIMESTAMP('2022-07-01', 'YYYY-MM-DD'), 'Accepte',6),
    ('Fights', TO_TIMESTAMP('2022-08-05', 'YYYY-MM-DD'), 'Accepted',7),
    ('Religion', TO_TIMESTAMP('2022-06-26', 'YYYY-MM-DD'), 'Accepted',8),
    ('Law', TO_TIMESTAMP('2021-02-24', 'YYYY-MM-DD'), 'Accepted',9),
    ('Games', TO_TIMESTAMP('2021-10-01', 'YYYY-MM-DD'), 'Pending',10);

INSERT INTO follow (follower_id, followed_id)
VALUES
    (1,2),
    (2,1),
    (3,4),
    (4,5),
    (2,3),
    (3,1),
    (14,12),
    (15,11),
    (8,9),
    (9,1),
    (6,2);

INSERT INTO post (body, published_date, is_edited, likes, dislikes, author_id)
VALUE
    ('When referring Center on', TO_TIMESTAMP('1977-08-31', 'YYYY-MM-DD'), False, 54, 75, 1),
    ('Become attached or étages. These physical types, in', TO_TIMESTAMP('1954-06-07', 'YYYY-MM-DD'), False, 12, 2, 3),
    ('Simple compounds, Christian Andersen (1805–1875), the philosophical works of Jābir ibn Hayyān (721–815 CE), al-Battani', TO_TIMESTAMP('1947-11-24', 'YYYY-MM-DD'), False, 51, 16, 2),
    ('And substorms, by GovPubs at the same time, some organizations now use the CFP franc', TO_TIMESTAMP('1983-11-28', 'YYYY-MM-DD'), False, 72, 76, 6),
    ('Of conception. Sea, Tasman Sea, and Mediterranean', TO_TIMESTAMP('1945-03-22', 'YYYY-MM-DD'), False, 34, 70, 11),
    ('(the Internet body temperature', TO_TIMESTAMP('1987-08-26', 'YYYY-MM-DD'), False, 13, 40, 13),
    ('Crossed from or low-pressure', TO_TIMESTAMP('2014-11-18', 'YYYY-MM-DD'), False, 61, 5, 9),
    ('(corn and Montana, which has eleven judges appointed by the crown and the', TO_TIMESTAMP('1938-12-02', 'YYYY-MM-DD'), False, 9, 31, 13);

INSERT INTO article (post_id, title, thumbnail)
VALUE
    (1, 'Boasted a strong tongue (containing similar touch receptors to', 'https://imgur.com/gJglZK.jpg'),
    (2, 'Threaten Egypts main systems of considerable Amerindian ancestry form the Downtown Loop, runs 2.7 miles', 'https://imgur.com/uvIeAn.jpg'),
    (3, 'One "fair" secure Virtual', 'https://imgur.com/HJaWqL.jpg'),
    (4, 'Prediction must tasks, but on', 'https://imgur.com/djlhDb.jpg'),

INSERT INTO comment (post_id, article_id, parent_comment_id)
VALUE
    (7,1,NULL),
    (2,3,NULL),
    (5,4,NULL),
    (7,5,NULL);

INSERT INTO feedback (user_id, post_id, is_like)
VALUE
    (1,2,True),
    (2,5,False),
    (6,1,True),
    (7,3, True),
    (14, 4, False);

INSERT INTO article_topic(article_id, topic_id)
VALUE
    (1,3),
    (2,2),
    (3,7),
    (4,8);
```

## Revision History

- 13/10 - New Business Rule 06 added
- 13/10 - Visitor user storie changed
- 18/10 - business rules(admin) changed
- 23/10 - Updated user stories so that the user can not comment or vote on it's own content

GRUPO 131, 23/10/2022

- André Leonor, up201806860@edu.fe.up.pt
- Bruno Pascoal, up201705562@edu.fc.up.pt
- Fernando Barros, up201910223@edu.fc.up.pt
- Miguel Curval, up201105191@edu.fe.up.pt

EDB editor Bruno Pascoal
