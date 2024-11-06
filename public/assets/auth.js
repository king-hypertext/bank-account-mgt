(() => {
    const loader = `<span class="fa fa-spinner fa-spin me-2"></span>`;
    const alertError = document.getElementById('alert');
    alertError.style.display = 'none';
    document.getElementById('login').addEventListener('submit', (e) => {
        e.preventDefault();
        // alert('login button clicked');
        const email = e.currentTarget[0].value;
        const phone_number = e.currentTarget[1].value;
        const _token = e.currentTarget[2].value;
        const submit = e.submitter;
        submit.innerHTML = loader + 'authenticating...'
        axios.post('login', {
            email,
            phone_number,
            _token
        }).then((response) => {
            submit.innerText = 'secure login';
            console.log(response.data);
            // alert('Login successful!');
            // Handle successful login (e.g., redirect to dashboard)
        }).catch((error) => {
            submit.innerText = 'secure login';
            if (error.response.status === 422) {
                const response = error.response.data.errors;
                console.error(error.response.data);
                let errors = '';
                Object.keys(response).map(key => {
                    console.log(key);

                    errors += `<li>${response[key][0]}</li>`
                });
                alertError.style.display = 'block';
                alertError.innerHTML = errors;
                console.log(errors);
            } else {
                alertError.innerText = `${error.message}`;
            }

            // alert('Invalid credentials!');
            // Handle login error
        });

    });
})();