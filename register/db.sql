-- old incorrect table--
CREATE TABLE users (
    user_id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) UNIQUE NOT NULL,
    username VARCHAR(20) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIME,
);

--query to delete old table from database
DROP TABLE IF EXISTS users;

--new table--
CREATE TABLE users (
    user_id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) UNIQUE NOT NULL,
    username VARCHAR(20) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
);


--create the payments table
CREATE TABLE payments (
    paymentID INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY, -- auto increment a primary key
    card_number VARCHAR(16) NOT NULL, --no more than 16 characters
    expiry_date VARCHAR(5) NOT NULL, --max 5 character
    cvv VARCHAR(3) NOT NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
);

-- Create the bookings table
CREATE TABLE bookings (
    bookingID INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNSIGNED NOT NULL,
    paymentID INT UNSIGNED NOT NULL,
    startStation VARCHAR(50) NOT NULL,
    destinationStation VARCHAR(50) NOT NULL,
    startDate DATE NOT NULL,
    startTime TIME NOT NULL,
    returnDate DATE,
    returnTime TIME,
    numTickets INT NOT NULL,
    totalPrice INT NOT NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (userID) REFERENCES users(userID),
    FOREIGN KEY (paymentID) REFERENCES payments(paymentID)
);

CREATE TABLE announcements (
    announcementID INT UNSIGNED NOT NULL, AUTO_INCREMENT PRIMARY KEY, --auto increment primary key id
    announcement VARCHAR(300) NOT NULL, --announcement cannot be null or more than 300 characters
    date DATE NOT NULL, --must not be null
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP, --timestamp time of creation
);