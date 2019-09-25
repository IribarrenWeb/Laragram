CREATE DATABASE IF NOT EXISTS laravel_master;
USE laravel_master;

CREATE TABLE IF NOT EXISTS users(

    id              int(255) auto_increment not null,
    role            varchar(50) not null,  
    name            varchar(100) not null,
    surname         varchar(100) not null,
    nick            varchar(100) not null,
    email           varchar(255) not null,
    password        varchar(255) not null,
    image           varchar(255),
    created_at      datetime     not null,
    updated_at      datetime     not null,
    remember_token  varchar(255),
    CONSTRAINT pk_users PRIMARY KEY(id)

) ENGINE=InnoDb;

INSERT INTO users VALUES('','user', 'Keinher', 'Gutierrez', 'guti19', 'keinher@keinher.com', 'pass', null, CURTIME(), CURTIME(), null);
INSERT INTO users VALUES('','user', 'Rafael', 'Gonzales', 'rafa1', 'rafa@rafa.com', 'pass', null, CURTIME(), CURTIME(), null);
INSERT INTO users VALUES('','user', 'Roberto', 'Alonso', 'alonso123', 'alonso@alonso.com', 'pass', null, CURTIME(), CURTIME(), null);
INSERT INTO users VALUES('','user', 'Tami', 'Bahia', 'tami20', 'tami@tami.com', 'pass', null, CURTIME(), CURTIME(), null);


CREATE TABLE IF NOT EXISTS images(

    id              int(255) auto_increment not null,
    user_id         int(255) not null,  
    image_path      varchar(255) not null,
    description     text,
    created_at      datetime     not null,
    updated_at      datetime     not null,
    CONSTRAINT pk_image PRIMARY KEY(id),
    CONSTRAINT fk_image_users FOREIGN KEY(user_id) REFERENCES users(id)

) ENGINE=InnoDb;

INSERT INTO images VALUES('',1, 'test.jpg', 'Lorem ipsum.', CURTIME(), CURTIME());
INSERT INTO images VALUES('',2, 'test1.jpg', 'Lorem ipsum dolor sit.', CURTIME(), CURTIME());
INSERT INTO images VALUES('',3, 'test2.jpg', 'Lorem ipsum dolor.', CURTIME(), CURTIME());
INSERT INTO images VALUES('',4, 'test.png', 'Lorem ipsum dolor.', CURTIME(), CURTIME());


CREATE TABLE IF NOT EXISTS comments(

    id              int(255) auto_increment not null,
    image_id        int(255) not null,  
    user_id         int(255) not null,  
    content         text,
    created_at      datetime     not null,
    updated_at      datetime     not null,
    CONSTRAINT pk_comments PRIMARY KEY(id),
    CONSTRAINT fk_comments_users FOREIGN KEY(user_id) REFERENCES users(id),
    CONSTRAINT fk_comments_image FOREIGN KEY(image_id) REFERENCES image(id)

) ENGINE=InnoDb;

INSERT INTO comments VALUES('',1, 2, 'Lorem ipsum. Lorem ipsum dolor sit amet, consectetur.', CURTIME(), CURTIME());
INSERT INTO comments VALUES('',2, 3, 'Lorem ipsum dolor sit. Lorem ipsum dolor sit amet.', CURTIME(), CURTIME());
INSERT INTO comments VALUES('',3, 1, 'Lorem ipsum dolor. Lorem ipsum dolor sit amet, consectetur adipisicing elit.', CURTIME(), CURTIME());
INSERT INTO comments VALUES('',4, 4, 'Lorem ipsum dolor lorem ipsum dolor.', CURTIME(), CURTIME());

INSERT INTO comments VALUES('',3, 2, 'Lorem ipsum dolor sit amet, consectetur.', CURTIME(), CURTIME());
INSERT INTO comments VALUES('',3, 4, 'Lorem ipsum dolor sit. Lorem ipsum dolor sit amet.', CURTIME(), CURTIME());
INSERT INTO comments VALUES('',3, 1, 'Lorem ipsum dolor sit amet, consectetur adipisicing elit.', CURTIME(), CURTIME());
INSERT INTO comments VALUES('',1, 4, 'Lorem ipsum dolor lorem ipsum Lorem ipsum dolor. dolor.', CURTIME(), CURTIME());

CREATE TABLE IF NOT EXISTS likes(

    id              int(255) auto_increment not null,
    image_id        int(255) not null,  
    user_id         int(255) not null,
    created_at      datetime     not null,
    updated_at      datetime     not null,
    CONSTRAINT pk_likes PRIMARY KEY(id),
    CONSTRAINT fk_likes_users FOREIGN KEY(user_id) REFERENCES users(id),
    CONSTRAINT fk_likes_image FOREIGN KEY(image_id) REFERENCES image(id)

) ENGINE=InnoDb;

INSERT INTO likes VALUES('',4, 2, CURTIME(), CURTIME());
INSERT INTO likes VALUES('',2, 1, CURTIME(), CURTIME());
INSERT INTO likes VALUES('',4, 1, CURTIME(), CURTIME());
INSERT INTO likes VALUES('',3, 2, CURTIME(), CURTIME());
INSERT INTO likes VALUES('',1, 4, CURTIME(), CURTIME());
INSERT INTO likes VALUES('',3, 1, CURTIME(), CURTIME());
INSERT INTO likes VALUES('',3, 2, CURTIME(), CURTIME());
INSERT INTO likes VALUES('',3, 4, CURTIME(), CURTIME());

