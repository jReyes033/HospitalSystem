<template>
  <div class="registration-container">
    <h1>Registration Form</h1>
    <form @submit.prevent="register" class="registration-form">
      <div class="form-group">
        <label for="name">Name:</label>
        <input type="text" v-model="name" id="name" required>
      </div>
      <div class="form-group">
        <label for="email">Email:</label>
        <input type="text" v-model="email" id="email" required>
      </div>
      <div class="form-group">
        <label for="password">Password:</label>
        <input type="password" v-model="password" id="password" required>
      </div>
      <div class="form-group">
        <label for="userType">User Type:</label>
        <select id="userType" v-model="userType" required>
          <option value="admin">I am an Administrator</option>
          <option value="doctor">I am a Doctor</option>
          <option value="patient">I am a Patient</option>
        </select>
      </div>
      <button type="submit">Register</button>
    </form>
    <div v-if="error" class="error">{{ error }}</div>
    <router-link to="/login">Login</router-link>
  </div>
</template>


<script>
import axios from 'axios';

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
  max-width: 400px;
  margin: 0 auto;
  padding: 20px;
  border: 1px solid #ccc;
  border-radius: 8px;
  background-color: #f9f9f9;
}

.registration-form {
  display: grid;
  grid-template-columns: 1fr 2fr;
  grid-gap: 10px;
}

.form-group {
  display: contents;
}

button {
  grid-column: span 2;
  padding: 10px 15px;
  background-color: #007bff;
  color: white;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

button:hover {
  background-color: #0056b3;
}

.error {
  color: red;
  margin-top: 10px;
  text-align: center;
}
</style>