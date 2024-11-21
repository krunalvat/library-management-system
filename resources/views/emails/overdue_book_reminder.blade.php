<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Overdue Book Reminder</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }
        .email-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: 0 auto;
        }
        h1 {
            color: #333;
        }
        .book-details {
            background-color: #f9f9f9;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .book-title {
            font-weight: bold;
            font-size: 18px;
        }
        .footer {
            text-align: center;
            font-size: 14px;
            color: #888;
            margin-top: 30px;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <h1>Reminder Book Overdue</h1>

        <div class="book-details">
            <p><span class="book-title">Book Title:</span> {{ $book->title }}</p>
            <p><span class="book-title">Borrower Name:</span> {{ $borrower->name }}</p>
            <p><span class="book-title">Due Date:</span> {{ $borrow->due_date }}</p>
        </div>
        <p>This is a reminder that the book you borrowed is overdue. Kindly return it as soon as possible to avoid any additional penalties.</p>
    </div>
</body>
</html>
