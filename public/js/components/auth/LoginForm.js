export default {
    template: `
        <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <h2>Login</h2>
                    <form @submit.prevent="submitLogin">
                        <div class="form-group">
                            <label>Username:</label>
                            <input type="text" v-model="name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Password:</label>
                            <input type="password" v-model="password" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary mt-3">Login</button>
                    </form>
                </div>
            </div>
        </div>
    `,
    data() {
        return {
            email: '',
            password: '',
            error: null,
        };
    },
    methods: {
        async submitLogin() {
            try {
                const response = await fetch('/login', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        name: this.name,
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
                this.error = 'An error occurred while logging in.';
            }
        }
    }
};
