<template>
  <div class="container">
    <div class="row justify-content-center mt-5">
      <div class="col-md-6">
        <div class="registration-container">
          <h1 class="registration-heading">Registration Form</h1>
          <form @submit.prevent="register" class="registration-form">
            <div class="form-group">
              <label for="name" class="form-label">Name:</label>
              <input type="text" v-model="name" id="name" class="form-control" required>
            </div>
            <div class="form-group">
              <label for="email" class="form-label">Email:</label>
              <input type="text" v-model="email" id="email" class="form-control" required>
            </div>
            <div class="form-group">
              <label for="password" class="form-label">Password:</label>
              <input type="password" v-model="password" id="password" class="form-control" required>
            </div>
            <div class="form-group">
              <label for="userType" class="form-label">User Type:</label>
              <select id="userType" v-model="userType" class="form-select" required>
                <option value="admin">Administrator</option>
                <option value="doctor">Doctor</option>
                <option value="patient">Patient</option>
              </select>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Register</button>
          </form>
          <div v-if="error" class="error">{{ error }}</div>
          <router-link to="/login" class="login-link">
            <span>Already have an account? <span class="login-link-highlight">Login</span></span>
          </router-link>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import Swal from 'sweetalert2';

export default {
  data() {
    return {
      name: '',
      email: '',
      password: '',
      userType: '',
      error: ''
    };
  },
  methods: {
    async register() {
      try {
        const response = await axios.post('http://127.0.0.1:8000/api/register', {
          name: this.name,
          email: this.email,
          password: this.password,
          userType: this.userType
        });
        console.log(response.data); // Log the response for debugging

        Swal.fire({
          icon: 'success',
          title: 'Registration Successful',
          text: 'You have successfully registered.',
          confirmButtonText: 'OK'
        });

        this.name = '';
        this.email = '';
        this.password = '';
        this.userType = '';
      } catch (err) {
        if (err.response) {
          this.error = `Error: ${err.response.data.message}`;
          console.error(err.response.data);
        } else if (err.request) {
          this.error = 'No response from server. Please try again later.';
          console.error(err.request);
        } else {
          this.error = 'Request error. Please check your input and try again.';
          console.error('Error', err.message);
        }
      }
    }
  }
};
</script>

<style>
.error {
  color: red;
}

.registration-container {
  padding: 40px;
  border-radius: 10px;
  background: linear-gradient(145deg, #ffffff, #e0e0e0);
  box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.1);
}

.registration-heading {
  margin-bottom: 30px;
  font-size: 28px;
  text-align: center;
  color: #333;
}

.form-group {
  margin-bottom: 20px;
}

.form-label {
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

.form-select {
  width: 100%;
  padding: 15px;
  font-size: 16px;
  border: 1px solid #ccc;
  border-radius: 6px;
  background-color: #f8f8f8;
}

.btn-primary {
  padding: 15px;
  font-size: 16px;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.btn-primary:hover {
  background-color: #0056b3;
}

.error {
  margin-top: 20px;
  text-align: center;
}

.login-link {
  display: block;
  text-align: center;
  margin-top: 20px;
  text-decoration: none;
  color: #007bff;
  font-weight: bold;
}

.login-link-highlight {
  color: #0056b3;
}
</style>
