CREATE TABLE users (
    id    serial PRIMARY KEY,
    name  VARCHAR (255) NOT NULL,
    email VARCHAR (255) NOT NULL UNIQUE,
    password VARCHAR (255) NOT NULL,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);

