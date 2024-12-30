function toggleFields() {
    var role = document.getElementById('role').value;
    var memberFields = document.getElementById('memberFields');
    if (role === 'member') {
        memberFields.style.display = 'block';
    } else {
        memberFields.style.display = 'none';
    }
}

function validateRegisterForm() {
    var name = document.getElementById('name').value;
    var contact = document.getElementById('contact').value;
    var membershipId = document.getElementById('membership_id').value;
    var password = document.getElementById('password').value;
    var confirmPassword = document.getElementById('confirm_password').value;
    var email=document.getElementById('email').value;
    var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    if (name.length < 3) {
        return ('Name must be at least 3 characters long.\n');
    }
    if (role === 'member') {
        if (contact.length < 8) {
            return ('Contact must be at least 8 characters long.\n');
        }
        else if (membershipId.length < 1) {
            return ('Membership ID cannot be empty.\n');
        }
    }
    else if (password.length < 6) {
        return ('Password must be at least 6 characters long.\n');
    }
    else if (password !== confirmPassword) {
        return ('Passwords do not match.\n');
    }

    else if (!emailRegex.test(email)) {
        return ('Invalid email format.\n');
    }

    return null;
}

function validateLoginForm() {
   
    var password = document.getElementById('password').value;
    var email=document.getElementById('email').value;
    var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    if (password.length < 6) {
        return ('Password must be at least 6 characters long.\n');
    }

    else if (!emailRegex.test(email)) {
        return ('Invalid email format.\n');
    }

    return null;

}