		create database petshop;
		use petshop;

		create table users
		(
			user_id int auto_increment primary key,
			fullname varchar(100) not null,
			username varchar(100) not null,
			password varchar(50) not null,
			email varchar(100) not null,
			phonenumber varchar(20) not null,
			birthday date,
			gender enum('male', 'female'),
			avatar varchar(255),
			role enum('user', 'admin') default 'user' not null
		);

		create table categories 
		(
			category_id int auto_increment primary key,
			name varchar(255) not null,
			title varchar(255) not null,
			created_day date not null,
			image varchar(255) not null
		);

		create table products
		(
			product_id int auto_increment primary key,
			name varchar(255) not null,
			description blob not null,
			created_day date not null,
			price float not null,
			image varchar(255) not null,
			quantity int(10) not null,
			category_id int,
			foreign key(category_id) references categories(category_id)
		);

		create table carts
		(
			cart_id int auto_increment primary key,
			image varchar(255) not null,
			name varchar(255) not null,
			product_count int ,
			price decimal(10,2) not null,
			user_id int,
			product_id int,
			foreign key(product_id) references products(product_id),
			foreign key(user_id) references users(user_id)
		);
		
		create table invoices 
		(
			invoice_id int auto_increment primary key,
			fullname varchar(100) not null,
			phonenumber varchar(20) not null,
			address varchar(255) not null,
			payment_status enum('online', 'offline'),
			created_day date not null,
			total_money decimal(10,2) not null,
			user_id int,
			foreign key(user_id) references users(user_id)
		);

		create table invoice_details (
			detail_id int auto_increment primary key,
			invoice_id int,
			product_id int,
			quantity int not null,
			total_money decimal(10,2) not null,
			foreign key(invoice_id) references invoices(invoice_id),
			foreign key(product_id) references products(product_id)
		);
		        
		create table comment_product
        (
			cmt_id int auto_increment primary key,
            content blob not null,
            create_day date not null,
            user_id int,
			product_id int,
			foreign key(product_id) references products(product_id),
			foreign key(user_id) references users(user_id)
        );
		
		alter table invoices 
		add COLUMN order_status enum('pending', 'confirmed') default 'pending' not null;

		ALTER TABLE invoices 
		MODIFY COLUMN order_status ENUM('pending', 'confirmed', 'cancelled') DEFAULT 'pending' NOT NULL;

		ALTER TABLE invoice_details ADD COLUMN cancel_reason TEXT;

		ALTER TABLE invoices ADD COLUMN cancel_reason VARCHAR(255) NULL;

		ALTER DATABASE petshop CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
		ALTER TABLE carts CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
		ALTER TABLE categories CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
		ALTER TABLE invoice_details CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
		ALTER TABLE invoices CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
		ALTER TABLE products CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
		ALTER TABLE users CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
		
		select * from users;
		select * from categories;
		select * from products;
		select * from carts;
		select * from invoices;
		select * from invoice_details;
		
		insert into users (fullname, username, password, email, phonenumber, gender, birthday, role) values 
	(
		'My Admin', 'admin', '123456', 'administrators@gmail.com', '0966418674', 'male','2001-07-06', 'admin'
	),
	(
		'Người dùng', 'user', '123', 'nguoidung9849@gmail.com', '0634885178', 'male','2003-07-06', 'user'
	);
		