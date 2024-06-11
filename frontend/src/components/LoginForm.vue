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
      <div v-if="error" class="error">{{ error }}</div>
      <router-link to="/register" class="register-link">Register Here</router-link>
    </div>
  </div>
</template>


<script>
import axios from 'axios';

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
      } catch (err) {
        this.error = 'Login failed. Please check your credentials and try again.';
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
  padding: 20px;
  border: 1px solid #ccc;
  border-radius: 8px;
  background-color: #fff;
}

.login-heading {
  margin-bottom: 20px;
  font-size: 24px;
  text-align: center;
}

.form-group {
  margin-bottom: 20px;
}

.form-label {
  display: block;
  font-weight: bold;
  margin-bottom: 5px;
}

.form-control {
  width: 100%;
  padding: 10px;
  font-size: 16px;
  border: 1px solid #ccc;
  border-radius: 4px;
}

.btn-primary {
  background-color: #007bff;
  color: #fff;
  border: none;
  border-radius: 4px;
  padding: 10px;
  font-size: 16px;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.btn-primary:hover {
  background-color: #0056b3;
}

.error {
  color: red;
  margin-top: 10px;
  text-align: center;
}

.register-link {
  display: block;
  text-align: center;
  margin-top: 20px;
  text-decoration: none;
  color: #007bff;
  font-weight: bold;
}
</style>