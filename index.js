const express = require('express');
const mysql = require('mysql');
const passport = require('passport');
const session = require('express-session');
const LocalStrategy = require('passport-local').Strategy;

const app = express();
const port = 8000;

// Middleware
app.use(express.json());
app.use(express.urlencoded({ extended: true }));
app.use(session({
    secret: 'your-secret-key',
    resave: false,
    saveUninitialized: false
}));

// Passport middleware
app.use(passport.initialize());
app.use(passport.session());

// MySQL connection
const connection = mysql.createConnection({
    host: 'localhost',
    user: 'root',
    password: '',
    database: 'shoplite'
});

// Passport Local Strategy
passport.use(new LocalStrategy(
    function(username, password, done) {
        connection.query('SELECT * FROM users WHERE username = ?', [username], function(err, rows) {
            if (err) return done(err);
            if (!rows.length) {
                return done(null, false, { message: 'Incorrect username.' });
            }
            const user = rows[0];
            if (password !== user.password) { // Trong thực tế nên dùng bcrypt để so sánh
                return done(null, false, { message: 'Incorrect password.' });
            }
            return done(null, user);
        });
    }
));

passport.serializeUser((user, done) => {
    done(null, user.id);
});

passport.deserializeUser((id, done) => {
    connection.query('SELECT * FROM users WHERE id = ?', [id], function(err, rows) {
        done(err, rows[0]);
    });
});

// Middleware kiểm tra authentication
function isAuthenticated(req, res, next) {
    if (req.isAuthenticated()) {
        return next();
    }
    res.status(401).json({
        status: "error",
        message: "Unauthorized"
    });
}

// Route cho đường dẫn gốc
app.get('/', (req, res) => {
    res.json({
        message: "Welcome to API"
    });
});

// API endpoint để lấy dữ liệu balo
app.get('/api/v1/balo', (req, res) => {
    connection.query('SELECT * FROM products', (error, results) => {
        if (error) {
            return res.status(500).json({
                status: "error",
                message: error
            });
        }
        res.json({
            status: "success",
            data: results
        });
    });
});

// Xử lý lỗi 404 cho các route không tồn tại
app.use((req, res) => {
    res.status(404).json({
        status: "error",
        message: "Route not found"
    });
});

app.listen(port, () => {
    console.log(`Server đang chạy tại http://localhost:8000`);
}); 