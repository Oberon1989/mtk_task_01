function getFilteredUsers()
{

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
}

function saveUser(btn) {



    const button = btn;
    button.disabled = true;


    const buttonName = button.getAttribute('name');
    console.log(buttonName);

    fetch(`/save-user`, {
        method: 'POST',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ username: buttonName })
    })
        .then(response => response.json()) // Ожидаем JSON ответ
        .then(data => {
            if (data.success) {

                button.remove();
            } else {

                button.disabled = false;
            }
        })
        .catch(error => {
            console.log('Error:', error);

            button.disabled = false;
        });
}

