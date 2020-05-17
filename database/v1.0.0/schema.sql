CREATE TABLE users (
    id    serial PRIMARY KEY,
    name  VARCHAR (255) NOT NULL,
    email VARCHAR (255) NOT NULL UNIQUE,
    password VARCHAR (255) NOT NULL,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);

CREATE TABLE orders (
    id    serial PRIMARY KEY,
    order_number  VARCHAR (255) NOT NULL UNIQUE,
    description VARCHAR (255),
    total_price INTEGER NOT NULL,
    status INTEGER DEFAULT 1,
    user_id INTEGER,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    FOREIGN  KEY (user_id) REFERENCES users (id)
);

CREATE TABLE order_items (
    id    serial PRIMARY KEY,
    product  VARCHAR (255) NOT NULL,
    qty INTEGER DEFAULT 1,
    price INTEGER NOT NULL,
    order_id INTEGER,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    FOREIGN KEY (order_id) REFERENCES orders (id)
);