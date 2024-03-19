function previousPage() {
    //If the user has arrived to the Account page for example from the home page, he will be redirected back
    //In the scenario where the user has accessed the Account page directly, the history will be empty,
    //therefore he will be rediredcted to the home page automatically
    if (window.history.length > 1) {
        window.history.back();
    } else {
        // If there is no previous page, redirect to the homepage
        window.location.href = 'home.php'; // Replace 'index.html' with your homepage URL
    }
}

function redirectPage() {
    window.location.href = 'login.php'
}

function returnHome() {
    window.location.href = 'home.php'
}