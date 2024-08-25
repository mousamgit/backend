// RegistrationForm component
export default {
    template: `
        <div>
            <h2>Register</h2>
            <form @submit.prevent="submitRegistration">
                <div>
                    <label>Name:</label>
                    <input type="text" v-model="name" required>
                </div>
                <div>
                    <label>Email:</label>
                    <input type="email" v-model="email" required>
                </div>
                <div>
                    <label>Password:</label>
                    <input type="password" v-model="password" required>
                </div>
                <button type="submit">Register</button>
            </form>
        </div>
    `,
    data() {
        return {
            name: '',
            email: '',
            password: ''
        };
    },
    methods: {
        submitRegistration() {
            console.log('Registration submitted with', this.name, this.email, this.password);
        }
    }
};
