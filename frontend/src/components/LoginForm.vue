<template>
  <div class="login-container">
    <div class="login-form">
      <h1 class="login-heading">Login</h1>
      <form @submit.prevent="login">
        <div class="form-group">
          <label for="email" class="form-label">Email:</label>
          <input type="email" v-model="email" id="email" class="form-control" required>
        </div>
        <div class="form-group">
          <label for="password" class="form-label">Password:</label>
          <input type="password" v-model="password" id="password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary btn-block">Login</button>
      </form>
      <router-link to="/register" class="register-link">
        <span>Don't have an account? <span class="register-link-highlight">Register Here</span></span>
      </router-link>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import Swal from 'sweetalert2';

export default {
  data() {
    return {
      email: '',
      password: '',
      error: ''
    };
  },
  methods: {
    async login() {
      try {
        const response = await axios.post('http://127.0.0.1:8000/api/login', {
          email: this.email,
          password: this.password
        });
        const token = response.data.token;
        const user = response.data.user;
        localStorage.setItem('token', token);
        localStorage.setItem('user', JSON.stringify(user));
        this.$router.push('/dashboard'); // Redirect to dashboard or another page
        Swal.fire({
          icon: 'success',
          title: 'Success!',
          text: 'You have successfully logged in.',
          confirmButtonText: 'OK'
        });
      } catch (err) {
        Swal.fire({
          icon: 'error',
          title: 'Login Failed',
          text: 'Invalid credentials. Please check your email and password and try again.',
          confirmButtonText: 'OK'
        });
      }
    }
  }
};
</script>

<style>
.login-container {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
}

.login-form {
  max-width: 400px;
  width: 100%;
  padding: 40px;
  border-radius: 10px;
  background: linear-gradient(145deg, #ffffff, #e0e0e0);
  box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.1);
}

.login-heading {
  margin-bottom: 30px;
  font-size: 28px;
  text-align: center;
  color: #333;
}

.form-group {
  margin-bottom: 20px;
}

.form-label {
  display: block;
  font-weight: bold;
  margin-bottom: 5px;
  color: #444;
}

.form-control {
  width: 100%;
  padding: 15px;
  font-size: 16px;
  border: 1px solid #ccc;
  border-radius: 6px;
  background-color: #f8f8f8;
}

.btn-primary {
  background-color: #007bff;
  color: #fff;
  border: none;
  border-radius: 6px;
  padding: 15px;
  font-size: 16px;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.btn-primary:hover {
  background-color: #0056b3;
}

.register-link {
  display: block;
  text-align: center;
  margin-top: 20px;
  text-decoration: none;
  color: #007bff;
  font-weight: bold;
}

.register-link-highlight {
  color: #0056b3;
}
</style>
