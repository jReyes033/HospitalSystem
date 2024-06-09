<template>
    <div>
      Logging out...
    </div>
  </template>
  
  <script>
  export default {
    name: 'LogoutView',
    mounted() {
      // Clear token and userType from local storage
      localStorage.removeItem('token');
      localStorage.removeItem('user');
      
      // Redirect to login page
      this.$router.push('/login');
    }
  }
  </script>
  
  <style>
  /* Add any necessary styles here */
  </style>
  