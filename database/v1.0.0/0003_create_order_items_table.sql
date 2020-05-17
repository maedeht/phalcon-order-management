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