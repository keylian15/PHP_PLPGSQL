DROP TABLE IF EXISTS mp_users;

CREATE TABLE
    IF NOT EXISTS mp_users (
        rowid SERIAL PRIMARY KEY,
        username varchar(64) NOT NULL UNIQUE,
        password varchar(255) NOT NULL,
        firstname varchar(64) NOT NULL,
        lastname varchar(64) NOT NULL,
        date_created timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
        date_updated timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
        admin boolean not null DEFAULT false
    );

insert into
    mp_users (
        username,
        password,
        firstname,
        lastname,
        date_created,
        date_updated,
        admin
    )
values
    (
        'admin',
        md5 ('2v85$%jU'),
        'Keylian',
        'Turbe',
        '2024-11-25 18:43:00',
        '2024-11-25 18:43:00',
        true
    );