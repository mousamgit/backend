export default {
    template: `
   
    <div class="form-body without-side">
         <div class="website-logo">
            <a href="">
                <div class="logo">
                    <img class="logo-size" src="/auth/logo-light.svg" alt="">
                </div>
            </a>
        </div>
        <div class="iofrm-layout">
             <div class="img-holder">
                <div class="bg"></div>
                <div class="info-holder">
                    <img src="/auth/graphic.svg" alt="">
                </div>
            </div>
             
            <div class="form-holder">
                <div class="form-content">
                    <div class="form-items">
                        <h3>Login to account</h3>
                        <p>Enter Username and Password To Login.</p>
                        <form @submit.prevent="submitLogin" >
                            <input class="form-control" type="text" v-model="name" placeholder="Username" required>
                            <input class="form-control" type="password" v-model="password" placeholder="Password" required>
                            <div class="form-button">
                                <button id="submit" type="submit" class="ibtn">Login</button> <a href="/forgot-password">Forget password?</a>
                            </div>
                        </form>
                        <div class="other-links social-with-title">
                            <div class="text">Or login with</div>
                            <a href="#"><i class="fab fa-facebook-f"></i>Facebook</a><a href="#">
                            <i class="fab fa-google"></i>Google</a><a href="#">
                            <i class="fab fa-linkedin-in"></i>Linkedin</a>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
  
    `,
    data() {
        return {
            name: '',
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
