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