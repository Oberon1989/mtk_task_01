<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Task_01</title>
    <script src="{{ asset('script.js') }}"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">

</head>
<body>

<form id="find_users" action="/filtered-users" method="GET">
    <input type="search" name="query" id="query" placeholder="Enter part of a name" required>
    <input type="submit" value="Search" onclick="getFilteredUsers()">
</form>

<div id="results">
    <!-- Здесь будут отображены результаты поиска -->
</div>

<script>
    // Отправка формы асинхронно
    document.getElementById('find_users').addEventListener('submit', function(event) {
        event.preventDefault();


        let query = document.getElementById('query').value;


        fetch(`/filtered-users?part_name=${query}`, {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
            .then(response => response.text())
            .then(html => {

                document.getElementById('results').innerHTML = html;
            })
            .catch(error => console.log('Error:', error));
    });
</script>

</body>
</html>

