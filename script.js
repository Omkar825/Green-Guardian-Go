// Change the API base URL to point to your local XAMPP server
const API_BASE_URL = "http://10.2.2.96/Green-Guardian-Go";


// Signup Form Submission
document.getElementById('signupForm')?.addEventListener('submit', async function(e) {
    e.preventDefault();
    const formData = new FormData(this);

    const response = await fetch(`${API_BASE_URL}/signup.php`, {
        method: 'POST',
        body: formData
    });

    const result = await response.text();
    alert(result);
    if (result.includes('successful')) window.location.href = 'index.html';
});

// Login Form Submission
document.getElementById('loginForm')?.addEventListener('submit', async function(e) {
    e.preventDefault();
    const formData = new FormData(this);

    const response = await fetch(`${API_BASE_URL}/login.php`, {
        method: 'POST',
        body: formData
    });

    const result = await response.text();
    alert(result);
    if (result.includes('successful')) {
        localStorage.setItem('userEmail', formData.get('email'));
        window.location.href = 'dashboard.html';  // Redirect after login
    }
});
