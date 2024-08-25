export default {
    template: `
        <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <h2>Register</h2>
                    <form @submit.prevent="submitRegistration">
                        <div class="form-group">
                            <label>Name:</label>
                            <input type="text" v-model="name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Email:</label>
                            <input type="email" v-model="email" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Password:</label>
                            <input type="password" v-model="password" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary mt-3">Register</button>
                    </form>
                </div>
            </div>
        </div>
    `,
    data() {
        return {
            name: '',
            email: '',
            password: '',
            error: null,
        };
    },
    methods: {
        async submitRegistration() {
            try {
                const response = await fetch('/register', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        name: this.name,
                        email: this.email,
                        password: this.password,
                    })
                });

                if (response.ok) {
                    window.location.href = '/dashboard';
                } else {
                    const errorData = await response.json();
                    this.error = errorData.message;
                }
            } catch (error) {
                console.error(error);
                this.error = 'An error occurred while registering.';
            }
        }
    }
};
