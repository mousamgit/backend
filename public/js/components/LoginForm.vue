<template>
    <div>
        <h2>Login</h2>
        <form @submit.prevent="submitLogin">
            <div>
                <label>Email:</label>
                <input type="email" v-model="email" required>
            </div>
            <div>
                <label>Password:</label>
                <input type="password" v-model="password" required>
            </div>
            <button type="submit">Login</button>
        </form>
    </div>
</template>

<script>
export default {
    data() {
        return {
            email: '',
            password: ''
        };
    },
    methods: {
        submitLogin() {
            // Your login logic here
        }
    }
};
</script>

<style scoped>
/* Your styles here */
</style>
